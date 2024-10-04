
@extends('layouts.app')
@section('title') Importar Oferentes @endsection
@section('page_active') Oferentes @endsection 
@section('subpage_active') Importar @endsection 

@section('content') 
<div class="container-fluid">
    <div class="row ">
        <div class="col-lg-12 mt-2">
            <div class="card py-3 m-b-30">
                <div class="card-body">
                    {!! Form::open(['url' => [$form_url],'files' => true],['class' => 'col s12']) !!} 
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="import_lbl">
                                    Seleccion el Archivo
                                </label>
                                <input type="file" id="import_lbl" class="form-control" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required="required">
                                <span>
                                    <small>(Recuerde ingresar los mismos campos en el orden correspondiente :
                                        Fotografia de perfil,<br />
                                        Fotografia de ine Frontal,<br />
                                        Fotografia de ine Reverso,<br />
                                        Contribuyente,<br/>
                                        Giro,<br/>
                                        Colonia,<br />
                                        Metros,<br /> 
                                        Costo,<br /> 
                                        Cuota,<br />
                                        Horario)</small>
                                </span>
                            </div> 
                        </div>
                        <br />
                        <button type="submit" id="btn-send" onclick="activeBtn()" class="btn btn-success btn-cta">Subir Archivo</button> 
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@section('scripts')
<script>
    function activeBtn() {
        let btn = document.getElementById('btn-send');
        btn.innerHTML = "Subiendo archivo...";
        btn.classList.add("disabled");
    } 
</script>
@endsection