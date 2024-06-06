<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyController extends Controller
{
    /**
     * Get the latest currency rates.
     *
     * @authenticated
     *
     * @response 200 {
     *   "rates": {
     *     "USD": 1,
     *     "EUR": 0.89,
     *     "GBP": 0.78
     *   },
     *   "base": "USD",
     *   "date": "2024-06-05"
     * }
     * @response 500 {
     *   "error": "Unable to fetch currency rates"
     * }
     */
    public function __invoke()
    {
        $cacheKey = 'currency_rates';

        $cacheTtl = now()->addMinutes(10);

        $rates = Cache::remember($cacheKey, $cacheTtl, function () {
            $response = Http::get('https://api.exchangerate-api.com/v4/latest/USD');

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });

        if ($rates) {
            return response()->json($rates);
        }

        return response()->json(['error' => 'Unable to fetch currency rates'], 500);
    }
}
