<!DOCTYPE html>
<link href="../bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../css/Siclan.css" rel="stylesheet">
<html>

<body style="padding-top: 50px;">
<div class="jumbotron" style="height: 350px;">
	<a class="btn-lg btn-success col-md-6 col-md-offset-3" style="padding-top: 50px; padding-bottom: 50px" href="https://si.clan.gov.co/ConvocatoriaOrganizaciones/" target="_blank"><center>Click Aquí para Acceder a la Convocatoria</center></a>
	<!--<a class="btn-lg btn-danger col-md-6 col-md-offset-3" style="padding-top: 50px; padding-bottom: 50px" data-toggle="modal" data-target="#MODAL_CONSULTA_REPORTE"><center><span class="glyphicon glyphicon-download-alt"></span> Descargar Reporte Propuesta</center></a>-->
</div>
<!--<div class="jumbotron" style="height: 250px;">
	<a class="btn-lg btn-danger col-md-6 col-md-offset-3" style="padding-top: 50px; padding-bottom: 50px" data-toggle="modal" data-target="#MODAL_CONSULTA_REPORTE"><center>Descargar Reporte Propuesta</center></a>
</div>-->
<form name="FORM_CONSULTA_REPORTE" id="FORM_CONSULTA_REPORTE" method="POST">
				<div class="modal fade" id="MODAL_CONSULTA_REPORTE" name="MODAL_CONSULTA_REPORTE" tabindex="-1" role="dialog">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">Descargar Reporte Propuesta</h4>
				      </div>
				      <div class="modal-body">
				      	<div class="row">
				      		<div class="col-md-12">
				      			<div class="col-md-4" style="text-align: right">
				      				<label>NIT Organización:</label>
				      			</div>
				        		<div class="col-md-6">
				        			<input class="form-control" type="text" name="TXT_NIT" id="TXT_NIT">
				        		</div>
				          	</div>
				      	</div>
				      	<div class="row">
				      		<div class="col-md-12">
				      			<br>
				      			<table id="tabla_proyectos" name="tabla_proyectos" class="table table-hover">
				      				
				      			</table>
				          	</div>
				      	</div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-danger">Ver Propuestas</button>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
</form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../bootstrap/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="Js/ConsultarReporte.js"></script>	
</html>