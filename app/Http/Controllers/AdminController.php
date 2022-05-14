<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginAdmin(){
        //dd(bcrypt('1')); $10$7oEUZwrUh9KKATha.kLuT.cpuM0Zb27Tr0wKSDOoC.xBNVpcsLcSG
        if(auth()->check()){
            return redirect()->to('ad/categories');
        }
        return view('Admin.login');
    }
    public function logoutAdmin(){
        Auth::logout();
        return redirect()->to('ad/login');
    }
    public function postLoginAdmin(Request $request){
        $remember = '';
        if($request->remember == 'true' || $request->remember == 'True'){
            $remember = true;
        }
        else{
            $remember = false;
        }
        if(auth()->attempt([
            'name' => $request->name,
            'password' => $request->password
        ],$remember)){
            return 'ok';
        }
        else{
            return 'F';
        }
    }

    function upload(Request $request)
    {
        if (file_exists('images/product/add/'.auth()->id().'/productMain')) {
            $images = \File::allFiles(public_path('images/product/add/'.auth()->id().'/productMain'));
            if(empty($images)){
                $image = $request->file('file');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('images/product/add/'.auth()->id()).'/productMain', $imageName);
                return response()->json(['success' => $imageName]);
            }
        }
        else{
            $image = $request->file('file');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/product/add/'.auth()->id()).'/productMain', $imageName);
            return response()->json(['success' => $imageName]);
        }
        $image = $request->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images/product/add/'.auth()->id().'/product'), $imageName);
        return response()->json(['success' => $imageName]);
    }

    function fetch()
    {
        if (!file_exists('images/product/add/'.auth()->id().'/productMain')) {
            return '';
        }
        else{
            $check = false;
            $imageMain = \File::allFiles(public_path('images/product/add/'.auth()->id().'/productMain'));
            $output = '<div class="row" id="imageProductOption" style="justify-content: center">';
            if(!empty($imageMain)){
                $check = true;
                $output .= '
                <div class="img-load" align="center">
                    <img src="'.asset('images/product/add/'.auth()->id().'/productMain/' . $imageMain[0]->getFilename()).'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                </div>
                ';
            }
            if (file_exists('images/product/add/'.auth()->id().'/product')) {
                $images = \File::allFiles(public_path('images/product/add/'.auth()->id().'/product'));
                foreach($images as $image)
                {
                    $output .= '
                    <div class="img-load" align="center">
                        <img src="'.asset('images/product/add/'.auth()->id().'/product/' . $image->getFilename()).'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                        <button title="Cài làm ảnh chính" type="button" class="btn btn-link setImageMain" id="'.$image->getFilename().'"><i class="tio-visible-outlined mr-1"></i></button>
                        <button title="Xoá ảnh này" type="button" class="btn btn-link remove_image" id="'.$image->getFilename().'"><i class="tio-delete-outlined dropdown-item-icon"></i></button>
                    </div>
                ';
                }
            }
            $output .= '</div>';
            if($check == false){
                $output = '';
            }
            return $output;
        }
    }

    function delete(Request $request)
    {
        if($request->get('name'))
        {
            \File::delete(public_path('images/product/add/'.auth()->id().'/product/'. $request->get('name')));
        }
    }
    function setImageMain(Request $request)
    {
        if($request->get('name'))
        {
            $imageMain = \File::allFiles(public_path('images/product/add/'.auth()->id().'/productMain'));
            rename('images/product/add/'.auth()->id().'/productMain/'.$imageMain[0]->getFilename(), 'images/product/add/'.auth()->id().'/product/'.$imageMain[0]->getFilename());
            rename('images/product/add/'.auth()->id().'/product/'.$request->get('name'), 'images/product/add/'.auth()->id().'/productMain/'.$request->get('name'));
        }
    }
}
