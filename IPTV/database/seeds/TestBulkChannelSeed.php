<?php

use Illuminate\Database\Seeder;

class TestBulkChannelSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->insert([
            ['name' => 'test','number' => 10],
            ['name' => 'test','number' => 11],
            ['name' => 'test','number' => 12],
            ['name' => 'test','number' => 13],
            ['name' => 'test','number' => 14],
            ['name' => 'test','number' => 15],
            ['name' => 'test','number' => 16],
            ['name' => 'test','number' => 17],
            ['name' => 'test','number' => 18],
            ['name' => 'test','number' => 19],
            ['name' => 'test','number' => 20],
            ['name' => 'test','number' => 21],
            ['name' => 'test','number' => 22],
            ['name' => 'test','number' => 23],
            ['name' => 'test','number' => 24],
            ['name' => 'test','number' => 25],
            ['name' => 'test','number' => 26],
            ['name' => 'test','number' => 27],
            ['name' => 'test','number' => 28],
            ['name' => 'test','number' => 29],
            ['name' => 'test','number' => 30],
            ['name' => 'test','number' => 31],
            ['name' => 'test','number' => 32],
            ['name' => 'test','number' => 33],
            ['name' => 'test','number' => 34],
            ['name' => 'test','number' => 35],
            ['name' => 'test','number' => 36],
            ['name' => 'test','number' => 37],
            ['name' => 'test','number' => 38],
            ['name' => 'test','number' => 39],
            ['name' => 'test','number' => 40],
            ['name' => 'test','number' => 41],
            ['name' => 'test','number' => 42],
            ['name' => 'test','number' => 43],
            ['name' => 'test','number' => 44],
            ['name' => 'test','number' => 45],
            ['name' => 'test','number' => 46],
            ['name' => 'test','number' => 47],
        ]);

        DB::table('streams')->insert([
            ['vid_stream' => 'udp://@224.1.1.22:1234','type' => 1,'channel' => 10],
            ['vid_stream' => 'udp://@224.1.245.1:1234','type' => 1,'channel' => 11],
            ['vid_stream' => 'udp://@224.1.7.9:1234','type' => 1,'channel' => 12],
            ['vid_stream' => 'udp://@224.1.15.8:1234','type' => 1,'channel' => 13],
            ['vid_stream' => 'udp://@224.1.1.16:1234','type' => 1,'channel' => 14],
            ['vid_stream' => 'udp://@224.1.1.18:1234','type' => 1,'channel' => 15],
            ['vid_stream' => 'udp://@224.1.7.24:1234','type' => 1,'channel' => 16],
            ['vid_stream' => 'udp://@224.1.244.5:1234','type' => 1,'channel' => 17],
            ['vid_stream' => 'udp://@224.1.245.6:1234','type' => 1,'channel' => 18],
            ['vid_stream' => 'udp://@224.1.9.11:1234','type' => 1,'channel' => 19],
            ['vid_stream' => 'udp://@224.1.9.7:1234','type' => 1,'channel' => 20],
            ['vid_stream' => 'udp://@224.1.11.18:1234','type' => 1,'channel' => 21],
            ['vid_stream' => 'udp://@224.1.16.2:1234','type' => 1,'channel' => 22],
            ['vid_stream' => 'udp://@224.1.7.15:1234','type' => 1,'channel' => 23],
            ['vid_stream' => 'udp://@224.1.2.8:1234','type' => 1,'channel' => 24],
            ['vid_stream' => 'udp://@224.1.2.9:1234','type' => 1,'channel' => 25],
            ['vid_stream' => 'udp://@224.1.245.2:1234','type' => 1,'channel' => 26],
            ['vid_stream' => 'udp://@224.1.10.14:1234','type' => 1,'channel' => 27],
            ['vid_stream' => 'udp://@224.1.7.78:1234','type' => 1,'channel' => 28],
            ['vid_stream' => 'udp://@224.1.2.1:1234','type' => 1,'channel' => 29],
            ['vid_stream' => 'udp://@224.1.7.84:1234','type' => 1,'channel' => 30],
            ['vid_stream' => 'udp://@224.1.10.56:1234','type' => 1,'channel' => 31],
            ['vid_stream' => 'udp://@224.1.7.73:1234','type' => 1,'channel' => 32],
            ['vid_stream' => 'udp://@224.1.9.27:1234','type' => 1,'channel' => 33],
            ['vid_stream' => 'udp://@224.1.10.1:1234','type' => 1,'channel' => 34],
            ['vid_stream' => 'udp://@224.1.2.10:1234','type' => 1,'channel' => 35],
            ['vid_stream' => 'udp://@224.1.12.8:1234','type' => 1,'channel' => 36],
            ['vid_stream' => 'udp://@224.1.2.11:1234','type' => 1,'channel' => 37],
            ['vid_stream' => 'udp://@224.1.245.3:1234','type' => 1,'channel' => 38],
            ['vid_stream' => 'udp://@224.1.3.6:1234','type' => 1,'channel' => 39],
            ['vid_stream' => 'udp://@224.1.10.84:1234','type' => 1,'channel' => 40],
            ['vid_stream' => 'udp://@224.1.244.7:1234','type' => 1,'channel' => 41],
            ['vid_stream' => 'udp://@224.1.9.6:1234','type' => 1,'channel' => 42],
            ['vid_stream' => 'udp://@224.1.9.12:1234','type' => 1,'channel' => 43],
            ['vid_stream' => 'udp://@224.1.10.34:1234','type' => 1,'channel' => 44],
            ['vid_stream' => 'udp://@224.1.244.4:1234','type' => 1,'channel' => 45],
            ['vid_stream' => 'udp://@224.1.9.10:1234','type' => 1,'channel' => 46],
            ['vid_stream' => 'udp://@224.1.7.26:1234','type' => 1,'channel' => 47],
        ]);
    }
}
