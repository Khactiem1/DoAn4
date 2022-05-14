<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    public function index()
    {
        if(auth()->check()){
            return view('Admin.category.index');
        }
        else{
            return redirect()->to('ad/login');
        }
        //Auth::logout();
    }

    public function getList()
    {
        if(auth()->check()){
            return Category::orderBy('id','DESC')->get();
        }
        else{
            $array = array(
                "status" => "Login",
            );
            return json_encode($array);
        }
    }
    public function getAdd(Request $request)
    {
        if(auth()->check()){
            $tb = DB::table('categories')->where('name', $request->name)->first();
            if (empty ($tb) ) {
                $Category = new Category();
                $Category->name = $request->name;
                $Category->parent_id = $request->parent_id;
                $Category->save();
                $array = array(
                    "status" => "T",
                );
                return json_encode($array);
            }
            else{
                $array = array(
                    "status" => "F",
                );
                return json_encode($array);
            }
        }
        else{
            $array = array(
                "status" => "Login",
            );
            return json_encode($array);
        }
    }
    public function getEdit($id){
        if(auth()->check()){
            return Category::findOrFail($id);
        }
        else{
            $array = array(
                "status" => "Login",
            );
            return json_encode($array);
        }
    }
    public function postEdit(Request $request ,$id){
        if(auth()->check()){
            $tb = DB::table('categories')->where('name', $request->name)->first();
            $Category = Category::findOrFail($id);
            if(!empty ($tb)){
                if($tb->name != $Category->name){
                    $array = array(
                        "status" => "F",
                    );
                    return json_encode($array);
                }
            }
            $Category->name = $request->name;
            $Category->parent_id = $request->parent_id;
            $Category->save();
            $array = array(
                "status" => "T",
            );
            return json_encode($array);
        }
        else{
            $array = array(
                "status" => "Login",
            );
            return json_encode($array);
        }
    }
    public function getDelete($id){
        if(auth()->check()){
            $tb = DB::table('categories')->where('parent_id', $id)->first();
            $tb2 = DB::table('products')->where('category_id', $id)->first();
            if (empty ($tb) ) {
                if(empty($tb2)){
                    $Category = Category::findOrFail($id);
                    $Category->delete();
                    $array = array(
                        "status" => "T",
                    );
                    return json_encode($array);
                }
                else{
                    $array = array(
                        "status" => "F",
                    );
                    return json_encode($array);
                }
            }
            else{
                $array = array(
                    "status" => "parent",
                );
                return json_encode($array);
            }
        }
        else{
            $array = array(
                "status" => "Login",
            );
            return json_encode($array);
        }
    }
}
