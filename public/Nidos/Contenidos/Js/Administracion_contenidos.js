var url_con = '../../../src/Contenidos/Controlador/ContenidosController.php';

$(document).ready(function(){

	 getCategoriaContenido("modificacion");

	 /**
	 * [Cargue de listado de categoria]
	 */
	 $("#sl-categoria").html(getCategoriaContenido("listado")).selectpicker("refresh");

	 $("#sl-categoria").change(function() {
	 	getContenidosCategoria();
	 }).selectpicker("refresh");

	 /**
	 * [getCategoriaContenido Función para obtener las categorias]
	 * @param  {[string]} tipo_consulta [listado: Para obtener el listado categorias, modificacion: Para modificar categorias]
	 * @return {[select, html]}               [Opciones de categorias, Información de categorias y elementos para su modificación]
	 */
	 function getCategoriaContenido(tipo_consulta){
	 	var mostrar = "";
	 	var datos = {
	 		funcion: 'getCategoriaContenido',
	 		p1: tipo_consulta
	 	};
	 	$.ajax({
	 		url: url_con,
	 		type: "POST",
	 		data: datos,
	 		dataType: 'html',
	 		success: function(data){
	 			if(tipo_consulta == "modificacion"){
	 				$("#div-categorias-creadas").html(data);
	 				$("#tabla-categorias").DataTable({
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
	 				});
	 			}else{
	 				mostrar += data;
	 			}
	 		},
	 		async: false
	 	});
	 	return mostrar;
	 }

	 /**
	 * [getContenidosCategoria Función para obtener contenidos]
	 * @return {[html]} [Información de contenidos y elementos para su modificación]
	 */
	 function getContenidosCategoria(){
	 	var datos = {
	 		funcion: 'getContenidosCategoria',
	 		p1: $("#sl-categoria").val(),
	 	};
	 	$.ajax({
	 		url: url_con,
	 		type: "POST",
	 		data: datos,
	 		dataType: 'html',
	 		success: function(data){
	 			$("#div-contenidos-creados").html(data)
	 			$("#tabla-contenidos").DataTable({
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
	 			});
	 		},
	 		async: false
	 	});
	 }

	 /**
	 * [guardarNuevaCategoriaContenido Función para guardar una nueva categoria]
	 * @return {[Bool]} [1 guardado, 0 no guardado]
	 */
	 function guardarNuevaCategoriaContenido(){
	 	var datos = {
	 		funcion: 'guardarNuevaCategoriaContenido',
	 		p1: $("#tx-nueva-categoria-contenido").val(),
	 		p2: 1
	 	};
	 	$.ajax({
	 		url: url_con,
	 		type: "POST",
	 		data: datos,
	 		dataType: 'html',
	 		success: function(data){
	 			if(data == 1) {
	 				parent.swal("Exito","Categoria guardada correctamente","success");
	 				$("#tx-nueva-categoria-contenido").val("");
	 				getCategoriaContenido("modificacion");
	 			}else{
	 				parent.swal("Error","No se ha podido guardar la nueva categoria, por favor intentelo nuevamente", "error");
	 			}
	 		},
	 		async: false
	 	});
	 }

	 /**
	 * [guardarNuevContenido Función para guardar nuevo contenido]
	 * @return {[Bool]} [1 guardado, 0 no guardado]
	 */
	 function guardarNuevContenido(){
	 	var datos = {
	 		funcion: 'guardarNuevContenido',
	 		p1: {
	 			"nombre_nuevo_contenido": $("#tx-nuevo-contenido").val(),
	 			"id_categoria_contenido": $("#sl-categoria").val()
	 		}
	 	};
	 	$.ajax({
	 		url: url_con,
	 		type: "POST",
	 		data: datos,
	 		dataType: 'html',
	 		success: function(data){
	 			if(data == 1) {
	 				parent.swal("Exito","Categoria guardada correctamente","success");
	 				$("#tx-nuevo-contenido").val("");
	 				getContenidosCategoria();
	 			}else{
	 				parent.swal("Error","No se ha podido guardar la nueva categoria, por favor intentelo nuevamente", "error");
	 			}
	 		},
	 		async: false
	 	});
	 }

	 /**
	 * [modificarCategoriaContenido Función para modificar información de la categoria]
	 * @param  {[Int]} id_categoria_contenido     [Id de la categoria]
	 * @param  {[String]} nombre_categoria_contenido [Nuevo nombre de la categoria]
	 * @return {[html]}                            [Categorias creadas]
	 */
	 function modificarCategoriaContenido(id_categoria_contenido, nombre_categoria_contenido, estado_categoria){
	 	var datos = {
	 		funcion: 'modificarCategoriaContenido',
	 		p1: {
	 			"id_categoria_contenido" : id_categoria_contenido,
	 			"nombre_categoria_contenido" : nombre_categoria_contenido,
	 			"estado_categoria": estado_categoria
	 		}
	 	};
	 	$.ajax({
	 		url: url_con,
	 		type: "POST",
	 		data: datos,
	 		dataType: 'html',
	 		success: function(data){
	 			getCategoriaContenido("modificacion");
	 			$("#sl-categoria").html(getCategoriaContenido("listado")).selectpicker("refresh");
	 		},
	 		async: false
	 	});
	 }

	 /**
	 * [modificarContenido Función para modificar información del contenido]
	 * @param  {[Int]} id_contenido     [Id del contenido]
	 * @param  {[String]} nombre_contenido [Nuevo nombre del contenido]
	 * @param  {[Int]} estado_contenido [Estado del contenido]
	 * @return {[Html]}                  [Contenidos creados]
	 */
	 function modificarContenido(id_contenido, nombre_contenido, estado_contenido){
	 	var datos = {
	 		funcion: 'modificarContenido',
	 		p1: {
	 			"id_contenido": id_contenido,
	 			"nombre_contenido": nombre_contenido,
	 			"estado_contenido": estado_contenido
	 		}
	 	};
	 	$.ajax({
	 		url: url_con,
	 		type: "POST",
	 		data: datos,
	 		dataType: 'html',
	 		success: function(data){
	 			getContenidosCategoria();
	 		},
	 		async: false
	 	});
	 }

	 /**
	 * [Función para realizar modificaciones sobre las categorias y contenidos]
	 */
	 $(".content").on("click", ".edit", function(){
	 	var input_id = $(this).attr("data-type") == "categoria" ? "categoria-"+$(this).attr("data-id-categoria") : "contenido-"+$(this).attr("data-id-contenido");
	 	var input_value = $(this).attr("data-type") == "categoria" ? $("#categoria-"+$(this).attr("data-id-categoria")).text() : $("#contenido-"+$(this).attr("data-id-contenido")).text();

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
	 			$(this).attr("data-type") == "categoria" ? modificarCategoriaContenido($(this).attr("data-id-categoria"), $("#"+input_id).text(), $("#estado-"+input_id).attr("data-hide")) : modificarContenido($(this).attr("data-id-contenido"), $("#"+input_id).text(), $("#estado-"+input_id).attr("data-hide"));
	 		}
	 	}else{
	 		$(this).attr("data-type") == "categoria" ? modificarCategoriaContenido($(this).attr("data-id-categoria"), $("#"+input_id).val(), $("#estado-"+input_id).attr("data-hide")) : modificarContenido($(this).attr("data-id-contenido"), $("#"+input_id).val(), $("#estado-"+input_id).attr("data-hide"));
	 	}
	 });

	 /**
	 * [Validación del formulario de categoria]
	 */
	 $("#form-nueva-categoria-contenido").submit(function(e){
	 	e.preventDefault();
	 	guardarNuevaCategoriaContenido();
	 });

	 /**
	 * [Validación del formulario de contenido]
	 */
	 $("#form-nuevo-contenido").submit(function(e){
	 	e.preventDefault();
	 	$("#sl-categoria").val() != "" ? guardarNuevContenido() : parent.swal("Error","Seleccione una categoria para guardar el contenido", "error");
	 });
	});
