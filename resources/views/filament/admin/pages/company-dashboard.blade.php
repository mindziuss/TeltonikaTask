@if(!is_null($company))
<x-filament::page>
    <!-- Logout -->
    <div class="flex justify-end mb-6">
        <form method="POST" action="{{ route('company.logout') }}">
            @csrf
            <x-filament::button color="danger" type="submit">
                Logout
            </x-filament::button>
        </form>
    </div>

    <!-- Company Info Table -->
    <x-filament::card>
        <h2 class="text-xl font-bold mb-4">Company Info</h2>
        <livewire:company-table :company="$company" />
    </x-filament::card>

    <!-- Employees Table -->
    <x-filament::card class="mt-6">
        <h2 class="text-xl font-bold mb-4">Employees</h2>
        <livewire:employees-table :company="$company" />
    </x-filament::card>
</x-filament::page>
@endif
