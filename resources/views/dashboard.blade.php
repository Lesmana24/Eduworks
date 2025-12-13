@section('title', 'Dashboard Admin')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Login Success --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            {{-- GRID CARDS (Ganti row/col bootstrap dengan Grid Tailwind) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Card 1: Products --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Total Products</h3>
                        <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">120</p>
                        <p class="text-l font-bold text-indigo-600 dark:text-indigo-400">Jumlah Product Yang Tersedia</p>
                        <a href="{{ route('products-admin') }}" class="inline-block mt-4 text-sm text-indigo-600 hover:text-indigo-900">View Details &rarr;</a>
                    </div>
                </div>

                {{-- Card 2: Categories --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Total Categories</h3>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">8</p>
                        <p class="text-l font-bold text-green-600 dark:text-green-400">Jumlah Category Yang Tersedia</p>
                        <a href="{{ route('categories-admin') }}" class="inline-block mt-4 text-sm text-green-600 hover:text-green-900">View Details &rarr;</a>
                    </div>
                </div>

                {{-- Card 3: Users/Settings --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Pengguna</h3>
                        <p class="text-3xl font-bold text-gray-600 dark:text-gray-400">100</p>
                        <p class="text-l font-bold text-gray-600 dark:text-gray-400">Jumlah Pengguna</p>
                        <a href="#" class="inline-block mt-4 text-sm text-gray-600 hover:text-gray-900">View Details &rarr;</a>

            </div>
        </div>
    </div>
</x-app-layout>
