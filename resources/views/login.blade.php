<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ACC OES</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.png">
  
  <!-- Custom fonts for this template-->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  
  
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  
  <!-- Custom styles for this template-->
  <link href="{{ asset('vendor/sb-admin-2.min.css') }}" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  <!-- Custom styles for this page -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
  
<style>
  body {
    background-image: url("{{ asset('img/bg.png') }}");
    background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  }

  .btn-user {
    color: white;
    background-color: green;
    /* Add other button styles here */
  }

  .btn-user:hover {
    color: green;
    background-color: white;
    /* Add other button styles for hover state here */
  }
</style>
</head>

<body class="">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center align-items-center" style="height: 100vh;">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row shadow">
            <div class="col-lg-6  d-flex justify-content-center align-items-center" ><img src="{{ asset('img/logo.jpg') }}" width="350px"
height="350px" class="img-fluid" alt=""></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">PROVINCIAL HEALTH OFFICE OF LEYTE</h1>
                  </div>
                  <form class="user" role="form" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input class="form-control form-control-user" placeholder="Username" name="username" type="text" autofocus value="">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-user" placeholder="Password" name="password" type="password" value="">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit" name="btnlogin">Login</button>
                    <hr>
                  <!-- <div class="text-center">
                    <a class="small" href="register.php">Create an Account!</a>
                  </div> -->
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages -->
<script src=".{{ asset('vendor/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Page level custom scripts -->
<!--<script src="../js/demo/datatables-demo.js"></script>-->
<script src=".{{ asset('vendor/datatables-demo.js') }}"></script>

<!--<script src="../js/city.js"></script> -->
<script src=".{{ asset('vendor/city.js') }}"></script>

</body>

</html>
