<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">   
                <div class="card-body">
                   <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="url" class="form-label">Url de redirección</label>
                        <input class="form-control" id="url" type="url" name="url" value="{{ $data->url }}">
                    </div> 

                    <div class="col-md-6 mb-3">
                        <label for="img">Imagen</label>
                        <input type="file" name="img" id="img" class="form-control" @if (!$data->id) required="required" @endif>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="example-select">Posición <small>(Inicial e Inermedio)</small> </label>
                        <select name="position"  id="example-select" class="form-select" required="required">
                            <option value="0" @if($data->position == 0) selected @endif>Inicial (Banners - 768px * 432px)</option>
                            <option value="1" @if($data->position == 1) selected @endif>Intermedio (Itinerario - 650px * 1024px )</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="example-select">Status</label>
                        <select name="status"  id="example-select" class="form-select" required="required">
                            <option value="0" @if($data->status == 0) selected @endif>Activo</option>
                            <option value="1" @if($data->status == 1) selected @endif>Inactivo</option>
                        </select>
                    </div>
                    
                    @if($data->id)
                    <div class="col-md-6 mb-3">
                        <img src="{{ Asset('upload/banner/' . $data->img) }}" height="120">
                    </div>
                    @endif
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