<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('movies')->insert([
            [
                'title' => 'Inception',
                'description' => 'A thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'poster_image_url' => 'https://via.placeholder.com/150',
                'release_date' => '2010-07-16',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Matrix',
                'description' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
                'poster_image_url' => 'https://via.placeholder.com/150',
                'release_date' => '1999-03-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Interstellar',
                'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'poster_image_url' => 'https://via.placeholder.com/150',
                'release_date' => '2014-11-07',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}