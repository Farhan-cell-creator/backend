<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

 
class Task extends Model
{
    //
       protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'employee_id',
    ];
     public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Task belongs to Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
