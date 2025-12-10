<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'rent_price',
        'address',
        'availability',
        'owner_info',
        'images',
        'owner_id',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    //  ADDing this sadman
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
