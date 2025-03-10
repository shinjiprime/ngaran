<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

    <title>@yield('title')</title>
    
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.png">

<!-- Custom fonts for this template-->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

<!--<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">-->
<link href="{{ asset('vendor/all.min.css') }}" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<!--<link href="../css/sb-admin-2.min.css" rel="stylesheet">-->
<link href="{{ asset('vendor/sb-admin-2.min.css') }}" rel="stylesheet">

<!-- Custom styles for this page -->
<!--<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">-->
<link href="{{ asset('vendor/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">
    @include('admin.connection')
    <div id="wrapper">
        @include('admin.sidebar')
        <!-- Content Wrapper -->
         <div id="content-wrapper" class="d-flex flex-column">

             <!-- Main Content -->
             <div id="content">
                @include('admin.topbar')

                <div class="container-fluid">
                    @yield('content')
                </div>

             </div>
             @include('admin.footer')


         </div>
    </div>
    
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>





<!-- Bootstrap core JavaScript-->
  <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
  <script src=".{{ asset('vendor/jquery.min.js') }}"></script>


  <!--<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>-->
  <script src=".{{ asset('vendor/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->

  <!--<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>-->
  <script src=".{{ asset('vendor/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->

  <!--<script src="../js/sb-admin-2.min.js"></script>-->
  <script src=".{{ asset('vendor/sb-admin-2.min.js') }}"></script>

  <!-- Page level plugins -->
  <!--<script src="../vendor/datatables/jquery.dataTables.min.js"></script>-->
  <script src=".{{ asset('vendor/jquery.dataTables.min.js') }}"></script>


  <!--<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>-->
  <script src=".{{ asset('vendor/dataTables.bootstrap4.min.js') }}"></script>


  <!-- Page level custom scripts -->
  <!--<script src="../js/demo/datatables-demo.js"></script>-->
  <script src=".{{ asset('vendor/datatables-demo.js') }}"></script>

  <!--<script src="../js/city.js"></script> -->
  <script src=".{{ asset('vendor/city.js') }}"></script>

</body>
</html>


