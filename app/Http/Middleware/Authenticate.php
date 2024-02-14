<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{
    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @param $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null): mixed
    {
        $segment = request()->segment(1);
        $authInvalid = match ($segment) {
            'epay' => !auth('epay')->check(),
            'merchant' => !auth('merchant')->check(),
            default => !auth()->check(),
        };

        if ($authInvalid) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                if ($segment == 'merchant') {
                    return redirect(route('merchant.auth.login'));
                }
                return redirect(route('admin_epay.auth.login'));
            }
        }

        return $next($request);
    }
}
