<?php

namespace App\Http\Middleware;

use Closure;

class AuthPublicKey
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $publicKey = $request->header('X-Public-Key') ? $request->header('X-Public-Key') : $request->input('public-key');

        if (!$publicKey) {
            return response()->json([
                'error'   => 403,
                'message' => 'Public Key is required via the headers (X-Public-Key) or as a query (public-key).',
            ], 403);

        }
        return $next($request);
    }
}
