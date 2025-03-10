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
            <a href="{{ url('/rhuhome') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        
        <li class="sidebar-item">
            <a href="{{ url('/rhupatientsnow') }}" class="sidebar-link">
                <i class="fa-solid fa-user-injured"></i>
                <span>Patient Records</span>
            </a>
        </li>
        <!-- Health Facilities -->
        <li class="sidebar-item">
            <a href="{{ url('/rhumorbidity') }}" class="sidebar-link">
                <i class="fas fa-virus"></i>
                <span>Morbidity Data</span>
            
            </a>
                   
        </li>

        <li class="sidebar-item">
            <a href="{{ url('/rhumortality') }}" class="sidebar-link">
                <i class="fas fa-skull-crossbones"></i>
                <span>Mortality Data</span>
            
            </a>
                   
        </li>
        <!-- Records -->
        <li class="sidebar-item">
            <a href="{{ url('/rhurequests') }}" class="sidebar-link">
                <i class="fa-solid fa-list-check"></i>
                <span>Mortality Requests</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ url('/submissionsrhu') }}" class="sidebar-link">
                <i class="fas fa-upload"></i>
                <span>Submissions</span>
            </a>
        </li>
        <!-- User with Dropdown (Accounts and Staffs) -->
        
    </ul>
</aside>
