@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('user.index') }}" title="Recargar">
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
                            Usuarios
                            &nbsp;
                            <i class="fas fa-users ml-3"></i>

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
    <ul class="nav nav-tabs d-print-none" id="mainTabs" role="tablist">
        <li class="nav-item active">
            <a href="#" class="nav-link active" data-toggle="tab" role="tab" aria-controls="ListAlmacen">                
                <i class="fas fa-users fa-fw"></i>
                <span class="d-none d-sm-inline-block">Usuarios [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICANDO' }}]</strong></span>                
            </a>
        </li>        
    </ul>
    <div class="rounded-bottom border-left border-right border-bottom bg-white">
        <div class="row pl-3 pr-3 pt-3">
            <div class="col-md-3">
                <label class="mb-0">Nombre Usuario</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Identificador del Equipo" value="{{ $row->name }}" required>
            </div>
            <div class="col-md-6">
                <label class="mb-0">Correo</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Identificador del Equipo" value="{{ old('email',$row->email) }}" required>
            </div>
            <div class="col-md-3">
                <label class="mb-0">Estado</label>
                <select name="isactive" id="isactive" class="form-control">
                    <option value="Y" @if($row->isactive=='Y') selected @endif>ACTIVO</option>
                    <option value="N" @if($row->isactive=='N') selected @endif>DESACTIVADO</option>
                </select>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-md-6">
                <label class="mb-0">Contraseña</label>
                <input type="text" class="form-control" id="password" name="password" placeholder="Identificador del Equipo" value="{{ old('password') }}" required>
            </div>
            <div class="col-md-6">
                <label class="mb-0">Grupo</label>                
                <select class="form-control" name="current_team_id" id="current_team_id" required>
                    @if ($mode == 'new')
                        <option value="" selected disabled >-- SELECCIONE --</option>
                    @endif
                    @foreach ($teams as $item)
                        <option value="{{ $item->id }}" {{ ($item->id == $row->current_team_id) ? 'selectd' : '' }}>{{ $item->teamname }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <div class="float-right">
                <a href="{{ route('user.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>

 
</form>
@endsection


 