<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Paddle domains based on sandbox/production mode
        $paddleDomain = config('cashier.sandbox') ? 'sandbox-buy.paddle.com' : 'buy.paddle.com';
        $paddleCdn = 'cdn.paddle.com';

        // Allow Vite dev server in local development
        $viteServer = app()->environment('local') ? ' http://127.0.0.1:5173 http://localhost:5173' : '';
        $viteWs = app()->environment('local') ? ' ws://127.0.0.1:5173 ws://localhost:5173' : '';

        // More restrictive CSP with specific Paddle domains
        $csp = [
            "default-src 'self'{$viteServer}",
            "frame-src 'self' https://*.paddle.com https://{$paddleDomain} https://*.myshopify.com",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://{$paddleCdn} https://cdn.jsdelivr.net https://public.profitwell.com{$viteServer}",
            "connect-src 'self' https://*.paddle.com https://{$paddleDomain} https://checkout-service.paddle.com https://*.myshopify.com{$viteWs}{$viteServer}",
            "img-src 'self' data: https://*.paddle.com",
            "style-src 'self' 'unsafe-inline' https://{$paddleCdn} https://fonts.bunny.net{$viteServer}",
            "font-src 'self' https://fonts.bunny.net",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $csp));

        return $response;
    }
}
