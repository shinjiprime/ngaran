<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facility_id',
        'date',
    ];

    /**
     * Define the relationship to the HealthFacility model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function healthFacility()
    {
        return $this->belongsTo(HealthFacility::class, 'facility_id', 'facility_id');
    }
}
