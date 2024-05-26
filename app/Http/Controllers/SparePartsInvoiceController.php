<?php

namespace App\Http\Controllers;

use App\Models\ScSparePartQty;
use App\Models\SparePart;
use App\Models\SparePartInvoice;
use App\Models\SparePartInvoiceItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;

class SparePartsInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('checkrole');
    }
   public function index(){
       if(Auth::user()->role_id==3){
           return redirect('/dashboard');
       }
       if(Auth::user()->role_id==4){
           $data['invoices'] = SparePartInvoice::select('spare_part_invoices.uuid as uuid','spare_part_invoices.foc as foc',
               'spare_part_invoices.total_amount as totalamount','spare_part_invoices.created_at as invoicedate','spare_part_invoices.status as status',
               'users.name as servicecentername','users.phoneno_1 as phone')
               ->join('users', 'spare_part_invoices.service_center_id', '=', 'users.id')
               ->where('spare_part_invoices.service_center_id','=',Auth::user()->id)
               ->get();
       }
       else{
           $data['invoices'] = SparePartInvoice::select('spare_part_invoices.uuid as uuid','spare_part_invoices.foc as foc',
               'spare_part_invoices.total_amount as totalamount','spare_part_invoices.created_at as invoicedate','spare_part_invoices.status as status',
               'users.name as servicecentername','users.phoneno_1 as phone')
               ->join('users', 'spare_part_invoices.service_center_id', '=', 'users.id')
               ->get();

       }
       $data['role'] = Auth::user()->role_id;

       return view('invoice.list-invoice',$data);

   }

   public function add(){
       if(Auth::user()->role_id==3 || Auth::user()->role_id==4){
           return redirect('/dashboard');
       }
       $data['serviceCenterUser'] = User::select('*')
                            ->where([
                                ['role_id','=',4],
                                ['status','=','active']
                            ])
                            ->get();
       $data['spareParts'] = SparePart::all();
       return view('invoice.add-invoice',$data);
   }
   public function detail($id){
       $data['user'] = User::find($id);
       return view('invoice.user-detail',$data);


   }
   public function partDetail(Request $request){
       $partId = $request->input('partId');
       $partDetail = SparePart::find($partId) ;// Assuming you have a Tax model that relates to parts

       if ($partDetail) {
           return response()->json([
               'netPrice'     =>     $partDetail->sale_price,
               'currentStock' =>     $partDetail->total_quantity,
           ]);
       } else {
           return response()->json(['taxValue' => 'No tax info available'], 404);
       }

   }

   public function save(Request $request){
       $this->validate($request, [

           'foc'             => 'required|not_in:0',
           'service_user'    => 'required|not_in:0',

       ]);
       //dd(Auth::user()->role_id);

       DB::beginTransaction();
       try {
           // if FOC=yes and  user who create invoice is super admin sent status complete
           if($request->foc=='1'){

               if(Auth::user()->role_id==1){
                   $status='completed';
               }
               // if FOC=yes and  user who create invoice is  admin sent status pending
               elseif(Auth::user()->role_id==2){
                   $status='pending';
               }
               // if FOC=yes and  user who create invoice is  service center sent status pending
               elseif(Auth::user()->role_id==3){
                   $status='pending';
               }


           }
           else{
               $status='completed';
           }
           //dd($status);


           // insert data in main invoice table
           $invoice = SparePartInvoice::create(
               [
                   'foc'                 => $request->foc,
                   'service_center_id'   => $request->service_user,
                   'total_amount'        => $request->total,
                   'discount'            => $request->discount,
                   'tax_adjustment'      => 0.00,
                   'status'              => $status,
                   'uuid'                => (string) Str::uuid(),
                   'user_id'             => Auth::user()->id,
               ]
           );
           $invoiceId = $invoice->id;
           #------------------ insert in sparepart model database------------------#
           if($request->sparepart){
               for($i=0;$i<count($request->sparepart);$i++){
                       $selectedItems[] = [
                           'invoice_id'         => $invoiceId,
                           'sparepart_id'       => $request->sparepart[$i],
                           'quantity'           => $request->qty[$i],
                           'sale_price'         => $request->sale_price[$i],
                           'service_center_id'  => $request->service_user,
                           'item_tax'           => $request->item_tax[$i],
                           'item_discount'      => $request->item_discount[$i],
                           'item_total'         => $request->item_total[$i],
                       ];
               }
               if(!empty($selectedItems)){
                   SparePartInvoiceItem::insert($selectedItems);
               }
               // deduct from current stock
               for($j=0;$j<count($request->sparepart);$j++){
                   $currentStock = SparePart::find($request->sparepart[$j]);
                   $deductedCurrentQuantity = ($currentStock->total_quantity)-($request->qty[$j]);
                   $addedSoldQuantity = ($currentStock->sold_quantity)+($request->qty[$j]);
                   $affected= DB::table('spare_parts')
                       ->where(['id'=>$request->sparepart[$j]])
                       ->update(['total_quantity' =>$deductedCurrentQuantity,'sold_quantity' =>$addedSoldQuantity]);
               }
               //insert or update in sc_spare_part_qties table
               for($k=0;$k<count($request->sparepart);$k++){
                   $checkexistingSp= ScSparePartQty::where([
                       ['sparepart_id','=',$request->sparepart[$k]],
                       ['service_center_id','=',$request->service_user]
                   ])->first();
                   if(!$checkexistingSp){
                       DB::table('sc_spare_part_qties')->insert([
                           'sparepart_id'      => $request->sparepart[$k],
                           'service_center_id' => $request->service_user,
                           'quantity'          => $request->qty[$k],
                       ]);
                   }
                   else{
                       $actualQty = $checkexistingSp->quantity;
                       $newQty = ($checkexistingSp->quantity)+($request->qty[$k]);
                       $affected= DB::table('sc_spare_part_qties')
                           ->where(['id'=>$checkexistingSp->id])
                           ->update(['quantity' =>$newQty]);
                   }
               }
           }
           DB::commit();
           return redirect('/invoice-list')->with('status', 'Invoice created successfully');

       }
       catch (\Exception $e) {
           DB::rollback();
           // Redirect to users page with an error message
           return redirect('/invoice-list')->with('status', $e);
       }
   }

    public function show($id){
        if(Auth::user()->role_id==3){
            return redirect('/dashboard');
        }
        $invoiceDetail = SparePartInvoice::select('spare_part_invoices.foc as foc','spare_part_invoices.total_amount as total',
        'spare_part_invoices.discount as discount','spare_part_invoices.status','users.name as name','users.email as email',
        'users.phoneno_1 as phone','users.shipping_address','spare_part_invoices.id as recordid')
            ->join('users', 'spare_part_invoices.service_center_id', '=', 'users.id')
             ->where('spare_part_invoices.uuid',$id)
            ->first();
        $invoiceItems = SparePartInvoiceItem::select('spare_part_invoice_items.quantity as itemqty','spare_part_invoice_items.item_tax as itemtax',
        'spare_part_invoice_items.item_discount as itemdiscount','spare_part_invoice_items.item_total as itemtotal','spare_parts.name as sparepart','spare_part_invoice_items.sale_price as itemunitprice')
            ->join('spare_parts', 'spare_part_invoice_items.sparepart_id', '=', 'spare_parts.id')
            ->where('invoice_id',$invoiceDetail->recordid)->get();
        //dd($invoiceItems);
        $userRole = Auth::user()->role_id;
        $invoiceId = $id;


        return view('invoice.view-invoice',compact('invoiceDetail','invoiceItems','userRole','invoiceId'));

    }
    public function update($id){
        if(Auth::user()->role_id==3 || Auth::user()->role_id==2 || Auth::user()->role_id==4){
            return redirect('/dashboard');
        }
        $affected= DB::table('spare_part_invoices')
            ->where(['uuid'=>$id])
            ->update(['status' =>'completed']);
        return redirect('/invoice-list')->with('status', 'Invoice approved successfully');

    }

    public function printInvoice($id){
        if(Auth::user()->role_id==3){
            return redirect('/dashboard');
        }
        $invoiceDetail = SparePartInvoice::select('spare_part_invoices.foc as foc','spare_part_invoices.total_amount as total',
            'spare_part_invoices.discount as discount','spare_part_invoices.status','users.name as name','users.email as email',
            'users.phoneno_1 as phone','users.shipping_address','spare_part_invoices.id as recordid')
            ->join('users', 'spare_part_invoices.service_center_id', '=', 'users.id')
            ->where('spare_part_invoices.uuid',$id)
            ->first();
        $invoiceItems = SparePartInvoiceItem::select('spare_part_invoice_items.quantity as itemqty','spare_part_invoice_items.item_tax as itemtax',
            'spare_part_invoice_items.item_discount as itemdiscount','spare_part_invoice_items.item_total as itemtotal','spare_parts.name as sparepart','spare_part_invoice_items.sale_price as itemunitprice')
            ->join('spare_parts', 'spare_part_invoice_items.sparepart_id', '=', 'spare_parts.id')
            ->where('invoice_id',$invoiceDetail->recordid)->get();
        //dd($invoiceItems);
        $invoiceId = $id;


        return view('invoice.print-invoice',compact('invoiceDetail','invoiceItems','invoiceId'));

    }

    public function downloadInvoice($id){
        if(Auth::user()->role_id==3){
            return redirect('/dashboard');
        }
        $data['invoiceDetail'] = SparePartInvoice::select('spare_part_invoices.foc as foc','spare_part_invoices.total_amount as total',
            'spare_part_invoices.discount as discount','spare_part_invoices.status','users.name as name','users.email as email',
            'users.phoneno_1 as phone','users.shipping_address','spare_part_invoices.id as recordid')
            ->join('users', 'spare_part_invoices.service_center_id', '=', 'users.id')
            ->where('spare_part_invoices.uuid',$id)
            ->first();
        $data['invoiceItems'] = SparePartInvoiceItem::select('spare_part_invoice_items.quantity as itemqty','spare_part_invoice_items.item_tax as itemtax',
            'spare_part_invoice_items.item_discount as itemdiscount','spare_part_invoice_items.item_total as itemtotal','spare_parts.name as sparepart','spare_part_invoice_items.sale_price as itemunitprice')
            ->join('spare_parts', 'spare_part_invoice_items.sparepart_id', '=', 'spare_parts.id')
            ->where('invoice_id',$data['invoiceDetail']->recordid)->get();
        //dd($invoiceItems);
        $data['invoiceId'] = $id;


        $pdf = PDF::loadView('invoice.download-invoice', $data);


        $rand = time().rand(10,1000);
        $filename = 'invoice_' . $rand . '.pdf';
        return $pdf->download($filename);
    }
}
