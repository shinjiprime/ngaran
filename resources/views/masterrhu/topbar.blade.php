<!-- Navbar -->
<nav class="navbar navbar-expand-lg" style="background-color: rgb(19, 159, 57);">
    <div class="container-fluid">
        <button class="toggle-btn" type="button">
            <i class="fas fa-bars" style="color: white;"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <!-- Notification Dropdown -->
                
                @include('masterrhu.partials.notifications')
            </ul>

            <!-- Modal -->
            <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="notificationModalLabel">Notification Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Date:</strong> <span id="notificationDate"></span></p>
                            <p><strong>From:</strong> <span>Provincial Health Office of Leyte</span></p>
                            <p><strong>Message:</strong> <span id="notificationMessage"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Profile Icon -->
            <li class="nav-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-link pe-md-0 d-flex align-items-center">
                    <img src="/img/admin1.png" class="avatar img-fluid rounded-circle me-2" alt="Profile Image">
                </a>
                <div class="dropdown-menu dropdown-menu-end rounded">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                        data-bs-target="#profileModal">Profile</a>
                    <!-- Change Password Dropdown -->
                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                        data-bs-target="#changePasswordModal">Change Password</a>
                    <!-- Logout Button -->
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </li>
        </div>
    </div>
    
<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="profileName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="profileName" readonly>
                </div>
                <div class="mb-3">
                    <label for="profileEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="profileEmail" readonly>
                </div>
                <div class="mb-3">
                    <label for="profilePhone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="profilePhone" readonly>
                </div>
                <div class="mb-3">
                    <label for="profileHealthFacility" class="form-label">Rural Health Unit:</label>
                    <input type="text" class="form-control" id="profileHealthFacility" readonly>
                </div>
                <div class="mb-3">
                    <label for="profileRHU" class="form-label">Municipality</label>
                    <input type="text" class="form-control" id="profileRHU" readonly>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Change Password Form -->
                <form action="{{ route('user.changePassword') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
                
        </div>
    </div>
</div>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            `,
        });
    </script>
@endif


<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const profileModal = document.getElementById('profileModal');

        profileModal.addEventListener('show.bs.modal', () => {
            fetch("{{ route('profile.fetch') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById('profileName').value = data.full_name;
                        document.getElementById('profileEmail').value = data.email;
                        document.getElementById('profilePhone').value = data.phone_number;
                        document.getElementById('profileHealthFacility').value = data.health_facility;
                        document.getElementById('profileRHU').value = data.rhu_name;
                    }
                })
                .catch(error => console.error('Error fetching profile data:', error));
        });
    });
</script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notificationItems = document.querySelectorAll('.notification-item, .read-notification-item');

            notificationItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();

                    const notificationId = this.dataset.id;
                    const notificationDate = this.dataset.date;
                    const notificationMessage = this.dataset.message;

                    if (this.classList.contains('notification-item')) {
                        // Mark unread notification as read
                        fetch(`/notifications/read/${notificationId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update UI for unread notification
                                this.classList.replace('notification-item', 'read-notification-item');
                                this.classList.add('text-muted');
                                this.querySelector('.fa-circle').classList.replace('text-primary', 'text-secondary');

                                const unreadCountElement = document.querySelector('.badge.bg-danger');
                    const currentUnreadCount = parseInt(unreadCountElement.textContent.trim(), 10);
                    unreadCountElement.textContent = Math.max(currentUnreadCount - 1, 0);

                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }

                    // Show modal with notification details
                    document.getElementById('notificationDate').textContent = notificationDate;
                    document.getElementById('notificationMessage').textContent = notificationMessage;

                    const notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
                    notificationModal.show();
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteReadNotificationsButton = document.getElementById('delete-read-notifications');
            const notificationsContainer = document.querySelector('.navbar-nav.ms-auto.d-flex.align-items-center');
    
            deleteReadNotificationsButton.addEventListener('click', function (e) {
                e.preventDefault();
    
                // Delete read notifications
                fetch('{{ route('notifications.deleteRead') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }); // Optional: Show success message
    
                        // Refresh the notifications dropdown
                        fetch('{{ route('notifications.refresh') }}')
                            .then(response => response.text())
                            .then(html => {
                                notificationsContainer.innerHTML = html;
                            })
                            .catch(error => console.error('Error refreshing notifications:', error));
                    }
                })
                .catch(error => console.error('Error deleting notifications:', error));
            });
        });
    </script>
    
   
</nav>
