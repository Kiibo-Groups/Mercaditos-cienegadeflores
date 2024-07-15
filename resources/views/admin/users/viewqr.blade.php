@extends('layouts.app')
@section('title') Código QR @endsection
@section('page_active') QR @endsection 
@section('subpage_active') Ver elemento @endsection 

@section('content')
 
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <div class="card">
                <div class="card-body"> 
                    <a download="qr_code_{{$data->name}}" href="data:image/png;base64,{{ $data->qr_identy }}" target="_blank">
                        <img src="data:image/png;base64,{{ $data->qr_identy }}">
                    </a>  
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        @if ($data->pic_profile != 'not_available.png')
                        <img src="{{ asset('upload/users/profile/'.$data->pic_profile) }}" alt="Sin imagen de perfil" style="width: 100px;height: 100px;border-radius: 2003px;float: left;margin: 0 25px 0 0;">
                        @else 
                        <img src="{{ asset('assets/images/no-image.png') }}" style="width: 100px;height: 100px;border-radius: 2003px;float: left;margin: 0 25px 0 0;">
                        @endif

                        <h3 class="mb-0">{{$data->name}}</h3> 
                        <div class="mb-1 text-muted">Tel: {{$data->phone}}</div>
                        <p class="card-text mb-auto">email: {{$data->email}}</p> 
                        <br />
                        <p class="card-text mb-auto mt-20">
                            <button class="btn m-b-15 ml-2 mr-2 btn-md  btn-success" onclick="ClipToDeepLink('{{  substr(md5($data->name),0,15) }}','store')">
                                Copy Link
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection

