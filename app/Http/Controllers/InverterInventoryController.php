<?php

namespace App\Http\Controllers;

use App\Models\Inverter;
use App\Models\InverterInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InverterInventoryController extends Controller
{
    public function index(){
        if(Auth::user()->role_id==4){
            return redirect('/dashboard');
        }
        $container_no=[];
        $order_no=[];
        $model_number=[];
        $serial_number=[];
        $qty=[];
        $receipt_date=[];
        $entry_date=[];

        $inventory = DB::table('inverter_inventories')
            ->select('model_number','serial_number', DB::raw('COUNT(*) as qty'))
            ->groupBy('model_number','serial_number')
            ->get()
            ->toArray();
        foreach($inventory as $row){
            $detail = DB::table('inverter_inventories')->select('*')
                ->where('serial_number',$row->serial_number)->first();
            $productName = Inverter::where('modal_number',$row->model_number)->first();
            $container_no[]   = $productName->inverter_name;
            $order_no[]       = $detail->order_number;
            $model_number[]   = $row->model_number;
            $serial_number[]  = $row->serial_number;
            $receipt_date[]   = $detail->date_of_receipt;
            $entry_date[]     = $detail->date_of_entry;

        }
        $count=1;

        return view('inverters.inventory.list-inventory',compact('model_number','serial_number','count','order_no','receipt_date','entry_date','container_no'));
    }

    public function add(){
        return view('inverters.inventory.add-inventory');
    }
    public function save(Request $request){
        // Validate the uploaded file
        $request->validate([
            'inventory_file' => 'required|mimes:csv,txt',
        ]);

        // Open and read the CSV file
        if (($handle = fopen($request->file('inventory_file')->getPathname(), 'r')) !== false) {
            // Get the headers
            $headers = fgetcsv($handle, 1000, ',');

            // Remove the BOM (Byte Order Mark) from the first column name
            $firstHeader = $headers[0];
            $firstHeader = preg_replace('/^\xEF\xBB\xBF/', '', $firstHeader);
            $headers[0] = $firstHeader;

          // Now create an associative array with header names as keys and their indices as values
            $headerIndexes = array_flip($headers);
            // Check for required columns
            $requiredColumns = ['ModelNumber', 'SerialNumber', 'OrderNumber','Dateofreceipt'];
            $headerIndexes = array_flip($headers);
            //dd($requiredColumns,$headerIndexes);


            foreach ($requiredColumns as $column) {
                if (!array_key_exists($column, $headerIndexes)) {
                    return back()->withErrors(['inventory_file' => "Missing required column: $column"]);
                }
            }

            // Read each row and validate data
            $insertData = [];
            // get random number for single csv
            $key = Str::random(6);
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $enteredSNo[]=  $row[$headerIndexes['SerialNumber']];
                // get inverter id from model name
                $inverter = Inverter::select('id')->where('modal_number',$row[$headerIndexes['ModelNumber']])->first();
                if($inverter){
                    // Extract data using column headers
                    $data = [
                        'model_number' =>    $row[$headerIndexes['ModelNumber']] ?? '',
                        'serial_number' =>   $row[$headerIndexes['SerialNumber']] ?? '',
                        'order_number'=>     $row[$headerIndexes['OrderNumber']] ?? '',
                        //'container' =>       $row[$headerIndexes['ContainerNumber']] ?? '',
                        'date_of_receipt'=>  date('Y-m-d',strtotime($row[$headerIndexes['Dateofreceipt']])) ?? '',
                        'inverter_id'    =>  $inverter->id,
                        'unique_sku'     =>  $row[$headerIndexes['SerialNumber']] ?? '',
                        'date_of_entry'  =>  date('Y-m-d'),
                        'user_id'        =>  Auth::user()->id,
                        'csv_key'        =>  $key
                    ];

                }
                else{
                    return back()->withErrors(['inventory_file' => 'Invalid data']);

                }

                // Validate row data
                $validator = Validator::make($data, [
                    'model_number' => 'required',
                    'serial_number' => 'required',
                    'order_number' => 'required',
                    //'container' =>    'required',
                    'date_of_receipt'=> 'required'
                ]);

                if ($validator->fails()) {
                    continue; // Skip rows with validation errors
                }

                // Add validated data to the insertion array
                $insertData[] = $data;
            }

            fclose($handle);
            // check serial number duplicates within an array
            $valueCounts = array_count_values($enteredSNo);

            $hasRepetitions = false;
            foreach ($valueCounts as $count) {
                if ($count > 1) {
                    $hasRepetitions = true;
                    break;
                }
            }
            if ($hasRepetitions) {
                return back()->withErrors(['inventory_file' => 'Duplicate Serial Number Found']);
            } else {}
            // check serial number already exist in database
            $repeatedSerialNumbers = DB::table('inverter_inventories')
                ->whereIn('serial_number', $enteredSNo)
                ->pluck('serial_number')
                ->toArray();
            if (!empty($repeatedSerialNumbers)) {
                return back()->withErrors(['inventory_file' => 'Serial Number already exist in database ']);
            }





            // Insert validated data into the database
            if (!empty($insertData)) {
                InverterInventory::insert($insertData);
                //count entries modal number wise and update main invertor table
                $itemCounts = InverterInventory::select('inverter_id', DB::raw('COUNT(*) as itemcount'))
                    ->groupBy('inverter_id')
                    ->where('csv_key',$key)
                    ->get();
                foreach($itemCounts as $row){
                    // logic to change quantity after inventory os added
                    $oldDetail = Inverter::select('total_quantity')->where('id',$row->inverter_id)->first();
                    $newTotal = ($oldDetail->total_quantity)+($row->itemcount);
                    $affected= DB::table('inverters')
                        ->where(['id'=>$row->inverter_id])
                        ->update(['total_quantity' =>$newTotal]);
                }
                return redirect('/inverters-inventory-list')->with('status', 'Inventory added successfully');
            } else {
                return back()->withErrors(['inventory_file' => 'No valid data to import']);
            }
        }

        return back()->withErrors(['inventory_file' => 'Unable to read the CSV file']);

    }
}
