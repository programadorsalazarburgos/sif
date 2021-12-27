<div class="row">
	<div class="col-xs-12 col-md-12 alert alert-warning">
		<h4>Seleccione el evento que desea modificar:</h4>
		<p>
			Unicamente podrá modificar los eventos que ha creado.
		</p>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-md-3">
		<label for="SL_evento_modificar">Evento:</label>
	</div>
	<div class="col-xs-12 col-md-9">
		<select class="selectpicker form-control" data-live-search="true" id="SL_evento_modificar"></select>
	</div>
</div>
<br>
<div class="panel-group" id="accordion">
	<div class="panel panel-info">
		<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
			<div class="panel-heading">
				<h4 class="panel-title">
					Datos Basicos
				</h4>
			</div>
		</a>
		<div id="collapse1" class="panel-collapse collapse in">
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="BT_estado_evento">Estado evento:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<input type="button" class="form-control btn btn-danger" name="BT_estado_evento" id="BT_estado_evento" value="Finalizar Evento">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="TX_modificar_nombre">Nombre del evento:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<input required="required" class="form-control" type="text" id="TX_modificar_nombre" title="Generado automaticamente por el sistema de información" readonly="readonly" disabled="disabled" placeholder="Nombre">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_modificar_tipo_evento">Tipo de Evento:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="selectpicker form-control" name="SL_modificar_tipo_evento" data-live-search="true" id="SL_modificar_tipo_evento"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="TX_modificar_fecha_evento">Fecha y Hora:</label>
					</div>
					<div class='col-xs-6 col-md-5'>
						<div class="form-group">
							<div class='input-group date' id='TX_modificar_fecha_evento'>
								<input type='text' name="TX_modificar_fecha_inicio_evento" id="TX_modificar_fecha_inicio_evento" class="form-control" required="required" placeholder="Fecha y Hora Inicio" readonly="readonly" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
					<div class='col-xs-6 col-md-4' id="DIV_fecha_fin_evento_modificar">
						<div class="form-group">
							<div class='input-group date'>
								<input type='text' id='TX_modificar_fecha_fin_evento' name="TX_modificar_fecha_fin_evento" class="form-control" required="required" placeholder="Fecha y Hora Fin" readonly="readonly" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="TX_modificar_lugar">Lugar (ubicación o <b>URL</b>):</label>
						<!-- <label for="">Lugar o ubicación:</label> -->
					</div>
					<div class="col-xs-12 col-md-9">
						<input required="required" class="mayuscula form-control" type="text" name="TX_modificar_lugar" id="TX_modificar_lugar" placeholder="Lugar (Ubicación o URL)">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="TX_modificar_objetivo">Objetivo o Descripción:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<textarea required="required" class="form-control" type="text" rows="4" name="TX_modificar_objetivo" id="TX_modificar_objetivo" placeholder="Objetivo o Descripción"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="TX_modificar_publico_asistente">Publico Asistente Esperado:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<input required="required" class="form-control" type="number" id="TX_modificar_publico_asistente" placeholder="Publico Asistente Esperado">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
						<button class="form-control btn btn-success" id="BT_modificar_guardar_datos_basicos">Modificar Datos Basicos</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-info">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
		<div class="panel-heading">
			<h4 class="panel-title">
				Datos multiples
			</h4>
		</div>
	</a>
	<div id="collapse2" class="panel-collapse collapse">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<label for="SL_clan_modificar_evento">Crea(s)</label>
				</div>
				<div class="col-xs-12 col-md-9">
					<select required="required" multiple id="SL_clan_modificar_evento" name="SL_clan_modificar_evento[]" class="selectpicker form-control" title="Seleccione uno o varios crea" data-live-search="true"></select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<label for="SL_area_artistica_modificar_evento">Area(s) Artistica(s):</label>
				</div>
				<div class="col-xs-12 col-md-9">
					<select multiple required="required" id="SL_area_artistica_modificar_evento" name="SL_area_artistica_modificar_evento[]" class="selectpicker form-control" title="Seleccione una o varias areas artisticas" data-live-search="true"></select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<label for="SL_artista_formador_modificar_evento">Artista(s) Formador(es)</label>
				</div>
				<div class="col-xs-12 col-md-9">
					<select required="required" multiple id="SL_artista_formador_modificar_evento" name="SL_artista_formador_modificar_evento[]" class="selectpicker form-control" title="Seleccione uno o varios artistas formadores" data-live-search="true"></select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
					<button class="form-control btn btn-success" id="BT_modificar_guardar_datos_multiples">Modificar Datos Multiples</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-info">
	<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
		<div class="panel-heading">
			<h4 class="panel-title">
				Recursos e insumos
			</h4>
		</div>
	</a>
	<div id="collapse3" class="panel-collapse collapse">
		<div class="panel-body">
			<div class="row">
				<hr>
				<div class="col-xs-3 col-md-3">
					<b>Recursos e insumos:</b>
					<br>
					<select id="SL_tipo_evento_recursos_modificar" name="SL_tipo_evento_recursos_modificar" title="Seleccione el tipo de evento" class="selectpicker form-control">
						<option value="propio">Propio</option>
						<option value="externo">Externo</option>
					</select>
					<br>
					<br>
					<div id="div_quien_invita_modificar"></div>
				</div>
				<div class="col-xs-9 col-md-9">
					<div class="panel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div id="div_alert_tipo_evento_recurso_modificar" class="alert alert-warning">
									<strong>Evento Interno!</strong> El evento es <u>propio</u> y se debe especificar los recursos e insumos que <strong>proporcionará el CREA</strong>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="transporte_modificar">Transporte</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" rows="2" required="required" placeholder="Transporte" name="transporte_modificar" id="transporte_modificar"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="tecnica_produccion_modificar">Técnica en producción</label>
							</div>
							<div class="col-xs-12 col-md-9" required="required">
								<textarea class="form-control" rows="2" required="required" placeholder="Técnica en producción" name="tecnica_produccion_modificar" id="tecnica_produccion_modificar"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="vestuario_modificar">Vestuario</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" rows="2" required="required" placeholder="Vestuario" name="vestuario_modificar" id="vestuario_modificar"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="escenografia_modificar">Escenografía</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" rows="2" required="required" placeholder="Escenografía" name="escenografia_modificar" id="escenografia_modificar"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="maquillaje_modificar">Maquillaje</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" rows="2" required="required" placeholder="Maquillaje" name="maquillaje_modificar" id="maquillaje_modificar"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="alimentacion_modificar">Alimentación</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" rows="2" required="required" placeholder="Alimentación" name="alimentacion_modificar" id="alimentacion_modificar"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="comunicaciones_instrumentos_modificar">Instrumentos</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" rows="2" required="required" placeholder="Comunicaciones e instrumentos" name="comunicaciones_instrumentos_modificar" id="comunicaciones_instrumentos_modificar"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
					<button class="form-control btn btn-success" id="BT_modificar_guardar_recursos_insumos">Modificar Datos de Recursos e Insumos</button>
				</div>
			</div>
		</div>
	</div>
</div>