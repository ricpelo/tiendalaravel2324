<x-app-layout>
    <div class="w-1/2 mx-auto">
        <form method="POST"
            action="{{ route('articulos.update', ['articulo' => $articulo]) }}">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <x-input-label for="denominacion" :value="'Denominación del artículo'" />
                <x-text-input id="denominacion" class="block mt-1 w-full"
                    type="text" name="denominacion" :value="old('denominacion', $articulo->denominacion)" required
                    autofocus autocomplete="denominacion" />
                <x-input-error :messages="$errors->get('denominacion')" class="mt-2" />
            </div>

            <!-- Precio -->
            <div class="mt-4">
                <x-input-label for="precio" :value="'Precio del artículo'" />
                <x-text-input id="precio" class="block mt-1 w-full"
                    type="text" name="precio" :value="old('precio', $articulo->precio)" required
                    autofocus autocomplete="precio" />
                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
            </div>

            <!-- Categoría -->
            <div class="mt-4">
                <x-input-label for="categoria_id" :value="'Categoría del artículo'" />
                <select id="categoria_id"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                    name="categoria_id" required>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ $categoria->id == $articulo->categoria_id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('articulos.index') }}">
                    <x-secondary-button class="ms-4">
                        Volver
                        </x-primary-button>
                </a>
                <x-primary-button class="ms-4">
                    Editar
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
