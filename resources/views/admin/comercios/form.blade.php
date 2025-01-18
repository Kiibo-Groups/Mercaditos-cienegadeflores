<!-- Tipo negocios -->
<input type="hidden" name="type" value="1">

<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">   
                <div class="card-body">
                   <div class="row"> 

                    <div class="col-md-6 mb-3">
                        <label for="contribuyente">Contribuyente</label>
                        <input type="text" name="contribuyente" id="contribuyente" class="form-control" @if (!$data->id) required="required" @endif value="{{ $data->contribuyente }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="pic_profile">Foto de perfíl</label>
                        <input type="file" name="pic_profile" id="pic_profile" class="form-control" @if (!$data->id) required="required" @endif>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="pic_credential">Credencial FRONTAL <small>(IFE/INE)</small> </label>
                        <input type="file" name="pic_credential" id="pic_credential" class="form-control" @if (!$data->id) required="required" @endif>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="pic_credential_back">Credencial REVERSO <small>(IFE/INE)</small> </label>
                        <input type="file" name="pic_credential_back" id="pic_credential_back" class="form-control" @if (!$data->id) required="required" @endif>
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label for="giro">Giro</label>
                        <input type="text" name="giro" id="giro" class="form-control" @if (!$data->id) required="required" @endif value="{{ $data->giro }}">
                    </div>
 
                    <div class="col-md-6 mb-3">
                        <label for="costo">Costo</label>
                        <input type="number" name="costo" id="costo" class="form-control" @if (!$data->id) required="required" @endif value="{{ $data->costo }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cuota">Cuota</label>
                        <input type="number" name="cuota" id="cuota" class="form-control" @if (!$data->id) required="required" @endif value="{{ $data->cuota }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="example-select">Horario</label>
                        <select name="horario"  id="example-select" class="form-select" required="required">
                            <option value="0" @if($data->horario == 0) selected @endif>Mañana</option>
                            <option value="1" @if($data->horario == 1) selected @endif>Tarde</option>
                        </select>
                    </div> 

                    <div class="col-md-6 mb-3">
                        <label class="example-select" fot="colonies_id">Mercado</label>
                        <select name="colonies_id"  id="colonies_id" class="form-select" required="required">
                            @foreach ($colonias as $item)
                                <option value="{{ $item->id }}" @if ($item->id == $data->colonies_id) selected @endif >{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>  

                    <div class="col-md-6 mb-3">
                        <label class="example-select">Status</label>
                        <select name="status"  id="example-select" class="form-select" required="required">
                            <option value="0" @if($data->status == 0) selected @endif>Activo</option>
                            <option value="1" @if($data->status == 1) selected @endif>Inactivo</option>
                        </select>
                    </div> 
                   </div>
                </div>

                <div class="mt-5" style="justify-items: end;display: grid;padding:20px;">
                    <button type="submit" class="btn btn-primary mb-2 btn-pill">
                        @if(!$data->id)
                        Agregar
                        @else 
                        Actualizar
                        @endif
                    </button>
                </div>
            </div>
        </div>           
    </div>
</div>