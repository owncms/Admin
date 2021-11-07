@extends('admin::layouts.auth')
@section('admin::main')
    <div class="login-box">
        <div class="login-header mb-4 ">
            <h1 class="text-center">@module_lang('login.sign_in')</h1>
        </div>
        @if($errors->has('error'))
            <div class="error-login">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        @if(Session::has('success'))
            <div class="text-success">
                <span>{{ Session::get('success') }}</span>
            </div>
        @endif
        {!! Form::open(['url' => admin_route('login'), 'method' => 'POST', 'class' => 'login-form']) !!}
        <div class="input-group mb-4">
            <input type="email" name="email" class="form-control @error('email') is-invalid @endif"
                   placeholder="@module_lang('login.email')" required
                   autofocus>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-group mb-4">
            <input type="password" name="password" class="form-control @error('password') is-invalid @endif"
                   placeholder="@module_lang('login.password')"
                   required>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="login-other-options">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember-me">
                <label class="form-check-label" for="remember-me">@module_lang('login.remember_me')</label>
            </div>
            <a href="{{ admin_route('password.request') }}">@module_lang('login.forgot_password')</a>
        </div>
        <button type="submit" class="btn">@module_lang('login.sign_in')</button>
        {!! Form::close() !!}
    </div>
@endsection
