<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyDrug extends Model
{
    use HasFactory;

    protected $table = "pharmacy_drug";
    protected $fillable = ["pharmacy_id", "drug_id", "quantity"];
}
