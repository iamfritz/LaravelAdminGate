<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Apikey;

class ApiKeyAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle($request, Closure $next)
{
    $apiKey = $request->header('X-Api-Key');

    if (!$apiKey) {
        return response()->json([
            "status"    => "error",
            "message"   => 'API key is missing'], 401);
    }

    $isValidKey = Apikey::where('key', $apiKey)->exists();

    if (!$isValidKey) {
        return response()->json([
            "status"    => "error",
            "message"   => 'Invalid API key'], 401);
    }

    return $next($request);
}
}
