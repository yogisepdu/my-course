<!-- Topbar Start -->
<div class="container-fluid bg-dark">
    <div class="row py-2 px-lg-5">
        <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
            <div class="d-inline-flex align-items-center text-white">
                <small><i class="fa fa-phone-alt mr-2"></i>+012 345 6789</small>
                <small class="px-3">|</small>
                <small><i class="fa fa-envelope mr-2"></i>info@example.com</small>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <a class="text-white px-2" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-white px-2" href="">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-white px-2" href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-white px-2" href="">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-white pl-2" href="">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
        <a href="index.html" class="navbar-brand ml-lg-3">
            <h1 class="m-0 text-uppercase text-primary"><img src="{{ asset('assets/images/Logo.png') }}" alt="Image"
                    style="width: 100px;"></img></h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        @guest
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    {{-- Jika belum login (guest), tampilkan tombol Login & Register --}}
                    <a href="{{ route('index') }}"
                        class="nav-item nav-link {{ Route::is('index') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('about') }}"
                        class="nav-item nav-link {{ Route::is('about') ? 'active' : '' }}">About</a>
                    <a href="{{ route('course') }}"
                        class="nav-item nav-link {{ Route::is('course') ? 'active' : '' }}">Courses</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0">
                            <a href="{{ route('team') }}"
                                class="dropdown-item {{ Route::is('team') ? 'active' : '' }}">Instructors</a>
                            <a href="{{ route('testimonial') }}"
                                class="dropdown-item {{ Route::is('testimonial') ? 'active' : '' }}">Testimonial</a>
                        </div>
                    </div>
                    <a href="{{ route('contact') }}"
                        class="nav-item nav-link {{ Route::is('contact') ? 'active' : '' }}">Contact</a>
                </div>

                <div class="mr-lg-3">
                    <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4 d-none d-lg-block">Login</a>
                </div>
                <div class="mr-lg-3">
                    <a href="{{ route('register') }}" class="btn btn-secondary py-2 px-4 d-none d-lg-block">Register</a>
                </div>
            </div>
        @endguest

        @auth
            @if (Auth::user()->role === 'student')
                <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        {{-- Jika belum login (guest), tampilkan tombol Login & Register --}}
                        <a href="{{ route('index') }}"
                            class="nav-item nav-link {{ Route::is('index') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('course') }}"
                            class="nav-item nav-link {{ Route::is('course') ? 'active' : '' }}">Courses</a>
                        <a href="{{ route('student.show') }}"
                            class="nav-item nav-link {{ Route::is('student.show') ? 'active' : '' }}">My Course</a>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <div class="mr-lg-3">
                        <button href="{{ route('logout') }}"
                            class="btn btn-secondary py-2 px-4 d-none d-lg-block">Logout</button>
                    </div>
                </form>
            @endif
        @endauth
    </nav>
</div>
<!-- Navbar End -->
