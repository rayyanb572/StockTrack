<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ Auth::user()->foto }}"
                    class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ Auth::user()->foto }}" class="img-circle elevation-2"
                        alt="User Image">

                    <p>
                        {{ Auth::user()->name }} - @if (Auth::user()->level == 0)
                            Admin
                        @else
                            Kasir
                        @endif
                    </p>
                </li>
                <!-- Menu Body -->
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{ route('user.profil') }}" class="btn btn-default btn-flat">Profile</a>
                    <a href="#" class="btn btn-default btn-flat float-right"
                    onclick="document.getElementById('logout-form').submit()">Sign out</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<form action="{{ route('logout') }}" method="post" id = "logout-form" style="display : none;">
    @csrf
</form>
