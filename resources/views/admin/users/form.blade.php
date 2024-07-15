
@section('styles')
<link href="{{ asset('assets/libs/mohithg-switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">   
                <div class="card-body">
                   <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" @if (!$data->id) required="required" @endif value="{{ $data->name }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="last_name">Apellidos</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" @if (!$data->id) required="required" @endif value="{{ $data->last_name }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email">Correo electrónico</label>
                        <input type="text" name="email" id="email" class="form-control" @if (!$data->id) required="required" @endif value="{{ $data->email }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone">Teléfono</label>
                        <input type="text" name="phone" id="phone" class="form-control" @if (!$data->id) required="required" @endif value="{{ $data->phone }}">
                    </div>
 
                    <div class="col-md-6 mb-3">
                        <label class="example-select" fot="selectize-optgroup">Colonia asignada</label>
                        <select name="colonies_id[]" class="form-control select2-multiple" data-toggle="select2" data-width="100%" multiple="multiple" required="required">
                            @foreach ($colonias as $item)
                                <option value="{{ $item->id }}"  @if(in_array($item->id,$coloniesAssign)) selected @endif >
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="clearfix"></div>
                    </div>  

                    <div class="col-md-6 mb-3">
                        @if (!$data->id) <!-- Nuevo -->
                            <label for="password">Contraseña</label>
                            <input type="text" name="password" id="password" class="form-control" @if (!$data->id) required="required" @endif>
                        @else 
                        <label for="password">Actualizar Contraseña <small>(Solo si es requerido)</small> </label>
                        <input type="password" name="password" id="password" class="form-control" @if (!$data->id) required="required" @endif value="{{ $data->password }}">
                        @endif
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


@section('scripts')
<script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>
<script src="{{ asset('assets/libs/mohithg-switchery/switchery.min.js') }}"></script>
<script src="{{ asset('assets/libs/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-mockjax/jquery.mockjax.min.js') }}"></script>
<script src="{{ asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

<!-- Init js-->
<script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
@endsection