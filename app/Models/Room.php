<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'tbl_rooms';
    protected $primaryKey = 'id_room';

    protected $fillable = [
        'name_room',
        'price',
        'qty',
        'rating',
        'short_desc',
        'detail_desc',
        'img_path',
        'category_room'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'name_room');
    }
}
