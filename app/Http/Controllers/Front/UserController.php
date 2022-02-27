<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function showUserName(){
        return 'moath';
    }

    public function getIndex(){

//        $obj = new \stdClass();
//        $obj -> name = 'moath';
//        $obj -> id = 500;

        $data = [];
        return view('welcome',compact('data'));
    }
}
