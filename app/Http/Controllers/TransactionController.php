<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
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