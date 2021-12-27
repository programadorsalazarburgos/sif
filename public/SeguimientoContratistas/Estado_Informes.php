<?php 
session_start();
//require_once "../../src/autoloader.php";
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");

} else {
	$Id_Persona = $_SESSION["session_username"];
	$Id_Rol =	$_SESSION['session_usertype'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/material-desing.css">
	<link href="../bower_components/summernote/dist/summernote.css" rel="stylesheet">
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >  
	<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
	<link href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet"> 

	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>
	<script src="../bower_components/summernote/dist/summernote.min.js"></script>
	<script src="../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script> 
	<script src="../bower_components/jszip/dist/jszip.min.js"></script> 
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  
	<script src="../bower_components/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" ></script>  
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
	<script src="../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
	<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.js"> </script>

	<!-- <script type="text/javascript" src="../LibreriasExternas/datatables-plugins/buttons/buttons.html5.min.js"></script> -->
	<script src='../LibreriasExternas/pdfmake/build/pdfmake.js?v=2019.04.01.010'></script>
	<script src='../LibreriasExternas/pdfmake/build/vfs_fonts.js?v=2019.04.01.12'></script>

	<script src="Js/Estado_Informes.js?v=2021.03.02.9"></script>
	<link rel="stylesheet" type="text/css" href="Css/Informe_Pago.css">
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid" style="padding-top: 30px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1 style="font-size: 45px;">Consulta Estado de  Informes </h1>
					<input type='hidden' id='id-usuario' value='<?php echo $Id_Persona; ?>'>
					<input type='hidden' id='id-rol' value='<?php echo $Id_Rol; ?>'>
				</div> 
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item  active"><a class="nav-link" data-toggle="tab" href="#listado" id="listado_link" role="tab">Listado</a></li>
				</ul>
				<div class="tab-content">
					<br>
					<div class="tab-pane active" id="listado" role="tabpanel">
												
						<div class="form-group row" >
							<div class="col-md-7" style="padding-right:0px ">
								<label  for="input-fecha-de"  class="col-sm-4 col-md-4 control-label">Número de Contrato:</label>
								<div class="input-group col-sm-8 col-md-6" style="padding-left: 15px;padding-right: 15px;" >
									<input style="background-color: white; z-index: 1;" maxlength="50" class="form-control" id="TX_Numero_Contrato" name="TX_Numero_Contrato" placeholder="000-2021" type="text" require>
								</div>
							</div>
						</div>
						<div class="form-group row" >
							<div class="col-md-7" style="padding-right:0px ">
								<label  for="select-mes-informe" class="col-sm-4 col-md-4 control-label">Mes de presentación</label>
								<div class="input-group col-sm-8 col-md-6" style="padding-left: 15px;padding-right: 15px;" >
									<select id="SL_Mes_Informe" name="SL_Mes_Informe"  class="selectpicker form-control" require></select>
								</div>
							</div>
						</div>
						<div class="form-group row" >
							<div class="col-md-6" style="padding-right:0px ">
								<input class="form-control btn btn-primary" id="BT_Trazabilidad_Informe" type="submit" value="Consultar trazabilidad">
							</div>
						</div>
						
						<div class="col-lg-12 row" >
							<div class="table-responsive">
								<table id="table-trazabilidad-informe" class="display table table-striped table-bordered" width="100%" style="width: 100%">
									<thead>
										<tr style="text-align: center;">
											<th>Identificacion</th>
											<th>Nombre Contratista</th>
											<th>N Contrato</th>
											<th>Fecha presentación</th>
											<th>Periodo</th>
											<th>Acción</th>
											<th>Hora de acción</th>
											<th>Aprobado</th>
										</tr> 
									</thead>
									<tbody>
									</tbody>
								</table>  
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>
