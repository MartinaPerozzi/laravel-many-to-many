<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Technology;
use Faker\Generator as Faker;


class ProjectTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $projects = Project::all()->pluck('id');
        $technologies = Technology::all()->pluck('id');

        for ($i = 1; $i < 30; $i++) {
            $project = Project::find($i);
            // funzione che dice prendi un poste associa un random element di tipo technology.
            $project->technologies()->attach($faker->randomElements($technologies));
        }
    }
}
