<?php

namespace App\Http\Controllers;

use App\Models\RepairSparePart;
use App\Models\RepairTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SparePartRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    public function index(){

        $data['allRepairTickets'] = RepairTicket::select('repair_tickets.id as rp_id',
            'repair_tickets.ticket_number as rp_ticket','repair_tickets.serial_number as rp_sn',
            'repair_tickets.status as rp_status','repair_tickets.repair_request_date as rp_req_date',
            'inverters.inverter_name as rep_inv_name','inverters.modal_number as rep_inv_model')
            ->join('inverters', 'repair_tickets.inverter_id', '=', 'inverters.id')
            ->where('repair_tickets.status','pending')
            ->get();

        return view('sparepartrequest.list', $data);
    }
    public function show($id){
        $repairTicketDetail = RepairTicket::where([
            ['id',$id],
            ['status','pending']
        ])->first();
        $detailSc = User::where('id',$repairTicketDetail->service_center_id)->first();

        if(!$repairTicketDetail){
            return redirect('/sparepart-request-list')->with('status', 'No Record Found');
        }
        else{

                $history = RepairTicket::select('repair_tickets.id as repairid','repair_tickets.repair_request_date as repair_date',
                    'repair_tickets.status as status', 'inverters.modal_number as inverter_modal',
                    'users.name as service_center_name','repair_tickets.fault_detail as faultdetail',
                    DB::raw('GROUP_CONCAT(spare_parts.name) as sp_name'))
                    ->join('inverters', 'repair_tickets.inverter_id', '=', 'inverters.id')
                    ->join('users', 'repair_tickets.service_center_id', '=', 'users.id')
                    ->join('repair_spare_parts', 'repair_spare_parts.repair_id', '=', 'repair_tickets.id')
                    ->join('spare_parts', 'repair_spare_parts.sparepart_id', '=', 'spare_parts.id')
                    ->groupBy('repair_tickets.id','repair_tickets.repair_request_date',
                        'repair_tickets.status', 'inverters.modal_number',
                        'users.name','repair_tickets.fault_detail')
                    ->where('repair_tickets.serial_number',$repairTicketDetail->serial_number)
                    ->get();
            $neededSpareParts = RepairSparePart::select('repair_spare_parts.stock_needed as need_qty',
                'repair_spare_parts.current_stock as current_qty','spare_parts.name as sp_name')
                ->join('spare_parts', 'repair_spare_parts.sparepart_id', '=', 'spare_parts.id')
                ->where('repair_spare_parts.repair_id',$id)
                ->get();
                $userRole = Auth::user()->role_id;
                return view('sparepartrequest.view-request',compact('repairTicketDetail','history','userRole','neededSpareParts','detailSc'));

        }
    }
}
