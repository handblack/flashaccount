@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1><i class="fas fa-users-cog fa-fw"></i> Grupos &amp; Accesos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Sistema</li>
                        <li class="breadcrumb-item">Grupos &amp; Accesos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection
 


@section('container')
    <div class="card mb-2">
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
        <div class="card-body table-responsive p-0" >
            <table class="table table-hover text-nowrap table-sm table-borderless">
                <thead>
                    <tr class="bg-light">
                        <th>Equipo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result as $item)
                        <tr id="tr-{{ $item->id }}">
                            <td class="" style="{{ $item->isactive == 'Y' ? '' : 'tachado' }}">
                                <a href="{{ route('team.show',$item->token) }}">
                                    {{ $item->teamname }} 
                                </a>
                            </td>
                            
                            <td class="text-right">
                                <a href="{{ route('teamgrant.schedule', $item->token) }}"> <i class="far fa-clock fa-fw"></i>
                                    <span class="d-none d-md-inline-block">Horario</span></a>&nbsp;|&nbsp;
                                <a href="{{ route('teamgrant.serial', $item->token) }}"> <i class="fas fa-list-ol fa-fw"></i>
                                    <span class="d-none d-md-inline-block">Series</span></a>&nbsp;|&nbsp;
                                <a href="{{ route('teamgrant.warehouse', $item->token) }}"> <i class="fas fa-warehouse fa-fw"></i>
                                    <span class="d-none d-md-inline-block">Almacen</span></a>&nbsp;|&nbsp;
                                <a href="{{ route('teamgrant.show', $item->token) }}"> <i class="fas fa-key"></i>
                                    <span class="d-none d-md-inline-block">Accesos</span></a>&nbsp;|&nbsp;
                                <a href="{{ route('team.edit', [$item->token]) }}"> <i class="fas fa-edit"></i>
                                    <span class="d-none d-md-inline-block">Modificar</span></a> |&nbsp;
                                <a class="delete-record" data-url="{{ route('team.destroy', $item->token) }}"
                                    data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-top">
                        <th colspan="6">{{ count($result) }} - Registros</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 pt-2">
            {{ $result->links('layouts.paginate') }}
        </div>
    </div>
@endsection


 
