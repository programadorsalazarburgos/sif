<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Horarios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../LibreriasExternas/shedule2/assets/css/style.css?v=2020.07.31.4">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
    <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='../LibreriasExternas/fullcalendar-5.2.0/lib/main.css' rel='stylesheet' />
    
    <link rel="stylesheet" href="../bower_components/amcharts/dist/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <script src="../bower_components/amcharts/dist/amcharts/amcharts.js"></script>
    <script src="../bower_components/amcharts/dist/amcharts/serial.js"></script>
    <script src="../bower_components/amcharts/dist/amcharts/themes/light.js"></script>
    <script src="../bower_components/amcharts/dist/amcharts/lang/es.js"></script>
    <script src="../bower_components/amcharts/dist/amcharts/plugins/export/export.min.js"></script>
    <script src="../bower_components/amcharts/dist/amcharts/plugins/dataloader/dataloader.min.js"></script>

    <script src='../LibreriasExternas/fullcalendar-5.2.0/lib/main.js'></script>
    <script src='Js/Consultar_Horario_Atencion.js?v=2020.08.13.0'></script>
  </head>
  <style type="text/css">
    .fc-event-time{
      font-size: 11px !important;
    }
    .fc-event-title-container{
      font-size: 14px !important;
    }
    .fc-timegrid-event:hover{
      background-color: #1c64ab;
    }
    .fc-timegrid-event:focus{
      background-color: #184d9c;
    }
  </style>
  <body><?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
  <div class="container-fluid">
    <div class="panel-success">
      <div class="panel-heading">
        <div class="page-header">
          <h1 style="font-size: 200%;">HORARIOS<small> CREA </small></h1>
        </div>
        <input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-xs-6 col-md-2">
            <label for="SL_CREA"><b>CREA</b></label>
          </div>
          <div class="col-xs-6 col-md-2">
            <label for="SL_AREA_ARTISTICA"><b>ÁREA</b></label>
          </div>
          <div class="col-xs-6 col-md-3">
            <label for="SL_ESTADO"><b>ESTADO</b></label>
          </div>
          <div class="col-xs-6 col-md-2">
            <label for="SL_ARTISTA_FORMADOR"><b>FORMADOR</b></label>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-md-2">
            <select id="SL_CREA" class="form-control selectpicker" multiple data-live-search="true"></select>
          </div>
          <div class="col-xs-6 col-md-2">
            <select id="SL_AREA_ARTISTICA" class="form-control selectpicker" multiple data-live-search="true"></select>
          </div>
          <div class="col-xs-6 col-md-2">
            <select id="SL_ESTADO" class="form-control selectpicker" data-live-search="true">
              <option value="1">ACTIVO</option>
              <option value="2">PRE-GRUPO</option>
              <option value="0">INACTIVO</option>
            </select>
          </div>
          <div class="col-xs-6 col-md-1">
            <button id="BT_CONSULTAR_FILTROS" name="BT_CONSULTAR_FILTROS" class="btn btn-success"><span class="fa fa-search"></span></button>
          </div>
          <div class="col-xs-6 col-md-2">
            <select id="SL_ARTISTA_FORMADOR" class="form-control selectpicker" data-live-search="true"></select>
          </div>
          <div class="col-xs-6 col-md-1">
            <button id="BT_CONSULTAR_FORMADOR" name="BT_CONSULTAR_FORMADOR" class="btn btn-success"><span class="fa fa-search"></span></button>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <p class="alert alert-info">
              Horario semanal de los grupos que corresponden a los filtros seleccionados:
            </p>
          </div>
        </div>
        <div class="row">
          <div id='calendar'></div>
        </div>
      </div>
    </div>
  </div>
  <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 0px;">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: #009f99; margin-left: -0.5px;">
        <h2 class="modal-title" id="modal_title" name="modal_title" style="color:white;"></h2>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="modal_body" name="modal_body">
        <div class="row">
          <div class="col-md-12" style="padding: 5px;">
          <div class="col-md-5 text-right">
            <h4><b style="color: #009f99 !important;">CREA:</b></h4>
          </div>
          <div class="col-md-6">
            <h4 id="INFO_CREA"></h4>
          </div>
          </div>
          <div class="col-md-12" style="padding: 5px;">
          <div class="col-md-5 text-right">
            <h4><b style="color: #009f99 !important;">Área Artística:</b></h4>
          </div>
          <div class="col-md-6">
            <h4 id="INFO_AREA_ARTISTICA"></h4>
          </div>
          </div>
          <div class="col-md-12" style="padding: 5px;">
          <div class="col-md-5 text-right">
            <h4><b style="color: #009f99 !important;">Artista Formador:</b></h4>
          </div>
          <div class="col-md-6">
            <h4 id="INFO_ARTISTA_FORMADOR"></h4>
          </div>
          </div>
          <div class="col-md-12" style="padding: 5px;">
          <div class="col-md-5 text-right">
            <h4><b style="color: #009f99 !important;">Colegio:</b></h4>
          </div>
          <div class="col-md-6">
            <h4 id="INFO_COLEGIO"></h4>
          </div>
          </div>
          <div class="col-md-12" style="padding: 5px;">
          <div class="col-md-5 text-right">
            <h4><b style="color: #009f99 !important;">Matriculados:</b></h4>
          </div>
          <div class="col-md-6">
            <button class="btn btn-success btn-sm" id="BT_BENEFICIARIOS_MATRICULADOS"><h4 style="color: white;" id="INFO_BENEFICIARIOS_MATRICULADOS">23</h4></button>
          </div>
          </div>
          <div class="col-md-12" style="padding: 5px;">
              <table id="table_matriculados" class="table table-striped table-bordered table-hover display nowrap" style="width:100%;" hidden>
                <thead>
                  <th><b>IDENTIFICACION</b></th>
                  <th><b>NOMBRE</b></th>
                  <th><b>FECHA INGRESO</b></th>
                </thead>
                <tbody id="table_matriculados_body">
                  
                </tbody>
              </table>
          </div>
          <div class="col-md-12" style="padding: 5px;">
          <div class="col-md-5 text-right">
            <h4><b style="color: #009f99 !important;">Atendidos (Acumulado):</b></h4>
          </div>
          <div class="col-md-6">
            <button class="btn btn-success btn-sm" id="BT_BENEFICIARIOS_ACUMULADO"><h4 style="color: white;" id="INFO_BENEFICIARIOS_ATENDIDOS_ACUMULADO">30</h4></button>
          </div>
          </div>
          <div class="col-md-12" style="padding: 5px;">
              <table id="table_acumulado" class="table table-striped table-bordered table-hover display nowrap" style="width:100%;" hidden>
                <thead>
                  <th><b>IDENTIFICACION</b></th>
                  <th><b>NOMBRE</b></th>
                  <th><b>PRIMER ASISTENCIA</b></th>
                  <th><b># ASISTENCIAS</b></th>
                </thead>
                <tbody id="table_acumulado_body">
                </tbody>
              </table>
          </div>
          <div class="col-md-12 text-center" style="padding: 5px;">
            <h4><b style="color: #009f99 !important;">Atención Mensual</b></h4>
          </div>
          <div class="col-md-12 text-center" style="padding: 5px;">
            <div id="chart_atencion_mensual" style="height: 300px !important;">
                
            </div>
          </div>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
  </body>
</html>