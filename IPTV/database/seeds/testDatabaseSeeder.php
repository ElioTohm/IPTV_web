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
        DB::table('app_settings')->insert([
            ['app' => 'launcher',
                'version' => 0.6],
        ]);

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

        DB::table('streams_types')->insert([
            ['id'=> 1,
                'name' => 'UPD'],
            ['id'=> 2,
                'name' => 'HLS'],
            ['id'=> 3,
                'name' => 'DASH'],
            ['id'=> 4,
                'name' => 'SS'],
            ['id'=> 5,
                'name' => 'MISC'],
        ]);
        
        DB::table('movies')->insert([
            'title' => '300',
            'poster' => 'http://shareeftube.net/videoimages/tt1253863.png',
        ]);

        DB::table('channels')->insert([
            ['name' => 'LBCI',
                'number' => 1,
                'id' => 1],
            ['name' => 'MTV',
                'number' => 2,
                'id' => 2],
            ['name' => 'El Jadid',
                'number' => 3,
                'id' => 3],
            ['name' => 'OTV',
                'number' => 4,
                'id' => 4],
            ['name' => 'LBCI HLS',
                'number' => 5,
                'id' => 5]
        ]);

        DB::table('streams')->insert([
                'vid_stream' => 'http://shareeftube.net/videos/movies/1/300IIriseofempire.mp4',
                'type' => 5,
                'movie' => 1
        ]);

        DB::table('streams')->insert([
            [
                'vid_stream' => 'udp://@224.1.3.32:1234',
                'type' => 1,
                'channel' => 1
            ],
            [
                'vid_stream' => 'udp://@224.1.1.28:1234',
                'type' => 1,
                'channel' => 2
            ],
            [
                'vid_stream' => 'udp://@224.1.1.27:1234',
                'type' => 1,
                'channel' => 3
            ],
            [
                'vid_stream' => 'udp://@224.1.1.26:1234',
                'type' => 1,
                'channel' => 4
            ],
            [
                'vid_stream' => 'http://192.168.0.102:8080/LBCI/index.m3u8',
                'type' => 2,
                'channel' => 5
            ]
        ]);

        DB::table('clients')->insert([
            'name' => 'client1',
            'email' => 'client@email.com',
            'room' => 1,
            'credit' => 120,
        ]);
    }
}
