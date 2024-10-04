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

    // Relasi one-to-one: satu detail produk dimiliki oleh satu detail transaksi
    public function detailTransaction()
    {
        return $this->hasOne(DetailTransaction::class, 'id_detail_product');
    }
}
