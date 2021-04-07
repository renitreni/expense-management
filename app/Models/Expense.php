<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_category_id',
        'amount',
        'entry_date',
        'created_by'
    ];

    public function categories()
    {
        return $this->hasOne(ExpenseCategory::class, 'id', 'expense_category_id');
    }
}
