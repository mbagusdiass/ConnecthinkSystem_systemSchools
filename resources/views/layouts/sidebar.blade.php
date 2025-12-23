<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="/" class="text-nowrap ">
                System School
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                @auth
                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'guru')
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Management</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('classrooms.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-home"></i>
                                </span>
                                <span class="hide-menu">Classrooms</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('teachers.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-id-badge-2"></i>
                                </span>
                                <span class="hide-menu">Teachers</span>
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->type == 'admin')
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('students.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-friends"></i>
                                </span>
                                <span class="hide-menu">Students</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('parents.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-friends"></i>
                                </span>
                                <span class="hide-menu">Parents</span>
                            </a>
                        </li>
                    @endif
                @endauth

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Report</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('reports.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Report</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
