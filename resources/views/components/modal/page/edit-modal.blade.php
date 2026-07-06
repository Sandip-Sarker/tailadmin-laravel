<div id="editPageModal" class="fixed inset-0 z-99999 hidden flex items-center justify-center overflow-y-auto p-5">
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
                    Edit Page Settings
                </h4>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                    Update the dynamic page details.
                </p>
            </div>
            <form id="editPageForm" method="POST" action="" class="flex flex-col">
                @csrf

                <div class="custom-scrollbar h-[400px] overflow-y-auto p-2">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                        <div class="col-span-2">
                            <label for="edit_page_title" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Page Title
                            </label>
                            <input id="edit_page_title" name="page_title" type="text" value=""
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" required />
                        </div>

                        <div class="col-span-2">
                            <label for="edit_page_slug" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Page Slug
                            </label>
                            <input id="edit_page_slug" name="page_slug" type="text" value=""
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" required />
                        </div>

                        <div class="col-span-2">
                            <label for="edit_page_content" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Page Content
                            </label>
                            <textarea id="edit_page_content" name="page_content" rows="6"
                                class="dark:bg-dark-900 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label for="edit_status" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Status
                            </label>
                            <select id="edit_status" name="status"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
                    <button type="button" class="close-modal-trigger flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                        Close
                    </button>
                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-blue-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-600 sm:w-auto">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
