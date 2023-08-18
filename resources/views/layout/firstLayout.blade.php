<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title')</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets') }}/vendors/feather/feather.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/vendors/css/vendor.bundle.base.css">
  
  <link rel="stylesheet" href="{{asset('assets/')}}/vendors/mdi/css/materialdesignicons.min.css"> 
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('assets') }}/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('assets/')}}/subang.ico" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        @yield('content')
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('assets') }}/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('assets') }}/js/off-canvas.js"></script>
  <script src="{{ asset('assets') }}/js/hoverable-collapse.js"></script>
  <script src="{{ asset('assets') }}/js/template.js"></script>
  <script src="{{ asset('assets') }}/js/settings.js"></script>
  <script src="{{ asset('assets') }}/js/todolist.js"></script>
  <!-- endinject -->
  <script>
    var togglePassword = document.getElementById("togglePassword");
    var passwordInput = document.getElementById("exampleInputPassword1");

    togglePassword.addEventListener("click", function() {
        var type = passwordInput.getAttribute("type");
        if (type === "password") {
            passwordInput.setAttribute("type", "text");
            togglePassword.innerHTML = '<i class="mdi mdi-eye" aria-hidden="true"></i>';
        } else {
            passwordInput.setAttribute("type", "password");
            togglePassword.innerHTML = '<i class="mdi mdi-eye-off" aria-hidden="true"></i>';
        }
    });
</script>
</body>

</html>
