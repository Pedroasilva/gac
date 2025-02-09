<?php

namespace App\Services;

use App\Models\BankAccount;

class BankAccountService
{
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
