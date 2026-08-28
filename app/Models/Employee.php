<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Employee extends Model
{
    //
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
   protected function email(): Attribute
    {
        return Attribute::make(

         set: fn ($value) => strtolower($value),

        );
    }
    protected function firstName(): Attribute
    {
        return Attribute::make(

           
            get: fn ($value) => strtoupper($value),

            
            set: fn ($value) => strtolower($value),

        );
    }
}
