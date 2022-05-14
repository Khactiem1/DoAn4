<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\trademark;
use Illuminate\Support\Facades\Storage;

class trademarkController extends Controller
{
    public function index()
    {
        if(auth()->check()){
            return view('Admin.trademark.index');
        }
        else{
            return redirect()->to('ad/login');
        }
    }
    public function getList()
    {
        if(auth()->check()){
            return trademark::orderBy('id','DESC')->get();
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
            return trademark::findOrFail($id);
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
            $tb = DB::table('trademarks')->where('name', $request->name)->first();
            $trademark = trademark::findOrFail($id);
            if(!empty ($tb)){
                if($tb->name != $trademark->name){
                    $array = array(
                        "status" => "F",
                    );
                    return json_encode($array);
                }
            }
            $trademark->name = $request->name;
            if(!empty($request->path)){
                $path = $this->saveImgBase64($request->path, 'trademark');
                $trademark->image_path = 'storage/trademark/'.$path;
            }
            $trademark->save();
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
    public function getAdd(Request $request)
    {
        $tb = DB::table('trademarks')->where('name', $request->name)->first();
        if (empty ($tb) ) {
            $path = $this->saveImgBase64($request->path, 'trademark');
            $trademark = new trademark();
            $trademark->name = $request->name;
            $trademark->image_path = 'storage/trademark/'.$path;
            $trademark->save();
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
    public function getDelete($id){
        if(auth()->check()){
            $tb = DB::table('products')->where('trademark_id', $id)->first();
            if (empty ($tb) ) {
                $Category = trademark::findOrFail($id);
                $Category->delete();
                $array = array(
                    "status" => "T",
                );
                return json_encode($array);
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

    protected function saveImgBase64($param, $folder)
    {
        list($extension, $content) = explode(';', $param);
        $tmpExtension = explode('/', $extension);
        preg_match('/.([0-9]+) /', microtime(), $m);
        $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
        $content = explode(',', $content)[1];
        $storage = Storage::disk('public');

        $checkDirectory = $storage->exists($folder);

        if (!$checkDirectory) {
            $storage->makeDirectory($folder);
        }

        $storage->put($folder . '/' . $fileName, base64_decode($content), 'public');

        return $fileName;
    }
}
