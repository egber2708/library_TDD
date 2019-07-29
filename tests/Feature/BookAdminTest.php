<?php


namespace Tests\Feature;


use App\Book;
use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


    /**
     * ClassNameTest
     * @group group
     */
class BookAdminTest extends TestCase
{
    use RefreshDatabase;
    /** @test  */
    public function test_add_book(){

        $this->withoutExceptionHandling();
        $response = $this->post('/books', $this->data());

        $this->assertCount(1, Book::all());
        $this->assertEquals("lunaRoja", Book::first()->editorial);
        $response->assertOk();
        Author::truncate();
        Book::truncate();
    }

    /** @test */
    public function test_add1_Book_title_empty()
    {
        $response = $this->post('/books', array_merge($this->data(), ['title'=>'']));
        $this->assertEmpty( Book::all());
        $response->assertSessionHasErrors("title");
    }
 

        /** @test */
        public function test_update_book_create_author()
        {    
            $this->post('/books', $this->data());
            $book = Book::first();            
            $response = $this->patch('/books/'. $book->id, [
                "title" => "casi 10 millas",
                "author_id" => "mario",
            ]);

            $this->assertEquals("casi 10 millas", Book::first()->title );
            $this->assertEquals( 2,    Book::first()->author_id );
            $this->assertEquals("mario", Author::find(2)->nombre);
            Author::truncate();
            Book::truncate();
        }



     
       /** @test */
       public function test_update1_all_Empty()
       {    
           $this->post('/books', $this->data());
           $book = Book::first();
           $response = $this->patch('/books/'. $book->id, [
               "title" => "   ",
               "author_id"=> " "
           ]);
           $response->assertSessionHasErrors("title");
           $response->assertSessionHasErrors("author_id");
       }

        /** @test */
        public function test_destroy()
        {    
            $this->withoutExceptionHandling();
            $this->post('/books', $this->data());
            $book = Book::first();
            $this->assertCount(1, Book::all());
            $response = $this->delete('/books/'. $book->id);
            $this->assertCount(0, Book::all());

            // in case redirection is needed... 
            $response->assertRedirect('/');
        }

        

        /** @test */
        public function test_booking_add_author()
        {    
            $this->withoutExceptionHandling();
            $this->post("/books/", $this->data());
            $author= Author::first();
            $book = Book::first();
            $this->assertCount(1, Author::all());
            $this->assertEquals($author->id, $book->author_id);
        }

        
        private function data(){
            return [
                "title" => "10 millas de viajes sobre el agua",            
                "author_id" => "Julio Rojas",
                "editorial" => "lunaRoja"
            ];
        }

     
}
