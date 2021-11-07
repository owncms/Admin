<aside id="sidebar-menu-content" class="active">
    <div class="sidebar-menu-header">
        <a href="{{ base_admin_url() }}">DCms<sub><small>v.{{cms_version()}}</small></sub></a>
        <span class="collapse-left-side" @click="toggleMenu()"><i class="fa fa-fw fa-bars"></i></span>
    </div>
    {!! $sidebar !!}
</aside>
