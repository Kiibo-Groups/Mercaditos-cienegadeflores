
@extends('layouts.app')
@section('title') Listado de Reportes @endsection
@section('page_active') Reportes @endsection 
@section('subpage_active') Listado @endsection 

@section('content') 
<div class="container-fluid">
   
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <p class="text-muted font-14 mb-3" style="position: relative;height: 50px;">
                        <a href="{{ $link }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right;">
                            <span class="btn-label"><i
                                class="mdi mdi-printer"></i></span>Imprimir
                        </a>

                    </p>

                    <table id="responsive-datatable" class="table dt-responsive nowrap">
                        <thead>
                            <tr> 
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Colonia</th> 
                                <th>Contribuyente</th>
                                <th>Metros</th>
                                <th>Costo</th>
                                <th>Extra</th>  
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $row)
                                <tr>
                                    
                                    <td>{{ $row['date'] }}</td>
                                    <td>
                                        {{ $row['user'] }}
                                    </td>
                                    <td>
                                        {{ $row['colonie'] }}
                                    </td> 
                                    <td>
                                        {{ $row['contribuyente'] }}
                                    </td>
                                    <td>
                                        {{ $row['metros'] }}
                                    </td>
                                    <td>
                                       ${{ number_format($row['costo'],2) }}
                                    </td>
                                    <td>
                                        ${{ number_format($row['extras'],2) }}
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
