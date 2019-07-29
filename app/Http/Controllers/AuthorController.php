<?php

namespace App\Http\Controllers;
use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store(Request $request){
        $this->evalRequest($request);
        $author = Author::create($request->only(
            "nombre","avatarUrl","nacionalidad","historia","dob"
        )) ;
    }

    public function update(Author $author, Request $request){
        $this->evalRequest($request);
        $author->update($request->all());
    }





    protected function evalRequest(Request $request){
        return  $request->validate([
                "nombre" => "required",
                "dob" => "required",
            ]);
    }
    
}
