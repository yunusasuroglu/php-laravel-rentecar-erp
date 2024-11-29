<html lang="tr" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close"><head>
    
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="simple admin panel template html css,admin panel html,bootstrap 5 admin template,admin,bootstrap dashboard,bootstrap 5 admin panel template,html and css,admin panel,admin panel html template,simple html template,bootstrap admin template,admin dashboard,admin dashboard template,admin panel template,template dashboard">
    
    <!-- Favicon -->
    <link rel="icon" href="{{asset('/')}}/assets/images/brand-logos/fav.ico" type="image/x-icon">
    
    <!-- Main Theme Js -->
    <script src="{{asset('/')}}/assets/js/authentication-main.js"></script>
    
    <!-- Bootstrap Css -->
    <link id="style" href="{{asset('/')}}/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Style Css -->
    <link href="{{asset('/')}}/assets/css/styles.min.css" rel="stylesheet">
    
    <!-- Icons Css -->
    <link href="{{asset('/')}}/assets/css/icons.min.css" rel="stylesheet">
    
    
</head>

<body>
    <div class="page error-bg" id="particles-js">
        <!-- Start::error-page -->
        @yield('content')
        <!-- End::error-page -->
    </div>
    
    <!-- Custom-Switcher JS -->
    <script src="{{asset('/')}}/assets/js/custom-switcher.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="{{asset('/')}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- Show Password JS -->
    <script src="{{asset('/')}}/assets/js/show-password.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500
        });
    </script>
    @endif
</body>
</html>