<p>Se ha generado el siguiente pedido:</p>

<p>Factura con fecha {{ $factura->created_at }} </p>

<table>
    <thead>
        <th>Denominación</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Importe</th>
    </thead>
    <tbody>
        @foreach ($factura->articulos as $articulo)
            <tr>
                <td>{{ $articulo->denominacion }}</td>
                <td>{{ $articulo->pivot->cantidad }}</td>
                <td>{{ $articulo->precio }}</td>
                <td>{{ $articulo->pivot->cantidad * $articulo->precio }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
