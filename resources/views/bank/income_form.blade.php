@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('bincome.index') }}" title="Recargar">
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
                            Banco / Ingresos 
                            &nbsp;<i class="fab fa-cc-visa fa-fw"></i>

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
            <div class="card-title">{{ $row->bpartner->bpartnername }}</div>
        </div>
        <div class="card-body pt-2 pb-2">
            <div class="row">
                <div class="col-md-2">
                    <label class="mb-0">Medio de PAGO</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Identificador del Equipo" value="" required="">
                </div>
                <div class="col-md-6">
                    <label class="mb-0">Detalle</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Identificador del Equipo" value="" required="">
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Estado</label>
                    <select name="isactive" id="isactive" class="form-control">
                        <option value="Y">ACTIVO</option>
                        <option value="N">DESACTIVADO</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0 border-top">
            <table class="table table-hover text-nowrap table-sm  mb-0">
                <thead>
                    <tr style="background-color:#dcdcdc;">
                        <th>check</th>
                        <th>Fecha</th>
                        <th>Documento</th>
                        <th>Moneda</th>
                        <th class="text-right">Total</th>
                        <th class="text-right">Abierto</th>
                        <th class="text-right">Aplicar</th>
                        <th class="text-right">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($open as $line)
                        <tr id="" class="bg-light">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </td>
                            <td>{{ $line->dateinvoiced }}</td>
                            <td>{{ $line->id }}</td>
                            <td>moneda</td>
                            <td width="120" class="text-right">total</td>
                            <td width="120" class="text-right">Abierto</td>
                            <td width="140">
                                <input type="text" class="text-right form-control form-control-sm" value="0.00">
                            </td>
                            <td class="text-right">
                                saldo
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay documentos con importes abiertos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection