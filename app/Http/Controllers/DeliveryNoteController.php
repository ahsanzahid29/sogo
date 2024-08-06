<?php

namespace App\Http\Controllers;

use App\Models\DealerProduct;
use App\Models\Deliverynote;
use App\Models\Inverter;
use App\Models\InverterInventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class DeliveryNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        //$this->middleware('checkrole');
    }
    public function index()
    {
        if (Auth::user()->role_id == 4) {
            return redirect("/dashboard");
        }
        $data["deliveryNotes"] = DB::table("dealer_products")
            ->join(
                "deliverynotes",
                "dealer_products.deliverynote_id",
                "=",
                "deliverynotes.id"
            )
            ->select(
                "deliverynotes.id as recordid",
                "deliverynotes.do_no",
                "deliverynotes.notes as notes",
                "deliverynotes.created_at as created_at",
                "deliverynotes.notes as notes",
                DB::raw("count(dealer_products.id) as total"),
                "deliverynotes.created_at"
            )
            ->groupBy(
                "dealer_products.deliverynote_id",
                "deliverynotes.do_no",
                "deliverynotes.notes",
                "deliverynotes.created_at",
                "deliverynotes.id",
                "deliverynotes.notes",
                "deliverynotes.id"
            ) // Group by delivery_id and any column you select
            ->get();

        $data["count"] = 1;

        return view("deliverynote.list-deliverynote", $data);
    }

    public function add()
    {
        if (Auth::user()->role_id == 4) {
            return redirect("/dashboard");
        }
        $data["dealers"] = User::where("role_id", 3)->get();
        $data["inverters"] = Inverter::where([
            ["total_quantity", ">", 0],
            ["status",'=','active']
        ])->get();
        return view("deliverynote.add-deliverynote", $data);
    }
    public function detailDealer($id)
    {
        $data["user"] = User::find($id);
        return view("deliverynote.user-detail", $data);
    }
    public function detailInverter(Request $request)
    {
        $id = $request->input("partId");
        $inverterDetail = Inverter::find($id);
        if ($inverterDetail) {
            return response()->json([
                "currentStock" => $inverterDetail->total_quantity,
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
        if ($request->all()) {
            //            $this->validate($request, [
            //                'dealer_id'    =>  'required|not_in:0',
            //                'do_no'        => 'required',
            //                'notes'        =>'required'
            //            ]);
            try {
                DB::beginTransaction();
                $spareparts = $request->input("sparepart");
                $csvFiles = $request->file("csv_files");

                // insert delivery note basic info
                $deliverynote = Deliverynote::create([
                    "dealer_id" => $request->dealer_id,
                    "do_no" => $request->do_number,
                    "user_id" => Auth::user()->id,
                    "notes" => $request->notes,
                ]);

                // logic to assign models to dealer based on serial number provided in csv

                foreach ($spareparts as $index => $modelId) {
                    $product = Inverter::find($modelId);
                    $csvFile = $csvFiles[$index];

                    // Validate the file type if necessary
                    if ($csvFile->getClientOriginalExtension() !== "csv") {
                        return back()->withErrors([
                            "invalid_csv" =>
                                "Invalid file type. Only CSV files are allowed.",
                        ]);
                    }

                    // Read the CSV file
                    $csvData = array_map(
                        "str_getcsv",
                        file($csvFile->getRealPath())
                    );

                    // Remove the header row
                    array_shift($csvData);

                    // Extract the serial numbers from the CSV data
                    $serialNumbers = array_column($csvData, 0);

                    $existingCount = InverterInventory::where(
                        "inverter_id",
                        $modelId
                    )
                        ->where("is_assigned", 0)
                        ->whereIn("serial_number", $serialNumbers)
                        ->count();

                    // Check if all serial numbers exist
                    if ($existingCount !== count($serialNumbers)) {
                        //deduct total stock and sold stock from inverters table
                        $dealerItems = DealerProduct::where(
                            "deliverynote_id",
                            $deliverynote->id
                        )->get();
                        if (count($dealerItems) > 0) {
                            foreach ($dealerItems as $row) {
                                $inverters[] = $row->inverter_id;
                                $sNo[] = $row->serial_number;
                            }
                            for ($i = 0; $i < count($inverters); $i++) {
                                $oldDetail = Inverter::select("total_quantity")
                                    ->where("id", $inverters[$i])
                                    ->first();
                                $newTotalStock =
                                    $oldDetail->total_quantity +
                                    count($inverters);
                                $newSoldStock =
                                    $oldDetail->sold_quantity -
                                    count($inverters);

                                $affected = DB::table("inverters")
                                    ->where(["id" => $inverters[$i]])
                                    ->update([
                                        "total_quantity" => $newTotalStock,
                                        "sold_quantity" => $newSoldStock,
                                    ]);
                            }
                            // make is_assigned to 0 in inverters_inventoty table

                            DB::table("inverter_inventories")
                                ->whereIn(["serial_number" => $sNo])
                                ->update(["is_assigned" => 0]);
                        }
                        // delete record from delivery_notes table
                        Deliverynote::where("id", $deliverynote->id)->delete();
                        DealerProduct::where(
                            "deliverynote_id",
                            $deliverynote->id
                        )->delete();
                        return back()->withErrors([
                            "invalid_csv" =>
                                "Invalid serial number for Product Model " .
                                $product->modal_number,
                        ]);
                    }
                    foreach ($serialNumbers as $serialNumber) {
                        DealerProduct::create([
                            "dealer_id" => $request->dealer_id,
                            "inverter_id" => $modelId,
                            "deliverynote_id" => $deliverynote->id,
                            "serial_number" => $serialNumber,
                        ]);
                        // update is_assigned column in inverters_inventory table

                        $is_assigned = 1;
                        DB::table("inverter_inventories")
                            ->where("serial_number", $serialNumber)
                            ->update(["is_assigned" => $is_assigned]);
                        // deduct inverter stock
                        $oldDetail = Inverter::select(
                            "total_quantity",
                            "sold_quantity"
                        )
                            ->where("id", $modelId)
                            ->first();
                        $newTotalStock = $oldDetail->total_quantity - 1;
                        $newSoldStock = $oldDetail->sold_quantity + 1;

                        $affected = DB::table("inverters")
                            ->where(["id" => $modelId])
                            ->update([
                                "total_quantity" => $newTotalStock,
                                "sold_quantity" => $newSoldStock,
                            ]);
                    }
                }
                DB::commit();
                return redirect("/deliverynote-list")->with(
                    "status",
                    "Delivery note added successfully"
                );
            } catch (\Exception $e) {
                DB::rollback();
                // Redirect to inverter page with an error message
                return redirect("/deliverynote-list")->with("status", $e);
            }
        }
    }

    public function show($id)
    {
        if (Auth::user()->role_id == 4) {
            return redirect("/dashboard");
        }
        $data["deliveryNote"] = Deliverynote::select(
            "deliverynotes.id as recordid",
            "users.name as username",
            "users.phoneno_1 as userphone",
            "deliverynotes.created_at as createdat",
            "deliverynotes.notes as notes",
            "users.email as useremail",
            "deliverynotes.do_no as do_no"
        )

            ->join("users", "deliverynotes.dealer_id", "=", "users.id")
            ->where("deliverynotes.id", $id)
            ->first();

        if ($data["deliveryNote"]) {

            $data['deliveryItems'] = DealerProduct::select('dealer_products.serial_number as sno',
            'inverters.modal_number as modalNo','dealer_products.created_at as delivery_date')
                ->join("inverters", "dealer_products.inverter_id", "=", "inverters.id")
                ->where('dealer_products.deliverynote_id',$id)
                ->orderBy('dealer_products.id','ASC')
                ->get();
            return view("deliverynote.view-deliverynote", $data);
        }
        return redirect("/deliverynote-list")->with(
            "status",
            "No record found"
        );
    }
    public function printNote($id)
    {
        $deliveryNote = Deliverynote::select(
            "deliverynotes.id as recordid",
            "users.name as username",
            "users.phoneno_1 as userphone",
            "deliverynotes.created_at as createdat",
            "deliverynotes.notes as notes",
            "users.email as useremail",
            "deliverynotes.do_no as do_no"
        )

            ->join("users", "deliverynotes.dealer_id", "=", "users.id")
            ->where("deliverynotes.id", $id)
            ->first();
        //dd($deliveryNote);
        if (!$deliveryNote) {
            return redirect("/deliverynote-list")->with(
                "status",
                "No record found"
            );
        }
        $deliveryItems = DealerProduct::select('dealer_products.serial_number as sno',
            'inverters.modal_number as modalNo','dealer_products.created_at as delivery_date')
            ->join("inverters", "dealer_products.inverter_id", "=", "inverters.id")
            ->where('dealer_products.deliverynote_id',$id)
            ->orderBy('dealer_products.id','ASC')
            ->get();
        return view("deliverynote.print-deliverynote", compact("deliveryNote","deliveryItems"));
    }

    public function downloadNote($id)
    {
        $data["deliveryNote"] = Deliverynote::select(
            "deliverynotes.id as recordid",
            "users.name as username",
            "users.phoneno_1 as userphone",
            "deliverynotes.created_at as createdat",
            "deliverynotes.notes as notes",
            "users.email as useremail",
            "deliverynotes.do_no as do_no"
        )

            ->join("users", "deliverynotes.dealer_id", "=", "users.id")
            ->where("deliverynotes.id", $id)
            ->first();
        //dd($deliveryNote);
        if (!$data["deliveryNote"]) {
            return redirect("/deliverynote-list")->with(
                "status",
                "No record found"
            );
        }
        $data['deliveryItems'] = DealerProduct::select('dealer_products.serial_number as sno',
            'inverters.modal_number as modalNo','dealer_products.created_at as delivery_date')
            ->join("inverters", "dealer_products.inverter_id", "=", "inverters.id")
            ->where('dealer_products.deliverynote_id',$id)
            ->orderBy('dealer_products.id','ASC')
            ->get();

        $pdf = PDF::loadView("deliverynote.download-deliverynote", $data);

        $rand = time() . rand(10, 1000);
        $filename = "delivery_note_" . $rand . ".pdf";
        return $pdf->download($filename);
    }
}
