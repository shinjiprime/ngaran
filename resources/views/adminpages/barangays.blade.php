@extends('masteradmin.master')

@section('title')
Barangays Management
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
              <h5 class="modal-title" id="exampleModalLabel">Add Barangay</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('barangays.create') }}" method="POST">
              <div class="modal-body">
                  @csrf

                  <div class="mb-3">
                      <label for="barangay_name" class="form-label">Barangay Name:</label>
                      <input type="text" name="barangay_name" class="form-control" required />
                  </div>

                  <div class="mb-3">
                      <label for="coordinates" class="form-label">Coordinates:</label>
                      <input type="text" name="coordinates" class="form-control" required />
                  </div>

                  <div class="mb-3">
                      <label for="municipality_id" class="form-label">Municipality:</label>
                      <select name="municipality_id" class="form-control" required>
                          <option value="">Select Municipality</option>
                          @foreach($municipalities as $municipality)
                              <option value="{{ $municipality->id }}">{{ $municipality->municipality_name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Barangay</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Update Barangay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barangays.update', ['id' => ':id']) }}" id="saveItem" method="POST">
                <div class="modal-body">
                    @csrf

                    <div class="mb-3">
                        <label for="barangay_name_edit">Barangay Name:</label>
                        <input type="text" name="barangay_name" id="barangay_name_edit" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label for="coordinates_edit">Coordinates:</label>
                        <input type="text" name="coordinates" id="coordinates_edit" class="form-control" required />
                    </div>

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
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class='card-header'>
        <strong class='card-title'>Barangays</strong>
        <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemAddModal" style="float: right;">Add New</button>
    </div>
    <div class='card-body'>
        <div class='table-responsive'>
            <table id='bootstrap-data-table-export' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Barangay Name</th>
                        <th>Coordinates</th>
                        <th>Municipality</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangays as $barangay)
                    <tr>
                        <td>{{ $barangay->id }}</td>
                        <td>{{ $barangay->barangay_name }}</td>
                        <td>{{ $barangay->coordinates }}</td>
                        <td>{{ $barangay->municipality->municipality_name }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="editGroupBtn btn btn-success btn-sm">Edit</button>
                                <button type="button" class="deleteGroupBtn btn btn-danger btn-sm">Delete</button>
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
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $('#bootstrap-data-table-export').DataTable();

        // Edit button script
        $(document).on('click', '.editGroupBtn', function () {
    var row = $(this).closest('tr');
    var data = row.children("td").map(function () {
        return $(this).text();
    }).get();

    // Populate fields with row data
    $('#barangay_name_edit').val(data[1]); // Barangay Name
    $('#coordinates_edit').val(data[2]);  // Coordinates

    // Get the municipality name from the table
    var municipalityName = data[3];

    // Find the option in the dropdown that matches the municipality name and set it as selected
    $('#municipality_id_edit option').each(function () {
        if ($(this).text() === municipalityName) {
            $(this).prop('selected', true);
        }
    });

    // Update the form action URL dynamically with the Barangay ID
    var actionUrl = '{{ route("barangays.update", ["id" => ":id"]) }}'.replace(':id', data[0]);
    $('#saveItem').attr('action', actionUrl);

    // Show the modal
    $('#editmodal').modal('show');
});


        // Delete button script
        $(document).on('click', '.deleteGroupBtn', function () {
            var row = $(this).closest('tr');
            var data = row.children("td").map(function () {
                return $(this).text();
            }).get();

            var actionUrl = '{{ route("barangays.delete", ["id" => ":id"]) }}'.replace(':id', data[0]);
            $('#saveItems').attr('action', actionUrl);
            $('#deletemodal').modal('show');
        });
    });
</script>

@endsection
