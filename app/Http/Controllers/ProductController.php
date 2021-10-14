<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        if ($user->role_id == 1){
            return view('be.product.index');
        }else{
            return redirect(route('product.get.index'));
        }
    }

    public function edit(Request $request, $id = null){
        $product = new Product();
        if ($id){
            $product = Product::find($id);
        }
        if ($request->isMethod('POST')){
            $product->name = $request->input('productName');
            $product->price = $request->input('price');
            $product->amount = $request->input('amount');
            $product->save();

            return redirect()->route('Admin::product.get.index');
        }

        $user = Auth::user();
        if ($user->role_id == 1){
            return view('be.product.edit',compact('id','product'));
        }else{
            return redirect(route('product.get.index'));
        }
        }
    public function delete(Request $request){
        if ($request->isMethod('post')){
            $product = Product::find($request->input('id'));
            $deleteProduct = Product::find($request->input('id'))->delete();
        }
        return response()->json([
            "code" => 200,
            "data" => $product,
            "message" => "Success."
        ],200);
    }

    public function dataTable(){
        $products = Product::get();
        return DataTables::of($products)->addIndexColumn()->toJson();
    }
}
