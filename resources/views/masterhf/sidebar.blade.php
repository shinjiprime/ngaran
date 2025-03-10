<aside id="sidebar">
    <div class="d-flex">
        <div class="sidebar-logo">
            <!-- Replace with your image logo -->
            <a href="#">
                <img src="/img/logo2.png" alt="Health Management Logo">
            </a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <!-- Home -->
        <li class="sidebar-item">
            <a href="{{ url('/hfhome') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        
        <li class="sidebar-item">
            <a href="{{ url('/hfrecordsnow') }}" class="sidebar-link">
                <i class="fa-solid fa-user-injured"></i>
                <span>Patient Records</span>
            </a>
        </li>
      
        <!-- Records -->
        <li class="sidebar-item">
            <a href="{{ url('/hfrequests') }}" class="sidebar-link">
                <i class="fa-solid fa-list-check"></i>
                <span>Pending Requests</span>
            </a>
        </li>
        <!-- User with Dropdown (Accounts and Staffs) -->
        
    </ul>
</aside>
