<?php

namespace Tests\Unit\Services;

use App\Models\BankAccount;
use App\Models\Transactions;
use App\Models\User;
use App\Services\BankAccountService;
use App\Services\Contracts\TransactionServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class BankAccountServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $transactionService;
    protected $bankAccountService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transactionService = $this->createMock(TransactionServiceInterface::class);
        $this->bankAccountService = new BankAccountService($this->transactionService);
    }

    public function test_create_account()
    {
        $user = User::factory()->create();

        $this->bankAccountService->createAccount($user);

        $this->assertDatabaseHas('bank_accounts', [
            'user_id' => $user->id,
            'balance' => 0,
            'income' => 0,
            'expenses' => 0,
            'account_type' => 'wallet',
        ]);
    }

    public function test_deposit()
    {
        $user = User::factory()->create();
        $account = BankAccount::factory()->create(['balance' => 100, 'income' => 100, 'user_id' => $user->id]);

        $this->bankAccountService->deposit($account, 50);

        $this->assertEquals(150, $account->balance);
        $this->assertEquals(150, $account->income);
    }

    public function test_withdraw()
    {
        $user = User::factory()->create();
        $account = BankAccount::factory()->create(['balance' => 100, 'expenses' => 50, 'user_id' => $user->id]);

        $this->bankAccountService->withdraw($account, 30);

        $this->assertEquals(70, $account->balance);
        $this->assertEquals(80, $account->expenses);
    }

    public function test_transfer()
    {
        $user = User::factory()->create();
        $source = BankAccount::factory()->create(['balance' => 1000, 'user_id' => $user->id]);
        $user = User::factory()->create();
        $destination = BankAccount::factory()->create(['balance' => 500, 'user_id' => $user->id]);

        $this->bankAccountService->transfer($source, $destination, 200);

        $this->assertEquals(800, $source->balance);
        $this->assertEquals(700, $destination->balance);
    }

    public function test_get_bank_account_with_transactions()
    {
        $user = User::factory()->create();
        $bankAccount = BankAccount::factory()->create(['user_id' => $user->id]);
        Transactions::factory()->count(5)->create(['bank_account_id' => $bankAccount->id]);

        $result = $this->bankAccountService->getBankAccountWithTransactions($user);

        $this->assertEquals($bankAccount->id, $result->id);
        $this->assertCount(5, $result->transactions);
    }

    public function test_get_transaction_by_group()
    {
        $user = User::factory()->create();
        $bankAccount = BankAccount::factory()->create(['user_id' => $user->id]);
        $transactionGroup = Str::uuid();
        $transaction = Transactions::factory()->create(['bank_account_id' => $bankAccount->id, 'transaction_group' => $transactionGroup]);

        $result = $this->bankAccountService->getTransactionByGroup($bankAccount, $transactionGroup);

        $this->assertEquals($transaction->id, $result->id);
    }

    public function test_reverse()
    {
        $user = User::factory()->create();
        $bankAccount = BankAccount::factory()->create(['balance' => 1000, 'income' => 1000, 'expenses' => 0, 'user_id' => $user->id]);
        $transaction = Transactions::factory()->create(['bank_account_id' => $bankAccount->id, 'amount' => 100, 'transaction_type' => 'in']);

        $this->bankAccountService->reverse([$transaction]);

        $this->assertEquals(1000, $bankAccount->balance);
        $this->assertEquals(1000, $bankAccount->income);
    }
}
