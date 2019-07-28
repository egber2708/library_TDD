<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
class BooksController extends Controller
{
    //
    public function store()
    {
        Book::create($this->validateRequest());
    }

    public function update(Book $book){
        $book->update($this->validateRequest());
    }


    public function destroy($book){
        $book1 = Book::find($book);
        $book1->delete();
        // Generating Redirects...
        return redirect('/');
       
    }



    protected function validateRequest(){
        return request()->validate([
            'title'=>"required",
            'author'=>"required",
        ]);

    }




}
