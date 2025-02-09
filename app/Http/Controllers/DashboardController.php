<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transfer\DepositRequest;
use App\Http\Requests\Transfer\ReceiptRequest;
use App\Http\Requests\Transfer\TransferRequest;
use App\Models\BankAccount;
use App\Services\Contracts\BankAccountServiceInterface;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    protected $bankAccountService;

    public function __construct(BankAccountServiceInterface $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    public function index(): Response
    {
        $user = Auth::user();
        $bankAccount = BankAccount::where('user_id', $user->id)
            ->with(['transactions' => function ($query) {
                $query->orderBy('created_at', 'desc');
                $query->limit(10);
            }])
            ->first();

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

        if (!$destination) {
            return redirect()->back()->withErrors(['wallet_destination' => 'The destination wallet does not exist']);
        }

        if ($source->wallet_code === $destination->wallet_code) {
            return redirect()->back()->withErrors(['wallet_destination' => 'You cannot transfer to the same wallet']);
        }

        if ($source->balance < $amount) {
            return redirect()->back()->withErrors(['amount' => 'Insufficient funds']);
        }

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
        $bankAccountId = Auth::user()->bankAccount->id;

        $transactions = BankAccount::find($bankAccountId)
            ->transactions()
            ->where('transaction_group', $validated['group'])
            ->get();

        return response()->json($transactions);
    }
}
