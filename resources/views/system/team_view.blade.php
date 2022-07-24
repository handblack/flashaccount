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
<div class="card">
    <div class="card-header">
        <h5 class="card-title"><strong>{{ $row->teamname }}</strong> - Resumen de accesos</h5>
    </div>
    <div class="card-body">
        <legend class="text-info mt-2 mb-0"><i class="far fa-clock fa-fw"></i> Horarios </legend>
        <div class="row">
            <div class="col-md-6">Horarios de Accesos</div>
            <div class="col-md-6">Dias</div>
        </div>

        <div class="row"></div>
        <legend class="text-info mt-2 mb-0"><i class="fas fa-list-ol fa-fw"></i> Series (Secuenciadores) </legend>
        <legend class="text-info mt-2 mb-0"><i class="fas fa-warehouse fa-fw"></i> Almacenes </legend>
        <div class="row">
            <div class="col-md-12">
                Todos los almacenes
            </div>
        </div>
        
        <legend class="text-info mt-2 mb-0"><i class="far fa-list-alt fa-fw"></i> Usuarios </legend>
        <div class="row"></div>
    </div>
</div>


@endsection