@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('warehouse.index') }}" title="Recargar">
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
                            Cuentas de Banco
                            &nbsp;
                            <i class="fas fa-piggy-bank fa-fw"></i>

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
            <ul class="nav nav-tabs card-header-tabs" >
                <li class="nav-item">
                    <span class="nav-link active">
                        @if($mode =='new')
                            <i class="far fa-edit fa-fw"></i>
                        @else
                            <i class="fas fa-edit fa-fw"></i>
                        @endif
                        <span class="d-none d-sm-inline-block">
                            Cuenta de Banco [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICANDO' }}]</strong>
                        </span>                
                    </span>
                     
                </li>
                
            </ul>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="mb-0">Entidad Bancaria</label>
                    <select name="bank_id" id="" class="form-control">
                        @if ($mode == 'new')
                            <option value="" selected disabled>-- SELECCIONA --</option>
                        @endif
                        @foreach ($bank as $item)
                            <option value="{{ $item->id }}" {{ ($item->id == $row->bank_id) ? 'selected' : '' }}>{{ $item->identity }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="mb-0">Nro de Cuenta</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Identificador del Equipo" value="" required="">
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Moneda</label>
                    <select name="currency_id" id="isactive" class="form-control">
                        @if ($mode == 'new')
                            <option value="" selected disabled>-- SELECCIONA --</option>
                        @endif
                        @foreach (auth()->user()->currency() as $item)
                            <option value="{{ $item->id }}" {{ ($item->id == $row->currency_id) ? 'selected' : '' }}>{{ $item->currencyname }}</option>
                        @endforeach
                    </select>
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
                <a href="{{ route('bankaccount.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>

    </div>
@endsection
