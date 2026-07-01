<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DynamicPageController extends Controller
{
    public function index(Request $request)
    {
        $pages = DB::table('dynamic_pages')
            ->orderByDesc('id')
            ->get();

        return view('pages.settings.page-setting', compact('pages'));
    }

    public function edit(Request $request, $id)
    {
        $page = DB::table('dynamic_pages')->find($id);

        if (! $page) {
            return redirect()->route('page-setting')->with('error', 'Page not found.');
        }

        return view('pages.settings.page-setting-edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'page_title' => ['required', 'string', 'max:255'],
            'page_slug' => ['required', 'string', 'max:255'],
            'page_content' => ['nullable', 'string'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        DB::table('dynamic_pages')
            ->where('id', $id)
            ->update([
                'page_title' => $request->page_title,
                'page_slug' => $request->page_slug,
                'page_content' => $request->page_content,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        return redirect()->route('page-setting')->with('success', 'Page updated successfully.');
    }
}
