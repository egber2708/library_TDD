<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Author extends Model
{
    protected $guarded = [];

    public function path(){
        return '/author/'. $this->id;
    }

    protected $dates = ['dob']; 
    public function setDobAttribute($value){
        $this->attributes['dob'] = Carbon::createFromFormat('d/m/Y', $value);
    }



    

}
