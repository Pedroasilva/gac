<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function deposit(Request $request, BankAccount $account)
    {
        $this->transactionService->deposit($account, $request->amount, $request->description);
        return response()->json(['message' => 'Deposit successful']);
    }

    public function withdraw(Request $request, BankAccount $account)
    {
        $this->transactionService->withdraw($account, $request->amount, $request->description);
        return response()->json(['message' => 'Withdrawal successful']);
    }

    public function transfer(Request $request, BankAccount $source, BankAccount $destination)
    {
        $this->transactionService->transfer($source, $destination, $request->amount, $request->description);
        return response()->json(['message' => 'Transfer successful']);
    }
}
