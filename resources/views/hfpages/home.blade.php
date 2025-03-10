@extends('masterhf.master')
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
                <h1 class="h3 mb-0 text-dark-green">{{ session('facility_name') }} Dashboard</h1>
                
            </div>
        </div>
    
    
    
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
                
                

                <!-- Morbidity Rate Records -->
                <div class="col-md-3">
                    <!-- Disease Morbidity Rate Record -->
                    


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
