<?php 
session_start();
if (!isset($_SESSION["session_username"])) {
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
	<title>Administración Grupos NIDOS</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script src="../../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>

	<script type="text/javascript" src="Js/Administracion_Grupo.js?v=2021.06.22.1941223"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet">
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="../../bower_components/jszip/dist/jszip.min.js" type="text/javascript"></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>

</head>

<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de grupos Nidos</h1>
				</div>
			</div>
			<div class="panel-body">

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#informacion_grupos" role="tab">Información Grupos</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consolidado_grupos" role="tab">Consolidado de Grupos</a></li>
					
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="informacion_grupos" role="tabpanel">
					<br><br>

					<div class="col-lg-12">
							<div class="col-lg-3 col-md-3">
								<div class="panel panel-primary">
									<div class="panel-heading" style="text-align: center;">
										<h3>Grupos Activos</h3>
										<h2><label id="LB_Grupos"></label></h2>
										
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="panel panel-danger">
									<div class="panel-heading" style="text-align: center;">
										<h3>Encuentros Grupales</h3>
										<h2><label id="LB_Grupales"></label></h2>
										<h4><label id="LB_Bene_Grupales"></label> Inscritos</h4>
										
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="panel panel-default">
									<div class="panel-heading" style="text-align: center;">
										<h3>Laboratorios</h3>
										<h2><label id="LB_Laboratorios"></label></h2>
										<h4><label id="LB_Bene_Laboratorios"></label> Inscritos</h4>
										
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<br>
							</div>
						</div>

						<div class="row">
							<br>
							<div class="col-md-6">
							</div>
							<div class="col-md-6">
							<button class="btn btn-block btn-success" id="btn-crear-grupo" data-toggle='modal' data-target='#modal-nuevo-grupo'>REGISTRAR NUEVO GRUPO</button>
							</div>
						</div><br>
						
						<div class="row">
								<div class='col-xs-12 col-md-12'>
									<table id="table_grupos_nidos" class="table table-striped table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<td class="text-center"><strong>Estrategia de atención</strong></td>
												<td class="text-center"><strong>Lugar de atención</strong></td>
												<td class="text-center"><strong>Nombre del grupo</strong></td>
												<td class="text-center"><strong>Tipo de Grupo</strong></td>
												<td class="text-center"><strong>Nivel de Escolaridad</strong></td>												
												<td class="text-center"><strong>Beneficiarios Inscritos</strong></td>
												<td class="text-center"><strong>Acciones</strong></td>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
						</div>

					</div>


					<div class="tab-pane" id="consolidado_grupos" role="tabpanel">
						<br>
						<fielset>
							<legend>Consolidado por lugar de atención</legend>							
							</fieldset>
							<div class="row">
								<div class='col-xs-12 col-md-12'>
									<table id="table_consolidado_dupla" class="table table-striped table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<td class="text-center"><strong>Lugar de atención</strong></td>
												<td class="text-center"><strong>N° de grupos</strong></td>
												<td class="text-center"><strong>N° de experiencias</strong></td>
												<td class="text-center"><strong>Beneficiarios Atendidos</strong></td>
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

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-nuevo-grupo">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">REGISTRAR NUEVO GRUPO</h4>
				</div>
				<div class="modal-body">
				  <form id="form_nuevo_grupo_nidos">							
							<div class="row">							
							<div class="col-xs-12 col-md-12 col-lg-12">							
								<div class="form-group">
									<label class="col-md-4" for="SL_EAtencion">Estrategia de atención:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" title="Seleccione una estrategia de atención" data-live-search="true" name="SL_EAtencion" id="SL_EAtencion" require></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="SL_LAtencion">Lugar de atención:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" title="Seleccione un lugar de atención" data-live-search="true" name="SL_LAtencion" id="SL_LAtencion" requiere></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="SL_Nivel">Nivel de escolaridad:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" multiple data-actions-box="true"  data-live-search="true" name="SL_nivel_escolaridad" id="SL_nivel_escolaridad" title="Selección múltiple" require></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="TX_nombre">Nombre del grupo:</label>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="Nombre del Grupo" id="TX_Nombre_Grupo" name="TX_Nombre_Grupo"require>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="SL_Tipo_Grupo">Tipo de grupo:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" title="Seleccione el tipo de grupo" data-live-search="true" name="SL_Tipo_Grupo" id="SL_Tipo_Grupo" require></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>								
								<div class="form-group">
									<label class="col-md-4" for="TX_Nombre_Responsable">Maestro(a) o responsable del grupo:</label>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="Responsable del Grupo" id="TX_Nombre_Responsable" name="TX_Nombre_Responsable" require>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
									<br>
									</div>
								</div>
							<div id="lugar_grupo_laboratorio" style="display: none;">
								<div class="form-group">
									<label class="col-md-4" for="SL_Lugar_Grupo">¿Aque lugar de atención pertenece este grupo?:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_Grupo" id="SL_Lugar_Grupo" title="Seleccione un lugar de atención del grupo"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
							</div>


							</div>
							</div>

							<div class="modal-footer">					
					<button type="button" class="registrar-grupo btn btn-success">REGISTRAR GRUPO</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>

						</form>
				</div>
				
			</div>
		</div>
	</div>


	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-modificar-grupo">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">MODIFICAR INFORMACIÓN DEL GRUPO</h4>
				</div>
				<div class="modal-body">
				<form id="form_modificar_grupo_nidos">

						<input type="hidden" class="form-control" id="TX_Id_Grupo" name="TX_Id_Grupo">
									<div class="form-group">
										<label class="col-md-4" for="SL_EAtencion_Modificar">Estrategia de atención:</label>
										<div class="col-md-8">
											<select class="form-control selectpicker" data-live-search="true" name="SL_EAtencion_Modificar" id="SL_EAtencion_Modificar"></select>
											<span class="help-block" id="error"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4" for="SL_LAtencion_Modificar">Lugar de atención:</label>
										<div class="col-md-8">
											<select class="form-control selectpicker" data-live-search="true" name="SL_LAtencion_Modificar" id="SL_LAtencion_Modificar"></select>
											<span class="help-block" id="error"></span>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-4" for="TX_Nombre_Grupo_Modificar">Nombre del grupo:</label>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="Nombre del Grupo" id="TX_Nombre_Grupo_Modificar" name="TX_Nombre_Grupo_Modificar">
											<span class="help-block" id="error"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4" for="SL_Tipo_Grupo_Modificar">Tipo de grupo:</label>
										<div class="col-md-8">
											<select class="form-control selectpicker" title="Seleccione el tipo de grupo" data-live-search="true" name="SL_Tipo_Grupo_Modificar" id="SL_Tipo_Grupo_Modificar"></select>
											<span class="help-block" id="error"></span>
										</div>
									</div>
									<div class="form-group">
									<label class="col-md-4" for="SL_Nivel_Modificar">Nivel de escolaridad:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" multiple data-actions-box="true"  data-live-search="true" name="SL_nivel_escolaridad_Modificar" id="SL_nivel_escolaridad_Modificar" title="Selección múltiple" require></select>
										<span class="help-block" id="error"></span>
									</div>
									</div>
									<div class="form-group">
										<label class="col-md-4" for="TX_Nombre_Responsable_Modificar">Responsable del grupo:</label>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="Responsable del Grupo" id="TX_Nombre_Responsable_Modificar" name="TX_Nombre_Responsable_Modificar">
											<span class="help-block" id="error"></span>
										</div>
									</div>								
										
									<div class="form-group">
									<div class="col-sm-12 col-md-12 col-lg-12">
									<br>
									  </div>
									</div>
							<div id="lugar_grupo_laboratorio_modificar" style="display: none;">
									<div class="form-group">
									<label class="col-sm-12 col-md-4 col-lg-4" for="SL_Lugar_Grupo_Modificar">¿A que entidad pertenece este grupo?:</label>									
									  <div class="col-sm-12 col-md-8 col-lg-8">
									  <select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_Grupo_Modificar" id="SL_Lugar_Grupo_Modificar" title="Seleccione un lugar de atención del grupo"></select>
										</div>
									</div>
							</div>
									<div class="form-group">
									<div class="col-sm-12 col-md-12 col-lg-12">
									<br>
									  </div>
									</div>
							

							<div class="modal-footer">					
					<button type="button" class="modificar-grupo btn btn-success">Modificar Grupo</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
				</form>

				</div>
				
			</div>
		</div>
	</div>



	<div class="modal fade" id="modalInactivacion" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">INACTIVACIÓN DE GRUPO</h4>
				</div>
				<div class="modal-body">
					<span>¿Esta seguro que desea inactivar el grupo <strong><label id="nombreGrupoI"><label></strong>?</span>
					<input id="idGrupoI" hidden="hidden" value="">
				</div>
				<div class="modal-footer">
					<button type="button" class="confirmar-inactivacion btn btn-success">INACTIVAR</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalActivacion" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">ACTIVACIÓN DE GRUPO</h4>
				</div>
				<div class="modal-body">
					<span>¿Esta seguro que desea activar nuevamente el grupo <strong><label id="nombreGrupoA"><label></strong>?</span>
					<input id="idGrupoA" hidden="hidden" value="">
				</div>
				<div class="modal-footer text-center">
					<button type="button" class="confirmar-activacion btn btn-success">ACTIVAR</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
</body>

</html>