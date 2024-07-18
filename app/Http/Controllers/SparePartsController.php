<?php

namespace App\Http\Controllers;

use App\Models\Inverter;
use App\Models\SparePart;
use App\Models\SparePartCategory;
use App\Models\SparePartInvoiceItem;
use App\Models\SparePartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SparePartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('checkrole');
    }

    public function index(){
        $data['role'] = Auth::user()->role_id;
        $data['count'] = 1;
        if($data['role']==4){
            $data['sparePartsForSc']= SparePartInvoiceItem::select(DB::raw('SUM(spare_part_invoice_items.quantity) as total_quantity'),
                'spare_parts.name as partname',
                'spare_part_categories.name as factorycode',
                'spare_parts.part_type as parttype',
                'spare_parts.voltage_rating as voltagerating',
                'spare_parts.ampeare_rating as ampearrating',
                'spare_parts.sale_price as saleprice',
                'spare_parts.base_unit as baseunit',
                'spare_parts.id as recordid',
                'spare_part_categories.name as category',
                'spare_parts.pieces as pieces'
            )
                ->join('spare_parts', 'spare_part_invoice_items.sparepart_id', '=', 'spare_parts.id')
                ->join('spare_part_categories', 'spare_parts.part_type', '=', 'spare_part_categories.id')
                ->groupBy(
                    'spare_part_invoice_items.sparepart_id',
                    'spare_parts.name',
                    'spare_parts.factory_code',
                    'spare_parts.part_type',
                    'spare_parts.voltage_rating',
                    'spare_parts.ampeare_rating',
                    'spare_parts.sale_price',
                    'spare_parts.base_unit',
                    'spare_part_categories.name',
                    'spare_parts.pieces',
                    'spare_parts.id'

                )
                ->where('spare_part_invoice_items.service_center_id','=',Auth::user()->id)
                ->get();
            //dd($data['sparePartsForSc']);
            return view('spareparts.servicecenter.parts-list', $data);
        }
        $data['spareParts'] = SparePart::select('spare_parts.*','spare_part_categories.name as category')
            ->join('spare_part_categories', 'spare_parts.part_type', '=', 'spare_part_categories.id')
            ->get();

        return view('spareparts.parts-list', $data);
    }

    public function add(){
        $data['inverters']= Inverter::get();
        $data['sparePartCategory'] = SparePartCategory::all();
        return view('spareparts.parts-add',$data);
    }

    public function save(Request $request){
        if ($request->all()) {
            $this->validate($request, [
                'name' => 'required',
                'factory_code' => 'required',
                'part_type' => 'required|not_in:0',
                //'voltage_rating' => 'required',
                //'ampeare_rating' => 'required',
                'sale_price' => 'required',
                //'base_unit' => 'required',
                'pieces' => 'required',
                'part_image' => 'nullable|mimes:jpeg,jpg,png,gif',

            ]);
            $partImageName = "";
            DB::beginTransaction();
            try {
                #----------- inverter image----------------------#
                if ($request->file('part_image')) {
                    $image = $request->file('part_image');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $partImageName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/sparepart'), $partImageName);

                }
                #------------------- insert in database--------------------------------#
                $sparePart = SparePart::create(
                    [
                        'name'           => $request->name,
                        'factory_code'   => $request->factory_code,
                        'part_type'      => $request->part_type,
                        //'voltage_rating' => $request->voltage_rating,
                       // 'ampeare_rating' => $request->ampeare_rating,
                        //'base_unit'       => $request->base_unit,
                        'pieces'          => $request->pieces,
                        'sale_price'      => $request->sale_price,
                        'total_quantity'  => 0,
                        'sold_quantity'   => 0,
                        'user_id'         => Auth::user()->id,
                        'part_image'      => $partImageName,
                        'technical_notes'  => $request->technical_notes
                    ]
                );
                $sparePartId = $sparePart->id;
                //dd($request->inverter_modal);
                #------------------ insert in sparepart model database------------------#
                if($request->inverter_modal){
                   for($i=0;$i<count($request->inverter_modal);$i++){
                        $selectedInverters[] = [
                            'sparepart_id'       => $sparePartId,
                            'inverter_id'        => $request->inverter_modal[$i],
                            'dosage'             => $request->dosage[$i],
                            'plugin_location'    => $request->plugin_location[$i]
                        ];
                    }
                    SparePartModel::insert($selectedInverters);

                }
                DB::commit();
                return redirect('/spareparts-list')->with('status', 'Spare part added successfully');

            } catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/spareparts-list')->with('status', $e);
            }
        }
    }

    public function edit($id){

        $data['inverters']= Inverter::get();
        $data['sparePart'] = SparePart::find($id);
        $data['sparePartModel'] = SparePartModel::select('spare_part_models.id as model_id','spare_part_models.dosage as dosage'
            ,'spare_part_models.plugin_location as plugin_location','inverters.modal_number as model')
            ->join('inverters', 'spare_part_models.inverter_id', '=', 'inverters.id')
            ->where('spare_part_models.sparepart_id',$id)
            ->get();
        $data['sparePartCategory'] = SparePartCategory::all();
        return view('spareparts.parts-edit',$data);

    }
    public function deleteModel($id){
        $sparePartDetail = SparePartModel::find($id);
        $sparePartId = $sparePartDetail->sparepart_id;
        if($sparePartId){
            // Delete spare part model
            SparePartModel::where('id', $id)->delete();

            return redirect('/sparepart-edit/'.$sparePartId)->with('status', 'Modal deleted successfully');
        }
        else{
            return redirect('/sparepart-edit/'.$sparePartId)->with('status', 'Something went wrong');


        }
    }
    public function updateSalePrice(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'sale_price' => 'required|numeric',
        ]);

        $sparePart = SparePart::find($request->id);
        if ($sparePart) {
            $sparePart->sale_price = $request->sale_price;
            $sparePart->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Spare part not found']);
        }
    }


    public function update(Request $request){
        if ($request->all()) {
            $this->validate($request, [
                'name' => 'required',
                'factory_code' => 'required',
                'part_type' => 'required|not_in:0',
                //'voltage_rating' => 'required',
               // 'ampeare_rating' => 'required',
                'sale_price' => 'required',
                //'base_unit' => 'required',
                'pieces' => 'required',
                'part_image' => 'nullable|mimes:jpeg,jpg,png,gif',

            ]);
            $spDetail = SparePart::find($request->recordid);
            $partImageName = $spDetail->part_image;
            DB::beginTransaction();
            try {
                #----------- inverter image----------------------#
                if ($request->file('part_image')) {
                    $image = $request->file('part_image');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $partImageName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/sparepart'), $partImageName);

                }
                $newdata = [
                    'name'           => $request->name,
                    'factory_code'   => $request->factory_code,
                    'part_type'      => $request->part_type,
                    //'voltage_rating' => $request->voltage_rating,
                    //'ampeare_rating' => $request->ampeare_rating,
                    //'base_unit'      => $request->base_unit,
                    'pieces'         => $request->pieces,
                    'sale_price'     => $request->sale_price,
                    'part_image'     => $partImageName,
                    'technical_notes' => $request->technical_notes

                ];

                SparePart::where('id', $request->recordid)->update($newdata);
                #------------------ insert in sparepart model database------------------#
                if($request->inverter_modal){
                    for($i=0;$i<count($request->inverter_modal);$i++){
                        if($request->inverter_modal[$i]!=null && $request->dosage[$i]!=null){
                            $selectedInverters[] = [
                                'sparepart_id'       => $request->recordid,
                                'inverter_id'        => $request->inverter_modal[$i],
                                'dosage'             => $request->dosage[$i],
                                'plugin_location'    => $request->plugin_location[$i],
                            ];
                        }
                    }
                    if(!empty($selectedInverters)){
                        SparePartModel::insert($selectedInverters);

                    }
                }
                DB::commit();
                return redirect('/spareparts-list')->with('status', 'Spare part updated successfully');

            } catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/spareparts-list')->with('status', $e);
            }
        }

    }
}
