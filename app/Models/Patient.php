<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_number',
        'name',
        'age'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
