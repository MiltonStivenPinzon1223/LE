<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Result;
use App\Models\Rol;
use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Rol::factory()->create(['rol_rol'=>"Adminitrator"]);
        // Rol::factory()->create(['rol_rol'=>"Standard"]);
        // User::factory(10)->create();
        // Category::factory()->create(['cat_category'=>'office']);
        // Category::factory()->create(['cat_category'=>'cinema']);
        // Category::factory()->create(['cat_category'=>'fruits']);
        // Category::factory()->create(['cat_category'=>'Tools']);
         Word::factory(20)->create();
        //Result::factory(100)->create();
    }
}
