<html>
<head>
    <link rel="stylesheet" href="{{ public_path('assets/pdf.css') }}">
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 3cm 2cm 2cm;
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
<header>
    <!-- logo empresa -->
</header>

<main>
    <div>
        {{ $row->bpartner->bpartnername }}
        <br>{{ $row->bpartner->bpartnercode }}
        <br>{{ $row->warehouse->warehousename }}
    </div>
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
