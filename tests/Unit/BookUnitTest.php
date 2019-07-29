<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Author;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;


class BookUnitTest extends TestCase
{
  
    use  RefreshDatabase;
 
   
   public function test_update_book_create_author(){
        
    $this->withoutExceptionHandling();
    Book::create([
        "title" => "10 millas de viajes sobre el agua",            
        "author_id" => "Julio Rojas",
        "editorial" => "lunaRoja"
        ]);
    
    $this->assertCount(1, Author::all());
    $book = Book::first();
    $book->update([
        "title" => "10 millas de viajes sobre el agua",            
        "author_id" => "Mario Losas", ]);
    
    $this->assertCount(2, Author::all() ); 
    $this->assertEquals("Mario Losas", Author::find(2)->nombre);
    Author::truncate();
    Book::truncate();
    }


    public function test_create_book_add_author(){
        Book::Create([
            "title" => "10 millas de viajes sobre el agua",            
            "author_id" => "Julio Rojas",
            "editorial" => "lunaRoja"
        ]);
        $author = Author::all();
        //dd($author);
        
        $this->assertCount(1, Author::all());           
        $this->assertEquals(1, Book::first()->author_id);

    }





}
