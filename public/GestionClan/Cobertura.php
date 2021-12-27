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
	<title>Cobertura</title>
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css">

	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>
	
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../bower_components/jszip/dist/jszip.min.js"></script> 
	<script src="../bower_components/pdfmake/build/pdfmake.min.js"></script> 
	<script src="../bower_components/pdfmake/build/vfs_fonts.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<!-- <link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script> -->

    <script type="text/javascript" src="Js/Cobertura.js?v=2021.09.17.1"></script>
</head>
<body style="font-family:Arial !important">
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Distribución Territorial de Coberturas<small></small></h1>
			</div>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#panel_crear_pacto" role="tab">Crear</a></li>
				<li class="nav-item"><a id="nav_consultar_pacto" class="nav-link" data-toggle="tab" href="#panel_consultar_pacto">Consultar</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="panel_crear_pacto" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>CREACIÓN DE PACTOS DE COBERTURA</h4>
						</div>
					</div>
                    <form id="form_nueva_cobertura">
						<div class="row">
                            <div class="col-xs-6 col-md-3 text-right">
                                <label for="SL_linea_atencion">Línea de Atención:</label>
                            </div>
                            <div class="col-xs-12 col-md-9">
                                <select class="form-control selectpicker" title="Seleccione la Línea de Atención" data-live-search="true" name="SL_linea_atencion" id="SL_linea_atencion" required="required"></select>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-xs-6 col-md-3 text-right">
                                <label for="SL_convenio">Convenio:</label>
                            </div>
                            <div class="col-xs-12 col-md-9">
                                <select class="form-control selectpicker" title="Seleccione el Convenio" data-live-search="true" name="SL_convenio" id="SL_convenio" required="required"></select>
                            </div>
                        </div>
						<!--<div class="row">
                            <div class="col-xs-6 col-md-3 text-right">
                                <label for="SL_lugar_atencion">Lugar de Atención:</label>
                            </div>
                            <div class="col-xs-12 col-md-9">
                                <select class="form-control selectpicker" title="Seleccione el Lugar de Atención" data-live-search="true" multiple="multiple" name="SL_lugar_atencion" id="SL_lugar_atencion" required="required"></select>
                            </div>
                        </div>-->
						<div class="row">
                            <div class="col-xs-6 col-md-3 text-right">
                                <label for="SL_zona">Zona:</label>
                            </div>
                            <div class="col-xs-12 col-md-9">
                                <select class="form-control selectpicker" title="Seleccione la Zona" data-live-search="true" name="SL_zona" id="SL_zona" required="required"></select>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-xs-6 col-md-3 text-right">
                                <label for="SL_colegio">Colegio:</label>
                            </div>
                            <div class="col-xs-12 col-md-9">
                                <select class="form-control selectpicker" title="Seleccione el Colegio" data-live-search="true" name="SL_colegio" id="SL_colegio" required="required"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-md-3 text-right">
                                <label for="SL_clan">CREA:</label>
                            </div>
                            <div class="col-xs-12 col-md-9">
                                <select class="form-control selectpicker" title="Seleccione CREA(s)" data-live-search="true" name="SL_clan" id="SL_clan" required="required"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-md-3 text-right">
                                <label for="SL_area_artistica">Areas Artisticas:</label>
                            </div>
                            <div class="col-xs-12 col-md-9">
                                <select class="form-control selectpicker" title="Seleccione el Área Artística" data-live-search="true" multiple="multiple" name="SL_area_artistica" id="SL_area_artistica" required="required"></select>
                            </div>
                        </div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<h3>Datos detallados Proyección por Área Artística</h3>
							</div>
						</div>
						<div class="row">
							<div id="div_detalle_grupos_beneficiarios_area"></div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-xs-offset-3 col-md-4 col-md-offset-4">
								<button type="submit" class="form-control btn btn-success"><i class="bi bi-save"></i> Guardar</button>
							</div>
						</div>
                    </form>
                </div>
                <div class="tab-pane" id="panel_consultar_pacto" role="tabpanel">
						<div class="row">
						<div class="col-md-6">
							<label>Filtros</label>
						</div>
						</div>
						<div class="row">
							<form id="form_filtros_consulta" name="form_filtros">
	                            <div class="col-xs-12 col-md-2">
                                	<select class="form-control selectpicker" title="Seleccione la Línea de Atención" data-live-search="true" name="SL_linea_atencion_consulta" id="SL_linea_atencion_consulta" required="required"></select>
                            	</div>
								<div class="col-xs-12 col-md-2">
	                                <select class="form-control selectpicker" title="Seleccione el Año" data-live-search="true" name="SL_anio_consulta" id="SL_anio_consulta" required="required"></select>
                            	</div>
								<div class="col-xs-12 col-md-2">
	                                <select class="form-control selectpicker" title="Seleccione la Zona" data-live-search="true" name="SL_zona_consulta" id="SL_zona_consulta" required="required"></select>
                            	</div>
								<!--<div class="col-xs-12 col-md-2">
									<select class="form-control selectpicker" title="Seleccione el Lugar de Atención" data-live-search="true" multiple="multiple" name="SL_lugar_atencion_consulta" id="SL_lugar_atencion_consulta" required="required"></select>
								</div>-->
								<div class="col-xs-12 col-md-2">
									<select class="form-control selectpicker" title="Seleccione el Área Artística" data-live-search="true" multiple="multiple" name="SL_area_artistica_consulta" id="SL_area_artistica_consulta" required="required"></select>
								</div>
								<div class="col-xs-12 col-md-2">
	                                <button class="btn btn-success" id="BT_Consultar" name="BT_Consultar" type="submit">
										<i class="bi bi-search"></i> Consultar
									</button>
                            	</div>
							</form>
                        </div>
					<div class="table-responsive" id="div_tabla_consultar_pactos"></div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="editar_cobertura" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="text-center">EDITAR PACTOS DE COBERTURA</h4>
				</div>
				<div class="modal-body">
					<form id="form_editar_cobertura">
						<input type="hidden" required="required" name="id" id="id" class="form-control">
						<div class="row">
							<div class="col-xs-6 col-md-3 text-right">
								<label for="SL_linea_atencion">Línea de Atención:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" title="Seleccione la Línea de Atención" data-live-search="true" name="SL_linea_atencion" id="SL_linea_atencion_editar" required="required"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3 text-right">
								<label for="SL_convenio">Convenio:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" title="Seleccione el Convenio" data-live-search="true" name="SL_convenio" id="SL_convenio_editar" required="required"></select>
							</div>
						</div>
						<!--<div class="row">
							<div class="col-xs-6 col-md-3 text-right">
								<label for="SL_lugar_atencion">Lugar de Atención:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" title="Seleccione el Lugar de Atención" data-live-search="true" multiple="multiple" name="SL_lugar_atencion" id="SL_lugar_atencion_editar" required="required"></select>
							</div>
						</div>-->
						<div class="row">
							<div class="col-xs-6 col-md-3 text-right">
								<label for="SL_zona">Zona:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" title="Seleccione la Zona" data-live-search="true" name="SL_zona" id="SL_zona_editar" required="required"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3 text-right">
								<label for="SL_colegio">Colegio:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" title="Seleccione el Colegio" data-live-search="true" name="SL_colegio" id="SL_colegio_editar" required="required"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3 text-right">
								<label for="SL_clan">CREA:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" title="Seleccione CREA(s)" data-live-search="true" name="SL_clan" id="SL_clan_editar" required="required"></select>
							</div>
						</div>
						<div class="row" hidden>
							<div class="col-xs-6 col-md-3 text-right">
								<label for="SL_area_artistica">Areas Artisticas:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" title="Seleccione el Área Artística" data-live-search="true" multiple="multiple" name="SL_area_artistica" id="SL_area_artistica_editar" required="required"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<h3>Datos detallados Proyección por Área Artística</h3>
							</div>
						</div>
						<div class="row">
							<div id="div_detalle_grupos_beneficiarios_area_editar"></div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-xs-offset-3 col-md-4 col-md-offset-4">
								<button type="submit" class="form-control btn btn-success"><i class="bi bi-save"></i> Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<div class="modal fade" id="eliminar_cobertura" tabindex="-1" role="dialog" aria-labelledby="editar_coberturaCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="text-center">ELIMINAR PACTO DE COBERTURA</h4>
				</div>
			<div class="modal-body" id="contenido_pacto">				
			</div>
			<div class="modal-footer">
				<h4 class="text-left">¿Esta seguro que desea eliminar el pacto seleccionado?</h4>				
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-danger" id="eliminar_pacto">Eliminar</button>
			</div>
			</div>
		</div>
	</div>
</body>