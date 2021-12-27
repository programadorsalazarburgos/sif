<?php
session_start();
if(!isset($_SESSION["session_username"])) {
  header("location:../index.php");
} else {
  $Id_Persona = $_SESSION["session_username"];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Administración de usuarios</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="../bower_components/jquery/dist/jquery.min.js"></script> 
  <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 

  <script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>

  <link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
  <link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
  <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 

  <link href="../bower_components/jquery-ui/themes/base/jquery-ui.css?v=2020.05.01.0" rel="Stylesheet"></link>
  <link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
  <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
  <script src="../bower_components/bootbox.js/bootbox.js"></script>
  
  <script src="../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <link href="../node_modules/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

  <script src="../node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <link href="../node_modules/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

  <script src="../node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
  <script src="../node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script> 
  <script src="../node_modules/jszip/dist/jszip.min.js"></script> 


  <link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css?v=1.12.1" rel="stylesheet" type="text/css" >  
  <script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  

  <link rel="stylesheet" type="text/css" href="../css/checkbox-searchable.css">
  <script type="text/javascript" src="../js/checkbox-searchable.js"></script>
  <link href="../bower_components/alertifyjs/build/css/alertify.css?v=1" rel="stylesheet" type="text/css" >
  <script src="../bower_components/alertifyjs/build/alertify.min.js?v=1"></script>
  <script src="../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="../bower_components/jquery-ui/jquery-ui.js"></script>
  <script type="text/javascript" src="Js/Administrar_Usuarios.js?v=2021.08.19"></script>

</head>
<style type="text/css">
  div{
    font-family: 'Prompt';
    font-size: 14px; 
  }
  .modal{
    text-align: center;
    padding: 0!important;
  }

  .modal:before{
    content: '';
    display: inline-block;
    height: 100%;
    vertical-align: middle;
    margin-right: -4px;
  }

  .modal-dialog{
    display: inline-block;
    text-align: left;
    vertical-align: middle;
  }
  .datepicker{
    z-index:1151 !important;
  }
  .ui-tooltip {
    padding: 8px;
    position: absolute;
    z-index: 9999;
    max-width: 300px;
    background: black;
    color: white;
  }
  td{ font-size: 12px; }
</style>
<body>
  <?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
  <div class="container-fluid">
    <div class="panel panel-success">
      <div class="panel-heading">
        <div class="page-header">
          <h1>Administración de Usuarios<small> SIF</small></h1>
        </div>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#creacion_usuarios" role="tab">Creación de Usuario</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab_consulta_usuarios" href="#consulta_usuarios" role="tab">Consulta de Usuarios</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" id="tab_consulta_info_completa_usuarios" href="#consulta_info_completa_usuarios" role="tab">Consulta información completa de Usuarios</a></li>
        </ul>
        <div class="tab-content" style="padding: inherit;">
          <div class="tab-pane active" id="creacion_usuarios" role="tabpanel">
            <div class="signup-form-container">

              <div class="signup-form-container">
               <!-- form start -->
               <form role="form" id="register-form" autocomplete="off">
                 <div class="form-body">
                   <div class="row">
                     <!-- <h3>SELECCIONE EL PROGRAMA</h3> -->
                     <div class="form-group">
                      <div class="searchable-container">
                        <div class="items col-xs-5 col-sm-5 col-md-3 col-lg-3">
                          <div class="info-block block-info clearfix">
                            <div data-toggle="buttons" class="btn-group bizmoduleselect">
                              <label class="btn btn-default">
                                <div class="bizcontent">
                                  <input type="checkbox" name="var_id[]" autocomplete="off" value="CREA" required>
                                  <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                                  <h5>CREA</h5>
                                </div>
                              </label>
                            </div>
                          </div>
                        </div>
																								<div class="items col-xs-5 col-sm-5 col-md-3 col-lg-3">
                          <div class="info-block block-info clearfix">
                            <div data-toggle="buttons" class="btn-group bizmoduleselect">
                              <label class="btn btn-default">
                                <div class="bizcontent">
                                  <input type="checkbox" name="var_id[]" autocomplete="off" value="NIDOS" required>
                                  <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                                  <h5>NIDOS</h5>
                                </div>
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="items col-xs-5 col-sm-5 col-md-3 col-lg-3">
                          <div class="info-block block-info clearfix">
                           <div data-toggle="buttons" class="btn-group bizmoduleselect">
                            <label class="btn btn-default">
                              <div class="bizcontent">
                                <input type="checkbox" name="var_id[]" autocomplete="off" value="CULTURAS">
                                <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                                <h5>CULTURAS</h5>
                              </div>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <div class="col-md-12">
                 <!-- <h3 class="form-title"><i class="fa fa-user"></i> Datos Personales</h3> -->
                 <i class="pull-right">
                   <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
                 </i>
               </div>
               <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                 <div class="input-group">
                   <div class="input-group-addon"><span class="fab fa-product-hunt fa-spin"></span></div>
                   <select id="SL_PERFIL" name="SL_PERFIL" class="form-control selectpicker" data-toggle="tooltip" data-placement="top" title="Seleccione un perfil de usuario"></select>
                 </div>
                 <span class="help-block" id="error"></span>
               </div>
             </div>
             <div class="col-md-12">
               <div class="col-md-6">
                <div class="form-group">
                 <div class="input-group">
                   <div class="input-group-addon"><span class="fa fa-hashtag"></span></div>
                   <input id="TB_NIdentificacion" name="TB_NIdentificacion" type="text" class="form-control" placeholder="Número de Identificación" data-toggle="tooltip" data-placement="top" title="Número de Identificación">
                 </div>
                 <span class="help-block" id="error"></span>
               </div>
             </div>
             <div class="col-md-6">
              <div class="form-group">
               <div class="input-group">
                 <div class="input-group-addon"><span class="fa fa-id-card"></span></div>
                 <select id="SL_TIPO_IDENTIFICACION" name="SL_TIPO_IDENTIFICACION" class="form-control selectpicker" data-live-search="true" data-toggle="tooltip" data-placement="top">
                 </select>
               </div>
               <span class="help-block" id="error"></span>
             </div>
           </div>
         </div>
         <div class="col-md-12">
           <div class="col-md-6">
            <div class="form-group">
             <div class="input-group">
               <div class="input-group-addon"><span><b>PN</b></span></div>
               <input id="TB_PNombre" name="TB_PNombre" type="text" class="form-control mayuscula" placeholder="Primer Nombre" data-toggle="tooltip" data-placement="top" title="Primer Nombre">
             </div>
             <span class="help-block" id="error"></span>
           </div>
         </div>
         <div class="col-md-6">
          <div class="form-group">
           <div class="input-group">
             <div class="input-group-addon"><span><b>SN</b></span></div>
             <input id="TB_SNombre" name="TB_SNombre" type="text" class="form-control mayuscula" placeholder="Segundo Nombre" data-toggle="tooltip" data-placement="top" title="Segundo Nombre">
           </div>
           <span class="help-block" id="error"></span>
         </div>
       </div>
     </div>
     <div class="col-md-12">
       <div class="col-md-6">
        <div class="form-group">
         <div class="input-group">
           <div class="input-group-addon"><span><b>PA</b></span></div>
           <input id="TB_PApellido" name="TB_PApellido" type="text" class="form-control mayuscula" placeholder="Primer Apellido" data-toggle="tooltip" data-placement="top" title="Primer Apellido">
         </div>
         <span class="help-block" id="error"></span>
       </div>
     </div>
     <div class="col-md-6">
      <div class="form-group">
       <div class="input-group">
         <div class="input-group-addon"><span><b>SA</b></span></div>
         <input id="TB_SApellido" name="TB_SApellido" type="text" class="form-control mayuscula" placeholder="Segundo Apellido" data-toggle="tooltip" data-placement="top" title="Segundo Apellido">
       </div>
       <span class="help-block" id="error"></span>
     </div>
   </div>
 </div>
 <div class="col-md-12">
   <div class="col-md-6">
    <div class="form-group">
     <div class="input-group">
       <div class="input-group-addon"><span class="fa fa-calendar"></span></div>
       <input id="TB_FNacimiento" name="TB_FNacimiento" type="text" class="form-control" placeholder="Fecha de Nacimiento" data-toggle="tooltip" data-placement="top" title="Fecha de Nacimiento">
     </div>
     <span class="help-block" id="error"></span>
   </div>
 </div>
 <div class="col-md-6">
  <div class="form-group">
   <div class="input-group">
     <div class="input-group-addon"><span class="fa fa-venus-mars"></span></div>
     <select id="SL_SEXO" name="SL_SEXO" class="form-control selectpicker" data-toggle="tooltip" data-placement="top" title="Genero"></select>
   </div>
   <span class="help-block" id="error"></span>
 </div>
</div>
</div>
<div class="col-md-12">
 <div class="form-group col-md-6">
  <div class="input-group">
    <div class="input-group-addon"><span class="fa fa-phone"></span></div>
    <input name="TB_Celular" id="TB_Celular" type="text" class="form-control" placeholder="Celular" data-toggle="tooltip" data-placement="top" title="Celular">
  </div>  
  <span class="help-block" id="error"></span>                    
</div>
<div class="form-group col-md-6">
  <div class="input-group">
    <div class="input-group-addon"><span class="fa fa-envelope"></span></div>
    <input id="TB_Correo" name="TB_Correo" class="form-control" placeholder="Email" data-toggle="tooltip" data-placement="top" title="Email">
  </div>  
  <span class="help-block" id="error"></span>                    
</div>
</div>
<div class="col-md-12">
  <div class="form-group col-md-6">
    <div class="input-group">
      <div class="input-group-addon"><span class="fa fa-user-tie"></span></div>
      <input id="TB_Cargo" name="TB_Cargo" class="form-control" placeholder="Cargo" data-toggle="tooltip" data-placement="top" title="Aparecerá en la firma del Informe de Pago" value="Contratista">
    </div>  
    <span class="help-block" id="error"></span>                    
  </div>
</div>

<div id="div_informacion_artistica" hidden>
  <div class="col-md-12">
    <h3><i class="fa fa-paint-brush"></i> Información Artística y Organizaciones</h3>
  </div>
  <div id="contenedor-areas-organizaciones">
    <div id="row_1" class="col-md-12">
     <div class="col-md-4">
      <div class="form-group">
       <div class="input-group">
         <div class="input-group-addon"><span class="fab fa-adn" style="color: Tomato"></span></div>
         <select id="SL_AREA_ARTISTICA_1" name="SL_AREA_ARTISTICA_1" class="form-control selectpicker areas_organizaciones" data-live-search="true" title="Área Artística" data-toggle="tooltip" data-placement="top">
         </select>
       </div>
       <span class="help-block" id="error"></span>
     </div>
   </div>
   <div class="col-md-4">
    <div class="form-group">
     <div class="input-group">
       <div class="input-group-addon"><span class="fas fa-dot-circle" style="color: Tomato"></span></div>
       <select id="SL_ORGANIZACION_1" name="SL_ORGANIZACION_1" class="form-control selectpicker areas_organizaciones" data-live-search="true" title="Organización" data-toggle="tooltip" data-placement="top">
       </select>
     </div>
     <span class="help-block" id="error"></span>
   </div>
 </div>
 <div class="col-md-4">
  <div class="form-group">
   <div class="input-group">
     <div class="input-group-addon"><span class="fas fa-dot-circle" style="color: Tomato"></span></div>
     <select id="SL_TIPO_ARTISTA_1" name="SL_TIPO_ARTISTA_1" class="form-control selectpicker areas_organizaciones" data-live-search="true" title="Tipo Artista" data-toggle="tooltip" data-placement="top">
     </select>
   </div>
   <span class="help-block" id="error"></span>
 </div>
</div>
</div>
</div>
<div class="col-md-1" style="padding-left: 20px;padding-bottom: 10px">
  <a id="a-add" class="btn btn-primary " Title="Agregar" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>    
  <a id="a-delete" class="btn btn-default " Title="Eliminar" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>                  
</div>
</div>
</div>

<div class="col-md-12 ">
  <div class="form-footer col-md-3 col-md-offset-5">
   <button id="BTN_RESET" name="BTN_RESET" type="reset" class="btn btn-danger">Limpiar</button>
   <button id="BTN_SUBMIT" name="BTN_SUBMIT" type="submit" class="btn btn-primary">Registrar</button>
 </div>
</div>
</form>
</div>
</div>
</div>
</div>

<div class="tab-pane" id="consulta_usuarios" role="tabpanel">
  <div class="row">
    <div class="col-xs-12 col-md-12 text-center bg-primary">
      <h4>Consulta de Usuarios <small><font style="color:#fff">sIF</font></small></h4>
    </div>
  </div>
  <center>
    <br>
    <div style="width:70%" align="justify">
      <font color="#333333" size="3">
        <span class="fa fa-asterisk"></span> Seleccione la organización que desea consultar para visualizar los USUARIOS asociados. 
      </font>
      <font color="#FF0000" size="3">
      </font>
    </div>
  </center>
  <form id="form_consultar_usuarios" name="form_consultar_usuarios">
    <div class="panel panel-green" style="width:100%">
     <div class="panel-body">
       <center>
        <table width="100%" border="0">
          <tr class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><div>Organización<font color="#FF0000">*</font> : </div></td>
            <td class="col-xs-10 col-md-10 col-sm-10 col-lg-10">
              <div>
                <select class="form-control selectpicker" title='Seleccione una organización' data-live-search="true" name="SL_Organizacion" id="SL_Organizacion">
                  <option value="">Todas</option>
                </select>
              </div>
            </td>
            <td  class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
              <div>
                <input type="submit" class="btn btn-success" value="CONSULTAR USUARIOS" title="Realizar Consulta">
              </div>
            </td>
          </tr>
        </table>
        <br>
        <table id="tabla_usuarios" name="tabla_usuarios" class="table table-hover">
          <thead>
           <tr>
             <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Id_Persona</th>
             <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Identificación</th>
             <th class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>Nombre</th>
             <th class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Usuario</th>
             <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Tipo</th>
             <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Estado</th>
             <th class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Opciones</th>
           </tr>
         </thead>
         <tbody></tbody>
       </table>  
     </center>
   </div>
 </div>
</form>     
</div><!--Fin Consulta de Usuarios    -->
<div class="tab-pane" id="consulta_info_completa_usuarios" role="tabpanel">
  <div class="form-group">
    <div class="row">
      <div class="col-lg-12">
        <table id="tabla-info-completa-usuarios" class="table table-striped table-bordered table-hover" width="100%">
          <thead>
            <tr>
              <th>Identificación</th>
              <th>Tipo identificación</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Género</th>
              <th>Fecha de nacimiento</th>
              <th>Email</th>
              <th>Celular</th>
              <th>Rol</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</body>
<!-- Modal -->
<div id="modal_perfil" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <table id="tabla_organizaciones_usuario" name="tabla_organizaciones_usuario" class="table table-hover">

        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="guardar-perfil" class="btn btn-primary">Guardar</button>
      </div>
    </div>

  </div>
</div>
<div id="modal_zona" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <form id="form-zonas" name="form-zonas">
        <div class="modal-body">

          <div class="jumbotron" id="div_zonas">

          </div>
          <div><p style="font-size: 14px">Reasignar Zonas del Usuario</p></div>
          <select id="SL_ZONAS" class="form-control selectpicker" multiple data-max-options="2" required="required" data-live-search="true">       
            <!-- <option value="1">Zona 1 Sur (RUU – SAN CRISTÓBAL – TUNJUELITO – ANTONIO NARIÑO)</option>
            <option value="2">Zona 2 Sur (BOSA – KENNEDY – PUENTE ARANDA)</option>
            <option value="3">Zona 3 Sur (CIUDAD BOLIVAR - USME)</option>
            <option value="4">Zona 4 Norte (USAQUÉN – SUBA – BARRIOS - UNIDOS)</option>
            <option value="5">Zona 5 Centro (TEUSAQUILLO – CHAPINERO – MÁRTIRES - SANTAFÉ)</option>
            <option value="6">Zona 6 Occidente (ENGATIVA – FONTIBON)</option> -->
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="guardar-zonas" class="btn btn-primary">Guardar Zonas</button>
        </div>
      </form>
    </div>

  </div>
</div>
<div class="modal fade" id="modal_organizaciones" name="modal_organizaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Indique la(s) organizacion(es) correspondiente(s)</h4>
      </div>
      <div id="modal_body" class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="capturar_organizaciones">Guardar Organizaciones</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</html>