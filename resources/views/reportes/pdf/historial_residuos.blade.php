<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Residuos</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 8px; font-size: 12px; }
    </style>
</head>
<body>
    <h2>Historial de Residuos</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Peso (kg)</th>
                <th>Tipo</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($residuos as $residuo)
            <tr>
                <td>{{ $residuo->nombre }}</td>
                <td>{{ $residuo->categoria->nombre ?? '-' }}</td>
                <td>{{ $residuo->peso }}</td>
                <td>
                    @if($residuo->peligroso) Peligroso @endif
                    @if($residuo->inflamable) Inflamable @endif
                    @if($residuo->biodegradable) Biodegradable @endif
                </td>
                <td>{{ $residuo->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
