<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-3">
        <x-filament::card>
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium">Total Invoices</h3>
                    <p class="text-3xl font-bold">{{ \App\Models\Invoice::count() }}</p>
                </div>
                <div class="text-primary-500">
                    <x-heroicon-o-document-text class="h-8 w-8" />
                </div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium">Total Clients</h3>
                    <p class="text-3xl font-bold">{{ \App\Models\Client::count() }}</p>
                </div>
                <div class="text-primary-500">
                    <x-heroicon-o-users class="h-8 w-8" />
                </div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium">Total Amount</h3>
                    <p class="text-3xl font-bold">{{ number_format(\App\Models\Invoice::sum('total_amount'), 2) }}</p>
                </div>
                <div class="text-primary-500">
                    <x-heroicon-o-currency-dollar class="h-8 w-8" />
                </div>
            </div>
        </x-filament::card>
    </div>
</x-filament-panels::page> 