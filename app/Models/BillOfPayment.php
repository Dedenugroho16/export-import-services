<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'no_inv',
        'payment_number',
        'id_client',
        'total',
        'created_by',
        'updated_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_bill', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_bill', 'id');
    }
}
