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
            <a href="{{ url('/phohome') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ url('/phomorbidity') }}" class="sidebar-link">
                <i class="fas fa-virus"></i>
                <span>Morbidity Data</span>
            
            </a>
                   
        </li>

        <li class="sidebar-item">
            <a href="{{ url('/phomortality') }}" class="sidebar-link">
                <i class="fas fa-skull-crossbones"></i>
                <span>Mortality Data</span>
            
            </a>
                   
        </li>
        <!-- Health Facilities -->
       
        <!-- Records -->
        
        
        <li class="sidebar-item">
            <a href="{{ url('/submissions') }}" class="sidebar-link">
                <i class="fas fa-upload"></i>
                <span>Submissions</span>
            </a>
        </li>
    </ul>
</aside>
