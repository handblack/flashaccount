<html>
<head>
    <link rel="stylesheet" href="{{ public_path('assets/pdf.css') }}">
    <style>
        body {
            margin: 2cm 0.2cm 2cm 0.2cm;
            /* margin: 3cm 2cm 2cm; */
           /* 10px arriba, 3px derecha, 30px abajo, 5px izquierda */
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            /*background-color: #2a0927;*/
            color: #343434;
            text-align: center;
            line-height: 30px;
        }

        footer {
            border:1px solid #dcdcdc;
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
<header style="border:1px solid black">
    <!-- logo empresa -->
    <table width="100%">
        <tr>
            <td>
                {{ auth()->user()->get_param('system.bpartner.name') }}
                {{ auth()->user()->get_param('system.bpartner.address') }}
                {{ auth()->user()->get_param('system.bpartner.phome') }}
                {{ auth()->user()->get_param('system.bpartner.email') }}
                {{ auth()->user()->get_param('system.bpartner.web') }}
            </td>
        </tr>
    </table>
</header>

<main>
     
    <h3>PARTE INGRESO</h3>
    <table width="100%">
        <tr>
            <td width="42%">
                <dl>
                    <dt>Proveedor</dt>
                    <dd>{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</dd>
                    <dd>
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->address : '_FALTA_ESPECIFICAR_DIRECCION_' }}
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
            <td width="33%">
                <dl>
                    <dt>Almacen INGRESO</dt>
                    <dd>{{ $row->warehouse->warehousename }}</dd>
                    <dd>{{ $row->warehouse->address->address }}</dd>                        
                    <dt>Motivo</dt>
                    <dd>{{ $row->reason->reasonname }}</dd>
                </dl>
            </td>
            <td width="25%"></td>
        </tr>
    </table>
    <table width="100%">
        <thead>
            <tr>
                <th>CODIGO</th>
                <th>PRODUCTO</th>
                <th>CANTIDAD</th>
                <th>PACKAGE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($row->lines as $item)
                <tr>
                    <td>{{ $item->product->productcode }}</td>
                    <td>{{ $item->product->productname }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->package }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>

<footer>
    <h1></h1>
</footer>
</body>
</html>
