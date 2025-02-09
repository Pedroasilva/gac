<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transfer\DepositRequest;
use App\Http\Requests\Transfer\ReceiptRequest;
use App\Http\Requests\Transfer\TransferRequest;
use App\Models\BankAccount;
use App\Services\BankAccountService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    protected $bankAccountService;

    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    public function index(): Response
    {
        $user = Auth::user();
        $bankAccount = $this->bankAccountService->getBankAccountWithTransactions($user);

        return Inertia::render('Dashboard', [
            'bankAccount' => $bankAccount,
        ]);
    }

    public function transfer(TransferRequest $request)
    {
        $validated = $request->validated();

        $amount = $validated['amount'];
        $source = Auth::user()->bankAccount;
        $destination = BankAccount::where('wallet_code', $validated['wallet_destination'])->first();

        $this->bankAccountService->transfer($source, $destination, $amount);

        return redirect()->back()->with('success', 'Transfer successful');
    }

    public function deposit(DepositRequest $request)
    {
        $validated = $request->validated();
        $bankAccount = Auth::user()->bankAccount;

        $this->bankAccountService->deposit($bankAccount, $validated['amount']);

        return redirect()->back()->with('success', 'Deposit successful');
    }

    public function receipt(ReceiptRequest $request)
    {
        $validated = $request->validated();
        $bankAccount = Auth::user()->bankAccount;

        $transactions = $this->bankAccountService->getTransactionsByGroup($bankAccount, $validated['group']);

        return response()->json([
            'bankAccount' => $bankAccount,
            'transactions' => $transactions,
        ]);
    }
}
