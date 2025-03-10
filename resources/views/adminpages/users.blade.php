@extends('masteradmin.master')
@section('title')
@endsection
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Add Modal -->
<div class="modal fade" id="itemAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.create') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" required />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>

                    <!-- User Level -->
 <!-- User Level -->
<div class="mb-3">
    <label for="user_level" class="form-label">User Level:</label>
    <select name="user_level" class="form-control" required>
        <option value="1">Admin</option>
        <option value="2">PHO Staff</option>
        <option value="3">RHU Staff</option>
        <option value="4">DH/BHS Staff</option>
    </select>
</div>



                    <!-- Staff ID -->
                    <div class="mb-3">
                        <label for="staff_id" class="form-label">Staff ID:</label>
                        <input type="text" name="staff_id" class="form-control" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update User -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.update', ['id' => ':id']) }}" id="saveItem" method="POST">
                <div class="modal-body">
                    @csrf
                    <div id="errorMessage" class="alert alert-warning d-none"></div>

                    <!-- Staff ID -->
                    <div class="mb-3">
                        <label for="staff_id">Staff ID: </label>
                        <input type="text" name="staff_id" id="staff_id" class="form-control" required readonly />
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username">Username: </label>
                        <input type="text" name="username" id="username" class="form-control" required />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" class="form-control" required />
                    </div>

                    <!-- User Level -->
                   
                    <div class="mb-3">
                        <label for="user_level" class="form-label">User Level:</label>
                        <select name="user_level" id="user_level class="form-control" required>
                            <option value="1">Admin</option>
                            <option value="2">PHO Staff</option>
                            <option value="3">RHU Staff</option>
                            <option value="4">DH/BHS Staff</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updatedata" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE POP UP FORM -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User Data</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.delete', ['id' => ':id']) }}" id="saveItems" method="GET">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="del" id="del">
                    <h4>Do you want to delete this user data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                    <button type="submit" name="submit" class="btn btn-primary">Yes!! Delete it.</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class='card-header'>
        <strong class='card-title'>User Records</strong>
        <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemAddModal" style="margin-left: 88%;">Add New</button>
    </div>
    <div class='card-body'>
        <div class='table-responsive'>
            <table id='bootstrap-data-table-export' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th class='text-nowrap'>Staff ID</th>
                        <th class='text-nowrap'>Username</th>
                        <th class='text-nowrap'>User Level</th>
                        <th class='text-nowrap'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->staff_id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->user_level }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="editWorkerBtn btn btn-success btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
                                <button type="button" class="deleteWorkerBtn btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Page level plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#bootstrap-data-table-export').DataTable();
});
</script>

<!-- Delete Button Script -->
<script>
    $(document).ready(function () {
        $(document).on('click', '.deleteWorkerBtn', function() {
            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            $('#del').val(data[1]);

            var staffId = data[0]; // Assuming staff_id is in the first column
            var actionUrl = '{{ route("users.delete", ["id" => ":id"]) }}'.replace(':id', staffId);
            $('#saveItems').attr('action', actionUrl);
            $('#deletemodal').modal('show');
        });
    });
</script>

<!-- Edit Button Script -->
<script>
    $(document).ready(function () {
        $(document).on('click', '.editWorkerBtn', function() {
            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            $('#staff_id').val(data[0]);
            $('#username').val(data[1]);
            $('#user_level').val(data[2]);

            var staffId = data[0]; // Assuming staff_id is in the first column
            var actionUrl = '{{ route("users.update", ["id" => ":id"]) }}'.replace(':id', staffId);
            $('#saveItem').attr('action', actionUrl);
            $('#editmodal').modal('show');
        });
    });
</script>
@endsection
