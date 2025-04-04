<?php

namespace App\Exports;

use App\Models\DayStartEnd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class ActivityExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $date;

    public function __construct($date = null)
    {
        $this->date = $date;
    }

    public function collection()
{
    $query = DayStartEnd::with('user');

    if ($this->date === 'today') {
        $query->whereDate('created_at', Carbon::today());
    } elseif ($this->date === 'yesterday') {
        $query->whereDate('created_at', Carbon::yesterday());
    } elseif ($this->isValidDateFormat($this->date, 'Y-m-d')) {
        $query->whereDate('created_at', $this->date);
    }

    return $query->get()->map(function ($record) {
        $valueOrNA = function ($val) {
            // Handle nulls, empty, 'null', '[]', or empty arrays
            if (is_null($val) || $val === '' || $val === 'null' || $val === '[]' || (is_array($val) && empty($val))) {
                return 'N/A';
            }

            // If numeric or numeric string, and less than or equal to 0
            if (is_numeric($val) && $val <= 0) {
                return '0';
            }

            return $val;
        };

        $formatArray = function ($value) use ($valueOrNA) {
            if (is_array($value)) {
                return count($value) > 0 ? implode(', ', $value) : 'N/A';
            }

            if (is_string($value) && str_starts_with($value, '[') && str_ends_with($value, ']')) {
                $decoded = json_decode($value, true);
                return (is_array($decoded) && count($decoded)) ? implode(', ', $decoded) : 'N/A';
            }

            return $valueOrNA($value);
        };

        return [
            'Name' => $valueOrNA($record->user->name ?? null),
            'Email' => $valueOrNA($record->user->email ?? null),
            'Emp ID' => $valueOrNA($record->user->emp_id ?? null),
            'Phone' => $valueOrNA($record->user->phone ?? null),
            'Start Time' => $valueOrNA($record->start_time),
            'End Time' => $valueOrNA($record->end_time),
            'Date' => $valueOrNA($record->date),
            'Login Status' => $valueOrNA($record->login_status),
            'Opening Balance' => $valueOrNA($record->opening_balance),
            'Issues At Start' => $formatArray($record->issues_at_start),
            'Day Start Remarks' => $valueOrNA($record->day_start_remarks),
            'AEPS Deposit Count' => $valueOrNA($record->aeps_deposit_count),
            'AEPS Deposit Amount' => $valueOrNA($record->aeps_deposit_amount),
            'AEPS Withdrawal Count' => $valueOrNA($record->aeps_withdrawal_count),
            'AEPS Withdrawal Amount' => $valueOrNA($record->aeps_withdrawal_amount),
            'Rupay Withdrawal Count' => $valueOrNA($record->rupay_withdrawal_count),
            'Rupay Withdrawal Amount' => $valueOrNA($record->rupay_withdrawal_amount),
            'SHG Count' => $valueOrNA($record->shg_count),
            'SHG Amount' => $valueOrNA($record->shg_amount),
            'Fund Transfer Count' => $valueOrNA($record->fund_transfer_count),
            'Fund Transfer Amount' => $valueOrNA($record->fund_transfer_amount),
            'TPD Count' => $valueOrNA($record->tpd_count),
            'TPD Amount' => $valueOrNA($record->tpd_amount),
            'Other Count' => $valueOrNA($record->other_count),
            'Other Amount' => $valueOrNA($record->other_amount),
            'PMJDY Count' => $valueOrNA($record->pmjdy_count),
            'PMJJBY Count' => $valueOrNA($record->pmjjby_count),
            'PMSBY Count' => $valueOrNA($record->pmsby_count),
            'RD Count' => $valueOrNA($record->rd_count),
            'FD Count' => $valueOrNA($record->fd_count),
            'APY Count' => $valueOrNA($record->apy_count),
            'SB Count' => $valueOrNA($record->sb_count),
            'Zero Balance SB Count' => $valueOrNA($record->zero_balance_sb_count),
            'Pending Esign SB Count' => $valueOrNA($record->pending_esign_sb_count),
            'Pending Signature SB Count' => $valueOrNA($record->pending_signature_sb_count),
            
            'Deposited Amount in Bank' => $valueOrNA($record->deposited_amount_bank),
            'Closing Cash' => $valueOrNA($record->closing_cash),
            'Pending Transaction Count' => $valueOrNA($record->pending_transaction_count),
            'Device Issues' => $valueOrNA($record->device_issues),
            'Issue Details' => $valueOrNA($record->issue_details),
            'Logout Status' => $valueOrNA($record->logout_status),
            'Remarks' => $valueOrNA($record->remarks),
            'Challenges' => $formatArray($record->challenges),
            'Submission Status' => $record->entry_type === 'end' ? 'Submitted' : 'Pending Submission',
            'Created At' => $valueOrNA($record->created_at),
        ];
    });
}

    

    public function headings(): array
    {
        return [
            'Name', 'Email', 'Emp ID', 'Phone', 'Start Time', 'End Time', 'Date',
            'Login Status', 'Opening Balance', 'Issues At Start', 'Day Start Remarks',
            'AEPS Deposit Count', 'AEPS Deposit Amount',
            'AEPS Withdrawal Count', 'AEPS Withdrawal Amount',
            'Rupay Withdrawal Count', 'Rupay Withdrawal Amount',
            'SHG Count', 'SHG Amount',
            'Fund Transfer Count', 'Fund Transfer Amount',
            'TPD Count', 'TPD Amount',
            'Other Count', 'Other Amount',
            'PMJDY Count', 'PMJJBY Count', 'PMSBY Count',
            'RD Count', 'FD Count', 'APY Count', 'SB Count',
            'Zero Balance SB Count', 'Pending Esign SB Count', 'Pending Signature SB Count',
            'Deposited Amount in Bank', 'Closing Cash',
            'Pending Transaction Count', 'Device Issues', 'Issue Details',
            'Logout Status', 'Remarks', 'Challenges', 'Submission Status', 'Created At',
        ];
    }

    private function isValidDateFormat($date, $format = 'Y-m-d')
    {
        $d = Carbon::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
