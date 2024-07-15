@extends('layouts.app')
@section('title') Inicio @endsection
@section('page_active') Dashboard @endsection 
@section('subpage_active') Home @endsection

@section('content')
<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Usuarios Registrados</h4>

                    <div class="widget-chart-1">
                        <div class="widget-detail-1 text-end">
                            <span class="badge bg-danger rounded-pill float-start mt-3">{{ $overview['users'] }}% <i class="mdi mdi-trending-up"></i> </span>
                            
                            <h2 class="fw-normal pt-2 mb-1"> {{$overview['users']}} </h2>
                            <p class="text-muted mb-1">De este mes</p>
                        </div>
                    </div>
                    <div class="progress progress-bar-alt-pink progress-sm">
                        <div class="progress-bar bg-danger" role="progressbar"
                                aria-valuenow="{{$overview['users']}}" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{$overview['users']}}%;">
                            <span class="visually-hidden">{{$overview['users']}}% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Colonias</h4>

                    <div class="widget-chart-1">
                            
                        <div class="widget-detail-1 text-end">
                            <span class="badge bg-success rounded-pill float-start mt-3">{{$overview['colonies']}}% <i class="mdi mdi-trending-up"></i> </span>
                            
                            <h2 class="fw-normal pt-2 mb-1"> {{ $overview['colonies'] }} </h2>
                            <p class="text-muted mb-1">Actividad de este mes</p>
                        </div>
                        <div class="progress progress-bar-alt-pink progress-sm">
                            <div class="progress-bar bg-success" role="progressbar"
                                    aria-valuenow="{{$overview['colonies']}}" aria-valuemin="0" aria-valuemax="100"
                                    style="width: {{$overview['colonies']}}%;">
                                <span class="visually-hidden">{{$overview['colonies']}}% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col --> 

        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    
                    <h4 class="header-title mt-0 mb-3">Mercados</h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2 text-end">
                            <span class="badge bg-pink rounded-pill float-start mt-3">{{$overview['mercados']}}% <i class="mdi mdi-trending-up"></i> </span>
                            <h2 class="fw-normal mb-1"> {{ $overview['mercados'] }} </h2>
                            <p class="text-muted mb-3">Revenue today</p>
                        </div>
                        <div class="progress progress-bar-alt-pink progress-sm">
                            <div class="progress-bar bg-pink" role="progressbar"
                                    aria-valuenow="{{$overview['mercados']}}" aria-valuemin="0" aria-valuemax="100"
                                    style="width: {{$overview['mercados']}}%;">
                                <span class="visually-hidden">{{$overview['mercados']}}% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div><!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Ultimos cobros</h4>
                    @if(count($overview['lastPays']) > 0)
                    <div class="inbox-widget">
                        @foreach ($overview['lastPays'] as $lp)
                        <div class="inbox-item">
                            <a href="#">
                                <h5 class="inbox-item-author mt-0 mb-1">{{$lp['user']}}</h5>
                                <p class="inbox-item-text">{{ $lp['colonie'] }} / {{ $lp['contribuyente'] }}</p>
                                <p class="inbox-item-date">
                                    Costo: ${{ number_format($lp['costo'], 2) }} / 
                                    Cuota: ${{ number_format($lp['cuota'], 2) }}
                                </p>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-xl-7">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mt-0 mb-4">Monto cobrado el dia de hoy</h4>
    
                        <div class="widget-chart-1">
                            <div class="widget-detail-1 text-end">
                                <h2 class="fw-normal pt-2 mb-1"> ${{ number_format($overview['cobroHoy']) }} </h2>
                                <p class="text-muted mb-1">Fecha: {{ date('M-D') }}</p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div><!-- end col -->
    
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mt-0 mb-4">Cantidad de Mercados visitados</h4>
    
                        <div class="widget-chart-1">
                                
                            <div class="widget-detail-1 text-end">
                                <h2 class="fw-normal pt-2 mb-1"> {{ $overview['visiteM'] }} </h2>
                                <p class="text-muted mb-1">Fecha: {{ date('M-D') }}</p>
                            </div> 
                        </div>
                    </div>
                </div>
            </div><!-- end col --> 
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0">Registro de usuarios de los últimos 6 meses</h4>
                    <div id="users-signin" dir="ltr" style="height: 280px;" class="morris-chart"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0">Mapa de ubicaciones</h4>
                    <div id="map" style="width:100%;height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
<!-- container-fluid -->

@endsection

@section('scripts')
<script>
    !
    function(e) {
        "use strict";
    

	function a() {
		this.$realData = []
	}
	a.prototype.createBarChart = function(e, a, t, r, o, i) {
		Morris.Bar({
			element: e,
			data: a,
			xkey: t,
			ykeys: r,
			labels: o,
			hideHover: "auto",
			resize: !0,
			gridLineColor: "rgba(173, 181, 189, 0.1)",
			barSizeRatio: .2,
			dataLabels: !1,
			barColors: i
		})
	}, a.prototype.init = function() {
		e("#users-signin").empty(); e("#interconn-chart").empty();
		
        // Estadisticas de usuarios registrados
        this.createBarChart("users-signin", [
            {
                y: "{{ $admin->getMonthName(5) }}",
                a: "{{ $admin->chartUsersSign(5)['online'] }}"
            },
            {
                y: "{{ $admin->getMonthName(4) }}",
                a: "{{ $admin->chartUsersSign(4)['online'] }}"
            },
            {
                y: "{{ $admin->getMonthName(3) }}",
                a: "{{ $admin->chartUsersSign(3)['online'] }}"
            },
            {
                y: "{{ $admin->getMonthName(2) }}",
                a: "{{ $admin->chartUsersSign(2)['online'] }}"
            },
            {
                y: "{{ $admin->getMonthName(1) }}",
                a: "{{ $admin->chartUsersSign(1)['online'] }}"
            },
            {
                y: "{{ $admin->getMonthName(0) }}",
                a: "{{ $admin->chartUsersSign(0)['online'] }}"
            }
        ], "y", ["a"], ["Registros"], ["#188ae2"]);
		

	}, e.Dashboard1 = new a, e.Dashboard1.Constructor = a
    }(window.jQuery), function(a) {
        "use strict";
        a.Dashboard1.init(), window.addEventListener("adminto.setBoxed", function(e) {
            a.Dashboard1.init()
        }), window.addEventListener("adminto.setFluid", function(e) {
            a.Dashboard1.init()
        })
    }(window.jQuery);
</script>

<script>
    let lat = 25.686099,
    lng = -100.3263446;
    let markers = [];

    function initMap() {
        var map;
        var marker; 
        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
 
        var geocoder = new google.maps.Geocoder;
        navigator.geolocation.getCurrentPosition(
            (position) => {
                // lat = position.coords.latitude;
                // lng = position.coords.longitude;
                map = new google.maps.Map(
                    document.getElementById('map'), {
                        center: {
                            lat: lat,
                            lng: lng
                        },
                        zoom: 13,
                        disableDefaultUI: true
                    }
                ); 
               
                fetch('{{route("getColonies")}}')
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                
                    if (data.status == true) {
                        let colonies = data.data;
                        for (let x = 0; x < colonies.length; x++) {
                            const origins = colonies[x];  
                            var location = new google.maps.LatLng(origins.lat, origins.lng);
                            
                            if (origins.lat != '' && origins.lng != '') {
                                const marker = new google.maps.Marker({
                                    position: location,
                                    map: map,
                                    title: origins.name,
                                    icon: "{{asset('assets/images/point_a.png')}}",
                                    lat: origins.lat, 
                                    lng: origins.lng,
                                    id_staff: origins.id
                                });

                                markers.push(marker);
                                var infowindow = new google.maps.InfoWindow({
                                    content: ''
                                });
                    
                                //contenido de la infowindow
                                var content='<div id="content" style="width: auto; height: auto;"><b>Oferente</b> <br />' + origins.name + ' <br /><br /> <a href="https://www.google.com/maps/place/'+origins.direccion+'" target="_blank">Ir a Google Maps</a></div>';   

                                google.maps.event.addListener(marker, 'click', function(marker, content, infowindow) {
                                    return function(){
                                        infowindow.setContent(content); //asignar el contenido al globo
                                        infowindow.open(map, marker); //mostrarlo
                                    };            
                                }(marker,content,infowindow));
                            } 
                        }
                    }
                });

                infowindow.setContent(infowindowContent);

                marker = new google.maps.Marker({
                    map: map
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
            },
            () => {
                handleLocationError(true, infoWindow, map.getCenter());
            }
        );

    
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ $ApiKey }}&libraries=places&callback=initMap">
</script>
@endsection