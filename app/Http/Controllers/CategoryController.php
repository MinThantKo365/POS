<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
// use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function categoryList(){
        $category = category::orderBy('created_at','asc')->paginate(3);
        return view('admin.category.list',compact('category'));
    }

    public function create(Request $request){
        $this->checkValidation($request);

        category::create([
            'name' => $request->categoryName ,
            'created_at' => Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);

        // dd($request->categoryName);
        Alert::success('Category Create', 'Category Created Successful!!!');
        return back();
        // return back()->with('alert','Category Created Successful!!!');
    }

    public function delete($id){
        category::find($id)->delete();

        return back()->with('alert','Category Delete Successful!!!');
    }

    public function updatePage($id){
        $category = category::where('id',$id)->first();
        return view('admin.category.update',compact('category'));
    }

    public function update($id, Request $request){

    }
    public function checkValidation(Request $request){
        $request -> validate([
            'categoryName' => 'required'
        ],[
            'categoryName.required' => 'Category name is required.'
        ]);
    }
}
