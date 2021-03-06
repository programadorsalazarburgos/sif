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
	<title>Consultar Estudiantes</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
	<link type="text/css" href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

	<script type="text/javascript" src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

	<link type="text/css" href="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
	<script type="text/javascript" src="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>

	<script type="text/javascript" src='../LibreriasExternas/pdfmake/pdfmake.min.js'></script>
	<script type="text/javascript" src='../LibreriasExternas/pdfmake/vfs_fonts.js'></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
    <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="Js/Consultar_Estudiantes_General.js?v=2019.10.04.1"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consulta general de Estudiantes<small> CREA </small></h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione el a??o:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_Ano" multiple="multiple" class="form-control selectpicker" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true">
							<?php for($i=2017;$i<=date("Y");$i++): ?>
							<option value="<?= $i ?>" <?php if($i==date("Y")) echo ' selected'; ?>><?= $i ?></option>							
							<?php endfor; ?>
						</select>
					</div>					
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione el crea:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_clan" multiple="multiple" class="form-control selectpicker" data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 alert alert-warning">
						<p>
							A continuaci??n va a encontrar todos los estudiantes, puede usar la celda <b>Filtrar</b> para encontrar los grupos pertenecientes a un ??rea Art??stica espcifica, Colegio u otro.
						</p>
					</div>
				</div>
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#grupos_arte_escuela" role="tab" id="gruposArteEscuela">Arte en la escuela</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#grupos_emprende_clan" role="tab" id="gruposEmprendeClan">Impulso Colectivo</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#grupos_laboratorio_clan" role="tab" id="gruposLaboratorioClan">Converge</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="grupos_arte_escuela" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>ARTE EN LA ESCUELA <small>Detalle de Estudiantes</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<div id="div_table_grupos_arte_escuela"> 
			            			</div> 									
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="grupos_emprende_clan" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>IMPULSO COLECTIVO <small>Detalle Grupos</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<div id="div_table_grupos_emprende_clan"> 
			            			</div> 	
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="grupos_laboratorio_clan" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>CONVERGE <small>Detalle Grupos</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<div id="div_table_grupos_laboratorio_clan"> 
			            			</div> 	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
</body>
</html>
