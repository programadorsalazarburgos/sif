<template>
	<!-- Nidos/Territorial/Administracion_Duplas.php -->
	<div class="col-lg-8 offset-lg-2">
		<div class="form-row">
			<div class="form-group col-lg-12">
				<br>
				<h2>Administración duplas</h2>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="form-row">
					<div class="form-group col-lg-1 offset-lg-11 text-right">
						<button class="btn btn-block btn-success" type="button" data-toggle="modal" data-target="#modal-creacion-dupla"><i class="fas fa-plus-circle"></i></button>
					</div>
				</div>
				<h5><strong>Territorio asignado:</strong> {{territorio_persona}}</h5>
				<br>
				<div class="form-row">
					<div class="form-group col-lg-12">
						<h3>Duplas activas</h3>
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-stripered">
								<thead>
									<tr>
										<th>Dupla</th>
										<th>Tipo</th>
										<th>Artistas asignados</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody v-if="duplas.length > 0">
									<tr v-for="(dupla, index) in duplas">
										<td>
											<input style="min-width: 90px;" v-model="dupla.nombre_dupla" type="text" class="form-control" :disabled="dupla.disabled" @input="dupla.nombre_dupla=dupla.nombre_dupla.toUpperCase()">
										</td>
										<td>
											<multiselect v-model="dupla.tipo_dupla" :disabled="dupla.disabled" label="text" :options="options_tipo_dupla" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
										</td>
										<td>
											<multiselect v-model="dupla.artistas_actuales" :disabled="dupla.disabled" multiple label="text" :options="options_artista" placeholder="Agregar o quitar artista(s)" :show-labels="false" track-by="value"></multiselect>
										</td>
										<td>
											<button type="button" class="btn btn-block btn-warning" v-bind:data-index="index" data-accion="editar" name="boton-editar" @click="actualizarDupla"><i class="fas fa-edit"></i></button>
											<button type="button" class="btn btn-block btn-danger" v-bind:data-index="index" name="boton-inactivar" @click="inactivarDupla"><i class="fas fa-minus-circle"></i></button>
										</td>
									</tr>
								</tbody>
								<tbody v-else>
									<tr>
										<td colspan="4" class="text-center">No hay información disponible, lo sentimos</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="modal-creacion-dupla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Creación dupla</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit="crearDupla">
						<div class="modal-body">
							<div class="form-row">
								<div class="form-group col-lg-12">
									<label>Tipo dupla</label>
									<multiselect v-model="form_crear_dupla.tipo_dupla" label="text" :options="options_tipo_dupla" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-12">
									<label>Código/Nombre dupla</label>
									<input v-model="form_crear_dupla.nombre_dupla" @input="form_crear_dupla.nombre_dupla=form_crear_dupla.nombre_dupla.toUpperCase()" type="text" class="form-control" required>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-12">
									<label>Artistas</label>
									<multiselect v-model="form_crear_dupla.artistas" multiple label="text" :options="options_artista" placeholder="Agregar uno o varios artistas" :show-labels="false" track-by="value"></multiselect>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" ref="cerrarModalCreacionDupla" data-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</template>
<script>

	import Multiselect from "vue-multiselect";
	export default {
		components: { Multiselect },
		data () {
			return {
				id_tipo_persona: null,
				territorio_persona: null,
				duplas: [],
				options_tipo_dupla: [],
				disabled_boton_editar: false,
				multiselect_values: [],
				multiselect_disabled: true,
				options_artista: [],
				form_crear_dupla:{
					id_persona: null,
					id_territorio_persona: null,
					tipo_dupla: null,
					nombre_dupla: null,
					artistas: null
				}
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
					this.form_crear_dupla.id_persona = response.data;
					this.getTerritorioPersonaNidos();
					this.getRolPersona();
					this.getDuplasGestor();
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de la persona, por favor inténtelo nuevamente", "error");
				});
			},
			getTerritorioPersonaNidos(){
				axios
				.post("/sif/framework/personas/getTerritorioPersonaNidos", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"id_persona": this.form_crear_dupla.id_persona
				})
				.then(response => {
					this.form_crear_dupla.id_territorio_persona = response.data.Pk_Id_Territorio;
					this.territorio_persona = response.data.Vc_Nom_Territorio;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de la persona, por favor inténtelo nuevamente", "error");
				});
			},
			getRolPersona(){
				axios
				.post("/sif/framework/personas/getRolPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					'id_persona': this.form_crear_dupla.id_persona
				})
				.then(response => {
				//20 tipo persona gestor territorial
				//27 tipo persona EAP
				//40 tipo persona gestor circulación
				this.id_tipo_persona = response.data.FK_Tipo_Persona;

				switch(this.id_tipo_persona){
					case 20:
					//16 tipo persona artista territorial
					this.options_tipo_dupla.push({value: 2, text: "Laboratorio"},{value: 3, text: "Territorial"});
					this.getArtistasPorLineaNidos(16);
					break;
					case 27:
					//38 tipo persona artista fortalecimiento
					this.options_tipo_dupla.push({value: 4, text: "Fortalecimiento"});
					this.getArtistasPorLineaNidos(38);
					break;
					case 40:
					//34 tipo persona artista circulación
					this.options_tipo_dupla.push({value: 1, text: "Circulación"});
					this.getArtistasPorLineaNidos(34);
					break;
				}
				// {value: 5, text: "Transicion"},
			})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de la persona, por favor inténtelo nuevamente", "error");
				});
			},
			getArtistasPorLineaNidos(tipo_persona){
				axios
				.post("/sif/framework/personas/getArtistasPorLineaNidos", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"tipo_persona": tipo_persona
				})
				.then(response => {
					this.options_artista = response.data; 
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de artistas, por favor inténtelo nuevamente", "error");
				});
			},
			getDuplasGestor(){
				this.duplas = [];
				axios
				.post("/sif/framework/nidos/duplas/getDuplasGestor", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"id_persona": this.form_crear_dupla.id_persona
				})
				.then(response => {
					response.data.forEach((value, index) => {

						let artistas;

						this.duplas.push({
							id_dupla: value["Pk_Id_Dupla"],
							tipo_dupla: {value: value["Fk_Id_Tipo_Dupla"], text: value["nombre_tipo_dupla"]},
							disabled: true,
							nombre_dupla: value["VC_Codigo_Dupla"],
							artistas_actuales: []
						});

						value["artistas"].forEach((v, i) => {
							this.duplas[index]["artistas_actuales"].push({
								value: v["PK_Id_Persona"],
								text: v["full_name"]
							})
						});
					});
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de las duplas, por favor inténtelo nuevamente", "error");
				});
			},
			crearDupla: function(e){
				e.preventDefault();

				if(this.form_crear_dupla.tipo_dupla == "" || this.form_crear_dupla.tipo_dupla == null){
					Swal.fire("Atención", "Compruebe que ha seleccionado el tipo de dupla", "warning");
				}else if(this.form_crear_dupla.artistas == "" || this.form_crear_dupla.artistas == null){
					Swal.fire("Atención", "Compruebe que ha seleccionado al menos un artista que conforma la dupla", "warning");
				}else{
					Swal.fire({
						title: "Creando dupla",
						text: "Espere un poco por favor.",
						imageUrl: "/sif/framework/public/images/cargando.gif",
						imageWidth: 140,
						imageHeight: 70,
						showConfirmButton: false,
					});
					
					axios
					.post("/sif/framework/nidos/duplas/crearDupla", {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
						"form_crear_dupla": JSON.stringify(this.form_crear_dupla),
					})
					.then(response => {
						Object.keys(this.form_crear_dupla).forEach( key => {
							if(key != "id_persona" && key != "id_territorio_persona"){
								this.form_crear_dupla[key] = null;
							}
						});
						Swal.close();
						Swal.fire("Éxito", "Se ha creado la dupla correctamente", "success");
						this.$refs.cerrarModalCreacionDupla.click();
						this.getDuplasGestor();
					})
					.catch(error => {
						Swal.fire("Error", "No se pudo crear la dupla, por favor inténtelo nuevamente", "error");
					});
				}
			},
			actualizarDupla: function(e){
				let element_index = e.currentTarget.getAttribute("data-index");

				this.duplas[element_index]["disabled"] = false;

				if(e.currentTarget.getAttribute("data-accion") == "editar"){
					e.currentTarget.setAttribute("data-accion", "guardar");
					
					let icon_save = '<i class="fas fa-save"></i>';

					document.getElementsByName('boton-editar').forEach( el => {
						if(element_index != el.getAttribute("data-index")){
							el.disabled = true;
						}else{
							el.innerHTML = icon_save;
							el.className = 'btn btn-block btn-success';
						}
					});

					document.getElementsByName('boton-inactivar').forEach( el => {
						el.disabled = true;
					});

				}else{
					if(this.duplas[element_index]["nombre_dupla"] == "" || this.duplas[element_index]["nombre_dupla"] == null){
						Swal.fire("Atención", "Compruebe que ha diligenciado el nombre o código de la dupla", "warning");	
					}else if(this.duplas[element_index]["tipo_dupla"] == "" || this.duplas[element_index]["tipo_dupla"] == null){
						Swal.fire("Atención", "Compruebe que ha diligenciado el tipo de dupla", "warning");	
					}else if(this.duplas[element_index]["artistas_actuales"] == "" || this.duplas[element_index]["artistas_actuales"] == null){
						Swal.fire("Atención", "La dupla debe tener asignado al menos un artista", "warning");	
					}else{

						Swal.fire({
							title: "Actualizando dupla",
							text: "Espere un poco por favor.",
							imageUrl: "/sif/framework/public/images/cargando.gif",
							imageWidth: 140,
							imageHeight: 70,
							showConfirmButton: false,
						});

						axios
						.post("/sif/framework/nidos/duplas/actualizarDupla", {
							"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
							"form_actualizar_dupla": JSON.stringify(this.duplas[element_index]),
						})
						.then(response => {
							Swal.close();
							Swal.fire("Éxito", "Se ha actualizado la dupla correctamente", "success");
							this.getDuplasGestor();
						})
						.catch(error => {
							Swal.fire("Error", "No se pudo actualizar la dupla, por favor inténtelo nuevamente", "error");
						});
					}
				}
			},
			inactivarDupla: function(e){
				let element_index = e.currentTarget.getAttribute("data-index");

				Swal.fire({
					title: 'Inactivar dupla',
					text: '¿Está seguro que desea inactivar la dupla '+ this.duplas[element_index]["nombre_dupla"] +'?', 
					icon: 'warning',
					showCancelButton: true,
					cancelButtonText: 'No',
					confirmButtonColor: '#3f9a9d',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Si, inactivarla'
				}).then((result) => {
					if (result.value) {
						Swal.fire({
							title: "Inactivando dupla",
							text: "Espere un poco por favor.",
							imageUrl: "/sif/framework/public/images/cargando.gif",
							imageWidth: 140,
							imageHeight: 70,
							showConfirmButton: false,
						});

						axios
						.post("/sif/framework/nidos/duplas/inactivarDupla", {
							"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
							"id_dupla": this.duplas[element_index]["id_dupla"],
						})
						.then(response => {
							Swal.close();
							Swal.fire("Éxito", "Se ha inactivado la dupla correctamente", "success");
							this.getDuplasGestor();
						})
						.catch(error => {
							Swal.fire("Error", "No se pudo inactivar la dupla, por favor inténtelo nuevamente", "error");
						});
					}else{

					}
				});
			}
		}
	}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>