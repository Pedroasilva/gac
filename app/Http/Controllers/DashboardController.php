<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transfer\TransferRequest;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
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
        $request = $request->validated();
        
        $amount = $request['amount'];
        $source = Auth::user()->bankAccount;
        $destination = BankAccount::where('wallet_code', $request['wallet_destination'])->first();

        if ($source->balance < $amount) {
            return redirect()->back()->with('error', 'Insufficient funds');
        }

        $source->withdraw($amount);
        $destination->deposit($amount);

        return redirect()->back()->with('success', 'Transfer successful');
    }
}
