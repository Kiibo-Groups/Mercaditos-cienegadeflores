
@extends('layouts.app')
@section('title') Listado de Oferentes  @endsection
@section('page_active') Oferentes @endsection 
@section('subpage_active') Listado @endsection 

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<style>
    * {
        font-family: "Roboto", sans-serif;
        font-weight: 600;
        font-style: normal;
    } 

    #cuadro_rojo {
        position: absolute;
        margin-top: 180px;
        z-index: 100;
    }

    #cuadro_rojo::after {
        content: "";
        width: 0;
        height: 0;
        border-left: 250px solid #A20D20;
        border-top: 150px solid transparent;
        border-bottom: 100px solid transparent;
    }

    #cuadro_blanco1 {
        position: absolute;
        top: 555px;
        right: -100px;
        z-index: 50;
    }

    #cuadro_blanco1::after {
        content: "";
        width: 0;
        height: 0;
        border-left: 1250px solid #FFF;
        border-top: 800px solid transparent;
        border-bottom: 0px solid transparent;
    }

    #cuadro_blanco2 {
        /* background: #fff; */
        color: #000 !important;
        text-align: center;
        position: relative;
        margin-top: -75px;
        padding-top: 70px;
    }

</style>
@endsection

@section('content') 
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <p class="text-muted font-14 mb-3" style="position: relative;height: 50px;">
                        <a href="{{ Asset($link . 'create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: left;">
                            <span class="btn-label"><i class="mdi mdi-check-all"></i></span>Agregar elemento
                        </a>
                        <a href="{{ route('ImportMercados') }}" type="button" class="btn btn-info waves-effect waves-light" style="float: right;">
                            <span class="btn-label"><i class="mdi mdi-file-excel"></i></span> &nbsp;Importar desde CSV
                        </a>
                    </p>

                    <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap">
                        <thead>
                            <tr> 
                                <th>QR</th>
                                <th>Contribuyente</th>
                                <th>Giro</th>
                                <th>Colonia</th>
                                <th>Metros</th>
                                <th>Costo</th> 
                                <th>Horario</th>
                                <th>Status</th>
                                <th style="text-align: right">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $row)
                                <tr>
                                    <td>
                                        @if ($row->qr_identy != '')
                                        <button type="button" 
                                            data-id="{{ $row->id }}"
                                            data-qr="{{ $row->qr_identy }}" 
                                            data-profile="{{ asset('upload/users/profile/'.$row->pic_profile) }}" 
                                            data-contribuyente="{{ $row->contribuyente }}" 
                                            data-giro="{{ $row->giro }}"
                                            data-colonies_id="{{ $req->getColonie($row->colonies_id) }}" 
                                            data-horario="@if ($row->horario == 0) Mañana @else Tarde @endif" 
                                            class="view-btn btn btn-link" data-toggle="modal" data-target="#viewModal">
                                            <img src="data:image/png;base64,{{ $row->qr_identy }}" style="width:50px;height: 50px;max-width:none !important;">
                                        </button>    
                                        @else 
                                        <img src="{{ asset('assets/images/no-image.png') }}" style="width:50px;height: 50px;max-width:none !important;">
                                        @endif
                                         
                                    </td>
                                    <td>
                                        {{ $row->contribuyente }}
                                    </td>
                                    <td>
                                        {{ $row->giro }}
                                    </td>
                                    <td>
                                        {{ $req->getColonie($row->colonies_id) }}
                                    </td>
                                    <td>
                                        {{ $row->metros }}
                                    </td>
                                    <td>
                                        {{ $row->costo }}
                                    </td> 
                                    <td>
                                        @if ($row->horario == 0)
                                        <span class="badge bg-success">Mañana</span>
                                        @else 
                                        <span class="badge bg-info">Tarde</span>                                            
                                        @endif
                                    </td>
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
                                    <td width="17%" style="text-align: right">

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary   dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Opciones <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu p-3 text-muted" style="max-width: 200px;">
                                                <a href="{{ Asset($link . $row->id . '/edit') }}"
                                                    class="dropdown-item"
                                                    data-toggle="tooltip" data-placement="top"
                                                    data-original-title="Editar">Editar</a>
                                                <a href="{{ Asset('upload/users/profile/'.$row->pic_profile) }}" target="_blank"
                                                    class="dropdown-item">Ver Foto Perfil </a>
                                                <a href="{{ Asset('upload/users/credentials/'.$row->pic_credential) }}" target="_blank"
                                                    class="dropdown-item">Ver INE <small>(Foto Frontal)</small> </a>
                                                <a href="{{ Asset('upload/users/credentials/'.$row->pic_credential_back) }}" target="_blank"
                                                    class="dropdown-item">Ver INE <small>(Foto Trasera)</small> </a>
                                                    <hr />
                                                <a type="button" class="dropdown-item"
                                                    onclick="deleteConfirm('{{ Asset($link . 'delete/' . $row->id) }}')">
                                                    Eliminar</a> 
                                            </div>
                                        </div>

                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $data->appends(request()->except('page'))->links() !!}

            </div>
        </div>
    </div>
</div> 

<div id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-dialog-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title d-print-none"> 
                    Tarjeta de presentación    
                </h5>
                <button id="print-btn" type="button" class="btn btn-default btn-sm d-print-none" style="border: 1px solid #e1e1e1;border-radius: 15px;position: absolute;right: 65px;"><i class="dripicons-print"></i> Descargar</button>
                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="close close-modal d-print-none" id="close-btn" 
                        style="background: transparent;border: none;font-size: 24px;">
                    <span aria-hidden="true"><i class="dripicons-cross"></i></span>
                </button>
            </div>
            <div class="modal-body" style="overflow: hidden;">
                <div class="gift-card" style="background-image: url('https://mercaditos-cienegadeflores.com/upload/users/group1.png');margin: 0 auto; max-width: 650px; position: relative; color:#fff;margin: auto;text-align: center;width: 350px;height: 600px;">
                    <img src="https://mercaditos-cienegadeflores.com/assets/images/card_mercados/logo.png" width="200" height="auto">
                    <div>
                        <h3 class="d-inline" style="color:#000;">DIRECCION DE COMERCIO</h3>
                        <div id="name-profile" style="width: 180px;height: 180px;border-radius: 2003px;border: 4px solid #fff;background-size: cover;background-position: center top;margin: 40px auto;z-index: 2003 !important;position: relative;"></div>
                        
                        <div id="cuadro_blanco2">
                            <h4 style="color:#9B1123;max-width: 50%;margin: auto;" id="name-contribuyente"></h4>
                            <h5 style="max-inline-size: 180px;margin: auto;">Oferente de Mercado <span id="name-colonies_id"></span></h5>   
                            <img id="card-barcode" style="width: auto;height: 120px;display: flex;margin: auto;" src="">
                         
                            <h4>FOLIO: <span id="data-id"></span></h4>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js" integrity="sha512-UcDEnmFoMh0dYHu0wGsf5SKB7z7i5j3GuXHCnb3i4s44hfctoLihr896bxM0zL7jGkcHQXXrJsFIL62ehtd6yQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).on("click", ".view-btn", function() {      
        $('#name-contribuyente').text($(this).attr('data-contribuyente'));
        // $('#name-giro').text($(this).attr('data-giro'));
        $('#name-horario').text($(this).attr('data-horario')); 
        $("#data-id").text($(this).attr('data-id'));
        $('#name-colonies_id').text($(this).attr('data-colonies_id')); 
        // Imagen de perfil
        $('#name-profile').css('background-image', 'url(' + $(this).attr('data-profile') + ')');
        // Cargamos el QR
        $('#card-barcode').attr('src',"data:image/png;base64,"+$(this).attr('data-qr'));
        // Abrimos
        $('#viewModal').modal('show');
    });

    $(document).on("click", "#print-btn", function(){
        //   var divToPrint=document.getElementById('viewModal');
        //   var newWin=window.open('','Print-Window');
        //   newWin.document.open();

        //   newWin.document.write('<link href="{{ asset("assets/css/config/default/bootstrap.min.css") }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" /><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
        //   newWin.document.close();
        //   setTimeout(function(){newWin.close();},500);
        //   5.4 x 8.6

        html2canvas(document.querySelector(".gift-card")).then(canvas => {
            // document.body.appendChild(canvas);
            var a = document.createElement('a');
            // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
            a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
            
            // var resizedCanvas = document.createElement("canvas");
            // var resizedContext = resizedCanvas.getContext("2d");

            // resizedCanvas.height = "400";
            // resizedCanvas.width = "1200";

            // resizedContext.drawImage(canvas, 0, 0, 200, 100);
          
            // a.href= resizedCanvas.toDataURL();
            a.download = 'tarjeta_presentacion.jpg';
            a.click();
        });
    });
</script>
@endsection