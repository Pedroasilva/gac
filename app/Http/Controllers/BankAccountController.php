<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Services\BankAccountService;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    protected $bankAccountService;

    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    public function deposit(Request $request, BankAccount $account)
    {
        $this->bankAccountService->deposit($account, $request->amount);
        return response()->json(['message' => 'Deposit successful']);
    }

    public function withdraw(Request $request, BankAccount $account)
    {
        $this->bankAccountService->withdraw($account, $request->amount);
        return response()->json(['message' => 'Withdrawal successful']);
    }

    public function transfer(Request $request, BankAccount $source, BankAccount $destination)
    {
        $this->bankAccountService->transfer($source, $destination, $request->amount);
        return response()->json(['message' => 'Transfer successful']);
    }
}
