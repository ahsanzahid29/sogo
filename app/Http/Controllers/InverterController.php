<?php

namespace App\Http\Controllers;

use App\Models\Inverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InverterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('checkrole');
    }
    public function index(){
        $data['inverters'] = Inverter::all();
        $data['count'] =1;
        $data['role'] = Auth::user()->role_id;
        return view('inverters.inverter-list', $data);
    }

    public function add(){
        return view('inverters.inverter-add');
    }

    public function save(Request $request){
        if ($request->all()) {
            $this->validate($request, [
               'inverter_image' => 'required|mimes:jpeg,jpg,png,gif',
               'product_catalog' => 'required|mimes:pdf',
               'product_manual' => 'required|mimes:pdf',

            ]);
            $productCatalogName='';
            $productManaualName='';
            $troubleshootGuideName='';
            $inverterImageName='';

            DB::beginTransaction();
            try {
                // upload files first
                #----------- inverter image----------------------#
                if ($request->file('inverter_image')) {
                    $image = $request->file('inverter_image');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $inverterImageName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/inverters'), $inverterImageName);

                }
                #----------- product catalog ----------------------#
                if ($request->file('product_catalog')) {
                    $image = $request->file('product_catalog');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $productCatalogName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/invertercatalog'), $productCatalogName);

                }
                #----------- product manual catalog ----------------------#
                if ($request->file('product_manual')) {
                    $image = $request->file('product_manual');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $productManaualName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/productmanaual'), $productManaualName);

                }
                #----------- product troubleshoot guide ----------------------#
                if ($request->file('troubleshoot_guide')) {
                    $image = $request->file('troubleshoot_guide');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $troubleshootGuideName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/troubleshootguide'), $troubleshootGuideName);

                }

                #------------------- insert in database--------------------------------#
                $inverter = Inverter::create(
                    [
                        'inverter_name'      => $request->inverter_name,
                        'inverter_packaging' => $request->inverter_packaging,
                        'no_of_pieces' => $request->no_of_pieces ? $request->no_of_pieces: '' ,
                        'brand' => $request->brand,
                        'category' => $request->category,
                        'modal_number' => $request->modal_number,
                        'product_warranty' => $request->product_warranty,
                        'service_warranty' => $request->service_warranty,
                        'warranty_lag'=> $request->warranty_lag,
                        'product_catalog'=> $productCatalogName ? $productCatalogName : null,
                        'product_manual'=> $productManaualName ? $productManaualName : null,
                        'troubleshoot_guide'=> $troubleshootGuideName ? $troubleshootGuideName : null,
                        'inverter_image'=> $inverterImageName ? $inverterImageName : null,
                        'total_quantity'=> 0,
                        'sold_quantity'=> 0,
                        'user_id'=> Auth::user()->id,
                    ]
                );
                DB::commit();

                return redirect('/inverters-list')->with('status', 'Inverter added successfully');
            }
            catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/inverters-list')->with('status', $e);
            }

        }
    }

    public function edit($id){
       $inverter = Inverter::find($id);
       if($inverter){
           return view('inverters.inverter-edit', compact('inverter'));

       }
       else{
           return redirect('/inverters-list');
       }

    }
    public function update(Request $request){
        if ($request->all()) {
            $this->validate($request, [
                'inverter_image' => 'nullable|mimes:jpeg,jpg,png,gif',
                'product_catalog' => 'nullable|mimes:pdf',
                'product_manual' => 'nullable|mimes:pdf',

            ]);
            // get previous detail in case of image and files
            $oldDetail = Inverter::find($request->recordid);
            $productCatalogName='';
            $productManaualName='';
            $troubleshootGuideName='';
            $inverterImageName='';


            DB::beginTransaction();
            try {
                // upload files first
                #----------- inverter image----------------------#
                if ($request->file('inverter_image')) {
                    $image = $request->file('inverter_image');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $inverterImageName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/inverters'), $inverterImageName);

                }
                #----------- product catalog ----------------------#
                if ($request->file('product_catalog')) {
                    $image = $request->file('product_catalog');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $productCatalogName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/invertercatalog'), $productCatalogName);

                }
                #----------- product manual catalog ----------------------#
                if ($request->file('product_manual')) {
                    $image = $request->file('product_manual');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $productManaualName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/productmanaual'), $productManaualName);

                }
                #----------- product troubleshoot guide ----------------------#
                if ($request->file('troubleshoot_guide')) {
                    $image = $request->file('troubleshoot_guide');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $troubleshootGuideName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/troubleshootguide'), $troubleshootGuideName);

                }

                #------------------- update in database--------------------------------#

                $newdata = [
                    'inverter_name'      => $request->inverter_name,
                    'inverter_packaging' => $request->inverter_packaging,
                    'no_of_pieces' => $request->no_of_pieces,
                    'brand' => $request->brand,
                    'category' => $request->category,
                    'modal_number' => $request->modal_number,
                    'product_warranty' => $request->product_warranty,
                    'service_warranty' => $request->service_warranty,
                    'warranty_lag'=> $request->warranty_lag,
                    'product_catalog'=> $productCatalogName ? $productCatalogName : $oldDetail->product_catalog,
                    'product_manual'=> $productManaualName ? $productManaualName : $oldDetail->product_manual,
                    'troubleshoot_guide'=> $troubleshootGuideName ? $troubleshootGuideName : $oldDetail->troubleshoot_guide,
                    'inverter_image'=> $inverterImageName ? $inverterImageName : $oldDetail->inverter_image,

                ];

                Inverter::where('id', $request->recordid)->update($newdata);
                DB::commit();

                return redirect('/inverters-list')->with('status', 'Inverter updated successfully');
            }
            catch (\Exception $e) {
                DB::rollback();
                // Redirect to inverter page with an error message
                return redirect('/inverters-list')->with('status', $e);
            }

        }

    }
}
