@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('bpartner.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
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
<form class="form-horizontal" action="{{ $url }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="{{ ($mode == 'edit') ? 'PUT' : '' }}">
    <input type="hidden" name="token" value="{{ $row->token }}">
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" >
            <li class="nav-item">
                <span class="nav-link active">
                    @if($mode =='new')
                        <i class="far fa-edit fa-fw"></i>
                    @else
                        <i class="fas fa-edit fa-fw"></i>
                    @endif
                    <span class="d-sm-inline-block">
                        Socio de Negocio [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICANDO' }}]</strong>
                    </span>                
                </span>
                 
            </li>
            
        </ul>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <label class="mb-0">Tipo de Registro</label>
                <div class="input-group mb-0">                    
                    <select name="typeperson" id="typeperson" class="form-control console" required="" style="width:80px;" {{ ($mode == 'edit') ? 'disabled' : '' }}>
                        @if($mode=='new')
                        <option value="" selected="" disabled="">----</option>
                        @endif
                        <option value="C" {{ ($row->typeperson == 'C') ? 'selected' : '' }}>CLIENTE</option>
                        <option value="P" {{ ($row->typeperson == 'P') ? 'selected' : '' }}>PROVEEDOR</option>
                    </select>
                </div>                
            </div>
            <div class="col-md-3 pt-2">
                <label class="mb-0">Tipo de Persona</label>
                <div class="input-group mb-0">                    
                    <select name="legalperson" id="legalperson" class="form-control console" required="" style="width:80px;">
                        @if($mode=='new')
                        <option value="" selected="" disabled="">----</option>
                        @endif
                        <option value="N" {{ ($row->legalperson == 'N') ? 'selected' : '' }}>PERSONA NATURAL</option>
                        <option value="J" {{ ($row->legalperson == 'J') ? 'selected' : '' }}>PERSONA JURIDICA</option>
                    </select>
                </div>                
            </div>
            <div class="col-md-3 pt-2">
                <label class="mb-0">Tipo y Nro de Documento @if($mode=='new') <small class="badge badge-secondary"><i class="far fa-clock"></i> <span  class="font-weight-normal" id="contador">0</span></small> @endif </label>
                <div class="input-group mb-0">
                    <div class="input-group-prepend pr-1">
                        <select name="doctype_id" class="form-control console" required="" style="width:80px;">
                            @if($mode=='new')
                        <option value="" selected="" disabled="">----</option>
                        @endif
                            @foreach ($doctype as $item)
                                <option value="{{ $item->id  }}" {{ ($item->id == $row->doctype_id) ? 'selected' : '' }}>{{ $item->shortname }} - {{ $item->doctypename }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="documentno" id="documentno" value="{{ $row->documentno }}" class="form-control console" placeholder="" aria-describedby="basic-addon1" maxlength="11" required>
                </div>
                
            </div>
            <div class="col-md-3 pt-2">
                <label class="mb-0">Codigo SN</label>
                @if($mode=='new')
                    <input type="text" name="bpartnercode" id="bpartnercode" class="form-control" value="{{ $row->bpartnercode }}" placeholder="Codigo" maxlength="12" minlength="12" {{ ($mode == 'edit') ? 'disabled' : '' }}>
                @else
                    <span class="form-control" style="background-color: #e9ecef;opacity: 1;">{{ $row->bpartnercode }}</span>
                @endif
            </div>
        </div>
        <div class="row" id="jur">
            <div class="col-md-12 pt-2">
                <label class="mb-0">Razon Social / Denominacion</label>
                <input type="text" name="bpartnername" class="form-control" value="{{ $row->bpartnername }}" placeholder="Descripcion" maxlength="150">
            </div>
        </div>
        <div class="row" id="nat">
            <div class="col-md-4 pt-2">
                <label class="mb-0">Apellido Parterno</label>
                <input type="text" name="lastname" class="form-control" value="{{ $row->lastname }}" placeholder="" maxlength="60">
            </div>
            <div class="col-md-4 pt-2">
                <label class="mb-0">Apellido Materno</label>
                <input type="text" name="firstname" class="form-control" value="{{ $row->firstname }}" placeholder="" maxlength="60">
            </div>
            <div class="col-md-4 pt-2">
                <label class="mb-0">Pre-Nombres</label>
                <input type="text" name="prename" class="form-control" value="{{ $row->prename }}" placeholder="" maxlength="60">
            </div>
        </div>
    </div>
    <div class="card-footer pt-1">
        <div class="row">
            <div class="col-md-6  mt-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Estado</span>
                    </div>
                    <select name="isactive" id="isactive" class="form-control">
                        <option value="Y" @if ($row->isactive == 'Y') selected @endif>ACTIVO</option>
                        <option value="N" @if ($row->isactive == 'N') selected @endif>DESACTIVADO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="float-right">
                    <a href="{{ route('bpartner.index') }}" class="btn btn-secondary"> <i class="fas fa-times"></i> Cancelar</a>                
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ ($mode == 'new') ? 'Crear' : 'Modificar' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>    
    
@endsection

@section('script')
<script>
$(function(){
    $("#documentno").on('keyup', function(event) {
        var currentString = $("#documentno").val()
        $('#contador').html(currentString.length);
        let code = '000000000000' + $("#documentno").val();
        @if($mode=='new')
        $('#bpartnercode').val($('#typeperson').val() + code.substr(code.length - 11));        
        @endif
    });
    $('#legalperson').on('change',function(){
        let lp = $('#legalperson').val()
        if(lp == 'J'){
            $('#jur').show();
            $('#nat').hide();
        }else{
            $('#jur').hide();
            $('#nat').show();
        }
    });
    $('#legalperson').trigger("change");
    
});
</script>
@endsection