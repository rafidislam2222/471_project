<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'rent_price',
        'address',
        'availability',
        'owner_info',
        'images',
        'owner_id'
    ];
    protected $casts = [
    'images' => 'array',
    ];
    
}
