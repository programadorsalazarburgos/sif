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
	<title>Solicitud soportes (Incidentes)</title>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 

	
    <link href="../css/solicitud_soporte.css?v=2018.09.11.11" rel="stylesheet" type="text/css">    
  	
  	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script><!-- defer  integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous" -->
	

	<link href="../bootstrap/metisMenu/dist/metisMenu.min.css" rel="stylesheet"> 
	<script src="../bootstrap/metisMenu/dist/metisMenu.min.js"></script>

	<!-- <script type="text/javascript" src="../js/bootbox.js"></script> -->
	<script type="text/javascript" src="../js/bootstrap-filestyle.js"> </script>
    <link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>	

	<!-- include summernote css/js--> 
	<link href="../bower_components/summernote/dist/summernote.css" rel="stylesheet"> 
	<script src="../bower_components/summernote/dist/summernote.min.js"></script>          
	<script src="../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>    

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>  	

	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>
	

	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >  

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>  

	<script type="text/javascript" src="Js/Solicitud_Soporte2.js?v=2019.06.17.001"></script>    
		
</head>
<body> 
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<!--<div class="page-header">-->
					<h4>Solicitud Soporte <small>SIF <?= date("Y") ?></small></h4>
				<!--</div>--> 
			</div>
			<div class="modal fade" id="modal_actividades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-body"> 							
							<div id='actividades'></div>							
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->	

			<div class="modal fade" id="modal_observaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" id="tituloObservaciones"></h4>
						</div>					
						<div class="modal-body"> 
							<div class="row">

								<div class="col-xs-12 col-md-12 table-responsive">
									<table id="table_observacion_incidentes" style="width: 100%" class="table table-hover">
										<thead>
											<tr>
												<th class="text-center"><strong>Fecha</strong></th>					
												<th class="text-center"><strong>Usuario</strong></th>
												<th class="text-center"><strong>Observación</strong></th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>	 												
							<div class="row">
								<div id='observacionesIncidente'></div>
								<div class="row container"> 
									<div class="col-xs-12 col-md-1"> 
									  <label for="adjuntos">Adjuntos:</label> 
									</div>  
									<div id="contenedorAdjuntos" class="col-xs-10 col-md-10"> 
									</div>             
								</div> 
					            <div class="col-xs-12 col-md-3">
									<select class="selectpicker" title="Escoga el el tipo de observación" id="tipoObservacion">			
										<option value='0'>Pública</option>
										<option value='1'>Privada</option>
									</select>
								</div>
					            <div class="col-xs-12 col-md-1 div_cerrarIncidente"> 
					              <label for="cerrarIncidente">Re abrir:</label> 
					            </div> 
					            <div class="col-xs-12 col-md-3 div_cerrarIncidente"> 
					              <input data-toggle="toggle" data-onstyle="success" name= "cerrarIncidente" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox"  id="cerrarIncidente">  
					            </div>  								
					            <div class="col-xs-12 col-md-5">
									<button class="btn btn-success" id="guardarObservacion">Guardar Observación</button>			
								</div> 								 						
								<input type="hidden" name="incidente_codigo" id="incidente_codigo" />	 
								<input type="hidden" name="observadores" id="observadores" />	
								<input type="hidden" name="atendido" id="atendido" />
								<input type="hidden" name="estado" id="estado" />
								<input type="hidden" name="usuario" id="usuario" />
							</div>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->	

			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a id="formulario" class="nav-link" data-toggle="tab" href="#solicitud_soporte_nuevo" role="tab">Solicitud de un nuevo soporte</a></li>
					<li class="nav-item"><a id="ver_historico" class="nav-link" data-toggle="tab" href="#historico_soportes" role="tab">Historico mis soportes</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="solicitud_soporte_nuevo" role="tabpanel">
						<div class="container-fluid">							
							<div class="row">
								<div class="input-group col-xs-12 col-md-12">
									<span class="input-group-addon" id="basic-addon-1"><i class="fas fa-user"></i></span>
									<input type="text" disabled="disabled" class="form-control" placeholder="Apellidos Nombres o Documento del usuario" aria-describedby="basic-addon1" id="TB_nombre_usuario">
									<?php echo "<input type='hidden' name='id_usuario' id='id_usuario'  value='".$Id_Persona."'>"; ?>
									<input type="hidden" name="sla_codigo" id="sla_codigo">
								</div>
							</div>									

							<div class="row">
								<div class="input-group col-xs-12 col-md-12">
									<span class="input-group-addon" id="basic-addon-2"><i class="fas fa-id-card"></i></span>
									<input type="text" disabled="disabled" class="form-control" placeholder="Identificación del usuario" aria-describedby="basic-addon-2" id="TB_identificacion_usuario">
								</div>
							</div>
							<div class="row">
								<div class="input-group col-xs-12 col-md-12">
									<span class="input-group-addon" id="basic-addon-3"><i class="fas fa-at"></i></span>
									<input type="text" disabled="disabled" class="form-control" placeholder="Correo del usuario" aria-describedby="basic-addon-3" id="TB_correo_usuario">
								</div>
							</div>
							<div class="row">
								<div class="input-group col-xs-12 col-md-12">
									<span class="input-group-addon" id="basic-addon1"><i class="fas fa-ellipsis-v"></i></span></span>
									<select  class="form-control selectpicker" id="SL_tipo_soporte" data-live-search="true"></select>
								</div>
							</div>  
							<div class="row" id="div_SL_observadores">
								<div class="input-group-selectpicker col-xs-12 col-md-12">
									<span class="input-group-addon" id="basic-addon1"><i class="fas fa-users"></i></span></span>
									<select id="SL_observadores" multiple="multiple" class="form-control selectpicker"data-actions-box="false"  data-live-search="true" title="A quien copiar este incidente"></select>
								</div>							
							</div> 				
							<div class="row actividadInicio">
								<div class="input-group col-xs-12 col-md-12">
									<span class="input-group-addon" id="basic-addon-a"><i class="fas fa-filter"></i></span>
									<button class="btn btn-info form-control" id="TFK_Actividad_Apertura">
										<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>
									</button>					
											
									<input type='hidden' name='FK_Actividad_Apertura' id='FK_Actividad_Apertura' value=''>
								</div>
							</div>						
							<div class="row">
								<div class="input-group col-xs-12 col-md-12">
									<span class="input-group-addon" id="basic-addon1"><i class="fas fa-text-width"></i></span>
									<input type='text' class="form-control" id="titulo" placeholder="Titulo de la solicitud" />
								</div>
							</div>						
							<div class="row">
								<div class="input-group col-xs-12 col-md-12">
									<span class="input-group-addon" id="basic-addon1"><i class="fas fa-comment"></i></span>
									<div id="TX_solicitud"></div>

									<!--<textarea class="form-control" id="TX_solicitud" placeholder="Detalle de la solicitud" rows="5"></textarea>-->
								</div>
							</div>
							<div class="row">
								<div id="div_archivo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<input id="archivos_incidente" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" size="2" data-max-size="10240" runat="server" multiple>
								</div>					
							</div>
							<div class="row">
									<div id="archivos_adjuntos_incidente" class="col-xs-12 col-sm-12 col-md-12 col-lg-6 alert alert-info" style="padding:5px;">
										<strong>Estos son los archivos que se van a enviar:</strong>
									</div>							
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
									<button class="btn btn-success form-control" id="BT_enviar_solicitud">Enviar solicitud</button>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="historico_soportes" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>HISTORIAL: <small>A continuación se visualizan todas las solicitudes que han sido enviadas a la mesa de ayuda de SICREA correspondientes a mi usuario.</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12 table-responsive">
								<table id="table_historico_solicitudes" style="width: 100%" class="table table-hover">
									<thead>
										<tr>
											<th class="text-center"><strong># Ticket</strong></th>										
											<th class="text-center"><strong>Fecha de Envío</strong></th>
											<th class="text-center"><strong>Usuario que solicita</strong></th> 
											<th class="text-center"><strong>Observadores</strong></th> 
											<th class="text-center"><strong>Titulo</strong></th>						
											<th class="text-center"><strong>Estado</strong></th>
											<th class="text-center"><strong>Prioridad</strong></th>
											<th class="text-center"><strong>Observaciones</strong></th>											
											<th class="text-center"><strong>Atendido por</strong></th>
											<th class="text-center descripcion"><strong>Descripción</strong></th>											
											<th class="text-center descripcion"><strong>Solución</strong></th>
											<th class="text-center"><strong>Fecha de Respuesta</strong></th>
											<th class="text-center"><strong>Actividad Problema Inicial</strong></th>	
											<th class="text-center"><strong>Actividad Problema Cierre</strong></th>				
											<th class="text-center"><strong>Tipo De Solicitud</strong></th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='hidden' id='respuestaFinal'></div>
</body>
</html>