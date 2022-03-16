<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\Phone;
use App\Models\Service;
use App\Models\User;

use Illuminate\Http\Request;

class RelationController extends Controller
{
    ######################### Begin one to one relation method ##############################
    public function hasOneRelation()
    {
        $user = User::with(['phone' => function ($q) {
            $q->select('code', 'phone', 'user_id');
        }])->find(10);

        // return $user->phone->code; // access to code field frome Phone table direct
        //return $user->name; // access to name field direct
        /*
                // Return data from phone table
                $phone = $user->phone;
                return $phone;
        */


        return response()->json($user);
    }

    public function hasOneRelationReverse()
    {
        $phone = Phone::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])->find(1);

        /*
                // Make some attribute visible (Visible on the Function Scale)
                $phone->makeVisible('user_id');

                // Make some attribute hidden (Hidden on the Function Scale)
                $phone->makeHidden('code');
        */
        // $phone ->user; // Return user of this phone number
        return $phone;
    }

    public function getUserHasPhone()
    {

        // Fetch all the data of users who have a phone number in the phone table from the user table
        //$user = User::whereHas('phone')->get();

        // Fetch id and name of users who have a phone number in the phone table from the user table
        $user = User::Select('id', 'name')->whereHas('phone')->get();

        return $user;
    }

    public function getUserWhereHasPhoneWithCondition()
    {
        $user = User::whereHas('phone', function ($q) {
            $q->where('code', '962');
        })->get();
        return $user;
    }

    public function getUserNotHasPhone()
    {
        $user = User::whereDoesntHave('phone')->get(); // whereDoesntHave
        return $user;
    }
    ######################### End one to one relation method ##############################
    #######################################################################################
    #######################################################################################
    ######################### Begin one to many relation method ###########################
    public function getHospitalDoctor()
    {

        $hospital = Hospital::find(1); // Hospital::where('id',1) -> first(); // Hospital::first();

        // $hospital = $hospital->doctors; // return hospital doctor
        // $hospital = Hospital::with('doctors')->find(1); // return hospitals and doctors
        // $hospital = $hospital->name; // return hospital name
        //return response()->json($hospital, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        /*
         * Return names all doctors
        $doctors = $hospital->doctors;
        foreach ($doctors as $doctor){
            echo $doctor->name . "<br>";
        }
        */

        /*
        $doctor = Doctor::find(3);
        $hos = $doctor ->hospital->name;
        return response()->json($hos, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        */

    }

    public function hospitals()
    {
        $hospitals = Hospital::select('id', 'name', 'address')->get();
        return view('doctor.hospitals', compact('hospitals'));
    }

    public function doctors($hospital_id)
    {
        $hospitals = Hospital::find($hospital_id);
        $doctors = $hospitals->doctors;
        return view('doctor.doctors', compact('doctors'));
    }

    // ge all hospitals which must has doctors
    public function hospitalsHasDoctor()
    {
        $hospitals = Hospital::whereHas('doctors')->get();
        return response()->json($hospitals, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function hospitalsHasOnlyMaleDoctor()
    {
        $hospitals = Hospital::whereHas('doctors', function ($q) {
            $q->where('gender', 'male');
        })->get();
        return response()->json($hospitals, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function hospitalsNotHasDoctors()
    {
        $hospitals = Hospital::whereDoesntHave('doctors')->get();
        return response()->json($hospitals, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function deleteHospitals($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        if (!$hospital)
            return abort('404');

        // delete doctors in this hospital
        $hospital -> doctors() -> delete();

        // delete hospital.
        $hospital -> delete();
        return redirect() -> route('hospitalAll');
    }
    ######################### End one to many relation method ################################
    ##########################################################################################
    ##########################################################################################
    ######################### Begin many to many relation method #############################

    public function getDoctorServices(){
        $services = Doctor::find(1);
        return $services -> services;

    }
    public function getServiceDoctors(){
        return $doctor = Service::with(['doctors'=> function ($q){
            $q->select('doctors.id','name','title');
        }]) -> find(1);
    }

    public function getDoctorServicesById($doctor_id){
        $doctor = Doctor::find($doctor_id);
        $services = $doctor->services; // doctor services

        $doctors = Doctor::select('id','name')->get();
        $allServices = Service::select('id','name')->get(); // all DB services

        return view('doctor.services',compact('services','doctors','allServices'));
    }

    public function saveServicesToDoctors(Request $request){
        $doctor = Doctor::find($request->doctor_id);
        if(!$doctor)
            return abort('404');

        // $doctor ->services()->attach($request->services_id); // many to many insert to DB

//        // many to many update data in DB // sync() [VIDEO 87]
//        $doctor ->services()->sync($request->services_id);
        // many to many insert data in DB without repetition // syncWithoutDetaching() [VIDEO 87]
        $doctor ->services()->syncWithoutDetaching($request->services_id);


        return 'success';
    }
    ######################### End many to many relation method ###############################

    ######################### Begin has one through relation method ########################################################

    public function getPatientDoctor(){
        $patient = Patient::find(1);
        $doctor = $patient-> doctor;
        return $doctor;
    }
    ######################### End has one through relation method ########################################################

    ######################### Begin has many through relation method ########################################################

    public function getCountryDoctor(){
//        $country = Country::find(1);
//        $doctors = $country->doctors;
//        return $doctors;
        return $country = Country::with('doctors')->find(1); // country with doctors
    }
    ######################### End has many through relation method ########################################################

}
