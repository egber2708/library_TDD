<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Book;
use App\Reservation;
use Mockery\Exception;

class ReservationAdminTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use  RefreshDatabase;
    public function test_reservation_check_out()
    {
        $book =  factory(Book::class)->create();
        $user =  factory(User::class)->create();

        $book->checkOut($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(now(), Reservation::first()->check_out);
        $this->assertNull(Reservation::first()->check_in);

    }

    public function test_reservation1_check_in(){
        $book =  factory(Book::class)->create();
        $user =  factory(User::class)->create();
        $book->checkOut($user);
        $book->checkIn();

        $this->assertCount(1, Reservation::all());   
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);     
        $this->assertNotNull(Reservation::first()->check_in);
        $this->assertEquals(now(), Reservation::first()->check_in);
        $this->assertGreaterThanOrEqual(Reservation::first()->check_out, Reservation::first()->check_in);
        Reservation::truncate();
    }


    
    public function test_reservation2_checkout_doble(){
        
        // alisto en caso de excepciones
        $this->expectException(\Exception::class);
        $book =  factory(Book::class)->create();
        $user =  factory(User::class)->create();
        // Saco un libro
        $book->checkOut($user);
        // devuelvo el libro
        $book->checkIn();
        // Saco el libro inmediatamente
        $book->checkOut($user);

        //Pruebas...
        $this->assertCount(2, Reservation::all());   
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertEquals($user->id, Reservation::find(2)->user_id);    
        $this->assertNull(Reservation::find(2)->check_in);
        $this->assertEquals(now(), Reservation::find(2)->check_out);

        //Intento sacar el libro que ya estaba afuera -> no deben presentarse cambios.
        $book->checkOut($user);
        $this->assertCount(2, Reservation::all());   
        $this->assertNull(Reservation::find(2)->check_in);

    }



    public function test_reservation3_checkin_doble(){
           // alisto en caso de excepciones
           $this->expectException(\Exception::class);
           $book =  factory(Book::class)->create();
           $user =  factory(User::class)->create();
           // Saco un libro
           $book->checkOut($user);
           // devuelvo el libro
           $book->checkIn();

            // Saco un libro por segunda vez. 
            $book->checkOut($user);

            // devuelvo el libro que estaba afuera -> No aumenta las reservas y cambia la fecha de entrega
            $book->checkIn();  
            $this->assertCount(2, Reservation::all()); 
            $this->assertNotNull(Reservation::find(2)->check_in);

            // Intento devolver un libro que no se registro su salida -> No aumenta reservas, arroja error. 
            $book->checkIn();  
            $this->assertCount(2, Reservation::all()); 
            $this->assertNotNull(Reservation::find(2)->check_in);
    
    }
    
}
