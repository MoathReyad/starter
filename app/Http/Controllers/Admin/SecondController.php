<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SecondController extends Controller
{
    // the middleware it will be implemented on all methods inside the controller except showString2
    public function  __construct(){
        $this->middleware('auth')->except('showString2');
    }
    public function showString0(){
        return 'static string0';
    }
    public function showString1(){
        return 'static string1';
    }
    public function showString2(){
        return 'static string2';
    }
    public function showString3(){
        return 'static string3';
    }
}
