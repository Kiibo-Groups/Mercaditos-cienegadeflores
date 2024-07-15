<!-- Topbar Start -->
<div class="navbar-custom" >
    <ul class="list-unstyled topnav-menu float-end mb-0" id="tooltip-container">
     
        <li class="dropdown notification-list topbar-dropdown">
            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{ asset('public/profile/img/logo//'.Auth::user()->logo) }}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ms-1">
                    {{Auth::user()->name}} <i class="mdi mdi-chevron-down"></i> 
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Bienvenido(a) !</h6>
                </div>

                <!-- item-->
                <a href="{{ route('dash') }}" class="dropdown-item notify-item">
                    <i class="fe-layout"></i>
                    <span>Inicio</span>
                </a>
                
                <!-- item-->
                <a href="{{ route('perfil_s') }}" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>Perfíl</span>
                </a> 
                <!-- item-->
                <a href="{{ route('settings') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-cog"></i>
                    <span>Configuraciones</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Cerrar sesión</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
  
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ route('dash') }}" class="logo logo-light text-center">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" height="50">
            </span>
        </a> 
    </div>
  
    <div class="clearfix"></div> 
</div>
<!-- end Topbar -->