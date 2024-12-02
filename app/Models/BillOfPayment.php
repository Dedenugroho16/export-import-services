<?php

namespace App\Models;

use App\Models\DescBill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillOfPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'no_inv',
        'id_client',
        'id_client_company',
        'total',
        'status',
        'created_by',
        'updated_by',
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'id_client');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function descBills()
    {
        return $this->hasMany(DescBill::class, 'id_bill', 'id');
    }
    
    public function paymentDetail()
    {
        return $this->hasOne(PaymentDetail::class, 'id_bill_of_payment', 'id');
    }

    public function clientCompany()
    {
        return $this->belongsTo(ClientCompany::class, 'id_client_company', 'id');
    }
}
