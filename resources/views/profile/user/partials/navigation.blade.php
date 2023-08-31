<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand text-center d-flex align-items-center">Online Quiz Platform<span
                class="badge text-bg-info ms-2">User Dashboard</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}" class="nav-link {{ Request::is('user/dashboard') ? 'active' : '' }}">Dashboard</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="" class="nav-link">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Job Applied</a>
                </li> --}}
            </ul>
            <div class="dropdown-center">
                <button class="btn btn-secondary text-bg-warning dropdown-toggle ms-3" type="button"
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
