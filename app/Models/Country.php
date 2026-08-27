<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'display_name',
        'name',
        'currency_symbol',
        'country_code',
        'iso2',
        'status',
        'language',
        'flag_url',
        'currency_meta',
        'app_icon',
    ];

    protected $casts = [
        'language' => 'array',
        'currency_meta' => 'array',
    ];
}