@extends('masterrhu.master')
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
            <form action="{{ route('patients.create') }}" method="POST">
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
                        <select name="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="deceased">Deceased</option>
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
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status">Status: </label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Deceased</option>
                            
                            
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
        <div class="d-flex justify-content-between align-items-center p-3">
            <strong class="card-title fs-5">{{ session('facility_name') }} Patient Records</strong>
            <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemAddModal">
                Add New
            </button>
        </div>
        

        <hr class="my-1" />
        <div class="row mb-2 mt-3">
            <div class="col-md-12">
                <strong>Filter By:</strong>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4">
                <label for="status-select" class="form-label">Record Type:</label>
                <select id="status-select" class="form-select">
                    <option value="" selected>All Records</option>
                    <option value="active">Active (Morbidity)</option>
                    <option value="deceased">Deceased (Mortality)</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="year-select" class="form-label">Year:</label>
            <select id="year-select" class="form-select">
                @for($year = now()->year; $year >= now()->year - 10; $year--)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endfor
            </select>
            </div>
            <div class="col-md-2">
                <label for="month-select" class="form-label">Month:</label>
                <select id="month-select" class="form-select">
                    <option value="" selected>All Months</option>
                    @for($month = 1; $month <= 12; $month++)
                        <option value="{{ $month }}">{{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label for="quarter-select" class="form-label">Quarter:</label>
                <select id="quarter-select" class="form-select">
                    <option value="" selected>All Quarters</option>
                    <option value="Q1">Q1 (First Quarter: Jan, Feb, Mar)</option>
                    <option value="Q2">Q2 (Second Quarter: Apr, May, Jun)</option>
                    <option value="Q3">Q3 (Third Quarter: Jul, Aug, Sep)</option>
                    <option value="Q4">Q4 (Fourth Quarter: Oct, Nov, Dec)</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="gender-select" class="form-label">Gender:</label>
                <select id="gender-select" class="form-select">
                    <option value="" selected>All</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            
            
            
        </div>
        
    </div>
    <div id="spinner" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    
    
    <div class='card-body'>
        <div class="table-responsive" id="patients-table-container">
            @include('rhupages.partials.patients')
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
<script>$(document).ready(function () {
    // Trigger AJAX when year, quarter, gender, month, or status changes
    $('#year-select, #month-select, #quarter-select, #gender-select, #status-select').on('change', function () {
        var selectedYear = $('#year-select').val();
        var selectedMonth = $('#month-select').val() || null; // Null if no month is selected
        var selectedQuarter = $('#quarter-select').val() || null; // Null if "All Quarters" is selected
        var selectedGender = $('#gender-select').val() || null; // Null if "All" is selected
        var selectedStatus = $('#status-select').val() || null; // Null if "All Statuses" is selected

        // Show the spinner
        $('#spinner').show();

        // Start AJAX request
        $.ajax({
            url: "{{ route('rhupatient.now') }}", // Update this to match your route
            type: 'GET',
            data: { 
                year: selectedYear, 
                month: selectedMonth,
                quarter: selectedQuarter,
                gender: selectedGender,
                status: selectedStatus 
            },
            success: function (response) {
                // Update the table container with new data
                $('#patients-table-container').html(response);

                // Reinitialize DataTable after replacing the content
                $('#bootstrap-data-table-export').DataTable();
            },
            error: function () {
                alert('Failed to fetch data. Please try again.');
            },
            complete: function () {
                // Hide the spinner after 1 second
                setTimeout(function () {
                    $('#spinner').hide();
                }, 300);
            }
        });
    });
});



</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Simulate loading delay
        setTimeout(function () {
            // Hide loading spinner
            document.getElementById('loading').style.display = 'none';
            // Show the table
            document.getElementById('patients-table-container').style.display = 'table';
        }, 1000); // 1-second delay
    });
</script>


@endsection
