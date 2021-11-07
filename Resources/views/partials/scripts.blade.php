<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@auth
    <script src="{{ asset(mix('js/admin.js')) }}"></script>
@endauth
