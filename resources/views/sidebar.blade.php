<aside id="sidebar">
    <div class="d-flex">
        <div class="sidebar-logo">
            <!-- Replace with your image logo -->
            <a href="#">
                <img src="/img/logo2.png" alt="Health Management Logo">
            </a>
        </div>
    </div>
    <hr class="sidebar-divider">
    <ul class="sidebar-nav">
        <!-- Home -->
        <li class="sidebar-item">
            <a href="{{ url('/rhuhome') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#user" aria-expanded="false" aria-controls="user">
                <i class="fas fa-heart"></i>
                <span>Consultations</span>
            </a>
            <ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{ url('/hfrecordsnow') }}" class="sidebar-link">This Month</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/hfrecords') }}" class="sidebar-link">All Time</a>
                </li>
            </ul>
        </li>

        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#user" aria-expanded="false" aria-controls="user">
                <i class="fas fa-hospital"></i>
                <span>Mortality</span>
            </a>
            <ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{ url('/hfrequests') }}" class="sidebar-link">Pending Requests</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/hfmortalitynow') }}" class="sidebar-link">This Month</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/hfmortality') }}" class="sidebar-link">All time</a>
                </li>
            </ul>
        </li>
        <!-- Records -->
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="fas fa-file-alt"></i>
                <span>Records</span>
            </a>
        </li>
        <!-- User with Dropdown (Accounts and Staffs) -->
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#user" aria-expanded="false" aria-controls="user">
                <i class="fas fa-user"></i>
                <span>User</span>
            </a>
            <ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">Accounts</a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">Staffs</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
