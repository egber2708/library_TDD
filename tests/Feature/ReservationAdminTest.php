<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;
use App\User;
use App\Reservation;


class ReservationAdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use  RefreshDatabase;
    public function test_reservation_simple_checkout_authorize_user()
    {
        $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $user_authorize = $this->actingAs($user);

        $response =  $user_authorize->post('/reservation_out/'.$book->id);

        $response->assertStatus(200);
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(now(), Reservation::first()->check_out);
        $this->assertNull(Reservation::first()->check_in);
    }

    public function test_reservation_simple_checkin_authorize_user()
    {
        // Es necesario primero hacer el retiro del libro primero.
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $user_authorize = $this->actingAs($user);
        $user_authorize->post('/reservation_out/'.$book->id);

        // ahora construimos el regreso del libro.

        $response = $user_authorize->post('/reservation_in/'.$book->id);

        $response->assertStatus(200);
        $this->assertCount(1, Reservation::all());
        $this->assertEquals(now(), Reservation::first()->check_in);
        $this->assertNotNull(Reservation::first()->check_in);
    }




    public function test_not_register_user_checkout_book(){
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $response =  $this->post('/reservation_out/'.$book->id);
        $response->assertRedirect('/login');
       $this->assertCount(0, Reservation::all());

     }


   public function test_checkin_book_not_authorize_user()
    {
        // Es necesario primero hacer el retiro del libro primero.
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $user_authorize = $this->actingAs($user);
        $user_authorize->post('/reservation_out/'.$book->id);

        $response = $this->post('/reservation_in/'.$book->id);

        $response->assertStatus(200);
        $this->assertCount(1, Reservation::all());
        $this->assertEquals(now(), Reservation::first()->check_in);
        $this->assertNotNull(Reservation::first()->check_in);
    }

    public function test_checkout_same_book_twice()
    {
        // Es necesario primero hacer el retiro del libro primero.
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $user_authorize = $this->actingAs($user);
        $user_authorize->post('/reservation_out/'.$book->id);

        // Realizo un segundo retiro del mismo libro.
        $response = $user_authorize->post('/reservation_out/'.$book->id);

        $response->assertStatus(404); // se devuelve el no valido.. en content esta el msm
        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->check_in);
    }

    public function test_checkin_same_book_twice()
    {
        // Es necesario primero hacer el retiro del libro primero.
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $user_authorize = $this->actingAs($user);
        $user_authorize->post('/reservation_out/'.$book->id);

        // Realizo la entrega del libro.
        $this->post('/reservation_in/'.$book->id);
        // verifico que el libro ya lo entregue
        $this->assertNotNull(Reservation::first()->check_in);

        // intento volver a entregarlo...
        $response =  $this->post('/reservation_in/'.$book->id);
        $response->assertStatus(404); // se devuelve el no valido.. en content esta el msm

        $this->assertCount(1, Reservation::all());
        $this->assertNotNull(Reservation::first()->check_in);
    }





}
