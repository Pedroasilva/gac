<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\Transactions;
use App\Services\Contracts\TransactionServiceInterface;

class TransactionService implements TransactionServiceInterface
{
    public function deposit(BankAccount $account, $amount, $description = null, $transactionGroup)
    {
        Transactions::create([
            'bank_account_id' => $account->id,
            'transaction_type' => 'in',
            'amount' => $amount,
            'description' => $description,
            'transaction_group' => $transactionGroup
        ]);
    }

    public function withdraw(BankAccount $account, $amount, $description = null, $transactionGroup)
    {
        Transactions::create([
            'bank_account_id' => $account->id,
            'transaction_type' => 'out',
            'amount' => $amount,
            'description' => $description,
            'transaction_group' => $transactionGroup
        ]);
    }

    public function transfer(BankAccount $source, BankAccount $destination, $amount, $description = null, $transactionGroup)
    {
        $this->withdraw($source, $amount, $description, $transactionGroup);
        $this->deposit($destination, $amount, $description, $transactionGroup);
    }

    public function getTransactionsByGroup($group)
    {
        return Transactions::where('transaction_group', $group)->get();
    }
}
