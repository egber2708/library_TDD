<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Author;
use App\User;
use App\Reservation;
class Book extends Model
{
    //turn off all the variable to the laravel...
    protected $guarded = [];


    public function SetAuthorIdAttribute($value){
        $this->attributes['author_id'] = (Author::firstOrCreate(["nombre" => $value]))->id;
    }

    public function checkOut(User $user){
       
        $reservation = Reservation::where('book_id', $this->id)->where('check_in' , null)->first();

        if ( empty($reservation)){
           $this->reservations()->create([
                'user_id'=> $user->id,
                'check_out' => now(),
                'observation' => null,
            ]);
        }else{
           throw new \Exception();
        }

    
    }

    public function checkIn(){
        $reservation = $this->reservations()->where('book_id', $this->id)->where('check_in' , null)->first();
        if ( !empty($reservation)){
            $reservation->update(["check_in"=>now()]);
        }else{
           throw new \Exception();
        }
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }



}
