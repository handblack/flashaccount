@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('sequence.index') }}" title="Recargar">
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
                            Secuenciadores (Series)
                            &nbsp;
                            <i class="fas fa-hashtag fa-fw"></i>

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
    <ul class="nav nav-tabs d-print-none" id="mainTabs" role="tablist">
        <li class="nav-item active">
            <a href="#" class="nav-link active" data-toggle="tab" role="tab" aria-controls="ListAlmacen">                
                @if($mode =='new')
                    <i class="far fa-edit fa-fw"></i>
                @else
                    <i class="fas fa-edit fa-fw"></i>
                @endif
                <span class="d-none d-sm-inline-block">Serie [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICANDO' }}]</strong></span>                
            </a>
        </li>        
    </ul>
    <div class="rounded-bottom border-left border-right border-bottom bg-white">
        <div class="row p-3">
            <div class="col-md-3 mb-2">
                <label class="mb-0">Tipo de Documento</label>
                <select name="doctype_id" id="" class="form-control" required>
                    @if ($mode=='new')
                        <option value="" selected disabled>-- SELECCIONE --</option>
                    @endif
                    @foreach ($doctype as $item)
                        <option value="{{ $item->id }}" {{ ($item->id == $row->doctype_id) ? 'selected' : '' }}>{{ $item->doctypename }}</option>
                    @endforeach
                </select>                
            </div>
            <div class="col-md-2 mb-2">
                <label class="mb-0">Serie</label>
                <input type="text" class="form-control" name="serial" value="{{ $row->serial }}" maxlength="4" required>               
            </div>
            <div class="col-md-2 mb-2">
                <label class="mb-0">Ultimo</label>
                <input type="number" class="form-control text-right" name="lastnumber" value="{{ $row->lastnumber }}" maxlength="10" required>               
            </div>
            <div class="col-md-2 mb-2">
                <label class="mb-0">Tag</label>
                <input type="text" class="form-control" name="tag" value="{{ $row->tag }}" maxlength="10" required>               
            </div>
            <div class="col-md-3 mb-2">
                <label class="mb-0">Almacen</label>
                <select name="warehouse_id" id="" class="form-control" required>
                    @if ($mode=='new')
                        <option value="" selected disabled>-- SELECCIONE --</option>
                    @endif
                    @foreach ($warehouse as $item)
                        <option value="{{ $item->id }}" {{ ($item->id == $row->warehouse_id) ? 'selected' : '' }}>{{ $item->warehousename }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="card-footer">
            <div class="btn-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Estado</span>
                    </div>
                    <select name="isactive" id="isactive" class="form-control">
                        <option value="Y" @if($row->isactive=='Y') selected @endif>ACTIVO</option>
                        <option value="N" @if($row->isactive=='N') selected @endif>DESACTIVADO</option>
                    </select>
                </div>                
            </div>
            <div class="float-right">
                <a href="{{ route('sequence.index') }}" class="btn btn-secondary"> <i class="fas fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</form>
@endsection