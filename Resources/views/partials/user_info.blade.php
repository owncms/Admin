<div id="user-info" class="user-info_sidebar">
    <div class="user-info__sidebar-header d-flex justify-content-between">
        <h3 class="title">@module_lang('users.user.info', 'admin')</h3>
        <a href="#" class="close-icon" @click="userInfoToggle()">@svg('modules/admin/img/cancel.svg')</a>
    </div>
    <div class="user-info__sidebar-body mt-4">
        <div class="d-flex align-items-center">
            <div class="symbol">
                {{ ucfirst(admin()->name[0]) }}
            </div>
            <div class="ml-4 user-info__sidebar-content">
                <span class="title">{{ admin()->name }}, {{ admin()->email }}</span><br>
                @if($role = admin()->getRoles()->first())
                    <span>{{ ucfirst($role) }}</span>
                @endif
                {!! Form::open(['url' => admin_route('logout'), 'method' => 'POST']) !!}
                <button type="submit" class="btn btn-logout pt-0 pb-0">@module_lang('users.user.logout', 'admin')</button>
                {!! Form::close() !!}
            </div>
        </div>
        <hr>
    </div>
</div>
