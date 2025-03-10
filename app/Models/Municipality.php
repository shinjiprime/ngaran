<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;
    protected $fillable = [
        'municipality_name','coordinates'
        
    ];
    public function barangays()
    {
        return $this->hasMany(Barangay::class, 'municipality_id');
    }
    public function rhus()
    {
        return $this->hasMany(RHU::class, 'municipality_id');
    }
}
