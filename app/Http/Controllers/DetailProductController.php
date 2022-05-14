<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\trademark;
use App\Models\ProductImage;
use App\Models\ProductOption;
use App\Models\discount;
use App\Models\discount_product;
use App\Models\discount_trademark;
use Carbon\Carbon;
use mysql_xdevapi\Exception;

session_start();

class cart{
    public $product,$option,$quality;
}

class DetailProductController extends Controller
{
    public $category = [];
    public function detailProduct($id){
        $product = Product::findOrFail($id);
        $productComment = $this->listProductCategory($product->category->id,$product->id);
        $product->visit++;
        $product->save();
        $imagePaths = $product->images;
        foreach($imagePaths as $imagePath)
        {
            if(strpos($imagePath->image_path,'productMain') != false){
                $product->image_path = $imagePath->image_path;
                break;
            }
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
        $trademarks = trademark::orderBy('id','ASC')->get();
        return view('User.detailProduct',['trademarks' => $trademarks,'product'=>$product,'productComment'=>$productsOutComment]);
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
    public function listProductCategory($id,$product_id){
        $this->category[] = Category::findOrFail($id);
        $this->getChildrenCategory($id);
        $productsOut = [];
        foreach ($this->category as $ct){
            if(count($productsOut) >= 10){
                break;
            }
            $products = Product::all()->sortByDesc("visit")->where('status','true')->where('category_id',$ct->id);
            foreach($products as $product)
            {
                if($product_id == $product->id){
                    continue;
                }
                if(count($productsOut) >= 10){
                    break;
                }
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
        return $productsOut;
    }

    public function optionProduct($id){
        return ProductOption::findOrFail($id);
    }
    public function addCardDetail($id,$option){
        //session_unset();
        if(!empty($_SESSION["cart"])){
            for ($i = 0; $i < count($_SESSION["cart"]); $i++){
                if($_SESSION["cart"][$i]->product->id == $id && $_SESSION["cart"][$i]->option->id == $option){
                    $_SESSION["cart"][$i]->quality++;
                    return '++';
                }
            }
        }
        $product =  Product::findOrFail($id);
        $imagePaths = $product->images;
        foreach($imagePaths as $imagePath)
        {
            if(strpos($imagePath->image_path,'productMain') != false){
                $product->image_path = $imagePath->image_path;
                break;
            }
        }
        $productOption = ProductOption::findOrFail($option);
        $card = new cart();
        $card->product = $product;
        $card->option = $productOption;
        $card->quality = 1;
        $_SESSION["cart"][] = $card;
        return 'T';
    }
    public function deleteCardDetail($id,$option){
        for ($i = 0; $i < count($_SESSION["cart"]); $i++){
            if($_SESSION["cart"][$i]->product->id == $id && $_SESSION["cart"][$i]->option->id == $option){
                array_splice($_SESSION["cart"], $i, 1);
                return 'T';
            }
        }
    }
    public function downCardDetail($id,$option){
        for ($i = 0; $i < count($_SESSION["cart"]); $i++){
            if($_SESSION["cart"][$i]->product->id == $id && $_SESSION["cart"][$i]->option->id == $option){
                if($_SESSION["cart"][$i]->quality == 1){
                    array_splice($_SESSION["cart"], $i, 1);
                    return 'T';
                }
                else{
                    $_SESSION["cart"][$i]->quality--;
                    return '--';
                }
            }
        }
    }
    public function getSaleCode($code){
        $discountGet = DB::table('discounts')->where('code', $code)->first();
        if(!empty($discountGet)){
            $discount = discount::findOrFail($discountGet->id);
            foreach ($_SESSION["code"] as $dis){
                if($code == $dis->code){
                    return 'C'; // đã tồn tại
                }
            }
            if($discount->optionDate == 0){
                if($discount->dateStart > Carbon::now() || $discount->dateEnd < Carbon::now()){
                    return 'H'; //Hết hạn sd
                }
            }
            if($discount->optionQuantity == 0){
                if($discount->quantity <= 0){
                    return '0'; // hết số lượng ưu đãi
                }
            }
            $_SESSION["code"][] = $discount;
            return $_SESSION['code'];
        }
        else{
            return 'F'; // ko tìm thấy
        }
    }


    public function getCode(){
        if(!empty($_SESSION["code"]) && !empty($_SESSION["cart"])){
            $price_sale = 0;
            foreach ($_SESSION["code"] as $discount){
                if($discount->optionDate == 0){
                    if($discount->dateStart > Carbon::now() || $discount->dateEnd < Carbon::now()){
                        continue; //Hết hạn sd
                    }
                }
                if($discount->optionQuantity == 0){
                    if($discount->quantity <= 0){
                        continue;
                        // hết số lượng ưu đãi
                    }
                }
                if($discount->stateApply == 0){
                    foreach ($_SESSION["cart"] as $cart){
                        if($discount->optionPrice == 0){
                            $price_sale += $cart->option->price_sale * $cart->quality * ($discount->price / 100);
                        }
                        if($discount->optionPrice == 1){
                            if($cart->option->price_sale * $cart->quality <= $discount->price){
                                $price_sale += $cart->option->price_sale * $cart->quality;
                            }
                            else{
                                $price_sale += $discount->price;
                            }
                        }
                    }
                }
                else if($discount->stateApply == 1){
                    foreach ($_SESSION["cart"] as $cart){
                        $trademark_id = DB::table('discount_trademarks')->where('discount_id', $discount->id)->where('product_id',$cart->product->trademark_id)->first();
                        if(!empty($trademark_id)){
                            if($discount->optionPrice == 0){
                                $price_sale += $cart->option->price_sale * $cart->quality * ($discount->price / 100);
                            }
                            if($discount->optionPrice == 1){
                                if($cart->option->price_sale * $cart->quality <= $discount->price){
                                    $price_sale += $cart->option->price_sale * $cart->quality;
                                }
                                else{
                                    $price_sale += $discount->price;
                                }
                            }
                        }
                    }
                }
                else if($discount->stateApply == 2){
                    foreach ($_SESSION["cart"] as $cart){
                        $product_id = DB::table('discount_products')->where('discount_id', $discount->id)->where('product_id',$cart->product->id)->first();
                        if(!empty($product_id)){
                            if($discount->optionPrice == 0){
                                $price_sale += $cart->option->price_sale * $cart->quality * ($discount->price / 100);
                            }
                            if($discount->optionPrice == 1){
                                if($cart->option->price_sale * $cart->quality <= $discount->price){
                                    $price_sale += $cart->option->price_sale * $cart->quality;
                                }
                                else{
                                    $price_sale += $discount->price;
                                }
                            }
                        }
                    }
                }
            }
            $array = array(
                "discount" => $_SESSION["code"],
                "priceSale" => $price_sale,
            );
            return json_encode($array);
        }
        else{
            return [];
        }
    }
}
