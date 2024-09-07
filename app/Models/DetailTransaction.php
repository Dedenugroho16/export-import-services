<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaction',
        'id_detail_product',
        'qty',
        'carton',
        'inner_qty_carton',
        'unit_price',
        'net_weight',
        'price_amount',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction');
    }

    public function detailProduct()
    {
        return $this->belongsTo(DetailProduct::class, 'id_detail_product');
    }
}
