<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenses extends Model
{
    use SoftDeletes;

    protected $fillable = ['expense_category_id', 'name', 'description', 'expense_date'];

    //expense categories relationship
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategories::class);
    }
}
