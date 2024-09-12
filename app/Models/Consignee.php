<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'tel', 'id_client'];

    // Relasi belongsTo ke model Client
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
}
