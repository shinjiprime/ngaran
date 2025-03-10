@extends('masteradmin.master')
@section('title')
    ACC OES Home

@endsection
@section('content')
<div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <script>
      // Initialize the map centered on Leyte
      var map = L.map('map').setView([10.8488, 124.9503], 8); // Set the initial view and zoom level

      // Add a tile layer (e.g., OpenStreetMap)
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 18,
          attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      // Municipalities data (you can also fetch this from a server)
      var municipalities = [
          {"name": "Leyte", "coordinates": [10.5726, 124.6061]},
          {"name": "Tacloban City", "coordinates": [11.2414, 125.0022]},
          {"name": "Ormoc City", "coordinates": [11.0711, 124.6095]},
          {"name": "Baybay City", "coordinates": [10.6587, 124.4319]},
          {"name": "Maasin City", "coordinates": [10.1898, 124.8423]},
          {"name": "Calubian", "coordinates": [11.2544, 124.4694]},
          {"name": "Dagami", "coordinates": [10.8976, 124.6162]},
          {"name": "Jaro", "coordinates": [10.8976, 124.5162]},
          {"name": "San Isidro", "coordinates": [10.9027, 124.5017]},
          {"name": "Carigara", "coordinates": [10.8850, 124.5751]}
          // Add more municipalities as needed
      ];

      // Loop through the municipalities data to add markers
      municipalities.forEach(function(municipality) {
          L.marker(municipality.coordinates)
              .addTo(map)
              .bindPopup(municipality.name);
      });
  </script>

<div class="row show-grid">
    <!-- Customer ROW -->
    <div class="col-md-3">
    <!-- Customer record -->
    <div class="col-md-12 mb-3">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-0">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Enrolled Students</div>
              <div class="h6 mb-0 font-weight-bold text-gray-800">
                0 Record(s)
              </div>
            </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
          </div>
        </div>
      </div>
    </div>

    
        <!-- Customer record -->
        <div class="col-md-12 mb-3">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-0">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending Enrollments</div>
                  <div class="h6 mb-0 font-weight-bold text-gray-800">
                    0 Record(s)
                  </div>
                </div>
                  <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                  </div>
              </div>
            </div>
          </div>
        </div>

    


    <!-- User record -->
    <div class="col-md-12 mb-3">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-0">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Paid Students</div>
              <div class="h6 mb-0 font-weight-bold text-gray-800">
                    0 Record(s)
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Customer record -->
        <div class="col-md-12 mb-3">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-0">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Late Enrollments</div>
                  <div class="h6 mb-0 font-weight-bold text-gray-800">
                    0 Record(s)
                  </div>
                </div>
                  <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                  </div>
              </div>
            </div>
          </div>
        </div>
    <div class="col-md-12 mb-3">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-0">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Enrolled to BSCRIM</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                  0 Record(s)
                </div>
              </div>
                <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
          </div>
        </div>
      </div>




  </div>
    <!-- Employee ROW -->
  <div class="col-md-3">
    <!-- Employee record -->
    <div class="col-md-12 mb-3">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-0">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Enrolled to BSIT</div>
              <div class="h6 mb-0 font-weight-bold text-gray-800">
                0 Record(s)
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- User record -->
    <div class="col-md-12 mb-3">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-0">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Enrolled to BSHM</div>
              <div class="h6 mb-0 font-weight-bold text-gray-800">
                0 Record(s)
              </div>
            </div>
            <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-0">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Enrolled to BSENTREP</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                  0 Record(s)
                </div>
              </div>
              <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-0">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Enrolled to BSED</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                  0 Record(s)
                </div>
              </div>
              <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    
      <div class="col-md-12 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-0">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Enrolled to BEED</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                  0 Record(s)
                </div>
              </div>
              <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

  </div>
  <!-- PRODUCTS ROW -->
  <div class="col-md-3">
    <!-- Product record -->
    <div class="col-md-12 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-0">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Subjects Offered</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                          0 Record(s)
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-0">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total 1st Year</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                          0 Record(s)
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    
      <div class="col-md-12 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-0">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total 2nd Year</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                          0 Record(s)
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12 mb-3">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-0">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total 3rd Year</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                          0 Record(s)
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12 mb-3">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-0">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total 4th Year</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                          0 Record(s)
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    
   
    

    </div>
    
  <!-- RECENT PRODUCTS -->
        <div class="col-lg-3">
            <div class="card shadow h-100">
              <div class="card-body">
                <div class="row no-gutters align-items-center">

                 
                    
                  
                <div class="panel-heading"> 
                    <i class="fa fa-th-list fa-fw"></i> Recent Pending Enrollees
                </div>
                <div class="row no-gutters align-items-center mt-1">
                <div class="col-auto">
                  <div class="h6 mb-0 mr-0 text-gray-800">

                <!-- /.panel-heading -->
                
                <div class="panel-body">
                    <div class="list-group">
                      <a href='#' class='list-group-item text-gray-800'>
                                          <i class='fa fa-tasks fa-fw'></i>  2021-01-11093
                                          </a>

                                          <a href='#' class='list-group-item text-gray-800'>
                                            <i class='fa fa-tasks fa-fw'></i>  2021-01-11093
                                            </a>
                                            <a href='#' class='list-group-item text-gray-800'>
                                                <i class='fa fa-tasks fa-fw'></i>  2021-01-11093
                                                </a>
                                                <a href='#' class='list-group-item text-gray-800'>
                                                    <i class='fa fa-tasks fa-fw'></i>  2021-01-11093
                                                    </a>
                                                    <a href='#' class='list-group-item text-gray-800'>
                                                        <i class='fa fa-tasks fa-fw'></i>  2021-01-11093
                                                        </a>
                                                        <a href='#' class='list-group-item text-gray-800'>
                                                            <i class='fa fa-tasks fa-fw'></i>  2021-01-11093
                                                            </a>
                                                            <a href='#' class='list-group-item text-gray-800'>
                                                                <i class='fa fa-tasks fa-fw'></i>  2021-01-11093
                                                                </a>
                                                                <a href='#' class='list-group-item text-gray-800'>
                                                                    <i class='fa fa-tasks fa-fw'></i>  2021-01-11093
                                                                    </a>
                                                                    <a href='#' class='list-group-item text-gray-800'>
                                                                        <i class='fa fa-tasks fa-fw'></i>  2021-01-11093
                                                                        </a>
                    </div>
                    <!-- /.list-group -->
                    <a href="item.php" class="btn btn-default btn-block">View All Records</a>
                </div>
                <!-- /.panel-body -->
            </div></div></div></div></div></div>
  <!-- 
  <div class="col-md-3">
   <div class="col-md-12 mb-2">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"><i class="fas fa-list text-danger">&nbsp;&nbsp;&nbsp;</i>Recent Products</div>
              <div class="h6 mb-0 font-weight-bold text-gray-800">
                
              </div>
            </div>
            <div class="col-auto">
              
            </div>
          </div>
        </div>
      </div>
    </div>
    </div> -->
    

  </div>
  @endsection