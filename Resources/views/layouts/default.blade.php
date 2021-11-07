<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('admin::partials.header')
<body>
<div id="admin-panel">
    @include('admin::partials.sidebar')
    <div id="main-content">
        @include('admin::partials.navbar')
        <div class="page-content">
            @yield('admin::main')
        </div>
        <footer class="author">
            <p>Copyright {{ date('Y') }} &copy; DCMS by @cms_author</p>
        </footer>
    </div>
</div>
@include('admin::partials.scripts')
</body>
</html>

