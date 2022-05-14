<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\trademark;
use App\Models\ProductImage;
use App\Models\Slider;
use App\Models\ProductOption;
use App\Models\discount;
use App\Models\discount_product;
use App\Models\discount_trademark;
session_start();

class HomeController extends Controller
{
    public $htmlCategories = '<li class="list-group-item clearfix"><a ng-click="searchCategory(0)" style="text-transform: none"><span>Tất cả sản phẩm</span></a></li>';
    public $category = [];
    public function index()
    {
        $htmlCategory = $this->categoryRecusive(0,'');
        $trademarks = trademark::orderBy('id','ASC')->get();
        $sliders = Slider::orderBy('id','DESC')->get();
        $products = Product::all()->sortByDesc("visit")->take(10)->where('status','true');
        $productComment = Product::all()->sortByDesc("comment")->where('status','true')->take(10);
        $productsOut = [];
        foreach($products as $product)
        {
            $imagePaths = $product->images;
            $product->options;
            foreach($imagePaths as $imagePath)
            {
                if(strpos($imagePath->image_path,'productMain') != false){
                    $product->image_path = $imagePath->image_path;
                    break;
                }
            }
            $productsOut[] =  $product;
        }
        $productsOutComment = [];
        foreach($productComment as $Comment)
        {
            $imagePaths = $Comment->images;
            $Comment->options;
            foreach($imagePaths as $imagePath)
            {
                if(strpos($imagePath->image_path,'productMain') != false){
                    $Comment->image_path = $imagePath->image_path;
                    break;
                }
            }
            $productsOutComment[] =  $Comment;
        }
        return view('User.home',['trademarks' => $trademarks,'products' => $productsOut,'htmlCategory' => $htmlCategory,'sliders'=>$sliders,'productComment'=>$productsOutComment]);
    }
    public function categoryRecusive($id,$text){
        $categories = Category::all();
        foreach ($categories as $value){
            if($value['parent_id'] == $id){
                $this->htmlCategories .= '<li class="list-group-item clearfix"><a ng-click="searchCategory('.$value['id'].')" style="text-transform: none"><span>'.$text.$value['name'].'</span></a></li>';
                $this->categoryRecusive($value['id'],$text.'-');
            }
        }
        return $this->htmlCategories;
    }
    public function listProductCategory($id){
        if($id == 0){
            return $this->getList();
        }
        else{
            $this->category[] = Category::findOrFail($id);
            $this->getChildrenCategory($id);
            $productsOut = [];
            foreach ($this->category as $ct){
                $products = Product::all()->where('status','true')->where('category_id',$ct->id);
                foreach($products as $product)
                {
                    $imagePaths = $product->images;
                    $product->options;
                    foreach($imagePaths as $imagePath)
                    {
                        if(strpos($imagePath->image_path,'productMain') != false){
                            $product->image_path = $imagePath->image_path;
                            break;
                        }
                    }
                    $productsOut[] =  $product;
                }
            }
            $array = array(
                "products" => $productsOut
            );
            return json_encode($array);
        }
    }
    public function listProductPrice($priceStart,$priceEnd){
        $options = ProductOption::all()->where('price_sale', '>=', $priceStart)->where('price_sale', '<=', $priceEnd);
        $products = Product::all()->where('status','true');
        foreach($products as $product)
        {
            $imagePaths = $product->images;
            $product->options;
            foreach($imagePaths as $imagePath)
            {
                if(strpos($imagePath->image_path,'productMain') != false){
                    $product->image_path = $imagePath->image_path;
                    break;
                }
            }
        }
        $productsOut = [];
        foreach ($options as $op){
            foreach ($products as $prd){
                if($prd->id == $op->product_id){
                    if(!in_array($prd, $productsOut)){
                        $productsOut[] =  $prd;
                    }
                }
            }
        }
        $array = array(
            "products" => $productsOut
        );
        return json_encode($array);
    }
    public function getChildrenCategory($id){
        $categories = Category::all();
        foreach ($categories as $value){
            if($value['parent_id'] == $id){
                $this->category[] = $value;
                $this->getChildrenCategory($value['id']);
            }
        }
    }
    public function listProductTrademark($id){
        if($id == 0){
            return $this->getList();
        }
        else{
            $products = Product::all()->where('status','true')->where('trademark_id',$id);
            $productsOut = [];
            foreach($products as $product)
            {
                $imagePaths = $product->images;
                $product->options;
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
    }
    public function getList(){
        $products = Product::all()->sortByDesc("id")->where('status','true');
        $productsOut = [];
        foreach($products as $product)
        {
            $imagePaths = $product->images;
            $product->options;
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
    public function getCart(){
        if(!empty($_SESSION["cart"])){
            return $_SESSION["cart"];
        }
        else{
            return [];
        }
    }
    public function deleteCode($id){
        for ($i = 0; $i < count($_SESSION["code"]); $i++){
            if($_SESSION["code"][$i]->id == $id){
                array_splice($_SESSION["code"], $i, 1);
                return $_SESSION["code"];
            }
        }
    }
}
