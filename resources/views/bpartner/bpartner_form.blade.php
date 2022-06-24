@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('bpartner.index') }}" title="Recargar">
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
                            Socio de Negocio
                            &nbsp;<i class="nav-icon fas fa-user-tie ml-3"></i>

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
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" >
            <li class="nav-item">
                <span class="nav-link active">
                    @if($mode =='new')
                        <i class="far fa-edit fa-fw"></i>
                    @else
                        <i class="fas fa-edit fa-fw"></i>
                    @endif
                    <span class="d-none d-sm-inline-block">
                        Informacion del Socio de Negocio [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICANDO' }}]</strong>
                    </span>                
                </span>
                 
            </li>
            
        </ul>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <label class="mb-0">Codigo SN</label>
                <input type="text" name="bpartnercode" class="form-control" value="{{ $row->bpartnercode }}" placeholder="Codigo" maxlength="12">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="mb-0">Razon Social / Denominacion</label>
                <input type="text" name="bpartnername" class="form-control" value="{{ $row->bpartnername }}" placeholder="Descripcion" maxlength="150">
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="btn-group">
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
        <div class="float-right">
            <a href="{{ route('bpartner.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>                
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ ($mode == 'new') ? 'Crear' : 'Modificar' }}</button>
        </div>
    </div>
</div>
</form>    
    
@endsection