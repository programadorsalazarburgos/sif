<!DOCTYPE html>
<html>
<style type="text/css">
  .enlaces-index {
    background-color: #66429a !important;
    border: none;
    color: #ffffff !important;
    text-align: center;
    transition: 0.3s;
  }
  .enlaces-index:hover {
    opacity: 1;
    background-color: #ffffff !important;
    color: #66429a !important;
  }
  .centered {
    float: none !important;
    margin: 0 auto;
  }
</style>
<head>
  <title>CENTRO DE MONITOREO</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Sistema Integrado de formación, nidos y crea">
  <meta name="Keywords" content="SIF, sistema integrado de formación, sicrea, sicrea.gov.co, si.clan, si.clan.gov.co, idartes, nidos">
  <meta name="author" content="Componente de Información e innovación Digital">
  <link rel="shortcut icon" href="imagenes/faviconsif.png">
  <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"  type="text/css">
  <link href="bower_components/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet"  type="text/css">
  <link href="bower_components/alertifyjs/build/css/alertify.min.css" rel="stylesheet"  type="text/css">
  <link href="css/Siclan.css?v=2020.03.09.0" rel="stylesheet">
  <link rel="stylesheet" href="bower_components/amcharts/dist/amcharts/plugins/export/export.css" type="text/css" media="all" />

  <link rel="stylesheet" href="css/CDM.css?v?2018.11.14.1" type="text/css" rel="stylesheet">

  <link href="bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" rel="stylesheet">

  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="LibreriasExternas/sweetalert2/sweetalert2.min.css">
  <script src="LibreriasExternas/sweetalert2/sweetalert2.min.js"></script>
  <script src="js/Siclan.js?v=695"></script>

  <script src="js/CDM.js?v=2019.07.30.6"></script>

  <script type="text/javascript" src="js/funcionesGenerales.js?v=2018.11.28.12"></script>

  <script src="bower_components/amcharts/dist/amcharts/amcharts.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/pie.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/serial.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/gauge.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/themes/light.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/themes/chalk.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/themes/black.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/themes/dark.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/themes/patterns.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/lang/es.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/plugins/export/export.min.js"></script>
  <script src="bower_components/amcharts/dist/amcharts/plugins/dataloader/dataloader.min.js"></script>
  <script src="bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>


  <script src="LibreriasExternas/ammap/ammap.js"></script>
  <script src="LibreriasExternas/ammap/themes/light.js"></script>

  <script>
    window.open = function() {};
    window.print = function() {};
    if (false) {
      window.ontouchstart = function() {};
    }
  </script>
</head>
<body>
  <div class="row header">
    <div class="col-xs-12 col-md-3 row-centered">
      <img src="imagenes/logo-idartes.png" class="logos-cdm-header">
    </div>
    <div class="col-xs-12 col-md-6 row-centered"><h2>CENTRO DE MONITOREO</h2><h3>Sub Dirección de Formación Artística</h3></div>
    <div class="col-xs-12 col-md-3 row-centered">
      <div id="menu_responsive_inicio">
        <button id="boton_menu_inicio">
          <span class="linea_inicio"></span>
          <span class="linea_inicio"></span>
          <span class="linea_inicio"></span>
        </button>
      </div>
      <img src="imagenes/logo-crea-header.png" id="logo-crea-header" class="logos-cdm-header">
      <img src="imagenes/logo-nidos-header.png" id="logo-nidos-header" class="logos-cdm-header">
    </div>

  </div>
  <div class="row">
    <div class="col-md-10 col-md-offset-1" id="contenedorMenu">
      <ul class="nav nav-pills nav-justified" id="menu-top">
        <li role="presentation"><a data-toggle="tab" href="#div_inicio" class="seccion" role="tab" data-seccion='1'>INICIO</a></li>
        <li role="presentation"><a data-toggle="tab" href="#div_subdireccion" class="seccion" role="tab" data-seccion='2'>SUBDIRECCIÓN DE FORMACIÓN</a></li>
        <li role="presentation"><a data-toggle="tab" href="#div_contenedor" class="seccion" role="tab" data-seccion='3'>NIDOS</a></li>
        <li role="presentation"><a data-toggle="tab" href="#div_contenedor" class="seccion" role="tab" data-seccion='4'>CREA</a></li>
      </ul>
    </div>
  </div>
  <div class="row tab-content">
    <div class="tab-pane" id="div_inicio" role="tabpanel">
      <div class="row">
        <div class="col-xs-8 col-md-8 col-md-offset-2 text-center">
          <div class="col-md-4">
            <br>
            <img src="imagenes/estadistica.png" width="300">
            <p>El tablero de monitoreo y control de la formación, permite hacer seguimiento estadístico a todos los aspectos de la formación:</p>
            <p><b>1.</b> Cobertura</p>
            <p><b>2.</b> Asistencia</p>
            <p><b>3.</b> Permanencia</p>
            <p><b>4.</b> Deserción</p>
            <p><b>5.</b> Infraestructura</p>
            <p><b>6.</b> Artistas y Formadores</p>
          </div>
          <br>
          <div class="col-md-8" style="border-style: outset; background-color: ghostwhite; border-radius: 3%;">
            <br>
            <h4>AÑO DE CONSULTA <a class="btn btn-default anio_inicio">2016</a><a class="btn btn-default anio_inicio">2017</a><a class="btn btn-default anio_inicio">2018</a><a id="year2019" class="btn btn-default anio_inicio" style="background-color: teal; color: white;">2019</a></h4>
            <div style="border-style: ridge;">
              <h5>TOTAL SUBDIRECCIÓN</h5>
              <h4 id="subdireccion_anual"></h4>
            </div>
            <br>
            <div id="atencion_programa_linea" style="border-style: ridge;">
            </div>
            <br>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane" id="div_subdireccion" role="tabpanel">
      <div class="row">
        <br><br>
        <div class="col-md-10 col-md-offset-1">
          <div class="col-xs-12 col-md-12 col-sm-12 text-center bg-default card-indicador">
            <div class="col-md-12">
              <h5>Comparativo de género (CREA y NIDOS)</h5>
            </div>
            <p></p>
            <div id="chartdivsub1" class="col-md-6 col-lg-6"></div>
            <div id="chartdivsub2" class="col-md-6 col-lg-6"></div>
            <div class="col-md-12">
              <h5>Comparativo por Localidad (CREA y NIDOS)</h5>
            </div>
            <div id="chartdivsub3" class="col-md-12 col-lg-12"></div>
            <div id="chartdivsub4" class="col-md-12 col-lg-12"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane" id="div_contenedor" role="tabpanel">
    </div>
    <footer class="row">
      <div class="col-md-2 col-md-offset-5 row-centered">
        <img src="imagenes/logo-alcaldia.png?v=07.02.2020.0" class="logo-alcaldia-header">
      </div>
    </footer>

    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg" id="modal_graph" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modal_title">Título de la gráfica</h4>
          </div>
          <div class="modal-body">
            <div id="description_div">
              <h5 id="descripcion" name="descripcion">Aquí la descripción</h5>
            </div>
            <div id="filter_div">
              <span>FILTROS</span>
              <span id="div_SL_ANIO" name="div_SL_ANIO" class="div_select">
                <select id="SL_ANIO" name="SL_ANIO" class="filtro">
                </select>
              </span>
              <span id="div_SL_MES" name="div_SL_MES" class="div_select">
                <select id="SL_MES" name="SL_MES" class="filtro">
                </select>
              </span>
              <span id="div_SL_LOCALIDAD" name="div_SL_LOCALIDAD" class="div_select">
                <select id="SL_LOCALIDAD" name="SL_LOCALIDAD" class="filtro">
                </select>
              </span>
              <span id="div_SL_CREA" name="div_SL_CREA" class="div_select">
                <select id="SL_CREA" name="SL_CREA" class="filtro">
                </select>
              </span>
              <span id="div_SL_TERRITORIO" name="div_SL_TERRITORIO" class="div_select">
                <select id="SL_TERRITORIO" name="SL_TERRITORIO" class="filtro">
                </select>
              </span>
              <span id="div_SL_LOCALIDAD_NIDOS" name="div_SL_LOCALIDAD_NIDOS" class="div_select">
                <select id="SL_LOCALIDAD_NIDOS" name="SL_LOCALIDAD_NIDOS" class="filtro">
                </select>
              </span>
              <span id="div_SL_LUGAR_ATENCION" name="div_SL_LUGAR_ATENCION" class="div_select">
                <select id="SL_LUGAR_ATENCION" name="SL_LUGAR_ATENCION" class="filtro">
                </select>
              </span>
              <span id="div_SL_LINEA_CREA" name="div_SL_LINEA_CREA" class="div_select">
                <select id="SL_LINEA_CREA" name="SL_LINEA_CREA" class="filtro selectpicker">
                  <option value="1">Arte en la Escuela</option> <!-- AE -->
                  <option value="2">Impulsa CREA</option> <!-- EC -->
                  <option value="3">Converge CREA</option> <!-- LC -->
                </select>
              </span>
              <span id="div_SL_LINEA_NIDOS" name="div_SL_LINEA_NIDOS" class="div_select">
                <select id="SL_LINEA_NIDOS" name="SL_LINEA_NIDOS" class="filtro">
                </select>
              </span>
              <span id="div_SL_UPZ" name="div_SL_UPZ" class="div_select">
                <select id="SL_UPZ" name="SL_UPZ" class="filtro selectpicker">
                </select>
              </span>
              <span id="div_SL_COLEGIO" name="div_SL_COLEGIO" class="div_select">
                <select id="SL_COLEGIO" name="SL_COLEGIO" class="filtro selectpicker"  data-live-search="true">
                </select>
              </span>
              <span id="div_SL_LUGAR_NIDOS" name="div_SL_LUGAR_NIDOS" class="div_select">
                <select id="SL_LUGAR_NIDOS" name="SL_LUGAR_NIDOS" class="filtro selectpicker"  data-live-search="true">
                </select>
              </span>
              <span id="div_SL_AREA_CREA" name="div_SL_AREA_CREA" class="div_select">
                <select id="SL_AREA_CREA" name="SL_AREA_CREA" class="filtro selectpicker"  data-live-search="true">
                </select>
              </span>
              <span id="div_SL_GRUPO" name="div_SL_GRUPO" class="div_select">
                <select id="SL_GRUPO" name="SL_GRUPO" class="filtro selectpicker"  data-live-search="true">
                </select>
              </span>
            </div>
            <div id="chartdiv"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </body>
  <header class="row">
    <div class="banner-abajo container-fluid" style="position: fixed; height: 8.05rem;">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 logos-abajo" style="width: 105%; margin-left: -30px;">
        <div class="container-fluid" style="background-color: #4f3483; padding: 0.5%; margin-bottom: 50px">
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <img src="imagenes/crea-blanco.png" style="width:10rem !important;">
            <img src="imagenes/nidos-blanco.png" style="width:10rem !important; margin-left: 2vh !important;">
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <img src="imagenes/bogota-blanco.png" class="pull-right" style="width:12rem !important; margin-right: 3%">
          </div>
          <div class="logo-footer">
          </div>
        </div>
      </div>
    </div>
  </header>
  </html>
