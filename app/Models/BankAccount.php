<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'user_id',
        'account_number',
        'agency',
        'balance',
        'income',
        'expenses',
        'account_type',
        'wallet_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function transactionsHistory()
    {
        return $this->transactions()->orderBy('created_at', 'desc')->get();
    }

    public function transactionsHistoryPaginated($perPage = 10)
    {
        return $this->transactions()->orderBy('created_at', 'desc')->paginate($perPage);
    }

}
