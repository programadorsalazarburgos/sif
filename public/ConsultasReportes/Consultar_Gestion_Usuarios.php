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

    <script type="text/javascript" src="Js/Consultar_Gestion_Usuarios.js?v=2018.08.220"></script> 
    
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consultar Gestión de Usuarios SIF</h1>
					<?php echo "<input type='hidden' id='id_usuario' value='".$Id_Persona."' >"; ?>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">																	
					<div class="col-xs-8 col-md-3">
						<label for="SL_Ano">Seleccione el año:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_Ano" class="form-control selectpicker">
							<?php for($i=2017;$i<=date("Y");$i++): ?>
							<option value="<?= $i ?>" <?php if($i==date("Y")) echo ' selected'; ?>><?= $i ?></option>							
							<?php endfor; ?>
						</select>
					</div>						
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_mes">Mes Desde:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select id="SL_mes" class="form-control"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_mesh">Mes Hasta:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select id="SL_mesh" class="form-control"></select>
					</div>
				</div>				
				<div class="row">
					<div class="col-xs-3 col-xs-offset-4 col-md-3 col-md-offset-4">
						<a href="#" id="BT_consultar_asignaciones" class="form-control btn btn-info">Consultar</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 table-responsive">
						<label for=""></label>
			            <div id="div_table_asignaciones"> 
			            </div>  
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>