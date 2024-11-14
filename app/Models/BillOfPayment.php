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
        'id_client',
        'total',
        'status',
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
}
