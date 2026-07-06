@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Page Settings" />

    <!-- Table Page Setting -->
    @include('components.table.page-setting-lists')

    <!-- Edit Page Modal -->
    @include('components.modal.page.edit-modal')

@endsection

@push('scripts')
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {

            // Initialize CKEditor
            let editEditor;
            ClassicEditor
                .create(document.querySelector('#edit_page_content'), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
                })
                .then(editor => {
                    editEditor = editor;
                })
                .catch(error => {
                    console.error(error);
                });

            // ------------------ Axios & jQuery Operations ------------------

            // Load / Refresh Page Table
            async function getList(url = window.location.href) {
                try {
                    let res = await axios.get(url, {
                        headers: {
                            'Accept': 'text/html',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(res.data, 'text/html');
                    let container = doc.getElementById('page-table-container');
                    if (container) {
                        document.getElementById('page-table-container').innerHTML = container.innerHTML;
                    }
                    window.history.pushState({ path: url }, '', url);
                } catch (err) {
                    showToast("Failed to load page table.", "#f43f5e");
                }
            }

            // Open Edit Modal
            $(document).on('click', '.open-edit-modal-btn', function() {
                // Micro-animation click feedback design
                let $btn = $(this);
                $btn.addClass('scale-95 duration-100');
                setTimeout(() => $btn.removeClass('scale-95'), 150);

                var page = $(this).data('page');

                $('#edit_page_title').val(page.page_title);
                $('#edit_page_slug').val(page.page_slug);
                $('#edit_status').val(page.status || 'Active');

                if (editEditor) {
                    editEditor.setData(page.page_content || '');
                } else {
                    $('#edit_page_content').val(page.page_content);
                }

                var actionUrl = "{{ route('page-setting') }}/" + page.id + "/update";
                $('#editPageForm').attr('action', actionUrl);

                $('#editPageModal').removeClass('hidden').addClass('flex');
                $('body').css('overflow', 'hidden');
            });

            // Close Modals
            $(document).on('click', '.close-modal-trigger', function() {
                $('#editPageModal').addClass('hidden').removeClass('flex');
                $('body').css('overflow', 'unset');
            });

            // Edit Page Submit
            $('#editPageForm').on('submit', async function(e) {
                e.preventDefault();
                if (editEditor) {
                    editEditor.updateSourceElement();
                }
                let formData = new FormData(this);
                try {
                    let res = await axios.post($(this).attr('action'), formData, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (res.data.success) {
                        $('#editPageModal').addClass('hidden').removeClass('flex');
                        $('body').css('overflow', 'unset');
                        $('#editPageForm')[0].reset();
                        showToast(res.data.message, "#22c55e");
                        await getList();
                    }
                } catch (err) {
                    showErrors(err);
                }
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


