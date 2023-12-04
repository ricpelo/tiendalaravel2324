<x-app-layout>
    <div class="container mx-auto">
        <div class="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
            <table class="mx-auto text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <th scope="col" class="py-3 px-6">Descripción</th>
                    <th scope="col" class="py-3 px-6">Cantidad</th>
                    <th scope="col" class="py-3 px-6">Precio</th>
                    <th scope="col" class="py-3 px-6">Importe</th>
                </thead>
                <tbody>
                    @php
                    $total = 0
                    @endphp

                    @foreach ($carrito->getLineas() as $id => $linea)
                        @php
                        $articulo = $linea->getArticulo();
                        $cantidad = $linea->getCantidad();
                        $precio = $articulo->precio;
                        $importe = $cantidad * $precio;
                        $total += $importe;
                        @endphp
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">{{ $articulo->denominacion }}</td>
                            <td class="py-4 px-6 text-center">{{ $cantidad }}</td>
                            <td class="py-4 px-6 text-center">
                                {{ dinero($precio) }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ dinero($importe) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <td colspan="2"></td>
                    <td class="text-center font-semibold">TOTAL:</td>
                    <td class="text-center font-semibold">{{ dinero($total) }}</td>
                </tfoot>
            </table>
            <form action="{{ route('realizar_compra') }}" method="POST" class="mx-auto flex mt-4">
                @csrf
                <button type="submit" href="" class="mx-auto focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">Realizar pedido</button>
            </form>
        </div>
    </div>
</x-app-layout>
