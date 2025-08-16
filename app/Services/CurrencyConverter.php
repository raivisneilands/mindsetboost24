<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    /**
     * Convert an amount from base currency (EUR) to target currency.
     * Cached per currency for 12 hours.
     *
     * @param float $amount
     * @param string $currencyCode
     * @return float
     */
    public static function convert(float $amount, string $currencyCode): float
    {
        $baseCurrency = env('BASE_CURRENCY', 'EUR');

        if ($currencyCode === $baseCurrency) {
            return round($amount, 2);
        }

        // Fetch and cache the rates for this currency
        $rates = Cache::remember('currency_rates_usd', 24 * 60 * 60, function () {
            $response = Http::get('https://openexchangerates.org/api/latest.json', [
                'app_id' => env('EXCHANGE_RATE_API_KEY'),
            ]);

            if ($response->failed()) {
                return [];
            }

            return $response->json()['rates'] ?? [];
        });

        // USD-based conversion
        $eurToUsd = $rates['EUR'] ?? 1;
        $targetRate = $rates[$currencyCode] ?? 1;

        $amountInUsd = $amount / $eurToUsd; // EUR → USD
        $converted = $amountInUsd * $targetRate; // USD → target currency

        return round($converted, 2);
    }
}
