<?php


namespace Tests\Feature;


Use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

/**
     * ClassNameTest
     * @group group
     */
class AuthorAdminTest extends TestCase
{
    use RefreshDatabase;
    /** @test  */

    public function test_add_author(){

        $this->withoutExceptionHandling();
        $response = $this->post("/author",[
            "nombre" => "Jorge Fuente",
            "dob" => "25/02/1983",
            "avatarUrl" => "/images/avatar.jpg",
            "nacionalidad" => "Colombiano",
            "historia"=> "muy trabajador"
                    ]);
             $author = Author::first();

        $this->assertCount(1, Author::all());
        $this->assertEquals("Jorge Fuente",        $author->nombre);
        $this->assertEquals("Colombiano",          $author->nacionalidad);
        $this->assertEquals("/images/avatar.jpg",  $author->avatarUrl);
        $this->assertEquals("1983/25/02", $author->dob->format('Y/d/m'));

        //Para verificar la respuesta del servidor -- $response->assertStatus(200);
    }


    public function test_update_author()
    {
            $this->withoutExceptionHandling();
            $this->test_add_author();

            $author = Author::first();

            $this->patch($author->path(), [
                "nombre" => "Egber",
                "historia" => "un hormbre casado",
                "dob" => "27/12/1983"
            ] );

            $author1 = Author::find($author->id);

            $this->assertEquals("Egber", $author1->nombre);
            $this->assertEquals("1983/12/27", $author1->dob->format('Y/m/d'));
    }



}