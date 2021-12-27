var url_con = '../../../src/Contenidos/Controlador/ContenidosController.php';
var url_lug = '../../../src/Territorial/Controlador/AdministrarLugaresController.php';
var url_gru = '../../../src/Beneficiarios/Controlador/AdministrarGruposController.php';
var url_ben = '../../../src/Beneficiarios/Controlador/RegistroBeneficiariosController.php';
var total_enfoque;
var select_lugar;
var select_tipo_documento;
var select_contenido;
var select_genero;
var select_enfoque;
var select_estrato;
var id_input = 1;
var date = new Date();
var month;
var day;

if((date.getMonth() + 1) < 10)
	month = "0" + (date.getMonth() + 1);

if(date.getDate() < 10)
	day = "0" + date.getDate();
else
	day = date.getDate();

var hoy = date.getFullYear() + "-" + month + "-" + day;

$(document).ready(function(){

	getConsultarLugarM();
	getContenidos();
	NombreTerritorio();

	 /**
	 * [Cargue de listados: Tipo documento, género, estrato y enfoque] 
	 */
	 $('a[href="#beneficiarios-con-informacion"]').click(function() {
	 	if(select_tipo_documento == undefined){
	 		getTipoDocumento();
	 		getGenero();
	 		getEtnia();
	 		getTPoblacional();
	 		getEtnia();

	 		$("#sl-tipo-documento-1").html(selectTipoDocumento()).selectpicker("refresh");
	 		$("#sl-genero-1").html(selectGenero()).selectpicker("refresh");
	 		$("#sl-enfoque-1").html(selectEtnia()).selectpicker("refresh");
	 		$("#sl-estrato-1").html(selectTPoblacional()).selectpicker("refresh");
	 		$("#tx-fecha-d").attr("max", hoy);

	 		$("#tx-f-nacimiento-1").attr("max", hoy);
	 	}
	 });

	 /**
	  * [Cargue de listados: contenidos y grupos]
	  */
	  $("#sl-contenido").html(selectContenido()).selectpicker("refresh");
	  $("#sl-contenido-d").html(selectContenido()).selectpicker("refresh");
	  $("#sl-lugar").html(selectLugar()).change(function(){
	  	$("#sl-grupo").html(getGrupos(1)).selectpicker("refresh");
	  	getDatosLugar(1)
	  }).selectpicker("refresh");
	  $("#tx-fecha").attr("max", hoy);


	  $("#sl-lugar-d").html(selectLugar()).change(function(){
	  	$("#sl-grupo-d").html(getGrupos(2)).selectpicker("refresh");
	  	getDatosLugar(2)
	  }).selectpicker("refresh");

	 /** 
	  * [Inicialización campo input file]
	  */
	  $(":file").filestyle({
	  	htmlIcon: '<i class="fas fa-upload"></i>',
	  	placeholder: "Seleccione un archivo",
	  	btnClass: "btn-primary",
	  	badge: true,
	  	text: "",
	  });

	 /**
	  *  [Validación y envio de campos del formulario]
	  */
	  $("#form-beneficiarios-sin-info").submit(function(e){
	  	e.preventDefault();
	  	if(+$("#tx-ninos").val() + +$("#tx-ninas").val() != +$("#tx-total").val()){
	  		parent.swal("Error","La cantidad de niños y niñas es superior o inferior al total","error");
	  	}else if(+$("#tx-ninos-cero-tres").val() + +$("#tx-ninos-tres-seis").val() != +$("#tx-ninos").val()){
	  		parent.swal("Error","La cantidad de niños por rango de edad es superior o inferior al total de niños","error");
	  	}else if(+$("#tx-ninas-cero-tres").val() + +$("#tx-ninas-tres-seis").val() != +$("#tx-ninas").val()){
	  		parent.swal("Error","La cantidad de niñas por rango de edad es superior o inferior al total de niñas","error");
	  	}else{
	  		total_enfoque = 0;
	  		$(".enfoque").each(function() {
	  			total_enfoque += +this.value;				
	  		});
	  		if(total_enfoque > +$("#tx-total").val()){
	  			parent.swal("Error","La cantidad de niños con enfoque es superior al total","error");
	  		}else{
	  			guardarBeneficiariosSinInfo();
	  		}
	  	}
	  });

	 /**
	  * [Cargue listado de meses]
	  */
	  $("#sl-mes").html(parent.getOptionsMes()).change(function(){
	  	getBeneficiariosSinInfo();
	  }).selectpicker("refresh");

	 /**
	  * [guardarBeneficiariosSinInfo Función que guarda la información de los beneficiarios sin información a los cuales se les entrega contenidos]
	  * @return {[boolean]} [1 si el guardado fue exitoso, 0 sino fue exitoso]
	  */
	  function guardarBeneficiariosSinInfo(){
	  	var datos = new FormData();
	  	formulario = {};

	  	formulario['tx-total'] = $("#tx-total").val();
	  	formulario['tx-ninos'] = $("#tx-ninos").val();
	  	formulario['tx-ninas'] = $("#tx-ninas").val();
	  	formulario['tx-ninos-cero-tres'] = $("#tx-ninos-cero-tres").val();
	  	formulario['tx-ninos-tres-seis'] = $("#tx-ninos-tres-seis").val();
	  	formulario['tx-ninas-cero-tres'] = $("#tx-ninas-cero-tres").val();
	  	formulario['tx-ninas-tres-seis'] = $("#tx-ninas-tres-seis").val();
	  	formulario['tx-mujeres'] = $("#tx-mujeres").val();
	  	formulario['tx-afro'] = $("#tx-afro").val();
	  	formulario['tx-rural'] = $("#tx-rural").val();
	  	formulario['tx-discapacidad'] = $("#tx-discapacidad").val();
	  	formulario['tx-conflicto'] = $("#tx-conflicto").val();
	  	formulario['tx-indigena'] = $("#tx-indigena").val();
	  	formulario['tx-libertad'] = $("#tx-libertad").val();
	  	formulario['tx-violencia'] = $("#tx-violencia").val();
	  	formulario['tx-raizal'] = $("#tx-raizal").val();
	  	formulario['tx-rom'] = $("#tx-rom").val();
	  	formulario['sl-lugar'] = $("#sl-lugar").val();
	  	formulario['sl-grupo'] = $("#sl-grupo").val();
	  	formulario['id-usuario'] = parent.idUsuario;

	  	var ids = "";
	  	$("#sl-contenido :selected").each(function(i, selected) {
	  		ids += $(selected).val() + ",";
	  	});
	  	ids = ids.slice(0,-1);
	  	formulario["sl-contenido"] = ids;

	  	formulario['tx-fecha'] = $("#tx-fecha").val();

	  	var archivo = $("#fl-documento")[0].files[0];

	  	datos.append('funcion', 'guardarBeneficiariosSinInfo');
	  	datos.append("p1", JSON.stringify(formulario));  
	  	datos.append("p3", archivo);

	  	$.ajax({
	  		contentType: false,
	  		processData: false,
	  		dataType: "html",
	  		type: "POST",
	  		url: url_con,
	  		data: datos,
	  		success: function(data){
	  			if(data == 1){
	  				parent.swal({
	  					confirmButtonColor: '#3f9a9d',
	  					title: 'Operación exitosa!',
	  					html: '<small>La información se ha guardado exitosamente</small>',
	  					type: 'success',
	  					confirmButtonText: 'Aceptar',
	  				}).then(() => {
	  					limpiarFormulario();
	  				}).catch(parent.swal.noop);
	  			}else{
	  				parent.swal("Error!", "No se ha podido guardar la información, por favor vuelva a intentarlo", "error");
	  			}
	  		},
	  		async: false
	  	});
	  }

	 /**
	  * [getTipoDocumento Función que obtiene el listado de tipo de documento]
	  * @return {[select]} [Opciones de tipo de documento]
	  */
	  function getTipoDocumento() {
	  	var datos = {
	  		funcion: 'getTipoDocumento'
	  	};
	  	$.ajax({
	  		url: url_ben,
	  		type: 'POST',
	  		data: datos,
	  		success: function(data) {
	  			select_tipo_documento += data
	  		},
	  		async: false
	  	});
	  }

	  function selectTipoDocumento() {
	  	return select_tipo_documento;
	  }

	 /**
	  * [getGenero Función que obtiene el listado de género]
	  * @return {[select]} [Opciones de género]
	  */
	  function getGenero() {
	  	var datos = {
	  		funcion: 'getGenero'
	  	};
	  	$.ajax({
	  		url: url_ben,
	  		type: 'POST',
	  		data: datos,
	  		success: function(data) {
	  			select_genero += data
	  		},
	  		async: false
	  	});
	  }

	  function selectGenero() {
	  	return select_genero;
	  }

	 /**
	  * [getEtnia Función que obtiene el listado de enfoque diferencial]
	  * @return {[select]} [Opciones de enfoque]
	  */
	  function getEtnia() {
	  	var datos = {
	  		funcion: 'getEtnia'
	  	};
	  	$.ajax({
	  		url: url_ben,
	  		type: 'POST',
	  		data: datos,
	  		success: function(data) {
	  			select_enfoque = data;
	  		},
	  		async: false
	  	});
	  }

	  function selectEtnia() {
	  	return select_enfoque;
	  }

	 /**
	  * [getTPoblacional Función que obtiene el listado de estrato]
	  * @return {[select]} [Opciones de estrato]
	  */
	  function getTPoblacional() {
	  	var datos = {
	  		funcion: 'getTPoblacional'
	  	};
	  	$.ajax({
	  		url: url_ben,
	  		type: 'POST',
	  		data: datos,
	  		success: function(data) {
	  			select_estrato = data;
	  		},
	  		async: false
	  	});
	  }

	  function selectTPoblacional() {
	  	return select_estrato;
	  }

	 /**
	 * [limpiarFormulario Función que limpia el formulario de entrega de contenidos a beneficiarios sin información]
	 */
	 function limpiarFormulario(){
	 	$(":input").val("");
	 	$(":file").filestyle('clear');
	 	$(".selectpicker").selectpicker("refresh");
	 }

	 /**
	 * [NombreTerritorio Función que obtiene el territorio asignado de cada usuario]
	 */
	 function NombreTerritorio() {
	 	datos = {
	 		'funcion': 'getNombreTerritorio',
			//'p1': parent.idUsuario
			'p1': 1797
		};
		$.ajax({
			url: url_lug,
			type: 'POST',
			data: datos,
			dataType: 'json',
			success: function(data){
				id_territorio = data["Pk_Id_Territorio"];
			},
			async: false,
		});
	}

	 /**
	 * [getConsultarLugarM Función que obtiene el listado de lugares de atención del territorio]
	 * @return {[select]} [Opciones de lugar de atención]
	 */
	 function getConsultarLugarM() {
	 	var datos = {
	 		funcion: 'getConsultarLugarM',
			//'p1': id_territorio
			'p1': 10
		};
		$.ajax({
			url: url_lug,
			type: 'POST',
			data: datos,
			success: function(data) {
				select_lugar += data;
			},
			async: false
		});
	}

	function selectLugar(){
		return select_lugar;
	}

	 /**
	 * [getDatosLugar Función que obtiene y muestra los datos del lugar de atención]
	 * @param  {[Int]} formulario [1 formulario sin información, 2 formulario con información]
	 * @return {[json]} [Datos del lugar de atención]
	 */
	 function getDatosLugar(formulario) {
	 	datos = {
	 		funcion: 'getDatosLugar',
	 	};

	 	datos["p1"] = formulario == 1 ? $("#sl-lugar").val() : $("#sl-lugar-d").val();

	 	$.ajax({
	 		url: url_con,
	 		type: 'POST',
	 		data: datos,
	 		dataType: 'json',
	 		success: function(data){
	 			if(formulario == 1){
	 				$("#localidad").text("").text(data["localidad"]);
	 				$("#upz").text("").text(data["upz"]);
	 				$("#entidad").text("").text(data["entidad"]);
	 				$("#barrio").text("").text(data["barrios"]);
	 			}else{
	 				$("#localidad-d").text("").text(data["localidad"]);
	 				$("#upz-d").text("").text(data["upz"]);
	 				$("#entidad-d").text("").text(data["entidad"]);
	 				$("#barrio-d").text("").text(data["barrios"]);
	 			}
	 		},
	 		async: false
	 	});
	 }

	 /**
	 * [getGrupos Función que obtiene el listado de grupos del lugar de atención seleccionado]
	 * @param  {[Int]} formulario [1 formulario sin información, 2 formulario con información]
	 * @return {[select]} [Opciones de grupos]
	 */
	 function getGrupos(formulario){
	 	var mostrar = "";
	 	var datos = {
	 		funcion: 'getGrupos',
	 	};

	 	datos["p1"] = formulario == 1 ? $("#sl-lugar").val() : $("#sl-lugar-d").val();

	 	$.ajax({
	 		url: url_con,
	 		type: "POST",
	 		data: datos,
	 		dataType: 'html',
	 		success: function(data){
	 			mostrar += data;
	 		},
	 		async: false
	 	});
	 	return mostrar;
	 }

	 /**
	 * [getContenidos Función que obtiene el listado de contenidos]
	 * @return {[select]} [Opciones de contenidos]
	 */
	 function getContenidos(){
	 	var datos = {
	 		funcion: 'getContenidos',
	 	};
	 	$.ajax({
	 		url: url_con,
	 		type: "POST",
	 		data: datos,
	 		dataType: 'html',
	 		success: function(data){
	 			select_contenido += data;
	 		},
	 		async: false
	 	});
	 }

	 function selectContenido(){
	 	return select_contenido;
	 }

	 /**
	 * [getBeneficiariosSinInfo Función que obtiene la información de la consulta de entrega de contenidos a beneficiarios sin información]
	 * @return {[html]} [Tabla con información]
	 */
	 function getBeneficiariosSinInfo(){
	 	var datos = {
	 		funcion: 'getBeneficiariosSinInfo',
	 		p1: $("#sl-mes").val()
	 	};
	 	$.ajax({
	 		url: url_con,
	 		type: "POST",
	 		data: datos,
	 		dataType: 'html',
	 		success: function(data){
	 			$("#div-beneficiarios-sin-informacion").html(data);

	 			$("#tabla-beneficiarios-sin-informacion").DataTable({
	 				autoWidth: false,
	 				responsive: true,
	 				pageLength: 100,
	 				dom: 'Blfrtip',
	 				buttons: [{
	 					extend: 'excel',
	 					text: 'Descargar datos',
	 					filename: 'Datos beneficiarios sin información'
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
	 			});

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
	 		},
	 		async: false
	 	});
	 }

	  /**
	  * [Agregar o quitar nueva fila de inputs en la tabla de información de registro de beneficiarios]
	  */
	  $("button").on("click", function(){
	  	if($(this).attr("id") == "bt-agregar"){
	  		id_input++;
	  		$("#tabla-beneficiarios").append("<tr id="+id_input+">"+
	  			"<td>"+id_input+"</td>"+
	  			"<td>"+
	  			"<input type='text' class='form-control input-sm identificacion' placeholder='Identificación' id='tx-identificacion-"+id_input+"' name='tx-identificacion-"+id_input+"' required='required' minlength='3' maxlength='25'>"+
	  			"</td>"+
	  			"<td>"+
	  			"<select class='form-control selectpicker tipo-documento' data-style='btn-default btn-sm' data-width='180px' data-live-search='true' id='sl-tipo-documento-"+id_input+"' name='sl-tipo-documento-"+id_input+"' title='Tipo de documento' required='required'></select>"+
	  			"</td>"+
	  			"<td>"+
	  			"<input type='text' class='form-control input-sm mayuscula' placeholder='P. nombre' id='tx-p-nombre-"+id_input+"' name='tx-p-nombre-"+id_input+"' required='required' minlength='3'>"+
	  			"</td>"+
	  			"<td>"+
	  			"<input type='text' class='form-control input-sm mayuscula' placeholder='S. nombre' id='tx-s-nombre-"+id_input+"' name='tx-s-nombre-"+id_input+"'>"+
	  			"</td>"+
	  			"<td>"+
	  			"<input type='text' class='form-control input-sm mayuscula' placeholder='P. apellido' id='tx-p-apellido-"+id_input+"' name='tx-p-apellido-"+id_input+"' required='required' minlength='3'>"+
	  			"</td>"+
	  			"<td>"+
	  			"<input type='text' class='form-control input-sm mayuscula' placeholder='S. apellido' id='tx-s-apellido-"+id_input+"' name='tx-s-apellido-"+id_input+"'>"+
	  			"</td>"+
	  			"<td>"+
	  			"<input type='date' class='form-control input-sm' placeholder='Fecha de nacimiento' id='tx-f-nacimiento-"+id_input+"' name='tx-f-nacimiento-"+id_input+"' required='required' style='width:140px;'>"+
	  			"</td>"+
	  			"<td>"+
	  			"<select class='form-control selectpicker' data-style='btn-default btn-sm' id='sl-genero-"+id_input+"' name='sl-genero-"+id_input+"' title='Género' data-width='110px' required='required'></select>"+
	  			"</td>"+
	  			"<td>"+
	  			"<select class='form-control selectpicker' data-style='btn-default btn-sm' data-width='160px' data-live-search='true' id='sl-enfoque-"+id_input+"' name='sl-enfoque-"+id_input+"' required='required' title='Enfoque diferencial'></select>"+
	  			"</td>"+
	  			"<td>"+
	  			"<select class='form-control selectpicker' data-style='btn-default btn-sm' id='sl-estrato-"+id_input+"' name='sl-estrato-"+id_input+"' title='Estrato' data-width='50px' required='required'></select>"+
	  			"<input type='hidden' class='form-control input-sm' id='TX_Existe"+id_input+"' name='TX_Existe"+id_input+"'>"+
	  			"</td>"+
	  			"</tr>");

	  		$("#sl-tipo-documento-"+id_input).html(selectTipoDocumento()).selectpicker("refresh");
	  		$("#sl-genero-"+id_input).html(selectGenero()).selectpicker("refresh");
	  		$("#sl-enfoque-"+id_input).html(selectEtnia()).selectpicker("refresh");
	  		$("#sl-estrato-"+id_input).html(selectTPoblacional()).selectpicker("refresh");
	  		$("#tx-f-nacimiento-"+id_input).attr("max", hoy);
	  	}

	  	if($(this).attr("id") == "bt-remover"){
	  		$("#tabla-beneficiarios tr#" + id_input).remove();
	  		if(id_input > 1)
	  			id_input--;
	  	}
	  });
	});