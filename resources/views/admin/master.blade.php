<!doctype html>
<html lang="en" class="semi-dark">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Favicon -->
<link rel="icon" href="{{ asset('admin/assets/images/favicon-32x32.png') }}" type="image/png" />

<!-- Plugins CSS -->
<link href="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />

<!-- Bootstrap CSS -->
<link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />

<!-- Custom Styles -->
<link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" />

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Loader CSS -->
<link href="{{ asset('admin/assets/css/pace.min.css') }}" rel="stylesheet" />

<!-- Theme Styles -->
<link href="{{ asset('admin/assets/css/dark-theme.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/css/light-theme.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/css/semi-dark.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/css/header-colors.css') }}" rel="stylesheet" />

  <title>luckyspotbd</title>





<!-- jQuery first, then Bootstrap JS, then Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- jQuery first, then Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Toastr & Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Toastr Notifications -->
<script>
    $(document).ready(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };

        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    });
</script>
</head>

<body>


  <!--start wrapper-->
  <div class="wrapper">
    <!--start top header-->
     @include('admin.pages.header')
       <!--end top header-->

        <!--start sidebar -->
         @include('admin.pages.sidebar')
       <!--end sidebar -->

       <!--start content-->
          <main class="page-content">
              @yield('admin')
          </main>
       <!--end page main-->

       <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

       <!--Start Back To Top Button-->
		     <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
       <!--End Back To Top Button-->



  </div>
  <!--end wrapper-->


<!-- Bootstrap Bundle (Includes Popper) -->
<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- jQuery -->
<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('admin/assets/plugins/chartjs/js/Chart.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/chartjs/js/Chart.extension.js') }}"></script>

<!-- ApexCharts -->
<script src="{{ asset('admin/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>

<!-- Vector Map -->
<script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

<!-- App Scripts -->
<script src="{{ asset('admin/assets/js/app.js') }}"></script>
<script src="{{ asset('admin/assets/js/index.js') }}"></script>

<script>
    new PerfectScrollbar(".review-list");
    new PerfectScrollbar(".chat-talk");
</script>

<!-- External Analytics (GoDaddy or Server Tracking) -->
<script>
    'undefined' === typeof _trfq || (window._trfq = []);
    'undefined' === typeof _trfd && (window._trfd = []);
    _trfd.push(
        { 'tccl.baseHost': 'secureserver.net' },
        { 'ap': 'cpsh-oh' },
        { 'server': 'p3plzcpnl509132' },
        { 'dcenter': 'p3' },
        { 'cp_id': '10399385' },
        { 'cp_cl': '8' }
    );
</script>

<script src="https://img1.wsimg.com/signals/js/clients/scc-c2/scc-c2.min.js"></script>

</body>
</html>

</html>
