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
                        <li class="breadcrumb-item"><a href="{{ route('team.index') }}">Grupos &amp; Accesos</a></li>
                        <li class="breadcrumb-item">Almacenes</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content-header pt-1 pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('team.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a class="btn btn-sm btn-secondary" href="#" onclick="location.reload()" title="Recargar">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block"> Actualizar</span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div>
    </section> 
@endsection

 

@section('container')    
<div class="card">
    <div class="card-header">        
        <h5 class="card-title"><strong>{{ $row->teamname }}</strong></h5>
        <div class="card-tools">
            <form action="{{ route('teamgrant.store') }}" method="post">
                @csrf
                <input type="hidden" name="team_id" value="{{ $row->id }}">
                <input type="hidden" name="mode" value="warehouse-add">
                <div class="input-group input-group-sm">
    
                    <select name="warehouse_id" class="form-control console" required>
                        <option value="" selected disabled>-- SELECCIONA SECUENCIADOR --</option>                    
                        @foreach ($wah as $item)
                            <option value="{{ $item->id }}" class="{{ ($item->isactive == 'N') ? 'tachado' : '' }}">{{ $item->shortname }} - {{ $item->warehousename }} {{ ($item->isactive == 'N') ? '[DESACTIVADO]' : '' }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>    
 
    <div class="card-body table-responsive p-0">
        <table class="table table-sm">
            @foreach ($row->warehouses as $item)
                <tr id="tr-{{ $item->id }}">
                    <td width="60">{{ $item->warehouse->shortname }}</td>
                    <td>{{ $item->warehouse->warehousename }}</td>
                    <td class="text-right">
                        <a class="delete-record" data-url="{{ route('teamgrant.destroy', 'warehouse|'.$item->id) }}"
                            data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection