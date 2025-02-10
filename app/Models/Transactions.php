<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_account_id',
        'transaction_type',
        'amount',
        'description',
        'transaction_group',
        'reversed',
    ];

    public $timestamps = false;

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function transactionsHistory()
    {
        return $this->orderBy('created_at', 'desc')->get();
    }

    public function transactionsHistoryPaginated($perPage = 10)
    {
        return $this->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
