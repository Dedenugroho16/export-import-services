<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaction',
        'id_bill',
        'description',
        'paid',
        'bill',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction', 'id');
    }
    
    public function billOfPayment()
    {
        return $this->belongsTo(BillOfPayment::class, 'id_bill', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id_payment', 'id');
    }
}
