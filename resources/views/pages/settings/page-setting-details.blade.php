@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Page Details" />

    <div class="space-y-6">
        <!-- Content Area: The Policy View -->
        <div class="lg:col-span-2 rounded-3xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-slate-900 overflow-hidden">
            <!-- Top bar of reader -->
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-8 py-4 bg-gray-50/50 dark:bg-slate-950/20">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-400"></span>
                    <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                    <span class="w-3 h-3 rounded-full bg-green-400"></span>
                </div>
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500 font-mono">legal_document.md</span>
            </div>

            <div class="px-8 py-10 md:px-12">
                <!-- Title in reader -->
                <h2 class="text-3xl font-extrabold text-gray-950 dark:text-white tracking-tight mb-6">
                    {{ $page->page_title }}
                </h2>

                <!-- Body Content -->
                <div class="prose dark:prose-invert max-w-none text-gray-800 dark:text-gray-200 leading-relaxed text-base space-y-6 whitespace-pre-wrap font-sans">
                    {!! $page->page_content ?: 'No legal content has been defined for this page yet.' !!}
                </div>
            </div>
        </div>
    </div>
@endsection
