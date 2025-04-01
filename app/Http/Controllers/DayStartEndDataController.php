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
    $validatedData = $request->validate([
        'aeps_deposit_count' => 'required|integer|min:0|max:1000000',
        'aeps_deposit_amount' => 'required|numeric|min:0|max:99999999.99',
        'aeps_withdrawal_count' => 'required|integer|min:0|max:1000000',
        'aeps_withdrawal_amount' => 'required|numeric|min:0|max:99999999.99',
        'rupay_withdrawal_count' => 'required|integer|min:0|max:1000000',
        'rupay_withdrawal_amount' => 'required|numeric|min:0|max:99999999.99',
        'shg_count' => 'required|integer|min:0|max:1000000',
        'shg_amount' => 'required|numeric|min:0|max:99999999.99',
        'fund_transfer_count' => 'required|integer|min:0|max:1000000',
        'fund_transfer_amount' => 'required|numeric|min:0|max:99999999.99',
        'tpd_count' => 'required|integer|min:0|max:1000000',
        'tpd_amount' => 'required|numeric|min:0|max:99999999.99',
        'other_count' => 'required|integer|min:0|max:1000000',
        'other_amount' => 'required|numeric|min:0|max:99999999.99',
        'pmjdy_count' => 'required|integer|min:0|max:1000000',
        'pmjjby_count' => 'required|integer|min:0|max:1000000',
        'pmsby_count' => 'required|integer|min:0|max:1000000',
        'rd_count' => 'required|integer|min:0|max:1000000',
        'fd_count' => 'required|integer|min:0|max:1000000',
        'apy_count' => 'required|integer|min:0|max:1000000',
        'sb_count' => 'required|integer|min:0|max:1000000',
        'ekyc_processed' => 'required|integer|min:0|max:1000000',
        'deposited_amount_bank' => 'required|numeric|min:0|max:99999999.99',
        'closing_cash' => 'required|numeric|min:0|max:99999999.99',
        'pending_transaction_count' => 'required|integer|min:0|max:1000000',
        'device_issues' => 'required|in:Yes,No',
        'issue_details' => 'nullable|required_if:device_issues,Yes|string|max:1000',
        'logout_status' => 'required|string|max:50',
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
        'aeps_deposit_count' => 'required|integer|min:0|max:1000000',
        'aeps_deposit_amount' => 'required|numeric|min:0|max:99999999.99',
        'aeps_withdrawal_count' => 'required|integer|min:0|max:1000000',
        'aeps_withdrawal_amount' => 'required|numeric|min:0|max:99999999.99',
        'rupay_withdrawal_count' => 'required|integer|min:0|max:1000000',
        'rupay_withdrawal_amount' => 'required|numeric|min:0|max:99999999.99',
        'shg_count' => 'required|integer|min:0|max:1000000',
        'shg_amount' => 'required|numeric|min:0|max:99999999.99',
        'fund_transfer_count' => 'required|integer|min:0|max:1000000',
        'fund_transfer_amount' => 'required|numeric|min:0|max:99999999.99',
        'tpd_count' => 'required|integer|min:0|max:1000000',
        'tpd_amount' => 'required|numeric|min:0|max:99999999.99',
        'other_count' => 'required|integer|min:0|max:1000000',
        'other_amount' => 'required|numeric|min:0|max:99999999.99',
        'pmjdy_count' => 'required|integer|min:0|max:1000000',
        'pmjjby_count' => 'required|integer|min:0|max:1000000',
        'pmsby_count' => 'required|integer|min:0|max:1000000',
        'rd_count' => 'required|integer|min:0|max:1000000',
        'fd_count' => 'required|integer|min:0|max:1000000',
        'apy_count' => 'required|integer|min:0|max:1000000',
        'sb_count' => 'required|integer|min:0|max:1000000',
        'ekyc_processed' => 'required|integer|min:0|max:1000000',
        'deposited_amount_bank' => 'required|numeric|min:0|max:99999999.99',
        'closing_cash' => 'required|numeric|min:0|max:99999999.99',
        'pending_transaction_count' => 'required|integer|min:0|max:1000000',
        'device_issues' => 'required|in:Yes,No',
        'issue_details' => 'nullable|required_if:device_issues,Yes|string|max:1000',
        'logout_status' => 'required|string|max:50',
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
            'login_status'     => 'required|string|in:Successful,Failure',
            'opening_balance'  => 'required|numeric|min:0',
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