<?php

namespace App\Http\Controllers;

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
        $bankAccount = BankAccount::where('user_id', $user->id)
            ->with(['transactions' => function ($query) {
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
            return redirect()->back()->with('error', 'Destination account not found');
        }

        if ($source->balance < $amount) {
            return redirect()->back()->with('error', 'Insufficient funds');
        }

        $this->bankAccountService->transfer($source, $destination, $amount);

        return redirect()->back()->with('success', 'Transfer successful');
    }
}
