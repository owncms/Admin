<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Http\Controllers\Controller;
use DB;
use Modules\Admin\Http\Requests\PasswordResetRequest;

class ResetPasswordController extends Controller
{
    protected $maxAttempts = 5;
    protected $lockTime = 1800;
    protected $cookieValidation = 'reset_password_attempts';

    public function __construct()
    {
        $this->modulePrefix = strtolower(\Application::getModulePrefix(get_called_class()));
    }

    public function showRequestPasswordResetForm()
    {
        return $this->view('auth.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        if ($request->get('email', '') == '') {
            return redirect()->back()->with('error', module_lang('password.field_required'));
        }
        if ($this->hasTooManyResetPassword($request)) {
            return $this->lockAccess($request);
        }
        $token = str_random(15); //todo
        $email = $request->get('email');
        $emailExists = Admin::where('email', $email)->first();
        if (!$emailExists) {
            return redirect()->back()->with('error', module_lang('password.email_not_found'));
        }
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'is_front' => 0
        ]);
        //todo: send mail
        $this->incrementAttempt($request);
        return redirect()->back()->with('success', module_lang('password.send_reset_link'));

    }

    public function hasTooManyResetPassword(Request $request): bool
    {
        if (!$request->hasCookie($this->cookieValidation)) {
            return false;
        }
        $attempts = (int)$request->cookie($this->cookieValidation);
        return $attempts >= $this->maxAttempts;
    }

    public function lockAccess(Request $request): \Illuminate\Http\RedirectResponse
    {
        return redirect()->back()->withInput()->with('error', module_lang('password.lock_access'));
    }

    public function incrementAttempt(Request $request): void
    {
        $attempts = 1;
        if ($request->hasCookie($this->cookieValidation)) {
            $attempts = (int)$request->cookie($this->cookieValidation);
            ++$attempts;
        }
        \Cookie::queue($this->cookieValidation, $attempts, $this->lockTime);
    }

    public function showResetPassword($token)
    {
        $token = trim($token);
        $reset = DB::table('password_resets')->where('token', $token)->where('is_front', 0)->first();
        if ($reset) {
            return $this->view('auth.password', [
                'token' => $token
            ]);
        }
        return redirect(admin_route('login'));
    }

    public function resetPassword(PasswordResetRequest $request)
    {
        $token = $request->get('token');
        $reset = DB::table('password_resets')
            ->where('token', $token)
            ->where('is_front', 0)
            ->first();
        if (!$reset) {
            return redirect(admin_route('login'));
        }
        $user = Admin::where('email', $reset->email)->first();
        if ($user) {
            $user->update([
                'password' => $request->password
            ]);
            DB::table('password_resets')->where('token', $reset->token)->delete();
            return redirect(admin_route('login'))->with('success', module_lang('password.updated'));
        }
        return redirect(admin_route('login'));
    }
}
