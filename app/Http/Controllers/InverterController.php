<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InverterController extends Controller
{
    public function index(){
        return view('inverters.inverter-list');
    }

    public function add(){
        return view('inverters.inverter-add');
    }

    public function save(Request $request){
        return redirect('/inverters-list');
    }
}
