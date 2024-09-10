<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Add 'abbreviation' to the fillable property
    protected $fillable = [
        'code',
        'name',
        'abbreviation',
    ];

    // Define relationships
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'detail_transactions', 'id_product', 'id_transaction');
    }

    public function detailProducts()
    {
        return $this->hasMany(DetailProduct::class, 'id_product');
    }
}
