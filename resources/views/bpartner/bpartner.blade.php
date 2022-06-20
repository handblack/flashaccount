@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('bpartner.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>

                    <a class="btn btn-sm btn-success" href="{{ route('bpartner.create') }}"
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
                                </button>
                            </span>
                        </div>
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
<div class="card">
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
                        <td width="100">
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

@endsection