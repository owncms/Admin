<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Modules\Admin\Http\Requests\LoginRequest;
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

    public function showLoginForm(): object
    {
        return $this->view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if ($this->guard()->attempt($request->only('email', 'password'), $request->remember_me)) {
            if ($this->guard()->user()->active == 0) {
                $this->guard()->logout();
                return redirect($this->redirectAfterLogout);
            }
            return $this->sendLoginResponse($request);
        }
        if ($request->ajax()) {
            //TODO: make login accessible through ajax
        }

        return redirect()->back()->withErrors([
            'error' => module_lang('login.error_login')
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(property_exists($this, 'redirectAfterLogout')
            ? $this->redirectAfterLogout : '');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login' => Carbon::now()
        ]);
    }
}
