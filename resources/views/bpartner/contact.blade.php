@extends('layouts.app')
 
@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1><i class="far fa-address-book fa-fw"></i> Contactos</h1>
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
                    <span class="nav-link">
                        <a href="{{ route('bpartneraddress.index') }}">
                            <i class="fas fa-map-marked fa-fw"></i>
                            <span class="d-none d-sm-inline-block">
                                Direcciones
                            </span>
                        </a>
                    </span>
                </li>

                <li class="nav-item">
                    <span class="nav-link active">
                        <i class="far fa-address-book fa-fw"></i>
                        <span class="d-none d-sm-inline-block">
                            Contactos
                        </span>
                    </span>
                </li>
                
            </ul>
        </div>
         
    </div>
    <div class="card-header" style="background-color: #fff;">
        <h3 class="card-title">{{ $row->bpartnercode }} - {{ $row->bpartnername }}</h3>
        <div class="card-tools pull-right">
            <div class="input-group input-group-sm">                
                <a href="{{ route('bpartnercontact.create') }}" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#ModalCreateContact">
                    <i class="fas fa-plus-square"></i>&nbsp;&nbsp;Añadir Contacto
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @forelse($result as $item)
                <div class="col-md-3" id="tr-{{ $item->id }}">
                    <div class="p-2" style="border:1px solid #dcdcdc;border-radius:4px;">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="mb-0">{{ $item->contactname }}</label>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0 float-right">
                                    <a href="{{ route('bpartnercontact.edit',[$item->token]) }}">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                    <a class="delete-record" 
                                        data-url="{{ route('bpartnercontact.destroy', $item->token) }}"
                                        data-id="{{ $item->id }}">
                                        <i class="far fa-trash-alt fa-fw"></i>
                                    </a>
                                </label>
                            </div>
                        </div>
                        {{ $item->workplace }}
                        <ul class="list-unstyled">
                            @foreach ($item->email as $email)
                                <li><i class="fas fa-envelope-open-text fa-fw"></i> {{ $email }}</li>
                            @endforeach
                            @foreach ($item->phone as $phone)
                                <li><i class="fas fa-mobile-alt fa-fw"></i> {{ $phone }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <p class="lead">Sin informacion</p>
            @endforelse
        </div>
    </div>
    
</div>

<!-- 
MODAL
-->

<form action="{{ route('bpartnercontact.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="ModalCreateContact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Contacto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">

                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="mb-0">Contacto </label>
                            <input type="text" name="contactname" class="form-control" maxlength="100">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="mb-0">Cargo / Referencia</label>
                            <input type="text" name="workplace" class="form-control" maxlength="100">
                        </div>
                    </div>
                    <div class="row" id="form_email">
                        <!-- EMAIL -->
                        <div class="col-md-12 mt-2" >
                            <label class="mb-0">Email</label>
                            <label class="float-right mb-0"><a href="#" class="font-weight-light add-email"><i class="far fa-plus-square fa-fw"></i> Agregar</a></label>
                            <div class="input-group mb-0">
                                <div class="input-group-prepend" >
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope-open-text fa-fw"></i></span>
                                </div>
                                <input type="email" name="email[]" class="form-control " placeholder="E-mail" aria-label="E-mail" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="form_phone">
                        <!-- TELEFONO -->
                        <div class="col-md-12 mt-2">
                            <label class="mb-0">Telefono</label>
                            <label class="float-right mb-0"><a href="#" class="font-weight-light add-phone"><i class="far fa-plus-square fa-fw"></i> Agregar</a></label>
                            <div class="input-group mb-0">
                                <div class="input-group-prepend" >
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-mobile-alt fa-fw"></i></span>
                                </div>
                                <input type="text" name="phone[]" class="form-control" placeholder="Telefono" aria-label="Telefono" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-save fa-fw"></i> Registrar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div style="display:none">
    <!-- muestra email -->
    <div id="new_form_email">
        <div class="row">
            <div class="col-md-12 mt-1">
                <div class="input-group mb-0">
                    <div class="input-group-prepend" >
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope-open-text fa-fw"></i></span>
                    </div>
                    <input type="email" name="email[]" class="form-control " placeholder="E-mail" aria-label="E-mail" aria-describedby="basic-addon1" required>
                    <div class="input-group-append">
                        <a href="#" class="btn btn-outline-danger del-email" onclick="del_email(this);">
                            <i class="far fa-times-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- muestra phone -->
    <div id="new_form_phone">
        <div class="row">
            <div class="col-md-12 mt-1">
                <div class="input-group mb-0">
                    <div class="input-group-prepend" >
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-mobile-alt fa-fw"></i></span>
                    </div>
                    <input type="text" name="phone[]" class="form-control " placeholder="Telefono" aria-label="Telefono" aria-describedby="basic-addon1" required>
                    <div class="input-group-append">
                        <a href="#" class="btn btn-outline-danger del-email" onclick="del_email(this);">
                            <i class="far fa-times-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>    
$(function(){
    $('.add-email').click(function(){
        $('#form_email').after($('#new_form_email').html());
    });
    $('.add-phone').click(function(){
        $('#form_phone').after($('#new_form_phone').html());
    });
});

function del_email(t){
    console.log('clic-del');
    $(t).parent().parent().parent().parent().remove();
}
</script>    
@endsection

 
