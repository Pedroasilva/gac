<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\BankAccount;

class TransferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'wallet_destination' => ['required', 'string', 'exists:bank_accounts,wallet_code'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $source = Auth::user()->bankAccount;
            $destination = BankAccount::where('wallet_code', $this->wallet_destination)->first();

            if (!$destination) {
                $validator->errors()->add('wallet_destination', 'The destination wallet does not exist');
                return;
            }

            if ($source->wallet_code === $destination->wallet_code) {
                $validator->errors()->add('wallet_destination', 'You cannot transfer to the same wallet');
                return;
            }

            if ($source->balance < $this->amount) {
                $validator->errors()->add('amount', 'Insufficient funds');
                return;
            }
        });
    }
}
