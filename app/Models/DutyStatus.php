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
        'start_photo',
        'end_latitude',
        'end_longitude',
        'end_photo',
        'end_time',
        'end_channel',
    ];
}
