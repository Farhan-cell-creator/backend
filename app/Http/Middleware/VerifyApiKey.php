<?php

namespace App\Http\Middleware;

use App\Models\Credential;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = Credential::where('name', 'web-api-key')->first();

        if (! $data) {
            return response()->json([
                'message' => 'API key is not configured',
                'success' => false,
            ], 404);
        }

        $apiKey = $request->header('api-key');

        if (! $apiKey) {
            return response()->json([
                'message' => 'API key is missing',
                'success' => false,
            ], 404);
        }

        if ($data->value !== $apiKey) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false,
            ], 404);
        }

        return $next($request);
    }
}
