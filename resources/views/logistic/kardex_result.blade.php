@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-print fa-fw"></i> Kardex de Productos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Logistica</li>
                    <li class="breadcrumb-item">Kardex de Productos</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('container')
<div class="card">
    <div class="card-body table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Almacen</th>
                    <th>Producto</th>
                    <th>Detalle</th>
                    <th>INGRESO</th>
                    <th>SALIDA</th>
                    <th>SALDO</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $saldo = 0
                @endphp
                @foreach ($result as $item)
                    @php
                        if($item->movetype == 'I'){
                            $saldo = $saldo + $item->quantity;
                        }else{
                            $saldo = $saldo - $item->quantity;
                        }
                        
                    @endphp
                    <tr>
                        <td>{{ $item->datetrx }}</td>
                        <td>{{ $item->warehouse_id }}</td>
                        <td>{{ $item->product_id }}</td>
                        <td>--</td>
                        @if($item->movetype=='I')
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td></td>
                        @else
                            <td></td>
                            <td class="text-right">{{ $item->quantity }}</td>
                        @endif
                        <td class="text-right">{{ $saldo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection