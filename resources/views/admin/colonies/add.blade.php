
@extends('layouts.app')
@section('title') Gestion de Mercados @endsection
@section('page_active') Mercados @endsection 
@section('subpage_active') Agregar Elemento @endsection 


@section('content')
    {!! Form::model($data, ['url' => [ $form_url ],'files' => true]) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @include('admin.colonies.form')
    </form>
@endsection