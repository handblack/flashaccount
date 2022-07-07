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
    <div class="card mb-1">
        <div class="card-header pt-2 pb-2">
            <div class="btn-group">
                <a class="btn btn-sm btn-secondary" href="{{ route('warehouse.index') }}" title="Recargar">
                    <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline-block">Actualizar</span>
                </a>
            </div>

            <a class="btn btn-sm btn-success" href="{{ route('warehouse.create') }}"
                title="Marcar como página de inicio">
                <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                <span class="d-none d-sm-inline-block">Añadir</span>
            </a>
            <div class="btn-group">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="text" name="query" value="" autocomplete="off"
                        placeholder="Buscar">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Buscar</span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Almacen</th>
                        <th>Abreviado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr id="tr-{{ $item->id }}">
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">{{ $item->warehousename }}</td>
                            <td>{{ $item->shortname }}</td>
                            <td class="text-right">
                                <a href="{{ route('warehouse.edit', [$item->token]) }}"> <i class="fas fa-edit"></i>
                                    <span class="d-none d-md-inline-block">Modificar</span></a> |
                                <a class="delete-record" data-url="{{ route('warehouse.destroy', $item->token) }}"
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
    <div class="row pt-1 pb-2">
        <div class="col-md-12 mt-0">
            {{ $result->links('layouts.paginate') }}
        </div>
    </div>
@endsection
