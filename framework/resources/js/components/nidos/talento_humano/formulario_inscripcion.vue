<template>
	<div class="row">
		<div class="col-lg-10 offset-lg-1 col-md-12 col-xs-12">
			<div class="form-row">
				<div class="form-group col-lg-12">
					<h1 class="text-center pt-5 pb-3">Trabaja con nosotros</h1>
					<p>¡Hola! En el <b>Programa Nidos - Arte en primera infancia</b>, del <b>Instituto Distrital de las Artes – Idartes</b>, tenemos como objetivo principal contribuir a la garantía de los derechos artísticos y culturales de la primera infancia desde el reconocimiento y la celebración de la diversidad a través de obras, conciertos y experiencias artísticas de calidad en los distintos entornos y territorios de Bogotá.</p>
					<p>Si te interesa ser parte de nuestro equipo de trabajo, te invitamos a aplicar a través del formulario que encuentras a continuación.</p>
					<p><i>Te recordamos que es indispensable inscribirte previamente en la plataforma <b>Talento No Palanca</b>, a la cual puedes acceder haciendo clic en el siguiente enlace: <a href="https://talentonopalanca.gov.co/index.html" target="_blank">talentonopalanca.gov.co</a></i></p>
				</div>
			</div>
			<form @submit="guardarHojadeVida">
				<div key="card-form-hoja-de-vida" >
					<div class="card">
						<div class="card-header bg-info"><i class="fas fa-user fa-2x"></i> Información personal</div>
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-lg-6">
									<label class="required">Primer nombre</label>
									<input v-model="form.primer_nombre" class="form-control" type="text" required @input="form.primer_nombre=form.primer_nombre.toUpperCase();">
								</div>
								<div class="form-group col-lg-6">
									<label>Segundo nombre</label>
									<input v-model="form.segundo_nombre" class="form-control" type="text" @input="form.segundo_nombre=form.segundo_nombre.toUpperCase();">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6">
									<label class="required">Primer apellido</label>
									<input v-model="form.primer_apellido" class="form-control" type="text" required @input="form.primer_apellido=form.primer_apellido.toUpperCase();">
								</div>
								<div class="form-group col-lg-6">
									<label>Segundo apellido</label>
									<input v-model="form.segundo_apellido" class="form-control" type="text" @input="form.segundo_apellido=form.segundo_apellido.toUpperCase();">
								</div>
							</div>	
							<div class="form-row">
								<div class="form-group col-lg-6">
									<label class="required">Tipo de documento</label>
									<multiselect v-model="form.tipo_documento" label="text" :options="options_tipo_documento" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
								</div>
								<div class="form-group col-lg-6">
									<label class="required">Número de documento</label>
									<input v-model="form.numero_documento" class="form-control" type="number" required>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6">
									<label class="required">Localidad</label>
									<multiselect v-model="form.localidad" label="text" :options="options_localidad" @input="showMunicipio()" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
								</div>	
								<div class="form-group col-lg-6">
									<label class="required">Teléfono</label>
									<input v-model="form.telefono" class="form-control" type="number" required>
								</div>														
								<div class="form-group col-lg-6" v-show="no_aplica_loc">
									<label class="required">Municipio <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title='Si indicó "No Aplica" en localidad, debe indicar el Municipio'></i></label>
									<input v-model="form.municipio" class="form-control" type="text">
								</div>
							</div>				
							<div class="form-row">
								<div class="form-group col-lg-6">
									<label class="required">Correo</label>
									<input v-model="form.correo" class="form-control" type="email" required>
								</div>
								<div class="form-group col-lg-6">
									<label class="required">Confirmar correo</label>
									<input v-model="form.confirmar_correo" class="form-control" type="email" required>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header bg-info"><i class="fas fa-briefcase fa-2x"></i> Experiencia </div>
						<div class="card-body">
							<div class="form-row">								
								<div class="form-group col-lg-6">
									<label class="required">Área de Experiencia</label>
									<multiselect v-model="form.area_experiencia" label="text" :options="options_area_experiencia" @input="showOtraExperiencia()" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
								</div>																
								<div class="form-group col-lg-6" v-show="otra_experiencia">
									<label class="required">Otra Area de Experiencia <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title='Si indicó "Otra" en Área de Experiencia, indíque cual es'></i></label>
									<input v-model="form.otra_area_experiencia" class="form-control" type="text">
								</div>
								<div class="form-group col-lg-9">									
									<p>¿Ha trabajado con anterioridad en Nidos? Si sí, indique el período durante el cual trabajó</p>
								</div>
								<div class="form-group col-lg-3 row">
									<div class="col-lg-6">
										<div class="custom-control custom-radio custom-control-inline">
											<input v-model="form.experiencia_nidos" value="1" type="radio" @change="showPeriodoExperienciaNidos()" id="radioButtonExperienciaNidos" name="datos" class="custom-control-input" required>
											<label class="custom-control-label" for="radioButtonExperienciaNidos">Si</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="custom-control custom-radio custom-control-inline">
											<input v-model="form.experiencia_nidos" value="0" type="radio" @change="showPeriodoExperienciaNidos()" id="radioButtonNoExperienciaNidos" name="datos" class="custom-control-input" required>
											<label class="custom-control-label" for="radioButtonNoExperienciaNidos">No</label>
										</div>
									</div>								
									<div class="form-group col-lg-12" v-show="nidos_periodo">
										<label class="required">Periodo</label> <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title='Ejemplo: 3 años, 6 meses'></i>
										<input v-model="form.periodo_nidos" class="form-control" type="text">
									</div>
								</div>
								<div class="form-group col-lg-9">									
									<p>¿Ha trabajado con infancia y/o primera infancia? Si sí, indique el tiempo de experiencia</p>
								</div>
								<div class="form-group col-lg-3 row">
									<div class="col-lg-6">
										<div class="custom-control custom-radio custom-control-inline">
											<input v-model="form.experiencia_infancia" value="1" type="radio" @change="showPeriodoExperienciaInfancia()" id="radioButtonExperienciaInfancia" name="infancia" class="custom-control-input" required>
											<label class="custom-control-label" for="radioButtonExperienciaInfancia">Si</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="custom-control custom-radio custom-control-inline">
											<input v-model="form.experiencia_infancia" value="0" type="radio" @change="showPeriodoExperienciaInfancia()" id="radioButtonNoExperienciaInfancia" name="infancia" class="custom-control-input" required>
											<label class="custom-control-label" for="radioButtonNoExperienciaInfancia">No</label>
										</div>
									</div>								
									<div class="form-group col-lg-12" v-show="infancia_periodo">
										<label class="required">Periodo  <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title='Ejemplo: 3 años, 6 meses'></i></label>
										<input v-model="form.periodo_infancia" class="form-control" type="text" >
									</div>
								</div>			
								<div class="form-group col-lg-12">
									<label class="required">Código de inscripción en Talento No Palanca</label>
									<input v-model="form.codigo" class="form-control" type="number" required>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header bg-info"><i class="fas fa-file-upload fa-2x"></i> Archivo</div>
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-lg-12">
									<label class="required">Hoja de Vida <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="Se permiten archivos word y pdf."></i></label>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="archivoHojadeVida" @change="onFileChange" accept=".doc,.docx,.pdf" required>	
											<label class="custom-file-label">{{ label_archivo_hoja_vida }}</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>					
					<div class="form-group col-lg-8 offset-lg-2">
						<button class="btn btn-block btn-primary" type="submit">Inscribirse</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>
<script>

	import Multiselect from "vue-multiselect";

	export default {
		components: { Multiselect },
		data () {
			return {
				//variables formulario
				form:{
					tipo_documento: null,
					numero_documento: null,
					primer_nombre: null,
					segundo_nombre: null,
					primer_apellido: null,
					segundo_apellido: null,
					correo: null,
					confirmar_correo: null,
					telefono: null,
					localidad: null,
					municipio: null,
					area_experiencia: null,
					otra_area_experiencia: null,
					experiencia_nidos: null,
					periodo_nidos: null,
					experiencia_infancia: null,	
					periodo_infancia: null,		
					codigo: null,		
					archivo_hoja_vida: ""
				},
				
				//variables para opciones de listado
				options_tipo_documento: [],
				options_localidad: [],
				options_area_experiencia: [],
				
				//variables funcionamiento del formulario
				nidos_periodo: false,
				infancia_periodo: false,
				otra_experiencia:false,
				no_aplica_loc: false,
				label_archivo_hoja_vida: "Seleccionar archivo",
			}
		},
		mounted() {
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

			this.getParametroDetalle(5);
			this.getParametroDetalle(19);
			this.getParametroDetalle(101);
		},
		methods: {	
			getParametroDetalle(FK_Id_Parametro){
				//5 tipo documento
				//19 localidades
				//101 areas de experiencia
				axios
				.post("/sif/framework/options/getParametroDetalle", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"FK_Id_Parametro": FK_Id_Parametro
				})
				.then(response => {
					let tipo_listado;
					switch(FK_Id_Parametro){
						case 5:
						this.options_tipo_documento = response.data;
						tipo_listado = "tipos de documento";
						break;
						case 19:
						this.options_localidad = response.data;
						this.options_localidad.push({text:"NO APLICA",value:0});
						tipo_listado = "localidades";
						break;
						case 101:
						this.options_area_experiencia = response.data;
						this.options_area_experiencia.push({text:"OTRA",value:0});
						tipo_listado = "area de experiencia";
						break;
					}
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de "+tipo_listado+", por favor inténtelo nuevamente", "error");
				});
			},
			showMunicipio(){
				if(this.form.localidad!=null){
					if(this.form.localidad.value==0)
						this.no_aplica_loc = true;
					else
						this.no_aplica_loc = false;
				}
			},
			showOtraExperiencia(){
				if(this.form.area_experiencia!=null){
					if(this.form.area_experiencia.value==0)
						this.otra_experiencia = true;
					else
						this.otra_experiencia = false;
				}
			},
			showPeriodoExperienciaNidos(){
				if(this.form.experiencia_nidos==1)
					this.nidos_periodo = true;
				else
					this.nidos_periodo = false;
			},
			showPeriodoExperienciaInfancia(){
				if(this.form.experiencia_infancia==1)
					this.infancia_periodo = true;
				else
					this.infancia_periodo = false;
			},
			onFileChange: function(e){
				this.form.archivo_hoja_vida = e.target.files[0];
				this.label_archivo_hoja_vida = e.target.files[0].name;
			},
			guardarHojadeVida: function(e){
				e.preventDefault();
				if(this.form.tipo_documento == null){
					Swal.fire("Error", "Compruebe que ha seleccionado su tipo de documento", "error");
				}else if(this.form.localidad == null){
					Swal.fire("Error", "Compruebe que ha seleccionado su localidad de residencia", "error");
				}else if(this.form.area_experiencia == null){
					Swal.fire("Error", "Compruebe que ha seleccionado el area de experiencia", "error");
				}else if(this.form.correo != this.form.confirmar_correo){
					Swal.fire("Error", "El correo electrónico no coincide", "error");
				}else if((this.form.localidad.value==0)&&((this.form.municipio=="")||(this.form.municipio==null))){
					Swal.fire("Error", 'Si indicó "No Aplica" en localidad, debe indicar el Municipio', "error");
				}else if((this.form.area_experiencia.value==0)&&((this.form.otra_area_experiencia=="")||(this.form.otra_area_experiencia==null))){
					Swal.fire("Error", 'Si indicó "Otra" en Área de Experiencia, debe indicar cual es', "error");
				}else if((this.form.experiencia_nidos==1)&&((this.form.periodo_nidos=="")||(this.form.periodo_nidos==null))){
					Swal.fire("Error", "Indique el período durante el cual trabajó en Nidos", "error");
				}else if((this.form.experiencia_infancia==1)&&((this.form.periodo_infancia=="")||(this.form.periodo_infancia==null))){
					Swal.fire("Error", "Indique el período durante el cual trabajó con infancia y/o primera infancia", "error");
				}else if((this.form.archivo_hoja_vida==null)||(this.form.archivo_hoja_vida=="")){
					Swal.fire("Error", "Compruebe que ha seleccionado el archivo de la Hoja de Vida", "error");
				}
				else{
					Swal.fire({
						title: "Guardar Formulario",
						text: '¿Está seguro de guardar este formulario?',
						type: 'warning',
						showConfirmButton: true,
						showCancelButton: true,
						confirmButtonText: 'Sí',
						cancelButtonText: 'No',
					}).then((result) => {
						if (result.isConfirmed) {
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

							let json = JSON.stringify(this.form);

							datos.append('data', json);
							datos.append("archivo_hoja_vida", this.form.archivo_hoja_vida);

							axios.post('/sif/framework/nidos/talento_humano/guardarHojadeVida', datos, config)
							.then(response => {
								Swal.close();
								Swal.fire("Éxito", "Se ha guardado la inscripción de la hoja de vida correctamente", "success");
								this.label_archivo_hoja_vida = "Seleccionar archivo";								
								this.nidos_periodo = false;
								this.infancia_periodo = false;
								this.otra_experiencia =false;
								this.no_aplica_loc = false;
								Object.keys(this.form).forEach( key => {
									this.form[key] = null;
								});
							})
							.catch(error => {
								Swal.fire("Error", "No se pudo almacenar la información, por favor inténtelo nuevamente", "error");
							});
						}
					});					
				}
			}
		}
	}
</script>