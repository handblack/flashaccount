@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('corder.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-sm-right">
                                <h1 class="h5 mb-0 d-none d-md-inline-block">
                                    Orden de Venta
                                    &nbsp;
                                    <i class="fas fa-edit fa-fw"></i>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('container')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <strong>Cliente</strong>
                    <p class="text-muted">{{ $header->bpartner->bpartnername }}</p>
                </div>
                <div class="col-md-2">
                    <strong>Almacen</strong>
                    <p class="text-muted">{{ $header->warehouse->shortname }}</p>
                </div>
                <div class="col-md-2">
                    <strong>Fecha</strong>
                    <p class="text-muted">{{ $header->dateorder }}</p>
                </div>
                <div class="col-md-2">
                    <strong>Moneda</strong>
                    <p class="text-muted">{{ $header->currency->currencyname }}</p>
                </div>
            </div>
        </div>

        <div class="card-body">
            
        </div>

        <div class="card-body border-top bg-light" id="order-items-totales">             
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="input-group ">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">BASE</span>
                        </div>
                        <span class="form-control disabled text-right text-monospace">{{ number_format($lines->sum('it_base'),2) }}</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="input-group ">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">EXO</span>
                        </div>
                        <span class="form-control disabled text-right text-monospace">0.00</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="input-group ">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">IGV</span>
                        </div>
                        <span class="form-control disabled text-right text-monospace">{{ number_format($lines->sum('it_tax'),2) }}</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="input-group ">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-secondary" id="basic-addon1"><strong>TOTAL</strong></span>
                        </div>
                        <span class="form-control disabled text-right text-monospace">{{ number_format($lines->sum('it_grand'),2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection