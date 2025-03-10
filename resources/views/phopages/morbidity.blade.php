@extends('masterpho.master')
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

<div class="card">
    <div class="card-header">
        
        <div class="d-flex justify-content-between align-items-center p-3">
            <strong class="card-title fs-5">Provincial Morbidity Records</strong>
            <div>
                <button id="export-btn" class="btn btn-primary">Export to Excel</button>
                <button id="submit-btn" class="btn btn-success">Submit</button>
            </div>
        </div>
        
        <hr class="my-1" />
        <div class="row mb-2 mt-3">
            <div class="col-md-12">
                <strong>Filter By:</strong>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-2">
                <label for="municipality-select" class="form-label">Record Type:</label>
                
                <select name="municipality-select" id="municipality-select" class="form-select">

                    <option value="" selected>All Municipalities</option>
                    @foreach($municipalities as $municipality)
                        <option value="{{ $municipality->id }}">{{ $municipality->municipality_name }}</option>
                    @endforeach
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
                    <option value="" selected>All Genders</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="age-group-select" class="form-label">Age Group:</label>
                <select id="age-group-select" class="form-select">
                    <option value="" selected>All Age Groups</option>
                    <option value="age_0_9">0-9 Years</option>
                    <option value="age_10_19">10-19 Years</option>
                    <option value="age_20_59">20-59 Years</option>
                    <option value="age_60_above">60+ Years</option>
                </select>
            </div>
            
            
            
            
        </div>
    </div>
    
    
    

    <div class="card-body">
        <div class="table-responsive" id="patients-table-container">
            @include('phopages.partials.patients')
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#disease-data-table').DataTable();
    });

    document.getElementById('export-btn').addEventListener('click', function () {
    const table = document.getElementById('disease-data-table');
    const rows = table.querySelectorAll('tbody tr');

    const data = Array.from(rows).map(row => {
        const cells = row.querySelectorAll('td');
        return Array.from(cells).map(cell => cell.textContent.trim());
    });

    // Specify the type (e.g., "mortality")
    const reportType = 'morbidity'; // or "morbidity" as needed

    fetch('{{ route('export.disease.data') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ data, type: reportType })
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'DiseaseData.xlsx';
        a.click();
        window.URL.revokeObjectURL(url);
    })
    .catch(error => console.error('Error exporting data:', error));
});


</script>

<script>$(document).ready(function () {
    function applyFilters() {
        var table = $('#disease-data-table').DataTable();
        var selectedGender = $('#gender-select').val();
        var selectedAgeGroup = $('#age-group-select').val();

        // Define age group columns
        var ageGroupColumns = {
            'age_0_9': [2, 3],    // 0-9 M, 0-9 F
            'age_10_19': [4, 5],  // 10-19 M, 10-19 F
            'age_20_59': [6, 7],  // 20-59 M, 20-59 F
            'age_60_above': [8, 9] // 60+ M, 60+ F
        };

        // Reset visibility of all columns
        table.columns().visible(true);

        // Create a list of columns to hide based on gender
        var columnsToHide = [];

        if (selectedGender === 'male') {
            // Add all female-related columns to hide
            table.columns().every(function (index) {
                if (this.header().innerText.includes('F')) {
                    columnsToHide.push(index);
                }
            });
        } else if (selectedGender === 'female') {
            // Add all male-related columns to hide
            table.columns().every(function (index) {
                if (this.header().innerText.includes('M')) {
                    columnsToHide.push(index);
                }
            });
        }

        // Add age group columns to hide if an age group is selected
        if (selectedAgeGroup && ageGroupColumns[selectedAgeGroup]) {
            var allAgeColumns = [2, 3, 4, 5, 6, 7, 8, 9]; // All age-related columns
            var visibleAgeColumns = ageGroupColumns[selectedAgeGroup];

            // Add age-related columns not in the selected group to hide
            columnsToHide = columnsToHide.concat(
                allAgeColumns.filter(col => !visibleAgeColumns.includes(col))
            );
        }

        // Hide the determined columns
        table.columns(columnsToHide).visible(false);
    }

    $('#year-select, #month-select, #quarter-select, #gender-select, #municipality-select, #age-group-select').on('change', function () {
        var selectedYear = $('#year-select').val();
        var selectedMonth = $('#month-select').val() || null;
        var selectedQuarter = $('#quarter-select').val() || null;
        var selectedMunicipality = $('#municipality-select').val() || null;
        var selectedGender = $('#gender-select').val() || null;
        var selectedAgeGroup = $('#age-group-select').val() || null;

        $('#spinner').show();

        $.ajax({
            url: "{{ route('phopatient.now') }}",
            type: 'GET',
            data: {
                year: selectedYear,
                month: selectedMonth,
                quarter: selectedQuarter,
                gender: selectedGender,
                municipality_id: selectedMunicipality,
                age_group: selectedAgeGroup
            },
            success: function (response) {
                $('#patients-table-container').html(response);
                var table = $('#disease-data-table').DataTable();
                applyFilters(); // Apply combined filters
            },
            error: function () {
                alert('Failed to fetch data. Please try again.');
            },
            complete: function () {
                setTimeout(function () {
                    $('#spinner').hide();
                }, 300);
            }
        });
    });

    // Initial table load and filter application
    var table = $('#disease-data-table').DataTable();
    applyFilters();
});



</script><script>$(document).ready(function () {
    // Function to toggle the disabled state of the export button
    function toggleExportButton() {
        var selectedGender = $('#gender-select').val();
        var selectedAgeGroup = $('#age-group-select').val();

        // Define the conditions where the export button should be disabled
        var disableButton = (selectedGender && selectedGender !== '') || (selectedAgeGroup && selectedAgeGroup !== '');

        // Enable or disable the export button
        $('#export-btn').prop('disabled', disableButton);
    }

    // Bind change events to the dropdowns
    $('#gender-select, #age-group-select').on('change', function () {
        toggleExportButton();
    });

    // Initial check on page load
    toggleExportButton();
});
</script>
<script>
    document.getElementById('submit-btn').addEventListener('click', function () {
        fetch('/submit-record', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Record submitted successfully!');
            } else {
                alert('Failed to submit record.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    });
</script>

@endsection
