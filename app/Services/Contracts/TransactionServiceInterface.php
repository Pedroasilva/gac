<?php

namespace App\Services\Contracts;

use App\Models\BankAccount;

interface TransactionServiceInterface
{
    public function deposit(BankAccount $account, $amount, $description = null, $transactionGroup);
    public function withdraw(BankAccount $account, $amount, $description = null, $transactionGroup);
    public function transfer(BankAccount $source, BankAccount $destination, $amount, $description = null, $transactionGroup);
}
