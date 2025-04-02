<?php

namespace App\Http\Controllers;

use App\Models\DayStartEnd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\DutyStatus;
class DayStartEndDataController extends Controller
{

    public function checkDataEntryStatus()
{
    // Get today's date
    $today = Carbon::now()->toDateString();

    // Get the logged-in user's ID
    $userId = Auth::id();

    // Retrieve today's entry from DayStartEnd
    $dayEntry = DayStartEnd::where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->select('entry_type')
        ->first();

    // Check if a record exists in DutyStatus for today
    $dutyExists = DutyStatus::where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->exists();

    // Return response with both 'entry_type' and 'duty_status' existence
    return response()->json([
        'exists' => (bool) $dayEntry, // true if entry exists, false otherwise
        'entry_type' => $dayEntry->entry_type ?? 'na', // Return null if no entry
        'duty_status' => $dutyExists ? 'exist' : 'not exist' // Return duty status existence
    ]);
}
    public function index()
    {
        $transactions = DayStartEnd::all();
        return view('pages.day-end-form');
    }
    public function fetch()
    {
        $transactions = DayStartEnd::all();
        return response()->json($transactions);
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
{
    // Get today's date
    $today = Carbon::now()->toDateString();

    // Get the logged-in user's ID
    $userId = Auth::id();

    // Validate the request data
    $request->merge([
        'aeps_deposit_count' => $request->filled('aeps_deposit_count') ? $request->input('aeps_deposit_count') : 0,
        'aeps_deposit_amount' => $request->filled('aeps_deposit_amount') ? $request->input('aeps_deposit_amount') : 0.00,
        'aeps_withdrawal_count' => $request->filled('aeps_withdrawal_count') ? $request->input('aeps_withdrawal_count') : 0,
        'aeps_withdrawal_amount' => $request->filled('aeps_withdrawal_amount') ? $request->input('aeps_withdrawal_amount') : 0.00,
        'rupay_withdrawal_count' => $request->filled('rupay_withdrawal_count') ? $request->input('rupay_withdrawal_count') : 0,
        'rupay_withdrawal_amount' => $request->filled('rupay_withdrawal_amount') ? $request->input('rupay_withdrawal_amount') : 0.00,
        'shg_count' => $request->filled('shg_count') ? $request->input('shg_count') : 0,
        'shg_amount' => $request->filled('shg_amount') ? $request->input('shg_amount') : 0.00,
        'fund_transfer_count' => $request->filled('fund_transfer_count') ? $request->input('fund_transfer_count') : 0,
        'fund_transfer_amount' => $request->filled('fund_transfer_amount') ? $request->input('fund_transfer_amount') : 0.00,
        'tpd_count' => $request->filled('tpd_count') ? $request->input('tpd_count') : 0,
        'tpd_amount' => $request->filled('tpd_amount') ? $request->input('tpd_amount') : 0.00,
        'other_count' => $request->filled('other_count') ? $request->input('other_count') : 0,
        'other_amount' => $request->filled('other_amount') ? $request->input('other_amount') : 0.00,
        'pmjdy_count' => $request->filled('pmjdy_count') ? $request->input('pmjdy_count') : 0,
        'pmjjby_count' => $request->filled('pmjjby_count') ? $request->input('pmjjby_count') : 0,
        'pmsby_count' => $request->filled('pmsby_count') ? $request->input('pmsby_count') : 0,
        'rd_count' => $request->filled('rd_count') ? $request->input('rd_count') : 0,
        'fd_count' => $request->filled('fd_count') ? $request->input('fd_count') : 0,
        'apy_count' => $request->filled('apy_count') ? $request->input('apy_count') : 0,
        'sb_count' => $request->filled('sb_count') ? $request->input('sb_count') : 0,
        'zero_balance_sb_count' => $request->filled('zero_balance_sb_count') ? $request->input('zero_balance_sb_count') : 0,
        'pending_esign_sb_count' => $request->filled('pending_esign_sb_count') ? $request->input('pending_esign_sb_count') : 0,
        'pending_signature_sb_count' => $request->filled('pending_signature_sb_count') ? $request->input('pending_signature_sb_count') : 0,
        'deposited_amount_bank' => $request->filled('deposited_amount_bank') ? $request->input('deposited_amount_bank') : 0.00,
        'closing_cash' => $request->filled('closing_cash') ? $request->input('closing_cash') : 0.00,
        'pending_transaction_count' => $request->filled('pending_transaction_count') ? $request->input('pending_transaction_count') : 0,
        'device_issues' => $request->filled('device_issues') ? $request->input('device_issues') : 'No',
        'issue_details' => $request->filled('issue_details') ? $request->input('issue_details') : '',
        'logout_status' => $request->filled('logout_status') ? $request->input('logout_status') : '',
        'remarks' => $request->filled('remarks') ? $request->input('remarks') : '',
        'challenges' => $request->filled('challenges') ? $request->input('challenges') : [],
    ]);
    
    $validatedData = $request->validate([
        'aeps_deposit_count' => 'integer|min:0|max:1000000',
        'aeps_deposit_amount' => 'numeric|min:0|max:99999999.99',
        'aeps_withdrawal_count' => 'integer|min:0|max:1000000',
        'aeps_withdrawal_amount' => 'numeric|min:0|max:99999999.99',
        'rupay_withdrawal_count' => 'integer|min:0|max:1000000',
        'rupay_withdrawal_amount' => 'numeric|min:0|max:99999999.99',
        'shg_count' => 'integer|min:0|max:1000000',
        'shg_amount' => 'numeric|min:0|max:99999999.99',
        'fund_transfer_count' => 'integer|min:0|max:1000000',
        'fund_transfer_amount' => 'numeric|min:0|max:99999999.99',
        'tpd_count' => 'integer|min:0|max:1000000',
        'tpd_amount' => 'numeric|min:0|max:99999999.99',
        'other_count' => 'integer|min:0|max:1000000',
        'other_amount' => 'numeric|min:0|max:99999999.99',
        'pmjdy_count' => 'integer|min:0|max:1000000',
        'pmjjby_count' => 'integer|min:0|max:1000000',
        'pmsby_count' => 'integer|min:0|max:1000000',
        'rd_count' => 'integer|min:0|max:1000000',
        'fd_count' => 'integer|min:0|max:1000000',
        'apy_count' => 'integer|min:0|max:1000000',
        'sb_count' => 'integer|min:0|max:1000000',
        'zero_balance_sb_count' => 'integer|min:0|max:1000000',
        'pending_esign_sb_count' => 'integer|min:0|max:1000000',
        'pending_signature_sb_count' => 'integer|min:0|max:1000000',
        'deposited_amount_bank' => 'numeric|min:0|max:99999999.99',
        'closing_cash' => 'numeric|min:0|max:99999999.99',
        'pending_transaction_count' => 'integer|min:0|max:1000000',
        'device_issues' => 'in:Yes,No',
        'issue_details' => 'nullable|required_if:device_issues,Yes|string|max:1000',
        'logout_status' => 'string|max:50',
        'remarks' => 'nullable|string|max:1000',
        'challenges' => 'nullable|array',
        'challenges.*' => 'string|max:255',
    ]);
    

    // Convert challenges array to JSON
    $validatedData['challenges'] = json_encode($request->challenges ?? []);
    $validatedData['entry_type'] = 'end';

    // Find the existing entry for the logged-in user where entry_type is 'start'
    $dayEntry = DayStartEnd::where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->where('entry_type', 'start')
        ->first();

    if ($dayEntry) {
        // Update the existing record
        $dayEntry->update($validatedData);
        return response()->json(['message' => 'Day End Data updated successfully']);
    } else {
        return response()->json(['message' => 'You dont have any pending entry for today'], 404);
    }
}
    


    public function show($id)
    {
        $transaction = DayStartEnd::findOrFail($id);
        return response()->json($transaction);
    }

    public function edit($id)
    {
        $transaction = DayStartEnd::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'aeps_deposit_count' => 'integer|min:0|max:1000000',
        'aeps_deposit_amount' => 'numeric|min:0|max:99999999.99',
        'aeps_withdrawal_count' => 'integer|min:0|max:1000000',
        'aeps_withdrawal_amount' => 'numeric|min:0|max:99999999.99',
        'rupay_withdrawal_count' => 'integer|min:0|max:1000000',
        'rupay_withdrawal_amount' => 'numeric|min:0|max:99999999.99',
        'shg_count' => 'integer|min:0|max:1000000',
        'shg_amount' => 'numeric|min:0|max:99999999.99',
        'fund_transfer_count' => 'integer|min:0|max:1000000',
        'fund_transfer_amount' => 'numeric|min:0|max:99999999.99',
        'tpd_count' => 'integer|min:0|max:1000000',
        'tpd_amount' => 'numeric|min:0|max:99999999.99',
        'other_count' => 'integer|min:0|max:1000000',
        'other_amount' => 'numeric|min:0|max:99999999.99',
        'pmjdy_count' => 'integer|min:0|max:1000000',
        'pmjjby_count' => 'integer|min:0|max:1000000',
        'pmsby_count' => 'integer|min:0|max:1000000',
        'rd_count' => 'integer|min:0|max:1000000',
        'fd_count' => 'integer|min:0|max:1000000',
        'apy_count' => 'integer|min:0|max:1000000',
        'sb_count' => 'integer|min:0|max:1000000',
        'ekyc_processed' => 'integer|min:0|max:1000000',
        'deposited_amount_bank' => 'numeric|min:0|max:99999999.99',
        'closing_cash' => 'numeric|min:0|max:99999999.99',
        'pending_transaction_count' => 'integer|min:0|max:1000000',
        'device_issues' => 'in:Yes,No',
        'issue_details' => 'nullable|required_if:device_issues,Yes|string|max:1000',
        'logout_status' => 'string|max:50',
        'remarks' => 'nullable|string|max:1000',
        'challenges' => 'nullable|array', // Challenges should be an array
        'challenges.*' => 'string|max:255', // Each challenge should be a string
    ]);

    // Find the record in the database
    $record = DayStartEnd::findOrFail($id);

    // Convert challenges array to JSON for database storage
    $challengesJson = json_encode($request->challenges);

    // Merge user_id before updating
    $request->merge([
        'user_id' => Auth::id(),
        'challenges' => $challengesJson, // Store as JSON
    ]);

    // Update the existing record
    $record->update($request->except(['challenges']) + ['challenges' => $challengesJson]);

    return response()->json(['message' => 'Transaction updated successfully']);
}


    public function destroy($id)
    {
        $transaction = DayStartEnd::findOrFail($id);
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }



    // day begin data operations

    public function storeDayBeginData(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'login_status'     => 'string|in:Successful,Failure',
            'opening_balance'  => 'numeric|min:0',
            'issues_at_start'  => 'nullable|array',
            'issues_at_start.*'=> 'string',
            'day_start_remarks' => 'nullable|string',
        ]);

        // Add the authenticated user ID
        $validatedData['user_id'] = Auth::id();
        $validatedData['entry_type'] = 'start';
        $validatedData['issues_at_start'] = json_encode($request->issues_at_start ?? []); // Ensure it's not null

        // Store the data in the database
        DayStartEnd::create($validatedData);

        // Return a JSON response
        return response()->json([
            'message' => 'Day Begin Details saved successfully!',
            'status'  => 'success'
        ], 200);
    }
}