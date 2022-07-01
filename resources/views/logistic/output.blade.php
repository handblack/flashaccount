@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('linput.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>

                    <a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#ModalCreate">
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Nueva Salida</span>
                    </a>
                    

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Logistica / Salida de Mercaderia
                            &nbsp;
                            <i class="fas fa-warehouse fa-fw"></i>

                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- MODALES --}}
    <div class="modal fade" id="ModalCreate" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('pinvoice.store') }}" method="POST" id="form-create">
                @csrf
                <input type="hidden" name="mode" value="temp">
                <div class="modal-content">
                    <div class="modal-header pt-2 pb-2">
                        <h5 class="modal-title" id="exampleModalLabel">SALIDA</h5>
                        <div class="card-tools float-sm-right">
                            <div class="btn-group">

                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-calendar-alt fa-fw"></i> Emision
                                        </span>
                                    </div>
                                    <input type="date" name="datetrx" value="{{ date("Y-m-d") }}" class="form-control" required style="width:120px;">
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="modal-body" style="background-color:#dcdcdc74;">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0">Socio de Negocio</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>                           
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-8">
                                <label class="mb-0">Almacen</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>                           
                            <div class="col-md-4">
                                <label class="mb-0">Serie</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>                           
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="mb-0">Motivo</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>                           
                            <div class="col-md-6">
                                <label class="mb-0">Glosa</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>                           
                        </div>
                    </div>
                    <div class="modal-footer p-1">
                        <div class="row w-100">

                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button type="reset" class="btn btn-default"><i class="fas fa-window-close fa-fw"></i> Limpiar</button>                                 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Iniciar</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection