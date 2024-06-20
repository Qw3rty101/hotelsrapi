<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $private_rating = json_encode([1, 1, 1, 1, 0]);
        $private_rating_2 = json_encode([1, 1, 1, 1, 0]);
        $date_rating = json_encode([1, 1, 1, 1, 1]);
        $meeting_rating = json_encode([1, 1, 1, 0, 0]);

        DB::table('tbl_rooms')->insert([
            'name_room' => 'Raffel Room',
            'price' => 300000,
            'qty' => 3,
            'rating' => $private_rating,
            'short_desc' => 'Exclusive room for private events with complete facilities.',
            'detail_desc' => 'Experience perfection in this room designed for your private needs. Equipped with everything you need for special events, from modern amenities to luxurious ambiance.',
            'img_path' => '../../assets/img/private.jpg',
            'category_room' => 'private',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tbl_rooms')->insert([
            'name_room' => 'Laffrel Room',
            'price' => 300000,
            'qty' => 3,
            'rating' => $private_rating,
            'short_desc' => 'Private room with elegant ambiance for precious moments.',
            'detail_desc' => 'An elegant and comfortable atmosphere awaits in this room. With full amenities and captivating decor, this place is perfect for creating unforgettable memories.',
            'img_path' => '../../assets/img/private2.jpg',
            'category_room' => 'private',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tbl_rooms')->insert([
            'name_room' => 'Cupid Room',
            'price' => 350000,
            'qty' => 3,
            'rating' => $date_rating,
            'short_desc' => 'Romantic room for intimate gatherings.',
            'detail_desc' => 'Create romantic moments in this room filled with love. Designed with attention to detail and tempting ambiance, creating an unparalleled experience.',
            'img_path' => '../../assets/img/date.jpg',
            'category_room' => 'date',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tbl_rooms')->insert([
            'name_room' => 'Meeting Room',
            'price' => 600000,
            'qty' => 1,
            'rating' => $meeting_rating,
            'short_desc' => 'Modern meeting room with full facilities.',
            'detail_desc' => 'Ideal for important meetings and collaboration sessions, this room offers the latest technology and maximum comfort. Ensuring every meeting runs smoothly and productively.',
            'img_path' => '../../assets/img/meeting.jpg',
            'category_room' => 'meeting',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
