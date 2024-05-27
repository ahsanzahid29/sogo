<?php

namespace App\Http\Controllers;


use App\Models\SparePart;
use App\Models\SparePartInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SparePartsInventoryController extends Controller
{
    public function index(){
        $factoryCode=[];
        $partName=[];
        $partType=[];
        $orderNumber=[];
        $receiptDate=[];
        $voltageRating=[];

        $sparePartInventory = DB::table('spare_part_inventories')
            ->select('factory_code','serial_number', DB::raw('COUNT(*) as qty'))
            ->groupBy('factory_code','serial_number')
            ->get()
            ->toArray();

        foreach($sparePartInventory as $row){
            $detail = DB::table('spare_parts')->select('*')
                ->where('factory_code',$row->factory_code)->first();
            $repairDateDetail= DB::table('spare_part_inventories')->select('*')
                ->where('serial_number',$row->serial_number)->first();
            $factoryCode[]    = $row->factory_code;
            $partName[]       = $detail->name;
            $partType[]       = $detail->part_type;
            $orderNumber[]    = $repairDateDetail->order_number;
            $receiptDate[]    = $repairDateDetail->repair_date;
            $voltageRating[]  = $detail->voltage_rating;

        }
        $count=1;
        return view('spareparts.inventory.list-inventory',compact('factoryCode','partName','partType','orderNumber','receiptDate','count','voltageRating'));
    }
    public function add(){
        return view('spareparts.inventory.add-inventory');

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
            $requiredColumns = ['Factorycode','Serialnumber','Ordernumber','Dateofreceipt'];
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
                $enteredSNo[]=  $row[$headerIndexes['Serialnumber']];
                // get inverter id from model name
                $sparePart = SparePart::select('id')->where('factory_code',$row[$headerIndexes['Factorycode']])->first();
                if($sparePart){
                    // Extract data using column headers
                    $data = [
                        'factory_code'     =>    $row[$headerIndexes['Factorycode']] ?? '',
                        'user_id'          =>  Auth::user()->id,
                        'sparepart_id'    =>    $sparePart->id,
                        'repair_date'      =>    date('Y-m-d',strtotime($row[$headerIndexes['Dateofreceipt']])) ?? '',
                        'csv_key'        =>  $key,
                        'order_number' =>   $row[$headerIndexes['Ordernumber']] ?? '',
                        'serial_number' =>   $row[$headerIndexes['Serialnumber']] ?? '',
                    ];

                }
                else{
                    return back()->withErrors(['inventory_file' => 'Invalid data']);
                }


                // Validate row data
                $validator = Validator::make($data, [
                    'factory_code' => 'required',
                    'repair_date' => 'required',
                    'order_number' => 'required',
                    'serial_number' => 'required',
                ]);

                if ($validator->fails()) {
                    continue; // Skip rows with validation errors
                }
                // check serial number length

                foreach ($enteredSNo as $item) {
                    if (strlen($item) === 17 && ctype_alnum($item)) {
                    } else {
                        return back()->withErrors(['inventory_file' => 'Please check serial numbers']);

                    }
                }

                // Add validated data to the insertion array
                $insertData[] = $data;
            }

            fclose($handle);
            //dd($insertData);


            // Insert validated data into the database
            if (!empty($insertData)) {
                SparePartInventory::insert($insertData);
                //count entries modal number wise and update main invertor table
                $itemCounts = SparePartInventory::select('sparepart_id', DB::raw('COUNT(*) as itemcount'))
                    ->groupBy('sparepart_id')
                    ->where('csv_key',$key)
                    ->get();
                foreach($itemCounts as $row){
                    // logic to change quantity after inventory os added
                    $oldDetail = SparePart::select('total_quantity')->where('id',$row->sparepart_id)->first();
                    $newTotal = ($oldDetail->total_quantity)+($row->itemcount);
                    $affected= DB::table('spare_parts')
                        ->where(['id'=>$row->sparepart_id])
                        ->update(['total_quantity' =>$newTotal]);
                }
                return redirect('/sparepart-inventory-list')->with('status', 'Inventory added successfully');
            } else {
                return back()->withErrors(['inventory_file' => 'No valid data to import']);
            }
        }

        return back()->withErrors(['inventory_file' => 'Unable to read the CSV file']);

    }
}
