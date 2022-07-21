<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
            </tr>
        </thead>
        <tbody>
            @forelse($result as $line)
                <tr>
                    <td>{{ $line->id }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay informacion disponible</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>