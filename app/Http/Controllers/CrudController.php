<?php

namespace App\Http\Controllers;

use App\Events\VideoViewer;
use App\Http\Requests\offerRequest;
use App\Models\Offer;
use App\Models\Video;
use App\Traits\offersTrait;
use Illuminate\Http\Request;
use LaravelLocalization;
class CrudController extends Controller
{
    use offersTrait;
    // photo
    // Update
    // delete
    // Upload image
    // improve code

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
    public function store(offerRequest $request){
        /*
        //Validate data before insert to database.

        $rules = $this->getRules();
        $messages = $this->getMessages();

        $validate = validator($request->all(), $rules, $messages);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput($request->all());
        }
        */

        // insert
        $file_name = $this->saveImages($request->photo,'images/offers');

        Offer::create([
            'photo'=> $file_name,
            'name_ar' => $request->name_ar,
            'name_en' =>   $request->name_en,
            'price' =>  $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
        ]);
        return redirect()->back()->with(['success'=> 'تم اضافة العرض بنجاح']);
    }
/*
    public function getMessages(){
        return [
            'name.required'=>__('messages.offer name required'),
            'name.unique'=>__('messages.offer name unique'),
            'price.numeric'=>'سعر العرض يجب ان يكون ارقام',
            'price.required'=>'السعر مطلوب',
            'details.required'=>'التفاصيل مطلوبة',
        ];
    }

    public function getRules(){
        return [
            'name'=>'required|max:100|unique:offers,name',
            'price'=>'required|numeric',
            'details'=>'required',
        ];
    }

*/
    public function getAllOffers(){
        $offers =  Offer::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name' ,
            'price',
            'details_'.LaravelLocalization::getCurrentLocale().' as details' ,
            'photo',
        )->get();
        return view('offers.all',compact('offers'));
    }

    public function editOffer($offer_id){
        //Offer::select()
        //Offer::findOrfail($offer_id); //Retrieve the variable from the Database and if it is not present, give me an error

        $offer= Offer::find($offer_id); // search in given table id only
        if(!$offer){
            return redirect()->back();
        }

        $offer = Offer::select('id', 'name_ar', 'name_en', "price", 'details_ar', 'details_en')->find($offer_id);

        return view('offers.edit',compact('offer'));
    }

    public function delete($offer_id){

        // check the offer exist in database
        $offer = Offer::find($offer_id); // Offer::where('id',$$offer_id)->first();
        if(!$offer)
            return redirect()->back()->with(['error'=>__('messages.offer not exist')]);
        // Delete offer
        $offer -> delete();
        return redirect()->route('offerAll')->with(['success'=>__('messages.offer delete successfully')]);



    }

    public function updateOffer(offerRequest  $request, $offer_id){
        //Validate in offerRequest

        //Check if the offer exist
        $offer = Offer::select()->find($offer_id);
        if(!$offer){
            return redirect()->back();
        }

        //Update data
        $offer->update($request->all()); // Update all the data that I entered in the form

        return redirect()->back()->with(['success'=>'تم التعديل بنجاح ']);

        /*
         // Select the data to update
        $offer->update([
            'name_ar'=>$offer->name_ar,
            'name_en'=>$offer->name_en,
            'price'=>$offer->price,
            'details_ar'=>$offer->details_ar,
            'details_en'=>$offer->details_en,
        ]);
        */
    }
    public function getVideo(){

        $video = Video::first();
        event(new VideoViewer($video)); // Fire event
        return view('video')->with('video',$video);
    }

}
