<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use App\Models\Question;
use App\Seller;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Question::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'item_id' => Item::all()->random()->id,
        'seller_id' => Seller::all()->random()->id,
        'question' => $faker->sentence(5),
        'approved' => rand(0,1), 
    ];
});
