<?php

namespace App\Http\Controllers;

use App\Models\DealerProduct;
use App\Models\Deliverynote;
use App\Models\Inverter;
use App\Models\InverterInventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeliveryNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('checkrole');
    }
    public function index(){

        if(Auth::user()->role_id==4){
            return redirect('/dashboard');
        }
       $data['deliveryNotes'] = Deliverynote::select('deliverynotes.id as recordid','deliverynotes.quantity as qty',
       'deliverynotes.notes as notes','inverters.inverter_name as invertername','inverters.modal_number as modal',
       'users.name as username','users.phoneno_1 as userphone','deliverynotes.created_at as createdat')
           ->join('inverters', 'deliverynotes.inverter_id', '=', 'inverters.id')
           ->join('users', 'deliverynotes.dealer_id', '=', 'users.id')
           ->get();


        return view('deliverynote.list-deliverynote', $data);
    }

    public function add(){
        if(Auth::user()->role_id==4){
            return redirect('/dashboard');
        }
        $data['dealers'] = User::where('role_id',3)->get();
        $data['inverters'] = Inverter::where('total_quantity','>',0)->get();
        return view('deliverynote.add-deliverynote',$data);

    }
    public function detailDealer($id){
        $data['user'] = User::find($id);
        return view('deliverynote.user-detail',$data);
    }
    public function detailInverter($id){
        $data['inverter'] = Inverter::find($id);
        return view('deliverynote.inverter-detail',$data);

    }
    public function save(Request $request)
    {
        if ($request->all()) {
            $this->validate($request, [
                'dealer_id'    =>  'required|not_in:0',
                'inverter_id'  => 'required|not_in:0',
                'quantity'     => 'required',
            ]);
            // check entered quantity is less than available quantity
            $inverter = Inverter::find($request->inverter_id);
            if($request->quantity>$inverter->total_quantity){
                return back()->withErrors(['quantity' => 'Entered Quantity exceeds with current stock']);

            }
            $insertData=[];

            DB::beginTransaction();
            try {
                #------------------- insert in database--------------------------------#
                $deliverynote = Deliverynote::create(
                    [
                        'dealer_id'     => $request->dealer_id,
                        'inverter_id'   => $request->inverter_id,
                        'quantity'      => $request->quantity,
                        'notes'         => $request->notes,
                        'user_id'        => Auth::user()->id,
                    ]
                );
                if($deliverynote->id){
                    // get inverters from inverter_product_table based on quantity entered
                    $inverter_stock = InverterInventory::select('serial_number','id')->where('is_assigned',0)
                        ->limit($request->quantity)
                        ->get();
                    foreach($inverter_stock as $row){
                        $serialNo[] = $row->serial_number;
                        $ids[] = $row->id;
                    }
                    if(count($serialNo)>0){
                        for($a=0;$a<count($serialNo);$a++){
                            $insertData[] = [
                                'dealer_id' =>      $request->dealer_id,
                                'inverter_id' =>    $request->inverter_id,
                                'deliverynote_id'=> $deliverynote->id,
                                'serial_number' =>  $serialNo[$a],
                                'created_at'    =>  date('Y-m-d H:i')
                            ];
                        }
                        DealerProduct::insert($insertData);
                    }
                    // update is_assigned column in inveeters_inventory table

                    $is_assigned = 1;
                    DB::table('inverter_inventories')
                        ->whereIn('id', $ids)
                        ->update(['is_assigned' => $is_assigned]);
                    // deduct inverter stock
                    $oldDetail = Inverter::select('total_quantity')->where('id',$request->inverter_id)->first();
                    $newTotalStock = ($oldDetail->total_quantity)-($request->quantity);
                    $newSoldStock = ($oldDetail->sold_quantity)+($request->quantity);

                    $affected= DB::table('inverters')
                        ->where(['id'=>$request->inverter_id])
                        ->update(['total_quantity' =>$newTotalStock,'sold_quantity' =>$newSoldStock]);
                }
                DB::commit();
                return redirect('/deliverynote-list')->with('status', 'Delivery note added successfully');

            }
        catch (\Exception $e) {
          DB::rollback();
          // Redirect to users page with an error message
          return redirect('/deliverynote-list')->with('status', $e);
    }

        }
    }

    public function show($id){
        if(Auth::user()->role_id==4){
            return redirect('/dashboard');
        }
        $data['deliveryNote'] = Deliverynote::select('deliverynotes.id as recordid','deliverynotes.quantity as qty',
            'deliverynotes.notes as notes','inverters.inverter_name as invertername','inverters.modal_number as modal',
            'users.name as username','users.phoneno_1 as userphone','deliverynotes.created_at as createdat',
            'deliverynotes.notes as notes','users.email as useremail')
            ->join('inverters', 'deliverynotes.inverter_id', '=', 'inverters.id')
            ->join('users', 'deliverynotes.dealer_id', '=', 'users.id')
            ->where('deliverynotes.id',$id)
            ->first();
        if($data['deliveryNote']){
            return view('deliverynote.view-deliverynote',$data);
        }
        return redirect('/deliverynote-list')->with('status', 'No record found');





    }

}
