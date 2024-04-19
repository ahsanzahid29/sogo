<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SparePartsInvoiceController extends Controller
{
   public function index(){
       return view('invoice.list-invoice');

   }

   public function add(){
       return view('invoice.add-invoice');
   }

   public function save(Request $request){
       return redirect('/invoice-list');
   }
}
