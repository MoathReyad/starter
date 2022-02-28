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

Route::get('/test1',function(){
    return ' welcome';
});
///////////////////////////////////////////
// route parameters
Route::get('/test2/{id}',function($id){
    //required parameter
   return $id;
});

Route::get('/test3/{id?}',function(){
    // optional parameter
   return ' welcome';
});
/////////////////////////////////////////////////
// route name
Route::get('/show-number/{id}',function($id){
    //required parameter
    return $id;
}) -> name('a');

Route::get('/show-string/{id?}',function(){
    return 'Moath Reyad';
}) -> name('b');
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

Route::group(['namespace'=>'App\Http\Controllers\Admin'],function(){
    Route::get('second','SecondController@showString0')-> middleware('auth');
    Route::get('second1','SecondController@showString1');
    Route::get('second2','SecondController@showString2');
    Route::get('second3','SecondController@showString3');
    //
    //
});

Route::get('login',function (){
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



Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

Route::get('/redirect/{service}','App\Http\Controllers\SocialiteController@redirect');

//Route::get('/callback/{service}','App\Http\Controllers\SocialiteController@callback');



