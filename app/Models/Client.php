<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        //
    ];

    // Definisi relasi one-to-many
    public function consignees()
    {
        return $this->hasMany(Consignee::class, 'id_client');
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_client');
    }
}
