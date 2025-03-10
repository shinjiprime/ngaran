@extends('masteradmin.master')  
@section('title')
Municipalities Management
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
              <h5 class="modal-title" id="exampleModalLabel">Add Municipality</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('municipalities.create') }}" method="POST">
              <div class="modal-body">
                  @csrf

                  <!-- Municipality Name -->
                  <div class="mb-3">
                      <label for="municipality_name" class="form-label">Municipality Name:</label>
                      <input type="text" name="municipality_name" class="form-control" required />
                  </div>

                  <!-- Coordinates -->
                  <div class="mb-3">
                    <label for="coordinates" class="form-label">Coordinates:</label>
                    <div id="map" style="height: 300px; border: 1px solid #ccc;"></div>
                    <input type="hidden" name="coordinates" id="coordinates" class="form-control" required />
                </div>
                
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Municipality</button>
              </div>
          </form>
      </div>
  </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Municipality</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('municipalities.update', ['id' => ':id']) }}" id="saveItem" method="POST">
                <div class="modal-body">
                    @csrf
                    <div id="errorMessage" class="alert alert-warning d-none"></div>

                    <!-- Municipality Name -->
                    <div class="mb-3">
                        <label for="municipality_name_edit">Municipality Name:</label>
                        <input type="text" name="municipality_name" id="municipality_name_edit" class="form-control" required />
                    </div>

                    <!-- Coordinates -->
                    <div class="mb-3">
                        <label for="coordinates_edit">Coordinates:</label>
                        <input type="text" name="coordinates" id="coordinates_edit" class="form-control" required />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updatedata" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Municipality</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('municipalities.delete', ['id' => ':id']) }}" id="saveItems" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="del" id="del">
                    <h4>Do you want to delete this municipality?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" name="submit" class="btn btn-primary">Yes! Delete it.</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class='card-header'>
        <strong class='card-title'>Municipalities</strong>
        <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemAddModal" style="margin-left: 88%;">Add New</button>
    </div>
    <div class='card-body'>
        <div class='table-responsive'>
            <table id='bootstrap-data-table-export' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th class='text-nowrap'>ID</th>
                        <th class='text-nowrap'>Municipality Name</th>
                        <th class='text-nowrap'>Coordinates</th>
                        <th class='text-nowrap'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($municipalities as $municipality)
                    <tr>
                        <td>{{ $municipality->id }}</td>
                        <td>{{ $municipality->municipality_name }}</td>
                        <td>{{ $municipality->coordinates }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="editGroupBtn btn btn-success btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
                                <button type="button" class="deleteGroupBtn btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Page level plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $('#bootstrap-data-table-export').DataTable();

        // Delete button script
        $(document).on('click', '.deleteGroupBtn', function () {
            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            $('#del').val(data[0]);
            var actionUrl = '{{ route("municipalities.delete", ["id" => ":id"]) }}'.replace(':id', data[0]);
            $('#saveItems').attr('action', actionUrl);
            $('#deletemodal').modal('show');
        });

        // Edit button script
        $(document).on('click', '.editGroupBtn', function () {
            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            $('#municipality_name_edit').val(data[1]);
            $('#coordinates_edit').val(data[2]);
            var actionUrl = '{{ route("municipalities.update", ["id" => ":id"]) }}'.replace(':id', data[0]);
            $('#saveItem').attr('action', actionUrl);
            $('#editmodal').modal('show');
        });
    });
</script><script>
    document.addEventListener('DOMContentLoaded', function () {
        var map, marker;

        function initializeMap() {
            map = L.map('map').setView([10.9165, 124.8447], 10); // Leyte coordinates
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);
    
            // Add click event to place a pin and update the hidden field
            map.on('click', function (e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
    
                if (marker) {
                    map.removeLayer(marker);
                }
    
                marker = L.marker([lat, lng]).addTo(map);
                document.getElementById('coordinates').value = `${lat},${lng}`;
            });
        }

        // Initialize the map when the modal is opened
        $('#itemAddModal').on('shown.bs.modal', function () {
            if (!map) {
                initializeMap(); // Initialize map if not already done
            } else {
                setTimeout(() => {
                    map.invalidateSize(); // Resize the map
                }, 10);
            }
        });

        // Clear marker when the modal is closed
        $('#itemAddModal').on('hidden.bs.modal', function () {
            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }
            document.getElementById('coordinates').value = '';
        });
    });
</script>

    

@endsection
