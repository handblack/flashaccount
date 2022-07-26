@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-1">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-users fa-fw"></i> Usuarios
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Sistema</li>
                    <li class="breadcrumb-item">Usuarios</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('user.index') }}" title="Recargar">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block"> Actualizar</span>
                        </a>
                    </div>

                    
                    <div class="btn-group">
                        <form action="{{ route('user.index') }}" method="GET">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input class="form-control" type="text" name="q" value="{{ $q }}" autocomplete="off" placeholder="Buscar USUARIO">
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-search" aria-hidden="true"></i>
                                        <span class="d-none d-sm-inline-block"> Buscar</span>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a class="btn btn-sm btn-success" href="{{ route('user.create') }}" title="Marcar como página de inicio">
                            <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Agregar Usuario</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('container')
<div class="card mb-1">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
            <thead>
                <tr class="bg-light">
                    <th>Usuario</th>
                    <th>e-mail</th>
                    <th>Grupo</th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($result as $item)
                <tr id="tr-{{ $item->id }}">
                    <td class="{{ ($item->isactive == 'N') ? 'tachado' : '' }}">
                        <a href="{{ route('user.edit', [$item->token]) }}">  
                            {{ $item->name }}
                        </a>
                    </td>
                    <td class="{{ ($item->isactive == 'N') ? 'tachado' : '' }}">{{ $item->email }}</td>
                    <td class="{{ ($item->isactive == 'N') ? 'tachado' : '' }}">{{ $item->team->teamname }}</td>
                    <td class="text-right">                        
                        <a class="delete-record" data-url="{{ route('user.destroy', $item->token) }}"
                            data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<div class="row pt-1 pb-2">
    <div class="col-md-12">
        {{ $result->links('layouts.paginate') }}
    </div>
</div>
@endsection