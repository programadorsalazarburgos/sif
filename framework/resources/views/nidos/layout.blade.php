<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @yield('titulo')
  <link rel="shortcut icon" href="{{ asset('images/faviconsif.png') }}">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href=" {{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href=" {{ asset('dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="/sif/framework/node_modules/sweetalert2/dist/sweetalert2.min.css">
  <script src="/sif/framework/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="/sif/framework/node_modules/amcharts3/amcharts/plugins/export/export.css">

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

  <!-- DataTables -->
  <link rel="stylesheet" href="/sif/framework/node_modules/datatables.net-dt/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="/sif/framework/node_modules/datatables.net-responsive-dt/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="/sif/framework/node_modules/datatables.net-buttons-dt/css/buttons.dataTables.min.css">

  <script src="/sif/framework/node_modules/jszip/dist/jszip.min.js"></script>
  <script src="/sif/framework/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="/sif/framework/node_modules/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
  <script src="/sif/framework/node_modules/datatables.net-buttons-dt/js/buttons.dataTables.min.js"></script>
  <script src="/sif/framework/node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script>

</head>
<style>
  .modal-backdrop {
      background-color: #00000085 !important;
  }
</style>

<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px !important;">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          @yield('contenido')
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer" style="margin-left: 0px !important;">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        IDARTES
      </div>
      <!-- Default to the left -->
      <strong>Sistema Integrado de Formación - SIF.</strong>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

  <script src="{{ asset('js/nidos/app.js') }}"></script>

</body>

</html>