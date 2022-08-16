@extends('layouts.app')

@section('breadcrumb')

<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-hashtag fa-fw"></i> Serie & Secuenciador</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Sistema</li>
                    <li class="breadcrumb-item">Serie & Secuenciador</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">

                <div class="btn-group">
                    <a class="btn btn-sm btn-secondary" href="#" onclick="location.reload();" title="Recargar">
                        <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Actualizar</span>
                    </a>
                </div>

                <a class="btn btn-sm btn-success" href="{{ route('sequence.create') }}"
                    title="Marcar como página de inicio">
                    <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline-block">Agregar Secuenciador</span>
                </a>
                 

            </div>
            <div class="col-sm-6">
                <form action="{{ route('sequence.index') }}" method="GET">
                    @csrf
                    <div class="input-group input-group-sm">                    
                        <select name="og" class="form-control">
                            <option disabled {{ ($og) ? '' : 'selected' }}>-- TODAS LOS GRUPOS --</option>
                            @foreach ($group as $item)
                                <option value="{{ $item->id }}" {{ ($item->id == $og) ? 'selected' : '' }}>{{ $item->groupname }}</option>
                            @endforeach
                        </select>
                        @if($og == 2 || $og == 3 )
                            <select name="od" class="form-control">                        
                                <option value="">-- TODOS LOS DOCUMENTOS --</option>
                                @foreach ($doctype as $item)
                                    <option value="{{ $item->id }}" {{ ($item->id == $od) ? 'selected' : '' }}>{{ $item->doctypename }}</option>
                                @endforeach
                            </select>
                        @endif
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-search fa-fw"></i>
                                Buscar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
 
@endsection

@section('container')
    <div class="card">        
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Tipo Documento</th>
                        <th width="60">Serie</th>
                        <th width="60" class="text-right pr-3">Ultimo</th>
                        <th>Almacen</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)                        
                        <tr id="tr-{{ $item->id }}">
                            <td>
                                <strong>{{ $item->doctype->group->shortname }}</strong> - 
                                {{ $item->doctype->doctypename }}
                            </td>
                            <td class="border-left border-right console">{{ $item->serial }}</td>
                            <td class="text-right pr-3">{{ $item->lastnumber }}</td>
                            <td>{{ $item->warehouse->warehousename }}</td>
                            <td class="text-right">
                                <a href="{{ route('sequence.edit', [$item->token]) }}"> <i class="fas fa-edit"></i>
                                    <span class="d-none d-md-inline-block">Modificar</span></a> |
                                <a class="delete-record" data-url="{{ route('sequence.destroy', $item->token) }}"
                                    data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
 
@endsection