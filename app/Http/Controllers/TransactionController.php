<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function checkTransactionToday()
    {
        // Get the current date in Y-m-d format
        $today = Carbon::now()->toDateString();

        // Get the logged-in user's ID
        $userId = Auth::id();

        // Check if there's any transaction for the logged-in user today
        $transactionExists = Transaction::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->exists();

        // Return true or false
        return response()->json(['exists' => $transactionExists]);
    }
    public function index()
    {
        $transactions = Transaction::all();
        return view('pages.record-transaction');
    }
    public function fetch()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'deposit_count' => 'required|integer|min:1|max:1000000',
            'deposit_amount' => 'required|numeric|min:0|max:99999999.99',
            'withdrawal_count' => 'required|integer|min:1|max:1000000',
            'withdrawal_amount' => 'required|numeric|min:0|max:99999999.99',
            'transfer_count' => 'required|integer|min:1|max:1000000',
            'transfer_amount' => 'required|numeric|min:0|max:99999999.99',
            'other_count' => 'required|integer|min:1|max:1000000',
            'other_details' => 'nullable|string|max:500',
            'enrollment_count' => 'required|integer|min:1|max:1000000',
            'savings_count' => 'required|integer|min:1|max:1000000',
            'deposit_accounts' => 'required|integer|min:1|max:1000000',
            'aadhaar_seeding' => 'required|integer|min:1|max:1000000',
            'ekyc_processed' => 'required|integer|min:1|max:1000000',
            'device_issues' => 'required|in:Yes,No',
            'issue_details' => 'nullable|required_if:device_issues,Yes|string|max:1000',
        ]);

        // Add the user_id to the request data
        $request->merge([
            'user_id' => Auth::id()
        ]);
        Transaction::create($request->all());

        return response()->json(['message' => 'Transaction saved successfully']);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'deposit_count' => 'required|integer',
            'deposit_amount' => 'required|numeric',
            'withdrawal_count' => 'required|integer',
            'withdrawal_amount' => 'required|numeric',
            'transfer_count' => 'required|integer',
            'transfer_amount' => 'required|numeric',
            'other_count' => 'required|integer',
            'other_details' => 'nullable|string',
            'enrollment_count' => 'required|integer',
            'savings_count' => 'required|integer',
            'deposit_accounts' => 'required|integer',
            'aadhaar_seeding' => 'required|integer',
            'ekyc_processed' => 'required|integer',
            'device_issues' => 'required|in:Yes,No',
            'issue_details' => 'nullable|required_if:device_issues,Yes|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());

        return response()->json(['message' => 'Transaction updated successfully']);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}