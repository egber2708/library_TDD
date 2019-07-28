<?php


namespace Tests\Feature;


use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


    /**
     * ClassNameTest
     * @group group
     */
class BookreservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test  */
    public function a_book_can_be_add_to_library(){

        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            "author" => "Kevin",
            "title" => "lo que el viento se llevo",
            "Editorial" => "lunaRoja"
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function test_title_empty()
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
            $this->withoutExceptionHandling();
    
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
     
     
}
