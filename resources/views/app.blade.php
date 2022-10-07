<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.2/css/bootstrap.min.css" integrity="sha512-CpIKUSyh9QX2+zSdfGP+eWLx23C8Dj9/XmHjZY2uDtfkdLGo0uY12jgcnkX9vXOgYajEKb/jiw67EYm+kBf+6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />


        <!-- plugins:css -->
        <link rel="stylesheet" href="{{asset("vendors/mdi/css/materialdesignicons.min.css")}}">
        <link rel="stylesheet" href="{{asset("vendors/css/vendor.bundle.base.css")}}">
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="{{asset("vendors/jvectormap/jquery-jvectormap.css")}}">
        <link rel="stylesheet" href="{{asset("vendors/flag-icon-css/css/flag-icon.min.css")}}">
        <link rel="stylesheet" href="{{asset("vendors/owl-carousel-2/owl.carousel.min.css")}}">
        <link rel="stylesheet" href="{{asset("vendors/owl-carousel-2/owl.theme.default.min.css")}}">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <!-- endinject -->
        <!-- Layout styles -->
        <link rel="stylesheet" href="{{asset("css/style.css")}}">
        <!-- End layout styles -->
        <link rel="shortcut icon" href="{{asset("images/favicon.png")}}" />

    </head>
    <body class="antialiased">
<div class="container-scroller">
    @include('layouts.sidebar')
    <div class="container-fluid page-body-wrapper">
        @include('layouts.haed')
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('breadcrumb')
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.2/js/bootstrap.min.js" integrity="sha512-5BqtYqlWfJemW5+v+TZUs22uigI8tXeVah5S/1Z6qBLVO7gakAOtkOzUtgq6dsIo5c0NJdmGPs0H9I+2OHUHVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



       <!-- container-scroller -->
       <!-- plugins:js -->
       <script src="{{asset("vendors/js/vendor.bundle.base.js")}}"></script>
       <!-- endinject -->
       <!-- Plugin js for this page -->
       <script src="{{asset("vendors/chart.js/Chart.min.js")}}"></script>
       <script src="{{asset("vendors/progressbar.js/progressbar.min.js")}}"></script>
       <script src="{{asset("vendors/jvectormap/jquery-jvectormap.min.js")}}"></script>
       <script src="{{asset("vendors/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>
       <script src="{{asset("vendors/owl-carousel-2/owl.carousel.min.js")}}"></script>
       <!-- End plugin js for this page -->
       <!-- inject:js -->
       <script src="{{asset("js/off-canvas.js")}}"></script>
       <script src="{{asset("js/hoverable-collapse.js")}}"></script>
       <script src="{{asset("js/misc.js")}}"></script>
       <script src="{{asset("js/settings.js")}}"></script>
       <script src="{{asset("js/todolist.js")}}"></script>
       <!-- endinject -->
       <!-- Custom js for this page -->
       <script src="{{asset("js/dashboard.js")}}"></script>
       <!-- End custom js for this page -->
    </body>
</html>
