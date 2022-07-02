<html>
<head>
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
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 30px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 35px;
        }
    </style>
</head>
<body>
<header>
    <h1>logo empresa</h1>
</header>

<main>
inventory
    <table>
        <thead>
            <tr>
                <th>CODIGO</th>
                <th>PRODUCTO</th>
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
    <h1>miasoftware.net</h1>
</footer>
</body>
</html>
