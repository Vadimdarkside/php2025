<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !in_array(auth()->user()->role, ['admin', 'manager'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to perform this action'
            ], 403);
        }

        return $next($request);
    }
}