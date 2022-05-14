<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\trademark;
use App\Models\discount;
use App\Models\discount_trademark;
use App\Models\discount_product;
use App\Models\ProductImage;
use App\Models\ProductOption;
session_start();

class CartController extends Controller
{
    public function Cart(){
        $trademarks = trademark::orderBy('id','ASC')->get();
        $products = Product::all()->sortByDesc("visit")->take(10)->where('status','true');
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
        return view('User.cart',['trademarks' => $trademarks,'products' => $productsOut]);
    }
}
