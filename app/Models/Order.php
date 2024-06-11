<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'tbl_orders'; // Nama tabel dalam database
    protected $primaryKey = 'id_order'; // Nama kolom primary key

    protected $fillable = [
        'id',
        'id_room',
        'id_facility',
        'price_order',
        'check_in',
        'check_out',
        'order_time',
        'status_order',
        'order_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'name_room');
    }
}
