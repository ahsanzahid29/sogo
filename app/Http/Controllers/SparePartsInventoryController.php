<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use App\Models\SparePartCategory;
use App\Models\SparePartInventory;
use App\Models\SparePartsInventoryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;

class SparePartsInventoryController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 4) {
            return redirect("dashboard");
        }
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4) {
            $data["sparePartInventory"] = SparePartsInventoryDetail::select(
                "spare_parts_inventory_details.id as id",
                "spare_parts_inventory_details.principle_invoice_no as inv_no",
                "spare_parts_inventory_details.receiving_invoice_date as inv_date",
                "spare_parts_inventory_details.status as status",
                DB::raw(
                    "COUNT(spare_part_inventories.id) as inventory_count_count"
                ),
                "spare_parts_inventory_details.grn as grn"
            )
                ->leftJoin(
                    "spare_part_inventories",
                    "spare_parts_inventory_details.id",
                    "=",
                    "spare_part_inventories.spare_part_inventory_detail_id"
                )
                ->groupBy(
                    "spare_parts_inventory_details.id",
                    "spare_parts_inventory_details.principle_invoice_no",
                    "spare_parts_inventory_details.receiving_invoice_date",
                    "spare_parts_inventory_details.status",
                    "spare_parts_inventory_details.grn"
                )
                ->get();
        } elseif (Auth::user()->role_id == 2) {
            $data["sparePartInventory"] = SparePartsInventoryDetail::select(
                "spare_parts_inventory_details.id as id",
                "spare_parts_inventory_details.principle_invoice_no as inv_no",
                "spare_parts_inventory_details.receiving_invoice_date as inv_date",
                "spare_parts_inventory_details.status as status",
                DB::raw(
                    "COUNT(spare_part_inventories.id) as inventory_count_count"
                ),
                "spare_parts_inventory_details.grn as grn"
            )
                ->leftJoin(
                    "spare_part_inventories",
                    "spare_parts_inventory_details.id",
                    "=",
                    "spare_part_inventories.spare_part_inventory_detail_id"
                )
                ->groupBy(
                    "spare_parts_inventory_details.id",
                    "spare_parts_inventory_details.principle_invoice_no",
                    "spare_parts_inventory_details.receiving_invoice_date",
                    "spare_parts_inventory_details.status",
                    "spare_parts_inventory_details.grn"
                )
                ->where(
                    "spare_parts_inventory_details.user_id",
                    Auth::user()->id
                )
                ->get();
        }
        $data["count"] = 1;
        $data['role'] = Auth::user()->role_id;
        return view("spareparts.inventory.list-inventory", $data);
    }
    public function index_old()
    {
        $factoryCode = [];
        $partName = [];
        $partType = [];
        $orderNumber = [];
        $receiptDate = [];
        $serialNo = [];

        $sparePartInventory = DB::table("spare_part_inventories")
            ->select(
                "factory_code",
                "serial_number",
                DB::raw("COUNT(*) as qty")
            )
            ->groupBy("factory_code", "serial_number")
            ->get()
            ->toArray();

        foreach ($sparePartInventory as $row) {
            $detail = DB::table("spare_parts")
                ->select("*")
                ->where("factory_code", $row->factory_code)
                ->first();
            $spCategory = SparePartCategory::where(
                "id",
                $detail->part_type
            )->first();
            $repairDateDetail = DB::table("spare_part_inventories")
                ->select("*")
                ->where("serial_number", $row->serial_number)
                ->first();
            $factoryCode[] = $row->factory_code;
            $partName[] = $detail->name;
            $partType[] = $spCategory->name;
            $orderNumber[] = $repairDateDetail->order_number;
            $receiptDate[] = $repairDateDetail->repair_date;
            $serialNo[] = $row->serial_number;
        }
        $count = 1;
        return view(
            "spareparts.inventory.list-inventory",
            compact(
                "factoryCode",
                "partName",
                "partType",
                "orderNumber",
                "receiptDate",
                "count",
                "serialNo"
            )
        );
    }
    function generateRandomString($length = 6)
    {
        return Str::random($length); // This will give you a random alphanumeric string
    }
    function generateSequentialNumber($number)
    {
        return str_pad($number, 4, '0', STR_PAD_LEFT);
    }
    public function add()
    {
        if (Auth::user()->role_id == 4) {
            return redirect("dashboard");
        }
        $data["spareParts"] = SparePart::where('status','active')->get();
        $data["randomString"] = $this->generateRandomString();
        $count = SparePartsInventoryDetail::count();
        $finalCount = $count +1;
        $data["randomString"] = 'SK'.date('y').$this->generateSequentialNumber($finalCount);
        $data["inentory_serial_no"] = $this->generateRandomString();
        $data['role'] = Auth::user()->role_id;
        if (Auth::user()->role_id == 1) {
            return view("spareparts.inventory.add-inventory", $data);
        } elseif (Auth::user()->role_id == 2) {
            return view("spareparts.inventory.add-inventory-admin", $data);
        }
    }
    public function partDetailForInventory(Request $request)
    {
        $partId = $request->input("id");
        $sparePart = SparePart::find($partId);

        if ($sparePart) {
            return response()->json([
                "description" => $sparePart->name,
                "current_stock" =>
                    $sparePart->total_quantity - $sparePart->sold_quantity,
                "previous_purchase_price" => $sparePart->purchase_price,
            ]);
        } else {
            return response()->json(
                ["taxValue" => "No tax info available"],
                404
            );
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            "principle_invoice_no" => "required",
            "principle_invoice_date" => "required",
            "grn" => "required",
        ]);

        DB::beginTransaction();
        try {
            #------------------- insert in database--------------------------------#
            $sparePartInentoryDetail = SparePartsInventoryDetail::create([
                "principle_invoice_no" => $request->principle_invoice_no,
                "principle_invoice_date" => $request->principle_invoice_date,
                "grn" => $request->grn,
                "receiving_invoice_date" => date("Y-m-d"),
                "remarks" => $request->remarks,
                "user_id" => Auth::user()->id,
                "status" =>
                    Auth::user()->role_id == 1 ? "completed" : "pending",
            ]);
            $id = $sparePartInentoryDetail->id;
            if (Auth::user()->role_id == 1) {
                #------------insert record in spare_part_inventories table-------------------#

                for ($i = 0; $i < count($request->parts); $i++) {
                    $factoryCode = SparePart::find($request->parts[$i]);

                    SparePartInventory::create([
                        "factory_code" => $factoryCode->factory_code,
                        "user_id" => Auth::user()->id,
                        "spare_part_inventory_detail_id" => $id,
                        "sparepart_id" => $request->parts[$i],
                        "repair_date" => date("Y-m-d"),
                        "csv_key" => $request->grn,
                        "order_number" => rand(10, 10000),
                        "serial_number" => $this->generateRandomString(),
                        "qty_required" => $request->qty[$i],
                        "part_purchase_price" => $request->purchase_price[$i]
                            ? $request->purchase_price[$i]
                            : null,
                    ]);
                }
                //count entries modal number wise and update main invertor table
                $itemCounts = SparePartInventory::select(
                    "sparepart_id",
                    DB::raw("SUM(qty_required) as itemcount")
                )
                    ->groupBy("sparepart_id")
                    ->where("csv_key", $request->grn)
                    ->addSelect([
                        "last_purchase_price" => SparePartInventory::select(
                            "part_purchase_price"
                        )
                            ->whereColumn(
                                "sparepart_id",
                                "main_table.sparepart_id"
                            )
                            ->orderBy("id", "desc")
                            ->limit(1),
                    ])
                    ->from("spare_part_inventories as main_table")
                    ->get();

                foreach ($itemCounts as $row) {
                    // logic to change quantity after inventory os added
                    $oldDetail = SparePart::select("total_quantity")
                        ->where("id", $row->sparepart_id)
                        ->first();
                    $newTotal = $oldDetail->total_quantity + $row->itemcount;
                    $previousPurchasePrice = $row->last_purchase_price;
                    $affected = DB::table("spare_parts")
                        ->where(["id" => $row->sparepart_id])
                        ->update([
                            "total_quantity" => $newTotal,
                            "purchase_price" => $previousPurchasePrice,
                        ]);
                }
            } elseif (Auth::user()->role_id == 2) {
                #------------insert record in spare_part_inventories table-------------------#

                for ($i = 0; $i < count($request->parts); $i++) {
                    $factoryCode = SparePart::find($request->parts[$i]);

                    SparePartInventory::create([
                        "factory_code" => $factoryCode->factory_code,
                        "user_id" => Auth::user()->id,
                        "spare_part_inventory_detail_id" => $id,
                        "sparepart_id" => $request->parts[$i],
                        "repair_date" => date("Y-m-d"),
                        "csv_key" => $request->grn,
                        "order_number" => rand(10, 10000),
                        "serial_number" => $this->generateRandomString(),
                        "qty_required" => $request->qty[$i],
                        "part_purchase_price" => null,
                    ]);
                }
                //count entries modal number wise and update main invertor table
                $itemCounts = SparePartInventory::select(
                    "sparepart_id",
                    DB::raw("SUM(qty_required) as itemcount")
                )
                    ->groupBy("sparepart_id")
                    ->where("csv_key", $request->grn)
                    ->get();

                foreach ($itemCounts as $row) {
                    // logic to change quantity after inventory os added
                    $oldDetail = SparePart::select("total_quantity")
                        ->where("id", $row->sparepart_id)
                        ->first();
                    $newTotal = $oldDetail->total_quantity + $row->itemcount;

                    $affected = DB::table("spare_parts")
                        ->where(["id" => $row->sparepart_id])
                        ->update(["total_quantity" => $newTotal]);
                }
            }

            DB::commit();

            return redirect("/sparepart-inventory-list")->with(
                "status",
                "Inventory added successfully"
            );
        } catch (\Exception $e) {
            DB::rollback();
            // Redirect to users page with an error message
            return redirect("/sparepart-inventory-list")->with("status", $e);
        }
    }
    public function save_csv(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            "inventory_file" => "required|mimes:csv,txt",
        ]);

        // Open and read the CSV file
        if (
            ($handle = fopen(
                $request->file("inventory_file")->getPathname(),
                "r"
            )) !== false
        ) {
            // Get the headers
            $headers = fgetcsv($handle, 1000, ",");

            // Remove the BOM (Byte Order Mark) from the first column name
            $firstHeader = $headers[0];
            $firstHeader = preg_replace('/^\xEF\xBB\xBF/', "", $firstHeader);
            $headers[0] = $firstHeader;

            // Now create an associative array with header names as keys and their indices as values
            $headerIndexes = array_flip($headers);
            // Check for required columns
            $requiredColumns = [
                "Factorycode",
                "Serialnumber",
                "Ordernumber",
                "Dateofreceipt",
            ];
            $headerIndexes = array_flip($headers);
            //dd($requiredColumns,$headerIndexes);

            foreach ($requiredColumns as $column) {
                if (!array_key_exists($column, $headerIndexes)) {
                    return back()->withErrors([
                        "inventory_file" => "Missing required column: $column",
                    ]);
                }
            }

            // Read each row and validate data
            $insertData = [];
            // get random number for single csv
            $key = Str::random(6);
            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                $enteredSNo[] = $row[$headerIndexes["Serialnumber"]];
                // get inverter id from model name
                $sparePart = SparePart::select("id")
                    ->where("factory_code", $row[$headerIndexes["Factorycode"]])
                    ->first();
                if ($sparePart) {
                    // Extract data using column headers
                    $data = [
                        "factory_code" =>
                            $row[$headerIndexes["Factorycode"]] ?? "",
                        "user_id" => Auth::user()->id,
                        "sparepart_id" => $sparePart->id,
                        "repair_date" =>
                            date(
                                "Y-m-d",
                                strtotime($row[$headerIndexes["Dateofreceipt"]])
                            ) ?? "",
                        "csv_key" => $key,
                        "order_number" =>
                            $row[$headerIndexes["Ordernumber"]] ?? "",
                        "serial_number" =>
                            $row[$headerIndexes["Serialnumber"]] ?? "",
                    ];
                } else {
                    return back()->withErrors([
                        "inventory_file" => "Invalid data",
                    ]);
                }

                // Validate row data
                $validator = Validator::make($data, [
                    "factory_code" => "required",
                    "repair_date" => "required",
                    "order_number" => "required",
                    "serial_number" => "required",
                ]);

                if ($validator->fails()) {
                    continue; // Skip rows with validation errors
                }
                // check serial number length

                foreach ($enteredSNo as $item) {
                    if (strlen($item) === 5 && ctype_alnum($item)) {
                    } else {
                        return back()->withErrors([
                            "inventory_file" => "Please check serial numbers",
                        ]);
                    }
                }
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
                    return back()->withErrors([
                        "inventory_file" => "Duplicate Serial Number Found",
                    ]);
                } else {
                }

                // check serial number already exist in database
                $repeatedSerialNumbers = DB::table("spare_part_inventories")
                    ->whereIn("serial_number", $enteredSNo)
                    ->pluck("serial_number")
                    ->toArray();
                if (!empty($repeatedSerialNumbers)) {
                    return back()->withErrors([
                        "inventory_file" =>
                            "Serial Number already exist in database ",
                    ]);
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
                $itemCounts = SparePartInventory::select(
                    "sparepart_id",
                    DB::raw("COUNT(*) as itemcount")
                )
                    ->groupBy("sparepart_id")
                    ->where("csv_key", $key)
                    ->get();
                foreach ($itemCounts as $row) {
                    // logic to change quantity after inventory os added
                    $oldDetail = SparePart::select("total_quantity")
                        ->where("id", $row->sparepart_id)
                        ->first();
                    $newTotal = $oldDetail->total_quantity + $row->itemcount;
                    $affected = DB::table("spare_parts")
                        ->where(["id" => $row->sparepart_id])
                        ->update(["total_quantity" => $newTotal]);
                }
                return redirect("/sparepart-inventory-list")->with(
                    "status",
                    "Inventory added successfully"
                );
            } else {
                return back()->withErrors([
                    "inventory_file" => "No valid data to import",
                ]);
            }
        }

        return back()->withErrors([
            "inventory_file" => "Unable to read the CSV file",
        ]);
    }

    public function edit($id)
    {
        $data['role'] = Auth::user()->role_id;
        $data["detail"] = SparePartsInventoryDetail::find($id);
        $data["sp_inventory"] = SparePartInventory::select(
            "spare_part_inventories.factory_code as factory_code",
            "spare_part_inventories.qty_required as qty",
            "spare_part_inventories.part_purchase_price as pprice",
            "spare_parts.name as spname",
            "spare_part_inventories.id as inv_id"
        )
            ->join(
                "spare_parts",
                "spare_part_inventories.sparepart_id",
                "=",
                "spare_parts.id"
            )
            ->where(
                "spare_part_inventories.spare_part_inventory_detail_id",
                "=",
                $id
            )
            ->get();

        return view("spareparts.inventory.inventory-detail", $data);
    }

    public function viewPdf($id){

        $data["detail"] = SparePartsInventoryDetail::find($id);
        $data["sp_inventory"] = SparePartInventory::select(
            "spare_part_inventories.factory_code as factory_code",
            "spare_part_inventories.qty_required as qty",
            "spare_part_inventories.part_purchase_price as pprice",
            "spare_parts.name as spname",
            "spare_part_inventories.id as inv_id"
        )
            ->join(
                "spare_parts",
                "spare_part_inventories.sparepart_id",
                "=",
                "spare_parts.id"
            )
            ->where(
                "spare_part_inventories.spare_part_inventory_detail_id",
                "=",
                $id
            )
            ->get();
        return view('spareparts.inventory.print-inventory',$data);

    }
    public function update(Request $request)
    {
        $inventoryIds = $request->inventory_ids;
        $newPurchasePrice = $request->purchase_price;
        $principle_invoice_no= $request->principle_invoice_no;
        $principle_invoice_date= $request->principle_invoice_date;
        $remarks= $request->remarks;

        $inventoryMainDetail = SparePartsInventoryDetail::find(
            $request->record_id
        );
        DB::beginTransaction();
        try {
            // update basic inventory detail
            $newdata = [
                'principle_invoice_no'      => $principle_invoice_no,
                'principle_invoice_date'    => $principle_invoice_date,
                'remarks'                   => $remarks,

            ];
            SparePartsInventoryDetail::where('id', $request->record_id)->update($newdata);

            // add purchase_price in spare_part_inventories table
            for ($i = 0; $i < count($inventoryIds); $i++) {
                $affected = DB::table("spare_part_inventories")
                    ->where(["id" => $inventoryIds[$i]])
                    ->update(["part_purchase_price" => $newPurchasePrice[$i]]);
            }
            #--update purchase_price in spare_parts table--#
            //count entries modal number wise and update main invertor table
            $itemCounts = SparePartInventory::select(
                "sparepart_id",
                DB::raw("SUM(qty_required) as itemcount")
            )
                ->groupBy("sparepart_id")
                ->where("csv_key", $inventoryMainDetail->grn)
                ->addSelect([
                    "last_purchase_price" => SparePartInventory::select(
                        "part_purchase_price"
                    )
                        ->whereColumn("sparepart_id", "main_table.sparepart_id")
                        ->orderBy("id", "desc")
                        ->limit(1),
                ])
                ->from("spare_part_inventories as main_table")
                ->get();

            foreach ($itemCounts as $row) {
                // logic to change purchase_price in spare_parts after purchaseprice is added by superadmin
                $previousPurchasePrice = $row->last_purchase_price;
                $affected = DB::table("spare_parts")
                    ->where(["id" => $row->sparepart_id])
                    ->update(["purchase_price" => $previousPurchasePrice]);
            }
            // change status in spare_parts_inventory_details table
            $affected = DB::table("spare_parts_inventory_details")
                ->where(["id" => $request->record_id])
                ->update(["status" => "completed"]);

            DB::commit();

            return redirect("/sparepart-inventory-list")->with(
                "status",
                "Purchase Price added successfully"
            );
        } catch (\Exception $e) {
            DB::rollback();
            // Redirect to users page with an error message
            return redirect("/sparepart-inventory-list")->with("status", $e);
        }
    }
}
