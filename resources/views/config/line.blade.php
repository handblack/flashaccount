@extends('layouts.app')

@section('breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">

                <div class="btn-group">
                    <a class="btn btn-sm btn-secondary" href="{{ route('productline.index') }}" title="Recargar">
                        <i class="fas fa-redo" aria-hidden="true"></i>
                    </a>
                </div>

                <a class="btn btn-sm btn-success" href="{{ route('productline.create') }}" title="Marcar como página de inicio">
                    <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline-block">Nuevo</span>
                </a>
                <div class="btn-group">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="query" value="" autocomplete="off" placeholder="Buscar">
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
                        Productos / Lineas
                        &nbsp;
                        <i class="fas fa-box-open fa-fw"></i>

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
            <tbody>
                @forelse ($result as $item)
                    <tr id="tr-{{ $item->id }}">
                        <td>{{ $item->linename }}</td>
                        <td>{{ $item->shortname }}</td>
                        <td class="text-right">
                            <a href="{{ route('productline.edit',[$item->token]) }}">
                                <i class="fas fa-pen-square fa-fw"></i>
                                Modificar
                            </a>
                            |
                            <a class="delete-record" data-url="{{ route('productline.destroy', $item->token) }}"
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
<div class="row">
    <div class="col-md-12 mt-0">
        {{ $result->links('layouts.paginate') }}
    </div>
</div>
@endsection