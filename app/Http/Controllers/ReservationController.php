<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Book;

class ReservationController extends Controller
{
    //


    public  function store(Book $book){
        try {
            $book->checkOut(Auth::user());
        } catch (\Exception $e) {
            return response(["book_id"=>"Book already out"], 404);
        }
        
    }

    public  function update(Book $book){

        try {
            $book->checkIn();
        } catch (\Exception $e) {
            return response(["book_id"=>"Book already check in"], 404);
        }

    }
}
