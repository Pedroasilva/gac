<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function rules()
    {
        return [
            'wallet_destination' => 'required|string',
            'amount' => 'required|numeric',
        ];
    }
}
