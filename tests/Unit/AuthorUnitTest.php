<?php

namespace Tests\Unit;
use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorUnitTest extends TestCase
{
    use RefreshDatabase;
    /**@test */
    public function test_add_author_only_name()
    {
        Author::firstOrCreate(["nombre"=>"Egber Insignares Alzate"]);
        Author::firstOrCreate(["nombre"=>"Egber Insignares Alzate"]);
        Author::firstOrCreate(["nombre"=>"Egber"]);
        $this->assertCount(2, Author::all());
        $this->assertEquals(2, Author::find(2)->id);
        Author::truncate();
    }
}
