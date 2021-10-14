<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        if ($request->isMethod('post')) {
            $email = $request->input('userName');
            $password = $request->input('password');
            if (Auth::attempt(['username' => $email, 'password' => $password])){
                $user = Auth::user();
                if ($user->role_id == 1){
                    return redirect(route('Admin::dashboard'));
                }else{
                    return redirect(route('product.get.index'));
                }
            }
        }
        return view('login');
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect(route('product.get.index'));
    }
}
