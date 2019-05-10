<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Keyword;

$factory->define(Keyword::class, function (Faker $faker) {
    return [
        'status' => 1
    ];
});
