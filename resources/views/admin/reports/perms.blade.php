
@extends('layouts.app')
@section('title') Listado de Permisos de alcohol @endsection
@section('page_active') Permisos de alcohol @endsection 
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
                                <th>Usuario</th>
                                <th>Colonia</th> 
                                <th>Dictamen protección civil</th>
                                <th>Dictamen aforo protección civil</th>
                                <th>Comprobante pago predial</th>
                                <th>Comprobante de arrendamiento</th>   
                                <th>Licencia uso de suelo</th>   
                                <th>Justificante</th>   
                                <th>Manifiesto no impedimento</th>   
                                <th>Anuencia municipal</th>   
                                <th>Pago de anuencia</th>  
                                <th>Pago de impuestos estatales</th>  
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $row)
                                <tr>
                                    
                                    <td>
                                        {{ $row['user'] }}
                                    </td>
                                    <td>
                                        {{ $row['colonie'] }}
                                    </td> 
                                    <td>
                                        {{ $row['perm1'] }}
                                    </td>
                                    <td>
                                        {{ $row['perm2'] }}
                                    </td> 
                                    <td>
                                        {{ $row['perm3'] }}
                                    </td> 
                                    <td>
                                        {{ $row['perm4'] }}
                                    </td> 
                                    <td>
                                        {{ $row['perm5'] }}
                                    </td> 
                                    <td>
                                        {{ $row['perm6'] }}
                                    </td> 
                                    <td>
                                        {{ $row['perm7'] }}
                                    </td> 
                                    <td>
                                        {{ $row['perm8'] }}
                                    </td> 
                                    <td>
                                        {{ $row['perm9'] }}
                                    </td> 
                                    <td>
                                        {{ $row['perm10'] }}
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
