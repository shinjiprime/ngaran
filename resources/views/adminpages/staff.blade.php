@extends('masteradmin.master')
@section('title')
BS
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
<!-- Updated Add Staff Modal -->
<div class="modal fade" id="itemAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Staff</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addPatientForm" action="{{ route('staff.create') }}" method="POST">
          <div class="modal-body">
            @csrf
            <!-- Staff Details -->
            <div class="mb-3">
              <label for="staff_fname" class="form-label">First Name:</label>
              <input type="text" name="staff_fname" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="staff_mname" class="form-label">Middle Name:</label>
              <input type="text" name="staff_mname" class="form-control" />
            </div>
            <div class="mb-3">
              <label for="staff_lname" class="form-label">Last Name:</label>
              <input type="text" name="staff_lname" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="staff_extension" class="form-label">Extension:</label>
              <input type="text" name="staff_extension" class="form-control" />
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" name="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="text" name="phone_number" class="form-control" required />
              </div>
              
              <div class="mb-3">
                <label for="health_facility" class="form-label">Health Facility:</label>
                <select name="health_facility" class="form-control" required>
                    <option value="" disabled selected>Select a Health Facility</option>
                    @foreach($healthFacilities as $facility)
                        <option value="{{ $facility->facility_id }}">{{ $facility->facility_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="rhu_id" class="form-label">RHU:</label>
                <select name="rhu_id" class="form-control">
                    <option value="" disabled selected>Select an RHU</option>
                    @foreach($rhus as $rhu)
                        <option value="{{ $rhu->rhu_id }}">{{ $rhu->rhu_name }}</option>
                    @endforeach
                </select>
            </div>
            
  
            <!-- User Account Details -->
            <h6 class="mt-3">User Account</h6>
            <div class="mb-3">
              <label for="username" class="form-label">Username:</label>
              <input type="text" name="username" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input type="password" name="password" class="form-control" required />
            </div>
           
            <div class="mb-3">
                <label for="user_level" class="form-label">User Level:</label>
                <select name="user_level" class="form-control" required>
                    <option value="1">Admin</option>
                    <option value="2">PHO Staff</option>
                    <option value="3">RHU Staff</option>
                    <option value="4">DH/BHS Staff</option>
                </select>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  
  <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('staff.update', ['id' => ':id']) }}" id="saveItem" method="POST">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Staff Fields -->
                    <input type="hidden" id="staff_id" name="staff_id">
                    <div class="mb-3">
                        <label for="staff_fname" class="form-label">First Name:</label>
                        <input type="text" id="staff_fname" name="staff_fname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="staff_mname" class="form-label">Middle Name:</label>
                        <input type="text" id="staff_mname" name="staff_mname" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="staff_lname" class="form-label">Last Name:</label>
                        <input type="text" id="staff_lname" name="staff_lname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="staff_extension" class="form-label">Extension:</label>
                        <input type="text" id="staff_extension" name="staff_extension" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number:</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                      </div>
                      
                      <div class="mb-3">
                        <label for="health_facility" class="form-label">Health Facility:</label>
                        <select id="health_facility" name="health_facility" class="form-control" required>
                            @foreach($healthFacilities as $facility)
                                <option value="{{ $facility->facility_id }}" 
                                   >
                                    {{ $facility->facility_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rhu_id" class="form-label">RHU:</label>
                        <select id="rhu_id" name="rhu_id" class="form-control" required>
                            @foreach($rhus as $rhu)
                                <option value="{{ $rhu->rhu_id }}" 
                                   >
                                    {{ $rhu->rhu_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    
                    

                    <!-- User Fields -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_level" class="form-label">User Level:</label>
                        <select name="user_level" id="user_level" class="form-control" required>
                            <option value="1">Admin</option>
                            <option value="2">PHO Staff</option>
                            <option value="3">RHU Staff</option>
                            <option value="4">DH/BHS Staff</option>
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Delete Staff Data</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('staff.delete', ['id' => ':id']) }}" id="saveItems" method="GET">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="del" id="del">
                    <h4>Do you want to delete this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                    <button type="submit" name="submit" class="btn btn-primary">Yes!! Delete it.</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePasswordForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="password_staff_id" name="staff_id">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password:</label>
                        <input type="password" id="new_password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="card">
    <div class='card-header'>
        <strong class='card-title'>Staff Records</strong>
        <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemAddModal" style="margin-left: 88%;">Add New</button>
    </div>
    <div class='card-body'>
        <div class='table-responsive'>
            <table id='bootstrap-data-table-export' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th class='text-nowrap'>ID</th>
                        <th class='text-nowrap'>First Name</th>
                        <th class='text-nowrap'>Middle Name</th>
                        <th class='text-nowrap'>Last Name</th>
                        <th class='text-nowrap'>Extension</th>
                        <th class='text-nowrap'>Email</th>
                        <th class='text-nowrap'>Phone Number</th>

                        <th class='text-nowrap'>Health Facility</th>
                        <th class='text-nowrap'>RHU ID</th> <!-- New column -->
                        <th class='text-nowrap'>Username</th>
                        <th class='text-nowrap'>User Level</th>
                        <th class='text-nowrap'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $member)
                    <tr>
                        <td>{{ $member->staff_id }}</td>
                        <td>{{ $member->staff_fname }}</td>
                        <td>{{ $member->staff_mname }}</td>
                        <td>{{ $member->staff_lname }}</td>
                        <td>{{ $member->staff_extension }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone_number }}</td>
                        <td>{{ $member->health_facility }}</td>
                        <td>{{ $member->rhu_id }}</td> <!-- Display RHU ID -->
                        <td>{{ $member->user->username ?? 'N/A' }}</td>
                        <td>{{ $member->user->user_level ?? 'N/A' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="editWorkerBtn btn btn-success btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
                                <button type="button" class="deleteWorkerBtn btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                <button type="button" class="changePasswordBtn btn btn-warning btn-sm"><i class="fa fa-key" aria-hidden="true"></i></button>
    
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
<script>
$(document).ready(function() {
    $('#bootstrap-data-table-export').DataTable();
});
</script>
<script>$(document).on('click', '.editWorkerBtn', function() {
    var row = $(this).closest('tr');
    var staff_id = row.find('td:eq(0)').text();
    var staff_fname = row.find('td:eq(1)').text();
    var staff_mname = row.find('td:eq(2)').text();
    var staff_lname = row.find('td:eq(3)').text();
    var staff_extension = row.find('td:eq(4)').text();
    var email = row.find('td:eq(5)').text();
    var phone_number = row.find('td:eq(6)').text();
    var health_facility = row.find('td:eq(7)').text();
    var rhu_id = row.find('td:eq(8)').text(); // Get RHU ID
    var username = row.find('td:eq(9)').text();
    var user_level = row.find('td:eq(10)').text();

    $('#staff_id').val(staff_id);
    $('#staff_fname').val(staff_fname);
    $('#staff_mname').val(staff_mname);
    $('#staff_lname').val(staff_lname);
    $('#staff_extension').val(staff_extension);
    $('#email').val(email);
    $('#phone_number').val(phone_number);
    $('#health_facility').val(health_facility);
    $('#rhu_id').val(rhu_id); // Set RHU ID
    $('#username').val(username);
    $('#user_level').val(user_level);

    var formAction = "{{ route('staff.update', ':id') }}".replace(':id', staff_id);
    $('#saveItem').attr('action', formAction);

    $('#editmodal').modal('show');
});



$(document).on('click', '.deleteWorkerBtn', function() {
    var row = $(this).closest('tr');
    var staff_id = row.find('td:eq(0)').text();

    $('#del').val(staff_id);
    var formAction = "{{ route('staff.delete', ['id' => ':id']) }}".replace(':id', staff_id);
    $('#saveItems').attr('action', formAction);

    $('#deletemodal').modal('show');
});

$(document).on('click', '.changePasswordBtn', function() {
    var row = $(this).closest('tr');
    var staff_id = row.find('td:eq(0)').text();

    $('#password_staff_id').val(staff_id);
    // alert($('#password_staff_id').val());
    var formAction = "{{ route('staff.changePassword', ':id') }}".replace(':id', staff_id);
    $('#changePasswordForm').attr('action', formAction);

    $('#changePasswordModal').modal('show');
});

</script>

<script>
    console.log('The Add Patient form has been reset.');
    // Clear the Add Modal form when it is closed
    document.getElementById('itemAddModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('addPatientForm').reset();
        console.log('The Add Patient form has been reset.');
    });
</script>
@endsection
