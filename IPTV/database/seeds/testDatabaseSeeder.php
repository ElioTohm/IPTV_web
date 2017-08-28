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

        DB::table('roles')->insert([
            ['name' => 'SuperAdmin'],
            ['name' => 'Admin'],
            ['name' => 'Monitor'],
        ]);

        DB::table('users')->insert([
            ['name' => 'admin',
                'email' => 'admin@admin.com',
                'role' => 1,
                'password' => bcrypt('123123')],
            ['name' => 'test',
                'email' => 'test@test.com',
                'role' => 2,
                'password' => bcrypt('123123')],
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
                'number' => 1,
                'stream' => 'udp://@224.1.3.32:1234',
                'thumbnail' => 'http://localhost/test.png'],
            ['name' => 'MTV',
                'number' => 2,
                'stream' => 'udp://@224.1.1.28:1234',
                'thumbnail' => 'http://localhost/test.png'],
            ['name' => 'El Jadid',
                'number' => 3,
                'stream' => 'udp://@224.1.1.27:1234',
                'thumbnail' => 'http://localhost/test.png'],
            ['name' => 'OTV',
                'number' => 4,
                'stream' => 'udp://@224.1.1.26:1234',
                'thumbnail' => 'http://localhost/test.png']
        ]);

        DB::table('clients')->insert([
            'name' => 'client1',
            'email' => 'client@email.com',
            'room' => 1,
            'credit' => 120,
        ]);
    }
}
