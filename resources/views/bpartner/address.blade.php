@extends('layouts.app')
 
@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1><i class="fas fa-map-marked fa-fw"></i> Direcciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Socio de Negocio</li>
                        <li class="breadcrumb-item">Maestro</li>
                        <li class="breadcrumb-item">Direcciones</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('bpartner.edit',[$row->token]) }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Actualizar</span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Socio de Negocio
                            &nbsp;<i class="nav-icon fas fa-user-tie ml-3"></i>

                        </h1>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
 

@section('container')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <span class="nav-link">
                        <a href="{{ route('bpartner.edit',[$row->token]) }}">
                            <i class="far fa-address-card fa-fw"></i>
                            <span class="d-none d-sm-inline-block">
                                Socio de Negocio </strong>
                            </span>
                        </a>
                    </span>
                </li>
                
                <li class="nav-item">
                    <span class="nav-link active">
                        <i class="fas fa-map-marked fa-fw"></i>
                        <span class="d-none d-sm-inline-block">
                            Direcciones
                        </span>
                    </span>
                </li>

                <li class="nav-item">
                    <span class="nav-link">
                        <a href="{{ route('bpartnercontact.index') }}">
                            <i class="far fa-address-book fa-fw"></i>
                            <span class="d-none d-sm-inline-block">
                                Contactos
                            </span>
                        </a>
                    </span>
                </li>
                
            </ul>
        </div>
    </div>
    <div class="card-header" style="background-color: #fff;">
        <h3 class="card-title">{{ $row->bpartnercode }} - {{ $row->bpartnername }}</h3>
        <div class="card-tools pull-right">
            <div class="input-group input-group-sm">
                <a href="{{ route('bpartneraddress.create') }}" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-plus-square"></i>&nbsp;&nbsp;Añadir Direccion
                </a>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-sm table-borderless">
            <thead>
                <tr>
                    <th>Direccion</th>
                    <th></th>
                    <th></th>
                    <th></th>                    
                </tr>
            </thead>
            <tbody>
                @forelse($result as $item)
                <tr id="tr-{{ $item->id }}">
                    <td>
                        {{ $item->address }}
                        {{ $item->reference ? "({$item->reference})" : '' }}
                        {{ $item->bpartner_city_id ? ' - ' . $item->city->cityname : '' }}
                        {{ $item->bpartner_county_id ? ' - ' . $item->county->countyname : '' }}
                    </td>
                    <td>{{ $item->bpartner_state_id ? $item->state->statename : '' }}</td>
                    <td class="border-left border-right" width="30">{{ $item->bpartner_country_id ? $item->country->alfa2 : '' }}</td>
                    <td class="text-right">
                        <a href="{{ route('bpartneraddress.edit',[$item->token]) }}"> <i class="fas fa-edit"></i> Modificar</a> |
                        <a class="delete-record" data-url="{{ route('bpartneraddress.destroy',$item->token) }}" data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-danger">No hay datos registrados!</td>
                </tr>
                @endforelse
            </tbody>
            <tbody>
                <tr class="border-top">
                    <th colspan="5">
                        {{ count($result) }} - Registros
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection


 
