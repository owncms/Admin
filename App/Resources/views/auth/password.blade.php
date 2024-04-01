@extends('admin::layouts.auth')
@section('admin::main')
    <div class="login-box">
        <div class="login-header mb-4 ">
            <h1 class="text-center">@module_lang('password.reset')</h1>
        </div>
        @if($errors->has('error'))
            <div class="error-login">
                <span>{{ $errors->first() }}</span>
            </div>
            @enderror
            {!! Form::open(['url' => admin_route('password.update'), 'method' => 'POST', 'class' => 'login-form']) !!}
            {!! Form::hidden('token', $token) !!}
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="@module_lang('password.password')"
                       required autofocus>
            </div>
            <div class="input-group mt-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="@module_lang('password.repeat_password')"
                       required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn">@module_lang('password.update')</button>
            </div>
            {!! Form::close() !!}
    </div>
@endsection
