<nav class="navbar navbar-expand-lg navbar-dark bg-white p-3">
    <div class="container-fluid">
        <a class="navbar-brand text-dark" href="{{ route('home') }}"><strong>Online Quiz Platform</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">

                @if (auth()->check())
                    <div class="dropdown-center">
                        <button class="btn btn-secondary text-bg-warning dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                @if (auth()->user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        Dashboard
                                    </a>
                                @else
                                    <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        Dashboard
                                    </a>
                                @endif

                            </li>

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
                                 <!-- Authentication  ends-->
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
                    <a class="btn ms-3 btn-secondary text-bg-warning" href="{{ route('register') }}">Register</a>
                @endif
            </ul>
        </div>
    </div>
</nav>
