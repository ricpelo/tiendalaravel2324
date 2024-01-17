<x-app-layout>
    <div class="relative overflow-x-auto w-auto mx-8 mshadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Imagen
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('articulos.index', ['order' => 'denominacion', 'order_dir' => order_dir($order == 'denominacion', $order_dir)]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Denominación {{ order_dir_arrow($order == 'denominacion', $order_dir) }}
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('articulos.index', ['order' => 'precio', 'order_dir' => order_dir($order == 'precio', $order_dir)]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Precio {{ order_dir_arrow($order == 'precio', $order_dir) }}
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio (I. I.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('articulos.index', ['order' => 'por', 'order_dir' => order_dir($order == 'por', $order_dir)]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            IVA {{ order_dir_arrow($order == 'por', $order_dir) }}
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('articulos.index', ['order' => 'nombre', 'order_dir' => order_dir($order == 'nombre', $order_dir)]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Categoría {{ order_dir_arrow($order == 'nombre', $order_dir) }}
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3" colspan="2">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $articulo)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if ($articulo->existeImagen())
                                <img src="{{ asset($articulo->imagen_url) }}" />
                            @endif
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('articulos.show', ['articulo' => $articulo]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                {{ truncar($articulo->denominacion) }}
                            </a>
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ dinero($articulo->precio) }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ dinero($articulo->precio_ii) }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" title="{{ $articulo->iva->tipo }}">
                            {{ $articulo->iva->por . " %" }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('categorias.edit', ['categoria' => $articulo->categoria]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                {{ $articulo->categoria->nombre }}
                            </a>
                        </th>
                        <td class="px-6 py-4">
                            <a href="{{ route('articulos.edit', ['articulo' => $articulo]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                <x-primary-button>
                                    Editar
                                </x-primary-button>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('articulos.cambiar_imagen', ['articulo' => $articulo]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                <x-primary-button>
                                    Cambiar imagen
                                </x-primary-button>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('articulos.destroy', ['articulo' => $articulo]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-primary-button class="bg-red-500">
                                    Borrar
                                </x-primary-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('articulos.create') }}" class="flex justify-center mt-4 mb-4">
            <x-primary-button class="bg-green-500">Insertar un nuevo artículo</x-primary-button>
        </form>
        {{ $articulos->withQueryString()->links() }}
    </div>
</x-app-layout>
