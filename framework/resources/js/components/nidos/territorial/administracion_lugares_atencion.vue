<template>
	<div>
		<h2>Administración lugares de atención</h2>
		<br>
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#creacion-lugar" role="tab" aria-controls="creacion-lugar" aria-selected="true">Creación</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-lugar" role="tab" aria-controls="consulta-lugar" aria-selected="false">Consulta</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#modificacion-lugar" role="tab" aria-controls="modificacion-lugar" aria-selected="false">Modificación</a></li>
		</ul>
		<div class="tab-content">
			<div id="creacion-lugar" class="tab-pane fade show active"><br>

				<div class="card col-lg-8 offset-lg-2">
					<div class="card-body">
						<form id="form_nuevo_lugar_nidos">
					<!-- <div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Creación Lugar Atención</h4>
						</div>
					</div> -->
					<!-- <fieldset> -->
						<!-- <h3>  <label>Territorio de:</label> <font color="teal"><label class="TX_NombreTerritorio" for="TX_NombreTerritorio"></label> </font></h3>-->
						

						<div class="form-group">
							<div class="col-lg-12">
								<div class="row">
									<h4>Datos lugar de atención</h4> 
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-12">
								<div class="p-3 mb-2 bg-info text-white">Territorio asignado: Bosa</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-12">
								<!-- <label>Localidad:</label> -->
								<!-- <multiselect v-model="value" :options="options" :searchable="true" :show-labels="false" placeholder=""></multiselect> -->
								<multiselect :options="options" placeholder="Localidad" :show-labels="false" id="sl-localidad-lugar"></multiselect>

								<!-- <multiselect v-model="id_categoria" @input="getContenidosPorCategoria()" label="text" :options="options_categoria" placeholder="Seleccione una opción" :show-labels="false" track-by="value" id="sl-categoria" name="sl-categoria"></multiselect> -->


								<!-- <select class="form-control" name="SL_Localidad" id="SL_Localidad" title="Seleccione una localidad"></select> -->
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<!-- <label>Upz:</label> -->
								<multiselect :options="options" placeholder="Upz" :show-labels="false" id="sl-upz-lugar"></multiselect>
								<!-- <select class="form-control" name="SL_Upz" id="SL_Upz" title="Seleccione una upz"></select> -->
							</div>
						</div>
						<!-- <div class="form-group">
							<div class="col-lg-6">
								<label>Upz:</label>
								<select class="form-control" name="SL_Upz" id="SL_Upz" title="Seleccione una upz"></select>
							</div>
						</div> -->
						<div class="form-group">
							<div class="col-lg-12">
								<multiselect :options="options" placeholder="Entidad" :show-labels="false" id="sl-entidad-lugar"></multiselect>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<!-- <label>Tipo de Lugar:</label> -->
								<multiselect :options="options" placeholder="Tipo de lugar" :show-labels="false" id="sl-tipo-lugar"></multiselect>
								<!-- <select class="form-control" name="SL_TLugar" id="SL_TLugar" title="Seleccione un tipo de lugar"></select> -->
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-12">
								<input v-model="barrio_lugar" @input="barrio_lugar=barrio_lugar.toUpperCase()" type="text" class="form-control" placeholder="Barrio" id="tx-barrio-lugar" required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-12">
								<input v-model="nombre_lugar" @input="nombre_lugar=nombre_lugar.toUpperCase()" type="text" class="form-control" placeholder="Nombre" id="tx-nombre-lugar" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<input v-model="direccion_lugar" @input="direccion_lugar=direccion_lugar.toUpperCase()" type="text" class="form-control" placeholder="Dirección" id="tx-direccion-lugar" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<input v-model="telefono_lugar" @input="telefono_lugar=telefono_lugar.toUpperCase()" type="number" class="form-control" placeholder="Teléfono" id="tx-telefono-lugar" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<input v-model="coordinador_lugar" @input="coordinador_lugar=coordinador_lugar.toUpperCase()" type="text" class="form-control" placeholder="Coordinador(a) responsable" id="tx-coordinador-lugar" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<input v-model="email_coordinador" type="email" class="form-control" placeholder="Email coordinador(a) responsable" id="tx-email-coordinador" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<input v-model="celular_coordinador" type="number" class="form-control" placeholder="Celular coordinador(a) responsable" id="tx-celular-coordinador" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-8 offset-lg-2">
								<button class="btn btn-block btn-primary" type="submit">Crear lugar</button>
							</div>
						</div>
					</form>
				</div>
			</div>




		</div>
		<div id="consulta-lugar" class="tab-pane"><br>
		</div>
		<div id="modificacion-lugar" class="tab-pane"><br>
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
				barrio_lugar: "",
				nombre_lugar: "",
				direccion_lugar: "",
				telefono_lugar: "",
				coordinador_lugar: "",
				email_coordinador: "",
				celular_coordinador: "",
				options: ['Select option', 'options', 'selected', 'mulitple', 'label', 'searchable', 'clearOnSelect', 'hideSelected', 'maxHeight', 'allowEmpty', 'showLabels', 'onChange', 'touched'],
				value: ""
			}
		},
		mounted() {
			this.getIdPersona();
		},
		methods: {
			getIdPersona(){
				axios
				.post("/sif/framework/getIdPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.id_persona = response.data;
					//this.getTerritorioPersona();
					this.getOptionLocalidadGestor();
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
					console.log(this.id_territorio);
					// this.getLugaresTerritorio();
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el territorio de la persona, por favor inténtelo nuevamente", "error");
				});
			},
			getOptionLocalidadGestor(){
				axios
				.post("/sif/framework/nidos/lugares/getOptionLocalidadGestor", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_persona: this.id_persona
				})
				.then(response => {
					console.log(response.data)
					//this.options_mes = response.data;
				})
				.catch(error => {
					//Swal.fire("Error", "No se pudo obtener el listado de meses, por favor inténtelo nuevamente", "error");
				});
			}
		}
	}
</script>