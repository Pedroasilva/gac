<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $bankAccount = BankAccount::where('user_id', $user->id)->with('transactions')->first();

        return Inertia::render('Dashboard', [
            'bankAccount' => $bankAccount,
            'transactions' => $bankAccount ? $bankAccount->transactions : [],
        ]);
    }
}
