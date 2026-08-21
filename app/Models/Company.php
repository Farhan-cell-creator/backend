<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_name',
        'logo',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function user(): HasOne
    {
        return $this->HasOne(User::class);
    }
}
