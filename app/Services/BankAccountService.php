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
            'account_number' => $this->generateAccountNumber(),
            'agency' => $this->generateAgencyNumber(),
            'balance' => 0,
            'account_type' => 'wallet',
        ]);
    }

    private function generateAgencyNumber()
    {
        return rand(1000, 9999);
    }

    private function generateAccountNumber()
    {
        return rand(1000000000, 9999999999);
    }

    public function deposit(BankAccount $account, $amount)
    {
        $account->balance += $amount;
        $account->save();
    }

    public function withdraw(BankAccount $account, $amount)
    {
        $account->balance -= $amount;
        $account->save();
    }

    public function transfer(BankAccount $source, BankAccount $destination, $amount)
    {
        $this->withdraw($source, $amount);
        $this->deposit($destination, $amount);
    }
}
