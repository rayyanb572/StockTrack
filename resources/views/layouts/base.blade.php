<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Config::get('app.name') }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/fontawesome-free-6.4.0/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">


    <link rel="shortcut icon" href="{{ asset('img/logistyx1.png') }}" type="image/x-icon" class="rounded-circle">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @includeIf('layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @includeIf('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @section('badge')
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>

                                @show
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <section class="content">
                @yield('content')
            </section>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Presented <a href="{{ route('dashboard') }}">{{ Config::get('app.name') }}</a>.</strong>
            Created by Klaten
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 0.1.15
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('AdminLTE-3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE-3/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('AdminLTE-3/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('AdminLTE-3/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('AdminLTE-3/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('AdminLTE-3/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('AdminLTE-3/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('AdminLTE-3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('AdminLTE-3/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('AdminLTE-3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-3/dist/js/adminlte.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('AdminLTE-3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/bootstrapValidator.min.js') }}"></script>
    <script>
        function preview(selector, temporaryFile, width = 200) {
            $(selector).empty();
            $(selector).append(`<img src="${window.URL.createObjectURL(temporaryFile)}" width="${width}">`);
        }

    </script>
    @stack('scripts')

</body>

</html>
