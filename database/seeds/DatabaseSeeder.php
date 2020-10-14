<?php

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
        // $this->call(UserSeeder::class);
        \Illuminate\Support\Facades\DB::table('sites')->insert([
            'name' => 'Terrikon',
            'rss' => 'https://terrikon.com/rss',
            'link' => 'https://terrikon.com'
        ]);
        \Illuminate\Support\Facades\DB::table('sites')->insert([
            'name' => 'UA Football',
            'rss' => 'https://www.ua-football.com/rss/all.xml',
            'link' => 'https://www.ua-football.com'
        ]);
        \Illuminate\Support\Facades\DB::table('sites')->insert([
            'name' => 'Tribuna',
            'rss' => 'https://ua.tribuna.com/rss/topnews.xml',
            'link' => 'https://ua.tribuna.com'
        ]);
        \Illuminate\Support\Facades\DB::table('sites')->insert([
            'name' => 'SportArena',
            'rss' => 'https://sportarena.com/feed/',
            'link' => 'https://sportarena.com'
        ]);
    }
}
