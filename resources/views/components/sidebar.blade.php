<!-- BEGIN: Main Menu-->
<div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto text-center"><a class="navbar-brand" href="{{route('dashboard')}}">
                {!! App\Models\Company::first()->logo ?? ''!!}
            </a></li>
        <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                    class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                    class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                    data-ticon="disc"></i></a></li>
    </ul>
</div>
<!-- <div class="shadow-bottom"></div> -->
<div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }} nav-item"><a class="d-flex align-items-center"
                href="{{route('dashboard')}}"><i data-feather="corner-down-right"></i><span
                    class="menu-title text-truncate" data-i18n="Email">Dashboard</span></a>
        </li>
        @foreach ($navigations as $nav)
        @if(in_array($nav->id , explode(',',$userRoll->parent_id)))
        <li class="nav-item"><a class="d-flex align-items-center"
                href="{{ $nav->route ? route($nav->route) : 'javascript:void()' }}"><i
                    data-feather="corner-down-right"></i><span class="menu-title text-truncate">{{ $nav->label ??
                    'N/A'}}</span></a>
            @if ($nav->children->isNotEmpty())
            <ul class="menu-content">
                @foreach ($nav->children as $children)
                @if(in_array($children->id , explode(',',$userRoll->child_id)))
                <li class="{{ request()->routeIs($children->route) ? 'active' : '' }}"><a
                        class="d-flex align-items-center"
                        href="{{ $children->route ? route($children->route) : 'javascript:void()' }}"><i
                            data-feather="circle"></i><span class="menu-item text-truncate"
                            data-i18n="Analytics">{{$children->label }}</span></a>
                </li>
                @endif
                @endforeach
            </ul>
            @endif
        </li>
        @endif
        @endforeach
    </ul>
</div>
<!-- END: Main Menu -->
