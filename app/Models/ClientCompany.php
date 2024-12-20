<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCompany extends Model
{
    use HasFactory;
    protected $table = 'client_company';
    protected $fillable = [
        'company_name',
        'address',
        'PO_BOX',
        'tel',
        'fax',
    ];
    

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class, 'id_client_company', 'id');
    }
    
    public function billOfPayments()
    {
        return $this->hasMany(BillOfPayment::class, 'id_client_company', 'id');
    }
}