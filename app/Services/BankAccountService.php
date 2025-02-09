<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\User;

class BankAccountService
{
    public function createAccount(User $user)
    {
        BankAccount::create([
            'user_id' => $user->id,
            'wallet_code' => $this->generateWalletCode(),
            'balance' => 0,
            'income' => 0,
            'expenses' => 0,
            'account_type' => 'wallet',
        ]);
    }

    private function generateWalletCode()
    {
        return md5(uniqid());
    }

    public function deposit(BankAccount $account, $amount)
    {
        $account->balance += $amount;
        $account->income += $amount;
        $account->save();
    }

    public function withdraw(BankAccount $account, $amount)
    {
        $account->balance -= $amount;
        $account->expenses -= $amount;
        $account->save();
    }

    public function transfer(BankAccount $source, BankAccount $destination, $amount)
    {
        $this->withdraw($source, $amount);
        $this->deposit($destination, $amount);
    }

    public function getTransactionsHistoryPaginated(BankAccount $account, $perPage = 10)
    {
        return $account->transactionsHistoryPaginated($perPage);
    }

    public function getTransactionsHistory(BankAccount $account)
    {
        return $account->transactionsHistory();
    }
}
