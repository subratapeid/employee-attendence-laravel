<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyUserReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filePath;

    /**
     * Create a new message instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Monthly User Report')
            ->view('emails.monthly_user_report')
            ->attach($this->filePath, [
                'as' => 'monthly_user_report.csv',
                'mime' => 'text/csv',
            ]);
    }
}
