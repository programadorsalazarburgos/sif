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

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Administracion_contenidos.js?v=2020.07.15"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">

	<style type="text/css">
		.p-t{
			padding-top: 15px;
		}
	</style>

	<title>Administración de contenidos</title>
</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de contenidos</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#administracion-contenidos" role="tab">Administración de contenidos</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="administracion-contenidos" role="tabpanel">
						<div class="panel-group" id="accordion">
							<div class="panel panel-default col-lg-6 col-lg-offset-3">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Administración de categorias</a>
									</h4>
								</div>
								<div id="collapse1" class="panel-collapse collapse in">
									<div class="panel-body">
										<div class="row p-t">
											<div class="col-lg-10 col-lg-offset-1">
												<label>Nueva categoria</label>
												<form id="form-nueva-categoria-contenido">
													<div class="row">
														<div class="col-lg-10">
															<input type="text" class="form-control" id="tx-nueva-categoria-contenido" required="required">
														</div>
														<div class="col-lg-2">
															<button type="submit" class="btn btn-block btn-primary"><i class="fas fa-plus-circle"></i></button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<div class="row p-t">
											<div class="col-lg-10 col-lg-offset-1">
												<label>Categorias creadas</label>
												<div id="div-categorias-creadas" class="content">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default col-lg-6 col-lg-offset-3">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Administración de contenidos</a>
									</h4>
								</div>
								<div id="collapse2" class="panel-collapse collapse">
									<div class="panel-body">
										<div class="row p-t">
											<div class="col-lg-10 col-lg-offset-1">
												<label>Categoria</label>
												<select class="form-control selectpicker" title="Seleccione una opción" name="sl-categoria" id="sl-categoria"></select>
											</div>		
										</div>
										<div class="row p-t">
											<div class="col-lg-10 col-lg-offset-1">
												<label>Nuevo contenido</label>
												<form id="form-nuevo-contenido">
													<div class="row">
														<div class="col-lg-10">
															<input type="text" class="form-control" id="tx-nuevo-contenido" required="required">
														</div>
														<div class="col-lg-2">
															<button type="submit" class="btn btn-block btn-primary"><i class="fas fa-plus-circle"></i></button>
														</div>
													</div>
												</form>	
											</div>	
										</div>
										<div class="row p-t">
											<div class="col-lg-10 col-lg-offset-1">
												<div id="div-contenidos-creados" class="content">
												</div>
											</div>
										</div>
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

