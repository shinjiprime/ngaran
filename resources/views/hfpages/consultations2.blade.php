@extends('masterhf.master')
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
                <h5 class="modal-title" id="exampleModalLabel">Add Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPatientForm" action="{{ route('patients.create') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <!-- Full Name Fields (First Name, Middle Initial, Last Name) -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="patient_fname" class="form-label">First Name:</label>
                            <input type="text" name="patient_fname" class="form-control" required />
                        </div>
                        <div class="col-md-4">
                            <label for="patient_minitial" class="form-label">Middle Initial:</label>
                            <input type="text" name="patient_minitial" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label for="patient_lname" class="form-label">Last Name:</label>
                            <input type="text" name="patient_lname" class="form-control" required />
                        </div>
                    </div>

                    <!-- Patient Extension -->
                    <div class="mb-3">
                        <label for="patient_extension" class="form-label">Extension (e.g., Jr., Sr.):</label>
                        <input type="text" name="patient_extension" class="form-control" />
                    </div>

                    <!-- Disease Code -->
                    <div class="mb-3">
                        <label for="disease_code" class="form-label">Disease Code:</label>
                        <select name="disease_code" id="disease_code" class="form-select select2-disease" required>
                            <option value="">Select Disease Code</option>
                            @foreach($diseases as $disease)
                                <option value="{{ $disease->disease_code }}">{{ $disease->disease_code }} - {{ $disease->disease_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Age, Age Unit, and Gender in One Row -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="age" class="form-label">Age:</label>
                            <input type="number" name="age" class="form-control" required />
                        </div>
                        <div class="col-md-4">
                            <label for="age_unit" class="form-label">Age Unit:</label>
                            <select name="age_unit" class="form-select" required>
                                <option value="years">Years</option>
                                <option value="months">Months</option>
                                <option value="days">Days</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender:</label>
                            <select name="gender" class="form-select" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="inactive" selected>Inactive</option>
                            
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Item -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('patients.update', ['id' => ':id']) }}" id="saveItem" method="POST">
                <div class="modal-body">
                    @csrf
                    <div id="errorMessage" class="alert alert-warning d-none"></div>
                    <input type="hidden" name="staff_id" value="{{ session('staff_id') }}">
                    <!-- Patient ID -->
                    <div class="mb-3">
                        <label for="patients_id">ID: </label>
                        <input type="number" name="patients_id" id="patients_id" class="form-control" required readonly />
                    </div>

                    <!-- Patient First Name -->
                    <div class="mb-3">
                        <label for="patient_fname">First Name: </label>
                        <input type="text" name="patient_fname" id="patient_fname" class="form-control" required />
                    </div>

                    <!-- Patient Middle Initial -->
                    <div class="mb-3">
                        <label for="patient_minitial">Middle Initial: </label>
                        <input type="text" name="patient_minitial" id="patient_minitial" class="form-control" />
                    </div>

                    <!-- Patient Last Name -->
                    <div class="mb-3">
                        <label for="patient_lname">Last Name: </label>
                        <input type="text" name="patient_lname" id="patient_lname" class="form-control" required />
                    </div>

                    <!-- Patient Extension -->
                    <div class="mb-3">
                        <label for="patient_extension">Extension: </label>
                        <input type="text" name="patient_extension" id="patient_extension" class="form-control" />
                    </div>

                    

                    <div class="mb-3">
                        <label for="disease_code">Disease Code:</label>
                        <select name="disease_code" id="edit_disease_code" class="form-select " required>
                            <option value="">Select Disease Code</option>
                            @foreach($diseases as $disease)
                                <option value="{{ $disease->disease_code }}">{{ $disease->disease_code }} - {{ $disease->disease_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Staff ID -->
                   

                    <!-- Date -->
                    <div class="mb-3">
                        <label for="date">Date: </label>
                        <input type="date" name="date" id="date" class="form-control" required />
                    </div>

                    <!-- Age -->
                    <div class="mb-3">
                        <label for="age">Age: </label>
                        <input type="number" name="age" id="age" class="form-control" required />
                    </div>

                    <!-- Age Unit -->
                    <div class="mb-3">
                        <label for="age_unit">Age Unit: </label>
                        <select name="age_unit" id="age_unit" class="form-select" required>
                            <option value="years">Years</option>
                            <option value="months">Months</option>
                            <option value="days">Days</option>
                        </select>
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label for="gender">Gender: </label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="inactive" selected>Inactive</option>
                            
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updatedata" class="btn btn-primary">Save Patient</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Delete Patient Data</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('patients.delete', ['id' => ':id']) }}" id="saveItems" method="GET">
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

<div class="card">
    <div class='card-header'>
        <strong class='card-title'>{{ session('facility_name') }} Pending Mortality Records</strong>
        <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemAddModal" style="margin-left: 88%;">Add New</button>
    </div>
    <div class='card-body'>
        <div class='table-responsive'>
            <table id='bootstrap-data-table-export' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th class='text-nowrap'>ID</th>
                        <th class='text-nowrap'>First Name</th>
                        <th class='text-nowrap'>Middle Initial</th>
                        <th class='text-nowrap'>Last Name</th>
                        <th class='text-nowrap'>Extension</th>
                        <th class='text-nowrap'>Disease Code</th>
                        <th class='text-nowrap'>Disease Name</th>
                        <th class='text-nowrap'>Date</th>
                        <th class='text-nowrap'>Age</th>
                        <th class='text-nowrap'>Age Unit</th>
                        <th class='text-nowrap'>Gender</th>
                        <th class='text-nowrap'>Status</th>
                        <th class='text-nowrap'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->patients_id }}</td>
                        <td>{{ $patient->patient_fname }}</td>
                        <td>{{ $patient->patient_minitial }}</td>
                        <td>{{ $patient->patient_lname }}</td>
                        <td>{{ $patient->patient_extension }}</td>
                        <td>{{ $patient->disease_code }}</td>
                        <td>{{ $patient->disease->disease_name ?? 'N/A' }}</td>
                        <td>{{ $patient->date }}</td>
                        <td>{{ $patient->age }}</td>
                        <td>{{ $patient->age_unit }}</td>
                        <td>{{ $patient->gender }}</td>
                        <td>{{ $patient->status }}</td>
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

<!-- Page level plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#bootstrap-data-table-export').DataTable();
});


</script><script>
    $(document).ready(function () {
        // Initialize Select2 globally
        $('.select2-disease').select2({
            placeholder: "Search for a Disease Code",
            allowClear: true,
            theme: "bootstrap-5"
        });

        // Re-initialize Select2 when the modal is shown
        $('#itemAddModal').on('shown.bs.modal', function () {
            $('.select2-disease').select2({
                placeholder: "Search for a Disease Code",
                allowClear: true,
                theme: "bootstrap-5",
                dropdownParent: $('#itemAddModal') // Ensure the dropdown is attached to the modal
            });
        });
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
            $('#del').val(data[0]); // Assuming patients_id is in the first column

            var patientId = data[0]; // Use the ID of the patient
            var actionUrl = '{{ route("patients.delete", ["id" => ":id"]) }}'.replace(':id', patientId);
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

            $('#patients_id').val(data[0]);
            $('#patient_fname').val(data[1]);
            $('#patient_minitial').val(data[2]);
            $('#patient_lname').val(data[3]);
            $('#patient_extension').val(data[4]);
            $('#edit_disease_code').val(data[5]).trigger('change');
           
            $('#date').val(data[7]);
            $('#age').val(data[8]);
            $('#age_unit').val(data[9]);
            $('#gender').val(data[10]);
            $('#status').val(data[11]);

            var patientId = data[0]; // Use the ID of the patient
            var actionUrl = '{{ route("patients.update", ["id" => ":id"]) }}'.replace(':id', patientId);
            $('#saveItem').attr('action', actionUrl);
            $('#editmodal').modal('show');
        });
    });
</script>
<script>
    // Clear the Add Modal form when it is closed
    document.getElementById('itemAddModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('addPatientForm').reset();
    });
</script>


@endsection
