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
	<link rel="stylesheet" href="../LibreriasExternas/bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<script src="../LibreriasExternas/JQuery/jquery-3.1.1.min.js">
	</script>
	<script src="../LibreriasExternas/bootstrap-3.3.7-dist/js/bootstrap.min.js">
	</script>
	<link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="Js/Valoracion_Grupo.js?v=2020.09.30.0">
	</script>
	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
	<link href="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-slider/bootstrap-slider.css">
	<link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-select/bootstrap-select.css">
	<script src="../LibreriasExternas/datatables/media/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" src="../bootstrap/bootstrap-slider/bootstrap-slider.js">
	</script>
	<script type="text/javascript" src="../bootstrap/bootstrap-select/bootstrap-select.js">
	</script>
	<script type="text/javascript" src="../js/bootbox.js">
	</script>
	<link rel="stylesheet" type="text/css" href="../Pedagogico/Js/bootstrap-slider/css/bootstrap-slider.css">
	<link rel="stylesheet" type="text/css" href="../css/Siclan.css">
	<script src="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js">
	</script>
	<link rel="stylesheet" href="../LibreriasExternas/barrating/dist/themes/bars-movie.css">
	<script src="../LibreriasExternas/barrating/jquery.barrating.js"></script>
	<script type="text/javascript" src="../../public/bootstrap/bootstrap-filestyle/bootstrap-filestyle.js"> </script>
</head>
<style type="text/css">
	div{
		font-family: 'Prompt';
		font-size: 14px;
		font-weight: normal; 
	}
	@media only screen and (max-width: 767px) {
		label {
			font-size: 10px;
		}
	}
	.center-modal{
		top: 0%;
		margin-top: 25%;
	}
</style>
<body style="padding: 22px 0px;">
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Valoración de Grupos 
						<small>Artista Formador
						</small>
					</h1>
					<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
				</div>
			</div>
			<div class="panel-body">
				<div id="DIV_SELECCIONAR_GRUPO">
					<form id="FORM_Realizar_Valoracion">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_grupo">Seleccione el grupo:
								</label>
							</div>
							<div class="col-xs-6 col-md-9">
								<select id="SL_grupo" title="Seleccione un grupo" class="form-control  selectpicker" required>
								</select>
							</div>
						</div>
						<div class="row" id="DIV_Observacion" hidden>
							<br>
							<div class="col-md-12">
								<label>Observación
								</label>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<h5 id="LB_Observacion">Observación
								</h5>
							</div>
							<br>
							<div class="col-md-12">
								<label>Estado
								</label>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<h5 id="LB_Estado">
								</h5>
							</div>
							<br>
						</div>
						<div class="row">
							<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
								<br>
								<button class="btn btn-primary form-control" type="submit">Realizar Valoración
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="">
					<div id="DIV_FORM_VALORACION" hidden>
						<form id="FORM_VALORACION">
							<div class="col-md-12">
								<div class="col-md-12" style="text-align: center; border-style: ridge; padding-top: 10px;">
									<p>
										<b>
											VALORACIÓN PROCESOS DE FORMACIÓN ARTÍSTICA
										</b>
									</p>
								</div>
								<div class="col-md-12" style="text-align: left; border-style: ridge;">
									<div class="col-md-7">
										<label id="LB_Clan">CREA:
										</label>
									</div>
									<div class="col-md-5">
										<label id="LB_Formador">Formador:
										</label>
									</div>
								</div>
								<div class="col-md-12" style="text-align: left; border-style: ridge;">
									<div class="col-md-7">
										<label id="LB_Entidad">
										</label>
									</div>
									<div class="col-md-5">
										<label id="LB_Area_Artistica">
										</label>
									</div>
								</div>
								<div class="col-md-12" style="text-align: left; border-style: ridge;">
									<div class="col-md-7">
										<label id="LB_Horario">
										</label>
									</div>
									<div class="col-md-3">
										<select id="SL_PERIODO" name="SL_PERIODO" class="selectpicker form-control" title="Seleccionar Periodo..."  required>
											<option value="1">Periodo 1
											</option>
											<option value="2">Periodo 2
											</option>
											<option value="3">Periodo 3
											</option>
											<option value="4">Periodo 4
											</option>
											<option value="5">Periodo 5
											</option>
											<option value="6">Periodo 6
											</option>
											<option value="7">Periodo 7
											</option>
										</select>
									</div>
								</div>
								<div class="col-md-12" style="text-align: left; border-style: ridge;">
									<div class="col-md-3">
										<select id="SL_CICLO" name="SL_CICLO" class="selectpicker form-control"  title="Seleccionar CICLO..."   required multiple>
											<option value="0" data-subtext=" ">NO APLICA
											</option>
											<option value="1" data-subtext=" (Grados 1,2)">CICLO I
											</option>
											<option value="2" data-subtext=" (Grados 3,4)">CICLO II
											</option>
											<option value="3" data-subtext=" (Grados 5,6,7)">CICLO III
											</option>
											<option value="4" data-subtext=" Grados (8,9)">CICLO IV
											</option>
										</select>
									</div>
									<div class="col-md-5 col-md-offset-4">
										<label id="LB_Fecha_Elaboracion">
										</label>
									</div>
								</div>
								<div id="div_cognitivo" class="col-md-4 non-padding-div" style="background-color: #eef6f0; border-style: outset;">
									<b>COGNITIVO</b>
									<div class="col-md-12 non-padding-div">
										
										<h5 id="H_Cognitivo">
											<b>Gesto</b><br><br> Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.
										</h5>
									</div>
								</div>
								<div id="div_actitudinal" class="col-md-4 non-padding-div" style="height: 140px; background-color: #eef6f0; border-style: outset;">
									<b>ACTITUDINAL</b>

									<div class="col-md-12 non-padding-div">
										<h5> 
											Participa y demuestra interés en las actividades propuestas para el desarrollo del proceso de formación.			
										</h5>
									</div>
								</div>
								<div id="div_convivencial" class="col-md-4 non-padding-div" style="height: 140px; background-color: #eef6f0; border-style: outset;">
									
									<b>CONVIVENCIAL</b>

									<div class="col-md-12 non-padding-div">
										<h5> 
											Contribuye en la creación de un ambiente constructivo para el desarrollo de las actividades artísticas y formativas.			
										</h5>
									</div>
								</div>
								<div class="col-md-12" style="background-color: #eef6f0; border-style: outset;">
									<table class="table table-hover text-center" id="table_listado_estudiantes_grupo" style="width: 100%;">
										<thead>
											<tr>
												<th class="text-center">Nº</th>
												<th class="text-center">Nombre</th>
												<th class="text-center">Apellido</th>
												<th class="text-center">Curso</th>
												<th class="text-center">Asistencia</th>
												<th class="text-center">Cognitivo</th>
												<th class="text-center">Actitudinal</th>
												<th class="text-center">Convivencial</th>
												<th class="text-center">Recomendaciones y Observaciones</th>
											</tr>
										</thead>
									</table>
								</div>
								<div class="col-md-12" style="background-color: #eef6f0; border-style: outset;">
									
									<h3>Anexo</h3>
									<div class="col-md-12 non-padding-div">
										<div id="div_anexo_archivo" data-toggle="tooltip" title="Anexo Valoración" data-placement="right" class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<input accept="application/pdf" id="anexo_archivo" multiple name="file[]" type="file" class="filestyle" data-buttonName="btn-danger" data-buttonBefore="true" runat="server" data-buttonText="Anexo">
										</div>
										<br>
									</div>
									<div class="col-md-12">
										<br>
									</div>
								</div>

								<div class="col-md-12">
									<br>
									<div class="col-md-6 col-md-offset-4">
										<input type="submit" id="BTN_Guardar_valoracion" name="BTN_Guardar_valoracion" class="btn btn-success" value="GUARDAR VALORACIÓN">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<div class="modal fade center-modal" id="MODAL_EJEMPLO_UNO">
	<div class="modal-dialog " role="document">
		<form id="FORM_Observacion">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-md-11">
						<h4 class="modal-title"><b>RECOMENDACIONES Y OBSERVACIONES</b></h4>
					</div>
					<div class="col-md-1">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
				<div class="modal-body" style="text-align: justify;">
					<h5 id="LB_Estudiante">
					</h5>
					<textarea class="form-control" rows="1"  type="" id="TXT_Observacion" name="TXT_Observacion" placeholder="Aquí las Recomendaciones y Observaciones" required></textarea>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Guardar
					</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

</html>