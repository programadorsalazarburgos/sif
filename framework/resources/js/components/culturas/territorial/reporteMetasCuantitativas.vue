<template>
	<div class="row">
	<div class="col-lg-12 col-md-12 text-center">
		
	</div>
	<!-- /.col-md-12 -->
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header text-muted">
				<h2 class="m-0">Reporte de Metas Cuantitativas</h2>
				<h5>Formulario para reporte de metas en la plataforma Pandora y para consulta interna.</h5>
			</div>
			<div>
				<ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="pills-formulario-tab" data-toggle="pill" href="#pills-formulario" role="tab" aria-controls="pills-formulario" aria-selected="true">Formulario</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="pills-consultar-tab" data-toggle="pill" @click="getReportesByUser()" href="#pills-consultar" role="tab" aria-controls="pills-consultar" aria-selected="false">Consultar</a>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-formulario" role="tabpanel" aria-labelledby="pills-formulario-tab">
	  <div class="accordion" id="accordionExample">
		  <div class="d-flex p-2 bg-secondary text-dark justify-content-between" v-if="bandera_crear == true">
			  <span class="float-left text-white"><h5>NUEVO REPORTE</h5></span>
			  <button class="btn btn-default btn-sm float-right align-middle" @click="cancelar()">LIMPIAR</button>
			</div>
		  <div class="d-flex p-2 bg-warning text-dark justify-content-between" v-if="bandera_editar == true">
			  <span class="float-left"><h5>EDITAR REPORTE</h5></span>
			  <button class="btn btn-default btn-sm float-right align-middle" @click="cancelar()">CANCELAR</button>
			</div>
			<div class="d-flex p-2 bg-success text-dark justify-content-between" v-if="bandera_ver == true">
			  <span class="float-left"><h5>VER REPORTE</h5></span>
			  <button class="btn btn-default btn-sm float-right align-middle" @click="cancelar()">CANCELAR</button>
			</div>
			<div class="d-flex p-2 bg-warning text-dark justify-content-between" v-if="bandera_revisar == true">
			  <span class="float-left"><h5>REVISAR REPORTE</h5></span>
			  <button class="btn btn-default btn-sm float-right align-middle" @click="cancelar()">CANCELAR</button>
			</div>
  <div class="card">
	<div class="card-header text-white bg-info" id="headingOne">
	  <h2 class="mb-0">
		<button class="btn btn-link btn-block text-white text-left" type="button" aria-expanded="true">
		  SECCIÓN 1 DE 4 - DATOS GENERALES
		</button>
	  </h2>
	</div>

	<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
	  <div class="card-body">
		  <form v-on:submit.prevent="checkFormSeccionUno">
		<div class="row">
				<div class="card-body text-center col-lg-6">
						<div class="form-group row justify-content-center">
							<label for="SL_MES" class="col-sm-4 col-form-label text-right">MES</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_MES" @input="limpiarErrores" :options="options_mes" label="text" track-by="value" id="SL_MES" name="SL_MES" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_MES') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_MES"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_MES') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_MES')" data-id-padre="SL_MES"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_COMPONENTE_META" class="col-sm-4 col-form-label text-right">COMPONENTE META</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_COMPONENTE_META" @input="limpiarErrores" :options="options_componente_meta" label="text" track-by="value" id="SL_COMPONENTE_META" name="SL_COMPONENTE_META" required :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_COMPONENTE_META') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_COMPONENTE_META"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_COMPONENTE_META') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_COMPONENTE_META')" data-id-padre="SL_COMPONENTE_META"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_ACCION_ESTRATEGICA" class="col-sm-4 col-form-label text-right">ACCIÓN ESTRATÉGICA</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_ACCION_ESTRATEGICA" @input="limpiarErrores" :options="options_accion_estrategica" label="text" track-by="value" id="SL_ACCION_ESTRATEGICA" name="SL_ACCION_ESTRATEGICA" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_ACCION_ESTRATEGICA') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_ACCION_ESTRATEGICA"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_ACCION_ESTRATEGICA') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_ACCION_ESTRATEGICA')" data-id-padre="SL_ACCION_ESTRATEGICA"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_ACTIVIDAD_COMPARTIDA" class="col-sm-4 col-form-label text-right">¿ACTIVIDAD COMPARTIDA?</label>
							<div class="col-sm-6">
							  <multiselect @input="bloquearDetalleActividadCompartida()" v-model="formulario.SL_ACTIVIDAD_COMPARTIDA" :options="options_si_no" label="text" track-by="value" id="SL_ACTIVIDAD_COMPARTIDA" name="SL_ACTIVIDAD_COMPARTIDA" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_ACTIVIDAD_COMPARTIDA') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_ACTIVIDAD_COMPARTIDA"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_ACTIVIDAD_COMPARTIDA') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_ACTIVIDAD_COMPARTIDA')" data-id-padre="SL_ACTIVIDAD_COMPARTIDA"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_DETALLE_ACTIVIDAD_COMPARTIDA" class="col-sm-4 col-form-label text-right">INDIQUE CUAL</label>
							<div class="col-sm-6">
							  <multiselect multiple v-model="formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA" @input="limpiarErrores" :disabled="formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA_DISABLED" :options="options_actividad_compartida" label="text" track-by="value" id="SL_DETALLE_ACTIVIDAD_COMPARTIDA" name="SL_DETALLE_ACTIVIDAD_COMPARTIDA"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_DETALLE_ACTIVIDAD_COMPARTIDA') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_DETALLE_ACTIVIDAD_COMPARTIDA"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_DETALLE_ACTIVIDAD_COMPARTIDA') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_DETALLE_ACTIVIDAD_COMPARTIDA')" data-id-padre="SL_DETALLE_ACTIVIDAD_COMPARTIDA"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_NOMBRE_ACTIVIDAD" class="col-sm-4 col-form-label text-right">NOMBRE ACTIVIDAD</label>
							<div class="col-sm-6">
								<input type="text" @input="formulario.TX_NOMBRE_ACTIVIDAD = $event.target.value.toUpperCase()" style="text-transform: uppercase" class="form-control" id="TX_NOMBRE_ACTIVIDAD" v-model="formulario.TX_NOMBRE_ACTIVIDAD" :disabled="disable_campos" maxlength="500">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_NOMBRE_ACTIVIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_NOMBRE_ACTIVIDAD"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_NOMBRE_ACTIVIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_NOMBRE_ACTIVIDAD')" data-id-padre="TX_NOMBRE_ACTIVIDAD"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_DESCRIPCION_ACTIVIDAD" class="col-sm-4 col-form-label text-right">DESCRIPCIÓN ACTIVIDAD</label>
							<div class="col-sm-6">
								<textarea type="text" rows="3" @input="formulario.TX_DESCRIPCION_ACTIVIDAD = $event.target.value.toUpperCase()" style="text-transform: uppercase" class="form-control" id="TX_DESCRIPCION_ACTIVIDAD" v-model="formulario.TX_DESCRIPCION_ACTIVIDAD" :disabled="disable_campos" maxlength="2000"></textarea>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_DESCRIPCION_ACTIVIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_DESCRIPCION_ACTIVIDAD"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_DESCRIPCION_ACTIVIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_DESCRIPCION_ACTIVIDAD')" data-id-padre="TX_DESCRIPCION_ACTIVIDAD"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_NOMBRE_AGRUPACION" class="col-sm-4 col-form-label text-right">NOMBRE AGRUPACIÓN</label>
							<div class="col-sm-6">
								<input type="text" @input="formulario.TX_NOMBRE_AGRUPACION = $event.target.value.toUpperCase()" style="text-transform: uppercase" class="form-control" id="TX_NOMBRE_AGRUPACION" v-model="formulario.TX_NOMBRE_AGRUPACION" :disabled="disable_campos" maxlength="500">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_NOMBRE_AGRUPACION') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_NOMBRE_AGRUPACION"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_NOMBRE_AGRUPACION') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_NOMBRE_AGRUPACION')" data-id-padre="TX_NOMBRE_AGRUPACION"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_AREA_ARTISTICA" class="col-sm-4 col-form-label text-right">ÁREA ARTÍSTICA</label>
							<div class="col-sm-6">
							  <multiselect multiple v-model="formulario.SL_AREA_ARTISTICA" @input="limpiarErrores" :options="options_area_artistica" label="text" track-by="value" id="SL_AREA_ARTISTICA" name="SL_AREA_ARTISTICA" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_AREA_ARTISTICA') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_AREA_ARTISTICA"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_AREA_ARTISTICA') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_AREA_ARTISTICA')" data-id-padre="SL_AREA_ARTISTICA"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
				</div>
				<div class="card-body text-center col-lg-6">
						<div class="form-group row justify-content-center">
							<label for="SL_MODALIDAD" class="col-sm-4 col-form-label text-right">MODALIDAD</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_MODALIDAD" @input="limpiarErrores" :options="options_modalidad" label="text" track-by="value" id="SL_MODALIDAD" name="SL_MODALIDAD" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_MODALIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_MODALIDAD"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_MODALIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_MODALIDAD')" data-id-padre="SL_MODALIDAD"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_DIMENSION_PROCESO" class="col-sm-4 col-form-label text-right">DIMENSIÓN/PROCESO</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_DIMENSION_PROCESO" @input="limpiarErrores" :options="options_dimension_proceso" label="text" track-by="value" id="SL_DIMENSION_PROCESO" name="SL_DIMENSION_PROCESO" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_DIMENSION_PROCESO') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_DIMENSION_PROCESO"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_DIMENSION_PROCESO') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_DIMENSION_PROCESO')" data-id-padre="SL_DIMENSION_PROCESO"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_TIPOLOGIA_ACTIVIDAD" class="col-sm-4 col-form-label text-right">TIPOLOGÍA DE ACTIVIDAD</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_TIPOLOGIA_ACTIVIDAD" @input="limpiarErrores" :options="options_tipologia_actividad" label="text" track-by="value" id="SL_TIPOLOGIA_ACTIVIDAD" name="SL_TIPOLOGIA_ACTIVIDAD" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_TIPOLOGIA_ACTIVIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_TIPOLOGIA_ACTIVIDAD"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_TIPOLOGIA_ACTIVIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_TIPOLOGIA_ACTIVIDAD')" data-id-padre="SL_TIPOLOGIA_ACTIVIDAD"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_ENFOQUE_POBLACIONAL" class="col-sm-4 col-form-label text-right">ENFOQUE POBLACIONAL</label>
							<div class="col-sm-6">
							  <multiselect multiple v-model="formulario.SL_ENFOQUE_POBLACIONAL" @input="limpiarErrores" :options="options_enfoque_poblacional" label="text" track-by="value" id="SL_ENFOQUE_POBLACIONAL" name="SL_ENFOQUE_POBLACIONAL" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_ENFOQUE_POBLACIONAL') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_ENFOQUE_POBLACIONAL"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_ENFOQUE_POBLACIONAL') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_ENFOQUE_POBLACIONAL')" data-id-padre="SL_ENFOQUE_POBLACIONAL"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_NUMERO_ACTIVIDADES" class="col-sm-4 col-form-label text-right">NÚMERO DE ACTIVIDADES</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="TX_NUMERO_ACTIVIDADES" v-model="formulario.TX_NUMERO_ACTIVIDADES" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_NUMERO_ACTIVIDADES') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_NUMERO_ACTIVIDADES"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_NUMERO_ACTIVIDADES') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_NUMERO_ACTIVIDADES')" data-id-padre="TX_NUMERO_ACTIVIDADES"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_FECHA_INICIO" class="col-sm-4 col-form-label text-right">FECHA DE INICIO</label>
							<div class="col-sm-6">
								<input type="date" class="form-control" id="TX_FECHA_INICIO" v-model="formulario.TX_FECHA_INICIO" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_FECHA_INICIO') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_FECHA_INICIO"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_FECHA_INICIO') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_FECHA_INICIO')" data-id-padre="TX_FECHA_INICIO"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_FECHA_FIN" class="col-sm-4 col-form-label text-right">FECHA DE FIN</label>
							<div class="col-sm-6">
								<input type="date" class="form-control" id="TX_FECHA_FIN" v-model="formulario.TX_FECHA_FIN" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_FECHA_FIN') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_FECHA_FIN"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_FECHA_FIN') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_FECHA_FIN')" data-id-padre="TX_FECHA_FIN"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_IMPACTO_TERRITORIAL" class="col-sm-4 col-form-label text-right">IMPACTO TERRITORIAL</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_IMPACTO_TERRITORIAL" @input="limpiarErrores" :options="options_impacto_territorial" label="text" track-by="value" id="SL_IMPACTO_TERRITORIAL" name="SL_IMPACTO_TERRITORIAL" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_IMPACTO_TERRITORIAL') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_IMPACTO_TERRITORIAL"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_IMPACTO_TERRITORIAL') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_IMPACTO_TERRITORIAL')" data-id-padre="SL_IMPACTO_TERRITORIAL"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_ORIGEN_INICIATIVA" class="col-sm-4 col-form-label text-right">ORIGEN INICIATIVA</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_ORIGEN_INICIATIVA" @input="limpiarErrores" :options="options_origen_iniciativa" label="text" track-by="value" id="SL_ORIGEN_INICIATIVA" name="SL_ORIGEN_INICIATIVA" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_ORIGEN_INICIATIVA') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_ORIGEN_INICIATIVA"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_ORIGEN_INICIATIVA') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_ORIGEN_INICIATIVA')" data-id-padre="SL_ORIGEN_INICIATIVA"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
				</div>
				<div class="card-body text-center col-lg-12">
						<div class="form-group row justify-content-center">
							<p v-if="errors.length" style="color:red">
    							<b>Por favor corrija los siguientes campos:</b>
    							<ul>
    	  							<li v-for="(error, i) in errors" :key="i">{{ error }}</li>
	    						</ul>
  							</p>
				  		</div>
				</div>
			</div>
			<div class="row float-right">
				<button class="btn btn-primary" type="submit">Siguiente</button>
			</div>
			</form>
	  </div>
	</div>
  </div>
  <div class="card">
	<div class="card-header text-white bg-info" id="headingTwo">
	  <h2 class="mb-0">
		<button class="btn btn-link btn-block text-white text-left collapsed" type="button" aria-expanded="false">
		  SECCIÓN 2 DE 4 - LOGISTICA Y LOCALIZACIONES
		</button>
	  </h2>
	</div>
	<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
	  <form v-on:submit.prevent="checkFormSeccionDos">
	  <div class="card-body">
		<div class="row">
				<div class="card-body text-center col-lg-6">
						<div class="form-group row justify-content-center">
							<label for="TX_LUGAR_ESCENARIO" class="col-sm-4 col-form-label text-right">LUGAR O ESCENARIO</label>
							<div class="col-sm-6">
								<input type="text" @input="formulario.TX_LUGAR_ESCENARIO = $event.target.value.toUpperCase()" style="text-transform: uppercase" class="form-control" id="TX_LUGAR_ESCENARIO" v-model="formulario.TX_LUGAR_ESCENARIO" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_LUGAR_ESCENARIO') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_LUGAR_ESCENARIO"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_LUGAR_ESCENARIO') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_LUGAR_ESCENARIO')" data-id-padre="TX_LUGAR_ESCENARIO"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_CAPACIDAD_AFORO" class="col-sm-4 col-form-label text-right">CAPACIDAD O AFORO</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="TX_CAPACIDAD_AFORO" v-model="formulario.TX_CAPACIDAD_AFORO" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_CAPACIDAD_AFORO') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_CAPACIDAD_AFORO"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_CAPACIDAD_AFORO') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_CAPACIDAD_AFORO')" data-id-padre="TX_CAPACIDAD_AFORO"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_ESPACIO_PUBLICO" class="col-sm-4 col-form-label text-right">¿ESPACIO PÚBLICO?</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_ESPACIO_PUBLICO" @input="limpiarErrores" :options="options_si_no" label="text" track-by="value" id="SL_ESPACIO_PUBLICO" name="SL_ESPACIO_PUBLICO" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_ESPACIO_PUBLICO') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_ESPACIO_PUBLICO"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_ESPACIO_PUBLICO') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_ESPACIO_PUBLICO')" data-id-padre="SL_ESPACIO_PUBLICO"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_LOCALIDAD" class="col-sm-4 col-form-label text-right">LOCALIDAD</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_LOCALIDAD" :options="options_localidades" @input="getBarrios()" label="text" track-by="value" id="SL_LOCALIDAD" name="SL_LOCALIDAD" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_LOCALIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_LOCALIDAD"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_LOCALIDAD') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_LOCALIDAD')" data-id-padre="SL_LOCALIDAD"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_UPZ_UPR" class="col-sm-4 col-form-label text-right">UPZ-UPR</label>
							<div class="col-sm-6">
								<input type="text" @input="formulario.TX_UPZ_UPR = $event.target.value.toUpperCase()" style="text-transform: uppercase" class="form-control" id="TX_UPZ_UPR" v-model="formulario.TX_UPZ_UPR" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_UPZ_UPR') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_UPZ_UPR"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_UPZ_UPR') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_UPZ_UPR')" data-id-padre="TX_UPZ_UPR"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_BARRIO" class="col-sm-4 col-form-label text-right">BARRIO</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_BARRIO" @input="limpiarErrores" :options="options_barrios" label="text" track-by="value" id="SL_BARRIO" name="SL_BARRIO" :disabled="formulario.SL_BARRIO_DISABLED"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_BARRIO') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_BARRIO"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_BARRIO') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_BARRIO')" data-id-padre="SL_BARRIO"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_MODALIDAD_USO_COMPARTIDO" class="col-sm-4 col-form-label text-right">MODALIDAD USO COMPARTIDO</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_MODALIDAD_USO_COMPARTIDO" @input="limpiarErrores" :options="options_modalidad_uso_compartido" label="text" track-by="value" id="SL_MODALIDAD_USO_COMPARTIDO" name="SL_MODALIDAD_USO_COMPARTIDO" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_MODALIDAD_USO_COMPARTIDO') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_MODALIDAD_USO_COMPARTIDO"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_MODALIDAD_USO_COMPARTIDO') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_MODALIDAD_USO_COMPARTIDO')" data-id-padre="SL_MODALIDAD_USO_COMPARTIDO"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_NUMERO_ARTISTAS_REMUNERADOS" class="col-sm-4 col-form-label text-right"># ARTISTAS REMUNERADOS</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="TX_NUMERO_ARTISTAS_REMUNERADOS" v-model="formulario.TX_NUMERO_ARTISTAS_REMUNERADOS" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_NUMERO_ARTISTAS_REMUNERADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_NUMERO_ARTISTAS_REMUNERADOS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_NUMERO_ARTISTAS_REMUNERADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_NUMERO_ARTISTAS_REMUNERADOS')" data-id-padre="TX_NUMERO_ARTISTAS_REMUNERADOS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
				</div>
				<div class="card-body text-center col-lg-6">
						<div class="form-group row justify-content-center">
							<label for="TX_NUMERO_ARTISTAS_NO_REMUNERADOS" class="col-sm-4 col-form-label text-right"># ARTISTAS NO REMUNERADOS</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="TX_NUMERO_ARTISTAS_NO_REMUNERADOS" v-model="formulario.TX_NUMERO_ARTISTAS_NO_REMUNERADOS" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_NUMERO_ARTISTAS_NO_REMUNERADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_NUMERO_ARTISTAS_NO_REMUNERADOS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_NUMERO_ARTISTAS_NO_REMUNERADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_NUMERO_ARTISTAS_NO_REMUNERADOS')" data-id-padre="TX_NUMERO_ARTISTAS_NO_REMUNERADOS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_NUMERO_PERSONAS_INSCRITAS" class="col-sm-4 col-form-label text-right"># PERSONAS INSCRITAS</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="TX_NUMERO_PERSONAS_INSCRITAS" v-model="formulario.TX_NUMERO_PERSONAS_INSCRITAS" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_NUMERO_PERSONAS_INSCRITAS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_NUMERO_PERSONAS_INSCRITAS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_NUMERO_PERSONAS_INSCRITAS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_NUMERO_PERSONAS_INSCRITAS')" data-id-padre="TX_NUMERO_PERSONAS_INSCRITAS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_MUJERES_BENEFICIADAS" class="col-sm-4 col-form-label text-right"># MUJERES BENEFICIADAS</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="TX_MUJERES_BENEFICIADAS" v-model="formulario.TX_MUJERES_BENEFICIADAS" @input="calcularTotalBeneficiados" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_MUJERES_BENEFICIADAS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_MUJERES_BENEFICIADAS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_MUJERES_BENEFICIADAS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_MUJERES_BENEFICIADAS')" data-id-padre="TX_MUJERES_BENEFICIADAS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_HOMBRES_BENEFICIADOS" class="col-sm-4 col-form-label text-right"># HOMBRES BENEFICIADOS</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="TX_HOMBRES_BENEFICIADOS" v-model="formulario.TX_HOMBRES_BENEFICIADOS" @input="calcularTotalBeneficiados" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_HOMBRES_BENEFICIADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_HOMBRES_BENEFICIADOS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_HOMBRES_BENEFICIADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_HOMBRES_BENEFICIADOS')" data-id-padre="TX_HOMBRES_BENEFICIADOS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_OTROS_BENEFICIADOS" class="col-sm-4 col-form-label text-right"># OTROS BENEFICIADOS</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="TX_OTROS_BENEFICIADOS" v-model="formulario.TX_OTROS_BENEFICIADOS" @input="calcularTotalBeneficiados" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_OTROS_BENEFICIADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_OTROS_BENEFICIADOS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_OTROS_BENEFICIADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_OTROS_BENEFICIADOS')" data-id-padre="TX_OTROS_BENEFICIADOS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_TOTAL_BENEFICIADOS" class="col-sm-4 col-form-label text-right">TOTAL BENEFICIADOS</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="TX_TOTAL_BENEFICIADOS" v-model="formulario.TX_TOTAL_BENEFICIADOS" readonly>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_TOTAL_BENEFICIADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_TOTAL_BENEFICIADOS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_TOTAL_BENEFICIADOS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_TOTAL_BENEFICIADOS')" data-id-padre="TX_TOTAL_BENEFICIADOS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_EVENTO_GRATUITO" class="col-sm-4 col-form-label text-right">¿EVENTO GRATUITO?</label>
							<div class="col-sm-6">
							  <multiselect v-model="formulario.SL_EVENTO_GRATUITO" @input="limpiarErrores" :options="options_si_no" label="text" track-by="value" id="SL_EVENTO_GRATUITO" name="SL_EVENTO_GRATUITO" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_EVENTO_GRATUITO') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_EVENTO_GRATUITO"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_EVENTO_GRATUITO') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_EVENTO_GRATUITO')" data-id-padre="SL_EVENTO_GRATUITO"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
				</div>
				<div class="card-body text-center col-lg-12">
						<div class="form-group row justify-content-center">
							<p v-if="errors.length" style="color:red">
    							<b>Por favor corrija los siguientes campos:</b>
    							<ul>
    	  							<li v-for="(error, i) in errors" :key="i">{{ error }}</li>
	    						</ul>
  							</p>
				  		</div>
				</div>
			</div>
			<div class="row float-right">
					<a class="btn btn-warning" @click="limpiarErrores" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne">Anterior</a>&nbsp
					<button class="btn btn-primary" type="submit">Siguiente</button>
			</div>
	  </div>
	  </form>
	</div>
	</div>
  <div class="card">
	<div class="card-header text-white bg-info" id="headingThree">
	  <h2 class="mb-0">
		<button class="btn btn-link btn-block text-white text-left collapsed" type="button" aria-expanded="false">
		  SECCIÓN 3 DE 4 - GRUPOS Y SECTORES POBLACIONALES
		</button>
	  </h2>
	</div>
	<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
	  <form v-on:submit.prevent="checkFormSeccionTres">
	  <div class="card-body">
		<div class="row">
				<div class="card-body text-center col-lg-12">
						<div class="row form-group justify-content-center" id="search_result">
						<div class="col-sm-4">
							<table id="tabla_poblacion" name="tabla_poblacion" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
								<thead>
									<tr>
										<th>TIPO DE POBLACIÓN</th>
										<th>CANTIDAD</th>
									</tr>
								</thead>
								<tbody>
								  <tr class="col-sm-12" v-for="(grupo,i) in formulario.grupos_poblacionales" :key="i">
									<td class="col-sm-10"><label>{{grupo.text}}</label></td>
									<td class="col-sm-2"><input type="number" class="form-control" v-bind:id="'TX_grupo_poblacional_'+grupo.value" v-model="grupo.cantidad" :disabled="disable_campos"></td>
								  </tr>
								  <tr class="col-sm-12">
									<td colspan="2">
										<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('grupos_poblacionales') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="grupos_poblacionales"><i class="fas fa-comment-alt"></i></button>
										<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('grupos_poblacionales') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('grupos_poblacionales')" data-id-padre="grupos_poblacionales"><i class="fas fa-comment-dots"></i></button>
									</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="form-group row justify-content-center">
						<label for="TX_INSTRUMENTO_RECOLECTOR" class="col-sm-3 col-form-label text-right">INSTRUMENTO RECOLECTOR DE INFORMACIÓN</label>
						<div class="col-sm-3">
							<input type="text" @input="formulario.TX_INSTRUMENTO_RECOLECTOR = $event.target.value.toUpperCase()" style="text-transform: uppercase" class="form-control" id="TX_INSTRUMENTO_RECOLECTOR" v-model="formulario.TX_INSTRUMENTO_RECOLECTOR" :disabled="disable_campos">
						</div>
						<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_INSTRUMENTO_RECOLECTOR') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_INSTRUMENTO_RECOLECTOR"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_INSTRUMENTO_RECOLECTOR') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_INSTRUMENTO_RECOLECTOR')" data-id-padre="TX_INSTRUMENTO_RECOLECTOR"><i class="fas fa-comment-dots"></i></button>
						</div>
					</div>
					<div class="form-group row justify-content-center" v-if="bandera_crear == true || bandera_editar == true">
						<label for="anexos" class="col-sm-3 col-form-label text-right">ANEXOS</label>
						<div class="col-sm-3">
							<div class="custom-file">
                            	<input type="file" class="custom-file-input" id="anexos" ref="anexos" v-on:change="cargaDI()" :disabled="disable_campos">
                                <label class="custom-file-label" for="anexos">{{ this.anexos ? anexos.name : 'Seleccione un archivo' }}</label>
                            </div>
						</div>
						<div class="col-sm-1">
						</div>
					</div>
					<div class="form-group row justify-content-center" v-if="bandera_editar == true">
						<div class="offset-md-3">
  							Recuerde que si anexa un nuevo archivo, se reemplazará el existente.
						</div>
						<div class="col-sm-1">
						</div>
					</div>
					<div class="form-group row justify-content-center" v-if="this.anexos_editar != null">
						<label for="anexos_editar" class="col-sm-3 col-form-label text-right">ANEXOS SUBIDOS</label>
						<div class="col-sm-3">
                        	<a class="btn btn-info" v-bind:href="this.anexos_editar" download>{{ this.anexos_editar.split("/")[8] }}</a>
						</div>
						<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('anexos') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="anexos"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('anexos') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('anexos')" data-id-padre="anexos"><i class="fas fa-comment-dots"></i></button>
						</div>
					</div>
					<div class="form-group row justify-content-center">
						<label for="TXA_OBSERVACIONES" class="col-sm-3 col-form-label text-right">OBSERVACIONES</label>
						<div class="col-sm-3">
							<textarea type="text" @input="formulario.TXA_OBSERVACIONES = $event.target.value.toUpperCase()" style="text-transform: uppercase" rows="3" class="form-control" id="TXA_OBSERVACIONES" v-model="formulario.TXA_OBSERVACIONES" :disabled="disable_campos"></textarea>
						</div>
						<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TXA_OBSERVACIONES') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TXA_OBSERVACIONES"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TXA_OBSERVACIONES') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TXA_OBSERVACIONES')" data-id-padre="TXA_OBSERVACIONES"><i class="fas fa-comment-dots"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body text-center col-lg-12">
						<div class="form-group row justify-content-center">
							<p v-if="errors.length" style="color:red">
    							<b>Por favor corrija los siguientes campos:</b>
    							<ul>
    	  							<li v-for="(error, i) in errors" :key="i">{{ error }}</li>
	    						</ul>
  							</p>
				  		</div>
				</div>
			<div class="row float-right">
				<a href="#" class="btn btn-warning" @click="limpiarErrores" data-toggle="collapse" data-target="#collapseTwo" aria-controls="collapseTwo">Anterior</a>&nbsp
				<button class="btn btn-primary">Siguiente</button>
			</div>
	  </div>
	  </form>
	</div>
  </div>
  <div class="card">
	<div class="card-header text-white bg-info" id="headingFour">
	  <h2 class="mb-0">
		<button class="btn btn-link btn-block text-white text-left collapsed" type="button" aria-expanded="false">
		  SECCIÓN 4 DE 4 - ARTICULACIONES Y GESTIÓN
		</button>
	  </h2>
	</div>
	<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
	  <form v-on:submit.prevent="checkFormSeccionCuatro">
	  <div class="card-body">
		<div class="row">
				<div class="card-body text-center col-lg-12">
						<div class="form-group row justify-content-center">
							<label for="SL_ACTIVIDAD_ARTICULADA_SDIS" class="col-sm-3 col-form-label text-right">¿ACTIVIDAD ARTICULADA CON SECRETARÍA DISTRITAL DE INTEGRACIÓN?</label>
							<div class="col-sm-3">
							  <multiselect v-model="formulario.SL_ACTIVIDAD_ARTICULADA_SDIS" @input="bloquearCamposProyectoSDIS()" :options="options_si_no" label="text" track-by="value" id="SL_ACTIVIDAD_ARTICULADA_SDIS" name="SL_ACTIVIDAD_ARTICULADA_SDIS" :disabled="disable_campos"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_ACTIVIDAD_ARTICULADA_SDIS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_ACTIVIDAD_ARTICULADA_SDIS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_ACTIVIDAD_ARTICULADA_SDIS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_ACTIVIDAD_ARTICULADA_SDIS')" data-id-padre="SL_ACTIVIDAD_ARTICULADA_SDIS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="SL_PROYECTO_SDIS" class="col-sm-3 col-form-label text-right">PROYECTOS PARTICIPANTES DE SECRETARÍA DISTRITAL DE INTEGRACIÓN SOCIAL</label>
							<div class="col-sm-3">
							  <multiselect v-model="formulario.SL_PROYECTO_SDIS" @input="limpiarErrores" :options="options_proyectos_sdis" :disabled="formulario.SL_PROYECTO_SDIS_DISABLED" label="text" track-by="value" id="SL_PROYECTO_SDIS" name="SL_PROYECTO_SDIS"></multiselect>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('SL_PROYECTO_SDIS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="SL_PROYECTO_SDIS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('SL_PROYECTO_SDIS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('SL_PROYECTO_SDIS')" data-id-padre="SL_PROYECTO_SDIS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_TOTAL_BENEFICIARIOS_SDIS" class="col-sm-3 col-form-label text-right">TOTAL DE BENEFICIARIOS SECRETARÍA DISTRITAL DE INTEGRACIÓN SOCIAL</label>
							<div class="col-sm-3">
								<input type="number" class="form-control" id="TX_TOTAL_BENEFICIARIOS_SDIS" v-model="formulario.TX_TOTAL_BENEFICIARIOS_SDIS" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_TOTAL_BENEFICIARIOS_SDIS') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_TOTAL_BENEFICIARIOS_SDIS"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_TOTAL_BENEFICIARIOS_SDIS') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_TOTAL_BENEFICIARIOS_SDIS')" data-id-padre="TX_TOTAL_BENEFICIARIOS_SDIS"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<label for="TX_OTRAS_ENTIDADES_PARTICIPANTES" class="col-sm-3 col-form-label text-right">OTRAS ENTIDADES PARTICIPANTES</label>
							<div class="col-sm-3">
								<input type="text" @input="formulario.TX_OTRAS_ENTIDADES_PARTICIPANTES = $event.target.value.toUpperCase()" style="text-transform: uppercase" class="form-control" id="TX_OTRAS_ENTIDADES_PARTICIPANTES" v-model="formulario.TX_OTRAS_ENTIDADES_PARTICIPANTES" :disabled="disable_campos">
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn comentar" v-bind:class="observaciones.hasOwnProperty('TX_OTRAS_ENTIDADES_PARTICIPANTES') ? 'btn-warning':'btn-secondary'" v-if="bandera_revisar == true" data-id-padre="TX_OTRAS_ENTIDADES_PARTICIPANTES"><i class="fas fa-comment-alt"></i></button>
								<button type="button" class="btn ver-comentario" v-bind:class="observaciones.hasOwnProperty('TX_OTRAS_ENTIDADES_PARTICIPANTES') ? 'btn-warning':'btn-secondary'" v-if="bandera_editar == true && observaciones.hasOwnProperty('TX_OTRAS_ENTIDADES_PARTICIPANTES')" data-id-padre="TX_OTRAS_ENTIDADES_PARTICIPANTES"><i class="fas fa-comment-dots"></i></button>
							</div>
						</div>
				</div>
			</div>
			<div class="card-body text-center col-lg-12">
						<div class="form-group row justify-content-center">
							<p v-if="errors.length" style="color:red">
    							<b>Por favor corrija los siguientes campos:</b>
    							<ul>
    	  							<li v-for="(error, i) in errors" :key="i">{{ error }}</li>
	    						</ul>
  							</p>
				  		</div>
			</div>
			<div class="row float-right">
					<a href="#" class="btn btn-warning" @click="limpiarErrores" data-toggle="collapse" data-target="#collapseThree" aria-controls="collapseThree">Anterior</a>&nbsp
					<button class="btn btn-primary" v-if="bandera_crear == true">Guardar Reporte</button>
					<button class="btn btn-success" v-if="bandera_editar == true">Actualizar Reporte</button>
			</div>
	  </div>
	  </form>
	  <div class="row float-right p-3">
	  <button class="btn btn-danger" v-if="bandera_revisar == true" v-on:click="saveRevisionReporte('rechazar')">Rechazar</button>&nbsp
		<button class="btn btn-info" v-if="bandera_revisar == true" v-on:click="saveRevisionReporte('aprobar')">Aprobar</button>
		</div>
	  </div>
	</div>
  </div>
  </div>
  <div class="tab-pane fade" id="pills-consultar" role="tabpanel" aria-labelledby="pills-consultar-tab">
	  <div class="row" v-if="rol_persona == 42">
		<div class="col-sm-12">
			<div class="form-group row pl-3">
					<div class="col-sm-3">
						<multiselect placeholder="COMPONENTE META" v-model="SL_FILTRO_COMPONENTE_META" @input="limpiarErrores" :options="options_componente_meta" label="text" track-by="value" id="SL_FILTRO_COMPONENTE_META" name="SL_FILTRO_COMPONENTE_META"></multiselect>
					</div>
					<div class="col-sm-3">
						<multiselect placeholder="MES" v-model="SL_FILTRO_MES" @input="limpiarErrores" :options="options_mes" label="text" track-by="value" id="SL_FILTRO_MES" name="SL_FILTRO_MES"></multiselect>
					</div>
					<div class="col-sm-1">
					<button @click="getReportesByFilters()" class="btn btn-info">Consultar</button>
				</div>
			</div>
	  	</div>
	  </div>
	  <div class="row form-group justify-content-center" id="search_result">
						<div class="col-sm-12">
                            <table id="tabla_reporte_metas_cuantitativas" name="tabla_reporte_metas_cuantitativas" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Componente Meta</th>
										<th>Nombre Actividad</th>
                                        <th>Descripción Actividad</th>
										<th>Mes</th>
                                        <th>Fecha de Inicio</th>
                                        <th>Fecha de Fin</th>
										<th>Fecha Registro</th>
                                        <th>Usuario</th>
										<th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
  </div>
</div>
</div>
</div>
		</div>
	</div>
	
	<!-- /.col-md-6 -->
<!-- /.row -->

</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
	import Multiselect from "vue-multiselect";
	import DataTables from "datatables.net";
	import Sweetalert2 from 'sweetalert2';
	require( 'jszip' );
	require( 'datatables.net-dt' );
	require( 'datatables.net-buttons-dt' );
	require( 'datatables.net-buttons/js/buttons.html5.js' );
	require( 'datatables.net-responsive-dt' );
	
	export default {
		components: { Multiselect },
		data () {
			return {
				formulario: {'SL_AREA_ARTISTICA':[],'SL_ENFOQUE_POBLACIONAL':[], 'SL_DETALLE_ACTIVIDAD_COMPARTIDA':[], 'SL_ACTIVIDAD_COMPARTIDA':{text:'SI', value:true}, 'SL_BARRIO':null, 'SL_PROYECTO_SDIS':{text:'', value:''}, 'TX_OTRAS_ENTIDADES_PARTICIPANTES':null},
				observaciones: {},
				config_tabla:"",
				options: [],
				options_mes: [],
				options_componente_meta: [],
				options_accion_estrategica: [],
				options_si_no: [
					{'text':'SI', 'value':true}, {'text':'NO', 'value':false},
				],
				options_actividad_compartida: [],
				options_area_artistica:[],
				options_modalidad: [],
				options_dimension_proceso: [],
				options_tipologia_actividad: [],
				options_enfoque_poblacional: [],
				options_impacto_territorial: [],
				options_origen_iniciativa: [],
				options_localidades: [],
				options_barrios: [],
				options_modalidad_uso_compartido:[],
				tabla_poblacion:"",
				options_proyectos_sdis:[],
				errors: [],
				bandera_actividad_compartida: false,
				id_persona : null,
				rol_persona : null,
				reportes:null,
				anexos: undefined,
				tabla_reportes: "",
				bandera_crear: true,
				bandera_editar: false,
				bandera_revisar: false,
				anexos_editar:null,
				id_reporte:null,
				bandera_ver:false,
				disable_campos : false,
				SL_FILTRO_COMPONENTE_META:null,
				SL_FILTRO_MES:null
			}
		},
		mounted() {
		  this.getIdPersona();
		  this.getRolPersona();
		  var listas = [
			{'i': 8, 'modelo':"options_mes"},
			{'i': 71, 'modelo':"options_componente_meta"},
			{'i': 72, 'modelo':"options_accion_estrategica"},
			{'i': 73, 'modelo':"options_actividad_compartida"},
			{'i': 6, 'modelo':"options_area_artistica"},
			{'i': 61, 'modelo':"options_modalidad"},
			{'i': 74, 'modelo':"options_dimension_proceso"},
			{'i': 75, 'modelo':"options_tipologia_actividad"},
			{'i': 79, 'modelo':"options_enfoque_poblacional"},
			{'i': 80, 'modelo':"options_impacto_territorial"},
			{'i': 81, 'modelo':"options_origen_iniciativa"},
			{'i': 19, 'modelo':"options_localidades"},
			{'i': 82, 'modelo':"options_modalidad_uso_compartido"},
			{'i': 84, 'modelo':"options_proyectos_sdis"},
		  ];
		  listas.forEach((value) => {
			  this.getParametroDetalle(value.modelo, value.i);
		  });

		  this.getGruposPoblacionalesCulturas();

		  this.config_tabla = {
				autoWidth: false,
				responsive: true,
				pageLength: 10,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por página",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando página _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtrado de un total de _MAX_ registros)",
					"search": "Filtrar",
					"paginate": {
						"first": "Primera",
						"last": "Última",
						"next": "Siguiente",
						"previous": "Anterior"
					},
				},
				"order": [[ 6, "desc" ]]
			};

			this.tabla_reportes = $("#tabla_reporte_metas_cuantitativas").DataTable(this.config_tabla);
			$('.collapse').collapse({
  				toggle: false
			})

			// Evento del botón Editar
            const vm = this;
            $(".content").on("click", ".editar", function(){
                var id_reporte = $(this).attr("data-id-reporte");
                vm.cargarInfoReporte(id_reporte);
				vm.bandera_editar = true;
				vm.bandera_crear = false;
				vm.disable_campos = false;
				vm.bandera_ver = false;
				vm.bandera_revisar = false;
				vm.formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA_DISABLED = false;
				vm.formulario.SL_PROYECTO_SDIS_DISABLED = false;
				vm.formulario.SL_BARRIO_DISABLED = false;
            });
			$(".content").on("click", ".ver", function(){
                var id_reporte = $(this).attr("data-id-reporte");
                vm.cargarInfoReporte(id_reporte);
				vm.disable_campos = true;
				vm.bandera_ver = true;
				vm.bandera_editar = false;
				vm.bandera_crear = false;
				vm.bandera_revisar = false;
				vm.formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA_DISABLED = true;
				vm.formulario.SL_PROYECTO_SDIS_DISABLED = true;
				vm.formulario.SL_BARRIO_DISABLED = true;
            });

			$(".content").on("click", ".revisar", function(){
                var id_reporte = $(this).attr("data-id-reporte");
                vm.cargarInfoReporte(id_reporte);
				vm.disable_campos = true;
				vm.bandera_revisar = true;
				vm.bandera_editar = false;
				vm.bandera_crear = false;
				vm.bandera_ver = false;
				vm.formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA_DISABLED = true;
				vm.formulario.SL_PROYECTO_SDIS_DISABLED = true;
				vm.formulario.SL_BARRIO_DISABLED = true;
            });

			$(".content").on("click", ".comentar", function(){
				var elemento = this;
				var id=$(elemento).data("id-padre");
                Swal.fire({
  					title: 'Ingrese la observación',
  					input: 'textarea',
					inputValue: vm.observaciones[id] ? vm.observaciones[id] : '',
  					inputAttributes: {
    					autocapitalize: 'off'
  					},
  					showCancelButton: true,
  					confirmButtonText: 'Guardar',
  					showLoaderOnConfirm: true
					}).then((result) => {
  					if (result.isConfirmed) {
						if(result.value != ''){
							vm.observaciones[id] = result.value;
							$(elemento).removeClass('btn-secondary');
							$(elemento).addClass('btn-warning');
						}
						else{
							delete vm.observaciones[id];
							$(elemento).removeClass('btn-warning');
							$(elemento).addClass('btn-secondary');
						}
					}
				})
            });

			$(".content").on("click", ".ver-comentario", function(){
				var elemento = this;
				var id=$(elemento).data("id-padre");
                Swal.fire({
  					title: 'Observación',
					html: vm.observaciones[id],
  					confirmButtonText: 'Cerrar',
					}).then((result) => {
					})
            	});
				Swal.disableInput()
		},
		methods: {
		  getParametroDetalle(variable,parametro){
				axios
					.post("/sif/framework/options/getParametroDetalle", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					FK_Id_Parametro: parametro,
					programa:"culturas"
				})
				.then(response => {
					this[variable] = response.data;
				})
				.catch(error => {
					console.log(error);
				});
			},
			getBarrios(){
				this.limpiarErrores();
				axios
					.post("/sif/framework/options/getBarrios", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					localidad:this.formulario.SL_LOCALIDAD.value
				})
				.then(response => {
					if(response.data.length > 0){
						response.data.push({text:'NO APLICA',value:0});
						this.options_barrios = response.data;
						this.formulario.SL_BARRIO = null;
						if(this.disable_campos == false){
							this.formulario.SL_BARRIO_DISABLED = false;
						}
					}else{
						this.formulario.SL_BARRIO = {text:'NO APLICA', value:0};
						this.formulario.SL_BARRIO_DISABLED = true;
					}
				})
				.catch(error => {
					console.log(error);
				});
			},
			getGruposPoblacionalesCulturas(){
				axios
					.post("/sif/framework/options/getGruposPoblacionalesCulturas", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					FK_Parametro:83
				})
				.then(response => {
					this.formulario.grupos_poblacionales = response.data;
				})
				.catch(error => {
					console.log(error);
				});
			},
			getReportesByUser(){
				axios
						.post("/sif/framework/culturas/reporteMetasCuantitativas/getAllReportesByUser", {
							"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
							id_usuario : this.id_persona
						})
						.then(response => {
							this.reportes = response.data;
							this.tabla_reportes.clear().draw();
							this.reportes.forEach((value, index) => {
								var opcion_estado = "";
								var url_archivo = "../../uploadedFiles/"+this.reportes[index]['url_anexos'];
								if(this.reportes[index]['in_estado'] == null){ opcion_estado = "<a style='color:black' class='btn btn-default ver' data-id-reporte='"+this.reportes[index]['id']+"'>Ver</a> <span class='badge bg-warning'>Enviado</span> <a href='"+url_archivo+"' download class='btn btn-dark'><i class='fas fa-cloud-download-alt'></i></a>";}
								if(this.reportes[index]['in_estado'] == 0){ opcion_estado = "<a style='color:white' class='btn btn-info editar' data-id-reporte='"+this.reportes[index]['id']+"'><i class='fas fa-pen-alt'></i></a> <span class='badge bg-danger'>Rechazado</span> <a href='"+url_archivo+"' download class='btn btn-dark'><i class='fas fa-cloud-download-alt'></i></a>";}
								if(this.reportes[index]['in_estado'] == 1){ opcion_estado = "<a style='color:black' class='btn btn-default ver' data-id-reporte='"+this.reportes[index]['id']+"'>Ver</a> <span class='badge bg-info'>Aprobado</span> <a href='"+url_archivo+"' download class='btn btn-dark'><i class='fas fa-cloud-download-alt'></i></a>";}
                            	this.rowNode = this.tabla_reportes.row.add([
									this.reportes[index]['componente_meta'].substring(0,12),
									this.reportes[index]['tx_nombre_actividad'],
									this.reportes[index]['tx_descripcion_actividad'],
									this.reportes[index]['mes'],
									this.reportes[index]['da_fecha_inicio'],
									this.reportes[index]['da_fecha_fin'],
									this.reportes[index]['created_at'],
									this.reportes[index]['usuario'],
									opcion_estado,
                            	]).draw().node();
                        	});
						})
						.catch(error => {
							Swal.fire("Error", "No se pudo consultar los reportes, por favor inténtelo nuevamente", "error");
						});
			},
			getReportesByFilters(){
				if(this.SL_FILTRO_COMPONENTE_META == null || this.SL_FILTRO_MES == null){
					Swal.fire('','Seleccione ambos filtros','warning')
				}
				else{
					Swal.fire({
                    	title: "Consultando información",
	                    text: "Espere un poco por favor",
                    	imageUrl: "../public/images/cargando.gif",
                    	imageWidth: 140,
                    	imageHeight: 70,
                    	showConfirmButton: false,
                    	backdrop: `rgba(0,0,123,0.4)`
                	});
					axios
						.post("/sif/framework/culturas/reporteMetasCuantitativas/getReportesByFilters", {
							"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
							componente_meta : this.SL_FILTRO_COMPONENTE_META.value,
							mes : this.SL_FILTRO_MES.value,
						})
						.then(response => {
							Swal.close()
							this.reportes = response.data;
							this.tabla_reportes.clear().draw();
							this.reportes.forEach((value, index) => {
								var opcion_estado = "";
								var url_archivo = "../../uploadedFiles/"+this.reportes[index]['url_anexos'];
								if(this.reportes[index]['in_estado'] == null){ opcion_estado = "<a style='color:black' class='btn btn-warning revisar' data-id-reporte='"+this.reportes[index]['id']+"'>Revisar</a> <a href='"+url_archivo+"' download class='btn btn-dark'><i class='fas fa-cloud-download-alt'></i></a>";}
								if(this.reportes[index]['in_estado'] == 0){ opcion_estado = "<a style='color:black' class='btn btn-default ver' data-id-reporte='"+this.reportes[index]['id']+"'>Ver</a> <span class='badge bg-danger'>Rechazado</span> <a href='"+url_archivo+"' download class='btn btn-dark'><i class='fas fa-cloud-download-alt'></i></a>";}
								if(this.reportes[index]['in_estado'] == 1){ opcion_estado = "<a style='color:black' class='btn btn-default ver' data-id-reporte='"+this.reportes[index]['id']+"'>Ver</a> <span class='badge bg-info'>Aprobado</span> <a href='"+url_archivo+"' download class='btn btn-dark'><i class='fas fa-cloud-download-alt'></i></a>";}
                            	this.rowNode = this.tabla_reportes.row.add([
									this.reportes[index]['componente_meta'].substring(0,12),
									this.reportes[index]['tx_nombre_actividad'],
									this.reportes[index]['tx_descripcion_actividad'],
									this.reportes[index]['mes'],
									this.reportes[index]['da_fecha_inicio'],
									this.reportes[index]['da_fecha_fin'],
									this.reportes[index]['created_at'],
									this.reportes[index]['usuario'],
									opcion_estado,
                            	]).draw().node();
                        	});
						})
						.catch(error => {
							Swal.fire("Error", "No se pudo consultar los reportes, por favor inténtelo nuevamente", "error");
						});
				}
			},
			checkFormSeccionUno: function (e) {
		      	this.errors = [];

      			if (!this.formulario.SL_MES) {
      			  this.errors.push('El mes es obligatorio.');
      			}
				if (!this.formulario.SL_COMPONENTE_META) {
      			  this.errors.push('El componente de la meta es obligatoria.');
      			}
				if (!this.formulario.SL_ACCION_ESTRATEGICA) {
      			  this.errors.push('La acción estratégica es obligatoria.');
      			}
				if (!this.formulario.SL_ACTIVIDAD_COMPARTIDA) {
      			  this.errors.push('Debe indicar si se trata de una actividad compartida.');
      			}
				if (this.formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA.length == 0) {
      			  this.errors.push('La actividad compartida es obligatoria.');
      			}
				if (!this.formulario.TX_NOMBRE_ACTIVIDAD) {
      			  this.errors.push('El nombre de la actividad es obligatorio.');
      			}
				if (!this.formulario.TX_DESCRIPCION_ACTIVIDAD) {
      			  this.errors.push('La descripción de la actividad es obligatoria.');
      			}
				if (!this.formulario.TX_NOMBRE_AGRUPACION) {
      			  this.errors.push('El nombre de la agrupación es obligatorio.');
      			}
				if (this.formulario.SL_AREA_ARTISTICA.length == 0) {
      			  this.errors.push('La área artística es obligatoria.');
      			}
				if (!this.formulario.SL_MODALIDAD) {
      			  this.errors.push('La modalidad es obligatoria.');
      			}
				if (!this.formulario.SL_DIMENSION_PROCESO) {
      			  this.errors.push('La dimensión/proceso es obligatoria.');
      			}
				if (!this.formulario.SL_TIPOLOGIA_ACTIVIDAD) {
      			  this.errors.push('La tipología de la actividad es obligatoria.');
      			}
				if (this.formulario.SL_ENFOQUE_POBLACIONAL.length == 0) {
      			  this.errors.push('El enfoque poblacional es obligatorio.');
      			}
				if ((!this.formulario.TX_NUMERO_ACTIVIDADES && this.formulario.TX_NUMERO_ACTIVIDADES != 0) || this.formulario.TX_NUMERO_ACTIVIDADES == "") {
      			  this.errors.push('El número de actividades es obligatorio.');
      			}
				if (!this.formulario.TX_FECHA_INICIO) {
      			  this.errors.push('La fecha de inicio es obligatoria.');
      			}
				if (!this.formulario.TX_FECHA_FIN) {
      			  this.errors.push('La fecha de fin es obligatoria.');
      			}
				if (!this.formulario.SL_IMPACTO_TERRITORIAL) {
      			  this.errors.push('El impacto territorial es obligatorio.');
      			}
				if (!this.formulario.SL_ORIGEN_INICIATIVA) {
      			  this.errors.push('El origen de la iniciativa es obligatorio.');
      			}

				if(this.errors.length == 0){
					$("#collapseTwo").collapse("show");
				}
				else{
					
				}

      			e.preventDefault();
    		},
			checkFormSeccionDos: function (e) {
		      	this.errors = [];

      			if (!this.formulario.TX_LUGAR_ESCENARIO) {
      			  this.errors.push('El lugar es obligatorio.');
      			}
      			if (!this.formulario.TX_CAPACIDAD_AFORO) {
      			  this.errors.push('La capacidad o aforo es obligatorio.');
      			}
				if (!this.formulario.SL_ESPACIO_PUBLICO) {
      			 this.errors.push('El ¿espacio público? es obligatorio.');
				}
				if (!this.formulario.SL_BARRIO) {
					this.errors.push('El barrio es obligatorio.');	 
      			}
				if (!this.formulario.SL_LOCALIDAD) {
      			  this.errors.push('La localidad es obligatoria.');
      			}
				if (!this.formulario.TX_UPZ_UPR) {
      			  this.errors.push('La UPZ-UPR es obligatoria.');
      			}
				if (!this.formulario.SL_MODALIDAD_USO_COMPARTIDO) {
      			  this.errors.push('La modalidad de uso compartido es obligatoria.');
      			}
				if (!this.formulario.TX_NUMERO_ARTISTAS_REMUNERADOS) {
      			  this.errors.push('El número de artistas remunerados es obligatorio (Debe poner al menos 0).');
      			}
				if (!this.formulario.TX_NUMERO_ARTISTAS_NO_REMUNERADOS) {
      			  this.errors.push('El número de artistas no remunerados es obligatorio (Debe poner al menos 0).');
      			}
				if (!this.formulario.TX_NUMERO_PERSONAS_INSCRITAS) {
      			  this.errors.push('El número de personas inscritas es obligatorio (Debe poner al menos 0).');
      			}
				if (!this.formulario.TX_MUJERES_BENEFICIADAS) {
      			  this.errors.push('El número de mujeres beneficiadas es obligatorio (Debe poner al menos 0).');
      			}
				if (!this.formulario.TX_HOMBRES_BENEFICIADOS) {
      			  this.errors.push('El número de hombres beneficiadios es obligatorio (Debe poner al menos 0).');
      			}
				if (!this.formulario.TX_OTROS_BENEFICIADOS) {
      			  this.errors.push('El número de otros beneficiados es obligatorio (Debe poner al menos 0).');
      			}
				if (!this.formulario.SL_EVENTO_GRATUITO) {
      			  this.errors.push('El ¿Evento gratuito? es obligatorio.');
      			}

				if(this.errors.length == 0){
					$("#collapseThree").collapse("show");
				}
				else{
					
				}

      			e.preventDefault();
    		},
			checkFormSeccionTres: function (e) {
		      	this.errors = [];

				this.formulario.grupos_poblacionales.forEach((value) => {
					if(value.cantidad === ""){
						this.errors.push("La cifra de "+value.text+" es obligatoria.");
					}
		  		});
      			
				if (!this.formulario.TX_INSTRUMENTO_RECOLECTOR) {
      			  this.errors.push('El instrumento recolector es obligatorio.');
      			}
				if (!this.formulario.anexos && this.bandera_crear == true) {
      			  this.errors.push('Los anexos son obligatorios.');
      			}

				if(this.formulario.anexos != undefined && this.formulario.anexos != {}){
					var filesize = this.formulario.anexos.size;
					if(filesize > 50000000){
						this.errors.push('El anexo no debe superar los 50Mb.');
					}
				}

				if(this.errors.length == 0){
					$("#collapseFour").collapse("show");
				}
				else{
					
				}

      			e.preventDefault();
    		},
			checkFormSeccionCuatro: function (e) {
		      	this.errors = [];
      			
				if (!this.formulario.SL_ACTIVIDAD_ARTICULADA_SDIS) {
      			  this.errors.push('La pregunta de ¿Actividad Articulada? es obligatoria.');
      			}
				if (!this.formulario.SL_PROYECTO_SDIS) {
      			  this.errors.push('El(los) proyecto(s) participantes son obligatorios.');
      			}
				if (!this.formulario.TX_TOTAL_BENEFICIARIOS_SDIS) {
      			  this.errors.push('El total de beneficiarios SDIS es obligatorio.');
      			}

				if(this.errors.length == 0){
					Swal.fire({
  					title: "¿Desea guardar el reporte?",
					icon: 'question',
  					showCancelButton: true,
  					confirmButtonText: `Sí, guardar`,
					confirmButtonColor: "#17a2b8",
  					cancelButtonText: `Cancelar`,
					}).then((result) => {
	  					if (result.isConfirmed) {
							this.formulario.id_persona = this.id_persona;
							const formData = new FormData();
							formData.append("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr("content"));
							formData.append('formulario', JSON.stringify(this.formulario));
							formData.append('anexos', this.formulario.anexos);
							formData.append('id_reporte', this.id_reporte);
							Swal.fire({
                    			title: "Guardando la información",
	                    		text: "Espere un poco por favor",
                    			imageUrl: "../public/images/cargando.gif",
                    			imageWidth: 140,
                    			imageHeight: 70,
                    			showConfirmButton: false,
                    			backdrop: `rgba(0,0,123,0.4)`,
								allowOutsideClick:false
                			});

							var url = "";
							var mensaje = "";
							var titulo = "";
							if(this.bandera_crear == true){
								url="/sif/framework/culturas/reporteMetasCuantitativas/save";
								titulo = "¡Registro exitoso!";
								mensaje = "Se ha guardado el Reporte satisfactoriamente";
							}
							if(this.bandera_editar == true){
								url="/sif/framework/culturas/reporteMetasCuantitativas/update";
								titulo = "¡Actualización exitosa!";
								mensaje = "Se ha actualizado el Reporte satisfactoriamente";
							}

							axios({
					    		method: 'post',
    							url: url,
    							data: formData,
    							config: { headers: {'Content-Type': 'multipart/form-data' }}
    						})
							.then(response => {
								Swal.fire({
									title: titulo,
  									text: mensaje,
                           			icon: 'success',
									confirmButtonText: `OK`,
									}
                       			).then((result) => {
									if(result.value){
 										this.resetFormulario();
										this.cancelar();
									}
								});
							})
							.catch(error => {
								Swal.fire("Error", "No se pudo guardar el reporte, por favor inténtelo nuevamente", "error");
							});
  						}
					})
				}

      			e.preventDefault();
    		},
			limpiarErrores: function(e){
				this.errors = [];
			},
			getIdPersona(){
				axios
				.post("/sif/framework/getIdPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.id_persona = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de la persona, por favor inténtelo nuevamente", "error");
				});
			},
			getRolPersona(){
				axios
				.post("/sif/framework/getRolPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.rol_persona = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el rol de la persona, por favor inténtelo nuevamente", "error");
				});
			},
			bloquearCamposProyectoSDIS(){
				this.limpiarErrores();
				if(this.formulario.SL_ACTIVIDAD_ARTICULADA_SDIS.value == false){
					this.formulario.SL_PROYECTO_SDIS_DISABLED = true;
					this.formulario.TX_TOTAL_BENEFICIARIOS_SDIS = "0";
					this.formulario.SL_PROYECTO_SDIS = {text:'NO APLICA', value:19};

					//$("#SL_PROYECTO_SDIS").prop("disabled",true);
					$("#TX_TOTAL_BENEFICIARIOS_SDIS").attr("disabled",true);
				}
				else{
					//$("#SL_PROYECTO_SDIS").prop("disabled", false);
					$("#TX_TOTAL_BENEFICIARIOS_SDIS").removeAttr("disabled");
					this.formulario.TX_TOTAL_BENEFICIARIOS_SDIS = "";
					this.formulario.SL_PROYECTO_SDIS_DISABLED = false;
					this.formulario.SL_PROYECTO_SDIS = null;
				}
			},
			bloquearDetalleActividadCompartida(){
				this.limpiarErrores();
				if(this.formulario.SL_ACTIVIDAD_COMPARTIDA.value == false){
					this.formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA_DISABLED = true;
					this.formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA = {text:'NO APLICA', value:0};
				}
				else{
					this.formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA_DISABLED = false;
				}
			},
			cargaDI() {
				if(this.$refs.anexos.files[0] != undefined){
					this.anexos = this.$refs.anexos.files[0];
                	this.formulario.anexos = this.$refs.anexos.files[0];
				}
				else{
					this.anexos = null;
                	delete this.formulario['anexos'];
				}
            },
			cargarInfoReporte(id){
				this.resetFormulario();
				this.limpiarErrores();
				Swal.fire({
                	title: "Cargando información",
	                text: "",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
				axios
				.post("/sif/framework/culturas/reporteMetasCuantitativas/getReporte", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id
				})
				.then(response => {
					this.id_reporte = id;
					var vm = this;
					var data = JSON.parse(response.data['json_formulario']);
					var data_observaciones = {};
					if(response.data['json_observaciones'] != null){
						data_observaciones = JSON.parse(response.data['json_observaciones']);
					}
					vm.options_mes.forEach(function(elemento) {
  						if (elemento.value == response.data['in_mes']) {
    						vm.formulario.SL_MES = elemento;
  						}
					});
					vm.formulario.TX_NOMBRE_ACTIVIDAD = response.data['tx_nombre_actividad'];
					vm.formulario.TX_DESCRIPCION_ACTIVIDAD = response.data['tx_descripcion_actividad'];
					vm.formulario.TX_FECHA_INICIO = response.data['da_fecha_inicio'];
					vm.formulario.TX_FECHA_FIN = response.data['da_fecha_fin'];
					vm.anexos_editar = "../../uploadedFiles/"+response.data['url_anexos'];
					Object.keys(data).forEach(function(key) {
						if(data[key] !== undefined){
							vm.formulario[key] = data[key];
						}
						else{
							vm.formulario[key] = "";
						}
					})

					if(data_observaciones != null){
						if(data_observaciones['SL_MES'] != undefined) vm.observaciones['SL_MES'] = data_observaciones['SL_MES'];
						if(data_observaciones['TX_NOMBRE_ACTIVIDAD'] != undefined) vm.observaciones['TX_NOMBRE_ACTIVIDAD'] = data_observaciones['TX_NOMBRE_ACTIVIDAD'];
						if(data_observaciones['TX_DESCRIPCION_ACTIVIDAD'] != undefined) vm.observaciones['TX_DESCRIPCION_ACTIVIDAD'] = data_observaciones['TX_DESCRIPCION_ACTIVIDAD'];
						if(data_observaciones['TX_FECHA_INICIO'] != undefined) vm.observaciones['TX_FECHA_INICIO'] = data_observaciones['TX_FECHA_INICIO'];
						if(data_observaciones['TX_FECHA_FIN'] != undefined) vm.observaciones['TX_FECHA_FIN'] = data_observaciones['TX_FECHA_FIN'];
					}
					Object.keys(data_observaciones).forEach(function(key) {
						if(data[key] !== undefined){
							vm.observaciones[key] = data_observaciones[key];
						}
					})
					if(vm.disable_campos == true){
						vm.formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA_DISABLED = true;
						vm.formulario.SL_PROYECTO_SDIS_DISABLED = true;
						vm.formulario.SL_BARRIO_DISABLED = true;
					}
					$("#pills-formulario-tab").click();
					$("#collapseOne").collapse("show");
					Swal.fire({
						title: 'Información cargada',
  						text: '',
                        icon: 'success',
						confirmButtonText: `Continuar`,
					});
					vm.getBarrios();
					setTimeout(function(){
						vm.formulario['SL_BARRIO'] = data['SL_BARRIO'];
						vm.formulario['grupos_poblacionales'] = data['grupos_poblacionales'];
					}, 3000);
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información del reporte, por favor inténtelo nuevamente", "error");
				});
			},
			resetFormulario(){
				this.limpiarErrores();
				this.formulario = {'SL_AREA_ARTISTICA':[],'SL_ENFOQUE_POBLACIONAL':[], 'SL_DETALLE_ACTIVIDAD_COMPARTIDA':[],'SL_ACTIVIDAD_COMPARTIDA':{text:'SI', value:true}, 'SL_BARRIO':null, 'SL_PROYECTO_SDIS':{text:'', value:''}, 'TX_OTRAS_ENTIDADES_PARTICIPANTES':null};
				this.getGruposPoblacionalesCulturas();
				this.anexos = undefined;
				this.anexos_editar = undefined;
				this.formulario.SL_DETALLE_ACTIVIDAD_COMPARTIDA_DISABLED = false;
				this.formulario.SL_PROYECTO_SDIS_DISABLED = false;
				this.observaciones = {};
				$("#collapseOne").collapse("show");
			},
			cancelar(){
				this.resetFormulario();
				this.limpiarErrores();
				this.anexos_editar = null;
				this.bandera_crear = true;
				this.bandera_editar = false;
				this.bandera_revisar = false;
				this.bandera_ver = false;
				this.disable_campos = false;
			},
			calcularTotalBeneficiados(){
				this.limpiarErrores();
				this.formulario.TX_TOTAL_BENEFICIADOS = parseInt(this.formulario.TX_MUJERES_BENEFICIADAS) + parseInt(this.formulario.TX_HOMBRES_BENEFICIADOS) + parseInt(this.formulario.TX_OTROS_BENEFICIADOS);
			},
			saveRevisionReporte(action){
				var color = "";
				var estado = null;
				
				if(action == "rechazar"){
					color= "#dc3545";
					estado = 0;
				}
				if(action == "aprobar")
				{
					color= "#17a2b8";
					estado = 1;
				}
				
				var datos = {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					'id_reporte': this.id_reporte,
					'observaciones': JSON.stringify(this.observaciones),
					'estado':estado,
					'id_usuario': this.id_persona
				};

				Swal.fire({
  					title: "¿Desea "+action+" el reporte?",
					icon: 'question',
  					showCancelButton: true,
  					confirmButtonText: `Sí, `+action,
					confirmButtonColor: color,
  					cancelButtonText: `Cancelar`,
				}).then((result) => {
  					if (result.isConfirmed) {
						Swal.fire({
                    		title: "",
	                    	text: "Espere un poco por favor",
                    		imageUrl: "../public/images/cargando.gif",
                    		imageWidth: 140,
                    		imageHeight: 70,
                    		showConfirmButton: false,
	                    	backdrop: `rgba(0,0,123,0.4)`,
							allowOutsideClick:false
                		});
						axios({
					    method: 'post',
    					url: '/sif/framework/culturas/reporteMetasCuantitativas/saveRevision',
    					data: datos
    					})
						.then(response => {
							Swal.close()
							Swal.fire({
								title: 'Acción realizada',
  								text: '',
                           		icon: 'success',
								confirmButtonText: `OK`,
								}
                       		).then((result) => {
								if(result.value){
 									this.resetFormulario();
									 this.bandera_revisar = false;
									 this.disable_campos = false;
									 this.bandera_crear = true;
								}
							});
						})
						.catch(error => {
							Swal.fire("Error", "No se pudo guardar la revisión, por favor inténtelo nuevamente", "error");
						});
  					}
				})
			}
		},
		computed:{
		// 	'formulario.TX_MUJERES_BENEFICIADAS' : function(val) {
		// 	this.formulario.TX_TOTAL_BENEFICIADOS = parseInt(this.formulario.TX_MUJERES_BENEFICIADAS) + parseInt(this.formulario.TX_HOMBRES_BENEFICIADOS) + parseInt(this.formulario.TX_OTROS_BENEFICIADOS);
		//   },
		//   'formulario.TX_HOMBRES_BENEFICIADOS' : function(val) {
		// 	this.formulario.TX_TOTAL_BENEFICIADOS = parseInt(this.formulario.TX_MUJERES_BENEFICIADAS) + parseInt(this.formulario.TX_HOMBRES_BENEFICIADOS) + parseInt(this.formulario.TX_OTROS_BENEFICIADOS);
		//   },
		//   'formulario.TX_OTROS_BENEFICIADOS' : function(val) {
		// 	this.formulario.TX_TOTAL_BENEFICIADOS = parseInt(this.formulario.TX_MUJERES_BENEFICIADAS) + parseInt(this.formulario.TX_HOMBRES_BENEFICIADOS) + parseInt(this.formulario.TX_OTROS_BENEFICIADOS);
		//   }
		},
		watch:{
		//   'formulario.TX_MUJERES_BENEFICIADAS' : function(val) {
		// 	this.formulario.TX_TOTAL_BENEFICIADOS = parseInt(this.formulario.TX_MUJERES_BENEFICIADAS) + parseInt(this.formulario.TX_HOMBRES_BENEFICIADOS) + parseInt(this.formulario.TX_OTROS_BENEFICIADOS);
		//   },
		//   'formulario.TX_HOMBRES_BENEFICIADOS' : function(val) {
		// 	this.formulario.TX_TOTAL_BENEFICIADOS = parseInt(this.formulario.TX_MUJERES_BENEFICIADAS) + parseInt(this.formulario.TX_HOMBRES_BENEFICIADOS) + parseInt(this.formulario.TX_OTROS_BENEFICIADOS);
		//   },
		//   'formulario.TX_OTROS_BENEFICIADOS' : function(val) {
		// 	this.formulario.TX_TOTAL_BENEFICIADOS = parseInt(this.formulario.TX_MUJERES_BENEFICIADAS) + parseInt(this.formulario.TX_HOMBRES_BENEFICIADOS) + parseInt(this.formulario.TX_OTROS_BENEFICIADOS);
		//   }
		},
	}
</script>