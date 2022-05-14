<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        if(auth()->check()){
            return view('Admin.slider.index');
        }
        else{
            return redirect()->to('ad/login');
        }
    }
    public function getList()
    {
        if(auth()->check()){
            return Slider::orderBy('id','DESC')->get();
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
            return Slider::findOrFail($id);
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
            $tb = DB::table('sliders')->where('name', $request->name)->first();
            $slider = Slider::findOrFail($id);
            if(!empty ($tb)){
                if($tb->name != $slider->name){
                    $array = array(
                        "status" => "F",
                    );
                    return json_encode($array);
                }
            }
            $slider->name = $request->name;
            if(!empty($request->path)){
                $path = $this->saveImgBase64($request->path, 'slider');
                $slider->image_path = 'storage/slider/'.$path;
            }
            $slider->save();
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
        $tb = DB::table('sliders')->where('name', $request->name)->first();
        if (empty ($tb) ) {
            $path = $this->saveImgBase64($request->path, 'slider');
            $slider = new Slider();
            $slider->name = $request->name;
            $slider->image_path = 'storage/slider/'.$path;
            $slider->save();
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
            $slider = Slider::findOrFail($id);
            $slider->delete();
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
