<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacist_id',
        'pharmacy_name',
        'longitude',
        'latitude',
    ];


    public function pharmacist()
    {
        return $this->belongsTo(Pharmacist::class, 'pharmacist_id');
    }
    public function drugs()
    {
        return $this->belongsToMany(Drug::class, 'pharmacy_drug', 'pharmacy_id', 'drug_id');
    }
}
