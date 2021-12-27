<div class="row">
	<div class="col-xs-12 col-md-12 alert alert-warning">
		<p>
			A continuación encontrará todos los eventos con estado <b>Activo</b> y que tienen asociado su CREA. Podrá asignar o remover artistas formadores al evento.<br>
			Si no encuentra el evento en el listado verifique en la actividad <a href="Consultar_Calendario_Eventos.php" title="Consultar Calendario Eventos">Calendario Circulación</a> o con el organizador principal del evento que este no tenga estado <b>Finalizado</b> y que <b>el CREA que tiene asignado se encuentre asociado al evento.</b>
		</p>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-md-3">
		<label for="SL_evento_administrar_artistas">Seleccione el evento</label>
	</div>
	<div class="col-xs-12 col-md-9">
		<select class="selectpicker form-control" data-live-search="true" id="SL_evento_administrar_artistas"></select>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-xs-8 col-md-10">
		<p>
			Estos son los artistas formadores que se encuentran actualmente asociados al evento.
		</p>
	</div>
	<div class="col-xs-4 col-md-2">
		<button class="btn btn-danger form-control" id="BT_agregar_artista_evento" data-toggle="modal" data-target="#modal_agregar_artista_formador">
			<span class="glyphicon glyphicon-plus"></span>
			Agregar Artista
		</button>
	</div>
</div>
<br>
<div class="row">
	<div class="col-xs-12 col-md-12 table-responsive">
		<table class='table table-striped table-bordered' id='table_artistas_formadores_evento'>
			<thead><tr>
				<th>Identificación</th>
				<th>Nombre</th>
				<th>Opciones</th>
			</tr></thead>
			<tbody></tbody>
		</table>
	</div>
</div>