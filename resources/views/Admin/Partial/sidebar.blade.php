<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <div class="logo-icon-container">
                        <?php $admin_logo_img = setting('admin.icon_image'); ?>
                        @if($admin_logo_img == '')
                            <img src="{{ asset('assets/images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                            <img src="{{ Storage::disk(config('storage.disk'))->url($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                    </div>
                    <div class="title">HUNGRY</div>
                </a>
            </div>

            <div class="panel widget center bgimage"
                 style="background-image:url({{ asset('assets/images/bg.jpg') }}); background-size: cover; background-position: 0px;">
                <div class="dimmer"></div>
                <div class="panel-content">
                    <img src="{{ (Auth::user()->avatar !== null) ?
                    Storage::disk(config('storage.disk'))->url(Auth::user()->avatar) :
                    Storage::disk(config('storage.disk'))->url('users/default.png') }}"
                         class="avatar" alt="{{ Auth::user()->name }} avatar">
                    <h4>{{ ucwords(Auth::user()->name) }}</h4>
                    <p>{{ Auth::user()->email }}</p>

                    <a href="{{ route('login') }}" class="btn btn-primary">Profile</a>
                    <div style="clear:both"></div>
                </div>
            </div>
        </div>
        @php
            $menuItems = new App\Repositories\MenuItemRepository();
            $menus = $menuItems->getAllMenuItems(1);
            $sidebar = App\Helpers\Helper::getSideMenuList($menus);
        @endphp
        <div id="adminmenu">
            <ul class="nav navbar-nav">
                {!! $sidebar !!}
            </ul>
        </div>
    </nav>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        //$('ul li.active').parent().parent().parent().parent().addClass('active');
        $('ul li.active').closest('li.dropdown').addClass('active');
    });
</script>
