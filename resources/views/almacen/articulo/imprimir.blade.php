<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table{
            width: 100%;
            border: 1px solid gray;
        }

        tr, th, td{
            border: 1px solid gray;
        }
    </style>
</head>
<body>
    <div>
        <h1>Tabla</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Código</th>
                <th>Img código</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articulos as $a)
                <tr>    
                    <td>{{ $a->idarticulo }}</td>
                    <td>{{ $a->nombre }}</td>
                    <td>{{ $a->categoria }}</td>
                    <td>{{ $a->stock }}</td>
                    <td>{{ $a->estado }}</td>
                    <td>{{ $a->codigo }}</td>
                    <td>
                        <div>
                            {!! DNS1D::getBarcodeHTML($a->codigo, 'C128') !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>