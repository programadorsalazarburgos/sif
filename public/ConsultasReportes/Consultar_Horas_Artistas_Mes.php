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
	<title>Consultar Horas Artistas Mes</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
    <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="Js/Consultar_Horas_Artistas_Mes.js?v=20"></script>
</head> 
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consulta completa de Artistas Formadores <small> CREA</small></h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="SL_Ano">Seleccione el año:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_Ano" class="form-control selectpicker" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true">
							<?php for($i=2017;$i<=date("Y");$i++): ?>
							<option value="<?= $i ?>" <?php if($i==date("Y")) echo ' selected'; ?>><?= $i ?></option>							
							<?php endfor; ?>
						</select>
					</div>			
				</div>	
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="SL_organizacion">Seleccione la Organización:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_organizacion" multiple="multiple" class="form-control selectpicker" data-actions-box="true" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
						<a href="#" id="BT_cargar_datos" class="form-control btn btn-primary">Cargar Artistas</a>
					</div>
				</div>
				<div class="row">
					<br>
					<div class="col-xs-12 col-md-12 alert alert-info">								
						<p>
							A continuación va a encontrar todos los Artistas Formadores con asistencias registradas consolidado mensual por organización. Se muestran los siguientes datos por cada mes: <strong>número de clases, número de horas, número de grupos y grupos atendidos</strong>; Puede usar la celda <b>Filtrar</b> para encontrar los Artstas pertenecientes a una organización específica.
						</p>

					</div>
				</div>
				<!-- -->
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="table-responsive">
							<table id="table_horas_artista" style="width: 100%" class="table table-hover">
								<thead>
									<tr>
										<th class="text-center"><strong>Línea de Atención</strong></th>
										<th class="text-center"><strong>Documento</strong></th>
										<th class="text-center"><strong>Nombre AF</strong></th>
										<th class="text-center"><strong>Organización Sesión de Clase</strong></th>
										<th class="text-center"><strong>Organizaciones AF</strong></th>
										<th class="text-center"><strong>Perfil</strong></th>
										<th class="text-center"><strong>Área(s)</strong></th>
										<th class="text-center"><strong>Fuente Recurso</strong></th>
										<th class="text-center"><strong>Horas Enero</strong></th>
										<th class="text-center"><strong>Clases Enero</strong></th>												
										<th class="text-center"><strong># Grupos Enero</strong></th>
										<th class="text-center"><strong>Grupos Enero</strong></th>												
										<th class="text-center"><strong>Horas Febrero</strong></th>
										<th class="text-center"><strong>Clases Febrero</strong></th>												
										<th class="text-center"><strong># Grupos Febrero</strong></th>
										<th class="text-center"><strong>Grupos Febrero</strong></th>
										<th class="text-center"><strong>Horas Marzo</strong></th>
										<th class="text-center"><strong>Clases Marzo</strong></th>												
										<th class="text-center"><strong># Grupos Marzo</strong></th>
										<th class="text-center"><strong>Grupos Marzo</strong></th>	
										<th class="text-center"><strong>Horas Abril</strong></th>
										<th class="text-center"><strong>Clases Abril</strong></th>												
										<th class="text-center"><strong># Grupos Abril</strong></th>
										<th class="text-center"><strong>Grupos Abril</strong></th>															
										<th class="text-center"><strong>Horas Mayo</strong></th>
										<th class="text-center"><strong>Clases Mayo</strong></th>												
										<th class="text-center"><strong># Grupos Mayo</strong></th>
										<th class="text-center"><strong>Grupos Mayo</strong></th>															
										<th class="text-center"><strong>Horas Junio</strong></th>
										<th class="text-center"><strong>Clases Junio</strong></th>												
										<th class="text-center"><strong># Grupos Junio</strong></th>
										<th class="text-center"><strong>Grupos Junio</strong></th>
										<th class="text-center"><strong>Horas Julio</strong></th>
										<th class="text-center"><strong>Clases Julio</strong></th>												
										<th class="text-center"><strong># Grupos Julio</strong></th>
										<th class="text-center"><strong>Grupos Julio</strong></th>
										<th class="text-center"><strong>Horas Agosto</strong></th>
										<th class="text-center"><strong>Clases Agosto</strong></th>												
										<th class="text-center"><strong># Grupos Agosto</strong></th>
										<th class="text-center"><strong>Grupos Agosto</strong></th>	
										<th class="text-center"><strong>Horas Septiembre</strong></th>
										<th class="text-center"><strong>Clases Septiembre</strong></th>												
										<th class="text-center"><strong># Grupos Septiembre</strong></th>
										<th class="text-center"><strong>Grupos Septiembre</strong></th>	
										<th class="text-center"><strong>Horas Octubre</strong></th>
										<th class="text-center"><strong>Clases Octubre</strong></th>												
										<th class="text-center"><strong># Grupos Octubre</strong></th>
										<th class="text-center"><strong>Grupos Octubre</strong></th>		
										<th class="text-center"><strong>Horas Noviembre</strong></th>
										<th class="text-center"><strong>Clases Noviembre</strong></th>												
										<th class="text-center"><strong># Grupos Noviembre</strong></th>
										<th class="text-center"><strong>Grupos Noviembre</strong></th>														
										<th class="text-center"><strong>Horas Diciembre</strong></th>
										<th class="text-center"><strong>Clases Diciembre</strong></th>												
										<th class="text-center"><strong># Grupos Diciembre</strong></th>
										<th class="text-center"><strong>Grupos Diciembre</strong></th>																																						
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- -->				
			</div>
		</div>
	</div>	
</body>
<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<img src="../imagenes/enviando.gif" width="100%">      
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</html>