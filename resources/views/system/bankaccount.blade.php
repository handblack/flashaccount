@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-piggy-bank fa-fw"></i> Cuentas de Banco</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Sistema</li>
                    <li class="breadcrumb-item">Cuentas de Banco</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('container')
    <div class="card">
        <div class="card-header pt-2 pb-2">
            <div class="btn-group">
                <a class="btn btn-sm btn-secondary" href="#" onclick="location.reload();" title="Recargar">
                    <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline-block">Actualizar</span>
                </a>
            </div>

            <a class="btn btn-sm btn-success" href="{{ route('bankaccount.create') }}"
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
                        <th>Entidad</th>
                        <th>Nro Cuenta</th>
                        <th>CLAVE</th>
                        <th>Divisa</th>
                        <th class="text-center"><i class="fas fa-check-circle fa-fw"></i></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td>{{ $item->bank->identity }}</td>
                            <td>{{ $item->accountno }}</td>
                            <td>{{ $item->shortname }}</td>
                            <td>{{ $item->currency->currencyname     }}</td>
                            <td class="text-center">{{ $item->isactive }}</td>
                            <td class="text-right">
                                <a href="{{ route('bankaccount.edit', [$item->token]) }}"> <i class="fas fa-edit"></i>
                                    Modificar</a> |
                                <a class="delete-record" data-url="{{ route('bankaccount.destroy', $item->token) }}"
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
    <div class="row">
        <div class="col-md-12 mt-0">
            {{ $result->links('layouts.paginate') }}
        </div>
    </div>
 
@endsection