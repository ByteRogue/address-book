<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory('App\Country', 20)->create()->each(function ($country) {
        factory('App\City', 10)->create(['country_id' => $country->id]);
      });
    }
}
