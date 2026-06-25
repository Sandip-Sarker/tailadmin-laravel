<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search', '');
        $perPage = (int) $request->input('per_page', 10);

        $users = User::query()
            ->select('id', 'name', 'email', 'role', 'avatar', 'created_at')
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('name',  'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role',  'like', "%{$search}%");
            }))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();   // keeps ?search=&per_page= on pagination links

        return view('pages.user.index', compact('users', 'search', 'perPage'));
    }
}
