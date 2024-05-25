<?php

namespace App\Http\Controllers;

use App\Models\DealerProduct;
use App\Models\Inverter;
use App\Models\InverterInventory;
use App\Models\RepairSparePart;
use App\Models\RepairTicket;
use App\Models\ScSparePartQty;
use App\Models\SparePartInvoiceItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RepairTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('checkrole');
    }
    public function index(){

        $data['openTickets']   = RepairTicket::where('status', 'pending')->count();
        $data['closedTickets'] = RepairTicket::where('status', 'completed')->count();
        $data['agentsCount']   = User::where('role_id',4)->count();
        if(Auth::user()->role_id==4){
            $data['allRepairTickets'] = RepairTicket::select('repair_tickets.id as rp_id',
                'repair_tickets.ticket_number as rp_ticket','repair_tickets.serial_number as rp_sn',
                'repair_tickets.status as rp_status','repair_tickets.repair_request_date as rp_req_date',
                'inverters.inverter_name as rep_inv_name','inverters.modal_number as rep_inv_model')
                ->join('inverters', 'repair_tickets.inverter_id', '=', 'inverters.id')
                ->where('repair_tickets.service_center_id','=',Auth::user()->id)
                ->limit(3)
                ->orderBy('repair_tickets.id','DESC')
                ->get();
        }
        else{
            $data['allRepairTickets'] = RepairTicket::select('repair_tickets.id as rp_id',
                'repair_tickets.ticket_number as rp_ticket','repair_tickets.serial_number as rp_sn',
                'repair_tickets.status as rp_status','repair_tickets.repair_request_date as rp_req_date',
                'inverters.inverter_name as rep_inv_name','inverters.modal_number as rep_inv_model')
                ->join('inverters', 'repair_tickets.inverter_id', '=', 'inverters.id')
                ->limit(3)
                ->orderBy('repair_tickets.id','DESC')
                ->get();
        }
        return view('repairticket.list-repairticket', $data);
    }

    public function allTickets(){

        if(Auth::user()->role_id==4){
            $data['allRepairTickets'] = RepairTicket::select('repair_tickets.id as rp_id',
                'repair_tickets.ticket_number as rp_ticket','repair_tickets.serial_number as rp_sn',
                'repair_tickets.status as rp_status','repair_tickets.repair_request_date as rp_req_date',
                'inverters.inverter_name as rep_inv_name','inverters.modal_number as rep_inv_model')
                ->join('inverters', 'repair_tickets.inverter_id', '=', 'inverters.id')
                ->where('repair_tickets.service_center_id','=',Auth::user()->id)
                ->get();
        }
        else{
            $data['allRepairTickets'] = RepairTicket::select('repair_tickets.id as rp_id',
                'repair_tickets.ticket_number as rp_ticket','repair_tickets.serial_number as rp_sn',
                'repair_tickets.status as rp_status','repair_tickets.repair_request_date as rp_req_date',
                'inverters.inverter_name as rep_inv_name','inverters.modal_number as rep_inv_model')
                ->join('inverters', 'repair_tickets.inverter_id', '=', 'inverters.id')
                ->get();
        }

        return view('repairticket.all-repairticket',$data);

    }

    public function add(){
        if(Auth::user()->role_id==4)
        {
            return view('repairticket.add-repairticket');
        }
        return redirect('dashboard');

    }
    public function serachSn(Request $request){
        $value = $request->input('value');
        $serialNoExist = InverterInventory::where([
            ['serial_number',$value],
            ['is_assigned',1]
        ])->first();
        if(!$serialNoExist){
            $data['alertDiv']="1";   // Serial No does not exist in table

        }
        else {
            $data['alertDiv'] = "2";   // Serial No exist in table

            // check warranty exist
            $inverters = Inverter::where('id', $serialNoExist->inverter_id)->first();

            $createdDate = $inverters->created_at;
            $productWarrantyMonths = $inverters->product_warranty * 12; // Convert years to months
            $serviceWarrantyMonths = $inverters->service_warranty * 12; // Convert years to months
            $warrantyLagMonths = $inverters->warranty_lag; // Already in months

            // Total warranty period in months
            $totalWarrantyMonths = $productWarrantyMonths + $serviceWarrantyMonths + $warrantyLagMonths;

            // Convert the created_date to a Carbon instance
            $createdDate = Carbon::parse($createdDate);

            // Clone the createdDate to ensure it remains unchanged
            $expiryDate = $createdDate->copy()->addMonths($totalWarrantyMonths);

            // Check if today's date is within the range
            $isInRange = Carbon::now()->between($createdDate, $expiryDate);

            if ($isInRange) {
                $data['warantyexpire'] = "0";
            } else {
                $data['warantyexpire'] = "1";
            }

            // For debugging, let's dd() the dates
            //dd($createdDate->toDateTimeString(), $expiryDate->toDateTimeString());

            // check repair record exist previously
            $data['history'] = RepairTicket::select('repair_tickets.id as repairid', 'repair_tickets.repair_request_date as repair_date',
                'repair_tickets.status as status', 'inverters.modal_number as inverter_modal',
                'users.name as service_center_name', 'repair_tickets.fault_detail as faultdetail',
                DB::raw('GROUP_CONCAT(spare_parts.name) as sp_name'))
                ->join('inverters', 'repair_tickets.inverter_id', '=', 'inverters.id')
                ->join('users', 'repair_tickets.service_center_id', '=', 'users.id')
                ->join('repair_spare_parts', 'repair_spare_parts.repair_id', '=', 'repair_tickets.id')
                ->join('spare_parts', 'repair_spare_parts.sparepart_id', '=', 'spare_parts.id')
                ->groupBy('repair_tickets.id')
                ->where('repair_tickets.serial_number', $value)
                ->get();


        }
        $data['sparePartsForSc'] = SparePartInvoiceItem::select(DB::raw('SUM(spare_part_invoice_items.quantity) as total_quantity'),
            'spare_parts.name as partname', 'spare_part_categories.name as factorycode', 'spare_parts.part_type as parttype',
            'spare_parts.voltage_rating as voltagerating', 'spare_parts.ampeare_rating as ampearrating',
            'spare_parts.sale_price as saleprice', 'spare_parts.base_unit as baseunit', 'spare_parts.id as partid')
            ->join('spare_parts', 'spare_part_invoice_items.sparepart_id', '=', 'spare_parts.id')
            ->join('spare_part_categories', 'spare_parts.part_type', '=', 'spare_part_categories.id')
            ->groupBy('spare_part_invoice_items.sparepart_id', 'spare_parts.name', 'spare_parts.factory_code',
                'spare_parts.part_type', 'spare_parts.voltage_rating', 'spare_parts.ampeare_rating', 'spare_parts.sale_price',
                'spare_parts.base_unit')
            ->where('spare_part_invoice_items.service_center_id', '=', Auth::user()->id)
            ->get();
            $data['selectedSn'] = $value;
        return view('repairticket.history-repair',$data);

    }
    public function partDetailForSc(Request $request){
        $partId = $request->input('partId');

        $detail= ScSparePartQty::select(DB::raw('SUM(sc_spare_part_qties.quantity) as total_quantity'),
            'spare_parts.id as partid')
            ->join('spare_parts', 'sc_spare_part_qties.sparepart_id', '=', 'spare_parts.id')
            ->groupBy('spare_parts.id')
            ->where([
                ['sc_spare_part_qties.sparepart_id','=',$partId],
                ['sc_spare_part_qties.service_center_id','=',Auth::user()->id]
            ])
            ->first();
        $partStock = $detail->total_quantity;
        if ($partStock) {
            return response()->json([
                'currentStock' =>    $partStock,
            ]);
        } else {
            return response()->json(['taxValue' => 'No tax info available'], 404);
        }
    }

    public function save(Request $request){
        if ($request->all()) {
            $this->validate($request, [
                'fault_detail' => 'required',
                'fault_video' => 'required|mimes:mp4,webm',
            ]);
            $faultVideo="";

            if(!$request->sparepart){
               $status='pending';
            }
            else{
                if($request->explain_more!=null){
                    $status='pending';
                }
                else{
                    $status='completed';
                }

            }
            $randomString = Str::random(4);
            $inverterDetail = DealerProduct::where('serial_number',$request->serial_no)->first();

            DB::beginTransaction();
            try {
                // upload video first
                #----------- inverter image----------------------#
                if ($request->file('fault_video')) {
                    $video = $request->file('fault_video');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $video->getClientOriginalName();
                    $sanitizedVideoName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $video->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $faultVideo = $sanitizedVideoName . '_' . time() . '.' . $extension;
                    $video->move(public_path('files/repairvideos'), $faultVideo);
                }

                $repairTicketDetail = RepairTicket::create(
                    [
                        'ticket_number'        => $randomString,
                        'user_id'              => Auth::user()->id,
                        'inverter_id'          => $inverterDetail->inverter_id,
                        'service_center_id'    => Auth::user()->id ,
                        'dealer_id'            => $inverterDetail->dealer_id,
                        'serial_number'        => $request->serial_no,
                        'fault_detail'         => $request->fault_detail,
                        'fault_video'          => $faultVideo,
                        'status'               => $status,
                        'explain_more'         => $request->explain_more,
                        'repair_request_date'  => date('Y-m-d H:i'),
                        'created_at'           => date('Y-m-d H:i'),
                    ]
                );
                $repairTicketId = $repairTicketDetail->id;
                if($request->sparepart){
                    for($i=0;$i<count($request->sparepart);$i++){
                        $selectedParts[] = [
                            'repair_id'           => $repairTicketId,
                            'sparepart_id'        => $request->sparepart[$i],
                            'current_stock'       => $request->current_stock[$i],
                            'stock_needed'        => $request->needed_stock[$i],
                            'created_at'          => date('Y-m-d H:i')
                        ];
                    }
                    RepairSparePart::insert($selectedParts);

                    // deduct from current stock
                    for($j=0;$j<count($request->sparepart);$j++){
                        $checkexistingSp= ScSparePartQty::where([
                            ['sparepart_id','=',$request->sparepart[$j]],
                            ['service_center_id','=',Auth::user()->id]
                        ])->first();

                        $newQty = ($checkexistingSp->quantity)-($request->needed_stock[$j]);
                        $affected= DB::table('sc_spare_part_qties')
                            ->where(['id'=>$checkexistingSp->id])
                            ->update(['quantity' =>$newQty]);
                    }
                }

                DB::commit();
                return redirect('/all-repairtickets')->with('status', 'Repair ticket generated successfully');

            } catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/all-repairtickets')->with('status', $e);
            }
        }
    }

    public function show($id){
        if(Auth::user()->role_id==3)
        {
            return redirect('/dashboard');
        }

       $repairTicketDetail = RepairTicket::find($id);
        $detailSc = User::where('id',$repairTicketDetail->service_center_id)->first();

        if(!$repairTicketDetail){
            return redirect('/all-repairtickets')->with('status', 'No Record Found');
        }
        else{
            if($repairTicketDetail->service_center_id ==Auth::user()->id || Auth::user()->role_id==1 || Auth::user()->role_id==2 ){

                $history = RepairTicket::select('repair_tickets.id as repairid','repair_tickets.repair_request_date as repair_date',
                    'repair_tickets.status as status', 'inverters.modal_number as inverter_modal',
                    'users.name as service_center_name','repair_tickets.fault_detail as faultdetail',
                    DB::raw('GROUP_CONCAT(spare_parts.name) as sp_name'))
                    ->join('inverters', 'repair_tickets.inverter_id', '=', 'inverters.id')
                    ->join('users', 'repair_tickets.service_center_id', '=', 'users.id')
                    ->join('repair_spare_parts', 'repair_spare_parts.repair_id', '=', 'repair_tickets.id')
                    ->join('spare_parts', 'repair_spare_parts.sparepart_id', '=', 'spare_parts.id')
                    ->groupBy('repair_tickets.id')
                    ->where('repair_tickets.serial_number',$repairTicketDetail->serial_number)
                    ->get();
                $neededSpareParts = RepairSparePart::select('repair_spare_parts.stock_needed as need_qty',
                    'repair_spare_parts.current_stock as current_qty','spare_parts.name as sp_name')
                    ->join('spare_parts', 'repair_spare_parts.sparepart_id', '=', 'spare_parts.id')
                    ->where('repair_spare_parts.repair_id',$id)
                    ->get();
                $userRole = Auth::user()->role_id;
                return view('repairticket.view-repair-ticket',compact('repairTicketDetail','history','neededSpareParts','userRole','detailSc'));
            }
            else{
                return redirect('/all-repairtickets')->with('status', 'Unauthorized');
            }
        }
    }
    public function markAsComplete($id){
        if(Auth::user()->role_id==1){
            // update status to completed
            $newdata = [
                'status'               => 'completed',
                'repair_complete_date' => date('Y-m-d H:i'),

            ];
            RepairTicket::where('id', $id)->update($newdata);

            return redirect('/all-repairtickets')->with('status', 'Repair Ticket is completed');
        }
        else{
            return redirect('/dashboard');


        }
    }
}
