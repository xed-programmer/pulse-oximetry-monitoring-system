<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pulse extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'patient_id',
        'hr',
        'spo2'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
