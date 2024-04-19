<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepairTicketController extends Controller
{
    public function index(){
        return view('repairticket.list-repairticket');
    }

    public function allTickets(){
        return view('repairticket.all-repairticket');


    }
}
