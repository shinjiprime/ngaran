<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container-fluid">
        <button class="toggle-btn" type="button">
            <i class="fas fa-bars" style="color: white;"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <!-- Notification Dropdown -->
                

                <!-- User Profile Icon -->
                <li class="nav-item dropdown">
                    <a href="#" data-bs-toggle="dropdown" class="nav-link pe-md-0 d-flex align-items-center">
                        <img src="/img/admin1.png" class="avatar img-fluid rounded-circle me-2" alt="Profile Image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end rounded">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit();">Logout</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
