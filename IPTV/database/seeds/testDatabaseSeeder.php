<?php

use Illuminate\Database\Seeder;

class testDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => bcrypt('123123'),
        ]);
        DB::table('genres')->insert([
            ['name' => 'Action'],
            ['name' => 'Drama'],
            ['name' => 'Kids'],
            ['name' => 'Family'],
            ['name' => 'News'],
            ['name' => 'Bollywood']
        ]);
        
        DB::table('channels')->insert([
            ['name' => 'LBCI',
            'stream' => 'udp://@224.1.1.30',
            'thumbnail' => 'http://localhost/test.png'],
            ['name' => 'MTV',
            'stream' => 'udp://@224.1.1.28',
            'thumbnail' => 'http://localhost/test.png'],
            ['name' => 'El Jadid',
            'stream' => 'udp://@224.1.1.27',
            'thumbnail' => 'http://localhost/test.png'],
            ['name' => 'Manar',
            'stream' => 'udp://@224.1.1.26',
            'thumbnail' => 'http://localhost/test.png']
        ]);
    }
}
