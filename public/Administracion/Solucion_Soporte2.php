<?php 
  session_start(); 
  if(!isset($_SESSION["session_username"])) { 
    header("location:index.php"); 
  } else { 
    $Id_Persona= $_SESSION["session_username"]; 
  }  
?> 
<!DOCTYPE html> 
<html> 
<head> 
  <meta charset="utf-8">  
  <title>Solución Soporte</title> 
  <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <script src="../bower_components/jquery/dist/jquery.min.js"></script> 
  <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 
  <!-- include summernote css/js--> 
  <link href="../bower_components/summernote/dist/summernote.css" rel="stylesheet">
  <script src="../bower_components/summernote/dist/summernote.min.js"></script>
  <script src="../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>
 
  <link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
  <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
  <link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >  
  
  
  <link href="../bootstrap/metisMenu/dist/metisMenu.min.css" rel="stylesheet">  
    <!-- <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">  -->

  <script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script><!-- defer  integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous" -->
  <link href="../css/solicitud_soporte.css?v=2018.07.173" rel="stylesheet" type="text/css">     
  <script src="../bootstrap/metisMenu/dist/metisMenu.min.js"></script> 
 
  <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
  <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
  <script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
  <script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

  <script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
  <script src="../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
  <script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

  <script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  
  <!-- <script src="../js/bootstrap-filestyle.js" type="text/javascript" > </script> -->
  <script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript" > </script> 
  <link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
  <script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>  
 
  <link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
  <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
  <script type="text/javascript" src="Js/Solucion_Soporte2.js?v=2020.09.30.0"></script>     
</head> 
<body> 
  <?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?> 
  <div class="container-fluid">  
    <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $Id_Persona; ?>" />  
     
    <div class="panel panel-default"> 
      <div class="panel-heading"> 
        <div class="page-header"> 
          <h1>Solución de Soportes SIF <small>CREA y NIDOS</small></h1> 
        </div> 
      </div> 
      <div class="modal fade" id="modal_actividades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-md" role="document"> 
          <div class="modal-content"> 
            <div class="modal-body">                
              <div id='actividades'></div>               
            </div> 
          </div><!-- /.modal-content --> 
        </div><!-- /.modal-dialog --> 
      </div><!-- /.modal -->    
 
      <div class="panel-body"> 
        <div class="row"> 
          <div class="col-xs-12 col-md-3">
            <strong>Selecione el programa:</strong> 
          </div>
          <div class="col-xs-12 col-md-9">
            <select name="sla_codigo" id="sla_codigo" class="form-control selectpicker" data-actions-box="true"  data-live-search="true"> 
              <option value="0">Programa</option> 
              <option value="1">CREA</option>
              <option value="2">NIDOS</option>
            </select>
          </div>          
        </div>
        <div class="row"> 
          <div class="col-xs-12 col-md-12 text-center bg-info"> 
            <h4>Soportes En Espera: <small>A continuación se visualizan todas las solicitudes que han sido enviadas a la mesa de ayuda de SICREA correspondientes y no se les ha dado respuesta.</small></h4> 
          </div> 
        </div>         
        <ul class="nav nav-tabs" role="tablist"> 
          <li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#solucionar_soporte" role="tab">Solucionar soportes</a></li> 
          <li class="nav-item"><a id="ver_historico" class="nav-link" data-toggle="tab" href="#historico_soportes" role="tab">Histórico de soportes</a></li> 
        </ul>   
        <div class="tab-content">       
          <div class="tab-pane active row" id="solucionar_soporte" role="tabpanel"> 
            <div class="col-xs-12 col-md-12 table-responsive"> 
              <table id="table_solicitudes_pendientes"  style="width: 100%" class="table table-hover"> 
                <thead>  
                  <tr> 
                    <td class="text-center"><strong># Ticket</strong></td> 
                    <td class="text-center"><strong>Fecha de Envío</strong></td> 
                    <td class="text-center"><strong>Titulo</strong></td>   
                    <td class="text-center"><strong>Id Usuario</strong></td> 
                    <td class="text-center"><strong>Estado</strong></td> 
                    <td class="text-center"><strong>Persona que envía</strong></td> 
                    <td class="text-center"><strong>Opciones</strong></td> 
                    <td class="text-center"><strong>Observadores</strong></td> 
                    <!--<td class="text-center"><strong>Solicitud</strong></td> --> 
                  </tr> 
                </thead> 
                <tbody></tbody> 
              </table> 
            </div> 
          </div> 
          <div class="tab-pane" id="historico_soportes" role="tabpanel"> 
            <div class="row"> 
              <div class="col-xs-12 col-md-12 text-center bg-info"> 
                <h4>HISTORIAL: <small>Seleccione un rago de fechas para  la busqueda de incidentes por fecha de creación</small></h4> 
              </div> 
            </div> 
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
                    <div class="row"> 
                      <div class="col-xs-6 col-md-2 col-lg-2"> 
                            <label for="fecha">Rango Fechas:</label> 
                        </div> 
 
                      <div class='col-xs-12 col-md-5 col-lg-5'> 
                            <div class="form-group"> 
                                <div class='input-group date' >  
                                    <input type='text' id='fecha_inicio' name="fecha_inicio" class="form-control" required="required" placeholder="Fecha Inicio" readonly="readonly" /> 
                                    <span class="input-group-addon"> 
                                        <span class="glyphicon glyphicon-calendar"></span> 
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <div class='col-xs-12 col-md-5 col-lg-5'> 
                            <div class="form-group"> 
                                <div class="input-group date"> 
                                    <input type='text' id='fecha_fin' name="fecha_fin"  class="form-control" required="required" placeholder="Fecha Fin" readonly="readonly" /> 
                                    <span class="input-group-addon"> 
                                        <span class="glyphicon glyphicon-calendar"></span> 
                                    </span> 
                                </div> 
                            </div> 
                        </div> 
                        <button class="btn btn-success col-xs-12 col-md-10 col-md-offset-2 col-lg-10 col-lg-offset-2" id="cargarHistorico">Cargar Histórico Solicitudes</button> 
                    </div>             
            <div class="row"> 
              <div class="col-xs-12 col-md-12 table-responsive"> 
                <table id="table_historico_solicitudes" style="width: 100%" class="table table-hover"> 
                  <thead>  
                    <tr> 
                      <th class="text-center"><strong># Ticket</strong></th>                     
                      <th class="text-center"><strong>Fecha de Envío</strong></th> 
                      <th class="text-center"><strong>Tipo De Solicitud</strong></th> 
                      <td class="text-center"><strong>Persona que envía</strong></td> 
                      <th class="text-center"><strong>Titulo</strong></th>             
                      <th class="text-center"><strong>Estado</strong></th> 
                      <th class="text-center"><strong>Prioridad</strong></th> 
                      <th class="text-center"><strong>Observaciones</strong></th>                       
                      <th class="text-center"><strong>Atendido por</strong></th> 
                      <th class="text-center descripcion"><strong>Descripción</strong></th>                       
                      <th class="text-center descripcion"><strong>Solución</strong></th> 
                      <th class="text-center"><strong>Fecha de Respuesta</strong></th> 
                      <th class="text-center"><strong>Actividad Problema Inicial</strong></th>   
                      <th class="text-center"><strong>Actividad Problema Cierre</strong></th>                                              
                    </tr> 
                  </thead> 
                  <tbody></tbody>  
                </table> 
              </div> 
            </div> 
          </div>           
        </div> 
      </div> 
    </div> 
  </div> 
  <div class='modal fade' role='dialog' id='modal_solucion_soporte'> 
    <div class='modal-dialog modal-xl'> 
      <!-- Modal content--> 
      <div class='modal-content'> 
        <div class='modal-header'> 
          <button type='button' class='close' data-dismiss='modal'>&times;</button> 
          <h4 class='modal-title'  id="tituloObservaciones">Solucionar soporte</h4> 
        </div> 
        <div class='modal-body'> 
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="titulo_incidente">Titulo:</label> 
            </div> 
            <div class="col-xs-11 col-md-11"> 
              <div id="titulo_incidente"></div> 
            </div> 
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
          </div>     
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="fecha_incidente">Fecha:</label> 
            </div> 
            <div class="col-xs-11 col-md-11"> 
              <div id="fecha_incidente"></div> 
            </div> 
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
          </div>                
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="tx_solicitud">Solicitud del usuario:</label> 
            </div> 
            <div class="col-xs-11 col-md-11"> 
              <div id="tx_solicitud"></div> 
            </div> 
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
          </div>         
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="usuario_solicita">Usuario:</label> 
            </div> 
            <div class="col-xs-11 col-md-11"> 
              <div id="usuario_solicita"></div> 
            </div> 
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
          </div>  
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="SL_observadores">Observadores:</label> 
            </div> 
            <div class="col-xs-11 col-md-11"> 
              <select id="SL_observadores" multiple="multiple" class="form-control selectpicker"data-actions-box="false"  data-live-search="true" title="A quien copiar este incidente"></select>
            </div> 
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
          </div>            
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="fk_actividad_apertura">Actividad Apertura:</label> 
            </div> 
            <div class="col-xs-5 col-md-5"> 
              <div id="actividad_apertura"></div> 
              <input type="hidden" name="fk_actividad_apertura" id="fk_actividad_apertura" /> 
            </div> 
            <div class="col-xs-1 col-md-1"> 
              <label for="fk_actividad_cierre">Actividad Cierre:</label> 
            </div> 
            <div class="col-xs-5 col-md-5"> 
              <div id="actividad_cierre"></div> 
              <input type='hidden' name='fk_actividad_cierre' id='fk_actividad_cierre' /> 
            </div>             
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
          </div>             
          <div class="row"> 
            <div class="col-xs-12 col-md-12"> 
              <strong>Observaciones</strong>  
            </div> 
            <div class="col-xs-12 col-md-12 table-responsive"> 
              <table id="table_observacion_incidentes" style="width: 100%" class="table table-hover"> 
                <thead> 
                  <tr> 
                    <th class="text-center"><strong>Fecha</strong></th>           
                    <th class="text-center"><strong>Usuario</strong></th> 
                    <th class="text-center"><strong>Observación</strong></th> 
                  </tr> 
                </thead> 
                <tbody></tbody> 
              </table> 
            </div> 
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
          </div> 
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="adjuntos">Adjuntos:</label> 
            </div> 
            <div id="contenedorAdjuntos" class="col-xs-10 col-md-10"> 
            </div>             
          </div>   
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="urgencia">Urgencia:</label> 
            </div> 
            <div class="col-xs-5 col-md-5"> 
              <select class="selectpicker" title="Seleccione la Urgencia" id="urgencia">       
                <option value='1'>Alta</option> 
                <option value='2'>Media</option> 
                <option value='3'>Baja</option> 
              </select> 
            </div> 
            <div class="col-xs-1 col-md-1"> 
              <label for="impacto">impacto:</label> 
            </div> 
            <div class="col-xs-5 col-md-5"> 
              <select class="selectpicker" title="Seleccione la Impacto" id="impacto">       
                <option value='1'>Alto  (Organización)</option> 
                <option value='2'>Medio (Departamento)</option> 
                <option value='3'>Bajo  (Individual)</option> 
              </select>               
            </div> 
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
          </div>    
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="urgencia">Prioridad:</label> 
            </div>   
            <div class="col-xs-11 col-md-11"> 
              <div id="prioridad"></div>   
            </div>   
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div>                   
          </div>                                       
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="tipoObservacion">Tipo:</label> 
            </div> 
            <div class="col-xs-5 col-md-5"> 
              <input type="hidden" name="incidente_codigo" id="incidente_codigo" />    
              <input type="hidden" name="id_persona" id="id_persona" /> 
              <select class="selectpicker" title="Escoga el el tipo de observación" id="tipoObservacion">       
                <option value='0'>Pública</option> 
                <option value='1'>Privada</option> 
              </select> 
            </div> 
            <div class="col-xs-1 col-md-1"> 
              <label for="cerrarIncidente">Cerrar:</label> 
            </div> 
            <div class="col-xs-5 col-md-5"> 
              <input data-toggle="toggle" data-onstyle="success" name= "cerrarIncidente" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" checked id="cerrarIncidente">  
 
              <!--<select class="selectpicker" id="cerrarIncidente" title="Indique si se Cierra el Incidente" >       
                <option value='0'>No</option> 
                <option value='1'>Si</option> 
              </select>-->  
            </div>   
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div>             
          </div>   
          <div class="row"> 
            <div class="col-xs-1 col-md-1"> 
              <label for="tx_solucion">Solución:</label> 
            </div> 
            <div class="col-xs-11 col-md-11"> 
              <div id="tx_solucion"></div> 
            </div> 
            <div class="col-xs-12 col-md-12 col-lg-12 mb-0"></div> 
          </div>                 
        </div> 
        <div class="modal-footer"> 
            <div class="row">
              <div id="div_archivo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <!--  <input id="archivos_incidente" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" size="2" data-max-size="10240" runat="server" multiple> -->
               <input id="archivos_incidente" name="file[]" type="file" size="2" data-max-size="10240" runat="server" multiple>
              </div>          
            </div>
            <div class="row">
                <div id="archivos_adjuntos_incidente" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-info" style="padding:5px;">
                  <strong>Estos son los archivos que se van a enviar:</strong>
                </div>              
            </div>    
            <div class="row botones_respuesta">      
              <button id="respuesta_soporte" type="button" class="btn btn-info" >Respuesta</button>         
              <button id="BT_solucionar_soporte" type="button" class="btn btn-success" >Guardar</button> 
            </div>
        </div> 
      </div> 
    </div> 
  </div> 
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