<?php

use App\Services\CurrencyConverter;

if (!function_exists('display_price')) {
    /**
     * Convert an amount from base currency to user-selected currency and return formatted string.
     *
     * @param float $amount
     * @return string
     */
    function display_price(float $amount): string
    {
        $currency = session('currency', 'EUR'); // default EUR
        $converted = CurrencyConverter::convert($amount, $currency);

        $symbol = match($currency) {
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            'CAD' => 'C$',
            'AUD' => 'A$',
            default => $currency . ' ',
        };

        return $symbol . number_format($converted, 2);
    }
}
