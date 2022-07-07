@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('currency.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>

                    <a class="btn btn-sm btn-success" href="{{ route('currency.create') }}"
                        title="Marcar como página de inicio">
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Añadir</span>
                    </a>
               

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h4 class="h4 mb-0   d-md-inline-block">
                            Divisa / Moneda
                            &nbsp;
                            <i class="fas fa-money-bill fa-fw"></i>

                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')
    <div class="card">
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