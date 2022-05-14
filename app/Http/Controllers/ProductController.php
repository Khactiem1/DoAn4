<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class ProductController extends Controller
{
    public function index()
    {
        if(auth()->check()){
            return view('Admin.product.index');
        }
        else{
            return redirect()->to('ad/login');
        }
    }

    public function getList()
    {
        if(auth()->check()){
            $products = Product::orderBy('id','DESC')->get();
            $productsOut = [];
            foreach($products as $product)
            {
                $product->categoryName = $product->category->name;
                $product->trademarkName = $product->trademark->name;
                $imagePaths = $product->images;
                foreach($imagePaths as $imagePath)
                {
                    if(strpos($imagePath->image_path,'productMain') != false){
                        $product->image_path = $imagePath->image_path;
                       break;
                    }
                }
                $productsOut[] =  $product;
            }
            $array = array(
                "products" => $productsOut
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
    public function getEdit($id){
        if (!file_exists('images/product/edit/'.auth()->id().'/productMain')) {
            \File::makeDirectory(public_path('images/product/edit/'.auth()->id().'/productMain'), 0775, true);
            \File::makeDirectory(public_path('images/product/edit/'.auth()->id().'/product'), 0775, true);
        }
        else{
            $imageMain = \File::allFiles(public_path('images/product/edit/'.auth()->id().'/productMain'));
            if(!empty($imageMain)){
                $tbImageMain = DB::table('product_images')->where('image_path', 'images/product/edit/'.auth()->id().'/productMain/'.$imageMain[0]->getFilename())->first();
                $explode_fullpath = explode('/', $tbImageMain->image_path);
                rename($tbImageMain->image_path, 'storeImage/product/productMain/'.$explode_fullpath[count($explode_fullpath) - 1]);
                $productImageMain = ProductImage::findOrFail($tbImageMain->id);
                $productImageMain->image_path = 'storeImage/product/productMain/'.$explode_fullpath[count($explode_fullpath) - 1];
                $productImageMain->save();
            }
            $images = \File::allFiles(public_path('images/product/edit/'.auth()->id().'/product'));
            foreach ($images as $image){
                $tbImage = DB::table('product_images')->where('image_path', 'images/product/edit/'.auth()->id().'/product/'.$image->getFilename())->first();
                $explode_fullpath = explode('/', $tbImage->image_path);
                rename($tbImage->image_path, 'storeImage/product/product/'.$explode_fullpath[count($explode_fullpath) - 1]);
                $productImage = ProductImage::findOrFail($tbImage->id);
                $productImage->image_path = 'storeImage/product/product/'.$explode_fullpath[count($explode_fullpath) - 1];
                $productImage->save();
            }
        }
        $product = Product::findOrFail($id);
        $image = DB::table('product_images')->where('product_id', $id)->get();
        $option = DB::table('product_options')->where('product_id', $id)->get();
        $category = Category::findOrFail($product->category_id);
        foreach ($image as $img){
            if(strpos($img->image_path,'edit') != false){
                break;
            }
            $explode_fullpath = explode('/', $img->image_path);
            $newFile = '';
            if(strpos($img->image_path,'productMain') != false){
                $newFile = 'images/product/edit/'.auth()->id().'/productMain/'.$explode_fullpath[count($explode_fullpath) - 1];
                rename($img->image_path, $newFile);
            }
            else{
                $newFile = 'images/product/edit/'.auth()->id().'/product/'.$explode_fullpath[count($explode_fullpath) - 1];
                rename($img->image_path, $newFile);
            }
            $imagePath = ProductImage::findOrFail($img->id);
            $imagePath->image_path = $newFile;
            $imagePath->save();
        }
        $array = array(
            "product" => $product,
            "option" => $option,
            "category" => $category,
            "image" => $this->fetchImageProductEdit(),
        );
        return json_encode($array);
    }
    public function fetchImageProductEdit(){
        $output = '<div class="row" id="imageProductOption" style="justify-content: center">';
        $imageMain = \File::allFiles(public_path('images/product/edit/'.auth()->id().'/productMain'));
        $output .= '
                <div class="img-load" align="center">
                    <img src="'.asset('images/product/edit/'.auth()->id().'/productMain/' . $imageMain[0]->getFilename()).'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                </div>
                ';
        $images = \File::allFiles(public_path('images/product/edit/'.auth()->id().'/product'));
        foreach($images as $image)
        {
            $output .= '
                    <div class="img-load" align="center">
                        <img src="'.asset('images/product/edit/'.auth()->id().'/product/' . $image->getFilename()).'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                        <button title="Cài làm ảnh chính" type="button" class="btn btn-link editSetImageMain" id="'.$image->getFilename().'"><i class="tio-visible-outlined mr-1"></i></button>
                        <button title="Xoá ảnh này" type="button" class="btn btn-link editRemove_image" id="'.$image->getFilename().'"><i class="tio-delete-outlined dropdown-item-icon"></i></button>
                    </div>
                ';
        }
        $output .= '</div>';
        return $output;
    }
    public function uploadEdit(Request $request){
        $imageMain = \File::allFiles(public_path('images/product/edit/'.auth()->id().'/productMain'));
        $tbImageMain = DB::table('product_images')->where('image_path', 'images/product/edit/'.auth()->id().'/productMain/'.$imageMain[0]->getFilename())->first();
        $image = $request->file('file');
        $imageName = time() . '.' . $image->extension();
        $productImage = new ProductImage();
        $productImage->image_path = 'images/product/edit/'.auth()->id().'/product/'.$imageName;
        $productImage->product_id = $tbImageMain->product_id;
        $productImage->save();
        $image->move(public_path('images/product/edit/'.auth()->id().'/product'), $imageName);
        return response()->json(['success' => $imageName]);
    }

    public function deleteImageProductEdit(Request $request){
        if($request->get('name'))
        {
            $tbImage = DB::table('product_images')->where('image_path', 'images/product/edit/'.auth()->id().'/product/'.$request->get('name'))->first();
            $productImage = ProductImage::findOrFail($tbImage->id);
            $productImage->delete();
            \File::delete(public_path('images/product/edit/'.auth()->id().'/product/'. $request->get('name')));
        }
    }

    public function setImageProductMain(Request $request){
        if($request->get('name'))
        {
            try {
                $imageMain = \File::allFiles(public_path('images/product/edit/'.auth()->id().'/productMain'));
                $tbImageMain = DB::table('product_images')->where('image_path', 'images/product/edit/'.auth()->id().'/productMain/'.$imageMain[0]->getFilename())->first();
                $tbImage = DB::table('product_images')->where('image_path', 'images/product/edit/'.auth()->id().'/product/'.$request->get('name'))->first();
                $productImageMain = ProductImage::findOrFail($tbImageMain->id);
                $productImageMain->image_path = 'images/product/edit/'.auth()->id().'/product/'.$imageMain[0]->getFilename();
                $productImageMain->save();
                $productImage = ProductImage::findOrFail($tbImage->id);
                $productImage->image_path = 'images/product/edit/'.auth()->id().'/productMain/'.$request->get('name');
                $productImage->save();
                $imageMain = \File::allFiles(public_path('images/product/edit/'.auth()->id().'/productMain'));
                rename('images/product/edit/'.auth()->id().'/productMain/'.$imageMain[0]->getFilename(), 'images/product/edit/'.auth()->id().'/product/'.$imageMain[0]->getFilename());
                rename('images/product/edit/'.auth()->id().'/product/'.$request->get('name'), 'images/product/edit/'.auth()->id().'/productMain/'.$request->get('name'));
            }
            catch (\Exception $exception){
                return $exception;
            }
        }
    }
    public function postEdit(Request $request ,$id){
        try {
            DB::beginTransaction();
            $tb = DB::table('products')->where('name', $request->name)->first();
            $Product = Product::findOrFail($id);
            if(!empty ($tb)){
                if($tb->name != $Product->name){
                    $array = array(
                        "status" => "F",
                    );
                    return json_encode($array);
                }
            }
            //Xoá hết img và option cũ
            DB::table('product_options')->where('product_id', $id)->delete();
            DB::table('product_images')->where('product_id', $id)->delete();
            // End
            $dataProductEdit = [
                'name' => $request->name,
                'status' => $request->status,
                'connect' => $request->connect,
                'weight' => $request->weight,
                'battery' => $request->battery,
                'promotion' => $request->promotion,
                'category_id' => $request->category_id,
                'trademark_id' => $request->trademark_id,
                'description' => $request->description,
            ];
            $Product->update($dataProductEdit);
            $images = \File::allFiles(public_path('images/product/edit/'.auth()->id().'/product'));
            foreach($images as $image)
            {
                rename('images/product/edit/'.auth()->id().'/product/'.$image->getFilename(), 'storeImage/product/product/'. $image->getFilename());
                $dataProductImageAdd = [
                    'image_path' => 'storeImage/product/product/'. $image->getFilename()
                ];
                $Product->images()->create($dataProductImageAdd);
            }
            $imageMain = \File::allFiles(public_path('images/product/edit/'.auth()->id().'/productMain'));
            rename('images/product/edit/'.auth()->id().'/productMain/'.$imageMain[0]->getFilename(), 'storeImage/product/productMain/'. $imageMain[0]->getFilename());
            $dataProductImageAdd = [
                'image_path' => 'storeImage/product/productMain/'. $imageMain[0]->getFilename()
            ];
            $Product->images()->create($dataProductImageAdd);
            foreach($request->productOption as $option)
            {
                $dataProductOptionAdd = [
                    'CPU' => $option['CPU'],
                    'RAM' => $option['RAM'],
                    'display' => $option['display'],
                    'VGA' => $option['VGA'],
                    'ROM' => $option['ROM'],
                    'color' => $option['color'],
                    'price' => $option['price'],
                    'price_sale' => $option['price_sale'],
                ];
                $Product->options()->create($dataProductOptionAdd);
            }
            $array = array(
                "status" => "T",
            );
            DB::commit();
            return json_encode($array);
        }
        catch (\Exception $exception){
            DB::rollBack();
            Log::error('Message: '.$exception->getMessage().' Line: '.$exception->getLine());
        }
    }
    public function getDelete($id){
        if(auth()->check()){
            $Product = Product::findOrFail($id);
            $productImages = DB::table('product_images')->where('product_id', $id)->get();
            foreach ($productImages as $productImage){
                \File::delete(public_path($productImage->image_path));
            }
            DB::table('product_options')->where('product_id', $id)->delete();
            DB::table('product_images')->where('product_id', $id)->delete();
            $Product->delete();
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
    public function getAdd(Request $request){
        try {
            DB::beginTransaction();
            $tb = DB::table('products')->where('name', $request->name)->first();
            if(empty ($tb)){
                $dataProductAdd = [
                    'name' => $request->name,
                    'status' => $request->status,
                    'connect' => $request->connect,
                    'weight' => $request->weight,
                    'battery' => $request->battery,
                    'promotion' => $request->promotion,
                    'category_id' => $request->category_id,
                    'trademark_id' => $request->trademark_id,
                    'description' => $request->description,
                ];
                $Product = Product::create($dataProductAdd);
                if (file_exists('images/product/add/'.auth()->id().'/productMain')) {
                    $images = \File::allFiles(public_path('images/product/add/'.auth()->id().'/product'));
                    foreach($images as $image)
                    {
                        rename('images/product/add/'.auth()->id().'/product/'.$image->getFilename(), 'storeImage/product/product/'. $image->getFilename());
                        $dataProductImageAdd = [
                            'image_path' => 'storeImage/product/product/'. $image->getFilename()
                        ];
                        $Product->images()->create($dataProductImageAdd);
                    }
                    $imageMain = \File::allFiles(public_path('images/product/add/'.auth()->id().'/productMain'));
                    rename('images/product/add/'.auth()->id().'/productMain/'.$imageMain[0]->getFilename(), 'storeImage/product/productMain/'. $imageMain[0]->getFilename());
                    $dataProductImageAdd = [
                        'image_path' => 'storeImage/product/productMain/'. $imageMain[0]->getFilename()
                    ];
                    $Product->images()->create($dataProductImageAdd);
                }
                foreach($request->productOption as $option)
                {
                    $dataProductOptionAdd = [
                        'CPU' => $option['CPU'],
                        'RAM' => $option['RAM'],
                        'display' => $option['display'],
                        'VGA' => $option['VGA'],
                        'ROM' => $option['ROM'],
                        'color' => $option['color'],
                        'price' => $option['price'],
                        'price_sale' => $option['price_sale'],
                    ];
                    $Product->options()->create($dataProductOptionAdd);
                }
                $array = array(
                    "status" => "T",
                );
                DB::commit();
                return json_encode($array);
            }
            else{
                $array = array(
                    "status" => "F",
                );
                return json_encode($array);
            }
        }
        catch (\Exception $exception){
            DB::rollBack();
            Log::error('Message: '.$exception->getMessage().' Line: '.$exception->getLine());
        }
    }
}
