<?php

namespace App\Services\Contracts;

use App\Models\BankAccount;
use App\Models\User;

interface BankAccountServiceInterface
{
    public function createAccount(User $user);
    public function deposit(BankAccount $account, $amount, $isTransfer = false);
    public function withdraw(BankAccount $account, $amount, $isTransfer = false);
    public function transfer(BankAccount $source, BankAccount $destination, $amount);
}
