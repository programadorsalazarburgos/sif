<?php
session_start();
if(!isset($_SESSION["session_username"])) {
  header("location:../index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Administración Ocupación CREA</title>
  <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="../bower_components/jquery/dist/jquery.min.js"></script>
  <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js"></script>
  <link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
  <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
  <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

  <script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
  <script src="../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
  <script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

  <link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
  <script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

  <link href="../bower_components/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" >
  <script src="../bower_components/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript" ></script>

  <script type="text/javascript" src='../bower_components/pdfmake/build/pdfmake.min.js'></script>
  <script type="text/javascript" src='../bower_components/pdfmake/build/vfs_fonts.js'></script>

  <script type="text/javascript" src="Js/AdministrarOcupacionCREA.js?v=2021.08.03.1"></script>
</head>
<body>
  <?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
  <div class="container-fluid">
    <div class="panel panel-success">
      <div class="panel-heading">
        <div class="page-header">
          <h1>Administración Ocupación<small> CREA</small></h1>
        </div>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item active" ><a id="nav_registrar_ocupacion" class="nav-link" data-toggle="tab" href="#panel_registrar_ocupacion" role="tab">Registrar Ocupación</a></li>
          <li class="nav-item"><a id="nav_modificar_ocupacion" class="nav-link" data-toggle="tab" href="#panel_modificar_ocupacion">Modificar Ocupación</a></li>
          <li class="nav-item"><a id="nav_consultar_ocupacion" class="nav-link" data-toggle="tab" href="#panel_consultar_ocupacion">Consultar Ocupaciones</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="panel_registrar_ocupacion" role="tabpanel">
            <form id="form_nuevo_registro_ocupacion">
              <div class="row">
                <div class="col-xs-12 col-md-12 text-center bg-info">
                  <h4>Registrar Ocupación</h4>
                </div>
              </div>
              <legend>Datos de la ocupación</legend>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="SL_crea" class="pull-right">CREA:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <select required="required" class="form-control selectpicker" title="Seleccione CREA" name="SL_crea" id="SL_crea" data-live-search="true" data-style="btn-primary"></select>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_nombre_actividad" class="pull-right">Nombre de la actividad:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="text" class="form-control" name="TX_nombre_actividad" id="TX_nombre_actividad" placeholder="Nombre de la actividad" />
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_descripcion_actividad" class="pull-right">Descripción de la actividad:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <textarea required="required" class="form-control" name="TX_descripcion_actividad" id="TX_descripcion_actividad" placeholder="Indicar información de préstamos de espacios, eventos, practicantes, nidos u otros que lo ocupan. Institución encargada de la reunión, tema o asunto de reunión. etc"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_responsable" class="pull-right">Responsable de la actividad:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="text" class="form-control" name="TX_responsable" id="TX_responsable" placeholder="Responsable de la actividad" />
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="IN_total_asistentes" class="pull-right">Número de asistentes:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="number" class="form-control" name="IN_total_asistentes" id="IN_total_asistentes" placeholder="Número de asistentes" min="0" max="500" value="0"/>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label class="pull-right">Salón(es) (Crear en <a href="../Infraestructura/FichaCrea.php" target="ventana_iframe">Ficha Crea</a>):</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <select class="form-control selectpicker" data-live-search="true" name="SL_salones" id="SL_salones" title="Seleccione el(los) salón(es) ocupados en la actividad" required="required" multiple>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_fecha_hora_inicio" class="pull-right">Fecha y hora inicio:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="text" class="form-control" name="TX_fecha_hora_inicio" id="TX_fecha_hora_inicio" placeholder="Fecha y hora inicio" />
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_fecha_hora_fin" class="pull-right">Fecha y hora fin:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="text" class="form-control" name="TX_fecha_hora_fin" id="TX_fecha_hora_fin" placeholder="Fecha y hora fin" />
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-12">
                  <input type="submit" class="form-control btn btn-success" name="BT_guardar_nueva_ocupacion" id="BT_guardar_nueva_ocupacion" value="Guardar" />
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="panel_modificar_ocupacion" role="tabpanel">
            <form id="form_modificar_registro_ocupacion">
              <div class="row">
                <div class="col-xs-12 col-md-12 text-center bg-info">
                  <h4>Modificar Ocupación</h4>
                </div>
              </div>
              <legend>Datos de la ocupación a modificar</legend>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="SL_crea_modificar_ocupacion" class="pull-right">Seleccione CREA:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <select class="form-control selectpicker" title="Seleccione CREA" name="SL_crea_modificar_ocupacion" id="SL_crea_modificar_ocupacion" data-live-search="true" data-style="btn-success"></select>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="SL_ocupacion_modificar" class="pull-right">Seleccione ocupación a modificar:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <select class="form-control selectpicker" title="Seleccione ocupación a modificar" name="SL_ocupacion_modificar" id="SL_ocupacion_modificar" data-live-search="true" data-style="btn-warning"></select>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_nombre_actividad_modificar" class="pull-right">Nombre de la actividad:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="text" class="form-control" name="TX_nombre_actividad_modificar" id="TX_nombre_actividad_modificar" placeholder="Nombre de la actividad" />
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_descripcion_actividad_modificar" class="pull-right">Descripción de la actividad:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <textarea required="required" class="form-control" name="TX_descripcion_actividad_modificar" id="TX_descripcion_actividad_modificar" placeholder="Indicar información de préstamos de espacios, eventos, practicantes, nidos u otros que lo ocupan. Institución encargada de la reunión, tema o asunto de reunión. etc"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_responsable_modificar" class="pull-right">Responsable de la actividad:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="text" class="form-control" name="TX_responsable_modificar" id="TX_responsable_modificar" placeholder="Responsable de la actividad" />
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="IN_total_asistentes_modificar" class="pull-right">Número de asistentes:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="number" class="form-control" name="IN_total_asistentes_modificar" id="IN_total_asistentes_modificar" placeholder="Número de asistentes" min="0" max="500" value="0"/>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label class="pull-right">Salón(es) (Crear en <a href="../Infraestructura/FichaCrea.php" target="ventana_iframe">Ficha Crea</a>):</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <select class="form-control selectpicker" data-live-search="true" name="SL_salones_modificar" id="SL_salones_modificar" title="Seleccione el(los) salón(es) ocupados en la actividad" required="required" multiple>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_fecha_hora_inicio_modificar" class="pull-right">Fecha y hora inicio:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="text" class="form-control" name="TX_fecha_hora_inicio_modificar" id="TX_fecha_hora_inicio_modificar" placeholder="Fecha y hora inicio" />
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                  <label for="TX_fecha_hora_fin_modificar" class="pull-right">Fecha y hora fin:</label>
                </div>
                <div class="col-xs-12 col-md-9">
                  <input required="required" type="text" class="form-control" name="TX_fecha_hora_fin_modificar" id="TX_fecha_hora_fin_modificar" placeholder="Fecha y hora fin" />
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-12">
                  <input type="submit" class="form-control btn btn-success" name="BT_guardar_modificar_ocupacion" id="BT_guardar_modif_ocupacion" value="Modificar Ocupación" />
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="panel_consultar_ocupacion" role="tabpanel">
            <div class="row">
              <div class="col-xs-12 col-md-12 text-center bg-info">
                <h4>Consultar Ocupaciones de un CREA</h4>
              </div>
            </div>
            <legend>Ocupaciones registradas en un CREA</legend>
            <div class="row">
              <div class="col-xs-6 col-md-3">
                <legend>Seleccione CREA</legend>
              </div>
              <div class="col-xs-12 col-md-9">
                <select class="form-control selectpicker" title="Seleccione CREA" name="SL_crea_consultar_ocupaciones" id="SL_crea_consultar_ocupaciones" data-live-search="true" data-style="btn-warning"></select>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6 col-md-3">
                <legend>Seleccione mes y año</legend>
              </div>
              <div class="col-xs-6 col-md-2">
                <select class="form-control selectpicker" title="Seleccione MES" name="SL_mes_reporte_ocupacion" id="SL_mes_reporte_ocupacion" data-live-search="true" data-style="btn-primary"></select>
              </div>
              <div class="col-xs-6 col-md-2">
                <select class="form-control selectpicker" title="Seleccione AÑO" name="SL_anio_reporte_ocupacion" id="SL_anio_reporte_ocupacion" data-live-search="true" data-style="btn-primary"></select>
              </div>
              <div class="col-xs-6 col-md-1">
                <a class="btn btn-primary" title="Descargar PDF mensual" id="BT_descargar_reporte_ocupacion"><span class="fas fa-download"></span> PDF mensual</a>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-md-12">
                <div class="table table-responsive">
                  <table class="table table-bordered" id="table_ocupaciones">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Responsable</th>
                        <th>Total Asistentes</th>
                        <th>Salón(es)</th>
                        <th>Fecha hora inicio</th>
                        <th>Fecha hora fin</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="modal_salones" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">OCUPACIÓN: </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal_body">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="table table-responsive">
                <table class="table table-bordered" id="table_salones_ocupacion">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Nivel</th>
                      <th>Capacidad</th>
                      <th>% Ocupación</th>
                    </tr>
                  </thead>
                  <tbody id="table_salones_modal">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
