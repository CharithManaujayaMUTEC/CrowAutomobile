<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'items';

    protected $fillable = [
        'name',
        'unit',
        'qty',
        'comment',
        'item_brand_id'
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    
    public function procurement()
    {
        return $this->hasMany(Procurement::class);
    }

    public function itemBrand()
    {
        return $this->belongsTo(ItemBrand::class, 'item_brand_id');
    }
}
