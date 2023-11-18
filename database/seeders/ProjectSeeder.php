<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 10; $i++) {
            

            $new_project = new Project();
            $new_project->type_id = rand(1, 5);
            $new_project->title = $faker->realText(50);
            $new_project->slug = Str::slug($new_project->title, '-');
            $new_project->description = $faker->realText(300);
            $new_project->thumb = 'https://unsplash.it/600/400?image=' . rand(1, 1000);
            $new_project->release_date = $faker->date();
            $new_project->github_link =  $faker->url();
            $new_project->public_link = $faker->url();
            //save data
            $new_project->save();
        }
    }
}
