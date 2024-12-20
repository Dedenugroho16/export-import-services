<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' 
    ];

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

    public function clientCompanies()
    {
        return $this->belongsToMany(ClientCompany::class, 'client_client_company', 'client_id', 'client_company_id');
    }

}
