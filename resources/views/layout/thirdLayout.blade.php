<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title') | GIS Kecelakaan</title>
  
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('assets/')}}/vendors/feather/feather.css">
  <link rel="stylesheet" href="{{asset('assets/')}}/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="{{asset('assets/')}}/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{asset('assets/')}}/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="{{asset('assets/')}}/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="{{asset('assets/')}}/vendors/mdi/css/materialdesignicons.min.css">  
  <link rel="stylesheet" type="text/css" href="{{asset('assets/')}}/js/select.dataTables.min.css"> 
  @yield('head')
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('assets/')}}/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('assets/')}}/subang.ico" />

  <!-- datatable -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

  {{-- open layer --}}
  <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">

  <style>
    .map {
        height: 100vh;
        width: 100%;
    }
</style>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        @include('layout.navbar')
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      @include('layout.twoSidebar')
      <!-- partial -->
      <div class="main-panel">
        @yield('content')

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span>© 2021 GIS Kecelakaan Kabupaten Subang</span>
          </div>
        </footer> 
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{asset('assets/')}}/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="{{asset('assets/')}}/vendors/chart.js/Chart.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="{{asset('assets/')}}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="{{asset('assets/')}}/js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset('assets/')}}/js/off-canvas.js"></script>
  <script src="{{asset('assets/')}}/js/hoverable-collapse.js"></script>
  <script src="{{asset('assets/')}}/js/template.js"></script>
  <script src="{{asset('assets/')}}/js/settings.js"></script>
  <script src="{{asset('assets/')}}/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{asset('assets/')}}/js/dashboard.js"></script>
  <script src="{{asset('assets/')}}/js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->

  {{-- open layer --}}
  @yield('script')

  <!-- datatable -->
  <script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
  </script>
</body>

</html>

