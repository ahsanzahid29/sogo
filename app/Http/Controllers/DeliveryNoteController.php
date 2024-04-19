<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryNoteController extends Controller
{
    public function index(){
        return view('deliverynote.list-deliverynote');
    }

    public function add(){
        return view('deliverynote.add-deliverynote');

    }
    public function save(Request $request){
        return redirect('/deliverynote-list');
    }

}
