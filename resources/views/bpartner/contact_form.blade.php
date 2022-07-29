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
<form class="" action="{{ ($mode == 'edit') ? route('bpartnercontact.update',$row->token) : route('bpartneraddress.store') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="{{ ($mode == 'edit') ? 'PUT' : '' }}">
    <input type="hidden" name="master" value="{{ $row->token }}">
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
            {{ $header->bpartnercode }} - {{ $header->bpartnername }}
        </div>
 
        <div class="card-body pt-1 bg-light">
             
            <div class="row">
                <div class="col-md-6 mt-2">
                    <label class="mb-0">Contacto </label>
                    <input type="text" name="contactname" value="{{ $row->contactname }}" class="form-control" maxlength="100">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="mb-0">Cargo / Referencia</label>
                    <input type="text" name="workplace" value="{{ $row->workplace }}" class="form-control" maxlength="100">
                </div>
            </div>
        </div>
        <div class="card-body pt-1">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="mb-0">Email</label>
                            <label class="float-right mb-0"><a href="#" class="font-weight-light add-email"><i class="far fa-plus-square fa-fw"></i> Agregar</a></label>
                        </div>
                    </div>
                    <div class="row" id="form_email"></div>
                    <!-- EMAIL -->
                    @foreach ($row->email as $item)
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend" >
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope-open-text fa-fw"></i></span>
                                    </div>
                                    <input type="email" name="email[]" value="{{ $item }}" class="form-control " placeholder="E-mail" aria-label="E-mail" aria-describedby="basic-addon1" required>
                                    <div class="input-group-append">
                                        <a href="#" class="btn btn-outline-danger del-email" onclick="del_email(this);">
                                            <i class="far fa-times-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-6">  
                    <div class="row">
                        <div class="col-md-12">
                            <label class="mb-0">Telefono</label>
                            <label class="float-right mb-0"><a href="#" class="font-weight-light add-phone"><i class="far fa-plus-square fa-fw"></i> Agregar</a></label>
                        </div>
                    </div>
                    <div class="row" id="form_phone"></div>
                    <!-- TELEFONO -->
                    @foreach ($row->phone as $item)
                        <div class="row">                        
                            <div class="col-md-12 mt-1">
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend" >
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-mobile-alt fa-fw"></i></span>
                                    </div>
                                    <input type="text" 
                                        required 
                                        name="phone[]" 
                                        value="{{ $item }}" 
                                        class="form-control console" 
                                        placeholder="Telefono" aria-label="Telefono" 
                                        aria-describedby="basic-addon1" 
                                        data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" 
                                        data-mask="" inputmode="text">
                                    
                                    <div class="input-group-append">
                                        <a href="#" class="btn btn-outline-danger del-email" onclick="del_email(this);">
                                            <i class="far fa-times-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                  
                </div>
            </div>
            
            

           

      
           
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col text-center"></div>
                <div class="col text-right">
                    <a href="{{ route('bpartnercontact.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-undo fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Cancelar</span>
                    </a>
                    <button class="btn btn-sm btn-primary" type="submit">
                        <i class="fas fa-save fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Guardar</span>
                    </button>
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
