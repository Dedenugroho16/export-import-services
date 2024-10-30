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
        'registration_number',
        'address',
        'city',
        'country',
        'postal_code',
        'phone_number',
        'email',
        'website',
        'tax_id',
        'founded_date',
        'export_license_number',
        'import_license_number',
        'bank_account_details',
        'logo',
    ];
}

