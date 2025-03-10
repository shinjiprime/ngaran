


<li class="nav-item dropdown me-3">
    <a href="#" class="nav-link position-relative" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell fa-lg"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $unreadNotifications->count() }}
            <span class="visually-hidden">unread messages</span>
        </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end rounded notifications-container" aria-labelledby="navbarDropdown">
       <!-- Unread Notifications -->
<li>
    <h6 class="dropdown-header">Notifications</h6>
</li>
@forelse($unreadNotifications as $notification)
    <li>
        <a class="dropdown-item notification-item" 
           href="#" 
           data-id="{{ $notification->id }}" 
           data-date="{{ $notification->created_at }}" 
           data-message="{{ $notification->message }}">
            <i class="fas fa-circle text-primary me-2"></i>{{ $notification->message }}
        </a>
    </li>
@empty
    <li>
        <p class="dropdown-item text-muted">No unread notifications</p>
    </li>
@endforelse

<hr class="dropdown-divider">

<!-- Read Notifications -->
<li>
    <h6 class="dropdown-header">Read Notifications</h6>
</li>
@forelse($readNotifications as $notification)
    <li>
        <a class="dropdown-item read-notification-item" 
           href="#" 
           data-id="{{ $notification->id }}" 
           data-date="{{ $notification->created_at }}" 
           data-message="{{ $notification->message }}">
            <i class="fas fa-check-circle text-secondary me-2"></i>{{ $notification->message }}
        </a>
    </li>
@empty
    <li>
        <p class="dropdown-item text-muted">No read notifications</p>
    </li>
@endforelse
<li>
    <a id="delete-read-notifications" class="dropdown-item text-center" href="#">Delete All Read Notifications</a>
</li>

    </ul>
</li>
