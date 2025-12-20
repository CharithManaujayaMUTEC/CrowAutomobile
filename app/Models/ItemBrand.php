<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemBrand extends Model
{

    protected $fillable = [
        'name',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'item_brand_id');
    }
}
