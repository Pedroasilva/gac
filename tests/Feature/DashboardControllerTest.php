<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\DashboardController;
use App\Models\BankAccount;
use App\Models\Transactions;
use App\Models\User;
use App\Services\BankAccountService;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $bankAccountService;
    protected $transactionService;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bankAccountService = $this->createMock(BankAccountService::class);
        $this->transactionService = $this->createMock(TransactionService::class);
        $this->controller = new DashboardController($this->bankAccountService, $this->transactionService);
    }

    public function test_dashboard_return_bank_account_with_transactions()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $bankAccount = BankAccount::factory()->create(['user_id' => $user->id]);
        $transactions = Transactions::factory()->count(5)->create(['bank_account_id' => $bankAccount->id]);
        $bankAccount->transactions = $transactions;

        $this->bankAccountService->method('getBankAccountWithTransactions')->willReturn($bankAccount);

        $response = $this->get(route('dashboard'));

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Dashboard')
                ->has('bankAccount')
                ->has('bankAccount.transactions', 5)
        );
    }

    public function test_dashboard_make_a_deposit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $bankAccount = BankAccount::factory()->create(['user_id' => $user->id]);
        $amount = 1000;

        $this->bankAccountService->method('deposit')->willReturn($bankAccount);

        $response = $this->post(route('deposit.make'), ['amount' => $amount]);

        $response->assertSessionHas('success', 'Deposit successful');
    }

    public function test_dashboard_make_a_transfer_successful()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $source = BankAccount::factory()->create(['user_id' => $user->id, 'balance' => 1000]);

        $destinationUser = User::factory()->create();
        $destination = BankAccount::factory()->create(['user_id' => $destinationUser->id]);
        $amount = 1000;

        $this->bankAccountService->method('transfer')->willReturn($source);

        $response = $this->post(route('transfer.make'), ['amount' => $amount, 'wallet_destination' => $destination->wallet_code]);

        $response->assertSessionHas('success', 'Transfer successful');
    }

    public function test_dashboard_make_a_transfer_fail()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $source = BankAccount::factory()->create(['user_id' => $user->id]);

        $destinationUser = User::factory()->create();
        $destination = BankAccount::factory()->create(['user_id' => $destinationUser->id]);
        $amount = 1000;

        $this->bankAccountService->method('transfer')->willThrowException(
            ValidationException::withMessages(['amount' => 'Insufficient funds'])
        );

        $response = $this->post(route('transfer.make'), ['amount' => $amount, 'wallet_destination' => $destination->wallet_code]);

        $response->assertSessionHasErrors(['amount' => 'Insufficient funds']);
    }

    public function test_view_a_transaction_receipt()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $bankAccount = BankAccount::factory()->create(['user_id' => $user->id]);
        $transactions = Transactions::factory()->count(1)->create(['bank_account_id' => $bankAccount->id]);

        $this->bankAccountService->method('getTransactionByGroup')->willReturn($transactions);

        $response = $this->get(route('receipt.get') . '?group=' . $transactions->first()->transaction_group);

        $response->assertJsonFragment([
            'id' => $bankAccount->id,
        ])->assertJsonFragment([
            'transaction_group' => $transactions->first()->transaction_group,
        ]);
    }

    public function test_reverse_a_transaction()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $bankAccount = BankAccount::factory()->create(['user_id' => $user->id]);
        $transactions = Transactions::factory()->count(1)->create(['bank_account_id' => $bankAccount->id]);

        $this->transactionService->method('getTransactionsByGroup')->willReturn($transactions);
        $this->bankAccountService->method('reverse')->willReturn($transactions);

        $response = $this->post(route('transaction.reverse'), ['group' => $transactions->first()->transaction_group]);

        $response->assertSessionHas('success', 'Transaction reversed');
    }
}
