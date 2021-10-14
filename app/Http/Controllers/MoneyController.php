<?php

namespace App\Http\Controllers;

use App\Models\MoneyAmount;
use App\Models\MoneyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MoneyController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        if ($user->role_id == 1){
            return view('be.money.index');
        }else{
            return redirect(route('product.get.index'));
        }
    }

    public function edit(Request $request, $id = null){

        if ($request->isMethod('POST')){
            if (!$id){
                $id = $request->input('moneyType');
            }
            $moneyTypes = MoneyType::find($id);
            if (!isset($moneyTypes)){
                return redirect()->route('Admin::money.get.index');
            }
            $moneyAmount = MoneyAmount::where('moneyType_id',$moneyTypes->id)->first();
            if (!$moneyAmount){
                $moneyAmount = new MoneyAmount();
                $moneyAmount->moneyType_id = $id;
                $moneyAmount->amount = intval($request->input('amount'));
            }else{
                $moneyAmount = MoneyAmount::where('moneyType_id',$moneyTypes->id)->first();
                $moneyAmount->amount = $moneyAmount->amount + intval($request->input('amount'));
            }
            $moneyAmount->save();
            return redirect()->route('Admin::money.get.index');
        }
        $user = Auth::user();
        if ($user->role_id == 1){
            return view('be.money.edit',compact('id'));
        }else{
            return redirect(route('product.get.index'));
        }
    }
    public function delete(Request $request){
        if ($request->isMethod('post')){
            $moneyType = MoneyType::find($request->input('id'));
            $deleteMoneyAmount = MoneyAmount::where('moneyType_id',$request->input('id'))->delete();
        }
        return response()->json([
            "code" => 200,
            "data" => $moneyType,
            "message" => "Success."
        ],200);
    }

    public function dataTable(){
        $moneyTypes = DB::select( '
                                    select
                                        money_type.id,
                                        money_type.name,
                                        money_amount.moneyType_id,
                                        (money_amount.amount*money_type.value) as totalMoney,
                                        IF(money_amount.amount <> 0 , money_amount.amount, 0) as amount
                                    from money_type 
                                    left join money_amount on money_type.id = money_amount.moneyType_id where money_amount.amount is not null 
                                ');
        return DataTables::of($moneyTypes)->addIndexColumn()->toJson();
    }
}
