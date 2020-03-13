<?php

namespace App\Http\Middleware;

use Closure;

class AuthSecretKey
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

        $secretKey = $request->header('X-Secret-Key') ? $request->header('X-Secret-Key') : $request->input('secret-key');

        if (!$secretKey) {
            return response()->json([
                'error'   => 403,
                'message' => 'Secret Key is required via the headers (X-Secret-Key) or as a query (secret-key).',
            ], 403);

        }

        return $next($request);
    }
}
