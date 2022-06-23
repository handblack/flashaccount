@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1>&nbsp;&nbsp;<i class="fas fa-tools"></i>  {{ !empty($title) ? $title : $this->title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Sistema</li>
                        <li class="breadcrumb-item active"><a href="{{ route('parameter.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item">@if($mode=='new') Crear Nuevo @else Modificar Registro @endif</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('container')
@if($mode == 'new')
<form class="form-horizontal" action="{{ route('parameter.store') }}" method="POST">
@elseif($mode == 'edit')
<form class="form-horizontal" action="{{ route('parameter.update',$row->id) }}" method="POST">
    <input type="hidden" name="_method" value="put">
@endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="card card-outline">
        <div class="card-header" >
            <div class="card-title">
                Parametros de Sistema <strong>[{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICAR' }}]</strong>
            </div>
        </div>
        <div class="card-body">

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Grupo de Parametros</label>
                <div class="col-sm-9">
                    <select name="group_id" id="group_id" class="form-control" {{ ($mode == 'edit') ? 'disabled' : '' }}>
                        @if($mode == 'new')
                            @foreach ($grupos as $item)
                                <option value="{{ $item['id'] }}" {{ ($item['id'] == session('cv_param_group_select_id')) ? 'selected' : '' }}>{{ $item['name'] }} </option>
                            @endforeach
                        @else
                            @foreach ($grupos as $item)
                                <option value="{{ $item['id'] }}" {{ ($item['id'] == $row->group_id) ? 'selected' : '' }}>{{ $item['name'] }} </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Identity [clave::string]</label>
                <div class="col-sm-9">
                    <input name="identity" class="form-control" value="{{ old('identity',$row->identity) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Nombre Corto [clave::string]</label>
                <div class="col-sm-5">
                    <input name="shortname" class="form-control" value="{{ old('shortname',$row->shortname) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Valor [value::string]</label>
                <div class="col-sm-5">
                    <input name="value" class="form-control" value="{{ old('value',$row->value) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Es Requerido</label>
                <div class="col-sm-5">
                    <select name="isrequired" id="" class="form-control">
                        <option value="Y" {{ ($row->isrequired == 'Y') ? 'selected' :'' }}>SI</option>
                        <option value="N" {{ ($row->isrequired == 'N') ? 'selected' :'' }}>NO</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Nombre Corto [clave::string]</label>
                <div class="col-sm-5">
                    <select name="isactive" id="" class="form-control">
                        <option value="Y" {{ ($row->isactive == 'Y') ? 'selected' :'' }}>SI</option>
                        <option value="N" {{ ($row->isactive == 'N') ? 'selected' :'' }}>NO</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Orden</label>
                <div class="col-sm-1">
                    <input name="orden" class="form-control text-right" value="{{ old('orden',$row->orden) }}">
                </div>
            </div>


            <!-- SEGUNDO -->
        </div>
        <div class="card-footer">
            <div class="float-right">
                <a href="{{ route('parameter.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</form>
@endsection
