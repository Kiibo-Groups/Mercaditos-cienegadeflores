@extends('layouts.app')

@section('content')

<section class="wrapper bg-light">
    <div class="container pt-12 pt-md-14 pb-14 pb-md-16">
      <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto">
          <figure class="mb-10"><img class="img-fluid" src="{{ asset('public/assets/img/errors/404.png') }}" srcset="{{ asset('public/assets/img/errors/404@2x.png 2x') }}" alt=""></figure>
        </div>
        <!-- /column -->
        <div class="col-lg-8 col-xl-7 col-xxl-6 mx-auto text-center">
          <h1 class="mb-3">¡Ups! Página no encontrada.</h1>
          <p class="lead mb-7 px-md-12 px-lg-5 px-xl-7">La página que busca no está disponible o ha sido movida. Pruebe con una página diferente o vaya a la página de inicio con el botón de abajo.</p>
          <a href="{{ route('home') }}" class="btn btn-primary rounded-pill">Ir a la página de inicio</a>
        </div>
        <!-- /column -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

@endsection
