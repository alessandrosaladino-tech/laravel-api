<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeList = ['HTML','BOOTSTRAP 5', 'CSS', 'JS', 'VUE 3', 'VITE', 'PHP', 'LARAVEL',];

        foreach ($typeList as $type) {
            $new_type = new Technology();
            $new_type->name = $type;
            $new_type->slug = Str::slug($new_type->name, '-');
            $new_type->save();
        }
    }
}