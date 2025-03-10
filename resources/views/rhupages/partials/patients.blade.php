<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Middle Initial</th>
            <th>Last Name</th>
            <th>Extension</th>
            <th>Disease Code</th>
            <th>Disease Name</th>
            <th>Date</th>
            <th>Age</th>
            <th>Age Unit</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Action</th>
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
                <td>{{ ucfirst($patient->status) }}</td>
                <td>
                    @if($patient->status !== 'deceased')
                        <div class="btn-group">
                            <button type="button" class="editWorkerBtn btn btn-success btn-sm">Edit</button>
                            <button type="button" class="deleteWorkerBtn btn btn-danger btn-sm">Delete</button>
                        </div>
                    @else
                        <span class="text-muted">No Actions</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
