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
                <td class="align-top" width="120">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <dl>
                                    <dt>GENERADO</dt>
                                    <dt>PAGINA</dt>
                                </dl>
                            </td>
                            <td>
                                <dl>
                                    <dd>{{ date("d/m/Y H:i:s") }}</dd>
                                    <dd>1/1</dd>
                                </dl>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>
    

<main>
    <h3>INVENTARIO - {{ ($row->movetype == 'I') ? 'INGRESO' : 'SALIDA' }}</h3>
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="40%">
                <dl>
                    <dt>Almacen Origen</dt>
                    <dd>{{ $row->warehouse->warehousename }}</dd>
                </dl>
            </td>
       
            
            <td width="10%">
                <dl>
                    <dt>#CONTROL</dt>
                    <dd>{{ $row->serial.'-'.$row->documentno }}</dd>
                </dl>
            </td>
            <td width="10%">
                <dl>
                    <dt>FECHA</dt>
                    <dd>{{ $row->datetrx }}</dd>
                </dl>
            </td>
        </tr>
    </table>
    <br>
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr class="border-top border-bottom" style="background-color: #dcdcdc;">
                <th class="text-left">CODIGO</th>
                <th class="text-left">PRODUCTO</th>
                <th class="text-right">CANTIDAD</th>
                <td></td>
                <th class="text-right">PACKAGE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($row->lines as $item)
                <tr>
                    <td>{{ $item->product->productcode }}</td>
                    <td>{{ $item->product->productname }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td></td>
                    <td>{{ $item->package }}</td>
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
</main>

<footer>

</footer>
</body>
</html>
