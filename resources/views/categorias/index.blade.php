<x-guest-layout>
    @foreach ($categorias as $categoria)
        {{ $categoria->nombre }}
    @endforeach
</x-guest-layout>
