<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Filename</th>
                            <th scope="col" class="px-6 py-3">Size</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                            <th scope="col" class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups as $backup)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $backup['name'] }}</td>
                                <td class="px-6 py-4">{{ number_format($backup['size'] / 1024, 2) }} KB</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::createFromTimestamp($backup['date'])->format('Y-m-d H:i:s') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end">
                                        <x-filament::dropdown>
                                            <x-slot name="trigger">
                                                <x-filament::link
                                                    size="sm"
                                                    color="gray"
                                                    icon="heroicon-m-ellipsis-vertical"
                                                />
                                            </x-slot>

                                            <x-filament::dropdown.list>
                                                <x-filament::dropdown.list.item
                                                    icon="heroicon-m-arrow-down-tray"
                                                    wire:click="downloadBackup('{{ $backup['name'] }}')"
                                                >
                                                    Download
                                                </x-filament::dropdown.list.item>

                                                <x-filament::dropdown.list.item
                                                    icon="heroicon-m-arrow-path"
                                                    wire:click="restoreBackup('{{ $backup['name'] }}')"
                                                    wire:confirm="Are you sure you want to restore this backup? This will overwrite your current database."
                                                >
                                                    Restore
                                                </x-filament::dropdown.list.item>

                                                <x-filament::dropdown.list.item
                                                    icon="heroicon-m-trash"
                                                    wire:click="deleteBackup('{{ $backup['name'] }}')"
                                                    wire:confirm="Are you sure you want to delete this backup?"
                                                    color="danger"
                                                >
                                                    Delete
                                                </x-filament::dropdown.list.item>
                                            </x-filament::dropdown.list>
                                        </x-filament::dropdown>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="4" class="px-6 py-4 text-center">No backups found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page> 