<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // Define the sender relationship
    protected $fillable = ['receiver', 'message', 'status', 'date'];

}
