<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChronicDiseases extends Model
{
    use HasFactory;

    protected $table = "chronic_diseases";
    protected $fillable = [
        'patient_id',
        'disease',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
