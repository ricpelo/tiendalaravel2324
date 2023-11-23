<x-app-layout>
    <div class="flex">
        <div
            class="p-2 flex-1 grid grid-cols-3 gap-4 justify-center justify-items-center">
            @foreach ($articulos as $articulo)
                <div
                    class="p-6 max-w-xs min-w-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <h5
                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $articulo->denominacion }}
                        </h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{ $articulo->denominacion }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
