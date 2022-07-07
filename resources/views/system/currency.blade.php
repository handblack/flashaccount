@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1><i class="fas fa-money-bill fa-fw"></i> Divisas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Sistema</li>
                        <li class="breadcrumb-item">Divisas</li>
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
                <a class="btn btn-sm btn-secondary" href="#" onclick="location.reload()" title="Recargar">
                    <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline-block">Actualizar</span>
                </a>
            </div>

            <a class="btn btn-sm btn-success" href="{{ route('warehouse.create') }}"
                title="Marcar como página de inicio">
                <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                <span class="d-none d-sm-inline-block">Nuevo</span>
            </a>
             
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td>{{ $item->currencyname }}</td>
                            <td>{{ $item->currencyiso }}</td>
                            <td>{{ $item->prefix }}</td>
                            <td>{{ $item->suffix }}</td>
                            <td class="text-right">
                                <a href="{{ route('currency.edit', [$item->token]) }}"> <i class="fas fa-edit"></i>
                                    <span class="d-none d-md-inline-block">Modificar</span></a> |
                                <a class="delete-record" data-url="{{ route('currency.destroy', $item->token) }}"
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