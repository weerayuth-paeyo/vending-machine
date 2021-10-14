<?php

namespace App\Http\Controllers;

use App\Models\MoneyAmount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendingController extends Controller
{
    //
    public function index(){
        return view('vending.index');
    }

    public function postProduct(){
        $products = Product::get();
        return response()->json([
            "data" => $products,
            "message" => "ดึงข้อมูลสำเร็จ",
            "status" => "success"
        ]);
    }

    public function postBuyProduct(Request $request){
        if ($request->isMethod('post')){
            if ($request->input('id')){
                $product = Product::find($request->input('id'));
                $product->amount = $product->amount-1;
                $product->save();
            }else{
                return response()->json([
                    "message" => "ไม่พบรายการสินค้า",
                    "status" => "failed"
                ]);
            }
        }
        return response()->json([
            "data" => $product,
            "message" => "ซื้อสิ้นค้าสำเร็จ",
            "status" => "success"
        ]);
    }

    public function stockProduct($id){
            if ($id){
                $product = Product::find($id);
                $product->amount = $product->amount-1;
                $product->save();
            }else{
                return response()->json([
                    "message" => "ไม่พบรายการสินค้า",
                    "status" => "failed"
                ]);
            }
        return response()->json([
            "data" => $product,
            "message" => "ซื้อสิ้นค้าสำเร็จ",
            "status" => "success"
        ]);
    }

    public function checkMoney(Request $request){
        if ($request->isMethod('post')){
            $checkMoney = $request->input('checkMoney');
            $calCheckMoney = $checkMoney;
            $array = array();
            $useAmount=null;

            $moneys = DB::select('
                                    select
                                        money_type.id,
                                        money_type.name,
                                        money_type.value,
                                        money_amount.moneyType_id,
                                        (money_amount.amount*money_type.value) as totalMoney,
                                        IF(money_amount.amount <> 0 , money_amount.amount, 0) as amount
                                    from money_type 
                                    left join money_amount on money_type.id = money_amount.moneyType_id 
                                    where money_amount.amount is not null 
                                    AND (money_amount.amount*money_type.value) <> 0  
                                    ORDER BY money_amount.moneyType_id DESC
                                ');
            if ($moneys){
                foreach ($moneys as $index => $money){
                    if ($money->value <= $checkMoney){
                        if ($money->amount > 1){
                            for ($i=1; $i <= $money->amount; $i++){
                                if ($calCheckMoney == 0 || $calCheckMoney-$money->value < 0){
                                    break;
                                }else{
                                    $calCheckMoney = $calCheckMoney-$money->value;
                                }
                            }

                            array_push($array,[
                                "id" => $money->id,
                                "value" => $money->value,
                                "useAmount" => $i-1,
                                "firstCal" => $calCheckMoney,
                                "sumMoney" => $money->value*($i-1),
                            ]);

                            if ($calCheckMoney == 0){
                                $this->stockProduct($request->input('id'));
                                foreach ($array as $datum){
                                    $moneyAmount = MoneyAmount::where('moneyType_id',$datum['id'])->first();
                                    if ($moneyAmount){
                                        $moneyAmount->amount = $moneyAmount->amount-$datum['useAmount'];
                                        $moneyAmount->save();
                                    }
                                }
                                return response()->json([
                                    "data" => $array,
                                    "message" => "มีเงินทอนเพียงพอ",
                                    "status" => "success"
                                ]);
                            }
                        }else{
                            if ($calCheckMoney-$money->value == 0){
                                $calCheckMoney = $calCheckMoney-$money->value;
                                array_push($array,[
                                    "id" => $money->id,
                                    "value" => $money->value,
                                    "useAmount" => 1,
                                    "firstCal" => $calCheckMoney,
                                    "sumMoney" => $money->value*1,
                                ]);
                                $this->stockProduct($request->input('id'));
                                foreach ($array as $datum){
                                    $moneyAmount = MoneyAmount::where('moneyType_id',$datum['id'])->first();
                                    if ($moneyAmount){
                                        $moneyAmount->amount = $moneyAmount->amount-$datum['useAmount'];
                                        $moneyAmount->save();
                                    }
                                }
                                return response()->json([
                                    "data" => $array,
                                    "message" => "มีเงินทอนเพียงพอ",
                                    "status" => "success"
                                ]);
                            }
                        }
                    }
                }
                if ($calCheckMoney == 0){
                    $this->stockProduct($request->input('id'));
                    foreach ($array as $datum){
                        $moneyAmount = MoneyAmount::where('moneyType_id',$datum['id'])->first();
                        if ($moneyAmount){
                            $moneyAmount->amount = $moneyAmount->amount-$datum['useAmount'];
                            $moneyAmount->save();
                        }
                    }
                    return response()->json([
                        "data" => $array,
                        "message" => "มีเงินทอนเพียงพอ",
                        "status" => "success"
                    ]);
                }else{
                    return response()->json([
                        "data" => $array,
                        "message" => "มีเงินทอนไม่เพียงพอ ยอดเงินทอนไม่ลงตัว",
                        "status" => "failed"
                    ]);
                }
            }else{
                return response()->json([
                    "data" => "",
                    "message" => "มีเงินทอนไม่เพียงพอ หรือ ไม่มีเงินในตู้หยอดเหรียญ",
                    "status" => "failed"
                ]);
            }
        }
    }
}
