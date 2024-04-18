<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SparePartsInventoryController extends Controller
{
    public function index(){
        return view('spareparts.inventory.list-inventory');
    }
}
