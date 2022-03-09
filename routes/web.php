<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/test1', function () {
    return ' welcome';
});
///////////////////////////////////////////
// route parameters
Route::get('/test2/{id}', function ($id) {
    //required parameter
    return $id;
});

Route::get('/test3/{id?}', function () {
    // optional parameter
    return ' welcome';
});
/////////////////////////////////////////////////
// route name
Route::get('/show-number/{id}', function ($id) {
    //required parameter
    return $id;
})->name('a');

Route::get('/show-string/{id?}', function () {
    return 'Moath Reyad';
})->name('b');
////////////////////////////////////////////////
/*
//namespace
Route::namespace('App\Http\Controllers\Front')->group(function(){

   // All routes only access controller or methods in folder name Front
    Route::get('users','UserController@showUserName');

});
*/
/////////////////////////////////////////

/*
Route::group(['prefix' =>'users'],function(){

    //set of routes

    Route::get('/',function(){
       return 'work';
    });
    Route::get('show','UserController@showUserName');
    Route::delete('delete','UserController@showUserName');
    Route::get('edit','UserController@showUserName');
    Route::put('update','UserController@showUserName');
});
*/
//////////////////////////////////////////
/*
//The middleware Check if the person has access or not
Route::get('check',function(){
    return 'middleware';
}) -> middleware('auth');
*/
///////////////////////////////////////////

//Route::get('second','App\Http\Controllers\Admin\SecondController@showString');

Route::group(['namespace' => 'App\Http\Controllers\Admin'], function () {
    Route::get('second', 'SecondController@showString0')->middleware('auth');
    Route::get('second1', 'SecondController@showString1');
    Route::get('second2', 'SecondController@showString2');
    Route::get('second3', 'SecondController@showString3');
    //
    //
});

Route::get('login', function () {
    return 'must be login to access this rout';
})->name('login');


///////////////////////////////////////////

// Middleware
/*
 // The first syntax
Route::get('users','App\Http\Controllers\Front\UserController@index')-> middleware('auth');

// The second syntax
Route::group(['middleware' => 'auth'],function (){
   Route::get('users','App\Http\Controllers\Front\UserController@index');
});
*/
//////////////////////////////////
//Route::resource('news','App\Http\Controllers\NewsController');
///////////////////////////////////
/*
Route::get('index','App\Http\Controllers\Front\UserController@getIndex');
*/


Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

Route::get('/redirect/{service}', 'App\Http\Controllers\SocialiteController@redirect');

//Route::get('/callback/{service}','App\Http\Controllers\SocialiteController@callback');


Route::get('fillable', '\App\Http\Controllers\CrudController@getOffers');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::group(['prefix' => 'offers'], function () {
        //Route::get('store','\App\Http\Controllers\CrudController@store');
        Route::get('create', '\App\Http\Controllers\CrudController@create');
        Route::post('store', '\App\Http\Controllers\CrudController@store')->name('offerStore');

        Route::get('edit/{offer_id}', '\App\Http\Controllers\CrudController@editOffer');
        Route::post('update/{offer_id}', '\App\Http\Controllers\CrudController@updateOffer')->name('offerUpdate');
        Route::get('delete/{offer_id}', '\App\Http\Controllers\CrudController@delete')->name('offerDelete');
        Route::get('all', '\App\Http\Controllers\CrudController@getAllOffers')->name('offerAll');

    });
    Route::get('youtube', '\App\Http\Controllers\CrudController@getVideo')->middleware('auth');
});


################################################ Begin Ajax Routes ##################################################################
Route::group(['prefix' => 'ajax-offers'], function () {
    Route::get('create', '\App\Http\Controllers\OfferController@create');
    Route::post('store', '\App\Http\Controllers\OfferController@store')->name('ajaxOffersStore');
    Route::get('all','\App\Http\Controllers\OfferController@all')->name('ajaxOfferAll');
    Route::get('edit/{offer_id}', '\App\Http\Controllers\OfferController@edit')->name('ajaxOfferEdit');
    Route::post('update', '\App\Http\Controllers\OfferController@update')->name('ajaxOfferUpdate');
    Route::post('delete','\App\Http\Controllers\OfferController@delete')->name('ajaxOfferDelete');

});
################################################ End Ajax Routes ##################################################################


################################################ Begin Authentication && Guards ###################################################
Route::group(['middleware'=>'CheckAge'],function (){
    Route::get('adults','\App\Http\Controllers\Auth\CustomAuthController@adult')->name('adults');
});
Route::get('default',function (){return 'Not found';})->name('notAdult'); // test route

Route::get('site','\App\Http\Controllers\Auth\CustomAuthController@site')->middleware('auth:web')->name('site');
Route::get('admin','\App\Http\Controllers\Auth\CustomAuthController@admin')->middleware('auth:admin')->name('admin');

Route::get('admin/login','\App\Http\Controllers\Auth\CustomAuthController@adminLogin')->name('adminLogin');
Route::post('admin/login','\App\Http\Controllers\Auth\CustomAuthController@checkAdminLogin')->name('saveAdminLogin');

################################################ End Authentication && Guards #####################################################





