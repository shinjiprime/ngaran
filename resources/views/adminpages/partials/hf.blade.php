@foreach($facilities as $facility)
                    <tr>
                        <td>{{ $facility->facility_id }}</td>
                        <td>{{ $facility->facility_name }}</td>
                        <td>
                            @if($facility->facility_type == 2)
                                Rural Health Unit
                            @elseif($facility->facility_type == 3)
                                Barangay Health Station
                            @elseif($facility->facility_type == 4)
                                District Hospital
                            @else
                                N/A
                            @endif
                        </td>
                        
                        
                        <td>{{ $facility->barangay ? $facility->barangay->barangay_name : 'N/A' }}</td>
                        
                        <td>{{ $facility->rhu ? $facility->rhu->rhu_name : 'N/A' }}</td>
                        <td>{{ $facility->coordinates }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="editWorkerBtn btn btn-success btn-sm"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
                                <button type="button" class="deleteWorkerBtn btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                <button type="button" class="locationWorkerBtn btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#locationModal">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach