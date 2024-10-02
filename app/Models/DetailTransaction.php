<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi
    protected $table = 'detail_transactions';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'id_transaction',      // Relasi dengan tabel transactions
        'id_detail_product',   // Relasi dengan tabel detail_products
        'qty',                 // Jumlah produk
        'carton',              // Jumlah carton
        'inner_qty_carton',    // Jumlah inner carton
        'unit_price',          // Harga satuan
        'net_weight',          // Berat bersih
        'price_amount',        // Jumlah harga
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
