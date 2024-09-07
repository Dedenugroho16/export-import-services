<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'tel',
        'id_client',
    ];

    // Definisi relasi one-to-many (kebalikannya)
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_consignee');
    }
}
