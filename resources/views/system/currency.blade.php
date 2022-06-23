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
                            Divisa / Moneda
                            &nbsp;
                            <i class="fas fa-money-bill fa-fw"></i>

                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm table-hover table-borderless">
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td>{{ $item->currencyname }}</td>
                            <td>{{ $item->currencyiso }}</td>
                            <td>{{ $item->prefix }}</td>
                            <td>{{ $item->suffix }}</td>
                            <td class="text-right">
                                <a href="{{ route('currency.edit', [$item->token]) }}"> <i class="fas fa-edit"></i>
                                    Modificar</a> |
                                <a class="delete-record" data-url="{{ route('currency.destroy', $item->token) }}"
                                    data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>

                    @empty
                        
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection