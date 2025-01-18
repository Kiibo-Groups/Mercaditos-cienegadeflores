
@extends('layouts.app')
@section('title') Gestion de Comercios @endsection
@section('page_active') Comercios @endsection 
@section('subpage_active') Editar Elemento @endsection 

@section('content')
    {!! Form::model($data, ['url' => $form_url,'files' => true,'method' => 'PATCH']) !!}
    <input type="hidden" value="{{$data->id}}" name="id">
        @include('admin.comercios.form')
    </form>
@endsection