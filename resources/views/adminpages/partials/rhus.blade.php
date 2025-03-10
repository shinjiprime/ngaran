
        @foreach($rhus as $rhu)
        <tr>
            <td>{{ $rhu->rhu_id }}</td>
            <td>{{ $rhu->rhu_name }}</td>
            <td>{{ $rhu->municipality->municipality_name ?? 'N/A' }}</td>
            <td>{{ $rhu->coordinates ?? 'N/A' }}</td>
            <td>
                <div class="btn-group" role="group">
                    <button type="button" class="editWorkerBtn btn btn-success btn-sm">
                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="deleteWorkerBtn btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="locationWorkerBtn btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#locationModal">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    