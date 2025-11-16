<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-logo text-center ">
                <a href="{{ route('home') }}" class="b-brand text-primary">
                    <img src="{{ asset('assets/images/Logo.png') }}" class="img-fluid logo-lg" alt="logo"
                        style="width: 100px;">
                </a>
            </div>
            <div class="navbar-content">
                @php
                    function isActive($pattern)
                    {
                        return request()->is($pattern) ? 'active' : '';
                    }
                @endphp
                <ul class="pc-navbar">
                    <li class="pc-item">
                        <a href="{{ route('home') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Account</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('admin.account.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-typography"></i></span>
                            <span class="pc-mtext">Account</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('admin.instructor.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-color-swatch"></i></span>
                            <span class="pc-mtext">Instructor</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Course</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-typography"></i></span>
                            <span class="pc-mtext">E-Course</span>
                            <span class="pc-arrow"><i class="ti ti-chevron-down"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item">
                                <a href="{{ route('admin.ecourse.index') }}" class="pc-link">Course</a>
                            </li>
                            <li class="pc-item">
                                <a href="{{ route('admin.ecourse.section') }}" class="pc-link">Course Section</a>
                            </li>
                            <li class="pc-item">
                                <a href="{{ route('admin.ecourse.content') }}" class="pc-link">Course Content</a>
                            </li>
                        </ul>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('admin.testimoni.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-plant-2"></i></span>
                            <span class="pc-mtext">Testimoni</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Setting</label>
                        <i class="ti ti-news"></i>
                    </li>

                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-brand-chrome"></i></span>
                            <span class="pc-mtext">Setting</span>
                        </a>
                        <a href="{{ route('logout') }}" class="pc-link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="pc-micon"><i class="ti ti-brand-chrome"></i></span>
                            <span class="pc-mtext">Logout</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
