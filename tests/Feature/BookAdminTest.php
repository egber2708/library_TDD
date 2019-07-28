<?php


namespace Tests\Feature;


use App\Book;
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

        $response = $this->post('/books', [
            "author" => "Kevin",
            "title" => "lo que el viento se llevo",
            "Editorial" => "lunaRoja"
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function test_add_Book_title_empty()
    {

        $response = $this->post('/books', [
            "author" => "",
            "title" => "",
            "Editorial" => "lunaRoja"
        ]);
        $this->assertEmpty( Book::all());
        $response->assertSessionHasErrors("title");
    }
 

        /** @test */
        public function test_update()
        {    
            $this->post('/books', [
                "author" => "Julio",
                "title" => "10 millas de viajes sobre el agua",
                "Editorial" => "lunaRoja"
            ]);

            $book = Book::first();
            
            $response = $this->patch('/books/'. $book->id, [
                "title" => "casi 10 millas",
                "author" => "mario",
            ]);
            
            $this->assertEquals("casi 10 millas", Book::first()->title );
            $this->assertEquals("mario", Book::first()->author );
           
        }
     
       /** @test */
       public function test_update_all_Empty()
       {    
           $this->post('/books', [
               "author" => "Julio",
               "title" => "10 millas de viajes sobre el agua",
               "Editorial" => "lunaRoja"
           ]);

           $book = Book::first();
           
           $response = $this->patch('/books/'. $book->id, [
               "title" => "   ",
               "author"=> " "

           ]);

           $response->assertSessionHasErrors("title");
           $response->assertSessionHasErrors("author");
          
       }

        /** @test */
        public function test_destroy()
        {    
            $this->withoutExceptionHandling();
            $this->post('/books', [
                "author" => "Julio",
                "title" => "10 millas de viajes sobre el agua",
                "Editorial" => "lunaRoja"
            ]);

            $book = Book::first();
            $this->assertCount(1, Book::all());

            // Muy buena alternativa para no volver a agregar nada  a la base de datos.
            // $this->test_add_book();
            // $book= Book::first();
            
            $response = $this->delete('/books/'. $book->id);

            $this->assertCount(0, Book::all());
            // in case redirection is needed... 
            $response->assertRedirect('/');
        }






     
}
