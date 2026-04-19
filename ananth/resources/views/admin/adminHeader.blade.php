<header>
    <div class="sidebar-backdrop" id="adminSidebarBackdrop" onclick="closeNav()" aria-hidden="true"></div>
    <div class="sidebar" id="mySidenav">
        <button type="button" class="closebtn" onclick="closeNav()" aria-label="Close sidebar"><i class="fas fa-times"></i></button>
        <div class="sidebar-shell">
        <div class="sidebar-topbar">
            <button type="button" class="openbtn" onclick="toggleNav()" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></button>
        </div>
        <div class="logo_area">
            <a href="{{ asset('admin/dashboard') }}/" class="brand-link">
                <img src="{{ asset('img/site/ananth-logo.svg') }}" alt="Ananth Decodes Logistics">
            </a>
        </div>
        <div class="menu-section-label">Navigation</div>
        <div class="menu_list">
            <ul>
                <li class="{{ request()->is('admin/dashboard*') ? 'active_tab' : '' }}"><a href="/admin/dashboard/"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li class="{{ request()->is('admin/profile*') ? 'active_tab' : '' }}"><a href="/admin/profile/"><i class="fas fa-user-cog"></i>My Profile</a></li>
                <li class="{{ request()->is('admin/add-user*') ? 'active_tab' : '' }}"><a href="/admin/add-user/"><i class="fas fa-plus"></i>Add Author</a></li>
                <li class="{{ request()->is('admin/users-list*') || request()->is('admin/edit/user/*') ? 'active_tab' : '' }}"><a href="/admin/users-list/"><i class="fas fa-user"></i>Authors List</a></li>
                <li class="{{ request()->is('admin/create-blog*') ? 'active_tab' : '' }}"><a href="/admin/create-blog/"><i class="fas fa-plus-square"></i>Create Blog</a></li>
                <li class="{{ request()->is('admin/live-blogs*') || request()->is('admin/edit/blog/*') ? 'active_tab' : '' }}"><a href="/admin/live-blogs/"><i class="fas fa-eye"></i>Live Blogs</a></li>
                <li class="{{ request()->is('admin/draft-blogs*') ? 'active_tab' : '' }}"><a href="/admin/draft-blogs/"><i class="fas fa-eye-slash"></i>Draft Blogs</a></li>
                <li class="{{ request()->is('admin/messages*') ? 'active_tab' : '' }}"><a href="/admin/messages/"><i class="fas fa-envelope-open"></i>Messages</a></li>
                <li class="{{ request()->is('admin/add-book-review*') ? 'active_tab' : '' }}"><a href="/admin/add-book-review/"><i class="fas fa-book-medical"></i>Add Book Review</a></li>
                <li class="{{ request()->is('admin/book-reviews*') || request()->is('admin/edit/book-review/*') ? 'active_tab' : '' }}"><a href="/admin/book-reviews/"><i class="fas fa-book"></i>Book Reviews</a></li>
                <li class="{{ request()->is('admin/create-insight*') ? 'active_tab' : '' }}"><a href="/admin/create-insight/"><i class="fas fa-plus-square"></i>Create Insight</a></li>
                <li class="{{ request()->is('admin/live-insights*') || request()->is('admin/edit/insight/*') ? 'active_tab' : '' }}"><a href="/admin/live-insights/"><i class="fas fa-eye"></i>Manage Insights</a></li>
                <li class="{{ request()->is('admin/add-member*') ? 'active_tab' : '' }}"><a href="/admin/add-member/"><i class="fas fa-plus-square"></i>Add Member</a></li>
                <li class="{{ request()->is('admin/members-list*') || request()->is('admin/edit-member/*') ? 'active_tab' : '' }}"><a href="/admin/members-list/"><i class="fas fa-users"></i>Manage Members</a></li>
                <li class="{{ request()->is('admin/edit-home-page*') ? 'active_tab' : '' }}"><a href="/admin/edit-home-page/"><i class="fas fa-home"></i>Edit Home Page</a></li>
                <li class="{{ request()->is('admin/edit-about-page*') ? 'active_tab' : '' }}"><a href="/admin/edit-about-page/"><i class="fas fa-info-circle"></i>Edit About Page</a></li>
                <li class="{{ request()->is('admin/manage-milestones*') || request()->is('admin/add-milestone*') || request()->is('admin/edit-milestone/*') ? 'active_tab' : '' }}"><a href="/admin/manage-milestones/"><i class="fas fa-trophy"></i>Manage Milestones</a></li>
                <li class="{{ request()->is('admin/registrations*') ? 'active_tab' : '' }}" style="border-top:1px solid rgba(148, 163, 184, 0.18);margin-top:.5rem;padding-top:.5rem;">
                    <a href="/admin/registrations"><i class="fas fa-user-plus"></i>Contributor Registrations</a>
                </li>
                <li class="{{ request()->is('admin/contributor-plans*') ? 'active_tab' : '' }}"><a href="/admin/contributor-plans"><i class="fas fa-tags"></i>Contributor Plans</a></li>
                <li class="{{ request()->is('admin/contributor-posts*') ? 'active_tab' : '' }}"><a href="/admin/contributor-posts"><i class="fas fa-newspaper"></i>Contributor Posts</a></li>
            </ul>
        </div>
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('adminLogout') }}">
                @csrf
                <button class="sidebar-logout-btn" type="submit">
                    <i class="fas fa-sign-out-alt"></i>Logout
                </button>
            </form>
        </div>
        </div>
    </div>
    <button type="button" class="sidebar-reopen" onclick="openNav()" aria-label="Open sidebar">
        <i class="fas fa-chevron-right"></i>
    </button>
</header>
