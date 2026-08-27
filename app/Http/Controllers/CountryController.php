<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Country;

class CountryController extends Controller
{
    public function getCountry()
    {
        $response = Http::withToken(
            env('REST_COUNTRIES_API_KEY')
        )->get('https://api.restcountries.com/countries/v5', [
            'limit' => 100,
        ]);

        // API request failed
        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to fetch country data',
                'error' => $response->json(),
            ], $response->status());
        }

        $result = $response->json();

        // Countries get karo
        $countries = $result['data']['objects'] ?? [];

        if (empty($countries)) {
            return response()->json([
                'success' => false,
                'message' => 'No country data found',
                'data' => $result,
            ], 404);
        }

      

        foreach ($countries as $country) {

           
     // Language names comma separated
            $languages = collect($country['languages'] ?? [])
                ->pluck('name')
                ->filter()
                ->implode(', ');

            // Currency symbols comma separated
            $currencySymbols = collect($country['currencies'] ?? [])
                ->pluck('symbol')
                ->filter()
                ->implode(', ');

            // Flag PNG URL
            $flagUrl = $country['flag']['url_png'] ?? null;

            Country::create([
                'display_name' => $country['names']['common'] ?? null,

                'name' => $country['names']['official'] ?? null,

                'country_code' => $country['codes']['ccn3'] ?? null,

                'iso2' => $country['codes']['alpha_2'] ?? null,

                'status' => 'active',

                'language' => $languages,

                'flag_url' => $flagUrl,

                'currency_symbol' => $currencySymbols,

                'currency_meta' => $country['currencies'] ?? [],

                'app_icon' => null,
            ]);

          
        }

        return response()->json([
            'success' => true,
            'message' => 'Countries successfully imported.',
            'api_total' => count($countries),
            
            'database_total' => Country::count(),
        ]);
    }
}