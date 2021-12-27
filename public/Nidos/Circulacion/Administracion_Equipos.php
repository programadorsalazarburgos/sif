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
	<title>Administración Duplas NIDOS</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="Js/Administracion_Duplas.js?v=1.7.1.1"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../../bower_components/jszip/dist/jszip.min.js" type="text/javascript" ></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>

</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Administración de Equipos</h1>
			</div>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#creacion_duplas" role="tab">Creación de Dupla</a></li>
				<li class="nav-item"><a id="nav_consultar_duplas"  class="nav-link" data-toggle="tab" href="#consultar_duplas" role="tab">Consulta Duplas</a></li>
				<li class="nav-item"><a id="nav_modificar_duplas"  class="nav-link" data-toggle="tab" href="#modificar_duplas" role="tab">Modificación Dupla</a></li>
				</ul>
		<div class="tab-content">
				<div class="tab-pane active" id="creacion_duplas" role="tabpanel">
					<form id="form_nuevo_dupla">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Creación De Equipos</h4>
							</div>
						</div>
					<?php echo "<input type='hidden' id='id_usuario' name='id_usuario' value='".$Id_Persona."'" ?>
						<fieldset>
                             <br>
							<legend><font color="teal">Datos Equipo:</font></legend>
							<div class="form-group">
								<label class="col-md-3" for="TX_CodigoDupla">Código Equipo:</label>
								<div class="col-md-9">
									<input type="text"  class="form-control" id="TX_CodigoDupla" name="TX_CodigoDupla">
									<span class="help-block" id="error"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3" for="SL_Artistas">Artistas Comunitarios:</label>
								<div class="col-md-9">
									<select multiple data-max-options="3" id="SL_Artistas" name="SL_Artistas" class="form-control selectpicker" title="Seleccione uno o varios artistas" data-live-search="true"></select>
									<span class="help-block" id="error"></span>
								</div>
							</div>
                            <div class="row">
								<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
									<input class="form-control btn btn-primary"  id="BT_guardar_dupla" type="submit" value="Guardar Equipo">
								</div>
							</div>
						</fieldset>
					</form>
				</div>

				<div class="tab-pane" id="consultar_duplas" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Consulta Duplas Territorio</h4>
						</div>
					</div>
					<br>

					<h4><label>Gestor Territorial:</label> <font color="teal"><label class="TX_GestorC" for="TX_GestorC"></label> </font></h4>
					<h4><label>Territorio:</label> <font color="teal"><label class="SL_TerritorioC" for="SL_TerritorioC"></label> </font></h4>


					<div style="text-align: center">
						<button class="btn btn-primary" type="button" style="align:rigth">
	  					TOTAL DUPLAS <span class="badge" id="TX_Total"></span>
					  </button>
					</div>
					<div class="row">
						<div class='col-xs-12 col-md-12'>
						<table id="table_duplas_nidos" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
									<tr>
										<td class="text-center"><strong>Tipo Dupla</strong></td>
										<td class="text-center"><strong>Código Dupla</strong></td>
										<td class="text-center"><strong>Artistas</strong></td>
										<td class="text-center"><strong>Estado</strong></td>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="modificar_duplas" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Modificar Dupla</h4>
						</div>
					</div>
					<br>
					<div class="form-group">
						<label class="col-md-3" for="SL_NombreDupla_Modificar">Seleccione la DUPLA: </label>
						<div class="col-md-9">
							<select id="SL_NombreDupla_Modificar" class="form-control selectpicker" data-live-search="true" title="Seleccione una dupla"></select>
						</div>
					</div>
					<br>
					<br>
					<div id="div_modificar_dupla">
						<form id="form_modificar_dupla">
							<fieldset>
							<legend><font color="teal">Modificar Dupla:</font></legend>
							<div class="form-group">
								<label class="col-md-3" for="SL_Tipo_Dupla_Modificar">Tipo de Dupla:</label>
								<div class="col-md-9">
									<select class="form-control selectpicker" data-live-search="true" name="SL_Tipo_Dupla_Modificar" id="SL_Tipo_Dupla_Modificar"></select>
									<span class="help-block" id="error"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3" for="TX_CodigoDupla_Modificar">Código de Dupla:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" id="TX_CodigoDupla_Modificar" name="TX_CodigoDupla_Modificar">
									<span class="help-block" id="error"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3" for="SL_Artistas_Modificar">Ingresar Artistas</label>
								<div class="col-md-9">
									<select multiple id="SL_Artistas_Modificar" name="SL_Artistas_Modificar" class="form-control selectpicker" title="Seleccione uno o varios artistas" data-live-search="true"></select>
									<span class="help-block" id="error"></span>
								</div>
							</div>
  						<div class="row">
							<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
									<input class="form-control btn btn-primary"  id="BT_modificar_dupla" type="submit" value="Modificar Dupla">
							</div>
						</div>
           </fieldset>
					 </form>
           <br><br>
					   <div class="row">
					     <div class='col-xs-6 col-md-9 col-md-offset-3'>
					 	     <table id="SL_Artista1" class="table table-striped table-bordered table-hover" width="50%">
					 		    <thead></thead>
					 			  <tbody></tbody>
					 	     </table>
					     </div>
					  </div>
				  </div>
				</div>
		</div>

			<div class="modal fade" id="miModalInactivar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel" style="text-align: center">INACTIVAR ARTISTA</h4>
						</div>
						<div class="modal-body">
			         	<form id="form_inactivar_artista">
							<div class="row">
								<div class="col-xs-12 col-md-12">
									¿Esta seguro que desea INACTIVAR el artista <label id="nombre"></label> de la dupla ?
									<br>
									<input type="text" hidden="hidden" id="IdArtistaInactivar" name="IdArtistaInactivar">
								</div>
							</div>
							<br>
								<div class="row" style="text-align: center">
									<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4"  style="text-align: center">
									 <input class="form-control btn btn-success" id="BT_eliminar_lugar" type="submit" value="SI">
								 </div>
								 <div class="col-xs-6 col-sm-6 col-md-4"  style="text-align: center">
										<button type="button" class="form-control btn btn-danger" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">NO</span>
										</button>
								 </div>
							 </div>
						</form>
					</div>
				</div>
			 </div>
			</div>

			<div class="modal fade" id="miModalActivar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel" style="text-align: center">ACTIVAR ARTISTA</h4>
						</div>
						<div class="modal-body">
				       <form id="form_activar_artista">
							<div class="row">
								<div class="col-xs-12 col-md-12">
									¿Esta seguro que desea ACTIVAR el artista <label id="nombreA"></label> en la dupla seleccionada ?
									<br>
									<input type="text" hidden="hidden" id="IdArtistaActivar" name="IdArtistaActivar">
								</div>
							</div>
							<br>
								<div class="row" style="text-align: center">
									<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4"  style="text-align: center">
									 <input class="form-control btn btn-success" id="BT_eliminar_lugar" type="submit" value="SI">
								 </div>
								 <div class="col-xs-6 col-sm-6 col-md-4"  style="text-align: center">
										<button type="button" class="form-control btn btn-danger" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">NO</span>
										</button>
								 </div>
							 </div>
						</form>
					</div>
				</div>
			 </div>
			</div>

		</div>
</body>
</html>
