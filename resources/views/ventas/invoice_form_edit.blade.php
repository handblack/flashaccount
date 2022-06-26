@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('cinvoice.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-sm-right">
                                <h1 class="h4 mb-0 d-none d-md-inline-block">
                                    Comprobante de Venta
                                    &nbsp;
                                    <i class="fas fa-cash-register fa-fw"></i>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')
    <form action="{{ route('cinvoice.update',[$header->session]) }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name='session' value="{{ $header->session }}">
        {{ $header->bpartner->bpartnername }}
        <select name="sequence_id" id="">
            @foreach ($sequence as $item)
            <option value="{{ $item->id }}">{{ $item->serial }}</option>
            @endforeach
        </select>

        <input type="date" name="dateinvoiced" value="{{ $header->datetrx }}">
        <button type="submit"> Crear </button>

        <table>
            <thead></thead>
            <tbody>
                @foreach ($lines as $item)
                    <tr>
                        <td>{{ ($item->product_id) ? $item->product->productcode : '' }}</td>
                        <td>{{ $item->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
@endsection