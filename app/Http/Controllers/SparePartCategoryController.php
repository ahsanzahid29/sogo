<?php

namespace App\Http\Controllers;


use App\Models\SparePart;
use App\Models\SparePartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SparePartCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(){
        $data['category'] = SparePartCategory::all();
        $data['count'] = 1;
        return view('category.sparepartcategory.category-list',$data);
    }
    public function save(Request $request){

        if ($request->all()) {
            $this->validate($request, [
                'name' => 'required|unique:spare_part_categories',
            ]);

            DB::beginTransaction();

            try {
                $inserted = DB::table('spare_part_categories')->insert([
                    'name' => $request->name,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                DB::commit();

                if ($inserted) {
                    \Log::info("Record inserted successfully.");
                    return redirect('/product-category-list')->with('status', 'Category added');
                } else {
                    \Log::error("Record insertion failed.");
                    return redirect('/spareparts-category-list')->with('status', 'Category insertion failed.');
                }
            } catch (\Exception $e) {
                DB::rollback();
                \Log::error("Error inserting record: " . $e->getMessage());
                return redirect('/spareparts-category-list')->with('status', 'Error: ' . $e->getMessage());
            }
        }

        
    }
    public function edit($id){
        $data['specificCategory'] = SparePartCategory::find($id);
        $data['category'] = SparePartCategory::all();
        $data['count'] = 1;
        return view('category.sparepartcategory.edit-category-list',$data);

    }

    public function update(Request $request){
        if ($request->all()) {
            $this->validate($request, [
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $newdata = [
                    'name'      => $request->name,
                ];

                SparePartCategory::where('id', $request->recordid)->update($newdata);
                DB::commit();
                return redirect('/spareparts-category-list')->with('status', 'Category updated');
            }
            catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/spareparts-category-list')->with('status', $e);
            }
        }
    }

    public function delete($id){

        $category = SparePartCategory::find($id);
        if($category){
            $product = SparePart::where('part_type',$id)->first();
            if($product){
                return redirect('/spareparts-category-list')->with('status', 'Category cannot be deleted. Spare Part found');
            }
            SparePartCategory::where('id', $id)->delete();
            return redirect('/spareparts-category-list')->with('status', 'Category deleted');


        }
        return redirect('/spareparts-category-list')->with('status', 'No record found');


    }
}
