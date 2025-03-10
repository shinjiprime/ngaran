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
            <a href="{{ url('/staff') }}" class="sidebar-link">
                <i class="fas fa-user"></i>
                <span>Staff</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#user" aria-expanded="false" aria-controls="user">
                <i class="fas fa-heart"></i>
                <span>Diseases</span>
            </a>
            <ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{ url('/diseases') }}" class="sidebar-link">Disease</a>
                </li>
                <li class="sidebar-item">
                    <a href="/disease-groups" class="sidebar-link">Disease Groups</a>
                </li>
            </ul>
        </li>
        <!-- Health Facilities -->
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#user" aria-expanded="false" aria-controls="user">
                <i class="fas fa-hospital"></i>
                <span>Health Facilities</span>
            </a>
            <ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{ url('/health-facilities') }}" class="sidebar-link">Health Stations</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/rhus') }}" class="sidebar-link">RHUs</a>
                </li>
            </ul>
        </li>
        <!-- Records -->
        
        <!-- User with Dropdown (Accounts and Staffs) -->
        
    </ul>
</aside>
