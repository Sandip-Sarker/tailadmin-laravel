@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Users List" />

    <!-- Table User -->
    @include('components.table.user-lists')

    <!-- Create User Modal -->
    @include('components.modal.user.create-modal')

    <!-- Edit User Modal -->
    @include('components.modal.user.edit-modal')

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            
            // ------------------ Axios & jQuery Operations ------------------

            // Load / Refresh User Table
            async function getList(url = window.location.href) {
                try {
                    let res = await axios.get(url, {
                        headers: {
                            'Accept': 'text/html',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    // Use DOMParser to reliably parse the full HTML page
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(res.data, 'text/html');
                    let container = doc.getElementById('user-table-container');
                    if (container) {
                        document.getElementById('user-table-container').innerHTML = container.innerHTML;
                    }
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
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
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
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
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
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
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