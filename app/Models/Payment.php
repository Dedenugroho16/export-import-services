<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaction',
        'id_bill',
        'paid',
        'description',
    ];

    public function billOfPayment()
    {
        return $this->belongsTo(BillOfPayment::class, 'id_bill', 'id');
    }
    
    public function detailTransaction()
    {
        return $this->belongsTo(DetailTransaction::class,  'id_detail_transaction', 'id');
    }
}