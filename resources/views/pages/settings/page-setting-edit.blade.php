@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Page" />

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
                    <p class="text-sm font-semibold uppercase tracking-wider text-brand-500">Page Settings</p>
                    <h1 class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">Edit Dynamic Page</h1>
                    <p class="mt-2 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Update the title, slug, content, and status for this page.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('page-setting') }}" class="rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm text-gray-700 transition hover:border-brand-500 hover:text-brand-500 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200">Back to Page List</a>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm dark:bg-slate-900">
            <form method="POST" action="{{ route('page-setting.update', $page->id) }}" class="space-y-6">
                @csrf

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Page Title</label>
                        <input type="text" name="page_title" value="{{ old('page_title', $page->page_title) }}" required
                            class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:focus:border-brand-400 dark:focus:ring-brand-500/20" />
                        @error('page_title')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Page Slug</label>
                        <input type="text" name="page_slug" value="{{ old('page_slug', $page->page_slug) }}" required
                            class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:focus:border-brand-400 dark:focus:ring-brand-500/20" />
                        @error('page_slug')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900 dark:text-white">Page Content</label>
                    <textarea id="edit_page_content_page" name="page_content" rows="8"
                        class="mt-2 w-full rounded-3xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:focus:border-brand-400 dark:focus:ring-brand-500/20">{{ old('page_content', $page->page_content) }}</textarea>
                    @error('page_content')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <select name="status"
                            class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:focus:border-brand-400 dark:focus:ring-brand-500/20">
                            <option value="Active" {{ old('status', $page->status) === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $page->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-end justify-end gap-3">
                        <a href="{{ route('page-setting') }}"
                            class="rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:border-brand-500 hover:text-brand-500 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200">Cancel</a>
                        <button type="submit"
                            class="rounded-2xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-600">Update Page</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#edit_page_content_page'), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
