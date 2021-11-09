<?php

namespace Database\Seeders;

use App\Models\Blog;
use Database\Factories\BlogFactory;
use Illuminate\Database\Seeder;


class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        Blog::factory()->count(3)->create();
    }
}
