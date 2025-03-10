<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sidebar with Bootstrap</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
   


    <div class="wrapper">
        <!-- Sidebar -->
        @include('masterrhu.sidebar')

        <!-- Main content -->
        <div class="main">
            <!-- Top Navbar -->
            @include('masterrhu.topbar')

            <div id="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            @include('masterrhu.footer')

        </div>
    </div>

    <!-- Bootstrap 5 Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="js/script.js"></script>
    <script>
        // Delay the start of the slide-up animation
        setTimeout(function() {
            const preloader = document.querySelector('.preloader');
            preloader.style.animation = 'slideUp 1s ease-in-out forwards';

            // Hide preloader entirely after the animation
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 1000); // Matches the duration of the slide-up animation (1s)
        }, 1300); // 1500ms delay before slide-up starts
    </script>

</body>
