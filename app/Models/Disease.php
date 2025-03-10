<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;
    protected $primaryKey = 'disease_code';

    protected $fillable = [
        'disease_code',
        'disease_name',
        'icd10_code',
        'disease_group_id',
    ];
    // In the Disease model
public function diseaseGroup()
{
    return $this->belongsTo(DiseaseGroup::class, 'disease_group_id');
}

}
