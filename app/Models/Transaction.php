<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_count',
        'deposit_amount',
        'withdrawal_count',
        'withdrawal_amount',
        'transfer_count',
        'transfer_amount',
        'other_count',
        'other_details',
        'enrollment_count',
        'savings_count',
        'deposit_accounts',
        'aadhaar_seeding',
        'ekyc_processed',
        'device_issues',
        'device_details'
    ];
}
