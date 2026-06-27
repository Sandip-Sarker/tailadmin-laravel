@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Users List" />



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
    <div class="space-y-6" id="user-table-container">
        <x-tables.basic-tables.user-tables-lists
            :users="$users"
            :search="$search"
            :perPage="$perPage"
        />
    </div>

    <!-- Create User Modal -->
    <div id="createUserModal" class="fixed inset-0 z-99999 hidden flex items-center justify-center overflow-y-auto p-5">
        <!-- Backdrop -->
        <div class="close-modal-trigger fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>

        <!-- Modal Content -->
        <div class="relative w-full max-w-[700px] rounded-3xl bg-white dark:bg-gray-900 shadow-2xl">
            <!-- Close Button -->
            <button type="button" class="close-modal-trigger absolute right-3 top-3 z-999 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z" fill="currentColor" />
                </svg>
            </button>

            <!-- Modal Body -->
            <div class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
                <div class="px-2 pr-14">
                    <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                        Add New User
                    </h4>
                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                        Create a new user profile by filling in the details below.
                    </p>
                </div>
                <form id="createUserForm" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" class="flex flex-col">
                    @csrf

                    <div class="custom-scrollbar h-[458px] overflow-y-auto p-2">
                        <div class="mt-2">
                            <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90 lg:mb-6">
                                Profile Image
                            </h5>
                            <div>
                                <input
                                    id="create_avatar"
                                    name="avatar"
                                    type="file"
                                    accept="image/*"
                                    class="dropify"
                                    data-height="150"
                                    data-max-file-size="150"
                                    data-allowed-file-extensions="jpg jpeg png gif webp"
                                    data-show-remove="true"
                                />
                            </div>
                        </div>

                        <div class="mt-8">
                            <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90 lg:mb-6">
                                Personal Information
                            </h5>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                                <div class="col-span-2 lg:col-span-1">
                                    <label for="create_name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Name
                                    </label>
                                    <input id="create_name" name="name" type="text" value="{{ old('name') }}"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" required />
                                </div>

                                <div class="col-span-2 lg:col-span-1">
                                    <label for="create_email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Email
                                    </label>
                                    <input id="create_email" name="email" type="email" value="{{ old('email') }}"
                                        class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" required />
                                </div>

                                <div class="col-span-2 lg:col-span-1">
                                    <label for="create_password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Password
                                    </label>
                                    <input id="create_password" name="password" type="password"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" required />
                                </div>

                                <div class="col-span-2 lg:col-span-1">
                                    <label for="create_role" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Role
                                    </label>
                                    <select id="create_role" name="role"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800" required>
                                        <option value="User" @selected(old('role') === 'User')>User</option>
                                        <option value="Admin" @selected(old('role') === 'Admin')>Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
                        <button type="button" class="close-modal-trigger flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                            Close
                        </button>
                        <button type="submit"
                            class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="fixed inset-0 z-99999 hidden flex items-center justify-center overflow-y-auto p-5">
        <!-- Backdrop -->
        <div class="close-modal-trigger fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>

        <!-- Modal Content -->
        <div class="relative w-full max-w-[700px] rounded-3xl bg-white dark:bg-gray-900 shadow-2xl">
            <!-- Close Button -->
            <button type="button" class="close-modal-trigger absolute right-3 top-3 z-999 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z" fill="currentColor" />
                </svg>
            </button>

            <!-- Modal Body -->
            <div class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
                <div class="px-2 pr-14">
                    <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                        Edit User Information
                    </h4>
                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                        Update user details. Leave password blank if you do not wish to change it.
                    </p>
                </div>
                <form id="editUserForm" method="POST" action="" enctype="multipart/form-data" class="flex flex-col">
                    @csrf

                    <div class="custom-scrollbar h-[458px] overflow-y-auto p-2">
                        <div class="mt-2">
                            <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90 lg:mb-6">
                                Profile Image
                            </h5>
                            <div>
                                <input
                                    id="edit_avatar"
                                    name="avatar"
                                    type="file"
                                    accept="image/*"
                                    class="dropify"
                                    data-height="150"
                                    data-max-file-size="150"
                                    data-allowed-file-extensions="jpg jpeg png gif webp"
                                    data-show-remove="true"
                                />
                            </div>
                        </div>

                        <div class="mt-8">
                            <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90 lg:mb-6">
                                Personal Information
                            </h5>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                                <div class="col-span-2 lg:col-span-1">
                                    <label for="edit_name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Name
                                    </label>
                                    <input id="edit_name" name="name" type="text" value=""
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" required />
                                </div>

                                <div class="col-span-2 lg:col-span-1">
                                    <label for="edit_email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Email
                                    </label>
                                    <input id="edit_email" name="email" type="email" value=""
                                        class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" required />
                                </div>

                                <div class="col-span-2 lg:col-span-1">
                                    <label for="edit_password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Password (Optional)
                                    </label>
                                    <input id="edit_password" name="password" type="password" placeholder="Leave blank to keep unchanged"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                </div>

                                <div class="col-span-2 lg:col-span-1">
                                    <label for="edit_role" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Role
                                    </label>
                                    <select id="edit_role" name="role"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800" required>
                                        <option value="User">User</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
                        <button type="button" class="close-modal-trigger flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                            Close
                        </button>
                        <button type="submit"
                            class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $(document).ready(function() {
        
        // Open Create Modal
        $(document).on('click', '.open-create-modal-btn', function() {
            $('#createUserModal').removeClass('hidden').addClass('flex');
            $('body').css('overflow', 'hidden');

            if (typeof $.fn.dropify !== 'undefined') {
                var drEvent = $('#create_avatar').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
            }
        });

        // Close Modals
        $(document).on('click', '.close-modal-trigger', function() {
            $('#createUserModal').addClass('hidden').removeClass('flex');
            $('#editUserModal').addClass('hidden').removeClass('flex');
            $('body').css('overflow', 'unset');
        });

        // Open Edit Modal
        $(document).on('click', '.open-edit-modal-btn', function() {
            var user = $(this).data('user');

            $('#edit_name').val(user.name);
            $('#edit_email').val(user.email);
            $('#edit_role').val(user.role || 'User');

            var actionUrl = "{{ route('users.index') }}/" + user.id + "/update";
            $('#editUserForm').attr('action', actionUrl);

            var avatarUrl = user.avatar ? '{{ asset('storage') }}/' + user.avatar : '{{ asset('images/user/owner.jpg') }}';

            $('#editUserModal').removeClass('hidden').addClass('flex');
            $('body').css('overflow', 'hidden');

            if (typeof $.fn.dropify !== 'undefined') {
                var drEvent = $('#edit_avatar').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.resetPreview();
                drEvent.clearElement();
                drEvent.settings.defaultFile = avatarUrl;
                drEvent.destroy();
                drEvent.init();
            }
        });

        // ------------------ Axios & jQuery Operations ------------------

        // Load / Refresh User Table
        async function getList(url = window.location.href) {
            try {
                let res = await axios.get(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                let newHtml = $(res.data).find('#user-table-container').html();
                $('#user-table-container').html(newHtml);
                window.history.pushState({ path: url }, '', url);
            } catch (err) {
                showToast("Failed to load user table.", "#f43f5e");
            }
        }

        // Create User Submit
        $('#createUserForm').on('submit', async function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            try {
                let res = await axios.post($(this).attr('action'), formData, {
                    headers: { 'Accept': 'application/json' }
                });
                if (res.data.success) {
                    $('#createUserModal').addClass('hidden').removeClass('flex');
                    $('body').css('overflow', 'unset');
                    $('#createUserForm')[0].reset();
                    if (typeof $.fn.dropify !== 'undefined') {
                        $('#create_avatar').data('dropify').clearElement();
                    }
                    showToast(res.data.message, "#22c55e");
                    await getList();
                }
            } catch (err) {
                showErrors(err);
            }
        });

        // Edit User Submit
        $('#editUserForm').on('submit', async function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            try {
                let res = await axios.post($(this).attr('action'), formData, {
                    headers: { 'Accept': 'application/json' }
                });
                if (res.data.success) {
                    $('#editUserModal').addClass('hidden').removeClass('flex');
                    $('body').css('overflow', 'unset');
                    $('#editUserForm')[0].reset();
                    if (typeof $.fn.dropify !== 'undefined') {
                        $('#edit_avatar').data('dropify').clearElement();
                    }
                    showToast(res.data.message, "#22c55e");
                    await getList();
                }
            } catch (err) {
                showErrors(err);
            }
        });

        // Delete User Confirmation & Action
        $(document).on('submit', '#user-table-container .confirm-delete-form', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    popup: 'dark:bg-gray-900 dark:text-white',
                    title: 'dark:text-white',
                    htmlContainer: 'dark:text-gray-300'
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        let res = await axios.post($(form).attr('action'), new FormData(form), {
                            headers: { 'Accept': 'application/json' }
                        });
                        if (res.data.success) {
                            showToast(res.data.message, "#22c55e");
                            await getList();
                        }
                    } catch (err) {
                        showErrors(err);
                    }
                }
            });
            e.stopImmediatePropagation();
        });

        // Search Form Submit
        $(document).on('submit', '#user-table-container form', function(e) {
            if ($(this).hasClass('confirm-delete-form')) return;
            e.preventDefault();
            let url = $(this).attr('action') || window.location.href;
            let queryParams = $(this).serialize();
            getList(url + (url.indexOf('?') >= 0 ? '&' : '?') + queryParams);
        });

        // Per-Page Selector Change
        $(document).on('change', '#user-table-container select[name="per_page"]', function(e) {
            let form = $(this).closest('form');
            let url = form.attr('action') || window.location.href;
            getList(url + (url.indexOf('?') >= 0 ? '&' : '?') + form.serialize());
        });

        // Pagination Link Click
        $(document).on('click', '#user-table-container a', function(e) {
            let href = $(this).attr('href');
            if (!href || href === '#' || href.startsWith('javascript:')) return;
            e.preventDefault();
            getList(href);
        });

        // Toast Helper
        function showToast(message, color) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "right",
                style: { background: color }
            }).showToast();
        }

        // Validation Error Parser Helper
        function showErrors(err) {
            if (err.response && err.response.status === 422) {
                let errors = err.response.data.errors;
                if (errors) {
                    $.each(errors, function(key, msgs) {
                        $.each(msgs, function(i, msg) {
                            showToast(msg, "#f43f5e");
                        });
                    });
                } else if (err.response.data.message) {
                    showToast(err.response.data.message, "#f43f5e");
                }
            } else {
                let msg = (err.response && err.response.data && err.response.data.message) 
                    ? err.response.data.message 
                    : "Something went wrong.";
                showToast(msg, "#f43f5e");
            }
        }
    });
</script>
@endpush