<?php

namespace Database\Factories;

use App\Models\BankAccount;
use App\Models\Transactions;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionsFactory extends Factory
{
    protected $model = Transactions::class;

    public function definition()
    {
        return [
            'bank_account_id' => BankAccount::factory(),
            'transaction_type' => $this->faker->randomElement(['in', 'out']),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'description' => $this->faker->sentence,
            'transaction_group' => $this->faker->uuid(),
            'reversed' => $this->faker->boolean(),
            ];
    }
}
