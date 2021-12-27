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
	<title>Administración Lugares NIDOS</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <script type="text/javascript" src="Js/Administracion_LugaresPedagogicos.js?v=2018.1.0.1"></script>

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
				<h1>Administración Lugares de Atención</h1>
			</div>
		</div>
		<div class="panel-body">
	<form id="form_nuevo_lugar_pedagogico">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#creacion_lugares" role="tab">Crear Lugar de Atención </a></li>
				<li class="nav-item"><a id="nav_consultar_lugares" class="nav-link" data-toggle="tab" href="#consultar_lugares" role="tab">Consultar Lugares</a></li>
				<li class="nav-item"><a id="nav_Modificar_lugares" class="nav-link" data-toggle="tab" href="#modificar_lugares" role="tab">Modificar Lugar</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="creacion_lugares" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Creación Lugar Atención</h4>
						</div>
					</div>
					<?php echo "<input type='hidden' id='id_usuario' name='id_usuario' value='".$Id_Persona."'" ?>
						<fieldset>
						<br><br>
            		<legend>Datos Lugar de Atención</legend>
						<div class="form-group">
							<label class="col-md-3" for="SL_Localidad">Localidad:</label>
							<div class="col-md-9">
								<select class="form-control selectpicker" data-live-search="true" name="SL_Localidad" id="SL_Localidad" title="Seleccione una localidad"></select>
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="SL_Upz">Upz:</label>
							<div class="col-md-9">
								<select class="form-control selectpicker" data-live-search="true" name="SL_Upz" id="SL_Upz" title="Seleccione una upz"></select>
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="TX_Barrio">Barrio:</label>
							<div class="col-md-9">
								<input type="text" class="form-control mayuscula" placeholder="Barrio" id="TX_Barrio" name="TX_Barrio">
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="TX_NombreLugar">Nombre del Lugar:</label>
							<div class="col-md-9">
								<input type="text" required="required" class="form-control mayuscula" placeholder="Nombre Lugar" id="TX_NombreLugar" name="TX_NombreLugar">
								<span class="help-block" id="error"></span>
							</div>
						</div>						

              <div class="row">
								<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
									<input class="form-control btn btn-primary" id="BT_guardar_lugar" type="submit" value="Guardar Lugar de Atención">
								</div>
							</div>
						</fieldset>
					</form>
				</div>

				<div class="tab-pane" id="consultar_lugares" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Consulta Lugares Atención NIDOS</h4>
						</div>
					</div>
 								<br>
								<div style="text-align: center">
									<button class="btn btn-primary" type="button" style="align:rigth">
				  					TOTAL DE LUGARES <span class="badge" id="TX_Total"></span>
									</button>
								</div>
					<div class="row">
						<div class='col-xs-12 col-md-12'>
						<table id="table_lugares_pedagogico" class="table table-striped table-bordered table-hover"  width="100%">
              <thead>
									<tr>
										<td class="text-center"><strong>Localidad</strong></td>
										<td class="text-center"><strong>Upz</strong></td>
										<td class="text-center"><strong>Barrio</strong></td>
										<td class="text-center"><strong>Nombre Lugar</strong></td>
										<td class="text-center"><strong>Acciones</strong></td>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="modificar_lugares" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Modificar Lugar Atención</h4>
						</div>
					</div>
					<br>
					<div class="row">
						<label class="col-md-3" for="SL_NombreLugar_Modificar">Seleccione el lugar de atención:</label>
						<div class="col-md-9">
							<select id="SL_NombreLugar_Modificar" class="form-control selectpicker" data-live-search="true" title="Seleccione un lugar"></select>
						</div>
					</div>
					<div id="div_modificar_lugar">
					  <form id="form_modificar_lugar">
					    <fieldset>
					      <legend>Modificar datos del lugar</legend>
					      <div class="form-group">
					        <label class="col-md-3" for="SL_Localidad_Modificar">Localidad:</label>
					        <div class="col-md-9">
					          <select class="form-control selectpicker" data-live-search="true" name="SL_Localidad_Modificar" id="SL_Localidad_Modificar"></select>
					          <span class="help-block" id="error"></span>
					        </div>
					      </div>
					      <div class="form-group">
					        <label class="col-md-3" for="SL_Upz_Modificar">Upz:</label>
					        <div class="col-md-9">
					          <select class="form-control selectpicker" data-live-search="true" name="SL_Upz_Modificar" id="SL_Upz_Modificar"></select>
					          <span class="help-block" id="error"></span>
					        </div>
					      </div>
					      <div class="form-group">
					        <label class="col-md-3" for="TX_Barrio_Modificar">Barrio:</label>
					        <div class="col-md-9">
					          <input type="text" class="form-control mayuscula" placeholder="Barrio" id="TX_Barrio_Modificar" name="TX_Barrio_Modificar">
					          <span class="help-block" id="error"></span>
					        </div>
					      </div>

					      <div class="form-group">
					        <label class="col-md-3" for="TX_NombreLugar_Modificar">Nombre del Lugar:</label>
					        <div class="col-md-9">
					          <input type="text" class="form-control mayuscula" placeholder="Nombre Lugar" id="TX_NombreLugar_Modificar" name="TX_NombreLugar_Modificar">
					          <span class="help-block" id="error"></span>
					        </div>
					      </div>
					      <br>
					      <div class="row">
					        <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
					          <input class="form-control btn btn-primary" id="BT_modificar_lugar" type="submit" value="MODIFICAR LUGAR ATENCIÓN">
					        </div>
					      </div>
					    </fieldset>
					  </form>
					</div>
				</div>
				<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="myModalLabel">Lugares Atención</h4>
							</div>
							<div class="modal-body">
					<form id="form_eliminar_lugar">
								<div class="row">
			            <div class="col-xs-12 col-md-12">
			              <label for="nombre">¿Esta seguro que desea ELIMINAR el lugar de atención <label id="nombre"></label> ?</label>
										<br>
										<input type="text" hidden="hidden" id="lugarAeliminar" name="lugarAeliminar">
									</div>
								</div>
								<br>
									<div class="row" style="text-align: center">
				            <div class="col-xs-2 col-md-2"  style="text-align: center">
				             <input class="form-control btn btn-danger" id="BT_eliminar_lugar" type="submit" value="SI">
									 </div>

									 <div class="col-xs-2 col-md-2"  style="text-align: center">
											<button type="button" class="form-control btn btn-primary" data-dismiss="modal" aria-label="Close">
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
