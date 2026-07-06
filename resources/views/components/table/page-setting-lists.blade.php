@if($errors->any())
    <div class="mb-6">
        <x-ui.alert variant="error" title="Validation Errors">
            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-ui.alert>
    </div>
@endif

<!-- User List Table -->
<div class="space-y-6" id="page-table-container">
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">

<!-- Header: Search + Per-page -->
<div class="flex flex-col gap-3 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Page</h3>

    <div class="flex flex-wrap items-center gap-3">
        {{-- <button type="button"
            class="open-create-modal-btn shadow-theme-xs flex h-[42px] items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
            <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.00016 3.33334V12.6667M3.3335 8.00001H12.6668" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Add User
        </button> --}}
    </div>
</div>

<!-- Table -->

<div class="overflow-hidden">
    <div class="max-w-full px-5 overflow-x-auto ">
        <table class="min-w-full">
            <thead>
                <tr class="border-gray-300 border-y dark:border-gray-200">
                    <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">#</th>
                    <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Page Title</th>
                    <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Status</th>
                    <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                @forelse ($pages as $page)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">

                        {{-- # --}}
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $page->page_title }}
                        </td>

                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $page->status }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">

                                {{-- View --}}
                                <a href="{{ route('page-setting.show', $page->id) }}" title="View"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-blue-500 bg-blue-50 hover:bg-blue-100 dark:bg-blue-500/10 dark:hover:bg-blue-500/20 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                                {{-- Edit --}}
                                <button type="button" title="Edit" 
                                    class="open-edit-modal-btn inline-flex items-center justify-center w-8 h-8 rounded-lg text-yellow-500 bg-yellow-50 hover:bg-yellow-100 dark:bg-yellow-500/10 dark:hover:bg-yellow-500/20 transition-colors" 
                                    data-page="{{ json_encode($page) }}"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </button>

                                {{-- Delete --}}
                                <button type="submit" title="Delete"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-500 bg-red-50 hover:bg-red-100 dark:bg-red-500/10 dark:hover:bg-red-500/20 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        <path d="M10 11v6"/>
                                        <path d="M14 11v6"/>
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                    </svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-sm text-gray-400 dark:text-gray-500">
                            No data found.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>



