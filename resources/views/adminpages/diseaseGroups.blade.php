@extends('masteradmin.master') 
@section('title')
Disease Groups Management
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
              <h5 class="modal-title" id="exampleModalLabel">Add Disease Group</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('disease_groups.create') }}" method="POST">
              <div class="modal-body">
                  @csrf

                  <!-- Disease Group Name -->
                  <div class="mb-3">
                      <label for="disease_group_name" class="form-label">Disease Group Name:</label>
                      <input type="text" name="disease_group_name" class="form-control" required />
                  </div>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Group</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Update Disease Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('disease_groups.update', ['id' => ':id']) }}" id="saveItem" method="POST">
                <div class="modal-body">
                    @csrf
                    <div id="errorMessage" class="alert alert-warning d-none"></div>

                    <!-- Disease Group Name -->
                    <div class="mb-3">
                        <label for="disease_group_name_edit">Disease Group Name:</label>
                        <input type="text" name="disease_group_name" id="disease_group_name_edit" class="form-control" required />
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
                <h5 class="modal-title" id="exampleModalLabel">Delete Disease Group</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('disease_groups.delete', ['id' => ':id']) }}" id="saveItems" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="del" id="del">
                    <h4>Do you want to delete this group?</h4>
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
        <strong class='card-title'>Disease Groups</strong>
        <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemAddModal" style="margin-left: 88%;">Add New</button>
    </div>
    <div class='card-body'>
        <div class='table-responsive'>
            <table id='bootstrap-data-table-export' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th class='text-nowrap'>ID</th>
                        <th class='text-nowrap'>Disease Group Name</th>
                        <th class='text-nowrap'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($disease_groups as $group)
                    <tr>
                        <td>{{ $group->id }}</td>
                        <td>{{ $group->disease_group_name }}</td>
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

<!-- Page level plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    });
    </script>

<script>
    $(document).ready(function () {
        // Delete button script
        $(document).on('click', '.deleteGroupBtn', function () {
            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            $('#del').val(data[0]);
            var actionUrl = '{{ route("disease_groups.delete", ["id" => ":id"]) }}'.replace(':id', data[0]);
            $('#saveItems').attr('action', actionUrl);
            $('#deletemodal').modal('show');
        });

        // Edit button script
        $(document).on('click', '.editGroupBtn', function () {
            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            $('#disease_group_name_edit').val(data[1]);
            var actionUrl = '{{ route("disease_groups.update", ["id" => ":id"]) }}'.replace(':id', data[0]);
            $('#saveItem').attr('action', actionUrl);
            $('#editmodal').modal('show');
        });
    });
</script>

@endsection
