<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\trademark;
use Illuminate\Http\Request;
use App\Models\discount;
use App\Models\discount_product;
use App\Models\discount_trademark;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiscountController extends Controller
{
    public function index(){
        if(auth()->check()){
            $trademarks = trademark::orderBy('id','DESC')->get();
            $products = Product::orderBy('id','DESC')->get();
            return view('Admin.discount',['trademarks'=>$trademarks,'products'=>$products]);
        }
        else{
            return redirect()->to('ad/login');
        }
    }
    public function getList(){
        if(auth()->check()){
            $discounts = discount::orderBy('id','DESC')->get();
            $discountOut = [];
            foreach ($discounts as $discount){
                if($discount->stateApply == 0){
                    $discount->stateApply = 'Tất cả sản phẩm';
                }
                else if($discount->stateApply == 1){
                    $discount->stateApply = 'Nhóm thương hiệu';
                }
                else{
                    $discount->stateApply = 'Nhóm sản phẩm';
                }
                if($discount->optionPrice == 0){
                    $discount->optionPrice = $discount->price.'%';
                }
                else{
                    $discount->optionPrice = number_format($discount->price).'đ';
                }
                if($discount->optionQuantity == 0){
                    $discount->optionQuantity = $discount->quantity;
                }
                else{
                    $discount->optionQuantity = 'Không giới hạn';
                }
                if($discount->optionDate == 0){
                    $discount->optionDate = $discount->dateStart.' -> '.$discount->dateEnd;
                }
                else{
                    $discount->optionDate = 'Không giới hạn';
                }
                $discountOut[] = $discount;
            }
            return $discountOut;
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
            $discount = discount::findOrFail($id);
            DB::table('discount_products')->where('discount_id', $id)->delete();
            DB::table('discount_trademarks')->where('discount_id', $id)->delete();
            $discount->delete();
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
            $tb = DB::table('discounts')->where('code', $request->discount['code'])->first();
            if (empty ($tb) ) {
                $discount = new discount();
                $discount->name = $request->discount['name'];
                $discount->optionDate = $request->optionDate;
                $discount->optionPrice = $request->optionPrice;
                $discount->optionQuantity = $request->optionQuantity;
                $discount->stateApply = $request->stateApply;
                $discount->code = $request->discount['code'];
                $discount->price = $request->discount['price'];
                if($request->optionDate == 0){
                    $pieces = explode("-", $request->discount['date']);
                    $discount->dateStart = Carbon::create($pieces[0]);
                    $discount->dateEnd = Carbon::create($pieces[1]);
                }
                if($request->optionQuantity == 0){
                    $discount->quantity = $request->discount['quantity'];
                }
                $discount->save();
                $disAdd = DB::table('discounts')->where('code', $request->discount['code'])->first();
                if($request->stateApply == 1){
                    foreach ($request->discount['trademarks'] as $trademark){
                        $trademark_item = [
                            'product_id' => $trademark,
                            'discount_id' => $disAdd->id,
                        ];
                        discount_trademark::create($trademark_item);
                    }
                }
                if($request->stateApply == 2){
                    foreach ($request->discount['products'] as $product){
                        $product_item = [
                            'product_id' => $product,
                            'discount_id' => $disAdd->id,
                        ];
                        discount_product::create($product_item);
                    }
                }
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
        catch (\Exception $e){
            return $e;
        }
    }
}
