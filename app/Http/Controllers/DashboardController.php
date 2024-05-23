<?php

namespace App\Http\Controllers;

use App\Models\Deliverynote;
use App\Models\Inverter;
use App\Models\RepairTicket;
use App\Models\SparePart;
use App\Models\SparePartInvoiceItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('checkrole');
    }

    public function index(){
        if(Auth::user()->role_id==1){
            $data['adminCount'] = User::where('role_id', 2)->count();
            $data['dealerCount'] = User::where('role_id', 3)->count();
            $data['agentCount'] = User::where('role_id', 4)->count();
            $data['inverterCount'] = Inverter::count();
            $data['sparePartCount'] = SparePart::count();
            $data['deliveryNotesCount'] = Deliverynote::count();
            $data['openTickets']   = RepairTicket::where('status', 'pending')->count();
            $data['closedTickets'] = RepairTicket::where('status', 'completed')->count();

            return view('dashboard.sa-dashboard', $data);


        }
        else if(Auth::user()->role_id==2){

            $data['dealerCount'] = User::where('role_id', 3)->count();
            $data['agentCount'] = User::where('role_id', 4)->count();
            $data['inverterCount'] = Inverter::count();
            $data['sparePartCount'] = SparePart::count();
            $data['deliveryNotesCount'] = Deliverynote::count();
            $data['allTickets']   = RepairTicket::count();

            return view('dashboard.ad-dashboard', $data);

        }
        else if(Auth::user()->role_id==3){
            $data['agentCount'] = User::where('role_id', 4)->count();
            $data['inverterCount'] = Inverter::count();
            $data['sparePartCount'] = SparePart::count();
            $data['deliveryNotesCount'] = Deliverynote::where('dealer_id','=',Auth::user()->id)->count();

            return view('dashboard.de-dashboard', $data);

        }
        else if(Auth::user()->role_id==4){

            $sparePartCount = SparePartInvoiceItem::select(DB::raw('SUM(spare_part_invoice_items.quantity) as total_quantity'),
                'spare_parts.name as partname','spare_part_categories.name as factorycode','spare_parts.part_type as parttype',
                'spare_parts.voltage_rating as voltagerating','spare_parts.ampeare_rating as ampearrating',
                'spare_parts.sale_price as saleprice','spare_parts.base_unit as baseunit')
                ->join('spare_parts', 'spare_part_invoice_items.sparepart_id', '=', 'spare_parts.id')
                ->join('spare_part_categories', 'spare_parts.part_type', '=', 'spare_part_categories.id')
                ->groupBy('spare_part_invoice_items.sparepart_id', 'spare_parts.name','spare_parts.factory_code',
                    'spare_parts.part_type','spare_parts.voltage_rating','spare_parts.ampeare_rating','spare_parts.sale_price',
                    'spare_parts.base_unit')
                ->where('spare_part_invoice_items.service_center_id','=',Auth::user()->id)
                ->get();
            $data['sparePartCount'] = count($sparePartCount);

            $data['openTickets']   = RepairTicket::where([
                [ 'status','=' ,'pending'],
                ['user_id','=',Auth::user()->id]
            ]
            )->count();
            $data['closedTickets'] = RepairTicket::where([
                    [ 'status','=' ,'completed'],
                    ['user_id','=',Auth::user()->id]
                ]
            )->count();

           return view('dashboard.sc-dashboard', $data);

        }

    }
}
