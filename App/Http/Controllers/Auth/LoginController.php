<?php

namespace Modules\Admin\App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Admin\App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Modules\Admin\App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected string $redirectTo = '/admin';
    protected string $loginPath = '/admin/login';
    protected string $redirectAfterLogout = '/admin/login';

    public function __construct()
    {
        $this->redirectTo = route('admin.dashboard');
        $this->loginPath = $this->redirectAfterLogout = route('admin.login');
        $this->modulePrefix = strtolower(\Application::getModulePrefix(get_called_class()));
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        \Illuminate\Support\Facades\Auth::setDefaultDriver('admin');
    }

    /**
     * @return mixed
     */
    public function showLoginForm(): mixed
    {
        return $this->view('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(LoginRequest $request)
    {
        if ($this->guard()->attempt($request->only('email', 'password'), $request->get('remember_me'))) {
            if ($this->guard()->user()->active == 0) {
                $this->guard()->logout();
                return redirect($this->loginPath);
            }
            return $this->sendLoginResponse($request);
        }
        if ($request->ajax()) {
            //TODO: make login accessible through ajax
        }

        return redirect()->back()->withErrors(
            [
                'error' => module_lang('login.error_login')
            ]
        );
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect($this->redirectAfterLogout);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * @param Request $request
     * @param $user
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        $user->update(
            [
                'last_login_at' => Carbon::now()
            ]
        );
    }
}
