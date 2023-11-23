<x-app-layout>
    <div class="relative overflow-x-auto w-3/4 mx-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Denominación
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Categoría
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
                            {{ truncar($articulo->denominacion) }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ dinero($articulo->precio) }}
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
    </div>
</x-app-layout>
