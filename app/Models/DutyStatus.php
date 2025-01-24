<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_latitude',
        'start_longitude',
        'start_location',
        'start_photo',
        'end_latitude',
        'end_longitude',
        'end_location',
        'end_photo',
        'end_time',
        'end_channel',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Define the inverse relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Assuming 'user_id' is the foreign key in the DutyStatus table
    }
}
