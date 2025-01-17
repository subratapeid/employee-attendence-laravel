<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    // Define the table name if it's not the default "attendances"
    protected $table = 'duty_statuses';

    // Define the fillable fields for mass assignment
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

    // Automatically cast timestamps to Carbon instances
    protected $dates = ['created_at', 'updated_at', 'end_time'];

    /**
     * Accessor to calculate working hours for an attendance record.
     * 
     * @return float
     */
    public function getWorkingHoursAttribute()
    {
        if ($this->created_at && $this->end_time) {
            return $this->end_time->diffInMinutes($this->created_at) / 60;
        }
        return 0;
    }

    /**
     * Check if the user arrived late.
     * 
     * @return bool
     */
    public function getIsLateArrivalAttribute()
    {
        $dutyStart = Carbon::createFromTime(9, 30, 0);
        return $this->created_at && $this->created_at->greaterThan($dutyStart);
    }

    /**
     * Check if the user left early.
     * 
     * @return bool
     */
    public function getIsEarlyLeftAttribute()
    {
        $dutyEnd = Carbon::createFromTime(18, 0, 0);
        return $this->end_time && $this->end_time->lessThan($dutyEnd);
    }

    /**
     * Calculate overtime hours.
     * 
     * @return float
     */
    public function getOvertimeHoursAttribute()
    {
        $dutyEnd = Carbon::createFromTime(18, 0, 0);
        if ($this->end_time && $this->end_time->greaterThan($dutyEnd)) {
            return $this->end_time->diffInMinutes($dutyEnd) / 60;
        }
        return 0;
    }

    /**
     * Relationship: An attendance record belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
