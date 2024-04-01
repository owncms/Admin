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
            {!! Form::open(['url' => admin_route('password.email'), 'method' => 'POST', 'class' => 'login-form']) !!}
            <div class="input-group">
                <input type="email" name="email" class="form-control" placeholder="@module_lang('password.email')"
                       required autofocus>
            </div>
            @if(Session::has('error'))
                <small class="text-danger">
                    {{ Session::get('error') }}
                </small>
            @endif
            @if(Session::has('success'))
                <small class="text-success">
                    {{ Session::get('success') }}
                </small>
            @endif
            <div class="mt-4">
                <button type="submit" class="btn">@module_lang('password.request')</button>
            </div>
            {!! Form::close() !!}
    </div>
@endsection
