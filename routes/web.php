<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login','AuthController@login')->name('get.login');
Route::post('/login','AuthController@login')->name('post.login');
Route::get('/logout','AuthController@logout')->name('get.logout');

Route::prefix('/product')->group(function (){
    Route::get('/','VendingController@index')->name('product.get.index');
    Route::post('/postProduct','VendingController@postProduct')->name('product.post.postProduct');
    Route::post('/postBuyProduct','VendingController@postBuyProduct')->name('product.post.postBuyProduct');
    Route::post('/checkMoney','VendingController@checkMoney')->name('product.post.checkMoney');
});

Route::group(['middleware' => ['auth.begin']], function () {
    Route::prefix('admin')->group(function (){
        Route::get('/dashboard', function () {
            return '
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
                        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
                    
                    <div class="container">
                        <br>
                        <br>
                        <a class="btn btn-primary" href="../product">ไปยังหน้าขายสินค้า</a>
                        <br>
                        <br>
                        <a class="btn btn-primary" href="./product/index">รายการสินค้า</a>
                        <br>
                        <br>
                        <a class="btn btn-primary" href="./money/index">รายการประเทภเงิน</a>
                
                    </div>
                    ';
        })->name('Admin::dashboard');

        Route::prefix('/product')->group(function (){
            Route::get('/index','ProductController@index')->name('Admin::product.get.index');
            Route::get('/edit/{id?}','ProductController@edit')->name('Admin::product.get.edit');
            Route::post('/edit/{id?}','ProductController@edit')->name('Admin::product.post.edit');
            Route::post('/delete','ProductController@delete')->name('Admin::product.post.delete');
            Route::get('/dataTable','ProductController@dataTable')->name('Admin::product.get.dataTable');
        });

        Route::prefix('/money')->group(function (){
            Route::get('/index','MoneyController@index')->name('Admin::money.get.index');
            Route::get('/edit/{id?}','MoneyController@edit')->name('Admin::money.get.edit');
            Route::post('/edit/{id?}','MoneyController@edit')->name('Admin::money.post.edit');
            Route::post('/delete','MoneyController@delete')->name('Admin::money.post.delete');
            Route::get('/dataTable','MoneyController@dataTable')->name('Admin::money.get.dataTable');
        });
    });
});
