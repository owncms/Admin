<?php

namespace Modules\Admin\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Get the path the users should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return string
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->guard('admin')->check()) {
            if ($request->ajax()) {
                return response('Unauthorized', 401);
            } else {
                return redirect(route('admin.login'));
            }
        }
        return $next($request);
    }
}
