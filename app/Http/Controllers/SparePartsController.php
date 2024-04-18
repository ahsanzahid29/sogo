<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SparePartsController extends Controller
{
    public function index(){
        return view('spareparts.parts-list');
    }

    public function add(){
        return view('spareparts.parts-add');
    }

    public function save(Request $request){
        return redirect('/spareparts-list');
    }
}
