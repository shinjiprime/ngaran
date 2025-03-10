@extends('masteradmin.master')
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
                background-color: #0056b3;
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
        </style>
    </head>

    <body>

        
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
          class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
  
    <!-- Content Row -->
    <div class="row">
  
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Registered Admin</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
  
                 <h4>Total Admin: *</h4>
  
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Pending Requests Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-comments fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
        <div class="container mt-5">
            <h1 class="text-center mb-4">
                <i class="fas fa-chart-pie text-primary"></i> Top 10 Diseases Dashboard
            </h1>

            <!-- Disease Filter Dropdown -->
            <div class="mb-4">
                <label for="diseaseFilter" class="form-label">Select Disease:</label>
                <select class="form-select" id="diseaseFilter">
                    <option value="Disease A">Disease A</option>
                    <option value="Disease B">Disease B</option>
                    <option value="Disease C">Disease C</option>
                </select>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            Top 10 Diseases in Barangays/Municipalities (3D)
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="topDiseases3DChart"></canvas>
                            </div>
                            <div class="legend-container mt-4" id="chartLegend"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <div class="row">
                <!-- Mortality Rate Records -->
                <div class="col-md-3">
                    <!-- Disease Mortality Rate Record -->
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-0">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Top Mortality
                                        Diseases</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        COVID-19 (2,000,000 Deaths)
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-skull-crossbones fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Top Morbidity
                                        Diseases</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        Influenza (10,000,000 Cases)
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-thermometer-half fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Infectious
                                        Diseases</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        12 Diseases
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-virus fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disease Statistics (Recent Data) -->
                <div class="col-md-3">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            <div class="panel-heading">
                                <i class="fa fa-list fa-fw"></i> Recent Disease Statistics
                            </div>
                            <div class="panel-body">
                                <div class="list-group">
                                    <a href='#' class='list-group-item text-gray-800'>
                                        <i class='fa fa-tasks fa-fw'></i> Tuberculosis (500,000 cases)
                                    </a>
                                    <a href='#' class='list-group-item text-gray-800'>
                                        <i class='fa fa-tasks fa-fw'></i> Malaria (300,000 cases)
                                    </a>
                                    <a href='#' class='list-group-item text-gray-800'>
                                        <i class='fa fa-tasks fa-fw'></i> HIV/AIDS (200,000 cases)
                                    </a>
                                    <a href='#' class='list-group-item text-gray-800'>
                                        <i class='fa fa-tasks fa-fw'></i> Hepatitis B (150,000 cases)
                                    </a>
                                    <a href='#' class='list-group-item text-gray-800'>
                                        <i class='fa fa-tasks fa-fw'></i> Pneumonia (100,000 cases)
                                    </a>
                                </div>
                                <a href="#" class="btn btn-default btn-block">View All Records</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Additional Information</h5>
                            <p class="card-text">
                                This section can be used for further elaboration on diseases, prevention measures, and
                                treatment information. It could also contain a chart or graph visualizing morbidity and
                                mortality rates over time.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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
