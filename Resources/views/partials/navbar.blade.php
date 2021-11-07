<header class="navbar-header">
    <div class="left-side">
        <div class="collapse-left-side" @click="toggleMenu()">
            <i class="fa fa-fw fa-bars"></i>
        </div>
    </div>
    <div class="right-side">
        <div class="user-info d-flex align-items-center" id="user-info-toggle" @click="userInfoToggle(true)">
            <span class="pr-1">{{ admin()->name }}</span>
            <div>
                <span class="symbol">{{ ucfirst(admin()->name[0]) }}</span>
            </div>
        </div>
        @include('admin::partials.user_info')
    </div>
</header>
