<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Centro de Monitoreo</title>
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
  <link rel="stylesheet" href="/sif/framework/node_modules/vue-multiselect/dist/vue-multiselect.min.css">
  <script type="text/javascript">
  var csrfToken = $('[name="csrf_token"]').attr('content');
  setInterval(refreshToken, 300000); // 5 minutos
  function refreshToken(){
      $.get('refresh-csrf').done(function(data){
          csrfToken = data; // the new token
      });
  }
  setInterval(refreshToken, 300000); // 5 minutos
  </script>
  <style>
    #chartdiv {
      width: 100%;
      height: 100%;
    }

    #chartdiv_alcance_crea,
    #chartdiv_alcance_nidos {
      width: 100%;
      height: 230px !important;
    }

    .dirty {
      border-color: #5A5 !important;
    }

    .dirty:focus {
      outline-color: #8E8 !important;
    }

    .error {
      border-color: #d0d0d0 !important;
      font-size: 12px;
    }

    .error:focus {
      outline-color: #F99 !important;
    }

    .modal-backdrop {
      background-color: #00000085 !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Inicio</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="https://sif.idartes.gov.co" class="nav-link">SIF</a>
        </li>
      </ul>

      <!-- SEARCH FORM 
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    -->

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fas fa-th-large"></i></a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #4f3483 !important; height:100vh !important;">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="/sif/framework/public/images/faviconsif.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Centro de Monitoreo</span>
      </a>
      <menuprincipal></menuprincipal>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="padding-top: 5px !important;">
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

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Info Extra</h5>
        <p>Información de Contacto</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        IDARTES
      </div>
      <!-- Default to the left -->
      <strong>Centro de Monitoreo del Sistema de Información <a href="https://sif.idartes.gov.co">SIF</a>.</strong>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

  <script src="{{ asset('js/cdm/app.js') }}"></script>
        
  <script src="/sif/framework/node_modules/amcharts3/amcharts/amcharts.js"></script>
  <script src="/sif/framework/node_modules/ammap3/ammap/ammap.js"></script>
  <script src="/sif/framework/node_modules/ammap3/ammap/themes/light.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/pie.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/serial.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/gauge.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/themes/light.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/themes/chalk.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/themes/black.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/themes/dark.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/themes/patterns.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/lang/es.js"></script>
  <script src="/sif/framework/node_modules/amcharts3/amcharts/plugins/export/export.min.js"></script>
</body>

</html>