<?php

declare(strict_types=1);

namespace App\Domain\TransactionType\Enums;

use App\Models\TransactionType;

enum TransactionTypeEnum: int
{
    case BUY = 1;
    case SELL = 2;
    case DIVIDEND = 3;
    case INTEREST = 4;

    public static function fromTrading212Action(string $action): ?self
    {
        return match ($action) {
            TransactionType::TRADING_212_BUY_ACTION => self::BUY,
            TransactionType::TRADING_212_SELL_ACTION => self::SELL,
            default => null,
        };
    }
}
