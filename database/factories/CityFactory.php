<?php

use Faker\Generator as Faker;

$factory->define(App\City::class, function (Faker $faker) {
    return [
      'name' => $faker->city,
      'country_id' => function () {
        return factory('App\Country')->create()->id;
      }
    ];
});
