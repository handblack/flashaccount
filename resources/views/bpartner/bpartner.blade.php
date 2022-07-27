@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit fa-fw"></i> Maestro de Socio de Negocio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Socio de Negocio</li>
                    <li class="breadcrumb-item">Maestro de Socio de Negocio</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('bpartner.index') }}" title="Recargar">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Actualizar</span>
                        </a>
                    </div>

                    <a class="btn btn-sm btn-success" href="{{ route('bpartner.create') }}"
                        title="Marcar como página de inicio">
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Añadir</span>
                    </a>
                    <div class="btn-group">
                        <form action="{{ route('bpartner.index') }}" method="GET">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input class="form-control" type="text" name="q" value="{{ $q }}" autocomplete="off"
                                    placeholder="Buscar">
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-search" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="col-sm-6">
                     
                </div>
            </div>
        </div>
    </section>
@endsection


@section('container')
<div class="card mb-1">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-sm table-borderless">    
            <thead>
                <tr class="bg-light">
                    <th>Codigo</th>
                    <th>Razon Social</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($result as $item)
                    <tr id="tr-{{ $item->id }}">
                        <td width="130">
                            <a href="{{ route('bpartner.edit',[$item->token]) }}">
                            {{ $item->bpartnercode }}
                            </a>
                        </td>
                        <td>{{ $item->bpartnername }}</td>
                        <td class="text-right">
                            <a class="delete-record" data-url="{{ route('bpartner.destroy', $item->token) }}"
                                data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No hay resultado en la busqueda</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="row pt-1 pb-2">
    <div class="col-md-12">
        {{ $result->links('layouts.paginate') }}
    </div>
</div>

@endsection