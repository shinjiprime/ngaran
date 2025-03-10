@extends('masterpho.master')
@section('title')
    PHO Leyte
@endsection
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Top 10 Diseases | Dashboard</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Chart.js 3D Plugin (optional - adjust if it doesn't work as expected) -->
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d"></script>
        <style>
            body {
                background: linear-gradient(to bottom, #e8f1f2, #ffffff);
            }

            .card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            }

            .card-header {
                background-color: white;
                color: white;
                text-align: center;
                border-radius: 15px 15px 0 0;
                font-weight: bold;
            }

            .chart-container {
                position: relative;
                height: 450px;
            }

            .legend-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .legend-color {
                width: 20px;
                height: 20px;
                border-radius: 5px;
                
            }
            .text-dark-green {
        color: #006400; /* Dark green */
    }

    /* Custom dark green button background */
    .bg-dark-green {
        background-color: #006400; /* Dark green */
        border-color: #006400; /* Optional: For consistency */
    }

    .bg-dark-green:hover {
        background-color: #004d00; /* Darker green for hover effect */
        border-color: #004d00; /* Optional: Match hover border */
    }
        </style>
    </head>

    <body>

      <div class="container-fluid mt-4">

        <!-- Page Heading as Card Header -->
        <div class="card shadow mb-1 bg-white"> 
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h1 class="h3 mb-0 text-dark-green">Provincial Health Office of Leyte Dashboard</h1>
                <div class="dropdown">
                    <button class="btn btn-sm bg-dark-green text-white shadow-sm dropdown-toggle" type="button" id="viewMapsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-map fa-sm text-white-50"></i> View Maps
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="viewMapsDropdown">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#morbidityMapModal">Morbidity Map</a></li>
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mortalityMapModal">Mortality Map</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
      <!-- Morbidity Map Modal -->
<!-- Morbidity Map Modal -->
<div class="modal fade" id="morbidityMapModal" tabindex="-1" aria-labelledby="morbidityMapModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="morbidityMapModalLabel">Morbidity Map</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Map Legend and View Data Button -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="map-legend d-flex align-items-center">
                        <div class="legend-item d-flex align-items-center me-3">
                            <span style="display: inline-block; width: 20px; height: 20px; background-color: green; margin-right: 5px;"></span>
                            <span>Less than 50 cases</span>
                        </div>
                        <div class="legend-item d-flex align-items-center me-3">
                            <span style="display: inline-block; width: 20px; height: 20px; background-color: orange; margin-right: 5px;"></span>
                            <span>50 - 100 cases</span>
                        </div>
                        <div class="legend-item d-flex align-items-center">
                            <span style="display: inline-block; width: 20px; height: 20px; background-color: red; margin-right: 5px;"></span>
                            <span>More than 250 cases</span>
                        </div>
                    </div>
                    <a href="/phomorbidity" class="btn btn-success">View Data</a>
                </div>
                <!-- Map Container -->
                <div id="morbidityMap" style="height: 500px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Mortality Map Modal -->
<div class="modal fade" id="mortalityMapModal" tabindex="-1" aria-labelledby="mortalityMapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mortalityMapModalLabel">Mortality Map</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Map Legend -->
                <div class="map-legend d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex">
                        <div class="legend-item d-flex align-items-center me-3">
                            <span style="display: inline-block; width: 20px; height: 20px; background-color: green; margin-right: 5px;"></span>
                            <span>Less than 50 cases</span>
                        </div>
                        <div class="legend-item d-flex align-items-center me-3">
                            <span style="display: inline-block; width: 20px; height: 20px; background-color: orange; margin-right: 5px;"></span>
                            <span>50 - 100 cases</span>
                        </div>
                        <div class="legend-item d-flex align-items-center">
                            <span style="display: inline-block; width: 20px; height: 20px; background-color: red; margin-right: 5px;"></span>
                            <span>More than 250 cases</span>
                        </div>
                    </div>
                    <!-- View Data Button -->
                    <a href="/phomortality" class="btn btn-success">View Data</a>
                </div>
                <!-- Map Container -->
                <div id="mortalityMap" style="height: 500px;"></div>
            </div>
            
        </div>
    </div>
</div>



<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const morbidityMapModal = document.getElementById('morbidityMapModal');
        let map;
    
        morbidityMapModal.addEventListener('show.bs.modal', function () {
            setTimeout(() => {
                if (!map) {
                    map = L.map('morbidityMap').setView([10.9165, 124.8447], 10);  // Adjust coordinates as needed
    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
    
                    fetch('/get-morbidity-map-data')
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(location => {
                                const [lat, lng] = location.coordinates.split(',');
                                const popupContent = `<strong>${location.municipality_name}</strong><br>Patients: ${location.patient_count}`;
    
                                // Define the marker color based on patient count
                                let markerColor;
                                if (location.patient_count === 0) {
                                    markerColor = 'green';
                                } else if (location.patient_count === 1) {
                                    markerColor = 'orange';
                                
                                } else {
                                    markerColor = 'red';  // Default color for more than 2 patients
                                }
    
                                // Create a custom DivIcon with the chosen color
                                const marker = L.marker([parseFloat(lat), parseFloat(lng)], {
                                    icon: L.divIcon({
                                        className: 'patient-marker',
                                        html: `<div style="background-color: ${markerColor}; width: 20px; height: 20px; border-radius: 50%; border: 2px solid #fff;"></div>`,
                                        iconSize: [20, 20],
                                        iconAnchor: [10, 10],  // Center the icon on the marker
                                    })
                                })
                                .addTo(map)
                                .bindPopup(popupContent);
                            });
                            map.invalidateSize();  // Resize the map after adding data
                        })
                        .catch(error => console.error('Error fetching morbidity data:', error));
                } else {
                    map.invalidateSize();  // Ensure map is resized on subsequent openings
                }
            }, 500);  // Delay to wait for modal animation completion
        });
    
        morbidityMapModal.addEventListener('hidden.bs.modal', function () {
            if (map) {
                map.remove();
                map = null;
            }
        });
    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mortalityMapModal = document.getElementById('mortalityMapModal');
            let mortalityMap;
    
            mortalityMapModal.addEventListener('show.bs.modal', function () {
                setTimeout(() => {
                    if (!mortalityMap) {
                        mortalityMap = L.map('mortalityMap').setView([10.9165, 124.8447], 10);  // Adjust coordinates as needed
    
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(mortalityMap);
    
                        fetch('/get-mortality-map-data')
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(location => {
                                    const [lat, lng] = location.coordinates.split(',');
                                    const popupContent = `<strong>${location.municipality_name}</strong><br>Deaths: ${location.death_count}`;
    
                                    let markerColor = location.death_count === 0 ? 'green' :
                                                      location.death_count === 1 ? 'orange' :'red';
                                                      
                                    const marker = L.marker([parseFloat(lat), parseFloat(lng)], {
                                        icon: L.divIcon({
                                            className: 'death-marker',
                                            html: `<div style="background-color: ${markerColor}; width: 20px; height: 20px; border-radius: 50%; border: 2px solid #fff;"></div>`,
                                            iconSize: [20, 20],
                                            iconAnchor: [10, 10],
                                        })
                                    })
                                    .addTo(mortalityMap)
                                    .bindPopup(popupContent);
                                });
                                mortalityMap.invalidateSize();
                            })
                            .catch(error => console.error('Error fetching mortality data:', error));
                    } else {
                        mortalityMap.invalidateSize();
                    }
                }, 500);
            });
    
            mortalityMapModal.addEventListener('hidden.bs.modal', function () {
                if (mortalityMap) {
                    mortalityMap.remove();
                    mortalityMap = null;
                }
            });
        });
    </script>
    
    
    
        <!-- Separator -->
        <hr class="sidebar-divider my-4">
    
        <!-- Content Row -->
        <div class="row">
    
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Morbidity Cases This Month</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <h4>{{ $morbidityCount }}</h4>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Mortality Cases Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Mortality Cases This Month</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mortalityCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cross fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Most Infectious Disease Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Most Infectious Disease</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $mostInfectiousDiseaseName }}</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-virus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Most Deadly Disease Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Most Deadly Disease</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $mostDeadlyDiseaseName }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-skull-crossbones fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Separator -->
        <hr class="sidebar-divider my-4">
    
        <!-- Line Graph -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-h4 3">
                        <h6 class="h4 m-3 font-weight-bold text-dark-green">Morbidity Total Counts (Last 7 Months)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="morbidityMortalityLineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    
    </div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    fetch('/get-morbidity-mortality-data')
      .then(response => response.json())
      .then(data => {
        // Log the fetched data to the console
        console.log('Months:', data.months);
        console.log('Morbidity Counts:', data.morbidity);
        console.log('Mortality Counts:', data.mortality);

        const ctx = document.getElementById('morbidityMortalityLineChart').getContext('2d');
        const morbidityMortalityLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: data.months,
            datasets: [
              {
                label: 'Morbidity (Active)',
                data: data.morbidity,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2
              },
              {
                label: 'Mortality (Deceased)',
                data: data.mortality,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 2
              }
            ]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top'
              }
            },
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Months'
                }
              },
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Count'
                }
              }
            }
          }
        });
      })
      .catch(error => console.error('Error fetching data:', error));
  });
</script>


        <div class="container mt-4">
            <div class="row">
                <!-- Mortality Rate Records -->
                <div class="col-md-3"> 
                    <!-- Disease Mortality Rate Record -->
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        <i class="fas fa-skull-crossbones fa-2x text-gray-300"></i> Top 10 Infectious Diseases
                                    </div>
                                    <hr class="my-2"> 
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        <ul class="list-group list-group-flush">
                                            @foreach($topInfectiousDiseases as $disease)
                                                <li class="list-group-item">
                                                    {{ $disease->disease->disease_name ?? 'N/A' }} - {{ $disease->count }} cases
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <hr class="my-2"> 
                                    <button class="btn btn-danger mt-3" onclick="window.location.href='{{ route('generate.disease.report') }}'">
                                        Generate Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- Morbidity Rate Records -->
                <div class="col-md-3">
                    <!-- Disease Morbidity Rate Record -->
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><i class="fas fa-thermometer-half fa-2x text-gray-300"></i>    Top 10
                                        Diseases With most deaths</div>
                                        <hr class="my-2"> 
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                      <ul class="list-group list-group-flush">
                                        @foreach($topDeadliestDiseases as $disease)
                                        <li class="list-group-item">
                                            {{ $disease->disease->disease_name ?? 'N/A' }} - {{ $disease->count }} cases
                                        </li>
                                    @endforeach
                                    </ul>
                                    </div>
                                    <hr class="my-2"> 
                                    <button class="btn btn-warning mt-3" onclick="window.location.href='{{ route('generate.disease2.report') }}'">
                                        Generate Report
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disease Category -->
                <div class="col-md-3">
                    <!-- Disease Category -->
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><i class="fas fa-virus fa-2x text-gray-300"></i>Top 10 Highest Morbidity Areas
                                        </div>
                                        <hr class="my-2"> 
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        <ul class="list-group list-group-flush">
                                            @foreach($topSickAreas as $municipality)
                                                <li class="list-group-item">
                                                    {{ $municipality['municipality_name'] }} - {{ $municipality['death_count'] }} cases
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <hr class="my-2"> 
                                    <button class="btn btn-success mt-3" onclick="window.location.href='{{ route('generate.disease3.report') }}'">
                                        Generate Report
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                  <!-- Disease Category -->
                  <div class="card border-left-success shadow h-100 py-2">
                      <div class="card-body">
                          <div class="row no-gutters align-items-center">
                              <div class="col mr-0">
                                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><i class="fas fa-virus fa-2x text-gray-300"></i>Top 10 Highest Mortality Areas
                                      </div>
                                      <hr class="my-2"> 
                                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        <ul class="list-group list-group-flush">
                                            @foreach($topDeadlyAreas as $municipality)
                                                <li class="list-group-item">
                                                    {{ $municipality['municipality_name'] }} - {{ $municipality['death_count'] }} deaths
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <hr class="my-2"> 
                                    <button class="btn btn-success mt-3" onclick="window.location.href='{{ route('generate.disease4.report') }}'">
                                        Generate Report
                                    </button>
                    
                              </div>
                              
                          </div>
                      </div>
                  </div>
              </div>


            </div>

            <!-- Additional Information Section -->
            
        </div>
        
        <script>
            // Data for Chart
            const chartData = {
                labels: [
                    "Barangay 1", "Barangay 2", "Barangay 3", "Barangay 4",
                    "Barangay 5", "Barangay 6", "Barangay 7", "Barangay 8",
                    "Barangay 9", "Barangay 10"
                ],
                datasets: [{
                        label: "Disease A",
                        data: [150, 130, 110, 95, 120, 140, 100, 105, 90, 125],
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.9)',
                    },
                    {
                        label: "Disease B",
                        data: [120, 140, 100, 110, 95, 130, 115, 90, 85, 100],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)',
                    },
                    {
                        label: "Disease C",
                        data: [100, 90, 130, 120, 110, 85, 125, 140, 95, 105],
                        backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        hoverBackgroundColor: 'rgba(255, 206, 86, 0.9)',
                    }
                ]
            };

            // Config for Chart
            const config = {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false // Use custom legend
                        },
                        title: {
                            display: true,
                            text: 'Top 10 Diseases Across Barangays/Municipalities (3D)',
                            font: {
                                size: 18
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'Barangays / Municipalities'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Cases'
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.raw} cases`;
                                }
                            }
                        },
                        chart3d: {
                            depth: 20,
                            angle: 60,
                            enabled: true,
                            rotation: 10
                        }
                    }
                }
            };

            // Render Chart
            const ctx = document.getElementById('topDiseases3DChart').getContext('2d');
            const myChart = new Chart(ctx, config);

            // Custom Legend
            const legendContainer = document.getElementById('chartLegend');
            chartData.datasets.forEach(dataset => {
                const legendItem = document.createElement('div');
                legendItem.className = 'legend-item';
                legendItem.innerHTML = `
                    <div class="legend-color" style="background-color: ${dataset.backgroundColor};"></div>
                    ${dataset.label}
                `;
                legendContainer.appendChild(legendItem);
            });

            // Handle Disease Filter Change
            document.getElementById('diseaseFilter').addEventListener('change', function() {
                const selectedDisease = this.value;

                // Update Chart Data Based on Selected Disease
                chartData.datasets.forEach(dataset => {
                    if (dataset.label === selectedDisease) {
                        dataset.data = chartData[dataset.label]; // Show data for selected disease
                    } else {
                        dataset.data = Array(chartData.labels.length).fill(0); // Hide data for others
                    }
                });

                // Update chart with new data
                myChart.update();
            });
        </script>
    </body>

    </html>
@endsection
