<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\Transactions;

class TransactionService
{
    public function deposit(BankAccount $account, $amount, $description = null)
    {
        $account->balance += $amount;
        $account->save();

        Transactions::create([
            'bank_account_id' => $account->id,
            'transaction_type' => 'in',
            'amount' => $amount,
            'description' => $description,
        ]);
    }

    public function withdraw(BankAccount $account, $amount, $description = null)
    {
        $account->balance -= $amount;
        $account->save();

        Transactions::create([
            'bank_account_id' => $account->id,
            'transaction_type' => 'out',
            'amount' => $amount,
            'description' => $description,
        ]);
    }

    public function transfer(BankAccount $source, BankAccount $destination, $amount, $description = null)
    {
        $this->withdraw($source, $amount, $description);
        $this->deposit($destination, $amount, $description);
    }
}
