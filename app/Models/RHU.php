<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RHU extends Model
{
    use HasFactory;
    protected $table = 'rhus'; // Adjust table name if different
    protected $primaryKey = 'rhu_id'; // Set primary key
   

    protected $fillable = [
        'rhu_name',
        'municipality_id',
    ];
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }
    public function healthFacilities()
{
    return $this->hasMany(HealthFacility::class, 'rhu_id');
}
}
