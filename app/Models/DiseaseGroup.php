<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'disease_group_name'
        
    ];
}
