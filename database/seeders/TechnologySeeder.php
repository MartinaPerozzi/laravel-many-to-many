<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;
use Faker\Generator as Faker;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $labels = ["HTML", "CSS", "JAVASCRIPT", "PHP", "SQL", "GIT", "Blade"];
        // Ciclo per generare con Faker
        foreach ($labels as $label) {
            $tech = new Technology();
            $tech->label = $label;
            $tech->color = $faker->hexColor();
            $tech->save();
        }
    }
}
