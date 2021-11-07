<?php

namespace Modules\Admin\Http\Middleware;

use Illuminate\Http\Request;
use Silber\Bouncer\Bouncer;
use Closure;

class ScopeBouncer
{
    /**
     * The Bouncer instance.
     *
     * @var \Silber\Bouncer\Bouncer
     */
    protected $bouncer;

    /**
     * Constructor.
     *
     * @param \Silber\Bouncer\Bouncer $bouncer
     */
    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }

    /**
     * Set the proper Bouncer scope for the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $auth_user = auth('admin')->user();
        if ($auth_user) {
            $this->bouncer->scope()->to($auth_user->id);
        }

        return $next($request);
    }
}
