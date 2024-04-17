<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientChronicDiseases extends Model
{
    use HasFactory;

    protected $table = "patient_chronic_diseases";
    protected $fillable = [
        'patient_id',
        'disease_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
