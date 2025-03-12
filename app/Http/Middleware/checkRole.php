<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$role): Response
    {
        $userRole = $request->user()?->role?->name;

        // Mengecek apakah role pengguna ada dalam array $roles yang diberikan
        if (!$userRole || !in_array($userRole, $role)) {
            return redirect()->back()->withErrors([
                'message' => 'Anda tidak memiliki hak akses yang cukup untuk masuk ke halaman yang anda tuju.'
            ]);
        }

        return $next($request);
    }
}
