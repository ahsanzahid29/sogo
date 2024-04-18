<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InverterInventoryController extends Controller
{
    public function index(){
        return view('inverters.inventory.list-inventory');
    }
}
