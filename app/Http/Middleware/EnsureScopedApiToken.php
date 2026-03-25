<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureScopedApiToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $requiredScope): Response
    {
        $bearerToken = (string) $request->bearerToken();

        if ($bearerToken === '') {
            return response()->json([
                'success' => false,
                'message' => 'Missing bearer token.',
                'errors' => [],
            ], 401);
        }

        $tokenHash = hash('sha256', $bearerToken);

        /** @var ApiToken|null $token */
        $token = ApiToken::query()->where('token_hash', $tokenHash)->first();

        if (!$token || !$token->isActive()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive token.',
                'errors' => [],
            ], 401);
        }

        if (!$token->hasScope($requiredScope)) {
            return response()->json([
                'success' => false,
                'message' => 'Token does not have required scope.',
                'errors' => [],
            ], 403);
        }

        $token->markUsed();
        $request->attributes->set('api_token', $token);

        return $next($request);
    }
}
