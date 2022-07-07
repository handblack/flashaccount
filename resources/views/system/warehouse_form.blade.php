@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-warehouse fa-fw"></i> Almacenes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Sistema</li>
                    <li class="breadcrumb-item">Almacenes</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('container')
<form class="form-horizontal" action="{{ $url }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="{{ ($mode == 'edit') ? 'PUT' : '' }}">
    <input type="hidden" name="token" value="{{ $row->token }}">
    <div class="card">
        <div class="card-header">
            <div class="card-title">

                <ul class="nav nav-tabs card-header-tabs" >
                    <li class="nav-item">
                        <span class="nav-link active">
                            @if($mode =='new')
                            <i class="far fa-edit fa-fw"></i>
                            @else
                            <i class="fas fa-edit fa-fw"></i>
                            @endif
                            <span class="d-sm-inline-block">
                                Almacen [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICANDO' }}]</strong>
                            </span>                
                        </span>
                    </li>
                </ul>
            </div>
            <div class="card-tools ">
                    <ul class="nav">
                        <li>                        
                            <div class="card-tools pull-right">
                                
                                <a class="btn btn-sm btn-secondary" href="#" onclick="history.back()" title="Recargar">
                                    <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                                    <span class="d-none d-lg-inline-block">Todos</span>
                                </a>
                                <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                                    <i class="fas fa-redo" aria-hidden="true"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-8">
                    <label class="mb-0">Identificador</label>
                    <input type="text" class="form-control" id="warehousename" name="warehousename" placeholder="Nombre del almacen" value="{{ $row->warehousename }}" required>
                </div>
                <div class="col-md-4">
                    <label class="mb-0">Nombre Corto</label>
                    <input type="text" class="form-control" id="shortname" name="shortname" placeholder="Nombre Abreviado" value="{{ $row->shortname }}">
                </div>
            </div>
        </div>
        <div class="card-footer pt-1">
            <div class="row">
                <div class="col-md-4  mt-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Estado</span>
                        </div>
                        <select name="isactive" id="isactive" class="form-control">
                            <option value="Y" @if ($row->isactive == 'Y') selected @endif>ACTIVO</option>
                            <option value="N" @if ($row->isactive == 'N') selected @endif>DESACTIVADO</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                </div>
                <div class="col-md-4 mt-2">
                    <div class="float-right">
                        <a href="{{ route('warehouse.index') }}" class="btn btn-secondary"> <i class="fas fa-times"></i> Cancelar</a>                
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ ($mode == 'new') ? 'Crear' : 'Modificar' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



 
</form>
@endsection