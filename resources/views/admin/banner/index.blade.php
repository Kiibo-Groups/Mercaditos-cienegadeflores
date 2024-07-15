
@extends('layouts.app')
@section('title') Listado de Itinerarios @endsection
@section('page_active') Itinerarios @endsection 
@section('subpage_active') Listado @endsection 

@section('content') 
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <p class="text-muted font-14 mb-3" style="position: relative;height: 50px;">
                        <a href="{{ Asset($link . 'add') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right;">
                            <span class="btn-label"><i class="mdi mdi-check-all"></i></span>Agregar elemento
                        </a>
                    </p>

                    <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Imagen</th> 
                                <th>Status</th>
                                <th>Posición</th>
                                <th>Url de redirección</th>
                                <th style="text-align: right">Opciones</th>
                            </tr> 
                        </thead>
                        <tbody>

                            @foreach ($data as $row)
                                <tr>
                                    <td><img src="{{ Asset('upload/banner/' . $row->img) }}" height="70"></td>
                                    <td>
                                        @if ($row->status == 0)
                                            <button type="button"
                                                class="btn btn-success width-xs waves-effect waves-light"
                                                onclick="confirmAlert('{{ Asset($link . 'status/' . $row->id) }}')">Activo</button>
                                        @else
                                            <button type="button"
                                                class="btn btn-danger width-xs waves-effect waves-light"
                                                onclick="confirmAlert('{{ Asset($link . 'status/' . $row->id) }}')">Inactivo</button>
                                        @endif

                                    </td>
                                    <td>
                                        {{ $ban->getPosition($row->position) }}
                                    </td>
                                    <td>
                                        <a href="{{ $row->url }}" target="_blank">Link</a>
                                    </td>
                                    <td width="17%" style="text-align: right">

                                        <a href="{{ Asset($link . $row->id . '/edit') }}"
                                            class="btn btn-success waves-effect waves-light btn m-b-15 ml-2 mr-2 btn-md"
                                            data-toggle="tooltip" data-placement="top"
                                            data-original-title="Editar"><i
                                                class="mdi mdi-border-color"></i></a>

                                        <button type="button"
                                            class="btn m-b-15 ml-2 mr-2 btn-md  btn btn-danger waves-effect waves-light"
                                            data-toggle="tooltip" data-placement="top"
                                            data-original-title="Eliminar"
                                            onclick="deleteConfirm('{{ Asset($link . 'delete/' . $row->id) }}')"><i
                                                class="mdi mdi-delete-forever"></i></button> 
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
