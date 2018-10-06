<?php

use Faker\Generator as Faker;

use App\Eloquents\Campaign;
use App\Eloquents\Invoice;
use App\Eloquents\Shop;

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

$factory->define(App\Eloquents\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Eloquents\Shop::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\Eloquents\User::class)->create()->id;
        },
    ];
});

$factory->define(App\Eloquents\Campaign::class, fuction (Faker $faker) {
    return [
        'shop_id' => function () {
            return factory(App\Eloquents\Shop::class)->create()->id;
        },
        'name' => $faker->name,
        'budget' => $faker->numberBetween(1000, 50000),
        'media' => $faker->numberBetween(1, 4),
        'begin_at' => $faker->numberBetween(1000, 50000),
        'end_at' => $faker->dateTime(),
        'description' => $faker->realText(),
        'approval_status' => $faker->numberBetween(1, 3),
        'comment' => $faker->realText(),
    ];
});

$factory->define(App\Eloquents\Invoice::class, function (Faker $faker) {
    return [
        'shop_id' => function () {
            return factory(App\Eloquents\Shop::class)->create()->id;
        },
        'billing_amount' => $faker->numberBetween(1000, 50000),
        'begin_at' => $faker->dateTime(),
        'end_at' => $faker->dateTime(),
        'description' => $faker->realText(),
    ];
});
