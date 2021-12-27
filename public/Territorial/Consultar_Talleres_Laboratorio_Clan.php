<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:index.php");
	} else {
		$Id_Persona= $_SESSION["session_username"];
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="Js/Consultar_Talleres_Laboratorio_Clan.js"></script>

    <link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    
</head>
<body>
	<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Consulta de clases impartidas <small> LABORATORIO CLAN</small></h1>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-3">Artista Formador.</div>
				<div class="col-xs-9">
					<select class="form-control" id="SL_artista_formador">
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3">Mes del reporte.</div>
				<div class="col-xs-9">
					<select class="form-control" id="SL_mes_reporte">
						<option value="0">Seleccione primero el artista formador</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3"></div>
				<div class="col-xs-6"><button id="BT_consultar_clases" class="btn btn-success form-control">Consultar Clases</button></div>
				<div class="col-xs-3"></div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<table class="table table-bordered" id="table_datos_historico_clase">
						<thead>
							<tr>
								<td>Código grupo</td>
								<td>Clan</td>
								<td>Area Artistica</td>
								<td>Fecha</td>
								<td>Lugar</td>
								<td># personas</td>
								<td>Observaciones</td>
								<td>Archivo Soporte</td>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>