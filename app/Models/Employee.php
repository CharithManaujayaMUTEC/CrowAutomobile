<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'address',
        'joined_date',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}


