<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const DESKTOP_BREAKPOINT = 991;

    function isMobileSidebar() {
        return window.innerWidth <= DESKTOP_BREAKPOINT;
    }

    function syncSidebarButtons() {
        const reopenButton = document.querySelector('.sidebar-reopen');
        const toggleButton = document.querySelector('.sidebar-topbar .openbtn i');

        if (reopenButton) {
            reopenButton.setAttribute('aria-hidden', isMobileSidebar() ? 'true' : 'false');
        }

        if (toggleButton) {
            toggleButton.className = document.body.classList.contains('admin-sidebar-collapsed')
                ? 'fas fa-bars'
                : 'fas fa-chevron-left';
        }
    }

    function applySidebarState() {
        const sidebar = document.getElementById("mySidenav");
        if (!sidebar) {
            return;
        }

        if (isMobileSidebar()) {
            document.body.classList.remove('admin-sidebar-collapsed');
            document.body.classList.toggle(
                'admin-sidebar-mobile-open',
                sidebar.dataset.mobileOpen === '1'
            );
        } else {
            document.body.classList.remove('admin-sidebar-mobile-open');
            document.body.classList.toggle(
                'admin-sidebar-collapsed',
                localStorage.getItem('adminSidebarCollapsed') === '1'
            );
            sidebar.dataset.mobileOpen = '0';
        }

        syncSidebarButtons();
    }

    function openNav() {
        const sidebar = document.getElementById("mySidenav");
        if (!sidebar) {
            return;
        }

        if (isMobileSidebar()) {
            sidebar.dataset.mobileOpen = '1';
            document.body.classList.add('admin-sidebar-mobile-open');
            syncSidebarButtons();
            return;
        }

        localStorage.setItem('adminSidebarCollapsed', '0');
        document.body.classList.remove('admin-sidebar-collapsed');
        syncSidebarButtons();
    }

    function closeNav() {
        const sidebar = document.getElementById("mySidenav");
        if (!sidebar) {
            return;
        }

        if (isMobileSidebar()) {
            sidebar.dataset.mobileOpen = '0';
            document.body.classList.remove('admin-sidebar-mobile-open');
            syncSidebarButtons();
            return;
        }

        localStorage.setItem('adminSidebarCollapsed', '1');
        document.body.classList.add('admin-sidebar-collapsed');
        syncSidebarButtons();
    }

    function toggleNav() {
        if (isMobileSidebar()) {
            if (document.body.classList.contains('admin-sidebar-mobile-open')) {
                closeNav();
                return;
            }
            openNav();
            return;
        }
        if (document.body.classList.contains('admin-sidebar-collapsed')) {
            openNav();
            return;
        }
        closeNav();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById("mySidenav");
        if (!sidebar) {
            return;
        }

        sidebar.dataset.mobileOpen = '0';
        applySidebarState();

        window.addEventListener('resize', applySidebarState);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && document.body.classList.contains('admin-sidebar-mobile-open')) {
                closeNav();
            }
        });
    });
</script>
