<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $fillable = [
        'name',
    ];

    const TRADING_212_BUY_ACTION = 'Market buy';
    const TRADING_212_SELL_ACTION = 'Market sell';
}
