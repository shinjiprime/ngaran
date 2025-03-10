<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthFacility extends Model
{
    use HasFactory;
    protected $table = 'health_facilities';

    // Specify the primary key
    protected $primaryKey = 'facility_id';

    // Allow mass assignment for these attributes
    protected $fillable = [
        'facility_name',
        'facility_type',
        'barangay_id', 
        'rhu_id',
        'coordinates'
    ];
    public function barangay()
{
    return $this->belongsTo(Barangay::class, 'barangay_id');
}
public function rhu()
{
    return $this->belongsTo(RHU::class, 'rhu_id');
}
public function staff()
{
    return $this->hasMany(Staff::class, 'health_facility');
}



}
