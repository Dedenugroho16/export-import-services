<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_bill_of_payment',
        'payment_number',
        'date',
        'id_client',
        'total',
        'created_by',
    ];

    public function billOfPayment()
    {
        return $this->belongsTo(BillOfPayment::class,  'id_bill_of_payment', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class, 'id_client', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_payment_detail', 'id');
    }
}
