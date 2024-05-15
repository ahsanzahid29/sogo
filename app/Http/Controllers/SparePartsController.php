<?php

namespace App\Http\Controllers;

use App\Models\Inverter;
use App\Models\SparePart;
use App\Models\SparePartInvoiceItem;
use App\Models\SparePartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SparePartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('checkrole');
    }

    public function index(){
        $data['role'] = Auth::user()->role_id;
        if($data['role']==4){
            $data['sparePartsForSc']= SparePartInvoiceItem::select(DB::raw('SUM(spare_part_invoice_items.quantity) as total_quantity'),
                'spare_parts.name as partname','spare_parts.factory_code as factorycode','spare_parts.part_type as parttype',
                'spare_parts.voltage_rating as voltagerating','spare_parts.ampeare_rating as ampearrating',
            'spare_parts.sale_price as saleprice','spare_parts.base_unit as baseunit')
                ->join('spare_parts', 'spare_part_invoice_items.sparepart_id', '=', 'spare_parts.id')
                ->groupBy('spare_part_invoice_items.sparepart_id', 'spare_parts.name','spare_parts.factory_code',
                    'spare_parts.part_type','spare_parts.voltage_rating','spare_parts.ampeare_rating','spare_parts.sale_price',
                'spare_parts.base_unit')
                ->where('spare_part_invoice_items.service_center_id','=',Auth::user()->id)
                ->get();
            //dd($data['sparePartsForSc']);
            return view('spareparts.servicecenter.parts-list', $data);
        }
        $data['spareParts'] = SparePart::all();
        return view('spareparts.parts-list', $data);
    }

    public function add(){
        $data['inverters']= Inverter::get();
        return view('spareparts.parts-add',$data);
    }

    public function save(Request $request){
        if ($request->all()) {
            $this->validate($request, [
                'name' => 'required',
                'factory_code' => 'required',
                'part_type' => 'required|not_in:0',
                'voltage_rating' => 'required',
                'ampeare_rating' => 'required',
                'sale_price' => 'required',
                'base_unit' => 'required',
                'pieces' => 'required',

            ]);
            DB::beginTransaction();
            try {
                #------------------- insert in database--------------------------------#
                $sparePart = SparePart::create(
                    [
                        'name'           => $request->name,
                        'factory_code'   => $request->factory_code,
                        'part_type'      => $request->part_type,
                        'voltage_rating' => $request->voltage_rating,
                        'ampeare_rating' => $request->ampeare_rating,
                        'base_unit'      => $request->base_unit,
                        'pieces'         => $request->pieces,
                        'sale_price'     => $request->sale_price,
                        'total_quantity' => 0,
                        'sold_quantity'  => 0,
                        'user_id'        => Auth::user()->id,
                    ]
                );
                $sparePartId = $sparePart->id;
                //dd($request->inverter_modal);
                #------------------ insert in sparepart model database------------------#
                if($request->inverter_modal){
                   for($i=0;$i<count($request->inverter_modal);$i++){
                        $selectedInverters[] = [
                            'sparepart_id'       => $sparePartId,
                            'inverter_id'        => $request->inverter_modal[$i],
                            'dosage'             => $request->dosage[$i],
                        ];
                    }
                    SparePartModel::insert($selectedInverters);

                }
                DB::commit();
                return redirect('/spareparts-list')->with('status', 'Spare part added successfully');

            } catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/spareparts-list')->with('status', $e);
            }
        }
    }

    public function edit($id){

        $data['inverters']= Inverter::get();
        $data['sparePart'] = SparePart::find($id);
        $data['sparePartModel'] = SparePartModel::select('spare_part_models.id as model_id','spare_part_models.dosage as dosage',
        'inverters.modal_number as model')
            ->join('inverters', 'spare_part_models.inverter_id', '=', 'inverters.id')
            ->where('spare_part_models.sparepart_id',$id)
            ->get();
        return view('spareparts.parts-edit',$data);

    }
    public function deleteModel($id){
        $sparePartDetail = SparePartModel::find($id);
        $sparePartId = $sparePartDetail->sparepart_id;
        if($sparePartId){
            // Delete spare part model
            SparePartModel::where('id', $id)->delete();

            return redirect('/sparepart-edit/'.$sparePartId)->with('status', 'Modal deleted successfully');
        }
        else{
            return redirect('/sparepart-edit/'.$sparePartId)->with('status', 'Something went wrong');


        }
    }

    public function update(Request $request){
        if ($request->all()) {
            $this->validate($request, [
                'name' => 'required',
                'factory_code' => 'required',
                'part_type' => 'required|not_in:0',
                'voltage_rating' => 'required',
                'ampeare_rating' => 'required',
                'sale_price' => 'required',
                'base_unit' => 'required',
                'pieces' => 'required',

            ]);
            DB::beginTransaction();
            try {
                $newdata = [
                    'name'           => $request->name,
                    'factory_code'   => $request->factory_code,
                    'part_type'      => $request->part_type,
                    'voltage_rating' => $request->voltage_rating,
                    'ampeare_rating' => $request->ampeare_rating,
                    'base_unit'      => $request->base_unit,
                    'pieces'         => $request->pieces,
                    'sale_price'     => $request->sale_price,

                ];

                SparePart::where('id', $request->recordid)->update($newdata);
                #------------------ insert in sparepart model database------------------#
                if($request->inverter_modal){
                    for($i=0;$i<count($request->inverter_modal);$i++){
                        if($request->inverter_modal[$i]!=null && $request->dosage[$i]!=null){
                            $selectedInverters[] = [
                                'sparepart_id'       => $request->recordid,
                                'inverter_id'        => $request->inverter_modal[$i],
                                'dosage'             => $request->dosage[$i],
                            ];
                        }
                    }
                    if(!empty($selectedInverters)){
                        SparePartModel::insert($selectedInverters);

                    }
                }
                DB::commit();
                return redirect('/spareparts-list')->with('status', 'Spare part updated successfully');

            } catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/spareparts-list')->with('status', $e);
            }
        }

    }
}
