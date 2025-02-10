<?php

namespace Database\Factories;

use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankAccountFactory extends Factory
{
    protected $model = BankAccount::class;

    public function definition()
    {
        return [
            'balance' => '900.00',
            'account_type' => 'wallet',
            'wallet_code' => (string) $this->faker->unique()->randomNumber(8),
            'expenses' => '100.00',
            'income' => '1000.00',
        ];
    }
}
