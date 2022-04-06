<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <img class="c-sidebar-brand-full" style="background-size: cover" width="50" height="50" src="{{asset('public/assets/logo.png')}}"/>
        <img class="c-sidebar-brand-minimized" style="background-size: cover" width="50" height="50" src="{{asset('public/assets/logo.png')}}"/>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{route('dashboard')}}"><i class="c-sidebar-nav-icon fa fa-tachometer-alt"></i> Dashboard</a>
            <a class="c-sidebar-nav-link" href="{{route('story')}}"><i class="c-sidebar-nav-icon fa fa-tachometer-alt"></i> Story</a>
        </li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
            <i class="c-sidebar-nav-icon fa fa-sign-out-alt"></i> Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>