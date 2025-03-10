@extends('masterpho.master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Notifications</h1>

        <!-- Notifications Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Notification Records</h5>
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <label for="entries" class="form-label">Show:</label>
                        <select id="entries" class="form-select d-inline-block w-auto">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        entries
                    </div>
                    <div>
                        <label for="search" class="form-label me-2">Search:</label>
                        <input type="text" id="search" class="form-control d-inline-block w-auto">
                    </div>
                </div>
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $notification)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $notification->sender->name ?? 'N/A' }}</td>
                                <td>{{ $notification->receiver->name ?? 'N/A' }}</td>
                                <td>{{ $notification->message }}</td>
                                <td>{{ $notification->date }}</td>
                                <td>
                                    <!-- Send Button (with icon) -->
                                    <a href="{{ route('notifications.send', $notification->id) }}"
                                        class="btn btn-sm btn-info" title="Send">
                                        <i class="fas fa-paper-plane" style="font-size: 18px;"></i>
                                    </a>

                                    <!-- Edit Button (with icon) -->
                                    <button class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit" style="font-size: 18px;"></i>
                                    </button>

                                    <!-- Delete Button (with icon) -->
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this notification?')"
                                            title="Delete">
                                            <i class="fas fa-trash" style="font-size: 18px;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No notifications available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">

                </div>

            </div>
        </div>
    </div>
@endsection
