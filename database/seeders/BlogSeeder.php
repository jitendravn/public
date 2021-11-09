<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = "http://lorempixel.com/400/200/sports";
        $contents = file_get_contents($url);
        $name = substr($url, strrpos($url, '/') + 1);
        Storage::put($name, $contents);

        DB::table('blogs')->insert([
            'title'=>Str::random(7),
            'description'=>Str::random(20).'@gmail.com',
            'author'=>Str::random(8),
            'image'=>$url,
            'status'=>1,
        ]);
    }
}
