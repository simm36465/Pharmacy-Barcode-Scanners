<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        
    </ul>
    <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="far fa-user"></i> <span>{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          
          <a href="{{route('profile.edit')}}" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> {{ __('Profile') }}
          </a>
          <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                @csrf
                <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                    this.closest('form').submit();">                    
                       {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
          
        </div>
      </li>
    </ul>
</nav>
<!-- /.navbar -->
