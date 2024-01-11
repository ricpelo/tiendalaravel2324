<x-app-layout>
    <div class="relative overflow-x-auto mx-auto w-2/4 mshadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Cliente
                    </th>
                    <th scope="col" class="text-right px-6 py-3">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-3" colspan="2">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facturas as $factura)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('facturas.show', ['factura' => $factura]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                {{ fecha($factura->created_at) }}
                            </a>
                        </th>
                        <th scope="row" class="text-right px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $factura->user->name }}
                        </th>
                        <th scope="row" class="text-right px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ dinero($factura->total) }}
                        </th>

                        <td class="px-6 py-4">
                            {{-- <form action="{{ route('articulos.destroy', ['articulo' => $articulo]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-primary-button class="bg-red-500">
                                    Borrar
                                </x-primary-button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
