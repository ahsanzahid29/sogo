<?php

namespace App\Http\Controllers;

use App\Models\Inverter;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(){

        $data['category'] = ProductCategory::all();
        $data['count'] = 1;
        return view('category.productcategory.category-list',$data);
    }

    public function save(Request $request){

        if ($request->all()) {
            $this->validate($request, [
                'name' => 'required|unique:product_categories',
            ]);
            DB::beginTransaction();
            try {
                DB::table('product_categories')->insert([
                    'name' => $request->name,
                    'created_at' => date('Y-m-d H:i'),

                ]);


                    return redirect('/product-category-list')->with('status', 'Category added');


            }
            catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/product-category-list')->with('status', $e);
            }
        }
    }
    public function edit($id){
        $data['specificCategory'] = ProductCategory::find($id);
        $data['category'] = ProductCategory::all();
        $data['count'] = 1;
        return view('category.productcategory.edit-category-list',$data);

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

                ProductCategory::where('id', $request->recordid)->update($newdata);
                DB::commit();
                return redirect('/product-category-list')->with('status', 'Category updated');
            }
            catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/product-category-list')->with('status', $e);
            }
        }
    }

    public function delete($id){

        $category = ProductCategory::find($id);
        if($category){
            $product = Inverter::where('category',$id)->first();
            if($product){
                return redirect('/product-category-list')->with('status', 'Category cannot be deleted. Inverter found');
            }
            ProductCategory::where('id', $id)->delete();
            return redirect('/product-category-list')->with('status', 'Category deleted');


        }
        return redirect('/product-category-list')->with('status', 'No record found');


    }

}
