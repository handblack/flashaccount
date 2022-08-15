<html>
<head>
    <link rel="stylesheet" href="{{ public_path('assets/pdf.css') }}">
    <style>
        body {
            margin: 1.5cm 0.2cm 2cm 0.2cm;
            /* margin: 3cm 2cm 2cm; */
           /* 2cm arriba, 3px derecha, 30px abajo, 5px izquierda */
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.5cm;
            color: #343434;
            padding:4;                     
            
        }

        footer {
            /*border:1px solid #dcdcdc;*/
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            /*background-color: #2a0927;*/
            color: #343434;
            text-align: center;
            line-height: 35px;
        }
    </style>
</head>
<body>
<header>
    <!-- logo empresa -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr style="border-bottom: 1px solid #dcdcdc;">
            <td>
                <dl>
                    <dd><strong>{{ auth()->user()->get_param('system.bpartner.name','EMPRESA_RAZON_SOCIAL') }}</strong></dd>
                    <dd>{{ auth()->user()->get_param('system.bpartner.address','AV REDUCTORES 1234 - URB CHACARILLAS') }}</dd>
                    <dd>{{ auth()->user()->get_param('system.bpartner.address2','LIMA - LIMA') }}</dd>                    
                </dl>
            </td>
            <td class="align-top">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td>Generado:</td>
                        <td>{{ date("d/m/Y H:i:s") }}</td>
                    </tr>
                    <tr>
                        <td>Usuario:</td>
                        <td>{{ auth()->user()->name }}</td>
                    </tr>
                    <tr>
                        <td>PAGINA:</td>
                        <td>1/1</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</header>

<main>     
    <h3>PARTE INGRESO</h3>
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="42%" class="align-top">
                <dl>
                    <dt>Proveedor</dt>
                    <dd>{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</dd>
                    <dd>
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->address : '--' }}
                    </dd>
                    <dd>
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->state->statename : '' }} - 
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->county->countyname : '' }} - 
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->city->cityname : '' }}
                    </dd>
                    <dd>
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->country->countryname : '' }}
                    </dd>
                    <dd>{{ $row->glosa }}</dd>
                </dl>
            </td>
            <td width="33%" class="align-top">
                <dl>
                    <dt>Almacen INGRESO</dt>
                    <dd>{{ $row->warehouse->warehousename }}</dd>
                    <dt>Motivo</dt>
                    <dd>{{ $row->reason->reasonname }}</dd>
                </dl>
            </td>
            <td width="25%" class="align-top">
                <table>
                    <tr>
                        <td><strong>#NRO</strong></td>
                        <td>{{ $row->serial.'-'.$row->documentno }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha</strong></td>
                        <td>{{ $row->datetrx }}</td>
                    </tr>
                    <tr>
                        <td><strong>Orden</strong></td>
                        <td>{{ ($row->order) ? $row->order->serial.'-'.$row->order->documentno : '--' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%">
        <thead>
            <tr class="border-top border-bottom">
                <th class="text-left">CODIGO</th>
                <th class="text-left">PRODUCTO</th>
                <th class="text-right">CANTIDAD</th>
                <th class="text-right">PACKAGE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($row->lines as $item)
                <tr>
                    <td>{{ $item->product->productcode }}</td>
                    <td>{{ $item->product->productname }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ $item->package }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="border-top">
                <td colspan="2">{{ count($row->lines) }} - registros</td>
                <td class="text-right">
                    {{ number_format($row->lines->sum('quantity'),env('DECILAM_QUANTITY',5)) }}
                </td>
                <td class="text-right">
                    {{ number_format($row->lines->sum('package'),env('DECILAM_QUANTITY',5)) }}
                </td>
            </tr>
        </tfoot>
    </table>
    <br>
    <br>
    <table width="100%" class="border">
        <tr>
            <td>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </td>
            <td width="25%" class="border text-center align-bottom">
                ALMACEN
            </td>
            <td width="25%" class="border text-center align-bottom">
                RECIBIDO POR
            </td>
        </tr>
    </table>
</main>

<footer>
    
</footer>
</body>
</html>
