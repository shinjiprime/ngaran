<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staff';

    // Specify the primary key
    protected $primaryKey = 'staff_id';

    public function user()
{
    return $this->hasOne(User::class, 'staff_id', 'staff_id');
}


    // Define the fillable attributes
    protected $fillable = [
        'staff_fname',
        'staff_mname',
        'staff_lname',
        'staff_extension',
        'email',
        'phone_number',
        'health_facility',
        'rhu_id'
    ];
    public function healthFacility()
{
    return $this->belongsTo(HealthFacility::class, 'health_facility', 'facility_id');
}
public function patients()
{
    return $this->hasMany(Patient::class, 'staff_id');
}
public function rhu()
{
    return $this->belongsTo(RHU::class, 'rhu_id');
}
}
