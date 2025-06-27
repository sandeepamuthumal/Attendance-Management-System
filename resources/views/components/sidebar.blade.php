<aside class="page-sidebar">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div class="main-sidebar" id="main-sidebar">
        <ul class="sidebar-menu" id="simple-bar">
            <li class="pin-title sidebar-main-title">
                <div>
                    <h5 class="sidebar-title f-w-700">Pinned</h5>
                </div>
            </li>

            <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i>
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/iconly-sprite.svg#Home-dashboard') }}"></use>
                    </svg>
                    <h6 class="f-w-600">Dashboard</h6>
                </a>
            </li>

            <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i>
                <a class="sidebar-link" href="javascript:void(0)">
                    <div class="stroke-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h6>Manage Users</h6><i class="iconly-Arrow-Right-2 icli"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li> <a href="{{ route('admin.users.admins') }}">Admins</a></li>
                    <li><a href="{{ route('admin.users.teachers') }}">Teachers </a></li>
                </ul>
            </li>

            <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i>
                <a class="sidebar-link" href="{{ url('admin/classes') }}">
                    <div class="stroke-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h6 class="f-w-600">Manage Classes</h6>
                </a>
            </li>

            <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i>
                <a class="sidebar-link" href="javascript:void(0)">
                    <div class="stroke-icon">
                        <i class="bi bi-person-bounding-box"></i>
                    </div>
                    <h6>Students</h6><i class="iconly-Arrow-Right-2 icli"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li> <a href="{{ route('admin.students.create') }}">Create Student</a></li>
                    <li><a href="{{ route('admin.students.index') }}">All Students </a></li>
                </ul>
            </li>

            <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i>
                <a class="sidebar-link" href="javascript:void(0)">
            <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i>
                <a class="sidebar-link" href="javascript:void(0)">
                    <div class="stroke-icon">
                        <i class="bi bi-qr-code-scan"></i>
                    </div>
                    <h6>Attendances</h6><i class="iconly-Arrow-Right-2 icli"></i>
                    <h6>Attendances</h6><i class="iconly-Arrow-Right-2 icli"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li> <a href="{{ route('attendance.scanner') }}">Scanner</a></li>
                    <li> <a href="{{ route('attendance.reports') }}">Reports</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>

    <style>
        .page-sidebar .sidebar-link .stroke-icon {
            height: 18px;
            width: 18px;
            stroke: var(--body-font-color);
            transition: all .5s;
        }
    </style>
</aside>
