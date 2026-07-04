@php
    use App\Helpers\MenuHelper;
    // $menuGroups = MenuHelper::getMenuGroups();
    $menus = MenuHelper::getMainNavItems();
    $currentPath = request()->path();
@endphp

<aside id="sidebar"
    class="fixed flex flex-col mt-0 top-0 px-5 left-0 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200 sidebar-collapsed"
    onmouseenter="sidebarHoverEnter()"
    onmouseleave="sidebarHoverLeave()">

    {{-- Logo Section --}}
    <div class="pt-8 pb-7 flex sidebar-logo-wrap">
        <a href="/">
            <img id="logo-full-light" class="dark:hidden sidebar-logo-full" src="/images/logo/logo.svg" alt="Logo" width="150" height="40" />
            <img id="logo-full-dark" class="hidden dark:block sidebar-logo-full" src="/images/logo/logo-dark.svg" alt="Logo" width="150" height="40" />
            <img id="logo-icon" class="sidebar-logo-icon" src="/images/logo/logo-icon.svg" alt="Logo" width="32" height="32" style="display:none;" />
        </a>
    </div>

    {{-- Navigation Menu --}}
    <div class="flex flex-col h-full overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">

                <hr/>
                <div>
                    {{-- Menu Items --}}
                    <ul class="flex flex-col gap-1">
                        @foreach ($menus as $itemIndex => $item)
                            <li>
                                @if (isset($item['subItems']))
                                    @php
                                        $submenuOpen = MenuHelper::isSubmenuActive($item);
                                        $submenuKey = 'menu-' . $itemIndex;
                                    @endphp

                                    {{-- Menu Item with Submenu --}}
                                    <button
                                        type="button"
                                        onclick="toggleSubmenu('{{ $submenuKey }}')"
                                        data-submenu-key="{{ $submenuKey }}"
                                        class="menu-item group w-full {{ $submenuOpen ? 'menu-item-active' : 'menu-item-inactive' }}">

                                        {{-- Icon --}}
                                        <span class="{{ $submenuOpen ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}">
                                            {!! MenuHelper::getIconSvg($item['icon']) !!}
                                        </span>

                                        {{-- Text --}}
                                        <span class="menu-item-text flex items-center gap-2 sidebar-text-label">
                                            {{ $item['name'] }}
                                            @if (!empty($item['new']))
                                                <span class="absolute right-10 menu-dropdown-badge {{ $submenuOpen ? 'menu-dropdown-badge-active' : 'menu-dropdown-badge-inactive' }}">
                                                    new
                                                </span>
                                            @endif
                                        </span>

                                        {{-- Chevron Icon --}}
                                        <svg id="chevron-{{ $submenuKey }}"
                                            class="ml-auto w-5 h-5 transition-transform duration-200 sidebar-text-label {{ $submenuOpen ? 'rotate-180 text-brand-500' : '' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    {{-- Submenu --}}
                                    <div id="submenu-{{ $submenuKey }}" style="{{ $submenuOpen ? '' : 'display:none;' }}">
                                        <ul class="mt-2 space-y-1 ml-9">
                                            @foreach ($item['subItems'] as $subItem)
                                                @php
                                                    $subActive = MenuHelper::isActive($subItem['path']);
                                                @endphp
                                                <li>
                                                    <a href="{{ $subItem['path'] }}"
                                                        class="menu-dropdown-item {{ $subActive ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">

                                                        @if (!empty($subItem['icon']))
                                                            <span class="{{ $subActive ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}">
                                                                {!! MenuHelper::getIconSvg($subItem['icon']) !!}
                                                            </span>
                                                        @endif

                                                        <span>{{ $subItem['name'] }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    @php
                                        if (isset($item['route'])) {
                                            $routePrefix = preg_replace('/\.[^.]+$/', '', $item['route']);
                                            $isActive = request()->routeIs($routePrefix . '.*') || request()->routeIs($item['route']);
                                            $href = route($item['route']);
                                        } else {
                                            $isActive = MenuHelper::isActive($item['path']);
                                            $href = $item['path'];
                                        }
                                    @endphp

                                    {{-- Simple Menu Item --}}
                                    <a href="{{ $href }}"
                                        class="menu-item group {{ $isActive ? 'menu-item-active' : 'menu-item-inactive' }}">

                                        {{-- Icon --}}
                                        <span class="{{ $isActive ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}">
                                            {!! MenuHelper::getIconSvg($item['icon']) !!}
                                        </span>

                                        {{-- Text --}}
                                        <span class="menu-item-text flex items-center gap-2 sidebar-text-label">
                                            {{ $item['name'] }}
                                            @if (!empty($item['new']))
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-brand-500 text-white">
                                                    new
                                                </span>
                                            @endif
                                        </span>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </nav>

        
        {{-- Sidebar Widget --}}
        <div class="mx-auto mt-auto mb-10 w-full max-w-60 rounded-2xl bg-gray-50 px-4 py-5 text-center dark:bg-white/[0.03]">
          
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-3 py-3 text-theme-sm font-medium text-white hover:bg-brand-600" aria-label="Logout">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 8.25V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25v-3" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.5 12h9m0 0l-3-3m3 3l-3 3" />
                    </svg>
                    <span class="sidebar-text-label">Logout</span>
                </button>
            </form>
        </div>

    </div>
</aside>

{{-- Mobile Overlay --}}
<div id="mobile-overlay"
    onclick="closeMobileSidebar()"
    class="fixed z-50 h-screen w-full bg-gray-900/50"
    style="display:none;"></div>

<script>
(function () {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('mobile-overlay');

    // State
    var state = {
        isExpanded: window.innerWidth >= 1280,
        isMobileOpen: false,
        isHovered: false,
    };

    // ----- Helpers -----
    function isDesktop() {
        return window.innerWidth >= 1280;
    }

    function applyState() {
        var expanded = state.isExpanded || state.isHovered || state.isMobileOpen;
        var sidebarEl = sidebar;

        // Width classes
        if (expanded) {
            sidebarEl.style.width = '290px';
        } else {
            sidebarEl.style.width = '90px';
        }

        // Mobile transform
        if (isDesktop()) {
            sidebarEl.style.transform = 'translateX(0)';
            overlay.style.display = 'none';
        } else {
            if (state.isMobileOpen) {
                sidebarEl.style.transform = 'translateX(0)';
                overlay.style.display = 'block';
            } else {
                sidebarEl.style.transform = 'translateX(-100%)';
                overlay.style.display = 'none';
            }
        }

        // Show/hide text labels
        var labels = document.querySelectorAll('.sidebar-text-label');
        labels.forEach(function (el) {
            el.style.display = expanded ? '' : 'none';
        });

        // Logo toggle
        var logoFull = document.querySelectorAll('.sidebar-logo-full');
        var logoIcon = document.getElementById('logo-icon');
        logoFull.forEach(function (el) {
            el.style.display = expanded ? '' : 'none';
        });
        if (logoIcon) {
            logoIcon.style.display = expanded ? 'none' : '';
        }

        // Group title: show text or dots
        document.querySelectorAll('.sidebar-title-text').forEach(function (el) {
            el.style.display = expanded ? '' : 'none';
        });
        document.querySelectorAll('.sidebar-title-dots').forEach(function (el) {
            el.style.display = expanded ? 'none' : '';
        });

        // Logo wrapper alignment
        var logoWrap = document.querySelector('.sidebar-logo-wrap');
        if (logoWrap) {
            logoWrap.style.justifyContent = expanded ? 'flex-start' : 'center';
        }

        // Update main content margin
        var mainContent = document.getElementById('main-content');
        if (mainContent) {
            if (isDesktop()) {
                mainContent.style.marginLeft = expanded ? '290px' : '90px';
            } else {
                mainContent.style.marginLeft = '0';
            }
        }

        // Sync Alpine store if available
        if (typeof Alpine !== 'undefined' && Alpine.store && Alpine.store('sidebar')) {
            Alpine.store('sidebar').isExpanded = state.isExpanded;
            Alpine.store('sidebar').isMobileOpen = state.isMobileOpen;
            Alpine.store('sidebar').isHovered = state.isHovered;
        }
    }

    // ----- Submenu -----
    window.toggleSubmenu = function (key) {
        var submenu = document.getElementById('submenu-' + key);
        var chevron = document.getElementById('chevron-' + key);
        var btn     = document.querySelector('[data-submenu-key="' + key + '"]');

        if (!submenu) return;

        var isOpen = submenu.style.display !== 'none';

        // Close all submenus
        document.querySelectorAll('[id^="submenu-"]').forEach(function (el) {
            el.style.display = 'none';
        });
        document.querySelectorAll('[id^="chevron-"]').forEach(function (el) {
            el.classList.remove('rotate-180', 'text-brand-500');
        });
        document.querySelectorAll('[data-submenu-key]').forEach(function (el) {
            el.classList.remove('menu-item-active');
            el.classList.add('menu-item-inactive');
            var icon = el.querySelector('span:first-child');
            if (icon) {
                icon.classList.remove('menu-item-icon-active');
                icon.classList.add('menu-item-icon-inactive');
            }
        });

        // If it was closed, open it
        if (!isOpen) {
            submenu.style.display = '';
            if (chevron) {
                chevron.classList.add('rotate-180', 'text-brand-500');
            }
            if (btn) {
                btn.classList.remove('menu-item-inactive');
                btn.classList.add('menu-item-active');
                var icon = btn.querySelector('span:first-child');
                if (icon) {
                    icon.classList.remove('menu-item-icon-inactive');
                    icon.classList.add('menu-item-icon-active');
                }
            }
        }
    };

    // ----- Sidebar toggle (called from header button) -----
    window.toggleSidebar = function () {
        if (isDesktop()) {
            state.isExpanded = !state.isExpanded;
            state.isMobileOpen = false;
        } else {
            state.isMobileOpen = !state.isMobileOpen;
        }
        applyState();
    };

    window.closeMobileSidebar = function () {
        state.isMobileOpen = false;
        applyState();
    };

    // ----- Hover (desktop collapsed only) -----
    window.sidebarHoverEnter = function () {
        if (isDesktop() && !state.isExpanded) {
            state.isHovered = true;
            applyState();
        }
    };

    window.sidebarHoverLeave = function () {
        state.isHovered = false;
        applyState();
    };

    // ----- Responsive resize -----
    window.addEventListener('resize', function () {
        if (isDesktop()) {
            state.isMobileOpen = false;
            state.isExpanded = true;
        } else {
            state.isExpanded = false;
        }
        applyState();
    });

    // Expose state and applyState globally so script.blade.php Alpine store can delegate here
    window._sidebarState = state;
    window.applySidebarState = function (isExpanded, isMobileOpen, isHovered) {
        state.isExpanded  = (isExpanded  !== undefined) ? isExpanded  : state.isExpanded;
        state.isMobileOpen = (isMobileOpen !== undefined) ? isMobileOpen : state.isMobileOpen;
        state.isHovered   = (isHovered   !== undefined) ? isHovered   : state.isHovered;
        applyState();
    };

    // ----- Initial render -----
    applyState();
})();
</script>
