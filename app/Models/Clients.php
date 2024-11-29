<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'PO_BOX',
        'tel',
        'fax',
        'client_company_id', 
    ];

    
    public function clientCompany()
    {
        return $this->belongsTo(ClientCompany::class, 'client_company_id');
    }


    public function consignees()
    {
        return $this->hasMany(Consignee::class, 'id_client');
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_client');
    }

    public function billOfPayments()
    {
        return $this->hasMany(BillOfPayment::class, 'id_client');
    }

    public function company()
    {
        return $this->belongsTo(ClientCompany::class, 'client_company_id');
    }
}
