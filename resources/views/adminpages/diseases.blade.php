@extends('masteradmin.master')
@section('title')
Diseases Management
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
              <h5 class="modal-title" id="exampleModalLabel">Add Disease</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('diseases.create') }}" method="POST">
              <div class="modal-body">
                  @csrf


                  <!-- Disease Name -->
                  <div class="mb-3">
                      <label for="disease_name" class="form-label">Disease Name:</label>
                      <input type="text" name="disease_name" class="form-control" required />
                  </div>

                  <!-- ICD-10 Code -->
                  <div class="mb-3">
                      <label for="icd10_code" class="form-label">ICD-10 Code:</label>
                      <input type="text" name="icd10_code" class="form-control" required />
                  </div>

                  <!-- Disease Group -->
                  <div class="mb-3">
                    <label for="disease_group_id" class="form-label">Disease Group:</label>
                    <select name="disease_group_id" class="form-control" required>
                        <option value="">Select Disease Group</option>
                        @foreach($diseaseGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->disease_group_name }}</option>
                        @endforeach
                    </select>
                </div>
                
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Disease</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Update Disease</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('disease.update', ['disease_code' => ':disease_code']) }}" id="saveItem" method="POST">
                <div class="modal-body">
                    @csrf
                    <div id="errorMessage" class="alert alert-warning d-none"></div>

                    <!-- Disease Code -->
                    <div class="mb-3">
                        <label for="disease_code_edit">Disease Code:</label>
                        <input type="text" name="disease_code" id="disease_code_edit" class="form-control" required readonly />
                    </div>

                    <!-- Disease Name -->
                    <div class="mb-3">
                        <label for="disease_name_edit">Disease Name:</label>
                        <input type="text" name="disease_name" id="disease_name_edit" class="form-control" required />
                    </div>

                    <!-- ICD-10 Code -->
                    <div class="mb-3">
                        <label for="icd10_code_edit">ICD-10 Code:</label>
                        <input type="text" name="icd10_code" id="icd10_code_edit" class="form-control" required />
                    </div>

                    <!-- Disease Group -->
                    <div class="mb-3">
                        <label for="disease_group_id" class="form-label">Disease Group:</label>
                        <select name="disease_group_id" id="disease_group_edit" class="form-control" required>
                            <option value="">Select Disease Group</option>
                            @foreach($diseaseGroups as $group)
                                <option value="{{ $group->id }}">{{ $group->disease_group_name }}</option>
                            @endforeach
                        </select>
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

<!-- DELETE POP UP FORM -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Disease</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('disease.delete', ['disease_code' => ':disease_code']) }}" id="saveItems" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="del" id="del">
                    <h4>Do you want to delete this disease?</h4>
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
        <strong class='card-title'>Disease Records</strong>
        <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemAddModal" style="margin-left: 88%;">Add New</button>
         </div>
    <div class='card-body'>
        <div class='table-responsive'>
            <table id='bootstrap-data-table-export' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th class='text-nowrap'>Disease Code</th>
                        <th class='text-nowrap'>Disease Name</th>
                        <th class='text-nowrap'>ICD-10 Code</th>
                        <th class='text-nowrap'>Disease Group</th>
                        <th class='text-nowrap'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diseases as $disease)
                    <tr>
                        <td>{{ $disease->disease_code }}</td>
                        <td>{{ $disease->disease_name }}</td>
                        <td>{{ $disease->icd10_code }}</td>
                        <td>{{ $disease->diseaseGroup->disease_group_name }}</td>

                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="editDiseaseBtn btn btn-success btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
                                <button type="button" class="deleteDiseaseBtn btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
<!-- Delete Button Script -->
<script>
    $(document).ready(function () {
        $(document).on('click', '.deleteDiseaseBtn', function() {
            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            $('#del').val(data[0]); // Assuming disease_code is in the first column

            var diseaseCode = data[0];
            var actionUrl = '{{ route("disease.delete", ["disease_code" => ":disease_code"]) }}'.replace(':disease_code', diseaseCode);
            $('#saveItems').attr('action', actionUrl);
            $('#deletemodal').modal('show');
        });
    });
</script>

<!-- Edit Button Script -->
<script>
    $(document).ready(function () {
        $(document).on('click', '.editDiseaseBtn', function() {
            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            $('#disease_code_edit').val(data[0]);
            $('#disease_name_edit').val(data[1]);
            $('#icd10_code_edit').val(data[2]);
            $('#disease_group_edit').val(data[3]);
            var diseaseGroup = data[3];

    // Find the option in the dropdown that matches the municipality name and set it as selected
    $('#disease_group_edit option').each(function () {
        if ($(this).text() === diseaseGroup) {
            $(this).prop('selected', true);
        }
    });

            var diseaseCode = data[0];
            var actionUrl = '{{ route("disease.update", ["disease_code" => ":disease_code"]) }}'.replace(':disease_code', diseaseCode);
            $('#saveItem').attr('action', actionUrl);
            $('#editmodal').modal('show');
        });
    });
</script>


        

@endsection
