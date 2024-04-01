<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('admin::partials.header')
<body class="login-page">
@yield('admin::main')

@include('admin::partials.scripts')
@yield('admin::script')
</body>
</html>
