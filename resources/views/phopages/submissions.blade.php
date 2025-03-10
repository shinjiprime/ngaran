@extends('masterpho.master')

@section('content')

<div class="card">
    <div class='card-header'>
        <strong class='card-title'>Submissions for this Month</strong>
        <button type="button" id="control_add" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#mapModal" style="margin-left: 88%;">View Submission Map</button>
    </div>
    <div class='card-body'>
        <button id="send-notifications" class="btn btn-primary mb-3">Send Notifications</button>
        <div class='table-responsive'>
            <table id='bootstrap-data-table-export' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>RHU Name</th>
                        <th>Submissions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rhuData as $rhu)
                        <tr>
                            <td><input type="checkbox" class="select-rhu" value="{{ $rhu['rhu_id'] }}"></td>
                            <td>{{ $rhu['rhu_id'] }}</td>
                            <td>{{ $rhu['rhu_name'] }}</td>
                            <td>
                                @if($rhu['submission_count'] == 0)
                                    <span class="badge bg-danger">No Submissions</span>
                                @elseif($rhu['submission_count'] == 1)
                                    <span class="badge bg-warning text-dark">Initial Submission</span>
                                @else
                                    <span class="badge bg-success">Final Submission</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>

<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">RHU Submission Map</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 500px;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        const table = $('#bootstrap-data-table-export').DataTable();

        // Select/Deselect all checkboxes
        $('#select-all').on('click', function () {
            $('.select-rhu').prop('checked', this.checked);
        });

        // Send notifications to selected rows
        $('#send-notifications').on('click', function () {
            const selectedRhuIds = $('.select-rhu:checked').map(function () {
                return $(this).val();
            }).get();

            if (selectedRhuIds.length === 0) {
                Swal.fire({
                    title: 'No Selection',
                    text: 'Please select at least one RHU.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.ajax({
                url: "{{ route('sendNotification') }}",
                method: 'POST',
                data: {
                    rhu_ids: selectedRhuIds,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Notifications sent successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function (error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to send notifications!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script><script>
    document.addEventListener('DOMContentLoaded', function () {
        const rhuData = @json($rhuData);

        let map;

        $('#mapModal').on('shown.bs.modal', function () {
            if (!map) {
                map = L.map('map').setView([10.9165, 124.8447], 10); // Default coordinates and zoom
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                rhuData.forEach(rhu => {
                    if (rhu.coordinates) {
                        const [lat, lng] = rhu.coordinates.split(',');
                        console.log(`Coordinates for ${rhu.rhu_name}:`, lat, lng); // Log coordinates for each RHU
                        
                        // Ensure lat and lng are valid numbers
                        const latNum = parseFloat(lat);
                        const lngNum = parseFloat(lng);
                        if (!isNaN(latNum) && !isNaN(lngNum)) {
                            // Create a DivIcon with custom styles
                            const pinColor = rhu.status === 'submitted' ? 'green' : 'red';
                            const pinIcon = L.divIcon({
                                className: 'leaflet-div-icon', // Default class name
                                html: `<div style="background-color: ${pinColor}; width: 25px; height: 41px; border-radius: 50%; border: 2px solid white; text-align: center; line-height: 41px; color: white; font-weight: bold;">!</div>`,
                                iconSize: [25, 41], // Size of the marker
                                iconAnchor: [12, 41], // Adjust anchor point
                                popupAnchor: [0, -34] // Adjust popup position
                            });

                            L.marker([latNum, lngNum], { icon: pinIcon })
                                .bindPopup(`<strong>${rhu.rhu_name}</strong><br>Submissions: ${rhu.submission_count}`)
                                .addTo(map);
                        } else {
                            console.log(`Invalid coordinates for ${rhu.rhu_name}: ${rhu.coordinates}`);
                        }
                    } else {
                        console.log(`No coordinates available for ${rhu.rhu_name}`);
                    }
                });
            }
        });

        $('#mapModal').on('hidden.bs.modal', function () {
            if (map) {
                map.remove();
                map = null;
            }
        });
    });
</script>


@endsection
