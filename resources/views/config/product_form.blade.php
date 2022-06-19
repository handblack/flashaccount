@extends('layouts.app')

@section('container')
<form class="form-horizontal" action="{{ $url }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="{{ ($mode == 'edit') ? 'PUT' : '' }}">
    <input type="hidden" name="token" value="{{ $row->token }}">
    <input type="text" name="productcode" value="{{ $row->productcode }}" placeholder="Codigo">
    <input type="text" name="productname" value="{{ $row->productname }}" placeholder="Descripcion">
    <select name="productfamily_id" id="" required>
        @if($mode="new")
            <option value="" disabled selected>--SELECCIONE--</option>
        @endif
        @foreach ($fam as $item)
            <option value="{{ $item->id }}" {{ ($item->id == $row->productfamily_id) ? 'selected' : '' }}>{{ $item->pfname }}</option>
        @endforeach
    </select>
    <select name="productline_id" id="" required>
        @if($mode="new")
            <option value="" disabled selected>--SELECCIONE--</option>
        @endif
        @foreach ($lin as $item)
            <option value="{{ $item->id }}" {{ ($item->id == $row->productline_id) ? 'selected' : '' }}>{{ $item->pfname }}</option>
        @endforeach
    </select>
    <button type="submit">{{ ($mode == 'new') ? 'Crear' : 'Modificar' }}</button>
</form>    
    
@endsection