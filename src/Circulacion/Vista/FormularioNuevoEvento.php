<div class="row alert alert-warning">
	<h4>Diligencie todos los datos del siguiente formulario:</h4>
</div>
<form id="form_nuevo_evento">
	<div class="panel panel-info">
		<a href="#collapse_crear_datos_basicos">
			<div class="panel-heading">
				<h4 class="panel-title">
					Datos Basicos
				</h4>
			</div>
		</a>
		<div id="collapse_crear_datos_basicos">
			<div class="panel-body">
				<div class="row" id="DIV_nombre">
					<div class="col-xs-6 col-md-3">
						<label for="nombre">Nombre del evento:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<input disabled="disabled" readonly="readonly" required="required" class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre (Generado automaticamente por el sistema de información)" title="Generado automaticamente por el sistema de información">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_tipo_evento">Tipo de Evento:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="selectpicker form-control" name="SL_tipo_evento" title="Seleccione el tipo de evento" data-live-search="true" id="SL_tipo_evento" required="required"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="lugar">Lugar (ubicación o <b>URL</b>):</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<input required="required" class="form-control mayuscula" type="text" name="lugar" id="lugar" maxlength="30" placeholder="Lugar (Ubicación o URL)">
					</div>
				</div>
				<div class="row" id="DIV_fecha_evento">
					<div class="col-xs-6 col-md-3">
						<label for="fecha_evento">Fecha y Hora:</label>
					</div>
					<div class='col-xs-6 col-md-5'>
						<div class="form-group">
							<div class='input-group date' id='fecha_evento'>
								<input type='text' name="fecha_inicio_evento" id="fecha_inicio_evento" class="form-control" required="required" placeholder="Fecha y Hora Inicio" readonly="readonly" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
					<div class='col-xs-6 col-md-4' id="DIV_fecha_fin_evento">
						<div class="form-group">
							<div class='input-group date'>
								<input type='text' id='fecha_fin_evento' name="fecha_fin_evento" class="form-control" required="required" placeholder="Fecha y Hora Fin" readonly="readonly" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="publico_asistente">Público asistente Esperado:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<input required="required" class="form-control" type="number" name="publico_asistente" id="publico_asistente" placeholder="Publico Asistente Esperado" value="0">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="objetivo">Objetivo o Descripción:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<textarea required="required" class="form-control" type="text" rows="4" name="objetivo" id="objetivo" placeholder="Objetivo o Descripción"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-info">
		<a href="#collapse_crear_datos_multiples">
			<div class="panel-heading">
				<h4 class="panel-title">
					Datos Múltiples
				</h4>
			</div>
		</a>
		<div id="collapse_crear_datos_multiples">
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_clan">Crea(s)</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select required="required" multiple id="SL_clan" name="SL_clan[]" class="selectpicker form-control" title="Seleccione uno o varios crea" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_area_artistica">Area(s) Artistica(s):</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select multiple required="required" id="SL_area_artistica" name="SL_area_artistica[]" class="selectpicker form-control" title="Seleccione una o varias areas artisticas" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_artista_formador">Artista(s) Formador(es)</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select required="required" multiple id="SL_artista_formador" name="SL_artista_formador[]" class="selectpicker form-control" title="Seleccione uno o varios artistas formadores" data-live-search="true"></select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-info">
		<a href="#collapse_crear_recursos_insumos">
			<div class="panel-heading">
				<h4 class="panel-title">
					Recursos e insumos
				</h4>
			</div>
		</a>
		<div id="collapse_crear_recursos_insumos">
			<div class="panel-body">
				<div class="row">
					<hr>
					<div class="col-xs-12 col-md-3">
						<b>Recursos e insumos:</b>
						<br>
						<select id="SL_tipo_evento_recursos" name="SL_tipo_evento_recursos" title="Seleccione el tipo de evento" class="selectpicker form-control">
							<option selected="selected" value="propio">Propio</option>
							<option value="externo">Externo</option>
						</select>
						<br>
						<br>
						<div id="div_alert_tipo_evento_recurso" class="alert alert-warning">
							<strong>Evento Interno!</strong> El evento es <u>propio</u> y se debe especificar los recursos e insumos que <strong>proporcionará el CREA</strong>
						</div>
						<div id="div_quien_invita"></div>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="panel">
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="transporte">Transporte</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<textarea class="form-control" rows="2" required="required" placeholder="Transporte" name="transporte" id="transporte"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="tecnica_produccion">Técnica en producción</label>
								</div>
								<div class="col-xs-12 col-md-9" required="required">
									<textarea class="form-control" rows="2" required="required" placeholder="Técnica en producción" name="tecnica_produccion" id="tecnica_produccion"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="vestuario">Vestuario</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<textarea class="form-control" rows="2" required="required" placeholder="Vestuario" name="vestuario" id="vestuario"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="escenografia">Escenografía</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<textarea class="form-control" rows="2" required="required" placeholder="Escenografía" name="escenografia" id="escenografia"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="maquillaje">Maquillaje</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<textarea class="form-control" rows="2" required="required" placeholder="Maquillaje" name="maquillaje" id="maquillaje"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="alimentacion">Alimentación</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<textarea class="form-control" rows="2" required="required" placeholder="Alimentación" name="alimentacion" id="alimentacion"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="comunicaciones_instrumentos">Instrumentos</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<textarea class="form-control" rows="2" required="required" placeholder="Comunicaciones e instrumentos" name="comunicaciones_instrumentos" id="comunicaciones_instrumentos"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
			<input type="hidden" name="opcion" value="new_evento" />
			<input required="required" class="btn-success form-control" type="submit" id="BT_guardar_evento" name="Guardar" value="Guardar">
		</div>
	</div>
</form>