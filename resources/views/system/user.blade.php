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
<div class="card">
    <div class="card-header bg-light">
        <div class="card-title">Usuario</div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
            @foreach ($result as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>

                    </td>
                </tr>

            @endforeach
        </table>
    </div>
</div>
@endsection