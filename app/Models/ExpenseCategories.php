<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategories extends Model
{
    protected $fillable = [
        'name'
    ];

    //Expenses relationship
    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }
}
