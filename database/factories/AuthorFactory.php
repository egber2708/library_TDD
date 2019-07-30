<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Author;
use Faker\Generator as Faker;
use Carbon\Carbon;


$factory->define(Author::class, function (Faker $faker) {
    return [
        'nombre'=> $faker->name(),
        'dob' => now()->subYears(10)->format('d/m/Y'),
    ];
});
