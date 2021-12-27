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
  <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
  <link href="../css/Siclan.css" rel="stylesheet">
  <link href="Css/fichaCrea.css?v=2021.03.02.0" rel="stylesheet">
  <script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js"></script>
  <link href="../bower_components/alertifyjs/build/css/alertify.css?v=1" rel="stylesheet" type="text/css" >
  <script src="../bower_components/alertifyjs/build/alertify.min.js?v=1"></script>
  <link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css">
  <link href="Css/bootstrap-select.css" rel="stylesheet" rel="stylesheet">
  <link rel="stylesheet" href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.3.2/css/colReorder.dataTables.min.css">
  <script src="../bower_components/jquery/dist/jquery.min.js"></script>
  <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtqVeR4UVEwznRGYOb5lv2A1UlP8damKk"></script>
  <script type="text/javascript" src="../bootstrap/bootstrap-filestyle/bootstrap-filestyle.js"> </script>
  <script type="text/javascript" src="../js/bootbox.js"></script>
  <script src="Js/bootstrap-select.js"></script>
  <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../bower_components/jszip/dist/jszip.js"></script>
  <script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="../bower_components/amcharts/dist/amcharts/amcharts.js"></script>
  <script src="../bower_components/amcharts/dist/amcharts/serial.js"></script>
  <script src="../bower_components/amcharts/dist/amcharts/plugins/export/export.js"></script>
  <link rel="stylesheet" href="../bower_components/amcharts/dist/amcharts/plugins/export/export.css" type="text/css" media="all"/>
  <script type="text/javascript" src="Js/FichaCrea.js?v=2021.04.16.1"></script>
</head>

<body>
  <div class="col-sm-10 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1">
    <h2 class="head"><i class="fa fa-list-alt"></i> FICHA CREA
      <select id="SL_CREA" name="SL_CREA" class="selectpicker" title="Seleccione un CREA" data-live-search="true">
        <option value="">Por favor seleccione el CREA que desea ver</option>
      </select></h2>
    </div>
    <div>
      <div id="div_jumbotron" name="div_jumbotron" class="col-md-12 jumbotron">
        <center><h4><i class='fa fa-info-circle'></i> SELECCIONE UN CREA DE LA LISTA PARA DESPLEGAR LA FICHA</h4></center>
      </div>
    </div>
    <div id="div_ficha_crea" name="div_ficha_crea" class="col-sm-10 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1" hidden>
      <div class="col-md-12 header">
        <h4><i class='fa fa-info-circle'></i> REGISTRO FOTOGRÁFICO</h4>
      </div>
      <div class="col-md-12 col-centered" id="div_carousel" style="width: 50%;">
      </div>
      <div class="col-md-12 header">
        <h4><i class='fa fa-info-circle'></i> Información General 
          <span id="botones-info-general" hidden><a class='fas fa-save a-save' data-seccion='info-general'></a></span>
          <span class="span-edit"><a class='fas fa-pencil-alt a-edit' data-seccion='info-general'></a></span>
        </h4>
      </div>
      <div id="div_informacion_general"> 
      </div>
      <div class="col-md-12 header">
        <h4><i class='fa fa-users'></i> Asistentes Administrativos
          <span id="botones-asistentes-administrativos" hidden><a class='fas fa-save a-save' data-seccion='asistentes-administrativos'></a></span>
          <span class="span-edit"><a class='fas fa-pencil-alt a-edit' data-seccion='asistentes-administrativos'></a></span>
        </h4>
      </div>
      <div id="div_asistentes_administrativos">
      </div>
      <div class="col-md-12 header">
        <h4><i class='fa fa-cogs'></i> Auxiliares Operativos
          <span id="botones-auxiliares-operativos" hidden><a class='fas fa-save a-save' data-seccion='auxiliares-operativos'></a></span>
          <span class="span-edit"><a class='fas fa-pencil-alt a-edit' data-seccion='auxiliares-operativos'></a></span>
        </h4>
      </div>
      <div id="div_auxiliares_operativos">
      </div>
      <div id="div_general">
      </div>
      <div class="col-md-6 header-middle">
        <h4><i class='fa fa-paint-brush'></i> ATENCIÓN POR LINEA Y AREAS ARTÍSTICAS</h4>
      </div>
      <div class="col-md-6 header-middle">
        <h4><i class='fa fa-child'></i> ATENCIÓN EN IMPULSO COLECTIVO (# TALLERES)</h4>
      </div>
      <div id="chartdiv_areas_artisticas" class='col-md-6'></div>
      <div id="chartdiv_emprende_crea" class='col-md-6'></div>
    </div>

  </div>

  <div class="modal fade" id="modal_archivos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="modal-titulo" class="modal-title">DOCUMENTOS</h4>
      </div>
      <div class="modal-body">
        <form id="FORM_ARCHIVOS" name="FORM_ARCHIVOS" enctype="multipart/form-data">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-info" style="padding:5px; border-style: groove;">
              <p><strong>El tamaño máximo del envío es de 30 Megabytes.</strong></p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor_anexos">
              <div id="div_archivo" class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <input id="archivos_crea" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" multiple required>
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <button type="submit" class="btn btn-success" id="enviar_fotografias">Enviar</button>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <br>
          </div>
          <div id="archivos_adjuntos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-danger" style="padding:5px; border-style: groove;">
            <p><strong>Estos son los archivos que se van a subir:</strong></p>
            <p>No ha seleccionado ninguno</p>
          </div>
        </form>
        <table id="tabla-archivos" class="table table-hover" style="width:100%">
          <thead>
            <tr>
              <th>Nombre Archivo</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody id="tbody-archivos">
          </tbody>
        </table>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_espacios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">ESPACIOS</h4>
    </div>
    <div class="modal-body">
      <div id="div_tabla_espacios">
        <form id="FORM_ESPACIOS" name="FORM_ESPACIOS" enctype="multipart/form-data">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <input id="TX_NOMBRE_ESPACIO" type="text" class="form-control" data-buttonName="btn-primary" placeholder="Nombre del espacio (Ej: SALÓN #)" required>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <br>
              <select id="SL_NIVEL" class="form-control" data-buttonName="btn-primary" title="Nivel" required>
                <option value="">Seleccione el nivel (piso)</option>
                <option value="-1">SÓTANO</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
              </select>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 pull-right">
              <br>
              <button type="submit" class="btn btn-success">GUARDAR</button>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <br>
          </div>
        </form>
        <table id="tabla-espacios" class="table table-hover" style="width:100%">
          <thead>
            <tr>
              <th>PK_Id_Tabla</th>
              <th>FK_Id_Crea</th>
              <th>Nombre</th>
              <th>Nivel</th>
              <th>Descripción</th>
              <th>Area Artística</th>
              <th>Capacidad</th>
              <th>Estado</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody id="tbody-espacios">
          </tbody>
        </table>
      </div>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_areas_artisticas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">ÁREAS ARTÍSTICAS</h4>
    </div>
    <div class="modal-body">
      <form id="FORM_AREAS_ARTISTICAS" name="FORM_AREAS_ARTISTICAS" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-12">
            <select id="SL_AREAS_ARTISTICAS" class="form-control" data-buttonName="btn-primary" title="Nivel" required>
              <option value="">Seleccione Área(s) Artística(s)</option>
            </select>
          </div>
          <div class="col-md-12">
            <br>
            <input id="TX_NOMBRE_ESPACIO" type="text" class="form-control" data-buttonName="btn-primary" placeholder="Nombre del espacio (Ej: SALÓN 1)" required>
          </div>
          <div class="col-md-12">
            <input id="TX_NOMBRE_ESPACIO" type="text" class="form-control" data-buttonName="btn-primary" placeholder="Nombre del espacio (Ej: SALÓN 1)" required>
          </div>
          <div class="col-md-12">
            <input id="TX_NOMBRE_ESPACIO" type="text" class="form-control" data-buttonName="btn-primary" placeholder="Nombre del espacio (Ej: SALÓN 1)" required>
          </div>
          <div class="col-md-12">
            <input id="TX_NOMBRE_ESPACIO" type="text" class="form-control" data-buttonName="btn-primary" placeholder="Nombre del espacio (Ej: SALÓN 1)" required>
          </div>
          <div class="col-md-12">
            <input id="TX_NOMBRE_ESPACIO" type="text" class="form-control" data-buttonName="btn-primary" placeholder="Nombre del espacio (Ej: SALÓN 1)" required>
          </div>
          <div class="col-md-12">
            <input id="TX_NOMBRE_ESPACIO" type="text" class="form-control" data-buttonName="btn-primary" placeholder="Nombre del espacio (Ej: SALÓN 1)" required>
          </div>
        </div>
        <div class="row justify-content-md-center">
          <div class="col-md-3 pull-right">
            <br>
            <button type="submit" class="btn btn-success">GUARDAR</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <img src="../imagenes/enviando.gif" width="100%">      
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body> 
</html>