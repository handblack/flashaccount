@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('bexpense.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="btn-group">
                        
                        <a href="#" class="btn btn-sm btn-success" onclick="document.getElementById('form-payment').submit(); return false;">
                            <i class="far fa-file-alt fa-fw"></i> Preliminar
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Asignacion de Valores 
                            &nbsp;<i class="fab fa-cc-visa fa-fw"></i>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection