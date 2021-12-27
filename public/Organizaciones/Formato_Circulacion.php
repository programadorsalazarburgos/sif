<?php
//header('charset=utf-8');
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else { 
$Id_Persona = $_SESSION["session_username"]; //
$Id_Rol =	$_SESSION['session_usertype'];
?>

<!DOCTYPE html>
<html>
<head>
	<link href="../bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/Siclan.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
	<link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script src="../LibreriasExternas/JQuery/jquery-3.1.1.min.js"></script>
	<link href="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../LibreriasExternas/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<script src="../bootstrap/jquery/dist/jquery.min.js"></script>
	<script src="../bootstrap/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../public/bootstrap/bootstrap-filestyle/bootstrap-filestyle.js"> </script>
	<link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-select/bootstrap-select.css">
	<link href="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.js"></script>
	<script type="text/javascript" src="../bootstrap/bootstrap-select/bootstrap-select.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
	<link href="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../LibreriasExternas/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Formato_Circulacion.js?v=2020.09.30.0"></script>
</head>
<style type="text/css">
.row-margin-none{
	margin-right: 0;
	margin-left: 0;
}
</style>
<body>
	<div class="container-fluid" style="padding-top: 30px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1 style="font-size: 45px;">Seguimiento a Organizaciones<small  style="font-size: 20px;"> Componente de Circulación.</small></h1>
					<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
					<input type='hidden' id='id_rol' value='<?php echo $Id_Rol; ?>'> 
				</div>

			</div>
			<div class="panel-body">
				<div class="container">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" id="a-consultar" href="#consulta-archivos">Consultar Archivos</a></li>
						<li><a data-toggle="tab" href="#home">Subir Archivos</a></li>
					</ul>
					<br>
					<div class="col-xs-8 col-md-8 col-md-offset-4">
						<div class="col-xs-2 col-md-2 text-right">
							<label>Convenio:</label>
						</div>
						<div class="col-xs-4 col-md-4">
							<select id="SL_Convenios_Organizacion" class="form-control selectpicker" required>
								<option value="">Seleccione el Convenio</option>
							</select>
						</div>
					</div>
					<br>
					<div class="tab-content">
						<div id="consulta-archivos" class="tab-pane fade in active">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-primary">
									<h4>Consultar Formatos <small><font style="color:#fff">Administrativos</font></small></h4>
								</div>
								<div class="col-xs-6 col-md-6">
									<select id="SL_Year" title="Seleccione el Año" class="form-control">
										<option>Seleccione el año</option>
										<option value="2017">Convenios 2017</option>
										<option value="2018">Convenios 2018</option>
										<option value="2019">Convenios 2019</option>
									</select>
								</div>
								<div class="col-xs-6 col-md-6">
									<select id="SL_Organizacion" title="Seleccione la Organización" class="form-control selectpicker" data-live-search="true">
										<option value="">Seleccione la Organización</option>
									</select>
								</div>
								<div class="col-md-12" style="background-color: rgb(255, 253, 147); border-style: outset;">
									<p><label>NOTA IMPORTANTE:</label></p>
									<p style="text-align: justify;">• Utilice los botones de la última columna de la siguiente tabla para definir cuales son los archivos correctos o finales de modo que el equipo administrativo pueda identificarlos en medio de los borradores o erroneos, todos aquellos que queden en <strong>"SI"</strong> serán los que se revisarán.</p>
								</div>
								<div class="col-xs-12 col-md-12">
									<br>
									<table id="tabla_archivos" class="table table-hover" style="text-align: center">
										<br><caption style="text-align: center; font-size: 20px;">ARCHIVOS</caption>
										<thead>
											<th>Nombre Archivo</th>
											<th>Tipo</th>
											<th>Subida</th>
											<th>Mes/Año</th>
											<th>Descarga</th>
											<th>Anexos</th>
											<th>Revisión</th>
											<th>Observaciones</th>
											<th>Definitivo?</th>
										</thead>
										<tbody id="body_archivos">

										</tbody>
									</table>
								</div>	
							</div>
						</div>
						<div id="home" class="tab-pane fade in">
							<form id="Form_Archivos" name="Form_Archivos" enctype="multipart/form-data">
								<div class="form-group ">
									<div class="form-group " id="contenedor_anexos">
										<br>
										<div class="form-group row">
											<div  class="col-lg-1 col-md-1" style="text-align: right; margin-top: 5px;">
												<label for="SL_Anio" class="control-label">Año</label>
											</div>
											<div class="col-lg-3 col-md-3">
												<select required id="SL_Anio" name="SL_Anio" class="selectpicker form-control " title="Seleccione el Año">
												</select>
											</div>
										</div>
										<div class="form-group row">
											<div  class="col-lg-1 col-md-1" style="text-align: right; margin-top: 5px;">
												<label for="SL_Mes" class="control-label">Mes</label>
											</div>
											<div class="col-lg-3 col-md-3">
												<select required id="SL_Mes" name="SL_Mes" class="selectpicker form-control " title="Seleccione el Mes">
												</select>
											</div>
										</div>
										<div class="row form-group ">
											<div id="div_archivo_seg" data-toggle="tooltip" title="Formato" data-placement="right" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<input required id="archivo_seg" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" data-buttonBefore="true" runat="server" data-buttonText="&nbsp&nbsp&nbsp&nbsp&nbsp Formato">
											</div>
											<div id="div_anexos_archivo_seg" data-toggle="tooltip" title="Anexos Formato" data-placement="right" class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xs-4 col-sm-4 col-md-4 col-lg-4">
												<input id="anexos_archivo_seg" multiple name="file[]" type="file" class="filestyle" data-buttonName="btn-danger" data-buttonBefore="true" runat="server" data-buttonText="Anexos">
											</div>
										</div>
									</div>
								</div>
								<div class="text-center row col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<button type="submit" class="btn btn-success btn-lg" id="enviar_documentos">Enviar Documentos</button>
								</div>
							</form>
						</div>
						<div id="menu1" class="tab-pane fade">
							<h3>Menu 1</h3>
							<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
						</div>
					</div>
				</div>



			</div>
		</div>
	</div>
</body>
<div class="modal fade" id="MODAL_REVISION">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_titulo"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<div class="row">
					<div class="col-md-12">
						<p>Ingrese alguna observación</p>		
						<textarea id="TXA_Observacion_Archivo" name="TXA_Observacion_Archivo" class="form-control" rows="5" placeholder="Alguna observación Aquí"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="text-align: right;">
						<br>
						<p>Aprobación							<input data-toggle="toggle" data-onstyle="success" id="IN_Aprobacion" name= "IN_Aprobacion" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" class="estado_check"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="BT_Guardar_Observacion">GUARDAR</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="MODAL_OBSERVACION">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_titulo_observacion"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<div class="row">
					<div class="col-md-12">
						<p id="P_Observacion"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="MODAL_ANEXOS">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_titulo_anexo"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<div class="row">
					<div class="col-md-12">
						<table id="TABLA_ANEXOS" class="table table-hover">
							<thead>
								<th>Nombre Archivo</th>
								<th>Descargar</th>
							</thead>
							<tbody id="body_anexos">
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
		</div>
	</div>
</div>
</html>
<?php }  ?>