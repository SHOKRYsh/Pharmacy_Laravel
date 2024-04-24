<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $fillable = [
        "name_en",
        "name_ar",
        "price",
        "image_url"
    ];

    public function pharmacies()
    {
        return $this->belongsToMany('Pharmacy', 'pharmacy_drug', 'drug_id', ' pharmacy_id');
    }
}
