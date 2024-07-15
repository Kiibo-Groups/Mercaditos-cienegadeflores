<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{ asset('public/profile/img/logo/'.Auth::user()->logo) }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
            <div class="dropdown">
                <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown"  aria-expanded="false">{{ Auth::user()->name }}</a>
                <div class="dropdown-menu user-pro-dropdown">
                    <!-- item-->
                    <a href="{{ route('dash') }}" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>Inicio</span>
                    </a>
    
                    <!-- item-->
                    <a href="{{ route('settings') }}" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Configuraciones</span>
                    </a> 
    
                    <!-- item-->
                    <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Cerrar sesión</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
    
                </div>
            </div>

            <p class="text-muted left-user-info">Panel de control</p>

            <ul class="list-inline">
                <li class="list-inline-item">
                    <!-- Configuraciones -->
                    <a href="{{ route('settings') }}" class="text-muted left-user-info">
                        <i class="mdi mdi-cog"></i>
                    </a>
                </li>

                <li class="list-inline-item">
                    <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-power"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">

                <li class="menu-title">NAVEGACIÒN</li>
                
                <!-- Dashboard --> 
                <li>
                    <a href="#dash" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span> Dashboard </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="dash">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('dash') }}">Inicio</a>
                            </li>
                            <li>
                                <a href="{{ route('perfil_s') }}">Perfíl</a>
                            </li>
                            <li>
                                <a href="{{ route('settings') }}">Configuraciones</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Dashboard -->
                
                <li class="menu-title mt-2">Opciones</li>

                <!-- Usuarios -->
                <li>
                    <a href="#users" data-bs-toggle="collapse">
                        <i class="mdi mdi-face-shimmer-outline"></i>
                        <span> Usuarios </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="users">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('users') }}">Listado</a>
                            </li>
                            <li>
                                <a href="{{ url('users/create') }}">Agregar Elemento</a>
                            </li> 
                        </ul>
                    </div>
                </li>
                <!-- Usuarios -->

                <!-- Colonias -->
                <li>
                    <a href="#colonies" data-bs-toggle="collapse">
                        <i class="mdi mdi-book-marker-outline"></i>
                        <span> Mercados </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="colonies">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('colonies_list') }}">Listado</a>
                            </li>
                            <li>
                                <a href="{{ url('colonies/create') }}">Agregar Elemento</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Colonias -->

                <!-- Carga de BD -->
                <li>
                    <a href="#mercaditos" data-bs-toggle="collapse">
                        <i class="mdi mdi-store"></i>
                        <span> Oferentes </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="mercaditos">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('bd_list') }}">Listado</a>
                            </li>
                            <li>
                                <a href="{{ url('mercaditos/create') }}">Agregar Elemento</a>
                            </li> 
                        </ul>
                    </div>
                </li>
                <!-- Carga de BD -->
               
                <!-- Reportes -->
                <li>
                    <a href="{{ route('reports') }}">
                        <i class="mdi mdi-file-excel-box"></i>
                        <span>Reportes</span> 
                        <span class="menu-arrow"></span>
                    </a> 
                </li>
                <!-- Reportes -->

                <!-- Reportes -->
                <li>
                    <a href="{{ route('perms_alcohol') }}">
                        <i class="mdi mdi-file-excel-box"></i>
                        <span>Permisos de alcohol</span> 
                        <span class="menu-arrow"></span>
                    </a> 
                </li>
                <!-- Reportes -->
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->