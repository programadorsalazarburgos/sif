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
	<title>Revisar Auditoria</title>

<!-- 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>     

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
    <script type="text/javascript" src="Js/Revisar_Auditoria.js?v=2019.08.23"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Revisión de Auditoría <small>SIF</small></h1>
				</div>

			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item"><a id="nav_inicios_sesion" class="nav-link" data-toggle="tab" href="#inicios_sesion" role="tab">Inicios Sesión</a></li>
					<li class="nav-item"><a id="nav_acciones_grupos" class="nav-link" data-toggle="tab" href="#acciones_grupos" role="tab">Acciones en grupos</a></li>
					<li class="nav-item"><a id="nav_acciones_circulacion" class="nav-link" data-toggle="tab" href="#acciones_circulacion" role="tab">Acciones en Circulación</a></li>
					<!--<li class="nav-item"><a id="nav_acciones_estudiante" class="nav-link" data-toggle="tab" href="#acciones_estudiante" role="tab">Acciones en Estudiantes</a></li>-->
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="inicios_sesion" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-info">
									<strong>Seleccione un usuario</strong> para ver las veces que ha ingresado a SIF.
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<select class="form-control selectpicker" data-live-search="true" id="SL_mes_anio_auditoria_inicios_sesion"></select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
									</span>
									<select class="form-control selectpicker" data-live-search="true" id="SL_usuario_auditoria_inicios_sesion"></select>
									<?php echo "<input type='hidden' name='id_usuario' id='id_usuario' value='".$Id_Persona."'>"; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12 table-responsive">
								<div id="div_table_log_login"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="acciones_grupos" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-info">
									<strong>Use los filtros</strong> para encontrar el grupo según el CREA.
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_mes_anio_auditoria_grupo">Mes:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<select class="form-control selectpicker" data-live-search="true" id="SL_mes_anio_auditoria_grupo"></select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_crea">Crea:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-tower"></span>
									</span>
									<select class="form-control selectpicker" data-live-search="true" id="SL_crea"></select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_grupo">Grupo:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-education"></span>
									</span>
									<select class="form-control selectpicker" data-live-search="true" id="SL_grupo"></select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-warning">
									<strong>Información!</strong> Los datos mostrados a continuación son capturados desde Abril - 2017.
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12 table-responsive">
								<div id="div_table_acciones_grupo"></div> 
							</div>
						</div>
					</div>
					<div class="tab-pane" id="acciones_circulacion" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-info">
									<strong>Use los filtros</strong> para encontrar resultados de un CREA.
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_mes_anio_auditoria_circulacion">Mes:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<select class="form-control selectpicker" data-live-search="true" id="SL_mes_anio_auditoria_circulacion"></select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_evento">Evento:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-globe"></span>
									</span>
									<select class="form-control selectpicker" data-live-search="true" id="SL_evento"></select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12 table-responsive">
								<div id="div_table_acciones_circulacion"></div> 
							</div>
						</div>
					</div>
					<div class="tab-pane" id="acciones_estudiante" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-info">
									<strong>Use el campo de texto para encontrar resultados de un estudiante.</strong>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="TX_busqueda_estudiante">Documento o nombres:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-user"></span>
									</span>
									<input type="text" class="form-control" placeholder="Documento o nombres" name="TX_busqueda_estudiante" id="TX_busqueda_estudiante" />
									<span class="input-group-btn">
										<button class="btn btn-success" id="BT_buscar_estudiante" type="button">Buscar</button>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_anio_auditoria_estudiante">Año: </label>
							</div>
							<div class="col-xs-12 col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<select class="form-control selectpicker" data-live-search="true" id="SL_anio_auditoria_estudiante">
										<option value="2018">2018</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class=" col-xs-12 col-md-12 table-responsive">
								<div id="div_table_estudiante"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12 table-responsive">
								<div id="div_table_estudiante"></div>								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
