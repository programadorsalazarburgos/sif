<template>
	<div class="col-lg-10 offset-lg-1">
		<div class="form-row">
			<div class="form-group col-lg-12">
				<br>
				<h2>Administración oferta disponible</h2>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="form-row">
					<div class="form-group col-lg-8 offset-lg-2">
						<label>Crea</label>
						<multiselect v-model="form_aprobar.crea" label="text" :options="options_crea" @input="getGrupos()" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
					</div>
					<div class="form-group col-lg-8 offset-lg-2">
						<label>Grupo</label>
						<multiselect v-model="id_grupo" label="text" :options="options_grupo" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-lg-8 offset-lg-2">
						<button class="btn btn-block btn-primary" type="button" @click="getPreinscritosGrupo()">Consultar</button>
					</div>
				</div>
				<div class="p-3 mb-2 bg-info text-white">
					<label><strong>Cupos totales:</strong></label> {{cupos_totales}}<br>
					<label><strong>Cupos disponibles:</strong></label> {{cupos_disponibles}}
				</div>
				<br>
				<br>
				<div class="form-row">
					<div class="form-group col-lg-12">
						<table class="table-sm table-bordered table-hover display" id="tablaPreinscritos" style="width:100%">
							<thead>
								<tr>
									<th>Identificación</th>
									<th>Nombres</th>
									<th>Correo</th>
									<th>Celular</th>
									<th>Fecha de solicitud</th>
									<th>Archivos</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(beneficiario, index) in beneficiarios">
									<td>{{ beneficiario.numero_documento }}</td>
									<td>{{ beneficiario.primer_nombre }} {{ beneficiario.primer_apellido }}</td>
									<td>{{ beneficiario.correo }}</td>
									<td>{{ beneficiario.celular }}</td>
									<td>{{ beneficiario.fecha_solicitud }}</td>
									<td>
										<div class="row">
											<div class="col-lg-4">
												<a v-bind:href="beneficiario.archivo_documento_identidad" target="_blank" class="btn btn-block btn-secondary" data-toggle="tooltip" data-placement="top" title="Documento de identidad"><i class="fas fa-id-card"></i></a>
											</div>
											<div class="col-lg-4">
												<a v-bind:href="beneficiario.archivo_eps" target="_blank" class="btn btn-block btn-secondary" data-toggle="tooltip" data-placement="top" title="Certificado de EPS"><i class="fas fa-book-medical"></i></a>
											</div>
											<div class="col-lg-4">
												<a v-bind:href="beneficiario.archivo_recibo_publico" target="_blank" class="btn btn-block btn-secondary" data-toggle="tooltip" data-placement="top" title="Recibo de servicio público"><i class="fas fa-tint"></i></a>
											</div>
										</div>
									</td>
									<td>
										<div class="row justify-content-center">
											<div class="px-1" v-if="cupos_disponibles != 0">
												<button v-if="beneficiario.grupo_existente == null" class="btn btn-block btn-success aprobar" @click="cargarDatosFormulario" id="aprobarPreinscripcion" :data-index="index" data-toggle="modal" data-target="#modalAprobar" data-placement="top" title="Aprobar preinscripción"><i class="fas fa-user-plus"></i></button>
												<span v-if="beneficiario.grupo_existente != null" class="btn btn-info">En grupo {{ beneficiario.grupo_existente }}</span>
											</div>
											<div class="px-1" v-bind:class="{ 'offset-lg-3': cupos_disponibles == 0 }">
												<button class="btn btn-block btn-danger" @click="cargarDatosFormulario" id="rechazarPreinscripcion" :data-index="index" data-toggle="modal" data-target="#modalRechazar" data-placement="top" title="Rechazar preinscripción" ><i class="fas fa-user-times"></i></button>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal aprobar-->
		<div class="modal fade" id="modalAprobar" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Aprobación preinscripción</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit="aprobarPreinscripcion">
						<div class="modal-body">
							<div class="card mb-3">
								<div class="card-header bg-secondary">1. Datos personales</div>
								<div class="card-body">
									<div class="form-row">
										<div class="form-group col-lg-6">
											<label class="required">Tipo de documento</label>
											<multiselect v-model="form_aprobar.tipo_documento" label="text" :options="options_tipo_documento" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
										</div>
										<div class="form-group col-lg-6">
											<label class="required">Número de documento</label>
											<input v-model="form_aprobar.numero_documento" class="form-control" type="number" required>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6">
											<label class="required">Primer nombre</label>
											<input v-model="form_aprobar.primer_nombre" class="form-control" type="text" required @input="form_aprobar.primer_nombre=form_aprobar.primer_nombre.toUpperCase();">
										</div>
										<div class="form-group col-lg-6">
											<label>Segundo nombre</label>
											<input v-model="form_aprobar.segundo_nombre" class="form-control" type="text" @input="form_aprobar.segundo_nombre=form_aprobar.segundo_nombre.toUpperCase();">
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6">
											<label class="required">Primer apellido</label>
											<input v-model="form_aprobar.primer_apellido" class="form-control" type="text" required @input="form_aprobar.primer_apellido=form_aprobar.primer_apellido.toUpperCase();">
										</div>
										<div class="form-group col-lg-6">
											<label>Segundo apellido</label>
											<input v-model="form_aprobar.segundo_apellido" class="form-control" type="text" @input="form_aprobar.segundo_apellido=form_aprobar.segundo_apellido.toUpperCase();">
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6">
											<label class="required">Fecha de nacimiento</label>
											<input v-model="form_aprobar.fecha_nacimiento" class="form-control" type="date" v-bind:max="hoy" required>
										</div>
										<div class="form-group col-lg-6">
											<label class="required">Género</label>
											<multiselect v-model="form_aprobar.genero" label="text" :options="options_genero" placeholder="Seleccione una opción" :show-labels="false" track-by="value">
											</multiselect>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6">
											<label class="required">Estrato</label>
											<multiselect v-model="form_aprobar.estrato" label="text" :options="options_estrato" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
										</div>
										<div class="form-group col-lg-6">
											<label class="required">Grupo poblacional</label>
											<multiselect v-model="form_aprobar.grupo_poblacional" label="text" :options="options_grupo_poblacional" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
										</div>
									</div>
								</div>
							</div>
							<div class="card mb-3">
								<div class="card-header bg-secondary">2. Salud</div>
								<div class="card-body">
									<div class="form-row">
										<div class="form-group col-lg-4">
											<label>Tipo afiliación</label>
											<multiselect v-model="form_aprobar.tipo_afiliacion_eps" label="text" :options="options_tipo_afiliacion_eps" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
										</div>
										<div class="form-group col-lg-4">
											<label>Eps</label>
											<multiselect v-model="form_aprobar.eps" label="text" :options="options_eps" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
										</div>
										<div class="form-group col-lg-4">
											<label class="required">Grupo sanguíneo y RH</label>
											<multiselect v-model="form_aprobar.grupo_sanguineo" label="text" :options="options_grupo_sanguineo" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-12">
											<label>Enfermedades</label>
											<textarea v-model="form_aprobar.enfermedades" class="form-control"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="card mb-3">
								<div class="card-header bg-secondary">3. Información del acudiente</div>
								<div class="card-body">
									<div class="form-row">
										<div class="form-group col-lg-4">
											<label>Nombre</label>
											<input v-model="form_aprobar.nombre_acudiente" class="form-control" type="text">
										</div>
										<div class="form-group col-lg-4">
											<label>Número de documento</label>
											<input v-model="form_aprobar.numero_documento_acudiente" class="form-control" type="text">
										</div>
										<div class="form-group col-lg-4">
											<label>Celular</label>
											<input v-model="form_aprobar.celular_acudiente" class="form-control" type="number">
										</div>
									</div>

								</div>
							</div>
							<div class="card mb-3">
								<div class="card-header bg-secondary">4. Georeferenciación</div>
								<div class="card-body">
									<div class="form-row">
										<div class="form-group col-lg-6">
											<label class="required">Localidad</label>
											<multiselect v-model="form_aprobar.localidad" label="text" :options="options_localidad" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
										</div>
										<div class="form-group col-lg-6">
											<label class="required">Barrio</label>
											<input v-model="form_aprobar.barrio" class="form-control" type="text" required>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6">
											<label class="required">Dirección</label>
											<input v-model="form_aprobar.direccion" class="form-control" type="text" required>
										</div>
										<div class="form-group col-lg-6">
											<label class="required">Correo</label>
											<input v-model="form_aprobar.correo" class="form-control" type="email" required>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6">
											<label>Teléfono fijo</label>
											<input v-model="form_aprobar.telefono_fijo" class="form-control" type="number">
										</div>
										<div class="form-group col-lg-6">
											<label class="required">Celular</label>
											<input v-model="form_aprobar.celular" class="form-control" type="number" required>
										</div>
									</div>

								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" ref="cerrarModalAprobar" data-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-primary">Aprobar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Modal rechazar -->
		<div class="modal fade" id="modalRechazar" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Rechazar preinscripción</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit="rechazarPreinscripcion">
						<div class="modal-body">
							<div class="form-row">
								<div class="form-group col-lg-12">
									<label class="required">Razón rechazo</label>
									<multiselect v-model="form_rechazar.razon_rechazo" label="text" :options="options_rechazo" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
								</div>
								<div class="form-group col-lg-12">
									<label class="required">Observaciones</label>
									<textarea v-model="form_rechazar.justificacion_rechazo" class="form-control" required></textarea>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" ref="cerrarModalRechazo" data-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-primary">Rechazar</button>
						</div>
					</form>
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
				//formulario aprobar preinscripcion
				form_aprobar:{
					tipo_documento: null,
					numero_documento: null,
					primer_nombre: null,
					segundo_nombre: null,
					primer_apellido: null,
					segundo_apellido: null,
					fecha_nacimiento: null,
					direccion: null,
					correo: null,
					telefono_fijo: null,
					celular: null,
					localidad: null,
					barrio: null,
					genero: null,
					estrato: null,
					grupo_poblacional: null,
					archivo_documento_identidad: null,
					archivo_eps: null,
					archivo_recibo_publico: null,
					autorizacion_imagen: null,
					autorizacion_datos: null,
					grupo_sanguineo: null,
					eps: null,
					tipo_afiliacion_eps: null,
					enfermedades: null,
					nombre_acudiente: null,
					numero_documento_acudiente: null,
					celular_acudiente: null,
					crea: null,
					grupo: null,
					modalidad: null
				},

				//formulario rechazar preinscripcion
				form_rechazar:{
					razon_rechazo: "",
					justificacion_rechazo: "",
					nombre: "",
					correo: "",
					modalidad: "",
					grupo: ""
				},

				//variables funcionamiento formulario
				id: "",
				beneficiarios: "",
				cupos_totales: "",
				cupos_disponibles: "",
				hoy: "",
				id_persona: "",
				id_grupo: "",

				//variables para opciones de listado
				options_crea: [],
				options_grupo: [],
				options_tipo_documento: [],
				options_estrato: [],
				options_localidad: [],
				options_grupo_poblacional: [],
				options_genero: [],
				options_grupo_sanguineo: [],
				options_eps: [],
				options_tipo_afiliacion_eps: [],
				options_rechazo: [
				{value: "Documentación incompleta", text: "Documentación incompleta"},
				{value: "Documentación errónea", text: "Documentación errónea"},
				{value: "No cumple los requisitos", text: "No cumple los requisitos"},
				{value: "Información errónea", text: "Información errónea"},
				{value: "Sin cupos disponibles", text: "Sin cupos disponibles"},
				{value: "Inscrito en otro grupo", text: "Inscrito en otro grupo"}
				]
			}
		},
		mounted() {

			const vm = this;

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

			this.getCreas();
			this.getIdPersona();
			this.getParametroDetalle(5, "tipos de documento");
			this.getParametroDetalle(14, "grupos poblacionales");
			this.getParametroDetalle(15, "grupos sanguíneos y RH");
			this.getParametroDetalle(16, "EPS");
			this.getParametroDetalle(17, "géneros");
			this.getParametroDetalle(19, "localidades");
			this.getParametroDetalle(53, "estratos");
			this.getParametroDetalle(70, "tipos de afiliación a eps");
		},
		methods: {
			getCreas(){
				axios
				.post("/sif/framework/options/getCentrosCrea", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.options_crea = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de creas, por favor inténtelo nuevamente", "error");
				});
			},
			getGrupos(){
				axios 
				.post("/sif/framework/crea/territorial/oferta/getGrupos", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"id_crea": this.form_aprobar.crea["value"]
				})
				.then(response => {
					this.options_grupo = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de grupos, por favor inténtelo nuevamente", "error");
				});
			},
			getPreinscritosGrupo(){
				if(this.form_aprobar.crea == "" || this.id_grupo == ""){
					Swal.fire("Error", "Compruebe que ha seleccionado el crea y el grupo, por favor inténtelo nuevamente", "error");
				}else{
					Swal.fire({
						title: "Cargando información",
						text: "Espere un poco por favor.",
						imageUrl: "/sif/framework/public/images/cargando.gif",
						imageWidth: 140,
						imageHeight: 70,
						showConfirmButton: false,
					});
					axios
					.post("/sif/framework/crea/territorial/oferta/getCuposGrupo", {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
						"id_grupo": this.id_grupo["value"]
					})
					.then(response => {
						this.cupos_totales = response.data["IN_cupos"];
						this.cupos_disponibles = response.data["IN_cupos"] - response.data["IN_cupos_disponibles"];
					})
					.catch(error => {
						Swal.fire("Error", "No se pudo obtener los cupos disponibles, por favor inténtelo nuevamente", "error");
					});

					axios
					.post("/sif/framework/crea/territorial/oferta/getPreinscritosGrupo", {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
						"id_grupo": this.id_grupo["value"]
					})
					.then(response => {

						this.beneficiarios = response.data;

						if($.fn.DataTable.isDataTable("#tablaPreinscritos")) 
							$("#tablaPreinscritos").DataTable().destroy();

						setTimeout(function(){
							$("#tablaPreinscritos").DataTable({
								responsive: true,
								pageLength: 50,
								//dom: 'Blfrtip',
								ordering: false,
								//buttons: [{
								//extend: 'excel',
								//text: 'Descargar datos',
								//filename: 'Datos'
								//}],
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
							});
							Swal.close();
						}, 500);

					})
					.catch(error => {
						Swal.fire("Error", "No se pudo obtener el listado de preinscritos, por favor inténtelo nuevamente", "error");
					});
				}
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
			cerrarModal(){
				this.$refs.cerrarModalRechazo.click();
				this.$refs.cerrarModalAprobar.click();
			},
			getParametroDetalle(FK_Id_Parametro, tipo_listado){
				//5 tipo documento
				//14 grupo poblacional
				//15 grupo sanguineo y rh
				//16 eps
				//17 género
				//19 localidades
				//53 estratos
				//70 tipo afiliacion eps
				axios
				.post("/sif/framework/options/getParametroDetalle", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"FK_Id_Parametro": FK_Id_Parametro
				})
				.then(response => {
					switch(FK_Id_Parametro){
						case 5:
						this.options_tipo_documento = response.data;
						break;
						case 14:
						this.options_grupo_poblacional = response.data;
						break;
						case 15:
						this.options_grupo_sanguineo = response.data;
						break;
						case 16:
						this.options_eps = response.data;
						break;
						case 17:
						this.options_genero = response.data;
						break;
						case 19:
						this.options_localidad = response.data;
						break;
						case 53:
						this.options_estrato = response.data;
						break;
						case 70:
						this.options_tipo_afiliacion_eps = response.data;
						break;
					}
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de "+tipo_listado+", por favor inténtelo nuevamente", "error");
				});
			},
			cargarDatosFormulario: function(e){
				let id_elemento = e.currentTarget.getAttribute("id");
				let index = e.currentTarget.getAttribute("data-index");

				this.id = this.beneficiarios[index]["id"];

				if(id_elemento == "aprobarPreinscripcion"){
					this.form_aprobar.numero_documento = this.beneficiarios[index]["numero_documento"];
					this.form_aprobar.primer_nombre = this.beneficiarios[index]["primer_nombre"];
					this.form_aprobar.segundo_nombre = this.beneficiarios[index]["segundo_nombre"];
					this.form_aprobar.primer_apellido = this.beneficiarios[index]["primer_apellido"];
					this.form_aprobar.segundo_apellido = this.beneficiarios[index]["segundo_apellido"];
					this.form_aprobar.fecha_nacimiento = this.beneficiarios[index]["fecha_nacimiento"];
					this.form_aprobar.direccion = this.beneficiarios[index]["direccion"];
					this.form_aprobar.correo = this.beneficiarios[index]["correo"];
					this.form_aprobar.telefono_fijo = this.beneficiarios[index]["telefono_fijo"];
					this.form_aprobar.celular = this.beneficiarios[index]["celular"];
					this.form_aprobar.barrio = this.beneficiarios[index]["barrio"];
					this.form_aprobar.archivo_documento_identidad = this.beneficiarios[index]["archivo_documento_identidad"];
					this.form_aprobar.archivo_eps = this.beneficiarios[index]["archivo_eps"];
					this.form_aprobar.archivo_recibo_publico = this.beneficiarios[index]["archivo_recibo_publico"];
					this.form_aprobar.autorizacion_imagen = this.beneficiarios[index]["autorizacion_imagen"];
					this.form_aprobar.autorizacion_datos = this.beneficiarios[index]["autorizacion_datos"];
					this.form_aprobar.grupo = this.beneficiarios[index]["grupo"];
					this.form_aprobar.modalidad = this.beneficiarios[index]["modalidad"];

					this.options_tipo_documento.forEach((val, ind) => {
						if(this.options_tipo_documento[ind]["value"] == this.beneficiarios[index]["tipo_documento"]){
							this.form_aprobar.tipo_documento = this.options_tipo_documento[ind];
						}
					});

					this.options_localidad.forEach((val, ind) => {
						if(this.options_localidad[ind]["value"] == this.beneficiarios[index]["localidad"]){
							this.form_aprobar.localidad  = this.options_localidad[ind];
						}
					});

					this.options_genero.forEach((val, ind) => {
						if(this.options_genero[ind]["value"] == this.beneficiarios[index]["genero"]){
							this.form_aprobar.genero  = this.options_genero[ind];
						}
					});

					this.options_estrato.forEach((val, ind) => {
						if(this.options_estrato[ind]["value"] == this.beneficiarios[index]["estrato"]){
							this.form_aprobar.estrato  = this.options_estrato[ind];
						}
					});

					this.options_grupo_poblacional.forEach((val, ind) => {
						if(this.options_grupo_poblacional[ind]["value"] == this.beneficiarios[index]["grupo_poblacional"]){
							this.form_aprobar.grupo_poblacional  = this.options_grupo_poblacional[ind];
						}
					});
				}else{
					this.form_rechazar.nombre = this.beneficiarios[index]["primer_nombre"] + " " + this.beneficiarios[index]["primer_apellido"];
					this.form_rechazar.correo = this.beneficiarios[index]["correo"];
					this.form_rechazar.modalidad = this.beneficiarios[index]["modalidad"];
					this.form_rechazar.grupo = this.beneficiarios[index]["grupo"];
				}
			},
			aprobarPreinscripcion: function(e){
				e.preventDefault();

				if(this.form_aprobar.tipo_documento == "" || this.form_aprobar.tipo_documento == null){
					Swal.fire("Error", "Compruebe que ha seleccionado el tipo de documento", "warning");
				}else if(this.form_aprobar.localidad == "" || this.form_aprobar.localidad == null){
					Swal.fire("Error", "Compruebe que ha seleccionado el localidad de residencia", "warning");
				}else if(this.form_aprobar.genero == "" || this.form_aprobar.genero == null){
					Swal.fire("Error", "Compruebe que ha seleccionado el género", "warning");
				}else if(this.form_aprobar.estrato == "" || this.form_aprobar.estrato == null){
					Swal.fire("Error", "Compruebe que ha seleccionado el estrato de su residencia", "warning");
				}else if(this.form_aprobar.grupo_poblacional == "" || this.form_aprobar.grupo_poblacional == null){
					Swal.fire("Error", "Compruebe que ha seleccionado el grupo poblacional", "warning");
				}else if(this.form_aprobar.grupo_sanguineo == "" || this.form_aprobar.grupo_sanguineo == null){
					Swal.fire("Error", "Compruebe que ha seleccionado el grupo sanguíneo y RH", "warning");
				}else{
					Swal.fire({
						title: "Aprobando preinscripción",
						text: "Espere un poco por favor.",
						imageUrl: "/sif/framework/public/images/cargando.gif",
						imageWidth: 140,
						imageHeight: 70,
						showConfirmButton: false,
					});
					axios
					.post("/sif/framework/crea/territorial/oferta/aprobarPreinscripcion", {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
						"form_aprobar": JSON.stringify(this.form_aprobar),
						"id": this.id,
						"id_persona": this.id_persona
					})
					.then(response => {
						Swal.close();
						Swal.fire("Éxito", "Se ha aprobado la preinscripción correctamente", "success");
						setTimeout(() => {
							this.cerrarModal();
							Object.keys(this.form_aprobar).forEach( key => {
								if(key != "crea")
									this.form_aprobar[key] = null;
							});
							this.getPreinscritosGrupo();
						}, 700);

					})
					.catch(error => {
						Swal.fire("Error", "No se pudo aprobar la preinscripción, por favor inténtelo nuevamente", "error");
					});
				}
			},
			rechazarPreinscripcion: function(e){
				e.preventDefault();

				if(this.form_rechazar.razon_rechazo == ""){
					Swal.fire("Error", "Compruebe que ha seleccionado una razón de rechazo", "warning");
				}else{
					Swal.fire({
						title: "Rechazando preinscripción",
						text: "Espere un poco por favor.",
						imageUrl: "/sif/framework/public/images/cargando.gif",
						imageWidth: 140,
						imageHeight: 70,
						showConfirmButton: false,
					});

					axios
					.post("/sif/framework/crea/territorial/oferta/rechazarPreinscripcion", {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
						"form_rechazar": JSON.stringify(this.form_rechazar),
						"id": this.id,
						"id_persona": this.id_persona
					})
					.then(response => {
						Swal.close();
						Swal.fire("Éxito", "Se ha rechazado la preinscripción correctamente", "success");
						setTimeout(() => {
							this.cerrarModal();
							this.getPreinscritosGrupo();
							Object.keys(this.form_rechazar).forEach( key => {
								this.form_rechazar[key] = "";
							});
						}, 700);
					})
					.catch(error => {
						Swal.fire("Error", "No se pudo rechazar la preinscripción, por favor inténtelo nuevamente", "error");
					});
				}
			}
		}
	}
</script>