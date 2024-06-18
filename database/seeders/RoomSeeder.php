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
            'short_desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda illo dolorem, hic iste exercitationem eum.',
            'detail_desc' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo fuga accusamus aliquam voluptates, est quis nulla earum, enim quos error temporibus beatae in dolorum obcaecati velit. Officia esse aliquam laboriosam.',
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
            'short_desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda illo dolorem, hic iste exercitationem eum.',
            'detail_desc' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo fuga accusamus aliquam voluptates, est quis nulla earum, enim quos error temporibus beatae in dolorum obcaecati velit. Officia esse aliquam laboriosam.',
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
            'short_desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda illo dolorem, hic iste exercitationem eum.',
            'detail_desc' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo fuga accusamus aliquam voluptates, est quis nulla earum, enim quos error temporibus beatae in dolorum obcaecati velit. Officia esse aliquam laboriosam.',
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
            'short_desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda illo dolorem, hic iste exercitationem eum.',
            'detail_desc' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo fuga accusamus aliquam voluptates, est quis nulla earum, enim quos error temporibus beatae in dolorum obcaecati velit. Officia esse aliquam laboriosam.',
            'img_path' => '../../assets/img/meeting.jpg',
            'category_room' => 'meeting',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
