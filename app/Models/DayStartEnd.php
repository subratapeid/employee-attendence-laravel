<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayStartEnd extends Model
{
    use HasFactory;
    protected $table = 'day_start_ends';
    protected $fillable = [
        'user_id', 'login_status', 'opening_balance', 'issues_at_start', 'day_start_remarks', 'entry_type',
        'aeps_deposit_count', 'aeps_deposit_amount', 
        'aeps_withdrawal_count', 'aeps_withdrawal_amount', 
        'rupay_withdrawal_count', 'rupay_withdrawal_amount', 
        'shg_count', 'shg_amount', 'fund_transfer_count', 
        'fund_transfer_amount', 'tpd_count', 'tpd_amount', 
        'other_count', 'other_amount', 'pmjdy_count', 
        'pmjjby_count', 'pmsby_count', 'rd_count', 'fd_count', 
        'apy_count', 'sb_count', 'zero_balance_sb_count', 'pending_esign_sb_count', 'pending_signature_sb_count',
        'deposited_amount_bank', 'closing_cash', 
        'pending_transaction_count', 'device_issues', 
        'issue_details', 'logout_status', 'remarks', 'challenges'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
    
}


