<?php

declare(strict_types=1);

namespace App\Domain\Currency\Services;

final class CurrencyFormatterService
{
    /**
     * Format a numeric value as currency.
     *
     * @param float $value The numeric value to format
     * @param string $currency The currency code (e.g., 'USD', 'EUR')
     * @return string The formatted currency string
     */
    public function format(float $value, string $currency): string
    {
        return (new \NumberFormatter('sk_SK', \NumberFormatter::CURRENCY))
            ->formatCurrency($value, $currency);
    }

    /**
     * Get the full name of a currency by its code.
     *
     * @param string $code The currency code (e.g., 'USD', 'EUR')
     * @return string The currency name
     */
    public function getNameByCode(string $code): string
    {
        return match ($code) {
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'JPY' => 'Japanese Yen',
            'CAD' => 'Canadian Dollar',
            'AUD' => 'Australian Dollar',
            'CHF' => 'Swiss Franc',
            'CNY' => 'Chinese Yuan',
            'HKD' => 'Hong Kong Dollar',
            'SGD' => 'Singapore Dollar',
            default => $code,
        };
    }
}
