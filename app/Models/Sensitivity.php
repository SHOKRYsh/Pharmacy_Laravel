<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensitivity extends Model
{
    use HasFactory;

    protected $table = "sensitivities";
    protected $fillable = [
        'patient_id',
        'name',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
