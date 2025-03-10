@extends('masteradmin.master')
@section('title')
BSCRIM
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
              <h5 class="modal-title" id="exampleModalLabel">Add RHU</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('rhus.create') }}" method="POST">
              <div class="modal-body">
                  @csrf
                  <!-- RHU Name -->
                  <div class="mb-3">
                      <label for="rhu_name" class="form-label">RHU Name:</label>
                      <input type="text" name="rhu_name" class="form-control" required />
                  </div>

                  <!-- Municipality -->
                  
<div class="mb-3">
    <label for="municipality_id" class="form-label">Municipality:</label>
    <select name="municipality_id" id="municipality_id" class="form-control" required>
        <option value="">Select Municipality</option>
        @foreach($municipalities as $municipality)
            <option value="{{ $municipality->id }}">{{ $municipality->municipality_name }}</option>
        @endforeach
    </select>
</div>  
                <div class="mb-3" id="coordinatesField" style="display: none;">
                    <label for="coordinates" class="form-label">Coordinates:</label>
                    <div id="map" style="height: 300px; border: 1px solid #ccc;"></div>
                    <input type="hidden" name="coordinates" id="coordinates" class="form-control" />
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save RHU</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Update RHU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('rhus.update', ['id' => ':id']) }}" id="saveItem" method="POST">
                <div class="modal-body">
                    @csrf
                    <div id="errorMessage" class="alert alert-warning d-none"></div>

                    <!-- RHU ID -->
                    <div class="mb-3">
                        <label for="rhu_id">ID: </label>
                        <input type="number" name="rhu_id" id="rhu_id" class="form-control" required readonly />
                    </div>

                    <!-- RHU Name -->
                    <div class="mb-3">
                        <label for="rhu_name">RHU Name: </label>
                        <input type="text" name="rhu_name" id="rhu_name" class="form-control" required />
                    </div>

                    <!-- Municipality -->
                    
                    <div class="mb-3">
                        <label for="municipality_id_edit">Municipality:</label>
                        <select name="municipality_id" id="municipality_id_edit" class="form-control" required>
                            @foreach($municipalities as $municipality)
                                <option value="{{ $municipality->id }}">{{ $municipality->municipality_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updatedata" class="btn btn-primary">Save Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Location Modal -->
<!-- Location Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="locationModalLabel">View/Edit Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="mapView" style="height: 400px;"></div>
                <input type="hidden" id="coordinates" name="coordinates" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="editLocationBtn">Edit Location</button>
                <button type="button" class="btn btn-primary" data-id="" id="saveLocationBtn" data-bs-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>



<!-- DELETE POP UP FORM -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete RHU Data</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('rhus.delete', ['id' => ':id']) }}" id="saveItems" method="GET">
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
        <strong class='card-title'>RHU Records</strong>
        <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemAddModal" style="margin-left: 88%;">Add New</button>
    </div>
    <div class='card-body'>
        <div class='table-responsive'>
            <table id='bootstrap-data-table-export' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th class='text-nowrap'>ID</th>
                        <th class='text-nowrap'>RHU Name</th>
                        <th class='text-nowrap'>Municipality Name</th>
                        <th class='text-nowrap'>Coordinates</th>
                        <th class='text-nowrap'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('adminpages.partials.rhus', ['rhus' => $rhus])
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Page level plugins -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Page level plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script><script>
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

            var rhuId = data[0]; // Assuming ID is in the first column
            var delRoute = "{{ route('rhus.delete', ['id' => ':id']) }}";
            delRoute = delRoute.replace(':id', rhuId);
            $('#saveItems').attr('action', delRoute);
            
            $('#deletemodal').modal('show');
        });
    });
</script>

<!-- Edit Button Script -->
<script>
    $(document).ready(function() {
    $(document).on('click', '.editWorkerBtn', function() {
        var $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log("Edit button clicked. Data:", data);

        // Populate the modal fields
        $('#rhu_id').val(data[0]);
        $('#rhu_name').val(data[1]);
        var municipalityName = data[2];

        // Select the correct municipality
        $('#municipality_id_edit option').each(function () {
            if ($(this).text() === municipalityName) {
                $(this).prop('selected', true);
            }
        });

        // Set the form action URL
        var updateRoute = "{{ route('rhus.update', ['id' => ':id']) }}";
        updateRoute = updateRoute.replace(':id', data[0]);
        $('#saveItem').attr('action', updateRoute);

        // Show the modal
        $('#editmodal').modal('show');
    });
});

</script>
<script>
    $(document).ready(function() {
    console.log("Document is ready");

    $('#municipality_id').on('change', function() {
    var municipality_id = $(this).val();
    console.log("Municipality selected:", municipality_id);

    if (municipality_id) {
       
        $('#coordinatesField').show();
        console.log("Showing Barangay, Facility Name, and Coordinates fields");

       


        // Fetch municipality coordinates
        $.ajax({
            url: '/get-municipality-coordinates/' + municipality_id,
            method: 'GET',
            success: function(data) {
                console.log("Municipality coordinates:", data);
                if (map && data.coordinates) {
                    var coordinates = data.coordinates.split(','); // Assuming "100000,120000" format
                    var lat = parseFloat(coordinates[0]);
                    var lng = parseFloat(coordinates[1]);

                    // Set the map's view to the municipality's coordinates
                    map.setView([lat, lng], 12); // Adjust the zoom level as needed
                }
            },
            error: function(err) {
                console.error('Error fetching municipality coordinates:', err);
            }
        });

        // Initialize the map when it's unhidden
        if (!map) {
            console.log("Initializing map...");
            $('#coordinatesField').show();  // Ensure it's shown before initializing
            initializeMap(); // Initialize map if not already done
        }
    } else {
        
        $('#coordinatesField').hide();
        console.log("Hiding Barangay, Facility Name, and Coordinates fields");
    }
});

});
let map; // Declare map globally
let marker; // Declare marker globally

function initializeMap() {
    console.log("Initializing map...");
    map = L.map('map').setView([10.9165, 124.8447], 10); // Set initial view
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
    }).addTo(map);

    map.on('click', function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        console.log("Map clicked at:", lat, lng);

        // Remove existing marker
        if (marker) {
            map.removeLayer(marker);
        }

        // Add new marker
        marker = L.marker([lat, lng]).addTo(map);
        const coordinatesValue = `${lat},${lng}`;
    document.getElementById('coordinates').value = coordinatesValue;

    // Log when coordinates value is populated
    console.log("Coordinates value populated:", coordinatesValue);
    });
}

// Ensure map resizes correctly when the modal is shown
$('#itemAddModal').on('shown.bs.modal', function () {
    console.log("Modal shown");
    if (!map) {
        initializeMap(); // Initialize map if not already initialized
    } else {
        setTimeout(() => {
            map.invalidateSize(); // Adjust map size
            console.log("Map size invalidated");
        }, 100); // Small delay to ensure the container is fully visible
    }
});

// Clear map and coordinates when modal is closed
$('#itemAddModal').on('hidden.bs.modal', function () {
    console.log("Modal closed");
    if (marker) {
        map.removeLayer(marker);
        marker = null;
    }
    document.getElementById('coordinates').value = '';
});


    </script><script>
    let mapView; // Declare the map view for the modal
    let locationMarker; // Declare a marker for the location
    let isEditing = false; // Track whether the user is editing

    // Initialize map for viewing location
    function initializeMapView() {
        mapView = L.map('mapView').setView([10.9165, 124.8447], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(mapView);

        // Add event listener for map click when editing
        mapView.on('click', function (e) {
            if (isEditing) {
                const { lat, lng } = e.latlng;

                // Move the marker to the clicked location
                if (locationMarker) {
                    locationMarker.setLatLng([lat, lng]);
                } else {
                    locationMarker = L.marker([lat, lng]).addTo(mapView);
                }

                // Update the hidden input field with the new coordinates
                $('#coordinates').val(`${lat},${lng}`);
            }
        });
    }

    $(document).ready(function () {
        // When the location button is clicked
        $(document).on('click', '.locationWorkerBtn', function () {
            const $tr = $(this).closest('tr');
            const data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            const coordinates = data[3];
            const healthFacilityId = data[0]; // Assuming coordinates are in the 4th column
            console.log("Selected coordinates:", coordinates);
            console.log("Selected coordinates:", healthFacilityId);

            $('#saveLocationBtn').data('id', healthFacilityId);

            if (coordinates) {
                const [lat, lng] = coordinates.split(',').map(parseFloat);

                $('#locationModal').on('shown.bs.modal', function () {
                    // Ensure map is fully initialized and visible
                    setTimeout(() => {
                        mapView.invalidateSize(); // Adjust map size
                        // Set the map view to the coordinates
                        mapView.setView([lat, lng], 15);

                        // Add or update the marker
                        if (locationMarker) {
                            locationMarker.setLatLng([lat, lng]);
                        } else {
                            locationMarker = L.marker([lat, lng]).addTo(mapView);
                        }

                        // Set the hidden input field value
                        $('#coordinates').val(`${lat},${lng}`);
                    }, 100);
                });

                // Show the modal
                $('#locationModal').modal('show');
            } else {
                console.error("No coordinates available for this row.");
            }
        });

        // Initialize the map when the modal is shown
        $('#locationModal').on('shown.bs.modal', function () {
            if (!mapView) {
                initializeMapView();
            }
        });

        // Edit Location Button
        $('#editLocationBtn').on('click', function () {
            isEditing = true;
            Swal.fire({
    title: 'Notice!',
    text: 'Click on the map to update the marker location.',
    icon: 'info',
    confirmButtonText: 'Got it!'
});

        });

        // Save Location Button
        $('#saveLocationBtn').on('click', function () {
        isEditing = false;
    const updatedCoordinates = $('#coordinates').val();
    if (updatedCoordinates) {
        const healthFacilityId = $(this).data('id');
        $.ajax({
            url: '/update-location',
            method: 'POST',
            data: {
                id: healthFacilityId,
                coordinates: updatedCoordinates,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            },
            success: function (response) {
                if (response.status === 'success') {
                    // Fetch the updated table data
                    $.ajax({
                        url: '/fetch-rhus', // Controller method to fetch updated data
                        method: 'GET',
                        success: function (data) {
                            // Update the table body
                            $('table#bootstrap-data-table-export tbody').html(data);
                        },
                        error: function (xhr) {
                            console.error("Error fetching updated RHU data:", xhr.responseText);
                        }
                    });
                } else {
                    console.error("Error updating location:", response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Server response:", xhr.responseText);
            }
        });
    } else {
        console.error("Coordinates field is empty.");
    }
});


    });
</script>

    
    
    



@endsection
