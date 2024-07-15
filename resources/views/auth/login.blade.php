@extends('layouts.app')
@section('title') Ingresa a tu panel de administración | Mercaditos @endsection

@section('content')
<div class="account-pages my-5">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="text-center">   
                    <a href="index.html">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="width: 150px;" class="mx-auto">
                    </a>
                    <p class="text-muted mt-2 mb-4">Panel administrativo Mercaditos</p>

                </div>
                <div class="card">
                    <div class="card-body p-4">
                        
                        <div class="text-center mb-4">
                            <h4 class="text-uppercase mt-0">Ingresa a tu panel</h4>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo administrativo</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ej.- admin@admin.com">
    
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="*************">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Recordarme</label>
                                </div>
                            </div>

                            <div class="mb-3 d-grid text-center">
                                <button class="btn btn-primary" type="submit"> Ingresar </button>
                            </div>
                        </form>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->
@endsection
