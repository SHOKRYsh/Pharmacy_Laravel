<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;


    protected $fillable = [
        'patient_id',
        'drug_name',
        'quantity',
        'address',
        'expiry_date'
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
