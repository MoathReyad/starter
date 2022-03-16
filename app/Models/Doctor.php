<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table='doctors';
    protected $fillable=['name','title','hospital_id','medical_id','created_at','updated_at'];
    protected $hidden=['created_at','updated_at','pivot'];

    ################################ Begin relations one to many #############################
    public function hospital(){
        return $this->belongsTo('App\Models\Hospital');
    }
    ################################ End relations one to many ###############################

    ################################ Begin relations many to many ############################
    public function services(){
        return $this-> belongsToMany('App\Models\Service','doctor_service','doctor_id','service_id','id','id');
    }
    ################################ End relations many to many ##############################
}
