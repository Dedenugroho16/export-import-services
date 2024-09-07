<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_product',
        'name',
        'pcs',
        'dimension',
        'type',
        'color',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class, 'id_detail_product');
    }
}
