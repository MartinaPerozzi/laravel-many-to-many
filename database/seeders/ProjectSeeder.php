<?php

namespace Database\Seeders;

// Importando iniziando a scrivere Project nel for con suggerimento.
use App\Models\Project;
// Importare per lo SLUG
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $types = Type::all()->pluck('id'); //prendi gli id dei tipi
        $types[] = null; // metti nell'array types anche il null

        for ($i = 0; $i < 40; $i++) {
            $project = new Project;
            // 
            $project->type_id = $faker->randomElement($types);

            $project->title = $faker->sentence(2);
            $project->slug = Str::of($project->title)->slug('-');
            $project->text = $faker->text(90);
            // $project->image = $faker->imageUrl(640, 480, 'animals', true);
            $project->save();
        }
    }
}
