<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_payment_detail',
        'id_transaction',
        'paid',
        'description',
    ];

    public function billOfPayment()
    {
        return $this->belongsTo(BillOfPayment::class, 'id_bill', 'id');
    }
    
    public function transaction()
    {
        return $this->belongsTo(Transaction::class,  'id_transaction', 'id');
    }
}