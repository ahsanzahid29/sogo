<?php

namespace App\Http\Controllers;

use App\Models\RepairSparePart;
use App\Models\RepairTicket;
use App\Models\SparePartRequest;
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

        $data['allSparePartRequests'] = DB::table('spare_part_requests')
            ->select(
                DB::raw('MIN(spare_part_requests.id) as recordid'),
                'spare_part_requests.ticket_id',
                'repair_tickets.ticket_number as rptn',
                'repair_tickets.serial_number as rpsn',
                DB::raw('MAX(users.name) as scname'),
                DB::raw('MAX(users.email) as scemail'),
                DB::raw('MAX(users.phoneno_1) as scphone')
            )
            ->join("users", "spare_part_requests.service_center_id", "=", "users.id")
            ->join("repair_tickets", "spare_part_requests.ticket_id", "=", "repair_tickets.id")
            ->groupBy('spare_part_requests.ticket_id', 'repair_tickets.ticket_number', 'repair_tickets.serial_number')
            ->get();
        $data['count'] = 1;

        return view('sparepartrequest.list', $data);
    }
    public function show($id){
        $repairTicketDetail = RepairTicket::where('id',$id)->first();

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
            $neededSpareParts = SparePartRequest::select('spare_part_requests.required_quantity as need_qty',
                'spare_parts.factory_code as sp_name')
                ->join('spare_parts', 'spare_part_requests.sparepart_id', '=', 'spare_parts.id')
                ->where('spare_part_requests.ticket_id',$id)
                ->get();
                $userRole = Auth::user()->role_id;
                return view('sparepartrequest.view-request',compact('repairTicketDetail','history','userRole','neededSpareParts','detailSc'));

        }
    }
}
