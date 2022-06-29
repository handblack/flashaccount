<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td><b>Show Name</b></td>
                <td><b>Series</b></td>
                <td><b>Lead Actor</b></td>
            </tr>
        </thead>
        <tbody>
            @forelse ($result as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->datetrx }}</td>
                    <td>{{ number_format($item->amount,env('DECIMAL_AMOUNT')) }}</td>
                    <td>{{ number_format($item->amountopen,env('DECIMAL_AMOUNT')) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay informacion</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
