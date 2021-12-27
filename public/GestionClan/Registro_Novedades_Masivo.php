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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
  	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 
	<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>    
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >  
   	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  
	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>     
    <script src="Js/Registro_Novedades_Masivo.js?v=2018.09.03" type="text/javascript"></script>      
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Registro Masivo de Novedades AF por Crea - Colegio</h1>
					<?php echo "<input type='hidden' id='id_usuario' value='".$Id_Persona."' >"; ?>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="SL_linea">Seleccione la línea:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_linea" class="form-control selectpicker" data-actions-box="true"  data-live-search="true">
							<option value="arte_escuela">Arte en la Escuela</option>
							<option value="emprende_clan">Impulso Colectivo</option>
							<option value="laboratorio_clan">Converge</option> 
						</select>
					</div>						
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione el crea:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_clan" class="form-control selectpicker" data-actions-box="true"  data-live-search="true"></select>
					</div>								
					<div class="col-xs-12 col-md-3"> 
						<label for="SL_colegio">Seleccione el colegio:</label>
					</div>
					<div class="col-xs-12 col-md-9"> 
						<select id="SL_colegio" multiple="multiple" class="form-control selectpicker" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true"></select>  
					</div>

					<div class="col-xs-12 col-md-3"> 
						<label for="SL_colegio">Seleccione el(los) grupo(s):</label>
					</div>
					<div class="col-xs-12 col-md-9"> 
						<select id="SL_grupo" multiple="multiple" class="form-control selectpicker" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true"></select>  
					</div>					
														
				</div>
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="fecha">Seleccione la fecha:</label>
					</div>					
					<div class='col-xs-12 col-md-9'> 
					    <div class="form-group"> 
					        <div class='input-group date' >  
					            <input type='text' id='fecha' name="fecha" class="form-control" required="required" placeholder="Fecha de novedad" readonly="readonly" /> 
					            <span class="input-group-addon"> 
					                <span class="glyphicon glyphicon-calendar"></span> 
					            </span> 
					        </div> 
					    </div> 
					</div> 
				</div>	
				<div class="row">

					<div class="col-xs-12 col-md-3">
						<label for="SL_novedad">Novedad:</label>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-th-list"></span>
							</span>
							<select id="SL_novedad" class="form-control selectpicker">
							</select>
						</div>
					</div>											
					<div class="col-xs-12 col-md-1">
						<label for="CH_asistencia">Asistencia:</label>
					</div>
					<div class="col-xs-12 col-md-2">
						<div class="input-group">
							<input class="form-control" data-toggle="toggle" data-onstyle="primary" id= "CH_asistencia" data-offstyle="danger" data-on="SI"
							 data-off="NO" type="checkbox" checked >
						</div>
					</div>					
				</div>
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="TX_observacion">Digite la Observación:</label>
					</div>					
					<div class='col-xs-12 col-md-9'> 
					    <div class="form-group"> 
							<textarea placeholder="Observaciones" id="TX_observacion" class="form-control" cols="4"></textarea>
					    </div> 
					</div> 
				</div>								
				<div class="row">
					<div class="col-xs-3 col-xs-offset-4 col-md-3 col-md-offset-4">
						<a href="#" id="BT_registrar_novedades" class="form-control btn btn-info">Registrar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>