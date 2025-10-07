<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white tracking-wide drop-shadow-sm">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-md shadow-xl sm:rounded-3xl p-6 ring-1 ring-white/10">
                <div class="text-gray-100 text-lg">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
