<?php
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location:index.php");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/Siclan.css?v=1" rel="stylesheet" type="text/css" media="all" >
    <link href="css/Bienvenida.css?v=6" rel="stylesheet" type="text/css" media="all" >
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/amcharts.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/pie.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/serial.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/gauge.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/themes/light.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/themes/chalk.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/lang/es.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/plugins/export/export.min.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/plugins/dataloader/dataloader.min.js"></script>

    <script src="LibreriasExternas/ammap/ammap.js"></script>
  	<script src="LibreriasExternas/ammap/themes/light.js"></script>

   <script src="js/bienvenida_version.js?v=1.5"></script>
</head>
<body>
   <div class="head">
      <div class="subhead">COBERTURA POR LOCALIDAD</div>
   </div>
   <div class="content-bienvenida" style="height: 500px;">
      <div id="mapdiv" style="width: 100%; background-color:#eeeeee; height: 500px;"></div>
   </div>

   <div class="head">
      <div class="subhead"><b>S</b>istema <b>I</b>ntegrado de <b>F</b>ormaci??n, ??ltima Actualizaci??n <strong>FEBRERO 13/2018</strong></div>
   </div>
   <div class="content-bienvenida">
        <div class="collumns">
            <div class="collumn">
                <div class="head"><span class="headline hl1">REGISTRO DE ASISTENCIAS SIN RESTRICCI??N</span>
                    <p>
                        <span class="headline hl6">
                            Durante el mes de Febrero est?? habilitado el calendario de registro de asistencias de todos los d??as, lo c??al quiere decir que podr??s registrar asistencia de d??as anteriores unicamente para este mes.
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div>
        <a href="ConsultasReportes/Consultar_Grupos.php" id="btn-grupos-activos" class="btn btn-md btn-primary form-control"></a>
    </div>
    <div>
        <a href="ConsultasReportes/Consultar_Grupos.php" id="btn-grupos-inactivos" class="btn btn-md btn-danger form-control"></a>
    </div>
    <div id="contenedor_graphs" hidden>
        <div class="panel-body">
            <ul class="nav nav-tabs" id="navs" role="tablist">
                <li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#2017" role="tab">2017</a></li>
                <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#2018" role="tab">2018</a></li>-->
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="2017" role="tabpanel">

                <div class="tituloCharts">
                    <h4>GR??FICA DE ATENCIONES POR CREA - L??NEA AE</h4>
                </div>
                <div id="chartdiv"></div>
                <div  class="tituloCharts">
                    <h4>GR??FICA ATENCIONES POR MES - L??NEAS AE Y EC</h4>
                </div>
                <div id="chartdiv4" class="chartdiv"></div>
                <div class="tituloCharts">
                    <h4>GR??FICA POR GENERO - L??NEA AE</h4>
                </div>
                <div id="chartdiv2" class="chartdiv"></div>
                <div class="tituloCharts">
                    <h4>ATENDIDOS VS META - L??NEA AE</h4>
                </div>
                <div id="chartdiv3" class="chartdiv"></div>
            </div>
            <div class="tab-pane" id="2018" role="tabpanel">
            </div>
        </div>
    </div>
</body>
</html>
