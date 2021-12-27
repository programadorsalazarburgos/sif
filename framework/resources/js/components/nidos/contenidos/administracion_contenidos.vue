<template>
	<div>
		<h2>Módulo contenidos NIDOS</h2>
		<br>
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#administracion-contenidos">Administración de contenidos</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-beneficiarios-sin-info">Consulta beneficiarios sin información</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-beneficiarios-con-info">Consulta beneficiarios con información</a></li>
		</ul>
		<div class="tab-content">
			<div id="administracion-contenidos" class="container tab-pane active"><br>
				<div class="container">
					<div id="accordion">
						<div class="card">
							<div class="card-header">
								<a class="card-link" data-toggle="collapse" href="#collapse-categorias">Administración de categorías</a>
							</div>
							<div id="collapse-categorias" class="collapse show" data-parent="#accordion">
								<div class="card-body">
									<div class="form-group">
										<div class="col-lg-10 offset-lg-1">
											<label>Nueva categoría</label>
											<form id="form-nueva-categoria-contenido" @submit="guardarNuevaCategoria">
												<div class="row">
													<div class="col-lg-10">
														<input type="text" v-model="nombre_nueva_categoria" class="form-control" id="tx-nueva-categoria-contenido" required="required">
													</div>
													<div class="col-lg-2">
														<button type="submit" class="btn btn-block btn-primary"><i class="fas fa-plus-circle"></i></button>
													</div>
												</div>
											</form>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-10 offset-lg-1">
											<label>Categorías creadas</label>
											<table class="table table-striped table-bordered" id="tabla-categorias" style="width:100%">
												<thead>
													<tr>
														<th>Categoria</th>
														<th>Modificar</th>
														<th>Estado</th>
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
						<div class="card">
							<div class="card-header">
								<a class="collapsed card-link" data-toggle="collapse" href="#collapse-contenidos">Administración de contenidos</a>
							</div>
							<div id="collapse-contenidos" class="collapse" data-parent="#accordion">
								<div class="card-body">
									<div class="form-group">
										<div class="col-lg-10 offset-lg-1">
											<label>Categorias</label>
											<multiselect v-model="id_categoria" @input="getContenidosPorCategoria()" label="text" :options="options_categoria" placeholder="Seleccione una opción" :show-labels="false" track-by="value" id="sl-categoria" name="sl-categoria"></multiselect>
										</div>		
									</div>
									<div class="form-group">
										<div class="col-lg-10 offset-lg-1">
											<label>Nuevo contenido</label>
											<form id="form-nuevo-contenido" @submit="guardarNuevoContenido">
												<div class="row">
													<div class="col-lg-10">
														<input type="text" v-model="nombre_nuevo_contenido" class="form-control" id="tx-nuevo-contenido" required="required">
													</div>
													<div class="col-lg-2">
														<button type="submit" class="btn btn-block btn-primary"><i class="fas fa-plus-circle"></i></button>
													</div>
												</div>
											</form>	
										</div>	
									</div>
									<div class="form-group">
										<div class="col-lg-10 offset-lg-1">
											<label>Contenidos creados</label>
											<table class="table table-striped table-bordered" id="tabla-contenidos" style="width:100%">
												<thead>
													<tr>
														<th>Contenido</th>
														<th>Modificar</th>
														<th>Estado</th>
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
						<div class="col-lg-12 col-sm-12 table-responsive">
							<table class="table table-sm nowrap display" id="tabla-info-sin-informacion" style="width:100%;">
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
										<th>Gestantes</th>
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
				id_categoria: "",
				options_categoria: [],
				nombre_nueva_categoria: "",
				tabla_categorias: "",
				info_tabla_categorias: [],
				nombre_nuevo_contenido: "",
				tabla_contenidos: "",
				rowNode: "",
				boton_estado: "",
				options_mes: [],
				id_mes_s: "",
				config_tabla: "",
				tabla_sin_info: "",
				info_tabla_contenidos: [],
				id_mes_c: "",
				config_tabla_reporte: "",
				tabla_con_info: "",
				info_tabla_com_info: []
			}
		},
		mounted() {

			const vm = this;

			this.getMes();

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

			this.config_tabla = {
				autoWidth: false,
				responsive: true,
				pageLength: 50,
				columnDefs: [
				{ "width": "80%", "targets": 0 }
				],
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

			this.tabla_categorias = $("#tabla-categorias").DataTable(this.config_tabla);
			this.tabla_contenidos = $("#tabla-contenidos").DataTable(this.config_tabla);
			this.tabla_sin_info = $("#tabla-info-sin-informacion").DataTable(this.config_tabla_reporte);
			this.tabla_con_info = $("#tabla-info-con-informacion").DataTable(this.config_tabla_reporte);
			
			this.getCategorias(1);
			this.getCategorias(2);


			$(".content").on("click", ".edit", function(){
				var input_id = $(this).attr("data-type") == "categoria" ? "categoria-"+$(this).attr("data-id-categoria") : "contenido-"+$(this).attr("data-id-contenido");
				var input_value = $("#"+input_id).text();

				if($(this).attr("data-action") == "edit"){
					if(!$(this).is('[data-hide]')){
						$("#"+input_id).replaceWith(function(){
							return '<input type="text" class="form-control" id='+input_id+' value="'+input_value+'">';
						});
						$(this).html("").html("<i class='far fa-save'></i>");
						$(this).removeClass("btn-warning").addClass("btn-success");
						$(this).attr("data-action", "save");
					}else{
						$(this).attr("data-hide") == 1 ? $(this).html("").html("<i class='far fa-eye-slash'></i>") : $(this).html("").html("<i class='far fa-eye'></i>");
						$(this).attr("data-hide") == 1 ? $(this).removeClass("btn-success").addClass("btn-danger") : $(this).removeClass("btn-danger").addClass("btn-success");
						$(this).attr("data-hide") == 1 ? $(this).attr("data-hide", 0) : $(this).attr("data-hide", 1);
						console.log($("#estado-"+input_id).attr("data-hide"));
						$(this).attr("data-type") == "categoria" ? vm.modificarCategoria($(this).attr("data-id-categoria"), $("#"+input_id).text(), $("#estado-"+input_id).attr("data-hide")) : vm.modificarContenido($(this).attr("data-id-contenido"), $("#"+input_id).text(), $("#estado-"+input_id).attr("data-hide"));
					}
				}else{
					$(this).attr("data-type") == "categoria" ? vm.modificarCategoria($(this).attr("data-id-categoria"), $("#"+input_id).val(), $("#estado-"+input_id).attr("data-hide")) : vm.modificarContenido($(this).attr("data-id-contenido"), $("#"+input_id).val(), $("#estado-"+input_id).attr("data-hide"));
				}
			});
		},
		methods: {
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
			getCategorias(tipo_consulta){
				axios
				.post("/sif/framework/options/getCategorias", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					tipo_consulta: tipo_consulta
				})
				.then(response => {
					if(tipo_consulta == 1){
						this.info_tabla_categorias = response.data;
						this.tabla_categorias.clear().draw();
						this.info_tabla_categorias.forEach((value, index) => {

							if(this.info_tabla_categorias[index]["IN_Estado"] == 0 ){
								this.boton_estado = "<button type='button' class='btn btn-block btn-danger edit' data-type='categoria' data-action='edit' data-id-categoria='"+this.info_tabla_categorias[index]["PK_Id_Categoria"]+"' id='estado-categoria-"+this.info_tabla_categorias[index]["PK_Id_Categoria"]+"' data-hide='"+this.info_tabla_categorias[index]["IN_Estado"]+"'><i class='far fa-eye-slash'></button>";
							}else{
								this.boton_estado = "<button type='button' class='btn btn-block btn-success edit' data-type='categoria' data-action='edit' data-id-categoria='"+this.info_tabla_categorias[index]["PK_Id_Categoria"]+"' id='estado-categoria-"+this.info_tabla_categorias[index]["PK_Id_Categoria"]+"' data-hide='"+this.info_tabla_categorias[index]["IN_Estado"]+"'><i class='far fa-eye'></i></button>";
							}

							this.rowNode = this.tabla_categorias.row.add([
								"<span id='categoria-"+this.info_tabla_categorias[index]["PK_Id_Categoria"]+"'>"+this.info_tabla_categorias[index]["VC_Nombre_Categoria"]+"</span>",

								"<button type='button' class='btn btn-block btn-warning edit' data-action='edit' data-type='categoria' data-id-categoria='"+this.info_tabla_categorias[index]["PK_Id_Categoria"]+"'><i class='far fa-edit'></i></button>",

								this.boton_estado

								]).draw().node();
						});
					}else{
						this.options_categoria = response.data;
					}
				})
				.catch(error => {
					console.log(error);
				});
			},
			guardarNuevaCategoria: function(e){ 		
				e.preventDefault();
				axios
				.post("/sif/framework/nidos/categorias/guardarNuevaCategoria", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					nombre_nueva_categoria: this.nombre_nueva_categoria,
					estado_categoria: 1
				})
				.then(response => {
					Swal.fire("Exito", "La categoria se ha guardado exitosamente", "success");
					this.nombre_nueva_categoria = "";
					this.getCategorias(1);
					this.getCategorias(2);
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo guardar la categoría, por favor inténtelo nuevamente", "error");
				});
			},
			modificarCategoria(id_categoria, nombre_categoria, estado_categoria){
				axios
				.post("/sif/framework/nidos/categorias/modificarCategoria", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_categoria : id_categoria,
					nombre_categoria : nombre_categoria,
					estado_categoria: estado_categoria
				})
				.then(response => {
					this.getCategorias(1);
					this.getCategorias(2);
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo actualizar la categoría, por favor inténtelo nuevamente", "error");
				});
			},
			getContenidosPorCategoria(){
				axios
				.post("/sif/framework/nidos/contenidos/getContenidosPorCategoria", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_categoria : this.id_categoria["value"],
				})
				.then(response => {
					this.info_tabla_contenidos = response.data;
					this.tabla_contenidos.clear().draw();
					this.info_tabla_contenidos.forEach((value, index) => {

						if(this.info_tabla_contenidos[index]["IN_Estado"] == 0 ){
							this.boton_estado = "<button type='button' class='btn btn-block btn-danger edit' data-type='contenido' data-action='edit' data-id-contenido='"+this.info_tabla_contenidos[index]["PK_Id_Contenido"]+"' id='estado-contenido-"+this.info_tabla_contenidos[index]["PK_Id_Contenido"]+"' data-hide='"+this.info_tabla_contenidos[index]["IN_Estado"]+"'><i class='far fa-eye-slash'></button>";
						}else{
							this.boton_estado = "<button type='button' class='btn btn-block btn-success edit' data-type='contenido' data-action='edit' data-id-contenido='"+this.info_tabla_contenidos[index]["PK_Id_Contenido"]+"' id='estado-contenido-"+this.info_tabla_contenidos[index]["PK_Id_Contenido"]+"' data-hide='"+this.info_tabla_contenidos[index]["IN_Estado"]+"'><i class='far fa-eye'></i></button>";
						}

						this.rowNode = this.tabla_contenidos.row.add([
							"<span id='contenido-"+this.info_tabla_contenidos[index]["PK_Id_Contenido"]+"'>"+this.info_tabla_contenidos[index]["VC_Nombre_Contenido"]+"</span>",

							"<button type='button' class='btn btn-block btn-warning edit' data-action='edit' data-type='contenido' data-id-contenido='"+this.info_tabla_contenidos[index]["PK_Id_Contenido"]+"'><i class='far fa-edit'></i></button>",

							this.boton_estado

							]).draw().node();
					});
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de contenidos, por favor inténtelo nuevamente", "error");
				});
			},
			guardarNuevoContenido: function(e){ 		
				e.preventDefault();
				if (this.id_categoria == ""){
					Swal.fire("Error", "Seleccione una categoría del listado para guardar el contenido", "error");
				}else{
					axios
					.post("/sif/framework/nidos/contenidos/guardarNuevoContenido", {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
						nombre_nuevo_contenido: this.nombre_nuevo_contenido,
						estado_contenido: 1,
						id_categoria : this.id_categoria["value"],
					})
					.then(response => {
						Swal.fire("Exito", "El contenido se ha guardado exitosamente", "success");
						this.nombre_nuevo_contenido = "";
						this.getContenidosPorCategoria();
					})
					.catch(error => {
						Swal.fire("Error", "No se pudo guardar el contenido, por favor inténtelo nuevamente", "error");
					});
				}
			},
			modificarContenido(id_contenido, nombre_contenido, estado_contenido){
				axios
				.post("/sif/framework/nidos/contenidos/modificarContenido", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_contenido : id_contenido,
					nombre_contenido : nombre_contenido,
					estado_contenido: estado_contenido
				})
				.then(response => {
					this.getContenidosPorCategoria();
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo actualizar el contenido, por favor inténtelo nuevamente", "error");
				});
			},
			getInformeBeneficiariosSinInfo(){
				axios
				.post("/sif/framework/nidos/contenidos/getInformeBeneficiariosSinInfo", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_mes: this.id_mes_s["value"],
					tipo_consulta: 2
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
					Swal.fire("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
				});
			},
			getInformeBeneficiariosConInfo(){
				axios
				.post("/sif/framework/nidos/contenidos/getInformeBeneficiariosConInfo", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					id_mes: this.id_mes_c["value"],
					tipo_consulta: 2
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