    @auth
        <x-app-layout>
            <h2>Shop</h2>
            @include('products.index')
        </x-app-layout>
    @else
        <x-guest-layout>
            <h2>Shop</h2>
            @include('products.index')
        </x-guest-layout>
    @endauth
