<template>
	<div>
		<br>
		<h2>Módulo contenidos NIDOS</h2>
		<br>
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#registro-cifras">Registro cifras</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#modificacion-cifras" @click="getListadoCifras()">Modificación cifras</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#beneficiarios-con-info">Beneficiarios con información</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-beneficiarios-sin-info">Consulta beneficiarios sin información</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-beneficiarios-con-info">Consulta beneficiarios con información</a></li>
		</ul>
		<div class="tab-content">
			<div id="registro-cifras" class="tab-pane active"><br>
				<form id="form-beneficiarios-sin-info" @submit="guardarBeneficiariosSinInfo">
					<div class="row">
						<div class="col-lg-5 offset-lg-1">
							<div class="card col-lg-12">
								<div class="card-body">
									<div class="form-group">
										<div class="card-header bg-primary text-white"><i class="fas fa-2x fa-sort-numeric-down"></i> Beneficiarios atención real</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 0 a 3 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_cero_tres" type="number" @change="calcularTotal(0, 'real')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 0 a 3 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_cero_tres" type="number" @change="calcularTotal(0, 'real')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 0 a 3 años</label>
												<p v-model.number="in_total_ninos_cero_tres">{{in_total_ninos_cero_tres}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 4 a 5 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_cuatro_seis" type="number" @change="calcularTotal(1, 'real')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 4 a 5 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_cuatro_seis" type="number" @change="calcularTotal(1, 'real')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 4 a 5 años</label>
												<p v-model.number="in_total_ninos_cuatro_seis">{{in_total_ninos_cuatro_seis}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 6 a 6 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_seis_seis" type="number" @change="calcularTotal(2, 'real')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 6 a 6 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_seis_seis" type="number" @change="calcularTotal(2, 'real')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 6 a 6 años</label>
												<p v-model.number="in_total_ninos_seis_seis">{{in_total_ninos_seis_seis}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-8">
												<span>Mujeres gestantes</span>
												<input class="form-control" v-model.number="in_gestantes" type="number" @change="calcularTotal(3, 'real')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total gestantes</label>
												<p v-model.number="in_total_gestantes">{{in_total_gestantes}}</p>
											</div>
										</div>
									</div>
									<hr>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 offset-lg-4 text-right">
												<label>Total</label>
											</div>
											<div class="col-lg-3 text-right">
												<span v-model.number="in_total">{{in_total}}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="card col-lg-12">
								<div class="card-body">
									<div class="form-group">
										<div class="card-header bg-danger text-white"><i class="fas fa-2x fa-sort-numeric-down"></i> Beneficiarios nuevos</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 0 a 3 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_cero_tres_nuevos" type="number" @change="calcularTotal(0, 'nuevos')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 0 a 3 años, meses</span>
												<input class="form-control" v-model.number="in_ninas_cero_tres_nuevos" type="number" @change="calcularTotal(0, 'nuevos')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 0 a 3 años</label>
												<p v-model.number="in_total_ninos_cero_tres_nuevos">{{in_total_ninos_cero_tres_nuevos}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 4 a 5 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_cuatro_seis_nuevos" type="number" @change="calcularTotal(1, 'nuevos')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 4 a 5 años, meses</span>
												<input class="form-control" v-model.number="in_ninas_cuatro_seis_nuevos" type="number" @change="calcularTotal(1, 'nuevos')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 4 a 5 años</label>
												<p v-model.number="in_total_ninos_cuatro_seis_nuevos">{{in_total_ninos_cuatro_seis_nuevos}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 6 a 6 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_seis_seis_nuevos" type="number" @change="calcularTotal(2, 'nuevos')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 6 a 6 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_seis_seis_nuevos" type="number" @change="calcularTotal(2, 'nuevos')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 6 a 6 años</label>
												<p v-model.number="in_total_ninos_seis_seis_nuevos">{{in_total_ninos_seis_seis_nuevos}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-8">
												<span>Mujeres gestantes</span>
												<input class="form-control" v-model.number="in_gestantes_nuevos" type="number" @change="calcularTotal(3, 'nuevos')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total gestantes</label>
												<p v-model.number="in_total_gestantes_nuevos">{{in_total_gestantes_nuevos}}</p>
											</div>
										</div>
									</div>
									<hr>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 offset-lg-4 text-right">
												<label>Total</label>
											</div>
											<div class="col-lg-3 text-right">
												<span v-model.number="in_total_nuevos">{{in_total_nuevos}}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 offset-lg-1">
							<div class="card col-lg-12">
								<div class="card-body">
									<div class="form-group">
										<div class="card-header bg-primary text-white"><i class="fa fa-2x fa-users"></i> Beneficiarios con enfoque diferencial atención real</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Afrodescendiente</span>
												<input class="form-control" v-model.number="in_afro" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Comunidad rural y campesina</span>
												<input class="form-control" v-model.number="in_rural" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Condición de discapacidad</span>
												<input class="form-control" v-model.number="in_discapacidad" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Conflicto armado</span>
												<input class="form-control" v-model.number="in_conflicto" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Indígena</span>
												<input class="form-control" v-model.number="in_indigena" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Menores privados de la libertad</span>
												<input class="form-control" v-model.number="in_libertad" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Mujeres victimas de violencia</span>
												<input class="form-control" v-model.number="in_violencia" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Raizal</span>
												<input class="form-control" v-model.number="in_raizal" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Rom o gitano</span>
												<input class="form-control" v-model.number="in_rom" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Niños de 7 a 10 años</span>
												<input class="form-control" v-model.number="in_ninos_siete_diez" type="number" required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="card col-lg-12">
								<div class="card-body">
									<div class="form-group">
										<div class="card-header bg-danger text-white"><i class="fa fa-2x fa-users"></i> Beneficiarios con enfoque diferencial nuevos</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Afrodescendiente</span>
												<input class="form-control" v-model.number="in_afro_nuevos" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Comunidad rural y campesina</span>
												<input class="form-control" v-model.number="in_rural_nuevos" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Condición de discapacidad</span>
												<input class="form-control" v-model.number="in_discapacidad_nuevos" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Conflicto armado</span>
												<input class="form-control" v-model.number="in_conflicto_nuevos" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Indígena</span>
												<input class="form-control" v-model.number="in_indigena_nuevos" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Menores privados de la libertad</span>
												<input class="form-control" v-model.number="in_libertad_nuevos" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Mujeres victimas de violencia</span>
												<input class="form-control" v-model.number="in_violencia_nuevos" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Raizal</span>
												<input class="form-control" v-model.number="in_raizal_nuevos" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Rom o gitano</span>
												<input class="form-control" v-model.number="in_rom_nuevos" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Niños de 7 a 10 años</span>
												<input class="form-control" v-model.number="in_ninos_siete_diez_nuevos" type="number" required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card col-lg-10 offset-lg-1">
						<div class="card-body">
							<div class="form-group">
								<div class="card-header bg-primary text-white"><i class="fas fa-2x fa-map-marker-alt"></i> Información del lugar</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-6">
										<span>Lugar de atención</span>
										<multiselect v-model="id_lugar_s" label="text" :options="options_lugar" @input="getGruposInfoLugar(id_lugar_s, 1);" placeholder="Seleccione una opción" :show-spans="false" track-by="value"></multiselect>
									</div>
									<div class="col-lg-6">
										<span>Grupo</span>
										<multiselect v-model="id_grupo_s" label="text" :options="options_grupo_s" placeholder="Seleccione una opción" :show-spans="false" track-by="value"></multiselect>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-3">
										<span>Localidad</span>
										<p>{{localidad_s}}</p>
									</div>
									<div class="col-lg-3">
										<span>Upz</span>
										<p>{{upz_s}}</p>
									</div>
									<div class="col-lg-3">
										<span>Entidad</span>
										<p>{{entidad_s}}</p>
									</div>
									<div class="col-lg-3">
										<span>Barrio</span>
										<p>{{barrio_s}}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card col-lg-10 offset-lg-1">
						<div class="card-body">
							<div class="form-group">
								<div class="card-header bg-primary text-white"><i class="fa fa-2x fa-photo-video"></i> Información del contenido</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-4">
										<span>Contenido entregado</span>
										<multiselect v-model="ids_contenido_s" :options="options_contenido" :multiple="true" group-values="cont" group-label="categoria" :group-select="false" placeholder="Selección múltiple" track-by="name" label="name"></multiselect>
									</div>
									<div class="col-lg-4">
										<span>Fecha de entrega</span>
										<input class="form-control" v-model="tx_fecha_entrega_s" type="date" min="1900-01-01" v-bind:max="hoy" required>
									</div>
									<div class="col-lg-4">
										<span>Documento de soporte</span>
										<div class="input-group">
											<div class="custom-file">
												<input class="custom-file-input" type="file" v-on:change="onFileChange" accept="application/pdf" required>
												<span id="customFile" class="custom-file-label" for="inputGroupFile01">Seleccione un archivo</span>
											</div>
										</div>
										<small class="form-text text-muted">Archivo PDF peso máximo 5MB</small>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<div class="col-lg-4 offset-lg-4">
						<button class="form-control btn btn-primary" type="submit">Guardar</button>
					</div>
				</form>
			</div>

			<div id="modificacion-cifras" class="tab-pane"><br>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-4 offset-lg-4">
							<label>Seleccione una opción</label>
							<multiselect v-model="id_cifra_m" :options="options_cifras_m" label="text" placeholder="Seleccione una opción" :show-spans="false" track-by="value" @input="getInfoCifras(); display = true;"></multiselect>
						</div>
					</div>
				</div>
				<form @submit="modificarBeneficiariosSinInfo" v-show="display">
					<div class="row">
						<div class="col-lg-5 offset-lg-1">
							<div class="card col-lg-12">
								<div class="card-body">
									<div class="form-group">
										<div class="card-header bg-primary text-white"><i class="fas fa-2x fa-sort-numeric-down"></i> Beneficiarios atención real</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 0 a 3 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_cero_tres_s_m" type="number" @change="calcularTotal(0, 'real_m')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 0 a 3 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_cero_tres_s_m" type="number" @change="calcularTotal(0, 'real_m')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 0 a 3 años</label>
												<p v-model.number="in_total_ninos_cero_tres_s_m">{{in_total_ninos_cero_tres_s_m}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 4 a 5 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_cuatro_seis_s_m" type="number" @change="calcularTotal(1, 'real_m')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 4 a 5 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_cuatro_seis_s_m" type="number" @change="calcularTotal(1, 'real_m')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 4 a 5 años</label>
												<p v-model.number="in_total_ninos_cuatro_seis_s_m">{{in_total_ninos_cuatro_seis_s_m}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 6 a 6 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_seis_seis_s_m" type="number" @change="calcularTotal(2, 'real_m')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 6 a 6 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_seis_seis_s_m" type="number" @change="calcularTotal(2, 'real_m')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 6 a 6 años</label>
												<p v-model.number="in_total_ninos_seis_seis_s_m">{{in_total_ninos_seis_seis_s_m}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-8">
												<span>Mujeres gestantes</span>
												<input class="form-control" v-model.number="in_gestantes_s_m" type="number" @change="calcularTotal(3, 'real_m')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total gestantes</label>
												<p v-model.number="in_total_gestantes_s_m">{{in_total_gestantes_s_m}}</p>
											</div>
										</div>
									</div>
									<hr>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 offset-lg-4 text-right">
												<label>Total</label>
											</div>
											<div class="col-lg-3 text-right">
												<span v-model.number="in_total_s_m">{{in_total_s_m}}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="card col-lg-12">
								<div class="card-body">
									<div class="form-group">
										<div class="card-header bg-danger text-white"><i class="fas fa-2x fa-sort-numeric-down"></i> Beneficiarios nuevos</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 0 a 3 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_cero_tres_nuevos_s_m" type="number" @change="calcularTotal(0, 'nuevos_m')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 0 a 3 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_cero_tres_nuevos_s_m" type="number" @change="calcularTotal(0, 'nuevos_m')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 0 a 3 años</label>
												<p v-model.number="in_total_ninos_cero_tres_nuevos_s_m">{{in_total_ninos_cero_tres_nuevos_s_m}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 4 a 5 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_cuatro_seis_nuevos_s_m" type="number" @change="calcularTotal(1, 'nuevos_m')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 4 a 5 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_cuatro_seis_nuevos_s_m" type="number" @change="calcularTotal(1, 'nuevos_m')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 4 a 5 años</label>
												<p v-model.number="in_total_ninos_cuatro_seis_nuevos_s_m">{{in_total_ninos_cuatro_seis_nuevos_s_m}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4">
												<span>Niños de 6 a 6 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninos_seis_seis_nuevos_s_m" type="number" @change="calcularTotal(2, 'nuevos_m')" required>
											</div>
											<div class="col-lg-4">
												<span>Niñas de 6 a 6 años, 11 meses</span>
												<input class="form-control" v-model.number="in_ninas_seis_seis_nuevos_s_m" type="number" @change="calcularTotal(2, 'nuevos_m')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total de 6 a 6 años</label>
												<p v-model.number="in_total_ninos_seis_seis_nuevos_s_m">{{in_total_ninos_seis_seis_nuevos_s_m}}</p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-8">
												<span>Mujeres gestantes</span>
												<input class="form-control" v-model.number="in_gestantes_nuevos_s_m" type="number" @change="calcularTotal(3, 'nuevos_m')" required>
											</div>
											<div class="col-lg-3 text-right">
												<label>Total gestantes</label>
												<p v-model.number="in_total_gestantes_nuevos_s_m">{{in_total_gestantes_nuevos_s_m}}</p>
											</div>
										</div>
									</div>
									<hr>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-4 offset-lg-4 text-right">
												<label>Total</label>
											</div>
											<div class="col-lg-3 text-right">
												<span v-model.number="in_total_nuevos_s_m">{{in_total_nuevos_s_m}}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 offset-lg-1">
							<div class="card col-lg-12">
								<div class="card-body">
									<div class="form-group">
										<div class="card-header bg-primary text-white"><i class="fa fa-2x fa-users"></i> Beneficiarios con enfoque diferencial atención real</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Afrodescendiente</span>
												<input class="form-control" v-model.number="in_afro_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Comunidad rural y campesina</span>
												<input class="form-control" v-model.number="in_rural_s_m" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Condición de discapacidad</span>
												<input class="form-control" v-model.number="in_discapacidad_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Conflicto armado</span>
												<input class="form-control" v-model.number="in_conflicto_s_m" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Indígena</span>
												<input class="form-control" v-model.number="in_indigena_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Menores privados de la libertad</span>
												<input class="form-control" v-model.number="in_libertad_s_m" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Mujeres victimas de violencia</span>
												<input class="form-control" v-model.number="in_violencia_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Raizal</span>
												<input class="form-control" v-model.number="in_raizal_s_m" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Rom o gitano</span>
												<input class="form-control" v-model.number="in_rom_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Niños de 7 a 10 años</span>
												<input class="form-control" v-model.number="in_ninos_siete_diez_s_m" type="number" required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="card col-lg-12">
								<div class="card-body">
									<div class="form-group">
										<div class="card-header bg-danger text-white"><i class="fa fa-2x fa-users"></i> Beneficiarios con enfoque diferencial nuevos</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Afrodescendiente</span>
												<input class="form-control" v-model.number="in_afro_nuevos_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Comunidad rural y campesina</span>
												<input class="form-control" v-model.number="in_rural_nuevos_s_m" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Condición de discapacidad</span>
												<input class="form-control" v-model.number="in_discapacidad_nuevos_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Conflicto armado</span>
												<input class="form-control" v-model.number="in_conflicto_nuevos_s_m" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Indígena</span>
												<input class="form-control" v-model.number="in_indigena_nuevos_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Menores privados de la libertad</span>
												<input class="form-control" v-model.number="in_libertad_nuevos_s_m" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Mujeres victimas de violencia</span>
												<input class="form-control" v-model.number="in_violencia_nuevos_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Raizal</span>
												<input class="form-control" v-model.number="in_raizal_nuevos_s_m" type="number" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-6">
												<span>Rom o gitano</span>
												<input class="form-control" v-model.number="in_rom_nuevos_s_m" type="number" required>
											</div>
											<div class="col-lg-6">
												<span>Niños de 7 a 10 años</span>
												<input class="form-control" v-model.number="in_ninos_siete_diez_nuevos_s_m" type="number" required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card col-lg-10 offset-lg-1">
						<div class="card-body">
							<div class="form-group">
								<div class="card-header bg-primary text-white"><i class="fas fa-2x fa-map-marker-alt"></i> Información del lugar</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-6">
										<span>Lugar de atención</span>
										<multiselect v-model="id_lugar_s_m" label="text" :options="options_lugar" @input="getGruposInfoLugar(id_lugar_s_m, 3);" placeholder="Seleccione una opción" :show-spans="false" track-by="value" required></multiselect>
									</div>
									<div class="col-lg-6">
										<span>Grupo</span>
										<multiselect v-model="id_grupo_s_m" label="text" :options="options_grupo_m" placeholder="Seleccione una opción" :show-spans="false" track-by="value" required></multiselect>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-3">
										<span>Localidad</span>
										<p>{{localidad_s_m}}</p>
									</div>
									<div class="col-lg-3">
										<span>Upz</span>
										<p>{{upz_s_m}}</p>
									</div>
									<div class="col-lg-3">
										<span>Entidad</span>
										<p>{{entidad_s_m}}</p>
									</div>
									<div class="col-lg-3">
										<span>Barrio</span>
										<p>{{barrio_s_m}}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card col-lg-10 offset-lg-1">
						<div class="card-body">
							<div class="form-group">
								<div class="card-header bg-primary text-white"><i class="fa fa-2x fa-photo-video"></i> Información del contenido</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-4">
										<span>Contenido entregado</span>
										<multiselect v-model="ids_contenido_s_m" :options="options_contenido" :multiple="true" group-values="cont" group-label="categoria" :group-select="false" placeholder="Selección múltiple" track-by="name" label="name"></multiselect>
									</div>
									<div class="col-lg-4">
										<span>Fecha de entrega</span>
										<input class="form-control" v-model="tx_fecha_entrega_s_m" type="date" min="1900-01-01" v-bind:max="hoy" required>
									</div>
									<div class="col-lg-4">
										<span>Documento de soporte</span>
										<div class="input-group">
											<div class="custom-file">
												<input class="custom-file-input" type="file" v-on:change="onFileChange" accept="application/pdf">
												<span id="customFile" class="custom-file-label" for="inputGroupFile01">Seleccione un archivo</span>
											</div>&nbsp
											<a type="button" class="btn btn-warning" target="_blank" v-bind:href="documento_soporte"><i class="fas fa-eye"></i></a>
										</div>
										<small class="form-text text-muted">Archivo PDF peso máximo 5MB - Si selecciona un archivo se reemplazará el existente</small>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="col-lg-4 offset-lg-4">
						<button class="form-control btn btn-primary" id="bt-guardar" type="submit">Guardar</button>
					</div>
				</form>
			</div>
			<div id="beneficiarios-con-info" class="tab-pane"><br>
				<form id="form-beneficiarios-con-info" @submit="guardarBeneficiariosConInfo">
					<div class="card col-lg-8 offset-lg-2">
						<div class="card-body">
							<div class="form-group">
								<div class="card-header bg-primary text-white"><i class="fa fa-2x fa-photo-video"></i> Información del contenido</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-6">
										<label>Lugar de atención</label>
										<multiselect v-model="id_lugar_c" label="text" :options="options_lugar" @input="getGruposInfoLugar(id_lugar_c, 2)" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
									</div>
									<div class="col-lg-6">
										<label>Grupo</label>
										<multiselect v-model="id_grupo_c" label="text" :options="options_grupo_c" placeholder="Seleccione una opción" :show-labels="false" track-by="value" id="sl-grupo-c" name="sl-grupo-c"></multiselect>
									</div>
								</div>	
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-3">
										<label>Localidad</label>
										<p>{{localidad_c}}</p>
									</div>
									<div class="col-lg-3">
										<label>Upz</label>
										<p>{{upz_c}}</p>
									</div>
									<div class="col-lg-3">
										<label>Entidad</label>
										<p>{{entidad_c}}</p>
									</div>
									<div class="col-lg-3">
										<label>Barrio</label>
										<p>{{barrio_c}}</p>
									</div>
								</div>
							</div>
							<div class="form-group" id="prueba">
								<div class="row">
									<div class="col-lg-6">
										<label>Contenido entregado</label>
										<multiselect v-model="ids_contenido_c" :options="options_contenido" :multiple="true" group-values="cont" group-label="categoria" :group-select="false" placeholder="Selección múltiple" track-by="name" label="name"></multiselect>
									</div>
									<div class="col-lg-6">
										<label>Fecha de entrega</label>
										<input class="form-control" v-model="tx_fecha_entrega_c" type="date" min="1900-01-01" v-bind:max="hoy" required>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="card-header col-lg-12 bg-primary text-white"><i class="fa fa-2x fa-users"></i> Información de los beneficiarios</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<div class="row">
								<table class="table table-sm table-bordered table-hover" id="tabla-beneficiarios">
									<thead>
										<tr>
											<th>Número de<br>documento</th>
											<th>Tipo de<br>documento</th>
											<th>Primer<br>nombre</th>
											<th>Segundo<br>nombre</th>
											<th>Primer<br>apellido</th>
											<th>Segundo<br>apellido</th>
											<th>Fecha de<br>nacimiento</th>
											<th>Género</th>
											<th>Enfoque<br>diferencial</th>
											<th>Estrato</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(beneficiario, index) in beneficiarios">
											<td class="text-center">
												<input type="text" class="form-control" placeholder="Documento" required minlength="3" maxlength="25" v-model="beneficiario.identificacion" @change="validarBeneficiarioRegistrado(beneficiario.identificacion, index)">
											</td>
											<td>
												<multiselect v-model="beneficiario.tipo_documento" label="text" :options="options_tipo_doc" placeholder="Seleccione" :show-labels="false" track-by="value"></multiselect>
											</td>
											<td>
												<input type="text" class="form-control" placeholder="P. nombre" required minlength="3" v-model="beneficiario.primer_nombre" @input="beneficiario.primer_nombre=beneficiario.primer_nombre.toUpperCase()" :readonly="beneficiario.existe == 1">
											</td>
											<td>
												<input type="text" class="form-control" placeholder="S. nombre" v-model="beneficiario.segundo_nombre" @input="beneficiario.segundo_nombre=beneficiario.segundo_nombre.toUpperCase()">
											</td>
											<td>
												<input type="text" class="form-control" placeholder="P. apellido" required minlength="3" v-model="beneficiario.primer_apellido" @input="beneficiario.primer_apellido=beneficiario.primer_apellido.toUpperCase()" :readonly="beneficiario.existe == 1">
											</td>
											<td>
												<input type="text" class="form-control" placeholder="S. apellido" v-model="beneficiario.segundo_apellido" @input="beneficiario.segundo_apellido=beneficiario.segundo_apellido.toUpperCase()">
											</td>
											<td>
												<input type="date" class="form-control date" required v-model="beneficiario.fecha_nacimiento" min="1900-01-01" v-bind:max="hoy">
											</td>
											<td>
												<multiselect v-model="beneficiario.genero" label="text" :options="options_genero" placeholder="Seleccione" :show-labels="false" track-by="value"></multiselect>
											</td>
											<td>
												<multiselect v-model="beneficiario.enfoque" label="text" :options="options_enfoque" placeholder="Seleccione" :show-labels="false" track-by="value"></multiselect>
											</td>
											<td>
												<multiselect v-model="beneficiario.estrato" label="text" :options="options_estrato" placeholder="Seleccione" :show-labels="false" track-by="value"></multiselect>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="text-right">
								<button type="button" class="btn btn-success" id="bt-agregar" @click="agregarBeneficiario"><i class="fas fa-plus-circle"></i></button>
								<button type="button" class="btn btn-danger" id="bt-remover" @click="eliminarBeneficiario"><i class="fas fa-minus-circle"></i></button>
							</div>
							<div class="text-center">
								<button type="submit" class="btn btn-primary">Guardar</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div id="consulta-beneficiarios-sin-info" class="tab-pane"><br>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6 offset-lg-3">
							<label>Mes</label>
							<multiselect v-model="id_mes_s" :options="options_mes" @input="getInformeBeneficiariosSinInfo" label="text" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
						</div>
					</div>	
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<table class="table-sm table-bordered display nowrap" id="tabla-info-sin-informacion" style="width: 100%">
								<thead>
									<tr>
										<th>Contenido</th>
										<th>Fecha</th>
										<th>Localidad</th>
										<th>Upz</th>
										<th>Lugar</th>
										<th>Entidad</th>
										<th>Barrio</th>
										<th>Grupo</th>
										<th>Total</th>
										<th>Niños</th>
										<th>Niñas</th>
										<th>Niños<br>0 a 3</th>
										<th>Niños<br>3 a 6</th>
										<th>Niñas<br>0 a 3</th>
										<th>Niñas<br>3 a 6</th>
										<th data-toggle="popover" data-text="Mujer gestante">MG</th>
										<th data-toggle="popover" data-text="Afrodescendiente">AF</th>
										<th data-toggle="popover" data-text="Comunidad rural y campesina">CR</th>
										<th data-toggle="popover" data-text="Conflicto de discapacidad">CD</th>
										<th data-toggle="popover" data-text="Conflicto armado">CA</th>
										<th data-toggle="popover" data-text="Indígena">IN</th>
										<th data-toggle="popover" data-text="Menores privados de la libertad">MP</th>
										<th data-toggle="popover" data-text="Mujeres victimas de violencia">MV</th>
										<th data-toggle="popover" data-text="Raizal">RZ</th>
										<th data-toggle="popover" data-text="Rom o gitano">RG</th>
										<th>Soporte</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div id="consulta-beneficiarios-con-info" class="tab-pane"><br>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6 offset-lg-3">
							<label>Mes</label>
							<multiselect v-model="id_mes_c" :options="options_mes" @input="getInformeBeneficiariosConInfo" label="text" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12 col-sm-12 table-responsive">
							<table class="table table-sm nowrap display" id="tabla-info-con-informacion" style="width:100%;">
								<thead>
									<tr>
										<th>Localidad</th>
										<th>Upz</th>
										<th>Barrio</th>
										<th>Lugar</th>
										<th>Contenido(s)</th>
										<th>Niños<br>0 a 3</th>
										<th>Niños<br>3 a 6</th>
										<th>Gestanates</th>
										<th data-toggle="popover" data-text="Afrodescendiente">AF</th>
										<th data-toggle="popover" data-text="Rom o gitano">RG</th>
										<th data-toggle="popover" data-text="Indígena">IN</th>
										<th data-toggle="popover" data-text="Conflicto armado">CA</th>
										<th data-toggle="popover" data-text="Condición de discapacidad">CD</th>
										<th data-toggle="popover" data-text="Ninnguno">N</th>
										<th data-toggle="popover" data-text="Menores privados de la libertad">MP</th>
										<th data-toggle="popover" data-text="Raizal">RZ</th>
										<th data-toggle="popover" data-text="Comunidad rural y campesina">CR</th>
										<th data-toggle="popover" data-text="Mujeres victimas de violencia">MV</th>
										<th>Total</th>
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
</template>

<script>

	require( 'jszip' );
	require( 'datatables.net-dt' );
	require( 'datatables.net-buttons-dt' );
	require( 'datatables.net-buttons/js/buttons.html5.js' );
	require( 'datatables.net-responsive-dt' );

	import Multiselect from "vue-multiselect";

	export default {
		components: { Multiselect },
		data () {
			return {
				id_persona: "",
				id_territorio: "",

				in_ninos_cero_tres: 0,
				in_ninas_cero_tres: 0,
				in_total_ninos_cero_tres: 0,
				in_ninos_cuatro_seis: 0,
				in_ninas_cuatro_seis: 0,
				in_total_ninos_cuatro_seis: 0,
				in_ninos_seis_seis: 0,
				in_ninas_seis_seis: 0,
				in_total_ninos_seis_seis: 0,
				in_gestantes: 0,
				in_total_gestantes: 0,
				in_total: 0,
				in_afro: "",
				in_rural: "",
				in_discapacidad: "",
				in_conflicto: "",
				in_indigena: "",
				in_libertad: "",
				in_violencia: "",
				in_raizal: "",
				in_rom: "",
				in_ninos_siete_diez: "",

				in_ninos_cero_tres_nuevos: 0,
				in_ninas_cero_tres_nuevos: 0,
				in_total_ninos_cero_tres_nuevos: 0,
				in_ninos_cuatro_seis_nuevos: 0,
				in_ninas_cuatro_seis_nuevos: 0,
				in_total_ninos_cuatro_seis_nuevos: 0,
				in_ninos_seis_seis_nuevos: 0,
				in_ninas_seis_seis_nuevos: 0,
				in_total_ninos_seis_seis_nuevos: 0,
				in_gestantes_nuevos: 0,
				in_total_gestantes_nuevos: 0,
				in_total_nuevos: 0,
				in_afro_nuevos: "",
				in_rural_nuevos: "",
				in_discapacidad_nuevos: "",
				in_conflicto_nuevos: "",
				in_indigena_nuevos: "",
				in_libertad_nuevos: "",
				in_violencia_nuevos: "",
				in_raizal_nuevos: "",
				in_rom_nuevos: "",
				in_ninos_siete_diez_nuevos: "",


				in_ninos_cero_tres_s_m: 0,
				in_ninas_cero_tres_s_m: 0,
				in_total_ninos_cero_tres_s_m: 0,
				in_ninos_cuatro_seis_s_m: 0,
				in_ninas_cuatro_seis_s_m: 0,
				in_total_ninos_cuatro_seis_s_m: 0,
				in_ninos_seis_seis_s_m: 0,
				in_ninas_seis_seis_s_m: 0,
				in_total_ninos_seis_seis_s_m: 0,
				in_gestantes_s_m: 0,
				in_total_gestantes_s_m: 0,
				in_total_s_m: 0,
				in_afro_s_m: "",
				in_rural_s_m: "",
				in_discapacidad_s_m: "",
				in_conflicto_s_m: "",
				in_indigena_s_m: "",
				in_libertad_s_m: "",
				in_violencia_s_m: "",
				in_raizal_s_m: "",
				in_rom_s_m: "",
				in_ninos_siete_diez_s_m: "",

				in_ninos_cero_tres_nuevos_s_m: 0,
				in_ninas_cero_tres_nuevos_s_m: 0,
				in_total_ninos_cero_tres_nuevos_s_m: 0,
				in_ninos_cuatro_seis_nuevos_s_m: 0,
				in_ninas_cuatro_seis_nuevos_s_m: 0,
				in_total_ninos_cuatro_seis_nuevos_s_m: 0,
				in_ninos_seis_seis_nuevos_s_m: 0,
				in_ninas_seis_seis_nuevos_s_m: 0,
				in_total_ninos_seis_seis_nuevos_s_m: 0,
				in_gestantes_nuevos_s_m: 0,
				in_total_gestantes_nuevos_s_m: 0,
				in_total_nuevos_s_m: 0,
				in_afro_nuevos_s_m: "",
				in_rural_nuevos_s_m: "",
				in_discapacidad_nuevos_s_m: "",
				in_conflicto_nuevos_s_m: "",
				in_indigena_nuevos_s_m: "",
				in_libertad_nuevos_s_m: "",
				in_violencia_nuevos_s_m: "",
				in_raizal_nuevos_s_m: "",
				in_rom_nuevos_s_m: "",
				in_ninos_siete_diez_nuevos_s_m: "",

				id_lugar_s_m: "",
				id_grupo_s_m: "",
				localidad_s_m: "",
				upz_s_m: "",
				entidad_s_m: "",
				barrio_s_m: "",
				ids_contenido_s_m: "",
				tx_fecha_entrega_s_m: "",

				id_lugar_s: "",
				id_grupo_s: "",
				localidad_s: "",
				upz_s: "",
				entidad_s: "",
				barrio_s: "",
				ids_contenido_s: [],
				tx_fecha_entrega_s: "",
				archivo: "",
				id_lugar_c: "",
				id_grupo_c: "",
				localidad_c: "",
				upz_c: "",
				entidad_c: "",
				barrio_c: "",
				ids_contenido_c: [],
				tx_fecha_entrega_c: "",
				options_lugar: [],
				options_grupo_s: [],
				options_grupo_c: [],
				options_contenido: [],
				options_tipo_doc: [],
				options_genero: [],
				options_enfoque: [],
				options_estrato: [],
				beneficiarios: [{
					identificacion: "",
					tipo_documento: "",
					primer_nombre: "",
					segundo_nombre: "",
					primer_apellido: "",
					segundo_apellido: "",
					fecha_nacimiento: "",
					genero: "",
					enfoque: "",
					estrato: "",
					existe: 0
				}],
				options_mes: [],
				id_mes_s: "",
				id_mes_c: "",
				info_tabla_sin_info: "",
				tabla_sin_info: "",
				tabla_con_info: "",
				hoy: "",
				options_cifras_m: [],
				id_cifra_m: "",
				options_grupo_m: [],
				documento_soporte: "",
				display: false
			}
		},
		mounted() {

			this.getMes();
			this.getIdPersona();
			this.getContenidos();
			this.getTipoDocumento();
			this.getGenero();
			this.getEnfoque();
			this.getEstrato();


			var date = new Date();
			var month;
			var day;

			if((date.getMonth() + 1) < 10)
				month = "0" + (date.getMonth() + 1);
			else
				month = (date.getMonth() + 1);

			if(date.getDate() < 10)
				day = "0" + date.getDate();
			else
				day = date.getDate();

			this.hoy = date.getFullYear() + "-" + month + "-" + day;

			$("[data-toggle='popover']").each(function(index, el) {
				$(el).popover({
					placement: 'top',
					trigger: 'hover',
					container: 'body',
					html: true,
					content: function () {
						return $(this).attr("data-text");
					}
				});
			});

			this.config_tabla_reporte = {
				responsive: true,
				pageLength: 50,
				dom: 'Blfrtip',
				buttons: [{
					extend: 'excel',
					text: 'Descargar datos',
					filename: 'Datos'
				}],
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
				}
			};

			this.tabla_sin_info = $("#tabla-info-sin-informacion").DataTable(this.config_tabla_reporte);
			this.tabla_con_info = $("#tabla-info-con-informacion").DataTable(this.config_tabla_reporte);
		},
		methods:{
			onFileChange(e){
				this.archivo = e.target.files[0];
			},
			calcularTotal(rango, tipo){
				if(rango == 0 && tipo == "real"){
					this.in_total_ninos_cero_tres = this.in_ninos_cero_tres + this.in_ninas_cero_tres;
				}
				if(rango == 1 && tipo == "real"){
					this.in_total_ninos_cuatro_seis = this.in_ninos_cuatro_seis + this.in_ninas_cuatro_seis;
				}
				if(rango == 2 && tipo == "real"){
					this.in_total_ninos_seis_seis = this.in_ninos_seis_seis + this.in_ninas_seis_seis;
				}
				if(rango == 3 && tipo == "real"){
					this.in_total_gestantes = this.in_gestantes;
				}
				if(rango == 0 && tipo == "nuevos"){
					this.in_total_ninos_cero_tres_nuevos = this.in_ninos_cero_tres_nuevos + this.in_ninas_cero_tres_nuevos;
				}
				if(rango == 1 && tipo == "nuevos"){
					this.in_total_ninos_cuatro_seis_nuevos = this.in_ninos_cuatro_seis_nuevos + this.in_ninas_cuatro_seis_nuevos;
				}
				if(rango == 2 && tipo == "nuevos"){
					this.in_total_ninos_seis_seis_nuevos = this.in_ninos_seis_seis_nuevos + this.in_ninas_seis_seis_nuevos;
				}
				if(rango == 3 && tipo == "nuevos"){
					this.in_total_gestantes_nuevos = this.in_gestantes_nuevos;
				}
				if(rango == 0 && tipo == "real_m"){
					this.in_total_ninos_cero_tres_s_m = this.in_ninos_cero_tres_s_m + this.in_ninas_cero_tres_s_m;
				}
				if(rango == 1 && tipo == "real_m"){
					this.in_total_ninos_cuatro_seis_s_m = this.in_ninos_cuatro_seis_s_m + this.in_ninas_cuatro_seis_s_m;
				}
				if(rango == 2 && tipo == "real_m"){
					this.in_total_ninos_seis_seis_s_m = this.in_ninos_seis_seis_s_m + this.in_ninas_seis_seis_s_m
				}
				if(rango == 3 && tipo == "real_m"){
					this.in_total_gestantes_s_m = in_gestantes_s_m;
				}
				if(rango == 0 && tipo == "nuevos_m"){
					this.in_total_ninos_cero_tres_nuevos_s_m = this.in_ninos_cero_tres_nuevos_s_m + this.in_ninas_cero_tres_nuevos_s_m;
				}
				if(rango == 1 && tipo == "nuevos_m"){
					this.in_total_ninos_cuatro_seis_nuevos_s_m  = this.in_ninos_cuatro_seis_nuevos_s_m + this.in_ninas_cuatro_seis_nuevos_s_m;
				}
				if(rango == 2 && tipo == "nuevos_m"){
					this.in_total_ninos_seis_seis_nuevos_s_m = this.in_ninos_seis_seis_nuevos_s_m + this.in_ninas_seis_seis_nuevos_s_m;
				}
				if(rango == 3 && tipo == "nuevos_m"){
					this.in_total_gestantes_nuevos_s_m = this.in_gestantes_nuevos_s_m;
				}

				this.in_total = this.in_total_ninos_cero_tres + this.in_total_ninos_cuatro_seis + this.in_total_ninos_seis_seis + this.in_total_gestantes;
				this.in_total_nuevos = this.in_total_ninos_cero_tres_nuevos + this.in_total_ninos_cuatro_seis_nuevos + this.in_total_ninos_seis_seis_nuevos + this.in_total_gestantes_nuevos;
				this.in_total_s_m = this.in_total_ninos_cero_tres_s_m + this.in_total_ninos_cuatro_seis_s_m + this.in_total_ninos_seis_seis_s_m + this.in_total_gestantes_s_m;
				this.in_total_nuevos_s_m = this.in_total_ninos_cero_tres_nuevos_s_m + this.in_total_ninos_cuatro_seis_nuevos_s_m + this.in_total_ninos_seis_seis_nuevos_s_m + this.in_total_gestantes_nuevos_s_m;
			},
			getMes(){
				axios
				.post("/sif/framework/getMes", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.options_mes = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de meses, por favor inténtelo nuevamente", "error");
				});
			},
			getIdPersona(){
				axios
				.post("/sif/framework/getIdPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.id_persona = response.data;
					this.getTerritorioPersona();
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de la persona, por favor inténtelo nuevamente", "error");
				});
			},
			getTerritorioPersona(){
				axios
				.post("/sif/framework/nidos/territorios/getTerritorioPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					//id_persona: 1797
					id_persona: this.id_persona
				})
				.then(response => {
					this.id_territorio = response.data[0]["Pk_Id_Territorio"];
					this.getLugaresTerritorio();
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el territorio de la persona, por favor inténtelo nuevamente", "error");
				});
			},
			getLugaresTerritorio(){
				axios
				.post("/sif/framework/nidos/lugares/getLugaresTerritorio", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					//id_territorio: 10
					id_territorio: this.id_territorio,
				})
				.then(response => {
					this.options_lugar = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo actualizar la categoría, por favor inténtelo nuevamente", "error");
				});
			},
			getGruposInfoLugar(id_lugar, tipo_consulta){
				if(tipo_consulta == 1)
					this.id_grupo_s = ""

				if(tipo_consulta == 2)
					this.id_grupo_c = "";

				if(tipo_consulta == 3)
					this.id_grupo_s_m = "";					

				axios
				.post("/sif/framework/nidos/grupos/getGruposLugar", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_lugar: id_lugar
				})
				.then(response => {
					if(tipo_consulta == 1)
						this.options_grupo_s = response.data;
					
					if(tipo_consulta == 2)
						this.options_grupo_c = response.data;

					if(tipo_consulta == 3)
						this.options_grupo_m = response.data;
					
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de grupos, por favor inténtelo nuevamente", "error");
				});

				axios
				.post("/sif/framework/nidos/lugares/getInfoLugar", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_lugar: id_lugar
				})
				.then(response => {
					if(tipo_consulta == 1){
						this.localidad_s = response.data[0]["localidad"];
						this.upz_s = response.data[0]["upz"];
						this.entidad_s = response.data[0]["entidad"];
						this.barrio_s = response.data[0]["barrio"];
					}
					if(tipo_consulta == 2){
						this.localidad_c = response.data[0]["localidad"];
						this.upz_c = response.data[0]["upz"];
						this.entidad_c = response.data[0]["entidad"];
						this.barrio_c = response.data[0]["barrio"];
					}
					if(tipo_consulta == 3){
						this.localidad_s_m = response.data[0]["localidad"];
						this.upz_s_m = response.data[0]["upz"];
						this.entidad_s_m = response.data[0]["entidad"];
						this.barrio_s_m = response.data[0]["barrio"];
					}
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información del lugar, por favor inténtelo nuevamente", "error");
				});
			},
			getContenidos(){
				axios
				.post("/sif/framework/nidos/contenidos/getContenidos", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.options_contenido = JSON.parse(response.data[0].json);
				})
				.catch(error => {
					Swal.fire("Error", "No se pudieron obtener los contenidos disponbibles, por favor inténtelo nuevamente", "error");
				});
			},
			getTipoDocumento(){
				axios
				.post("/sif/framework/nidos/beneficiarios/getTipoDocumento", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.options_tipo_doc = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de tipo de documentos, por favor inténtelo nuevamente", "error");
				});
			},
			getGenero(){
				axios
				.post("/sif/framework/nidos/beneficiarios/getGenero", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.options_genero = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de géneros, por favor inténtelo nuevamente", "error");
				});
			},
			getEnfoque(){
				axios
				.post("/sif/framework/nidos/beneficiarios/getEnfoque", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.options_enfoque = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de enfoques diferenciales, por favor inténtelo nuevamente", "error");
				});
			},
			getEstrato(){
				axios
				.post("/sif/framework/nidos/beneficiarios/getEstrato", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.options_estrato = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de estratos, por favor inténtelo nuevamente", "error");
				});
			},
			agregarBeneficiario(){
				this.beneficiarios.push({
					identificacion: "",
					tipo_documento: "",
					primer_nombre: "",
					segundo_nombre: "",
					primer_apellido: "",
					segundo_apellido: "",
					fecha_nacimiento: "",
					genero: "",
					enfoque: "",
					estrato: ""
				});
			},
			eliminarBeneficiario(){
				this.beneficiarios.splice(-1,1);
			},
			guardarBeneficiariosSinInfo: function(e){
				e.preventDefault();
				if(this.id_lugar_s == ""){
					Swal.fire("Error","Compruebe que ha seleccionado un lugar de atención","error");
				}else if(this.id_grupo_s == ""){
					Swal.fire("Error","Compruebe que ha seleccionado un grupo","error");
				}else if(this.ids_contenido_s == ""){
					Swal.fire("Error","Compruebe que ha seleccionado al menos un contenido","error");
				} else{
					let config = { headers: { 'content-type': 'multipart/form-data' }}
					let datos = new FormData();

					let ids = "";
					this.ids_contenido_s.forEach(function (item) { 
						ids += item.value + ",";
					});
					ids = ids.slice(0,-1);

					let json = JSON.stringify({

						in_ninos_cero_tres: this.in_ninos_cero_tres,
						in_ninas_cero_tres: this.in_ninas_cero_tres,
						in_ninos_cuatro_seis: this.in_ninos_cuatro_seis,
						in_ninas_cuatro_seis: this.in_ninas_cuatro_seis,
						in_ninos_seis_seis: this.in_ninos_seis_seis,
						in_ninas_seis_seis: this.in_ninas_seis_seis,
						in_gestantes: this.in_gestantes,
						in_total: this.in_total,
						in_afro: this.in_afro,
						in_rural: this.in_rural,
						in_discapacidad: this.in_discapacidad,
						in_conflicto: this.in_conflicto,
						in_indigena: this.in_indigena,
						in_libertad: this.in_libertad,
						in_violencia: this.in_violencia,
						in_raizal: this.in_raizal,
						in_rom: this.in_rom,
						in_ninos_siete_diez: this.in_ninos_siete_diez,

						in_ninos_cero_tres_nuevos: this.in_ninos_cero_tres_nuevos,
						in_ninas_cero_tres_nuevos: this.in_ninas_cero_tres_nuevos,
						in_ninos_cuatro_seis_nuevos: this.in_ninos_cuatro_seis_nuevos,
						in_ninas_cuatro_seis_nuevos: this.in_ninas_cuatro_seis_nuevos,
						in_ninos_seis_seis_nuevos: this.in_ninos_seis_seis_nuevos,
						in_ninas_seis_seis_nuevos: this.in_ninas_seis_seis_nuevos,
						in_gestantes_nuevos: this.in_gestantes_nuevos,
						in_total_nuevos: this.in_total_nuevos,
						in_afro_nuevos: this.in_afro_nuevos,
						in_rural_nuevos: this.in_rural_nuevos,
						in_discapacidad_nuevos: this.in_discapacidad_nuevos,
						in_conflicto_nuevos: this.in_conflicto_nuevos,
						in_indigena_nuevos: this.in_indigena_nuevos,
						in_libertad_nuevos: this.in_libertad_nuevos,
						in_violencia_nuevos: this.in_violencia_nuevos,
						in_raizal_nuevos: this.in_raizal_nuevos,
						in_rom_nuevos: this.in_rom_nuevos,
						in_ninos_siete_diez_nuevos: this.in_ninos_siete_diez_nuevos,

						id_lugar: this.id_lugar_s["value"],
						id_grupo: this.id_grupo_s["value"], 
						ids_contenido: ids,
						tx_fecha_entrega: this.tx_fecha_entrega_s,
						id_persona: this.id_persona
					});

					datos.append('data', json);
					datos.append("archivo", this.archivo);

					axios.post('/sif/framework/nidos/contenidos/guardarBeneficiariosSinInfo', datos, config)
					.then(response => {
						Swal.fire("Exito", "La información se ha almacenado correctamente", "success");
						this.limpiarFormulario(1);
					})
					.catch(error => {
						Swal.fire("Error", "No se pudo almacenar la información, por favor inténtelo nuevamente", "error");
					});
				}
			},
			modificarBeneficiariosSinInfo: function(e){
				e.preventDefault();
				if(this.id_lugar_s_m == ""){
					Swal.fire("Error","Compruebe que ha seleccionado un lugar de atención","error");
				}else if(this.id_grupo_s_m == ""){
					Swal.fire("Error","Compruebe que ha seleccionado un grupo","error");
				}else if(this.ids_contenido_s_m == ""){
					Swal.fire("Error","Compruebe que ha seleccionado al menos un contenido","error");
				} else{
					let config = { headers: { 'content-type': 'multipart/form-data' }}
					let datos = new FormData();

					let ids = "";
					this.ids_contenido_s_m.forEach(function (item) { 
						ids += item.value + ",";
					});
					ids = ids.slice(0,-1);

					let json = JSON.stringify({

						id_cifra: this.id_cifra_m["value"],
						in_ninos_cero_tres_s_m: this.in_ninos_cero_tres_s_m,
						in_ninas_cero_tres_s_m: this.in_ninas_cero_tres_s_m,
						in_ninos_cuatro_seis_s_m: this.in_ninos_cuatro_seis_s_m,
						in_ninas_cuatro_seis_s_m: this.in_ninas_cuatro_seis_s_m,
						in_ninos_seis_seis_s_m: this.in_ninos_seis_seis_s_m,
						in_ninas_seis_seis_s_m: this.in_ninas_seis_seis_s_m,
						in_gestantes_s_m: this.in_gestantes_s_m,
						in_total_s_m: this.in_total_s_m,
						in_afro_s_m: this.in_afro_s_m,
						in_rural_s_m: this.in_rural_s_m,
						in_discapacidad_s_m: this.in_discapacidad_s_m,
						in_conflicto_s_m: this.in_conflicto_s_m,
						in_indigena_s_m: this.in_indigena_s_m,
						in_libertad_s_m: this.in_libertad_s_m,
						in_violencia_s_m: this.in_violencia_s_m,
						in_raizal_s_m: this.in_raizal_s_m,
						in_rom_s_m: this.in_rom_s_m,
						in_ninos_siete_diez_s_m: this.in_ninos_siete_diez_s_m,

						in_ninos_cero_tres_nuevos_s_m: this.in_ninos_cero_tres_nuevos_s_m,
						in_ninas_cero_tres_nuevos_s_m: this.in_ninas_cero_tres_nuevos_s_m,
						in_ninos_cuatro_seis_nuevos_s_m: this.in_ninos_cuatro_seis_nuevos_s_m,
						in_ninas_cuatro_seis_nuevos_s_m: this.in_ninas_cuatro_seis_nuevos_s_m,
						in_ninos_seis_seis_nuevos_s_m: this.in_ninos_seis_seis_nuevos_s_m,
						in_ninas_seis_seis_nuevos_s_m: this.in_ninas_seis_seis_nuevos_s_m,
						in_gestantes_nuevos_s_m: this.in_gestantes_nuevos_s_m,
						in_total_nuevos_s_m: this.in_total_nuevos_s_m,
						in_afro_nuevos_s_m: this.in_afro_nuevos_s_m,
						in_rural_nuevos_s_m: this.in_rural_nuevos_s_m,
						in_discapacidad_nuevos_s_m: this.in_discapacidad_nuevos_s_m,
						in_conflicto_nuevos_s_m: this.in_conflicto_nuevos_s_m,
						in_indigena_nuevos_s_m: this.in_indigena_nuevos_s_m,
						in_libertad_nuevos_s_m: this.in_libertad_nuevos_s_m,
						in_violencia_nuevos_s_m: this.in_violencia_nuevos_s_m,
						in_raizal_nuevos_s_m: this.in_raizal_nuevos_s_m,
						in_rom_nuevos_s_m: this.in_rom_nuevos_s_m,
						in_ninos_siete_diez_nuevos_s_m: this.in_ninos_siete_diez_nuevos_s_m,

						id_lugar_s_m: this.id_lugar_s_m["value"],
						id_grupo_s_m: this.id_grupo_s_m["value"], 
						ids_contenido_s_m: ids,
						tx_fecha_entrega_s_m: this.tx_fecha_entrega_s_m,
						id_persona: this.id_persona
					});

					datos.append('data', json);
					datos.append("archivo", this.archivo);

					axios.post('/sif/framework/nidos/contenidos/modificarBeneficiariosSinInfo', datos, config)
					.then(response => {
						Swal.fire("Exito", "La información se ha almacenado correctamente", "success");
						this.display = false;
						this.id_cifra_m = "";
					})
					.catch(error => {
						Swal.fire("Error", "No se pudo almacenar la información, por favor inténtelo nuevamente", "error");
					});
				}

			},
			getInformeBeneficiariosSinInfo(){
				axios
				.post("/sif/framework/nidos/contenidos/getInformeBeneficiariosSinInfo", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_mes: this.id_mes_s["value"],
					tipo_consulta: 1
				})
				.then(response => {
					this.info_tabla_sin_info = response.data;	
					this.tabla_sin_info.clear().draw();
					this.info_tabla_sin_info.forEach((value, index) => {
						this.rowNode = this.tabla_sin_info.row.add([
							this.info_tabla_sin_info[index]["VC_Contenido"],
							this.info_tabla_sin_info[index]['DT_Fecha_Entrega'],
							this.info_tabla_sin_info[index]['VC_Nom_Localidad'],
							this.info_tabla_sin_info[index]['VC_Nombre_Upz'],
							this.info_tabla_sin_info[index]['VC_Nombre_Lugar'],
							this.info_tabla_sin_info[index]['Vc_Abreviatura'],
							this.info_tabla_sin_info[index]['VC_Barrio'],
							this.info_tabla_sin_info[index]['VC_Nombre_Grupo'],
							this.info_tabla_sin_info[index]['IN_Total_Beneficiarios'],
							this.info_tabla_sin_info[index]['IN_Total_Ninos'],
							this.info_tabla_sin_info[index]['IN_Total_Ninas'],
							this.info_tabla_sin_info[index]['IN_Total_Ninos_0_3'],
							this.info_tabla_sin_info[index]['IN_Total_Ninos_3_6'],
							this.info_tabla_sin_info[index]['IN_Total_Ninas_3_6'],
							this.info_tabla_sin_info[index]['IN_Total_Ninas_3_6'],
							this.info_tabla_sin_info[index]['IN_Mujeres_Gestantes'],
							this.info_tabla_sin_info[index]['IN_Afrodescendiente'],
							this.info_tabla_sin_info[index]['IN_Campesina'],
							this.info_tabla_sin_info[index]['IN_Discapacidad'],
							this.info_tabla_sin_info[index]['IN_Conflicto'],
							this.info_tabla_sin_info[index]['IN_Indigena'],
							this.info_tabla_sin_info[index]['IN_Privados'],
							this.info_tabla_sin_info[index]['IN_Victimas'],
							this.info_tabla_sin_info[index]['IN_Raizal'],
							this.info_tabla_sin_info[index]['IN_Rom'],
							"<a href='"+this.info_tabla_sin_info[index]['VC_Documento_Soporte']+"' target='_blank'><button type='button' class='btn btn-success'><i class='fas fa-download'></i></button></a>"

							]).draw().node();
					});

				})
				.catch(error => {
					Swal.fire("Error", "No se pudieron obtener los contenidos disponbibles, por favor inténtelo nuevamente", "error");
				});
			},
			guardarBeneficiariosConInfo: function(e){
				e.preventDefault();
				let validado = 0;
				if(this.id_lugar_c == ""){
					Swal.fire("Error","Compruebe que ha seleccionado un lugar de atención","error");
				} else if(this.id_grupo_c == ""){
					Swal.fire("Error","Compruebe que ha seleccionado un grupo","error");
				} else if(this.ids_contenido_c == ""){
					Swal.fire("Error","Compruebe que ha al menos un contenido","error");
				} else{
					this.beneficiarios.forEach((beneficiario, index) => {
						if(beneficiario.tipo_documento == "" || beneficiario.genero == "" || beneficiario.enfoque == "" || beneficiario.estrato == ""){
							Swal.fire("Error", "Compruebe que ha diligenciado los listados de tipo de documento, género, enfoque y estrato de los beneficiarios", "error");
							validado = 1;
						}
					});
				}
				if(validado == 0){
					let ids = "";
					this.ids_contenido_c.forEach(function (item) { 
						ids += item.value + ",";
					});
					ids = ids.slice(0,-1);

					axios
					.post('/sif/framework/nidos/contenidos/guardarBeneficiariosConInfo', {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
						id_lugar: this.id_lugar_c["value"],
						id_grupo: this.id_grupo_c["value"],
						ids_contenido: ids,
						fecha_entrega_contenido: this.tx_fecha_entrega_c,
						beneficiarios: this.beneficiarios,
						id_persona: this.id_persona
					})
					.then(response => {
						Swal.fire("Exito", "Los datos se han guardado correctamente.", "success");
						this.limpiarFormulario(2);
					})
					.catch(error => {
						Swal.fire("Error", "No se pudo guardar la información de los beneficiarios, por favor vuelva a intentarlo", "error");
					});
				}
			},
			validarBeneficiarioRegistrado(id_beneficiario, index){
				axios
				.post("/sif/framework/nidos/beneficiarios/validarBeneficiarioRegistrado", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_beneficiario: id_beneficiario
				})
				.then(response => {
					if(response.data != ""){
						Swal.fire({
							confirmButtonColor: '#28a745',
							title: 'Alerta',
							html: 'Se ha encontrado un beneficiario con el número de documento suministrado, se cargará toda la información',
							type: 'success',
							confirmButtonText: 'Aceptar',
						}).then(() => {
							this.beneficiarios[index].tipo_documento = JSON.parse(response.data[0].tdoc);
							this.beneficiarios[index].primer_nombre = response.data[0].pnombre;
							this.beneficiarios[index].segundo_nombre = response.data[0].snombre;
							this.beneficiarios[index].primer_apellido = response.data[0].papellido;
							this.beneficiarios[index].segundo_apellido = response.data[0].sapellido;
							this.beneficiarios[index].fecha_nacimiento = response.data[0].fnacimiento;
							this.beneficiarios[index].genero = JSON.parse(response.data[0].genero);
							this.beneficiarios[index].enfoque = JSON.parse(response.data[0].enfoque);
							this.beneficiarios[index].estrato = JSON.parse(response.data[0].estrato);
							this.beneficiarios[index].existe = 1;
						}).catch(parent.swal.noop);
					}else{
						this.beneficiarios[index].tipo_documento = "";
						this.beneficiarios[index].primer_nombre = "";
						this.beneficiarios[index].segundo_nombre = "";
						this.beneficiarios[index].primer_apellido = "";
						this.beneficiarios[index].segundo_apellido = "";
						this.beneficiarios[index].fecha_nacimiento = "";
						this.beneficiarios[index].genero = "";
						this.beneficiarios[index].enfoque = "";
						this.beneficiarios[index].estrato = "";
						this.beneficiarios[index].existe = 0;
					}
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo validar la existencia del beneficiario, por favor inténtelo nuevamente", "error");
				});
			},
			getInformeBeneficiariosConInfo(){
				axios
				.post("/sif/framework/nidos/contenidos/getInformeBeneficiariosConInfo", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_mes: this.id_mes_c["value"],
					tipo_consulta: 1
				})
				.then(response => {
					this.info_tabla_con_info = response.data;	
					this.tabla_con_info.clear().draw();
					this.info_tabla_con_info.forEach((value, index) => {
						this.rowNode = this.tabla_con_info.row.add([
							this.info_tabla_con_info[index]["LOCALIDAD"],
							this.info_tabla_con_info[index]['UPZ'],
							this.info_tabla_con_info[index]['BARRIO'],
							this.info_tabla_con_info[index]['LUGAR_ATENCION'],
							this.info_tabla_con_info[index]['CONTENIDO'],
							this.info_tabla_con_info[index]['TOTAL_DE_0_3_ANIOS_R'],
							this.info_tabla_con_info[index]['TOTAL_DE_4_6_ANIOS_R'],
							this.info_tabla_con_info[index]['GESTANTES_R'],
							this.info_tabla_con_info[index]['AFRODESCENDIENTE_R'],
							this.info_tabla_con_info[index]['ROM_R'],
							this.info_tabla_con_info[index]['INDIGENA_R'],
							this.info_tabla_con_info[index]['CONFLICTO_R'],
							this.info_tabla_con_info[index]['DISCAPACIDAD_R'],
							this.info_tabla_con_info[index]['NINGUNO_R'],
							this.info_tabla_con_info[index]['PRIVADOS_R'],
							this.info_tabla_con_info[index]['RAIZALES_R'],
							this.info_tabla_con_info[index]['CAMPESINA_R'],
							this.info_tabla_con_info[index]['MUJERES_VICTIMAS_R'],
							this.info_tabla_con_info[index]['TOTAL_R']
							]).draw().node();
					});
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
				});
			},
			limpiarFormulario(formulario){
				if(formulario == 1){

					this.in_ninos_cero_tres = 0;
					this.in_ninas_cero_tres = 0;
					this.in_total_ninos_cero_tres = 0;
					this.in_ninos_cuatro_seis = 0;
					this.in_ninas_cuatro_seis = 0;
					this.in_total_ninos_cuatro_seis = 0;
					this.in_ninos_seis_seis = 0;
					this.in_ninas_seis_seis = 0;
					this.in_total_ninos_seis_seis = 0;
					this.in_gestantes = 0;
					this.in_total_gestantes = 0;
					this.in_total = 0;
					this.in_afro = "";
					this.in_rural = "";
					this.in_discapacidad = "";
					this.in_conflicto = "";
					this.in_indigena = "";
					this.in_libertad = "";
					this.in_violencia = "";
					this.in_raizal = "";
					this.in_rom = "";
					this.in_ninos_siete_diez = "";
					this.in_ninos_cero_tres_nuevos = 0;
					this.in_ninas_cero_tres_nuevos = 0;
					this.in_total_ninos_cero_tres_nuevos = 0;
					this.in_ninos_cuatro_seis_nuevos = 0;
					this.in_ninas_cuatro_seis_nuevos = 0;
					this.in_total_ninos_cuatro_seis_nuevos = 0;
					this.in_ninos_seis_seis_nuevos = 0;
					this.in_ninas_seis_seis_nuevos = 0;
					this.in_total_ninos_seis_seis_nuevos = 0;
					this.in_gestantes_nuevos = 0;
					this.in_total_gestantes_nuevos = 0;
					this.in_total_nuevos = 0;
					this.in_afro_nuevos = "";
					this.in_rural_nuevos = "";
					this.in_discapacidad_nuevos = "";
					this.in_conflicto_nuevos = "";
					this.in_indigena_nuevos = "";
					this.in_libertad_nuevos = "";
					this.in_violencia_nuevos = "";
					this.in_raizal_nuevos = "";
					this.in_rom_nuevos = "";
					this.in_ninos_siete_diez_nuevos = "";

					this.id_lugar_s = "";
					this.id_grupo_s = "";
					this.ids_contenido_s = "";
					this.tx_fecha_entrega_s = "";
					this.id_lugar_s = "";
					this.id_grupo_s = "";
					this.localidad_s = "";
					this.upz_s = "";
					this.entidad_s = "";
					this.barrio_s = "";
				}else{
					this.id_lugar_c = "";
					this.id_grupo_c = "";
					this.ids_contenido_c = "";
					this.tx_fecha_entrega_c = "";
					this.localidad_c = "";
					this.upz_c = "";
					this.entidad_c = "";
					this.barrio_c = "";
					this.beneficiarios = [{
						identificacion: "",
						tipo_documento: "",
						primer_nombre: "",
						segundo_nombre: "",
						primer_apellido: "",
						segundo_apellido: "",
						fecha_nacimiento: "",
						genero: "",
						enfoque: "",
						estrato: "",
						existe: 0
					}];
				}
			},
			getListadoCifras(){
				axios
				.post("/sif/framework/nidos/contenidos/getListadoCifras", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_persona: this.id_persona
				})
				.then(response => {
					this.options_cifras_m = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
				});
			},
			getInfoCifras(){
				axios
				.post("/sif/framework/nidos/contenidos/getInfoCifras", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_cifra: this.id_cifra_m["value"]
				})
				.then(response => {
					this.in_ninos_cero_tres_s_m = response.data[0]["IN_Total_Ninos_0_3"];
					this.in_ninas_cero_tres_s_m = response.data[0]["IN_Total_Ninas_0_3"];
					this.in_total_ninos_cero_tres_s_m = response.data[0]["IN_Total_Ninos_0_3"] + response.data[0]["IN_Total_Ninas_0_3"];

					this.in_ninos_cuatro_seis_s_m = response.data[0]["IN_Total_Ninos_3_6"];
					this.in_ninas_cuatro_seis_s_m = response.data[0]["IN_Total_Ninas_3_6"];
					this.in_total_ninos_cuatro_seis_s_m = response.data[0]["IN_Total_Ninos_3_6"] + response.data[0]["IN_Total_Ninas_3_6"]

					this.in_ninos_seis_seis_s_m = response.data[0]["IN_Total_Ninos_6"];
					this.in_ninas_seis_seis_s_m = response.data[0]["IN_Total_Ninas_6"];
					this.in_total_ninos_seis_seis_s_m = response.data[0]["IN_Total_Ninos_6"] + response.data[0]["IN_Total_Ninas_6"]

					this.in_gestantes_s_m = response.data[0]["IN_Mujeres_Gestantes"];
					this.in_total_gestantes_s_m = response.data[0]["IN_Mujeres_Gestantes"];

					this.in_total_s_m = response.data[0]["IN_Total_Beneficiarios"];

					this.in_afro_s_m = response.data[0]["IN_Afrodescendiente"];
					this.in_rural_s_m = response.data[0]["IN_Campesina"];
					this.in_discapacidad_s_m = response.data[0]["IN_Discapacidad"];
					this.in_conflicto_s_m = response.data[0]["IN_Conflicto"];
					this.in_indigena_s_m = response.data[0]["IN_Indigena"];
					this.in_libertad_s_m = response.data[0]["IN_Privados"];
					this.in_violencia_s_m = response.data[0]["IN_Victimas"];
					this.in_raizal_s_m = response.data[0]["IN_Raizal"];
					this.in_rom_s_m = response.data[0]["IN_Rom"];
					this.in_ninos_siete_diez_s_m = response.data[0]["IN_Discapacidad_7_10"];

					this.in_ninos_cero_tres_nuevos_s_m = response.data[0]["IN_Total_Ninos_0_3_Nuevos"];
					this.in_ninas_cero_tres_nuevos_s_m = response.data[0]["IN_Total_Ninas_0_3_Nuevos"];
					this.in_total_ninos_cero_tres_nuevos_s_m = response.data[0]["IN_Total_Ninos_0_3_Nuevos"] + response.data[0]["IN_Total_Ninas_0_3_Nuevos"];

					this.in_ninos_cuatro_seis_nuevos_s_m = response.data[0]["IN_Total_Ninos_3_6_Nuevos"];
					this.in_ninas_cuatro_seis_nuevos_s_m = response.data[0]["IN_Total_Ninas_3_6_Nuevos"];
					this.in_total_ninos_cuatro_seis_nuevos_s_m = response.data[0]["IN_Total_Ninos_3_6_Nuevos"] + response.data[0]["IN_Total_Ninas_3_6_Nuevos"]

					this.in_ninos_seis_seis_nuevos_s_m = response.data[0]["IN_Total_Ninos_6_Nuevos"];
					this.in_ninas_seis_seis_nuevos_s_m = response.data[0]["IN_Total_Ninas_6_Nuevos"];
					this.in_total_ninos_seis_seis_nuevos_s_m = response.data[0]["IN_Total_Ninos_6_Nuevos"] + response.data[0]["IN_Total_Ninas_6_Nuevos"]

					this.in_gestantes_nuevos_s_m = response.data[0]["IN_Mujeres_Gestantes_Nuevos"];
					this.in_total_gestantes_nuevos_s_m = response.data[0]["IN_Mujeres_Gestantes_Nuevos"];

					this.in_total_nuevos_s_m = response.data[0]["IN_Total_Beneficiarios_Nuevos"];

					this.in_afro_nuevos_s_m = response.data[0]["IN_Afrodescendiente_Nuevo"];
					this.in_rural_nuevos_s_m = response.data[0]["IN_Campesina_Nuevo"];
					this.in_discapacidad_nuevos_s_m = response.data[0]["IN_Discapacidad_Nuevo"];
					this.in_conflicto_nuevos_s_m = response.data[0]["IN_Conflicto_Nuevo"];
					this.in_indigena_nuevos_s_m = response.data[0]["IN_Indigena_Nuevo"];
					this.in_libertad_nuevos_s_m = response.data[0]["IN_Privados_Nuevo"];
					this.in_violencia_nuevos_s_m = response.data[0]["IN_Victimas_Nuevo"];
					this.in_raizal_nuevos_s_m = response.data[0]["IN_Raizal_Nuevo"];
					this.in_rom_nuevos_s_m = response.data[0]["IN_Rom_Nuevo"];
					this.in_ninos_siete_diez_nuevos_s_m = response.data[0]["IN_Discapacidad_7_10_Nuevo"];

					this.id_lugar_s_m = JSON.parse(response.data[0]["lugar"]);
					this.getGruposInfoLugar(this.id_lugar_s_m, 3);

					this.id_grupo_s_m = JSON.parse(response.data[0]["grupo"])	;

					this.tx_fecha_entrega_s_m = response.data[0]["DT_Fecha_Entrega"];

					this.ids_contenido_s_m = JSON.parse(response.data[0]["contenidos"]);

					this.documento_soporte = response.data[0]["VC_Documento_Soporte"];

				})
.catch(error => {
	Swal.fire("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
});
}
}
}

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style type="text/css">
@media(max-width: 1366px){
	th, td{
		font-size: 0.8rem !important;
	}
	.form-control{
		font-size: 0.8rem !important;
	}
	.multiselect, .multiselect__tags, .multiselect__input, .multiselect__single {
		font-size: 0.8rem !important;
	}
}
table.dataTable thead th, table.dataTable thead td {
	padding: 10px 5px !important;
	border-bottom: 1px solid #111111;
}
</style>