<?php

use Faker\Generator as Faker;

$factory->define(App\Agency::class, function (Faker $faker) {
    return [
      'name' => $faker->word,
      'address' => $faker->address,
      'email' => $faker->unique()->safeEmail,
      'web' => $faker->url,
      'city_id' => function () {
        return factory('App\City')->create()->id;
      }
    ];
});
