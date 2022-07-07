@extends('layouts.app')

@section('breadcrumb')
 
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-box-open fa-fw"></i> Productos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Catalogos</li>
                    <li class="breadcrumb-item">Productos</li>
                </ol>
            </div>
        </div>
    </div>
</section>
 

 
@endsection

 

@section('container')
<div class="card mb-1">
    <div class="card-header pt-2 pb-2">
        <div class="btn-group">
            <a class="btn btn-sm btn-secondary" href="#" onclick="location.reload();" title="Recargar">
                <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                <span class="d-none d-sm-inline-block">Actualizar</span>
            </a>
        </div>

        <a class="btn btn-sm btn-success" href="{{ route('product.create') }}"
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
        <table class="table table-hover text-nowrap table-sm table-borderless">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Producto / Descripcion</th>
                    <th class="d-none d-sm-inline-block">UM</th>
                    <th></th>
                </tr>    
            </thead> 
            <tbody>
                @forelse ($result as $item)
                    <tr id="tr-{{ $item->id }}">
                        <td width="70">
                            <a href="{{ route('product.edit',[$item->token]) }}">
                            {{ $item->productcode }}
                            </a>
                        </td>
                        <td class="{{ ($item->isactive == 'N') ? 'tachado' : '' }}">{{ $item->productname }}</td>
                        <td class="d-none d-sm-inline-block {{ ($item->isactive == 'N') ? 'tachado' : '' }}">{{ $item->um->shortname }}</td>
                        <td class="text-right">
                            <a class="delete-record" data-url="{{ route('product.destroy', $item->token) }}"
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
    <div class="col-md-12 mt-0">
        {{ $result->links('layouts.paginate') }}
    </div>
</div>
@endsection