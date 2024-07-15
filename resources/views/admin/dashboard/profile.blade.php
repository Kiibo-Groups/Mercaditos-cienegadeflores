@extends('layouts.app')
@section('title') Perfíl de administración @endsection
@section('page_active') Dashboard @endsection 
@section('subpage_active') Perfíl @endsection 

@section('styles')
    <link 
        href="{{ asset('assets/libs/quill/quill.snow.css') }}" 
        rel="stylesheet" 
        type="text/css" />
@endsection

@section('content')
<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                @if($data->logo == '')
                    <img src="{{ asset('assets/images/users/1647418114462.jpg') }}" alt="Profile" class="rounded-circle">
                @else
                    <img src="<?php echo asset('public/profile/img/logo/'.$data->logo) ?>" alt="Profile" class="rounded-circle"> 
                @endif

                <h2>{{$data->name}}</h2>
                <h3>{{$data->email}}</h3>
                </div>

                <div class="card-body profile-card d-flex flex-column align-items-left">
                <div class="social-links mt-2">
                    <hr class="w-100"> 
                    <h5 class="text-dark">
                        Información de contacto
                    </h5>
                    <p class="text-dark pt-4 font-weight-medium mb-2 label">Correo Electronico</p>
                    <p>{{$data->shw_email}}</p>
                    <p class="text-dark font-weight-medium pt-24px mb-2 label">Telefono</p>
                    <p>{{$data->phone_contact}}</p>
                    
                    <p class="text-dark font-weight-medium pt-24px mb-2">Redes sociales</p>
                    <p class="social-button">
                        <a href="{{$data->twitter}}" target="_blank" class="mb-1 btn btn-outline btn-twitter rounded-circle">
                            <i class="mdi mdi-twitter"></i>
                        </a> 
                        <a href="{{$data->fb}}" target="_blank" class="mb-1 btn btn-outline btn-facebook rounded-circle">
                            <i class="mdi mdi-facebook"></i>
                        </a> 
                        <a href="{{$data->insta}}" target="_blank" class="mb-1 btn btn-outline btn-instagram rounded-circle">
                            <i class="mdi mdi-instagram"></i>
                        </a>
                        <a href="{{$data->youtube}}" target="_blank" class="mb-1 btn btn-outline btn-youtube rounded-circle">
                            <i class="mdi mdi-youtube"></i>
                        </a>
                    </p>
                </div>
                </div>

                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <div class="social-links mt-2">
                    <a @if($data->twitter) href="{{$data->twitter}}" @else href="#" @endif class="twitter"><i class="bi bi-twitter"></i></a>
                    <a @if($data->facebook) href="{{$data->facebook}}" @else href="#" @endif class="facebook"><i class="bi bi-facebook"></i></a>
                    <a @if($data->instagram) href="{{$data->instagram}}" @else href="#" @endif class="instagram"><i class="bi bi-instagram"></i></a>
                    <a @if($data->linkedin) href="{{$data->linkedin}}" @else href="#" @endif class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">

            <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-settings">Configuraciones</button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Información de contacto</button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#terms_info">Términos y Condiciones</button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#poliyces">Política de privacidad</button>
                </li>

                </ul>
                
                <div class="tab-content pt-2">
    
                    <!-- Settings -->
                    <div class="tab-pane fade show active profile-settings pt-3" id="profile-settings">
                        <form action="{{ $form_url }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row mb-6 ec-vendor-uploads">
                                <div class="col-lg-12">
                                    <label for="profileImage">Logotipo &nbsp;<small>(512px * 512px)</small></label>
                                </div>

                            <div class="col-md-8 mb-6 col-lg-9 ec-preview">
                                <input type='file' name='logo' id="imageUpload" class="ec-image-upload" accept=".png, .jpg, .jpeg" hidden />
                                <label for="imageUpload">
                                    @if($data->logo)
                                    <img src="{{ asset('public/profile/img/logo/'.$data->logo) }}" class="ec-image-preview" alt="Profile">
                                    @else 
                                    <img src="{{ asset('public/profile/img/user_profile.jpg') }}" class="ec-image-preview" alt="Profile">
                                    @endif
                                </label>
                                </div>
                            </div>
                            <br />

                            <div class="row mb-3">
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group mb-3">
                                        <label for="name">Nombre del negocio</label>
                                        <input type="text" class="form-control" name="name" value="{{$data->name}}" id="name"  autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="form-group mb-3">
                                        <label for="short_descript">Descripción corta</label>
                                        <input type="text" class="form-control" name="short_descript" value="{{$data->short_descript}}" id="short_descript"  autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="form-group mb-3">
                                        <label for="userName">Nombre de usuario</label>
                                        <input type="text" class="form-control" id="userName" name="username" value="{{$data->username}}" autocomplete="off">
                                        <span class="d-block mt-1" style="font-size:11px;color:red;" style="font-size:11px;color:red;">
                                            Usuario para el inicio de sesión
                                        </span>
                                    </div>
                                </div> 

                                <div class="col-lg-6 mb-3">
                                    <div class="form-group mb-3">
                                        <label for="email">Correo Administrativo</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{$data->email}}" autocomplete="off">
                                    </div>
                                </div> 
                            </div>
    

                            <div class="text-left pt-16 mb-3">
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                    <!-- End Settings -->

                    <!-- Edit info -->
                    <div class="tab-pane fade pt-3" id="profile-edit">
                        <form action="{{ $form_url }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row mb-3">
                                
                                <div class="col-lg-5 col-md-6 col-sl-12">
                                    <div class="form-group mb-3">
                                        <label for="phone_contact">Número telefonico</label>
                                        <input type="tel" class="form-control" id="phone_contact" name="phone_contact" value="{{$data->phone_contact}}" autocomplete="off">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="shw_email">Correo Publico</label>
                                        <input type="shw_email" class="form-control" id="shw_email" name="shw_email" value="{{$data->shw_email}}" autocomplete="off">
                                        <span class="d-block mt-1" style="font-size:11px;color:red;">
                                            Correo que se mostrara en tu sitio web/Aplicativo
                                        </span>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="fb">Facebook</label>
                                        <input type="text" class="form-control" id="fb" name="fb" value="{{$data->fb}}" autocomplete="off">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="insta">Instagram</label>
                                        <input type="text" class="form-control" id="insta" name="insta" value="{{$data->insta}}" autocomplete="off">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="twitter">Twitter</label>
                                        <input type="text" class="form-control" id="twitter" name="twitter" value="{{$data->twitter}}" autocomplete="off">
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="youtube">Youtube</label>
                                        <input type="text" class="form-control" id="youtube" name="youtube" value="{{$data->youtube}}" autocomplete="off">
                                    </div>
                                </div> 

                                <div class="col-lg-7 col-md-6 col-sl-12">
                                    <div class="form-group mb-3">
                                        @include('admin.dashboard.google')
                                    </div>
                                </div> 
                                
                            </div>
     
                            <div class="text-left pt-16 mb-3">
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                    <!-- End Edit info -->

                    <!-- Terminos y condiciones -->
                    <div class="tab-pane fade pt-3" id="terms_info" role="tabpanel"
                        aria-labelledby="contact_info-tab">
                        <div class="tab-pane-content mt-5">
                            <form action="{{ $form_url }}" method="post" id="terms_form" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="terms_title">Titulo</label>
                                            <input type="text" class="form-control" id="terms_title" name="terms_title" value="{{$data->terms_title}}" autocomplete="off">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="terms_descript">Descripción</label>
                                            <input type="text" class="form-control" id="terms_descript" name="terms_descript" value="{{$data->terms_descript}}" autocomplete="off">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="terms">Términos y Condiciones</label>
                                            <textarea name="terms" id="terms_area" style="display:none"></textarea>
                                            <div name="terms" id="snow-editor" style="height: 300px;" >
                                                {!! $data->terms !!} 
                                            </div> <!-- end Snow-editor-->
                                        </div>
                                    </div> 
                                </div>
                                
                                <div class="d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary mb-2 btn-pill">
                                        Actualizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Terminos y condiciones -->

                    <!-- Politicas de privacidad -->
                    <div class="tab-pane fade pt-3" id="poliyces" role="tabpanel"
                        aria-labelledby="social_media-tab">
                        <div class="tab-pane-content mt-5">
                            <form action="{{ $form_url }}" method="post" id="pol_form" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="privacy_title">Titulo</label>
                                            <input type="text" class="form-control" id="privacy_title" name="privacy_title" value="{{$data->privacy_title}}" autocomplete="off">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="privacy_descript">Descripción</label>
                                            <input type="text" class="form-control" id="privacy_descript" name="privacy_descript" value="{{$data->privacy_descript}}" autocomplete="off">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="privacy">Políticas de privacidad</label>
                                            <textarea name="privacy" id="pol_area" style="display:none"></textarea>
                                            <div id="snow-editor-privacy" style="height: 300px;" >
                                                {!! $data->privacy !!} 
                                            </div> <!-- end Snow-editor-->
                                        </div>
                                    </div> 
                                </div>

                                <div class="d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary mb-2 btn-pill">
                                        Actualizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Politicas de privacidad -->

                </div><!-- End Bordered Tabs -->

            </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Plugins js --> 
<script src="{{ asset('assets/libs/quill/quill.min.js') }}"></script>
<!-- Init js-->  
<script>
    var quill = new Quill("#snow-editor",{
        theme:"snow",
        modules:{
            toolbar:[
                [
                    {font:[]},
                    {size:[]}
                ],
                ["bold","italic","underline","strike"],
                [{color:[]},{background:[]}],
                [{script:"super"},{script:"sub"}],
                [
                    {header:[!1,1,2,3,4,5,6]},
                    "blockquote","code-block"
                ],
                [
                    {list:"ordered"},
                    {list:"bullet"},
                    {indent:"-1"},
                    {indent:"+1"}
                ],
                ["direction",{align:[]}],
                ["link","image","video"],
                ["clean"]
            ]
        }
    });

    var privacy = new Quill("#snow-editor-privacy",{
        theme:"snow",
        modules:{
            toolbar:[
                [
                    {font:[]},
                    {size:[]}
                ],
                ["bold","italic","underline","strike"],
                [{color:[]},{background:[]}],
                [{script:"super"},{script:"sub"}],
                [
                    {header:[!1,1,2,3,4,5,6]},
                    "blockquote","code-block"
                ],
                [
                    {list:"ordered"},
                    {list:"bullet"},
                    {indent:"-1"},
                    {indent:"+1"}
                ],
                ["direction",{align:[]}],
                ["link","image","video"],
                ["clean"]
            ]
        }
    });

    $("#terms_form").on("submit",function() {
        $("#terms_area").val($("#snow-editor").html());
    });

    $("#pol_form").on("submit",function() {
        $("#pol_area").val($("#snow-editor-privacy").html());
    });
    
</script>
@endsection
