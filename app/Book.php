<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Author;

class Book extends Model
{
    //turn off all the variable to the laravel...
    protected $guarded = [];


    public function SetAuthorIdAttribute($value){
        $this->attributes['author_id'] = (Author::firstOrCreate(["nombre" => $value]))->id;
    }




}
