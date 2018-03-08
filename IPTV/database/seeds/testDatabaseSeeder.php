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
            'app' => 'launcher',
            'version' => 0.6
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
            [
                'name' => 'Action',
                'poster' => 'Action.png'
            ],
            [
                'name' => 'Adventure',
                'poster' => 'Adventure.png'
            ],
            [
                'name' => 'Animation',
                'poster' => 'Animation.png'
            ],
            [
                'name' => 'Biography',
                'poster' => 'Biography.png'
            ],
            [
                'name' => 'Comedy',
                'poster' => 'Comedy.png'
            ],
            [
                'name' => 'Crime',
                'poster' => 'Crime.png'
            ],
            [
                'name' => 'Documentary',
                'poster' => 'Documentary.png'
            ],
            [
                'name' => 'Drama',
                'poster' => 'Drama.png'
            ],
            [
                'name' => 'Family',
                'poster' => 'Family.png'
            ],
            [
                'name' => 'Fantasy',
                'poster' => 'Fantasy.png'
            ],
            [
                'name' => 'Favourites',
                'poster' => 'Favourites.png'
            ],
            [
                'name' =>  'Film-Noir',
                'poster' => 'Film-Noir.png'
            ],
            [
                'name' => 'History',
                'poster' => 'History.png'
            ],
            [
                'name' => 'Horror',
                'poster' => 'Horror.png'
            ],
            [
                'name' => 'Music',
                'poster' => 'Music.png'
            ],
            [
                'name' => 'Musical',
                'poster' => 'Musical.png'
            ],
            [
                'name' => 'Mystery',
                'poster' => 'Mystery.png'
            ],
            [
                'name' =>  'Oscar',
                'poster' => 'Oscar.png'
            ],
            [
                'name' => 'Others' ,
                'poster' => 'Others.png'
            ],
            [
                'name' => 'RomCom',
                'poster' => 'RomCom.png'
            ],
            [
                'name' => 'Romance',
                'poster' => 'Romance.png'
            ],
            [
                'name' => 'Sci-fi',
                'poster' => 'Sci-fi.png'
            ],
            [
                'name' => 'Sport',
                'poster' => 'Sport.png'
            ],
            [
                'name' => 'Superhero',
                'poster' => 'Superhero.png'
            ],
            [
                'name' => 'Thriller',
                'poster' => 'Thriller.png'
            ],
            [
                'name' => 'War',
                'poster' => 'War.png'
            ],
            [
                'name' => 'Western',
                'poster' => 'Western.png'
            ]
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
            [
                'title' => '300',
                'poster' => '300_1.png',
            ],
            [
                'title' => 'Spider Man',
                'poster' => 'spiderman_.png',
            ],
        ]);

        DB::table('movies')->insert([
                'title' => 'Star Wars',
                'poster' => 'star wars_.png',
                'price' => 20
            ]);

        DB::table('channels')->insert([
            [
                'name' => 'MBC 2',
                'number' => 1
            ],
            [
                'name' => 'MBC + Drama',
                'number' => 2
            ],
            [
                'name' => 'M6',
                'number' => 3
            ],
            [
                'name' => '6TER',
                'number' => 4
            ],
            [
                'name' => 'W9',
                'number' => 5
            ],
            [
                'name' => 'El Jadid',
                'number' => 7,
            ],
            [
                'name' => 'OTV',
                'number' => 8,
            ],
            [
                'name' => 'LBCI Ott',
                'number' => 9,
            ]
        ]);

        DB::table('streams')->insert([
            [
                'vid_stream' => 'http://shareeftube.net/videos/movies/1/300IIriseofempire.mp4',
                'type' => 5,
                'movie' => 1,
            ],
            [
                'vid_stream' => 'http://shareeftube.net/videos/movies/1/300IIriseofempire.mp4',
                'type' => 5,
                'movie' => 2,
            ],
            [
                'vid_stream' => 'http://shareeftube.net/videos/movies/1/300IIriseofempire.mp4',
                'type' => 5,
                'movie' => 3,
            ],
        ]);

        DB::table('channels')->insert([
                'name' => 'LBCI',
                'number' => 6,
                'price' => 20,
            ]);

        DB::table('streams')->insert([
            [
                'vid_stream' => 'udp://@224.1.10.14:1234',
                'type' => 1,
                'channel' => 1
            ],
            [
                'vid_stream' => 'udp://@224.1.10.32:1234',
                'type' => 1,
                'channel' => 2
            ],
            [
                'vid_stream' => 'udp://@224.1.10.20:1234',
                'type' => 1,
                'channel' => 3
            ],
            [
                'vid_stream' => 'udp://@224.1.10.21:1234',
                'type' => 1,
                'channel' => 4
            ],
            [
                'vid_stream' => 'udp://@224.1.10.24:1234',
                'type' => 1,
                'channel' => 5
            ],
            [
                'vid_stream' => 'udp://@224.1.3.32:1234',
                'type' => 1,
                'channel' => 6
            ],
            [
                'vid_stream' => 'udp://@224.1.1.27:1234',
                'type' => 1,
                'channel' => 7
            ],
            [
                'vid_stream' => 'udp://@224.1.1.26:1234',
                'type' => 1,
                'channel' => 8
            ],
            [
                'vid_stream' => 'http://192.168.0.102:8080/LBCI/index.m3u8',
                'type' => 2,
                'channel' => 9
            ]
        ]);

        DB::table('clients')->insert([
            'name' => 'client1',
            'email' => 'client@email.com',
            'room' => 1,
            'balance' => 200,
        ]);

        DB::table('sections')->insert([
            [
                'name' => 'Restaurants & Bar',
            ],
            [
                'name' => 'Spa & Fitness',
            ],
            [
                'name' => 'City Guide',
            ]
        ]);
        
        DB::table('services')->insert([
            [
                'name' => 'Assistance',
                'tag' => 'assistance'
            ],
            [
                'name' => 'Room Service',
                'tag' => 'roomservice'
            ],
            [
                'name' => 'House Keeper',
                'tag' => 'housekeeper'
            ],
            [
                'name' => 'Parental Control',
                'tag' => 'parentalcontrol'
            ],
            [
                'name' => 'Instant Messaging',
                'tag' => 'instantmessaging'
            ],
            [
                'name' => 'Survey',
                'tag' => 'survey'
            ],
        ]);
    }
}
