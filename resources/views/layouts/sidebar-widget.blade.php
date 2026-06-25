<div class="mx-auto mt-auto mb-10 w-full max-w-60 rounded-2xl bg-gray-50 px-4 py-5 text-center dark:bg-white/[0.03]">
    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
        Logout
    </h3>
    <p class="mb-4 text-gray-500 text-theme-sm dark:text-gray-400">
        Sign out from your account securely and return to the login screen.
    </p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full rounded-lg bg-brand-500 px-3 py-3 text-theme-sm font-medium text-white hover:bg-brand-600">
            Logout
        </button>
    </form>
</div>
