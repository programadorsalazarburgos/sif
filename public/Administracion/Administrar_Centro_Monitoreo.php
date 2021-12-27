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
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Administrar Centro de Monitoreo</title>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>  
	
	
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>


 	<!-- Dependencias de CodeMirror-->
	<link  href="../bower_components/codemirror/lib/codemirror.css" rel="stylesheet" type="text/css">
	<link  href="../bower_components/codemirror/theme/monokai.css" rel="stylesheet" type="text/css">
	<link href="../bower_components/codemirror/addon/hint/show-hint.css" rel="stylesheet" />
	<link href="../bower_components/codemirror/addon/display/fullscreen.css" rel="stylesheet" />
	<link href="../bower_components/codemirror/addon/scroll/simplescrollbars.css" rel="stylesheet" /> 
	<link href="../bower_components/codemirror/addon/dialog/dialog.css" rel="stylesheet" />   
	<link href="../css/editor_sublime.css?v=2018.11.13.12" rel="stylesheet" type="text/css" />  
	<!-- <script src="../js/editor_sublime.js?v=2018.11.13."></script>    -->

	<script src="../bower_components/codemirror/lib/codemirror.js"></script>
	<script src="../bower_components/codemirror/addon/search/searchcursor.js"></script>
	<script src="../bower_components/codemirror/addon/search/search.js"></script>
	<script src="../bower_components/codemirror/addon/dialog/dialog.js"></script>
	<script src="../bower_components/codemirror/addon/edit/matchbrackets.js"></script>
	<script src="../bower_components/codemirror/addon/edit/closebrackets.js"></script>
	<script src="../bower_components/codemirror/addon/comment/comment.js"></script>
	<script src="../bower_components/codemirror/addon/wrap/hardwrap.js"></script>
	<script src="../bower_components/codemirror/addon/fold/foldcode.js"></script>
	<script src="../bower_components/codemirror/addon/fold/brace-fold.js"></script>		
	<script src="../bower_components/codemirror/addon/hint/show-hint.js"></script>
	<script src="../bower_components/codemirror/addon/hint/anyword-hint.js"></script>
	<script src="../bower_components/codemirror/addon/hint/sql-hint.js"></script>	
	<script src="../bower_components/codemirror/addon/display/autorefresh.js"></script>	
	<script src="../bower_components/codemirror/addon/display/fullscreen.js"></script>	
	<script src="../bower_components/codemirror/addon/scroll/simplescrollbars.js"></script>	
	<script src="../bower_components/codemirror/keymap/sublime.js"></script> 
	<script src="../bower_components/codemirror/mode/sql/sql.js"></script>  

	<link href="../css/centro_monitoreo.css?v=2018.11.13" rel="stylesheet" type="text/css" >

	
	<!-- include summernote css/js--> 
	<link href="../bower_components/summernote/dist/summernote.css" rel="stylesheet"> 
	<script src="../bower_components/summernote/dist/summernote.min.js"></script>          
	<script src="../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>     

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>  
	<script src="../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>	
	<script type="text/javascript" src="Js/Administrar_Centro_Monitoreo.js?v=2018.11.13.2"></script>  

</head>
<body> 
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de indicadores del Centro de Monitoreo</h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
			</div>
			<div class="panel-body col-md-8 col-md-offset-2">
				<div class="row"> 
					<div class="col-xs-3 col-md-3">
						<label for="SL_seccion">Seleccione la sección:</label>
					</div>
					<div class="col-xs-9 col-md-9">
						<select id="SL_seccion" class="form-control selectpicker" data-actions-box="true" data-live-search="true" title="Eliga una sección">
							<option value="1">INICIO</option>
							<option value="2">SUBDIRECCIÓN DE FORMACIÓN</option>
							<option value="3">NIDOS</option>
							<option value="4">CREA</option>
						</select>
					</div>
				</div>
				<div class="row">
					<br>
					<div class="col-xs-3 col-md-3">
						<label for="SL_tipo_indicador">Seleccione el tipo de indicador:</label>
					</div>
					<div class="col-xs-9 col-md-9">
						<div class="input-group">
							<select id="SL_tipo_indicador" name="SL_tipo_indicador" class="form-control selectpicker" data-actions-box="true" title="Seleccione el tipo de indicador" data-live-search="true"></select>
							<span class="input-group-btn">
								<button class="btn btn-info" id="BT_Crear" data-toggle="modal" data-target="#myModal"><span class="fas fa-plus-square"></span></button>
	
							</span>
						</div>
					</div>
				</div>
				<div class="row">
					<br>
					<div class="col-xs-9 col-md-9 col-md-offset-3">
						<button class="btn btn-primary btn-block btn-sm" id="BT_Buscar">Buscar</button>
					</div>
				</div>				
				<div class="row">
					<br>  
					<div id="div_table_tipos_indicadores">
					</div>
				</div>				
			</div>
		</div>
	</div>




  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-xl"> 
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Tipo de Indicador</h4>
        </div>
        <div class="modal-body">
        	<form id="tipo_indicador">
        		<input type="hidden" name="PK_id_centro_monitoreo" id="PK_id_centro_monitoreo" />
				<div class="row"> 
					<div class="col-xs-12 col-md-2">
						<label for="VC_numeral">Numeral:</label>
					</div>
					<div class="col-xs-12 col-md-10 form-group">
						<input type="text" id="VC_numeral" name="VC_numeral"  class="form-control" placeholder="Numeral" />
						<span class="help-block" id="error"></span>
					</div>
				</div> 
				<div class="row"> 
					<br>
					<div class="col-xs-12 col-md-2">
						<label for="VC_titulo">Titulo:</label>
					</div>
					<div class="col-xs-12 col-md-10 form-group">
						<input type="text" id="VC_titulo" name="VC_titulo"  class="form-control" placeholder="Titulo" />
						<span class="help-block" id="error"></span>
					</div>
				</div> 
				<div class="row"> 
					<div class="col-xs-12 col-md-2">
						<label for="TX_descripcion">Descripción:</label>
					</div>
					<div class="col-xs-12 col-md-10">
						<div class="" id="TX_descripcion"></div>
					</div>
				</div>				 				       	
				<div class="row"> 
					<div class="col-xs-12 col-md-2">
						<label for="IN_seccion">sección:</label>
					</div>
					<div class="col-xs-12 col-md-4  form-group">
						<select id="IN_seccion" name="IN_seccion" class="form-control selectpicker" data-actions-box="true" data-live-search="true" title="Eliga una sección">
							<option value="1">INICIO</option>
							<option value="2">SUBDIRECCIÓN DE FORMACIÓN</option>
							<option value="3">NIDOS</option>
							<option value="4">CREA</option>
						</select>
						<span class="help-block" id="error"></span>
					</div>
					<div class="col-xs-12 col-md-2">
						<label for="FK_tipo_indicador">tipo de indicador:</label>
					</div>
					<div class="col-xs-12 col-md-4">
						<select id="FK_tipo_indicador" name="FK_tipo_indicador" class="form-control selectpicker" data-actions-box="true" title="Seleccione el tipo de indicador" data-live-search="true"></select>
					</div>
				</div>	
				<div class="row"> 
					<br>
					<div class="col-xs-12 col-md-2">
						<label for="VC_icono">Icono:</label>
					</div>
					<div class="col-xs-12 col-md-4 form-group">
						<input type="text" id="VC_icono" name="VC_icono"  class="form-control" placeholder="Icono" />
						<span class="help-block" id="error"></span>
					</div>
					<div class="col-xs-12 col-md-2">
						<label for="VC_tipo_grafico">Tipo de Grafico:</label>
					</div>
					<div class="col-xs-12 col-md-4 form-group"> 
						<select id="VC_tipo_grafico" name="VC_tipo_grafico" class="form-control selectpicker"  data-actions-box="true" data-live-search="true" title="Tipo de Grafico"></select>
						<span class="help-block" id="error"></span>
					</div>
				</div> 	
			
				<div class="row"> 
					<br>
					<div class="col-xs-12 col-md-2" id="labelSQL">
						<label for="TX_sql">SQL:</label> 
						<div class="row">	
							<ul class="list-group">
								<li class="list-group-item active">ShortCuts</li>
								<li class="list-group-item">F11 - Pantalla completa</li>
								<li class="list-group-item">ESC - Salir pantalla completa</li>
								<li class="list-group-item">CTRL + D - Seleccionar mas de uno</li>
								<li class="list-group-item">CTRL + A - Seleccionar todo</li>
								<li class="list-group-item">CTRL + SHIFT + L - Seleccionar última línea</li>
								<li class="list-group-item">CTRL + F - Buscar en el documento</li>
								<li class="list-group-item">CTRL + ESPACIO - Auto completar</li>
							</ul>
						</div>
					</div>
					<div class="col-xs-12 col-md-10 form-group" id="contenidoSQL">
						<textarea id="TX_sql" name="TX_sql"></textarea>
						<span class="help-block" id="error"></span>
					</div>
				</div>														
				<div class="row"> 
					<br>
					<div class="col-xs-12 col-md-2">
						<label for="VC_filtros">Filtros:</label>
					</div>
					<div class="col-xs-12 col-md-4">
						<select id="VC_filtros" name="VC_filtros" class="form-control selectpicker" multiple data-actions-box="true" data-live-search="true" title="Eliga un filtro"></select>
					</div>
					<div class="col-xs-12 col-md-2">
						<label for="IN_estado">Estado:</label>
					</div>
					<div class="col-xs-12 col-md-4">
				        <input data-toggle="toggle" data-onstyle="success" name= "IN_estado" data-offstyle="danger" data-on="Activo" data-off="Inactivo" type="checkbox"  id="IN_estado" class="form-control">  	
					</div>
				</div>	
				<div class="row"> 
					<br> 
					<div class="col-xs-12 col-md-10 col-md-offset-2">
						<!-- <button class="btn btn-block btn-success btn-sm" id="BT_guardar">Guardar</button> -->
						<input class="btn btn-block btn-success btn-sm" type="submit" value="Guardar" id="BT_guardar"/>
					</div>
				</div>				
			</form>
					 														
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
</body>
</html>
