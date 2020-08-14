<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="hamburger btn-link">
                <span class="hamburger-inner"></span>
            </button>
            @section('breadcrumbs')
                <ol class="breadcrumb hidden-xs">
                    @php
                        $segments = Request::segments();
                        array_shift($segments);
                        $url = route('dashboard');
                    @endphp
                    @if($segments[0] === 'dashboard')
                        <li class="active"><i class="voyager-boat"></i> Dashboard</li>
                    @else
                        <li class="active">
                            <a href="{{ route('dashboard')}}"><i class="voyager-boat"></i> Dashboard</a>
                        </li>

                        @foreach ($segments as $segment)
                            @php
                                $url .= '/'.$segment;
                                $url = str_replace('/dashboard', '', $url);
                            @endphp
                            @if ($loop->last)
                                <li>{{ ucfirst(urldecode($segment)) }}</li>
                            @else
                                <li>
                                    <a href="{{ $url }}">{{ ucfirst(urldecode($segment)) }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            @show
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown" role="button"
                   aria-expanded="false"><img src="{{ (Auth::user()->avatar !== null) ? Storage::disk(config('storage.disk'))->url(Auth::user()->avatar) : Storage::disk(config('storage.disk'))->url('users/default.png') }}" class="profile-img"> <span
                        class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-animated">
                    <li class="profile-img">
                        <img src="{{ (Auth::user()->avatar !== null) ? Storage::disk(config('storage.disk'))->url(Auth::user()->avatar) : Storage::disk(config('storage.disk'))->url('users/default.png') }}" class="profile-img">
                        <div class="profile-body">
                            <h5>{{ Auth::user()->name }}</h5>
                            <h6>{{ Auth::user()->email }}</h6>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li class="class-full-of-rum">
                        <a href="{{route('profile')}}" > <i class="voyager-person"></i> Profile</a>
                    </li>
                    <li>
                        <a href="{{route('logout')}}" class="btn btn-danger btn-block">
                            <i class="voyager-power"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
