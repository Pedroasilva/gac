<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'group' => 'required|exists:transactions,transaction_group',
        ];
    }
}
