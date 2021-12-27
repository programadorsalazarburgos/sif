<div class="row">
	<div class="col-xs-3"><h4><label for="SL_evento_asignar_participante">Seleccione el evento distrital:</label></h4></div>
	<div class="col-xs-9">
		<select id="SL_evento_asignar_participante" data-live-search="true" name="SL_evento_asignar_participante" title="Seleccione el evento distrital" class="form-control selectpicker"></select>
	</div>
</div>
<div id="datos_participantes_asignados_evento">
	<div class="row">
		<div class="col-xs-3 col-md-3">
			<button align="center" id="BT_buscar_participante_grupo" class="form-control btn btn-success eventoClic" data-toggle='modal' data-target='#modal_agregar_desde_grupo'>
				<span class="glyphicon glyphicon-list"></span> Desde Grupo
			</button>
		</div>
		<div class="col-xs-4 col-xs-offset-1 col-md-4 col-md-offset-1 text-center"></div>
		<div class="col-xs-3 col-xs-offset-1 col-md-3 col-md-offset-1">
			<!--<button align='center' id="BT_asignar_participante" class='form-control btn btn-primary eventoClic' data-toggle='modal' data-target='#modal-buscar' data-add-estudiante=''>
				<span class="glyphicon glyphicon-user"></span> Manualmente
			</button>-->
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-md-12 table-responsive">
				<table class='table table-striped table-bordered' id='table_participantes'>
					<thead><tr>
						<th>Permiso Padres</th>
						<th>Identificación</th>
						<th>Nombre</th>
						<th>Opciones</th>
					</tr></thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class='modal fade' role='dialog' id='modal-buscar'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal'>&times;</button>
				<h4 class='modal-title'>Asignar Participante</h4>
			</div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-xs-12'><p>Escriba el nombre del participante o el número de documento.</p></div>
				</div>
				<div class='row'>
					<div class='col-xs-12'>
						<div class='input-group'>
							<span class='input-group-addon' id='basic-addon1'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></span>
							<input class='form-control' data-id_evento='' aria-describedby='basic-addon1' id='TB_buscar_participante' type='text' placeholder='Apellidos, Nombres o Documento del participante'>
							<span class='input-group-btn'><button id='BT_buscar_participante' class='form-control btn-info eventoClic'>Buscar</button></span>
						</div>
					</div>
				</div>
				<div id='datos_participante'>
					<fieldset>
						<legend>Datos del participante</legend>
						<form id="form_nuevo_participante_grupo">
							<div class ='row'>
								<div class='col-xs-12'><div class='alert-warning'><b>Estos datos fueron cargados de la ultima inscripción del participante en el (SIF). </b>Debe verificar que todos los campos correspondan y corregir los que sea necesario, usando el menu desplegable.</div></div>
							</div>
							<div class='row'>
								<div class='col-xs-6 col-md-3'>
									<label for="label_nombre_participante">Participante</label>
								</div>
								<div class='col-xs-12 col-md-9' align='center'>
									<b><input class='form-control' type='text' disabled='disabled' id='label_nombre_participante' name='label_nombre_participante'></input></b>
								</div>
							</div>
							<div class='row'>
								<div class="col-xs-6 col-md-3">
									<label for='SL_area_artistica_agregar_participante'>Area Artistica:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select id="SL_area_artistica_agregar_participante" class="form-control selectpicker" data-live-search='true' title="Seleccione area artistica" required="required"></select>
								</div>
							</div>
							<div class='row'>
								<div class="col-xs-6 col-md-3">
									<label for='SL_crea_agregar_participante'>Crea:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select id="SL_crea_agregar_participante" class="form-control selectpicker" data-live-search='true' title="Seleccione CREA" required="required"></select>
								</div>
							</div>
							<div class='row'>
								<div class="col-xs-6 col-md-3">
									<label for='SL_organizacion_agregar_participante'>Organización:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select id="SL_organizacion_agregar_participante" class="form-control selectpicker" data-live-search='true' title="Seleccione Organización" required="required"></select>
								</div>
							</div>
							<div class='row'>
								<div class="col-xs-6 col-md-3">
									<label for='SL_colegio_agregar_participante'>Colegio:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select id="SL_colegio_agregar_participante" class="form-control selectpicker" data-live-search='true' title="Seleccione Colegio" required="required"></select>
								</div>
							</div>
							<div class='row'>
								<div class="col-xs-6 col-md-3">
									<label for='SL_grado_agregar_participante'>Grado:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select id="SL_grado_agregar_participante" class="form-control selectpicker" data-live-search='true' title="Seleccione Grado" required="required"></select>
								</div>
							</div>
							<div class='row' align='center'>
								<div class='col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4'><input type="submit" id='BT_asignar_participante_evento' class=' form-control btn-success eventoClic'></div>
							</div>
						</form>
					</fieldset>
				</div>
				<div class='row'>
					<div class='col-xs-12' id='resultado-busqueda'></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='modal fade' role='dialog' id='modal_agregar_desde_grupo'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal'>&times;</button>
				<h4 class='modal-title'>Asignar participante desde grupo a evento distrital</h4>
			</div>
			<div class='modal-body'>
				<div class='row'>
					<div class="col-xs-6 col-md-3">
						<label for="SL_crea_desde_grupo">Seleccione CREA:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" data-live-search="true" id="SL_crea_desde_grupo"></select>
					</div>
				</div>
				<div class='row'>
					<div class="col-xs-6 col-md-3">
						<label for="SL_grupo">Seleccione Grupo:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" data-live-search="true" id="SL_grupo"></select>
					</div>
				</div>
				<div class="row">
					<div class="table-responsive">
						<table class="table table-responsive table-bordered table-striped" id="table_estudiantes_grupo">
							<thead>
								<tr>
									<th>Identificación</th>
									<th>Nombre</th>
									<th>Opción</th>
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
<div class='modal fade' role='dialog' id='modal_editar_datos_participante'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal'>&times;</button>
				<h4 class='modal-title'>Editar Datos Participante</h4>
			</div>
			<div class='modal-body'>
				<div class='row'>
					<div class="col-xs-6 col-md-3">
						<label for="SL_editar_participante_area_artistica">Seleccione Area Artistica:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" data-live-search="true" id="SL_editar_participante_area_artistica"></select>
					</div>
				</div>
				<div class='row'>
					<div class="col-xs-6 col-md-3">
						<label for="SL_editar_participante_crea">Seleccione CREA:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" data-live-search="true" id="SL_editar_participante_crea"></select>
					</div>
				</div>
				<div class='row'>
					<div class="col-xs-6 col-md-3">
						<label for="SL_editar_participante_colegio">Seleccione Colegio:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" data-live-search="true" id="SL_editar_participante_colegio"></select>
					</div>
				</div>
				<div class='row'>
					<div class="col-xs-6 col-md-3">
						<label for="SL_editar_participante_grado">Seleccione Grado:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" data-live-search="true" id="SL_editar_participante_grado"></select>
					</div>
				</div>
				<div class='row'>
					<div class="col-xs-6 col-md-3">
						<label for="SL_editar_participante_organizacion">Seleccione Organización:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" data-live-search="true" id="SL_editar_participante_organizacion"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-4 col-md-offset-2">
						<button class="btn btn-success form-control eventoClic" id="BT_editar_participante">Guardar Cambios</button>
					</div>
					<div class="col-xs-6 col-md-4">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>