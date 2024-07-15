<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="Aplicativo web para Venture - Cafe Monterrey." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Panel de administración |  @yield('title') </title> 
    <!-- Styles -->
    <link href="{{ asset('assets/css/config/default/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('assets/css/config/default/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('assets/css/config/default/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled="disabled" />
    <link href="{{ asset('assets/css/config/default/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled="disabled" />
    <!-- icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    @yield('styles')
</head>
<body class="loading" 
    @if(Route::is('qr_reader')) 
    data-layout-mode="horizontal"
    @endif
    @if(Route::is('login')) 
    style="background: #932527; visibility: visible; opacity: 1;" 
    @else 
    data-sidebar-color="light"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "dark", "size": "default", "showuser": true}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}' 
    @endif>
    
    <!-- Begin page -->
    <div id="wrapper">
        @if(Auth::guard('web')->check() && !Route::is('qr_reader') )
            <!-- Topbar Start -->
            @include('layouts.top-bar')
            <!-- Left Sidebar -->
            @include('layouts.side-bar')
        @endif
 

        <div class="@if(!Route::is('login')) content-page @endif">
            <div class="content">
                @if(Auth::guard('web')->check())
                <!-- Alerts -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h6 class="mb-0 text-white">ERROR</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                {{ Session::get('error') }}
                            </div>
                           @endif
                
                            @if(Session::has('message'))
                            <div class="alert alert-success  alert-dismissible" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <i class="mdi mdi-check-all me-2"></i>  {{ Session::get('message') }}
                            </div>
                            @endif
                        </div>
                    </div>
 
                    <div class="row">
                        <h4 class="header-title mt-3 mt-sm-0">Te encuentras en:</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('dash') }}">Inicio</a></li>
                                        <li class="breadcrumb-item">@yield('page_active')</li>
                                        <li class="breadcrumb-item active">@yield('subpage_active')</li>
                                    </ol> 
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                @endif

                <!-- Container Fluid app -->
                @yield('content')
            </div>
        </div>
       
         
    </div>

    @if(Auth::guard('web')->check())
    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <script>document.write(new Date().getFullYear())</script> &copy; Mercaditos Diseñado por <a href="https://kiibo.mx" target="_blank">Kiibo Groups</a> 
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
    @endif

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <!-- knob plugin -->
    <script src="{{ asset('assets/libs/jquery-knob/jquery.knob.min.js') }}"></script>

    @if(Route::is('dash'))
        <!--Morris Chart-->
        <script src="{{ asset('assets/libs/morris.js06/morris.min.js') }}"></script>
        <script src="{{ asset('assets/libs/raphael/raphael.min.js') }}"></script>
        <!-- Dashboar init js-->
        <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
    @endif

    <!-- third party js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <!-- third party js ends -->
    <!-- Datatables init -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script> 
    <!-- App js-->
    <script src="{{ asset('assets/js/apps.min.js') }}"></script>

    <script>
        function deleteConfirm(url) {
            Swal.fire({
                title: 'Estas seguro(a)',
                text: "No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminarlo!',
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Eliminado!',
                        'Esta entrada ha sido eliminada.',
                        'success'
                    )

                    window.location = url;
                }
            })
        }

        function confirmAlert(url) {
            Swal.fire({
                title: 'Estas seguro(a)',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, hazlo!',
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Cambiado!',
                        'Esta entrada ha sido modificada.',
                        'success'
                    )

                    window.location = url;
                }
            })
        }

        function showMsg(data) {
            Swal.fire(data);
        }
    </script>
    @yield('scripts')
</body>
</html>
