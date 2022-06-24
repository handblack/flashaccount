@extends('layouts.app')


@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('corder.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                    
                    <div class="btn-group">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"> 
                                <i class="fas fa-map-signs fa-fw"></i>
                                  Accion 
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateInvoice"><i class="far fa-copy fa-fw"></i> Copiar a Comprobante</a>
                                <a class="dropdown-item" href="#"><i class="far fa-copy fa-fw"></i> Copiar a Salida de Mercaderia</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="far fa-window-close fa-fw"></i> Cerrar documento</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="fas fa-print fa-fw"></i> Imprimir</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-download fa-fw"></i> Descargar PDF</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-envelope fa-fw"></i> Enviar por Email</a>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-sm btn-success" href="{{ route('corder.create') }}"
                            title="Marcar como página de inicio">
                            <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Nuevo OV</span>
                        </a>
                    </div>

                </div>

                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-sm-right">
                                <h1 class="h4 mb-0 d-none d-md-inline-block">
                                    Orden de Venta
                                    &nbsp;
                                    <i class="fas fa-edit fa-fw"></i>
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
    <div class="invoice p-3 mb-3">

        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fas fa-globe"></i>{{ auth()->user()->get_param('system.entity.bpartnername','EMPRESA_PRUEBA') }}
                    <small class="float-right">Date: 2/10/2014</small>
                </h4>
            </div>
        </div>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>{{ $header->bpartner->bpartnername }}</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong>John Doe</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (555) 539-1037<br>
                    Email: john.doe@example.com
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                <b>Invoice #007612</b><br>
                <br>
                <b>Order ID:</b> 4F3S8J<br>
                <b>Payment Due:</b> 2/22/2014<br>
                <b>Account:</b> 968-34567
            </div>

        </div>


        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Producto</th>
                            <th class="text-right">Cantidad</th>
                            <th class="text-right">Precio</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lines as $item)
                            <tr>
                                <td>{{ ($item->product_id) ? $item->product->productcode : '' }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="text-right">{{ $item->quantity }}</td>
                                <td>{{ $item->um->shortname }}</td>
                                <td class="text-right">{{ $item->priceunit }}</td>
                                <td class="text-right">{{ $item->amounttax }}</td>
                                <td class="text-right">{{ $item->amountgrand }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                        
                       
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row">

            <div class="col-6">
                <p class="lead">Payment Methods:</p>
             
                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                </p>
            </div>

            <div class="col-6">
                <p class="lead">Amount Due 2/22/2014</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Total:</th>
                                <td>{{ $header->currency->prefix }} {{ number_format($header->amountgrand,2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        <div class="row no-print">
            <div class="col-12">
                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                        class="fas fa-print"></i> Print</a>
                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                </button>
                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                </button>
            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="ModalCreateInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="{{ route('corder_copy_to_invoice') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="order_id" value="{{ $header->id }}">
            <input type="hidden" name="token" value="{{ $header->token }}">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Emitir Comprobante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select name="sequence_id" id="" class="form-control" required>
                    <option value="" selected disabled>-- SELECCIONE --</option>
                    @foreach ($sequence_invoice as $item)
                        <option value="{{ $item->id }}">{{ $item->serial }} - {{ $item->doctype->doctypename }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
</div>
</div>    
@endsection
