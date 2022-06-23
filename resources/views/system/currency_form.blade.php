@extends('layouts.app')


@section('container')
<form class="form-horizontal" action="{{ $url }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="{{ ($mode == 'edit') ? 'PUT' : '' }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">        
    <div class="card card-primary card-outline">
        <div class="card-header" style="background-color: rgba(0,0,0,.03);">
            <h3 class="card-title">Informacion  <strong>[@if($mode=='new') NUEVO @else MODIFICAR @endif]</strong></h3>
        </div>
        <div class="card-body">



            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Divisa [Denominacion]</label>
                <div class="col-sm-9">
                    <input name="currencyname" class="form-control" value="{{ old('currencyname',$row->currencyname) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Codigo [ISO4217]</label>
                <div class="col-sm-5">
                    <input name="currencyiso" class="form-control" value="{{ old('currencyiso',$row->currencyiso) }}" maxlength="3">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Prefijo</label>
                <div class="col-sm-2">
                    <input name="prefix" class="form-control" value="{{ old('prefix',$row->prefix) }}" maxlength="5">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Sufijo</label>
                <div class="col-sm-2">
                    <input name="suffix" class="form-control" value="{{ old('suffix',$row->suffix) }}" maxlength="5">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Estado</label>
                <div class="col-sm-5">
                    <select name="isactive" id="" class="form-control">
                        <option value="Y" {{ ($row->isactive == 'Y') ? 'selected' :'' }}>ACTIVO</option>
                        <option value="N" {{ ($row->isactive == 'N') ? 'selected' :'' }}>DESACTIVADO</option>
                    </select>
                </div>
            </div>


            <!-- SEGUNDO -->
        </div>
        <div class="card-footer">
            <div class="float-right">
                <a href="{{ route('currency.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</form>
@endsection
 