@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('cinvoice.index') }}" title="Recargar">
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
                                <h1 class="h4 mb-0 d-none d-md-inline-block">
                                    Comprobante de Venta
                                    &nbsp;
                                    <i class="fas fa-cash-register fa-fw"></i>
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
    {{ $header->bpartner->bpartnername }}
@endsection