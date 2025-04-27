<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the Bearer token from the request
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthorized - No token provided'], 401);
        }

        // Send request to user-service to verify the token
        $response = Http::withToken($token)->get('http://user-service:8000/api/me');

        if ($response->status() !== 200) {
            return response()->json(['message' => 'Unauthorized - Invalid token'], 401);
        }

        // Optionally, you can attach user data to the request (if needed)
        $request->merge(['auth_user' => $response->json('user')]);

        return $next($request);
    }
}


