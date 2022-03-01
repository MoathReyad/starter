<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class CrudController extends Controller
{

    public function __construct(){

    }

    public function getOffers(){
        return Offer::select('id', 'name') -> get();
    }

//    public function store(){
//        return Offer::create([
//           'name' => 'offer3',
//           'price' => '20000',
//           'details' => 'offer details',
//        ]);
//    }

    public function create(){
        return view('offers\create');
    }
    public function store(Request $request){
        // validate data before insert to database
        $rules=[
            'name'=>'required|max:100|unique:offers,name',
            'price'=>'required|numeric',
            'details'=>'required',
        ];

        $messages=[
            'name.required'=>__('messages.offer name required'),
            'name.unique'=>__('messages.offer name unique'),
            'price.numeric'=>'سعر العرض يجب ان يكون ارقام',
            'price.required'=>'السعر مطلوب',
            'details.required'=>'التفاصيل مطلوبة',
        ];
        $validate = validator($request->all(), $rules, $messages);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput($request->all());
        }
        // insert
        Offer::create([
            'name'=> $request -> name,
            'price'=> $request -> price,
            'details'=> $request -> details
        ]);
        return redirect()->back()->with(['success'=> 'تم اضافة العرض بنجاح']);
    }
}
