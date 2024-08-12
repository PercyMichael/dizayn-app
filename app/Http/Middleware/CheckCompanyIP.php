<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCompanyIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $allowedIPs = ['102.209.128.233', '127.0.0.1']; // Replace with your company's IPs

        if (!in_array($_SERVER['REMOTE_ADDR'], $allowedIPs)) {
            abort(403, "Unauthorized access. {{$request->ip()}}");
        }

        return $next($request);
    }
}
