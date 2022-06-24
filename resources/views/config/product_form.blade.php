@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('product.index') }}" title="Recargar">
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
                            Productos
                            &nbsp;
                            <i class="fas fa-box-open fa-fw"></i>
    
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
                        <span class="d-none d-sm-inline-block">
                            Informacion del producto [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICANDO' }}]</strong>
                        </span>                
                    </span>
                     
                </li>
                
            </ul>
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
                <div class="col-md-12 mt-3">
                    <label class="mb-0">Descripcion</label>
                    <input type="text" name="productname" value="{{ $row->productname }}" placeholder="Descripcion" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 mt-3">
                    <label class="mb-0">Nombre Corto</label>
                    <input type="text" name="shortname" value="{{ $row->shortname }}" placeholder="Nombre Corto" class="form-control">
                </div>
            </div>
            
            
            
        </div>
        <div class="card-footer">
            <div class="btn-group">
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
            <div class="float-right">
                <a href="{{ route('product.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>                
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ ($mode == 'new') ? 'Crear' : 'Modificar' }}</button>
            </div>
        </div>
    </div>
    
</form>    
    
@endsection