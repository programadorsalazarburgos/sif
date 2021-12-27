<div class="row">
	<div class="col-xs-12 col-md-12 alert alert-warning">
		<h4>Seleccione el evento que desea registrar asistencia: <small>Tenga en cuenta que esta opción es unicamente para registro de asistencias a eventos en los cuales los participantes no son acompañados por un artista formador.</small></h4>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-md-3">
		<label for="SL_evento_registrar_asistencia">Evento:</label>
	</div>
	<div class="col-xs-12 col-md-9">
		<select class="selectpicker form-control" data-live-search="true" id="SL_evento_registrar_asistencia"></select>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-md-3">
		<label for="TX_fecha_asistencia_evento">Fecha sesión evento:</label>
	</div>
	<div>
		<div class="col-xs-12 col-md-9">
			<div class="input-group date">
				<input type="text" id="TX_fecha_asistencia_evento" readonly="readonly" class="form-control">
				<div class="input-group-addon" id="SPAN_fecha_asistencia_evento">
					<span class="glyphicon glyphicon-calendar"></span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-md-3">
		<label for="SL_horas_sesion_evento">Horas de participación</label>
	</div>
	<div class="col-xs-12 col-md-9">
		<select class="form-control selectpicker" required="required" title="Seleccione una opción" data-live-search="true" id="SL_horas_sesion_evento">
			<option value="1" selected="selected">Una (01)</option>
			<option value="2">Dos (02)</option>
			<option value="3">Tres (03)</option>
			<option value="4">Cuatro (04)</option>
			<option value="5">Cinco (05)</option>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-md-3">
		<label for="SL_linea_atencion_sesion_evento">Linea de atención</label>
	</div>
	<div class="col-xs-12 col-md-9">
		<select class="form-control selectpicker" required="required" title="Seleccione una opción" data-live-search="true" id="SL_linea_atencion_sesion_evento">
			<option value="arte_escuela" selected="selected">Arte en la escuela</option>
			<option value="emprende_clan">Emprende CREA</option>
			<option value="laboratorio_clan">Laboratorio CREA</option>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-12 table-responsive">
		<table class='table table-striped table-bordered' id='table_estudiantes_evento'>
			<thead><tr>
				<th>Permiso Padres</th>
				<th>Identificación</th>
				<th>Nombre</th>
				<th>Registro asistencia</th>
			</tr></thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-md-3">
		<label for="TX_observaciones">Observaciones:</label>
	</div>
	<div class="col-xs-12 col-md-9">
		<textarea class="form-control" id="TX_observaciones" placeholder="Observaciones"></textarea>
	</div>
</div>
<div class="row">
	<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
		<button class="btn btn-success form-control" id="BT_guardar_asistencia_sesion_evento">Guardar</button>
	</div>
</div>