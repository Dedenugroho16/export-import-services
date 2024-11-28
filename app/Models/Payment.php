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
        'transfered',
        'description',
    ];

    public function billOfPayment()
    {
        return $this->belongsTo(BillOfPayment::class, 'id_bill', 'id');
    }
    
    public function paymentDetail()
    {
        return $this->belongsTo(PaymentDetail::class, 'id_payment_detail', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction', 'id');
    }
}