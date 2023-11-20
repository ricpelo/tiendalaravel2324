<x-guest-layout>
    <form method="POST" action="{{ route('articulos.store') }}">
        @csrf

        <!-- Nombre -->
        <div>
            <x-input-label for="denominacion" :value="'Denominación del artículo'" />
            <x-text-input id="denominacion" class="block mt-1 w-full" type="text" name="denominacion" :value="old('denominacion')" required autofocus autocomplete="denominacion" />
            <x-input-error :messages="$errors->get('denominacion')" class="mt-2" />
        </div>

        <!-- Precio -->
        <div class="mt-4">
            <x-input-label for="precio" :value="'Precio del artículo'" />
            <x-text-input id="precio" class="block mt-1 w-full" type="text" name="precio" :value="old('precio')" required autofocus autocomplete="precio" />
            <x-input-error :messages="$errors->get('precio')" class="mt-2" />
        </div>

        <!-- Categoría -->
        <div class="mt-4">
            <x-input-label for="categoria_id" :value="'Categoría del artículo'" />
            <x-text-input id="categoria_id" class="block mt-1 w-full" type="text" name="categoria_id" :value="old('categoria_id')" required autofocus autocomplete="categoria_id" />
            <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('articulos.index') }}">
                <x-secondary-button class="ms-4">
                    Volver
                </x-primary-button>
            </a>
            <x-primary-button class="ms-4">
                Insertar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
