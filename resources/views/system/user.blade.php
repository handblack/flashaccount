@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('user.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>

                    <a class="btn btn-sm btn-success" href="{{ route('user.create') }}"
                        title="Marcar como página de inicio">
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Añadir</span>
                    </a>
                    <div class="btn-group">
                        <form action="{{ route('user.index') }}">
                            <div class="input-group input-group-sm">
                                <input class="form-control" type="text" name="q" value="{{ $q }}" auto}complete="off"
                                placeholder="Buscar EMAIL">
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
                    <td>
                        <a href="{{ route('user.edit', [$item->token]) }}">  
                            {{ $item->name }}
                        </a>
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->team->teamname }}</td>
                    <td class="text-right">                        
                        <a class="delete-record" data-url="{{ route('user.destroy', $item->token) }}"
                            data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12 pt-2">
        {{ $result->links('layouts.paginate') }}
    </div>
</div>
@endsection