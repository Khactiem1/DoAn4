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


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::prefix('ad')->group(function () {
    Route::get('login',['uses' => 'AdminController@loginAdmin']);
    Route::post('login',['uses' => 'AdminController@postLoginAdmin']);
    Route::get('logout',['uses' => 'AdminController@logoutAdmin'])->name('ad.logout');

//  UpLoad nhiều hình ảnh
    Route::post('dropzone/upload', 'AdminController@upload')->name('dropzone.upload');
    Route::post('dropzone/uploadEdit', 'ProductController@uploadEdit')->name('dropzone.uploadEdit');
    Route::get('dropzone/fetch', 'AdminController@fetch')->name('dropzone.fetch');
    Route::get('dropzone/fetchEdit', 'ProductController@fetchImageProductEdit')->name('dropzone.fetchEdit');
    Route::get('dropzone/delete', 'AdminController@delete')->name('dropzone.delete');
    Route::get('dropzone/deleteEdit', 'ProductController@deleteImageProductEdit')->name('dropzone.deleteEdit');
    Route::get('dropzone/setImageMain', 'AdminController@setImageMain')->name('dropzone.setImageMain');
    Route::get('dropzone/setImageProductMain', 'ProductController@setImageProductMain')->name('dropzone.setImageProductMain');

    Route::prefix('categories')->group(function () {
        Route::get('/', [
            'as' => 'categories.index',
            'uses' => 'CategoryController@index'
        ]);
        Route::get('list',['uses' => 'CategoryController@getList']);
        Route::post('add',['uses' => 'CategoryController@getAdd']);
        Route::get('edit/{id}',['uses' => 'CategoryController@getEdit']);
        Route::post('edit/{id}',['uses' => 'CategoryController@postEdit']);
        Route::get('delete/{id}',['uses' => 'CategoryController@getDelete']);
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [
            'as' => 'product.index',
            'uses' => 'ProductController@index'
        ]);
        Route::post('add',['uses' => 'ProductController@getAdd']);
        Route::get('list',['uses' => 'ProductController@getList']);
        Route::get('edit/{id}',['uses' => 'ProductController@getEdit']);
        Route::post('edit/{id}',['uses' => 'ProductController@postEdit']);
        Route::get('delete/{id}',['uses' => 'ProductController@getDelete']);
    });

    Route::prefix('trademark')->group(function () {
        Route::get('/', [
            'as' => 'trademark.index',
            'uses' => 'TrademarkController@index'
        ]);
        Route::get('list',['uses' => 'TrademarkController@getList']);
        Route::post('add',['uses' => 'TrademarkController@getAdd']);
        Route::get('edit/{id}',['uses' => 'TrademarkController@getEdit']);
        Route::post('edit/{id}',['uses' => 'TrademarkController@postEdit']);
        Route::get('delete/{id}',['uses' => 'TrademarkController@getDelete']);
    });

    Route::prefix('slider')->group(function () {
        Route::get('/', [
            'as' => 'slider.index',
            'uses' => 'SliderController@index'
        ]);
        Route::get('list',['uses' => 'SliderController@getList']);
        Route::post('add',['uses' => 'SliderController@getAdd']);
        Route::get('edit/{id}',['uses' => 'SliderController@getEdit']);
        Route::post('edit/{id}',['uses' => 'SliderController@postEdit']);
        Route::get('delete/{id}',['uses' => 'SliderController@getDelete']);
    });

    Route::prefix('discount')->group(function () {
        Route::get('/', [
            'as' => 'discount.index',
            'uses' => 'DiscountController@index'
        ]);
        Route::get('list',['uses' => 'DiscountController@getList']);
        Route::post('add',['uses' => 'DiscountController@getAdd']);
        Route::get('delete/{id}',['uses' => 'DiscountController@getDelete']);
    });
});


Route::get('/', ['uses' => 'HomeController@index']);
Route::get('/product/{id}', ['uses' => 'DetailProductController@detailProduct']);
Route::get('/cart', ['uses' => 'CartController@Cart']);
Route::prefix('data')->group(function () {
    Route::get('list',['uses' => 'HomeController@getList']);
    Route::get('listProductTrademark/{id}',['uses' => 'HomeController@listProductTrademark']);
    Route::get('listProductCategory/{id}',['uses' => 'HomeController@listProductCategory']);
    Route::get('listProductPrice/{priceStart}/{priceEnd}',['uses' => 'HomeController@listProductPrice']);
    Route::get('optionProduct/{id}',['uses' => 'DetailProductController@optionProduct']);
    Route::get('addCardDetail/{id}/{option}',['uses' => 'DetailProductController@addCardDetail']);
    Route::get('deleteCardDetail/{id}/{option}',['uses' => 'DetailProductController@deleteCardDetail']);
    Route::get('downCardDetail/{id}/{option}',['uses' => 'DetailProductController@downCardDetail']);
    Route::get('getSaleCode/{code}',['uses' => 'DetailProductController@getSaleCode']);
    Route::get('getCart',['uses' => 'HomeController@getCart']);
    Route::get('getCode',['uses' => 'DetailProductController@getCode']);
    Route::get('deleteCode/{id}',['uses' => 'HomeController@deleteCode']);
});
