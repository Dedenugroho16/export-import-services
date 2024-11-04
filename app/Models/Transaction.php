<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'code',
        'number',
        'id_consignee',
        'notify',
        'id_client',
        'port_of_loading',
        'place_of_receipt',
        'port_of_discharge',
        'place_of_delivery',
        'id_product',
        'id_commodity',
        'container',
        'net_weight',
        'gross_weight',
        'payment_term',
        'stuffing_date',
        'bl_number',
        'container_number',
        'seal_number',
        'product_ncm',
        'payment_condition',
        'freight_cost',
        'total',
        'approved',
        'approver',
        'created_by',
        'confirmed_by',
        'edited_by',
    ];
    
    public function consignee()
    {
        return $this->belongsTo(Consignee::class, 'id_consignee');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'detail_transactions', 'id_transaction', 'id_product');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }


    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'id_commodity');
    }

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class, 'id_transaction');
    }

    public function approverUser()
    {
        return $this->belongsTo(User::class, 'approver', 'id');
    }
}
