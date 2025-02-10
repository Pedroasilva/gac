<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\User;
use App\Services\Contracts\BankAccountServiceInterface;
use App\Services\Contracts\TransactionServiceInterface;
use Illuminate\Support\Str;

class BankAccountService implements BankAccountServiceInterface
{
    protected $transactionService;

    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

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

    public function deposit(BankAccount $account, $amount, $isTransfer = false)
    {
        $account->balance += $amount;
        $account->income += $amount;
        $account->save();

        if (!$isTransfer) {
            $this->transactionService->deposit($account, $amount, 'Deposit', $this->generateTransactionGroup());
        }
    }

    public function withdraw(BankAccount $account, $amount, $isTransfer = false)
    {
        $account->balance -= $amount;
        $account->expenses += $amount;
        $account->save();

        if (!$isTransfer) {
            $this->transactionService->withdraw($account, $amount, 'Withdraw', $this->generateTransactionGroup());
        }
    }

    public function transfer(BankAccount $source, BankAccount $destination, $amount)
    {
        $transactionGroup = $this->generateTransactionGroup();

        $this->withdraw($source, $amount, true);
        $this->transactionService->withdraw($source, $amount, 'Transfer to ' . $destination->wallet_code, $transactionGroup);

        $this->deposit($destination, $amount, true);
        $this->transactionService->deposit($destination, $amount, 'Transfer from ' . $source->wallet_code, $transactionGroup);
    }

    public function getTransactionsHistoryPaginated(BankAccount $account, $perPage = 10)
    {
        return $account->transactionsHistoryPaginated($perPage);
    }

    public function getTransactionsHistory(BankAccount $account)
    {
        return $account->transactionsHistory();
    }

    private function generateTransactionGroup()
    {
        return Str::uuid();
    }

    public function getBankAccountWithTransactions(User $user)
    {
        return BankAccount::where('user_id', $user->id)
            ->with(['transactions' => function ($query) {
                $query->orderBy('created_at', 'desc');
                $query->limit(15);
            }])
            ->first();
    }

    public function getTransactionByGroup(BankAccount $bankAccount, $group)
    {
        return $bankAccount->transactions()
            ->where('transaction_group', $group)
            ->first();
    }

    public function reverse($transactions)
    {
        foreach ($transactions as $transaction) {
            $account = $transaction->bankAccount;
            if ($transaction->transaction_type == 'in') {
                $account->balance -= $transaction->amount;
                $account->income -= $transaction->amount;
            }else if ($transaction->transaction_type == 'out') {
                $account->balance += $transaction->amount;
                $account->expenses -= $transaction->amount;
            }
            $account->save();

            $transaction->reversed = true;
            $transaction->save();
        }
    }

}
