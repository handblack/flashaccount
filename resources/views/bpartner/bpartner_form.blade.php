@extends('layouts.app')

@section('container')
<form class="form-horizontal" action="{{ $url }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="{{ ($mode == 'edit') ? 'PUT' : '' }}">
    <input type="hidden" name="token" value="{{ $row->token }}">
    <input type="text" name="bpartnercode" value="{{ $row->bpartnercode }}" placeholder="Codigo" maxlength="12">
    <input type="text" name="bpartnername" value="{{ $row->bpartnername }}" placeholder="Descripcion" maxlength="150">
    <button type="submit">{{ ($mode == 'new') ? 'Crear' : 'Modificar' }}</button>
</form>    
    
@endsection