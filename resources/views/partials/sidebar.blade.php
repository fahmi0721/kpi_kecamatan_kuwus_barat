<aside class="app-sidebar bg-dark-subtle" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="#" class="brand-link">
            <img src="{{ asset('uploads/images/avatar.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text">SiMoKin KWB</span>
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="navigation"
            aria-label="Main navigation"
            data-accordion="false"
            id="navigation"
        >
            <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>Dashboard</p>
            </a>
            </li>
            @if(auth()->user()->level == "admin")
            <li class="nav-item">
                <a href="{{ route('jabatan') }}" class="nav-link {{ Route::is('jabatan') ? 'active' : '' }}">
                    <i class="nav-icon fa  fa-sitemap fa-reguler"></i>
                    <p>Data Jabatan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pegawai') }}" class="nav-link {{ Route::is('pegawai') ? 'active' : '' }}">
                    <i class="nav-icon fa fa-user-tie fa-reguler"></i>
                    <p>Data Pegawai</p>
                </a>
            </li>
            <li class="nav-item">
                <a  href="{{ route('user') }}" class="nav-link ">
                    <i class="nav-icon fa fa-user fa-reguler"></i>
                    <p>Data User Login</p>
                </a>
            </li>
            @endif
            @if(auth()->user()->level == "pegawai")
            <li class="nav-item">
                <a href="{{ route('task.create') }}" class="nav-link {{ Route::is('task.create') ? 'active' : '' }}">
                    <i class="nav-icon fa  fa-plus-square fa-reguler"></i>
                    <p>Buat Tugas Harian</p>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('task') }}" class="nav-link {{ Route::is('task') ? 'active' : '' }}">
                    <i class="nav-icon fa  fa-tasks fa-reguler"></i>
                    <p>Monitoring Tugas</p>
                </a>
            </li>
        </ul>
        <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
    </aside>