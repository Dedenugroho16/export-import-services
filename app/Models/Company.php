<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Define the table name (optional if naming convention is followed)
    protected $table = 'companies';

    // Define the fillable fields
    protected $fillable = [
        'company_name',
        'company_code',
        'registration_number',
        'address',
        'city',
        'country',
        'postal_code',
        'phone_number',
        'email',
        'website',
        'contact_person',
        'industry',
        'tax_id',
        'founded_date',
        'export_license_number',
        'import_license_number',
        'bank_account_details',
        'payment_terms',
        'incoterms',
        'shipping_agent',
        'customs_broker',
        'consignee_code',
        'forwarding_agent',
        'logo',
    ];
}

