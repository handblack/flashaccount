@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-box-open fa-fw"></i> Productos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Catalogos</li>
                    <li class="breadcrumb-item">Productos</li>
                </ol>
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
            <div class="card-title">

                <ul class="nav nav-tabs card-header-tabs" >
                    <li class="nav-item">
                        <span class="nav-link active">
                            @if($mode =='new')
                            <i class="far fa-edit fa-fw"></i>
                            @else
                            <i class="fas fa-edit fa-fw"></i>
                            @endif
                            <span class="d-sm-inline-block">
                                Producto [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICANDO' }}]</strong>
                            </span>                
                        </span>
                    </li>
                </ul>
            </div>
            <div class="card-tools ">
                    <ul class="nav">
                        <li>                        
                            <div class="card-tools pull-right">
                                
                                <a class="btn btn-sm btn-secondary" href="#" onclick="history.back()" title="Recargar">
                                    <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                                    <span class="d-none d-lg-inline-block">Todos</span>
                                </a>
                                <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                                    <i class="fas fa-redo" aria-hidden="true"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
            </div>
        </div>
         
        <div class="card-body">
            <div class="row">

                <div class="col-md-3">
                    <label class="mb-0">Codigo SKU</label>
                    <input type="text" name="productcode" value="{{ $row->productcode }}" class="form-control" placeholder="Codigo" required>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">UM</label>
                    <select name="um_id" id="" class="form-control" required>
                        @if ($mode == 'new')
                            <option value="" selected disabled>-- SELECCIONE --</option>
                        @endif
                        @foreach (auth()->user()->um() as $item)
                            <option value="{{ $item->id }}" {{ ($item->id == $row->um_id) ? 'selected' : '' }}>{{ $item->shortname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Familia</label>
                    <select name="family_id" id="" required class="form-control">
                        @if($mode == "new")
                            <option value="" disabled selected>--SELECCIONE--</option>
                        @endif
                        @foreach ($fam as $item)
                            <option value="{{ $item->id }}" {{ ($item->id == $row->family_id) ? 'selected' : '' }}>{{ $item->familyname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="mb-0">Linea</label>
                    <select name="line_id" id="" required class="form-control">
                        @if($mode == "new")
                            <option value="" disabled selected>--SELECCIONE--</option>
                        @endif
                        @foreach ($lin as $item)
                            <option value="{{ $item->id }}" {{ ($item->id == $row->line_id) ? 'selected' : '' }}>{{ $item->linename }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 mt-3">
                    <label class="mb-0">Descripcion</label>
                    <input type="text" name="productname" value="{{ $row->productname }}" placeholder="Descripcion" class="form-control">
                </div>
           
                <div class="col-md-4 mt-3">
                    <label class="mb-0">Nombre Corto</label>
                    <input type="text" name="shortname" value="{{ $row->shortname }}" placeholder="Nombre Corto" class="form-control">
                </div>
            </div>
            
            
            
        </div>
         
        <div class="card-footer pt-1">
            <div class="row">
                <div class="col-md-4  mt-2">
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
                <div class="col-md-4 mt-2">
                </div>
                <div class="col-md-4 mt-2">
                    <div class="float-right">
                        <a href="{{ route('product.index') }}" class="btn btn-secondary"> <i class="fas fa-times"></i> Cancelar</a>                
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ ($mode == 'new') ? 'Crear' : 'Modificar' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</form>    
    
@endsection