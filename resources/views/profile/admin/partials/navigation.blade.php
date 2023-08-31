<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">Online Quiz Platform<span
                class="badge text-bg-primary ms-2">Admin Dashboard</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
                </li>
                {{-- <li class="nav-item active">
                    <a href="" class="nav-link">Job Posted</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Applicants</a>
                </li> --}}
            </ul>
            <a href="" class="btn btn-outline-warning mx-3">Post Quiz</a>
            <div class="dropdown-center">
                <button class="btn btn-secondary text-bg-warning dropdown-toggle " type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                        this.closest('form').submit();">
                                Log Out
                            </a>

                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
