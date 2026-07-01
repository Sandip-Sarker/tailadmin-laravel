@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Page Settings" />

    @if (session('success'))
        <div class="rounded-3xl bg-emerald-50 border border-emerald-100 p-4 text-emerald-700 dark:bg-emerald-900/10 dark:text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-3xl bg-rose-50 border border-rose-100 p-4 text-rose-700 dark:bg-rose-900/10 dark:text-rose-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-6 shadow-sm dark:bg-slate-900">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-brand-500">Settings</p>
                    <h1 class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">Dynamic Pages</h1>
                    <p class="mt-2 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Manage pages, slugs, content and status from a single dashboard.</p>
                </div>

            </div>
        </div>

        <div class="rounded-3xl bg-white shadow-sm dark:bg-slate-900">
            <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-4 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Page List</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">All dynamic pages stored in the system.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative w-full sm:w-72">
                        <input type="search" placeholder="Search by title or slug"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:focus:border-brand-400 dark:focus:ring-brand-500/20" />
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto p-6">
                <table class="min-w-full table-auto text-left">
                    <thead class="border-b border-gray-200 text-sm uppercase tracking-[0.2em] text-gray-500 dark:border-gray-800 dark:text-gray-400">
                        <tr>
                            <th class="pb-4 pr-6 pt-2">ID</th>
                            <th class="pb-4 pr-6 pt-2">Page Title</th>
                            <th class="pb-4 pr-6 pt-2">Slug</th>
                            <th class="pb-4 pr-6 pt-2">Status</th>
                            <th class="pb-4 pr-6 pt-2">Last Updated</th>
                            <th class="pb-4 pt-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-600 dark:divide-gray-800 dark:text-gray-300">
                        @forelse ($pages ?? [] as $page)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="whitespace-nowrap py-4 pr-6 font-medium text-gray-900 dark:text-white">{{ $page->id }}</td>
                                <td class="py-4 pr-6">{{ $page->page_title }}</td>
                                <td class="py-4 pr-6 text-brand-500">{{ $page->page_slug }}</td>
                                <td class="py-4 pr-6">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] {{ $page->status === 'Active' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-200' }}">
                                        {{ $page->status }}
                                    </span>
                                </td>
                                <td class="py-4 pr-6">{{ optional($page->updated_at)->format('M d, Y') ?? '-' }}</td>
                                <td class="py-4 text-right">
                                    <a href="{{ route('page-setting.edit', $page->id) }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 transition hover:border-brand-500 hover:text-brand-500 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No dynamic pages found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        <div x-show="editModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/70 p-4 backdrop-blur-sm"
            @click="closeEditModal()">
            <div @click.stop class="w-full max-w-3xl overflow-hidden rounded-3xl bg-white text-left shadow-2xl dark:bg-slate-900">
                <div class="flex items-start justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Page</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Update your page details and status.</p>
                    </div>
                    <button type="button" @click="closeEditModal()"
                        class="rounded-full bg-gray-100 p-2 text-gray-600 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                </div>

                <form method="POST" x-bind:action="editPage.id ? '{{ url('/page-setting') }}/' + editPage.id + '/update' : '#'" class="space-y-5 px-6 py-6">
                    @csrf
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-gray-900 dark:text-white">Page Title</label>
                            <input type="text" name="page_title" x-model="editPage.page_title" required
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:focus:border-brand-400 dark:focus:ring-brand-500/20" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-900 dark:text-white">Page Slug</label>
                            <input type="text" name="page_slug" x-model="editPage.page_slug" required
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:focus:border-brand-400 dark:focus:ring-brand-500/20" />
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Page Content</label>
                        <textarea name="page_content" x-model="editPage.page_content" rows="5"
                            class="mt-2 w-full rounded-3xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:focus:border-brand-400 dark:focus:ring-brand-500/20"></textarea>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status" x-model="editPage.status"
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:focus:border-brand-400 dark:focus:ring-brand-500/20">
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                        <div class="flex items-end justify-end gap-3">
                            <button type="button" @click="closeEditModal()"
                                class="rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:border-brand-500 hover:text-brand-500 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200">
                                Cancel
                            </button>
                            <button type="submit"
                                class="rounded-2xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-600">
                                Update Page
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


