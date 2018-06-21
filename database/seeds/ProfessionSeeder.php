<?php

use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $professions = collect(['Web Developer', 'Designer', 'FullStack Developer', 'Manager', 'CTO', 'CEO', 'Bartender', 'Frontend Developer', 'Farmer']);

      $professions->each(function ($profession) {
        factory('App\Profession')->create(['name' => $profession]);
      });
    }
}
