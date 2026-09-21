<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request and check if user has the required role.
     *
     * Usage in routes:
     * ->middleware('role:Admin')
     * ->middleware('role:Admin,Manager')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        // 2. If user has no role assigned, deny access
        if (!$user->role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Access denied: No role assigned to your account.',
                ], 403);
            }

            abort(403, 'Access denied: No role assigned to your account.');
        }

        $userRole = strtolower(trim($user->role->role_name));

        // 3. Normalize allowed roles list
        $allowedRoles = array_map(function ($role) {
            return strtolower(trim($role));
        }, $roles);

        // 4. Check if user's role is in the allowed roles
        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        // 5. If not authorized, return 403 Forbidden
        if ($request->expectsJson()) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized access: Required role [' . implode(', ', $roles) . '], your role is [' . $user->role->role_name . '].',
            ], 403);
        }

        abort(403, 'Unauthorized access: Required role [' . implode(', ', $roles) . '], your role is [' . $user->role->role_name . '].');
    }
}
