<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    // protected $table = 'patients';

    // Define the primary key
    protected $primaryKey = 'patients_id'; // Set the primary key

    // Specify if the primary key is not an incrementing integer

    protected $fillable = [
        'patient_fname',
        'patient_minitial',
        'patient_lname',
        'patient_extension',
        'disease_code',
        'staff_id',
        'date',
        'age',
        'age_unit',
        'gender',
        'status',
    ];

    public function disease()
{
    return $this->belongsTo(Disease::class, 'disease_code', 'disease_code');
}
public function staff()
{
    return $this->belongsTo(Staff::class, 'staff_id');
}

    
}
