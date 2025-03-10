@extends('masterrhu.master')

@section('content')
<div class="container">
    <h2>Staff Details</h2>
    @if($staff)
        <ul>
            <li><strong>First Name:</strong> {{ $staff->staff_fname }}</li>
            <li><strong>Middle Name:</strong> {{ $staff->staff_mname }}</li>
            <li><strong>Last Name:</strong> {{ $staff->staff_lname }}</li>
            <li><strong>Extension:</strong> {{ $staff->staff_extension ?? 'N/A' }}</li>
            <li><strong>Email:</strong> {{ $staff->email }}</li>
            <li><strong>Health Facility ID:</strong> {{ $staff->health_facility }}</li>
            <li><strong>Health Facility Name:</strong> {{ $staff->healthFacility->facility_name ?? 'N/A' }}</li>
        </ul>
    @else
        <p>No staff details found.</p>
    @endif
</div>
@endsection
