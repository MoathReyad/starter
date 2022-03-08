<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Traits\offersTrait;
use http\Env\Response;
use Illuminate\Http\Request;
use LaravelLocalization;

class OfferController extends Controller
{
    use offersTrait;

    public function create()
    {
        // View form to add this offer
        return view('ajaxoffers.create');
    }


    public function store(Request $request)
    {
        // Save offer into DB using Ajax

        // Save photo into file.
        $file_name = $this->saveImages($request->photo, 'images/offers');

        // insert table offers in database
        $offer = Offer::create([
            'photo' => $file_name,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
        ]);
        if ($offer)
            return response()->json([
                'status' => true,
                'msg' => 'تم الحفظ بنجاح',
            ]);
        else
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ الرجاء المحاولة مجددا',
            ]);
    }

    public function all()
    {
        $offers = Offer::select('id',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'price',
            'details_' . LaravelLocalization::getCurrentLocale() . ' as details',
            'photo'
        )->get();
        return view('ajaxoffers.all', compact('offers'));
    }

    public function delete(Request $request)
    {
        // check the offer exist in database
        $offer = Offer::find($request->id);
        if (!$offer)
            return response()->json([
                'status' => false,
                'msg' => 'العنصر غير موجود',
            ]);
        // Delete offer from DB
        $offer->delete();

        return response()->json([
            'status' => true,
            'msg' => 'تم الحذف بنجاح',
            'id' => $request->id
        ]);
    }

    public function edit(Request $request)
    {

        $offer = Offer::find($request->offer_id); // search in given table id only
        if (!$offer)
            return response()->json([
                'status' => false,
                'msg' => 'هذا العرض غير موجود',
            ]);

        $offer = Offer::select('id', 'name_ar', 'name_en', 'price', 'details_ar', 'details_en')->find($request->offer_id);

        return view('ajaxoffers.edit', compact('offer'));
    }

    public function update(Request $request){
        //Validate in offerRequest

        //Check if the offer exist
        $offer = Offer::select()->find($request->offer_id);
        if(!$offer)
            return response()->json([
                'status' => false,
                'msg' => 'هذا العرض غير موجود',
            ]);

        //Update data
        $offer->update($request->all()); // Update all the data that I entered in the form

        return response()->json([
            'status' => true,
            'msg' => 'تم التحديث بنجاح',
        ]);
    }
}
