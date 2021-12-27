<template>
	<div class="col-lg-12 pt-3">
		<div class="card">
            <div class="card-header">
                <h1>Getión de Formularios de Inscripción</h1>
				<h5>Nidos - Talento Humano</h5>
            </div>
			<div class="card-body">
				<div class="form-row">
					<div class="form-group col-lg-3">
						<label>Área de Experiencia</label>
						<multiselect v-model="area_experiencia" label="text" :options="options_area_experiencia" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
					</div>
					<div class="form-group col-lg-3">
						<label>Experiencia en Nidos</label>
						<multiselect v-model="experiencia_nidos" label="text" :options="options_sino" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
					</div>
					<div class="form-group col-lg-3">
						<label>Experiencia con infancia</label>
						<multiselect v-model="experiencia_infancia" label="text" :options="options_sino" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
					</div>
					<div class="form-group col-lg-3">
						<label>Seleccionado</label>
						<multiselect v-model="estado" label="text" :options="options_estado" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-lg-4 offset-lg-4">
						<button class="btn btn-block btn-primary" type="button" @click="getHojasVida()">Consultar</button>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-lg-12">
						<div class="table-responsive"> 
							<table class="table-sm table-bordered table-hover display" id="tablaInscritos" style="width:100%; font-size:small">
								<thead>								
									<tr>
										<th>Fecha de solicitud</th>
										<th>Nombres</th>
										<th>Identificación</th>
										<th>Localidad/Municipio</th>
										<th>Teléfono</th>
										<th>Correo</th>
										<th>Área de Experiencia</th>
										<th>Experiencia en Nidos</th>
										<th>Experiencia en Infancia</th>
										<th class="archivo">Hoja de Vida</th>
										<th>Estado</th>
										<th>Opciones</th>
									</tr>
								</thead>
								<tbody>								
									<tr v-for="(hojaVida, index) in hojasVida" v-bind:key="index">
										<td>{{ hojaVida.fecha_solicitud }}</td>
										<td>{{ hojaVida.primer_nombre }} {{ hojaVida.primer_apellido }}</td>
										<td>{{ hojaVida.numero_documento }}</td>
										<td v-if="hojaVida.localidad.FK_Value != 0">{{ hojaVida.localidad.VC_Descripcion }}</td>
										<td v-if="hojaVida.localidad.FK_Value == 0">{{ hojaVida.municipio }}</td>
										<td>{{ hojaVida.telefono }}</td>
										<td>{{ hojaVida.correo }}</td>
										<td v-if="hojaVida.area_experiencia != null">{{ hojaVida.area_experiencia.VC_Descripcion }}</td>
										<td v-if="hojaVida.area_experiencia == null">{{ hojaVida.otra_area_experiencia }}</td>
										<td v-if="hojaVida.experiencia_nidos != 0">{{ hojaVida.periodo_nidos }}</td>
										<td v-if="hojaVida.experiencia_nidos == 0">NO</td>
										<td v-if="hojaVida.experiencia_infancia != 0">{{ hojaVida.periodo_infancia }}</td>
										<td v-if="hojaVida.experiencia_infancia == 0">NO</td>
										<td>
											<div class="row justify-content-center">
												<div class="col-lg-12">
													<a v-bind:href="hojaVida.archivo_hoja_vida" target="_blank" class="btn btn-block btn-secondary" data-toggle="tooltip" data-placement="top" title="Hoja de Vida"><i class="fas fa-file-download"></i></a>
												</div>
											</div>
										</td>
										<td v-if="hojaVida.estado == 0">SIN DEFINIR</td>
										<td v-if="hojaVida.estado == 1">SELECCIONADO</td>
										<td v-if="hojaVida.estado == 2">NO SELECCIONADO</td>
										<td>
											<div class="row justify-content-center">
												<button class="btn btn-block btn-success" @click="cargarDatosFormulario(index)" :data-index="index" data-toggle="modal" data-target="#modalValorar" data-placement="top" title="Evalorar Hoja de Vida">Evaluar</button>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal aprobar-->
		<div class="modal fade" id="modalValorar" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title">Evaluación de Audición</h1>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit="valorarHojaVida">
						<div class="modal-body">							
							<table class='table table-hover'>
								<thead>
									<tr>
										<th class="border-top-0">PARÁMETROS</th>
										<th class="text-center border-top-0" style="width: 50px" v-for="(usuario, index) in datos_evaluaciones[0]">{{ usuario.VC_Primer_Nombre }} {{ usuario.VC_Primer_Apellido }}</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(evaluaciones, index) in datos_evaluaciones[1]">
										<td class="border-bottom">{{ index+1 }}. {{ evaluaciones.parametro }}</td>
										<td v-for="(valores, index_v) in evaluaciones.valores" class="border-left border-bottom">
											<span v-if="id_persona != valores.id_usuario">{{ valores.valor }}</span>
											<input v-model="form_valorar.parametro[index]" v-if="id_persona == valores.id_usuario" class="form-control" type="number" >
										</td>
									</tr>
								</tbody>
							</table>
							<div class="form-group col-lg-12">
								<label>Observaciones</label>
								<textarea v-model="form_valorar.observaciones" class="form-control" required></textarea>
							</div>
							<div class="form-group row col-lg-3">
								<label class="col-sm-2">Resultado</label>
								<multiselect v-model="form_valorar.estado_guardar" label="text" :options="options_estado_guardar" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" ref="cerrarModalValorar" data-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success">Guardar</button>
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
				form_valorar:{
					id_hoja_vida: null,
					id_usuario: null,
					id_parametro: [],
					parametro: [],
					estado_guardar: null,
					observaciones: null
				},

				//variables funcionamiento formulario
				area_experiencia: "",
				experiencia_nidos: "",
				experiencia_infancia: "",
				estado: "",
				hojasVida: "",
				datos_evaluaciones: "",
				id_persona: "",

				//variables para opciones de listado
				options_area_experiencia: [],
				options_sino: [
					{value: -1, text: "TODOS"},
					{value: 1, text: "SI"},
					{value: 0, text: "NO"}
				],
				options_estado: [
					{value: -1, text: "TODOS"},
					{value: 0, text: "SIN DEFINIR"},
					{value: 1, text: "SELECCIONADO"},
					{value: 2, text: "NO SELECCIONADO"}
				],
				options_estado_guardar: [
					{value: 0, text: "SIN DEFINIR"},
					{value: 1, text: "SELECCIONADO"},
					{value: 2, text: "NO SELECCIONADO"}
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

			this.getIdPersona();
			this.getParametroDetalle(5, "tipos de documento");
			this.getParametroDetalle(19, "localidades");
			this.getParametroDetalle(101, "areas de experiencia");
		},
		methods: {
			getHojasVida(){
				if(this.area_experiencia == "" || this.experiencia_nidos == "" || this.experiencia_infancia == "" || this.estado == ""){
					Swal.fire("Error", "Compruebe que ha seleccionado algun filtro, por favor inténtelo nuevamente", "error");
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
					.post("/sif/framework/nidos/talento_humano/getHojasVida", {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
						"area_experiencia": this.area_experiencia["value"],
						"experiencia_nidos": this.experiencia_nidos["value"],
						"experiencia_infancia": this.experiencia_infancia["value"],
						"estado": this.estado["value"]
					})
					.then(response => {

						this.hojasVida = response.data;

						if($.fn.DataTable.isDataTable("#tablaInscritos")) 
							$("#tablaInscritos").DataTable().destroy();

						setTimeout(function(){
							$("#tablaInscritos").DataTable({
								//responsive: true,
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
						Swal.fire("Error", "No se pudo obtener el listado de hojas de vida inscritas, por favor inténtelo nuevamente", "error");
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
			getParametroDetalle(FK_Id_Parametro, tipo_listado){
				//5 tipo documento
				//14 grupo poblacional
				//15 grupo sanguineo y rh
				//16 eps
				//17 género
				//19 localidades
				//53 estratos
				//70 tipo afiliacion eps
				//101 areas de experiencia
				axios
				.post("/sif/framework/options/getParametroDetalle", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"FK_Id_Parametro": FK_Id_Parametro
				})
				.then(response => {
					switch(FK_Id_Parametro){
						case 101:
							this.options_area_experiencia.push({text:"TODAS",value:-1});
							for (let value of response.data) {
								this.options_area_experiencia.push(value);
							};
						//this.options_area_experiencia = response.data;						
						
						break;
					}
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de "+tipo_listado+", por favor inténtelo nuevamente"+error, "error");
				});
			},
			cargarDatosFormulario(index){	
				console.log("cualquier cosa");
				//let index = e.currentTarget.getAttribute("data-index");		
				this.form_valorar.id_hoja_vida = this.hojasVida[index]["id"];
				this.form_valorar.id_usuario = this.id_persona;	
				this.datos_evaluaciones = "";
				this.form_valorar.parametro = [];
				this.form_valorar.id_parametro = [];
				this.form_valorar.estado_guardar = "";
				this.form_valorar.observaciones = "";	
				Swal.fire({
					title: "Cargando información",
					text: "Espere un poco por favor.",
					imageUrl: "/sif/framework/public/images/cargando.gif",
					imageWidth: 140,
					imageHeight: 70,
					showConfirmButton: false,
				});	
				axios
				.post("/sif/framework/nidos/talento_humano/getEvaluacionHojasVida", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"id_hoja_vida": this.hojasVida[index]["id"],
					"id_usuario_actual": this.id_persona
				})
				.then(response => {
					this.datos_evaluaciones = response.data;
					this.form_valorar.observaciones = this.hojasVida[index]["observaciones"];
					this.options_estado_guardar.forEach((val, ind) => {
						if(this.options_estado_guardar[ind]["value"] == this.hojasVida[index]["estado"]){
							this.form_valorar.estado_guardar  = this.options_estado_guardar[ind];
						}
					});
					this.datos_evaluaciones[1].forEach((evaluacion) => {
						this.form_valorar.id_parametro.push(evaluacion.id_parametro);
						evaluacion.valores.forEach((valor, indice) => {
							if(valor.id_usuario==this.id_persona){
								this.form_valorar.parametro.push(valor.valor);
							}
						});
					});
					Swal.close();
				})
				.catch(error => {
					Swal.fire("Error", error+"No se pudo obtener el listado de las evaluaciones de las hojas de vida inscritas, por favor inténtelo nuevamente", "error");
				});
			},
			valorarHojaVida: function(e){
				e.preventDefault();
				Swal.fire({
					title: "Cargando",
					text: "Por favor espere",
					imageUrl: "/sif/framework/public/images/cargando.gif",
					imageWidth: 140,
					imageHeight: 70,
					showConfirmButton: false,
				});

				let config = { headers: { 'content-type': 'multipart/form-data' }}
				let datos = new FormData();

				let json = JSON.stringify(this.form_valorar);

				datos.append('data', json);

				axios.post('/sif/framework/nidos/talento_humano/guardarEvaluacionHojasVida', datos, config)
				.then(response => {
					Swal.close();
					Swal.fire("Éxito", "Se ha guardado la inscripción de la hoja de vida correctamente", "success");					
					setTimeout(() => {
						this.$refs.cerrarModalValorar.click();
						Object.keys(this.form_valorar).forEach( key => {
							this.form_valorar[key] = "";
						});
						this.getHojasVida();
					}, 700);					
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo almacenar la información, por favor inténtelo nuevamente", "error");
				});				
			}			
		}
	}
</script>
<style type="text/css">
.archivo {
	width: 80px !important;
}
</style>