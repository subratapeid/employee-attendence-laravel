<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_date',
        'reason',
    ];
}
