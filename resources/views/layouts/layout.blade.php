<!DOCTYPE html> 
<html lang="tr" dir="ltr" data-nav-layout="vertical"  data-theme-mode="light" data-header-styles="gradient" data-menu-styles="dark">

<head>
    
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="simple admin panel template html css,admin panel html,bootstrap 5 admin template,admin,bootstrap dashboard,bootstrap 5 admin panel template,html and css,admin panel,admin panel html template,simple html template,bootstrap admin template,admin dashboard,admin dashboard template,admin panel template,template dashboard">
    
    <!-- Favicon -->
    <link rel="icon" href="{{asset('/')}}assets/images/brand-logos/fav.ico" type="image/x-icon">
    
    <!-- Choices JS -->
    <script src="{{asset('/')}}assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    
    <!-- Main Theme Js -->
    <script src="{{asset('/')}}assets/js/main.js"></script>
    
    <!-- Bootstrap Css -->
    <link id="style" href="{{asset('/')}}assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Style Css -->
    <link href="{{asset('/')}}assets/css/styles.css" rel="stylesheet">
    
    <!-- Icons Css -->
    <link href="{{asset('/')}}assets/css/icons.css" rel="stylesheet">
    
    <!-- Node Waves Css -->
    <link href="{{asset('/')}}assets/libs/node-waves/waves.min.css" rel="stylesheet"> 
    
    <!-- Simplebar Css -->
    <link href="{{asset('/')}}assets/libs/simplebar/simplebar.min.css" rel="stylesheet">
    
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{asset('/')}}assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/libs/@simonwep/pickr/themes/nano.min.css">
    
    <!-- Choices Css -->
    <link rel="stylesheet" href="{{asset('/')}}assets/libs/choices.js/public/assets/styles/choices.min.css">
    
    <link rel="stylesheet" href="{{asset('/')}}assets/libs/jsvectormap/css/jsvectormap.min.css">
    
    <link rel="stylesheet" href="{{asset('/')}}assets/libs/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/libs/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/libs/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/libs/fullcalendar/main.min.css">
    <style>
        .fc-license-message{
            display: none !important;
        }
    </style>
    
</head>

<body>
</div>
<!-- Loader -->
<div id="loader" >
    <img src="{{asset('/')}}assets/images/media/loader.svg" alt="">
</div>
<!-- Loader -->

<div class="page">
    @include('include.header')
    @include('include.sidebar')
    @yield('content')
    @include('include.footer')
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-circle-fill fs-20"></i></span>
</div>
<script src="{{asset('/')}}/assets/libs/@popperjs/core/umd/popper.min.js"></script>
<script src="{{asset('/')}}assets/js/date&amp;time_pickers.js"></script>
<script>
    flatpickr("#timepickr1", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",  // 24 saat formatı için H:i doğru ayar
        time_24hr: true      // 24 saatlik zamanı etkinleştirme
    });
</script>
<div id="responsive-overlay"></div>
<!-- Date & Time Picker JS -->
<script src="{{asset('/')}}assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{asset('/')}}assets/js/date&time_pickers.js"></script>
<!-- Popper JS -->
<script src="{{asset('/')}}assets/libs/@popperjs/core/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="{{asset('/')}}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Defaultmenu JS -->
<script src="{{asset('/')}}assets/js/defaultmenu.min.js"></script>

<!-- Node Waves JS-->
<script src="{{asset('/')}}assets/libs/node-waves/waves.min.js"></script>

<!-- Sticky JS -->
<script src="{{asset('/')}}assets/js/sticky.js"></script>

<!-- Simplebar JS -->
<script src="{{asset('/')}}assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{asset('/')}}assets/js/simplebar.js"></script>

<!-- Color Picker JS -->
<script src="{{asset('/')}}assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

<!-- JSVector Maps JS -->
<script src="{{asset('/')}}assets/libs/jsvectormap/js/jsvectormap.min.js"></script>

<!-- JSVector Maps MapsJS -->
<script src="{{asset('/')}}assets/libs/jsvectormap/maps/world-merc.js"></script>

<!-- Chartjs Chart JS -->
<script src="{{asset('/')}}assets/libs/chart.js/chart.min.js"></script>

<!-- Apex Charts JS -->
<script src="{{asset('/')}}assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- CRM-Dashboard -->
<script src="{{asset('/')}}assets/js/sales-dashboard.js"></script>

<!-- Custom-Switcher JS -->

<script src="{{asset('/')}}assets/js/custom-switcher.min.js"></script>
<!-- Jquery Cdn -->
<!-- Sweetalerts JS -->
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
@if (session('role'))
<script>
    Swal.fire({
        position: "top-end",
        icon: "error",
        title: "{{ session('role') }}",
        showConfirmButton: false,
        timer: 2500
    });
</script>
@endif
<!-- Datatables Cdn -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- Internal Datatables JS -->
<script>
    $('#datatable-basic').dataTable( {
        "order": [[1, 'desc']],
        searching: false
    } );
</script>


<!-- Custom-Switcher JS -->
<script src="{{asset('/')}}assets/js/custom-switcher.min.js"></script>

<!-- Swiper JS -->
<script src="{{asset('/')}}assets/libs/swiper/swiper-bundle.min.js"></script>
<!-- Custom JS -->
<script src="{{asset('/')}}assets/js/product-details.js"></script>

<!-- Fullcalendar JS -->
<script src="{{asset('/')}}assets/libs/fullcalendar/main.min.js"></script>
<script src="{{asset('/')}}assets/js/calendar.js"></script>
<script src="{{asset('/')}}assets/js/cars/contracts-cars.js"></script>
<script src="{{asset('/')}}assets/js/choices.js"></script>
<script src="{{asset('/')}}assets/js/custom.js"></script>


<script>
    $(document).ready(function() {
        $('#km_packages_group').change(function() {
            var selectedPackage = $(this).find(':selected').data('package');
            $('#selected_km_package').val(JSON.stringify(selectedPackage));
        });
        
        $('#insurance_packages_group').change(function() {
            var selectedPackage = $(this).find(':selected').data('package');
            $('#selected_insurance_package').val(JSON.stringify(selectedPackage));
        });
    });
    
    $(document).ready(function () {
        var rowsPerPage = 5; // Her sayfada gösterilecek satır sayısı
        var currentPage = 1;
        var $tableRows = $('#datatable-rnt tbody tr');
        var totalRows = $tableRows.length;
        var totalPages = Math.ceil(totalRows / rowsPerPage);
        
        // Sayfa değiştirme fonksiyonu
        function showPage(page) {
            currentPage = page;
            var start = (currentPage - 1) * rowsPerPage;
            var end = start + rowsPerPage;
            
            $tableRows.hide();
            $tableRows.slice(start, end).show();
            
            // Sayfa bilgisini güncelle
            $('#page-info').text(currentPage);
            
            // Önceki butonu kontrol et
            if (currentPage === 1) {
                $('#prev-page').closest('li').addClass('disabled');
            } else {
                $('#prev-page').closest('li').removeClass('disabled');
            }
            
            // Sonraki butonu kontrol et
            if (currentPage === totalPages) {
                $('#next-page').closest('li').addClass('disabled');
            } else {
                $('#next-page').closest('li').removeClass('disabled');
            }
        }
        
        // İlk sayfayı göster
        showPage(currentPage);
        
        // Önceki sayfa
        $('#prev-page').click(function (e) {
            e.preventDefault(); // Link tıklamasını engelle
            if (currentPage > 1) {
                showPage(currentPage - 1);
            }
        });
        
        // Sonraki sayfa
        $('#next-page').click(function (e) {
            e.preventDefault(); // Link tıklamasını engelle
            if (currentPage < totalPages) {
                showPage(currentPage + 1);
            }
        });
    });
    $('#search-input').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        
        $('#datatable-rnt tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    $('#status-filter').on('change', function () {
        var status = $(this).val().toLowerCase();
        
        $('#datatable-rnt tbody tr').filter(function () {
            var rowStatus = $(this).find('td:nth-child(5)').text().toLowerCase(); // 5. sütun durumu gösteriyor
            if (status) {
                $(this).toggle(rowStatus.indexOf(status) > -1);
            } else {
                $(this).show(); // "All" seçiliyse tüm satırları göster
            }
        });
    });
</script>
<script src="{{asset('/')}}assets/js/logispro-pagination.js"></script>

<script src="{{asset('/')}}assets/js/cars/rentcars.js"></script>

</body>

</html>