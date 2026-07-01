
<!-- Scripts -->
@vite('resources/js/app.js')


<!-- jQuery (required by Dropify) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Dropify JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<!-- Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Toastify & SweetAlert2 -->
<script>
    $(document).ready(function() {
        @if(session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                style: {
                    background: "#22c55e",
                }
            }).showToast();
        @endif

        @if(session('deleted'))
            Swal.fire({
                title: 'Deleted!',
                text: "{{ session('deleted') }}",
                icon: 'success',
                confirmButtonColor: '#3085d6',
                customClass: {
                    popup: 'dark:bg-gray-900 dark:text-white',
                    title: 'dark:text-white',
                    htmlContainer: 'dark:text-gray-300'
                }
            });
        @endif

        @if(session('error'))
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                style: {
                    background: "#f43f5e",
                }
            }).showToast();
        @endif

        // Global SweetAlert2 delete confirmation
        $(document).on('submit', '.confirm-delete-form', function(e) {
            e.preventDefault();
            var form = this;
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
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>


<!-- Apply dark mode immediately to prevent flash -->
<script>
    (function() {
        const savedTheme = localStorage.getItem('theme');
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        const theme = savedTheme || systemTheme;
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            document.body.classList.add('dark', 'bg-gray-900');
        } else {
            document.documentElement.classList.remove('dark');
            document.body.classList.remove('dark', 'bg-gray-900');
        }
    })();
</script>


<!-- Theme Store -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('theme', {
            init() {
                const savedTheme = localStorage.getItem('theme');
                const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' :
                    'light';
                this.theme = savedTheme || systemTheme;
                this.updateTheme();
            },
            theme: 'light',
            toggle() {
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                localStorage.setItem('theme', this.theme);
                this.updateTheme();
            },
            updateTheme() {
                const html = document.documentElement;
                const body = document.body;
                if (this.theme === 'dark') {
                    html.classList.add('dark');
                    body.classList.add('dark', 'bg-gray-900');
                } else {
                    html.classList.remove('dark');
                    body.classList.remove('dark', 'bg-gray-900');
                }
            }
        });

        Alpine.store('sidebar', {
            // Initialize based on screen size
            isExpanded: window.innerWidth >= 1280, // true for desktop, false for mobile
            isMobileOpen: false,
            isHovered: false,

            toggleExpanded() {
                this.isExpanded = !this.isExpanded;
                this.isMobileOpen = false;
                if (typeof window.applySidebarState === 'function') {
                    window.applySidebarState(this.isExpanded, this.isMobileOpen, this.isHovered);
                }
            },

            toggleMobileOpen() {
                this.isMobileOpen = !this.isMobileOpen;
                if (typeof window.applySidebarState === 'function') {
                    window.applySidebarState(this.isExpanded, this.isMobileOpen, this.isHovered);
                }
            },

            setMobileOpen(val) {
                this.isMobileOpen = val;
                if (typeof window.applySidebarState === 'function') {
                    window.applySidebarState(this.isExpanded, this.isMobileOpen, this.isHovered);
                }
            },

            setHovered(val) {
                // Only allow hover effects on desktop when sidebar is collapsed
                if (window.innerWidth >= 1280 && !this.isExpanded) {
                    this.isHovered = val;
                    if (typeof window.applySidebarState === 'function') {
                        window.applySidebarState(this.isExpanded, this.isMobileOpen, this.isHovered);
                    }
                }
            }
        });
    });
</script>
