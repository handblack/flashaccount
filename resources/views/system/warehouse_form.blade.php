@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('warehouse.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>

                    

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Almacenes 
                            &nbsp;
                            <i class="fas fa-warehouse fa-fw"></i>

                        </h1>
                    </div>
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
    <ul class="nav nav-tabs d-print-none" id="mainTabs" role="tablist">
        <li class="nav-item active">
            <a href="#" class="nav-link active" data-toggle="tab" role="tab" aria-controls="ListAlmacen">                
                @if($mode =='new')
                    <i class="far fa-edit fa-fw"></i>
                @else
                    <i class="fas fa-edit fa-fw"></i>
                @endif
                <span class="d-none d-sm-inline-block">Almacen [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICANDO' }}]</strong></span>                
            </a>
        </li>        
    </ul>
    <div class="rounded-bottom border-left border-right border-bottom bg-white">
        <div class="row p-3">
            <div class="col-md-12 mb-2">
                <label class="mb-0">Identificador</label>
                <input type="text" class="form-control" id="warehousename" name="warehousename" placeholder="Nombre del almacen" value="{{ $row->warehousename }}" required>
            </div>
         
            <div class="col-md-9">
                <label class="mb-0">Nombre Corto</label>
                <input type="text" class="form-control" id="shortname" name="shortname" placeholder="Nombre Abreviado" value="{{ $row->shortname }}">
            </div>
            <div class="col-md-3">
                <label class="mb-0">Estado</label>
                <select name="isactive" id="isactive" class="form-control">
                    <option value="Y" @if($row->isactive=='Y') selected @endif>ACTIVO</option>
                    <option value="N" @if($row->isactive=='N') selected @endif>DESACTIVADO</option>
                </select>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <a href="{{ route('warehouse.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</form>
@endsection