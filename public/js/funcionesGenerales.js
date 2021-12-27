if(window.location.href.includes("Encuesta_Estudiantes_Percepcion_Formadores") ){
	var url_service_options = '../../src/General/Controlador/OptionsController.php';
	var url_service_auditoria = '../../src/Administracion/Controlador/AuditoriaController.php';
	var url_service_af = '../../src/ArtistaFormador/RegistrarAsistenciaController/';
	var url_administracion = "../../src/Administracion/Controlador/AdministracionController.php";
}else{
	var url_service_options = '../src/General/Controlador/OptionsController.php';
	var url_service_auditoria = '../src/Administracion/Controlador/AuditoriaController.php';
	var url_service_af = '../src/ArtistaFormador/RegistrarAsistenciaController/';
	var url_administracion = "../src/Administracion/Controlador/AdministracionController.php";
}




var trama = [];
$(document).on("click","a.eventoClic", eventoClick);
$(document).on("click","button.eventoClic, input[type='button'].eventoClic, input[type='submit'].eventoClic", eventoButton);
function cuandoCargaIframe(){
	$('#ventana_iframe').contents().find("body").on("click","a.eventoClic", eventoClick);
	$('#ventana_iframe').contents().find("body").on("click","button.eventoClic, input[type='button'].eventoClic, input[type='submit'].eventoClic", eventoButton);
}

function refreshNombreImagen(idUsuario) {
	var datos = {
		'funcion':'consultaInformacionUsuarioById',
		p1: idUsuario
	};
	$.ajax({
		url:  url_administracion,
		type:'POST',
		data: datos,
		dataType: "json",
		success: function(datos_usuario) {
			usuario = datos_usuario[0];
			$("#nombre_usuario").html("<span class='fa fa-user'></span> "+usuario.VC_Primer_Nombre+' '+usuario.VC_Primer_Apellido);
			if (usuario.TX_Foto_Perfil == null)
				usuario.TX_Foto_Perfil = "imagenes/iconos/perfil.png";
			$('#imagenUsuario').css('background-image', 'url("'+usuario.TX_Foto_Perfil+'")');
		},
		async : false
	});
}
function validaUrl(url)
{
	if(url.indexOf("/ArtistaFormador/")!=-1 ||
		url.indexOf("/Organizaciones/")!=-1 ||
		url.indexOf("/Estudiante/")!=-1 ||
		url.indexOf("/Pedagogico/")!=-1 )
		return true;
	else return false;

}

function eventoClick(){
	var url = ($(this).prop("href") != undefined && $(this).prop("href") !=null && $(this).prop("href")!="") ? $(this).prop("href") : document.getElementById("ventana_iframe").contentWindow.location.href;
	//console.log(url+" : "+$(this).prop("href"));
	//if(validaUrl(url)){
		var contenidoBoton = "";
		var data = "";
		//var datos=$(this).data(); 		// no actualiza se usará nativo dataset
		var datos=this.dataset;
		if(datos!=undefined && datos!=null){
			$.each(datos,function(key,element) {
				if(key!="tokens"){

					if(data=="")
						data=" Data = " +  key+":"+element+" ";
					else
						data += key+":"+element+" ";
				}
			});
		}
		if($(this).prop("id")!="")
			contenidoBoton += $(this).prop("id");
		if($(this).prop("class")!="")
			contenidoBoton += " - "+$(this).prop("class");

		//console.log(url+" : "+contenidoBoton + data );
		guardarClickUsuario(url+" : "+contenidoBoton + data);
	//}

}

function eventoButton(){
	var url = document.getElementById("ventana_iframe").contentWindow.location.href;
	//if(validaUrl(url)){
		var contenidoBoton = "";
		var data = "";
		//if(!$(this).html().includes("filter-option")){
			//var datos=$(this).data(); 		// no actualiza se usará nativo dataset
			var datos=this.dataset;
			if(datos!=undefined && datos!=null){
				$.each(datos,function(key,element) {
					if(key!="tokens"){

						if(data=="")
							data=" Data = " +  key+":"+element+" ";
						else
							data += key+":"+element+" ";
					}
				});
			}
			if($(this).prop("id")!="")
				contenidoBoton += $(this).prop("id");
			if($(this).prop("value")!="")
				contenidoBoton += " - "+$(this).prop("value");
			if($(this).prop("name")!="")
				contenidoBoton += " - "+$(this).prop("name");
			if($(this).html()!="")
				contenidoBoton += " - "+$(this).html();
			//console.log(url+" : "+contenidoBoton + data );
			guardarClickUsuario(url+" : "+contenidoBoton + data);
		//}

	//}
}



function guardarClickUsuario(urlClick){

	var id_usuario = $("#id_usuario").val();
	var datos = {
		'funcion' : 'guardarClickUsuario',
		'p1': {
			'usuario': id_usuario,
			'url': urlClick

		}//Obtener todos los clanes
	};
	//console.log(JSON.stringify(datos));
	$.ajax({
		url: url_service_auditoria,
		type: 'POST',
		data: datos,
		success: function(data){
			//console.log(data);
		},
		async: false
	});

}

function getOptionsClanes(estado_clan = 0){  // 0 CREAS activos, 1 CREAS inactivos, 2 todos los CREA
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsClanes',
		'p1': estado_clan //Obtener todos los clanes
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsOrganizaciones(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsOrganizaciones'
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsOrganizacionesRol(id_usuario){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsOrganizacionesRol',
		'p1': id_usuario
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsArtistasFormadores(conGrupos){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsArtistasFormadores',
		'p1': conGrupos
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsArtistasFormadoresNidos(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsArtistasFormadoresNidos'
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsAreasArtisticas(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsAreasArtisticas'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsAreasArtisticasPorColegio(listaColegios){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsAreasArtisticasPorColegio',
		'p1': listaColegios
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsColegios(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsColegios'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsColegiosConvenio(convenio, year){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsColegiosConvenio',
		p1:convenio,
		p2:year
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType : 'json',
		success: function(data){
			for (var i = data.length -1; i >=0; i--) {
				mostrar += "<option value='" + data[i]['value'] + "'>" + data[i]['text'] + "</option>";
			}
		},
		async: false
	});
	return mostrar;
}

function getOptionsConveniosByLineaAtencionYear(linea_atencion, year){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsConveniosByLineaAtencionYear',
		p1:linea_atencion,
		p2:year
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType : 'json',
		success: function(data){
			for (var i = data.length -1; i >=0; i--) {
				mostrar += "<option value='" + data[i]['value'] + "'>" + data[i]['text'] + "</option>";
			}
		},
		async: false
	});
	return mostrar;
}

function getOptionsColegiosAtendidos(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsColegiosAtendidos'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsGrados(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsGrados'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsEventosActivos(id_usuario){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsEventosActivos',
		'p1' : id_usuario
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsNovedades(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsNovedades'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;

}

function getGruposDeUnUsuario(id_usuario){
	var tipo_grupo = ['arte_escuela','emprende_clan','laboratorio_clan'];
	var mostrar = "";
	for (var i = 0; i <= tipo_grupo.length - 1; i++) {
		datos = {
			p1: {
				'id_usuario':id_usuario
			},
			p2: {
				'tipo_grupo':tipo_grupo[i]
			}
		};
		$.ajax({
			url:url_service_af+'consultarGruposUsuario',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			mostrar += data;
		}).fail(function(data){
			console.log("fail" + data);
		});
	}
	return mostrar;
}

function getOptionsGruposDeUnColegio(linea,colegioCrea){

	var mostrar = "";
	datos = {
		funcion: 'getOptionsGruposDeUnColegio',
		p1: {
			linea:linea,
			colegioCrea: colegioCrea
		}
	};
	$.ajax({
		url:url_service_options,
		type:'POST',
		data: datos,
		async: false
	}).done(function(data){
		mostrar += data;
	}).fail(function(data){
		console.log("fail" + data);
	});
	return mostrar;
}

function getOptionsTiposDeIdentificacion(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsTiposDeIdentificacion'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsGenero(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsGenero'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsPerfiles(parametro){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsPerfiles',
		'p1': parametro
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getParametroDetalle(parametro){
	var mostrar;
	var datos = {
		'funcion' : 'getParametroDetalle',
		'p1': parametro
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType: "JSON",
		success: function(data){
			mostrar = data;
		},
		async: false
	});
	return mostrar;

}

function getOptionParametroDetalle(parametro){
	var mostrar = "";

	var datos = {
		'funcion' : 'getParametroDetalle',
		'p1': parametro
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType: "JSON",
		success: function(data){
			for (var i = data.length -1; i >=0; i--) {
				mostrar += "<option value='" + data[i]['FK_Value'] + "'>" + data[i]['VC_Descripcion'] + "</option>";
			}
		},
		async: false
	});
	return mostrar;
}

function getOptionParametroDetalleByOrder(parametro, ordenar_por = "FK_Value", orden="ASC"){
	var mostrar = "";

	var datos = {
		'funcion' : 'getParametroDetalleByOrder',
		'p1': parametro,
		'p2': ordenar_por,
		'p3': orden
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType: "JSON",
		success: function(data){
			for (var i = 0; i <data.length; i++) {
				mostrar += "<option value='" + data[i]['FK_Value'] + "'>" + data[i]['VC_Descripcion'] + "</option>";
			}
		},
		async: false
	});
	return mostrar;
}

function getParametroDetalleActivoInactivo(parametro){
	var mostrar;
	var datos = {
		'funcion' : 'getParametroDetalleActivoInactivo',
		'p1': parametro
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType: "JSON",
		success: function(data){
			mostrar = data;
		},
		async: false
	});
	return mostrar;

}
function getPermisosRol(parametro){
	var mostrar;
	var datos = {
		'funcion' : 'getPermisosRol',
		'p1': parametro
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType: "JSON",
		success: function(data){
			mostrar = data;
		},
		async: false
	});
	return mostrar;

}


function getOptionsLineasAtencion(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsLineasAtencion'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsLocalidades(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsLocalidad'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}
function getUsuariosActivos(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getUsuariosActivos'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsLocalidadesGestor(id_usuario){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsLocalidadesGestor',
		'p1': id_usuario
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsUpz(parametro){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsUpz',
		'p1': parametro
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsLugarNidos(parametro){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsLugarNidos',
		'p1': parametro
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getLineasNidos(parametro){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsTipoLugar'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsAnio(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsAnio'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsMes(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsMes'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsGPoblacional(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsGPoblacional'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionGruposDeUnCrea(id_crea){
	var mostrar = "";
	var datos = {
		'funcion': 'getOptionGruposDeUnCrea',
		'p1': {
			'id_crea': id_crea
		}
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		async:false,
		beforeSend: function(){

		}
	}).done(function(data){
		mostrar += data;
	}).fail(function(data){
		alertify.alert("Error","Error no se cargaron los grupos de un crea.");
		console.log(data);
	});
	return mostrar;
}

function getOptionsEPS(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsEPS'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsGSanguineo(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsGSanguineo'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsColegiosCrea(id_crea,muestraDane){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsColegiosCrea',
		p1:{
			'id_crea' : id_crea
		},
		p2:muestraDane
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsLocalidad(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsLocalidad'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsLugarInventario(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsLugarInventario',
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getFormData(form){
	var unindexed_array = form.serializeArray();
	var indexed_array = {};

	$.map(unindexed_array, function(n, i){
		indexed_array[n['name']] = n['value'];
	});

	return indexed_array;
}

function getOptionsParametroDetalle(id_parametro){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsParametroDetalle',
		'p1': id_parametro
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getParametroDetalleProyectoEstado(id_parametro, id_proyecto, estado = null){
	var mostrar = "";
	var datos = {
		'funcion' : 'getParametroDetalleProyectoEstado',
		'p1': id_parametro,
		'p2': id_proyecto,
		'p3': estado //Cuando es 'null' trae activos e inactivos.
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsActividades(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsActividades',
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getOptionsUsuariosRol(id_rol,todos,label){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsUsuariosRol',
		'p1' : id_rol,
		'p2' : todos ,
		'p3' : label
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function getProyectos(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getProyectos',
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		dataType:'json',
		data: datos,
		success: function(data){
			for (var i = 0; i < data.length; i++) {
				mostrar += "<option value='" + data[i]['id'] + "'>" + data[i]['nombre'] + "</option>";
			}
		},
		async: false
	});
	return mostrar;
}

function mostrarCargando(mensaje="Por favor espere, estamos cargando la información solicitada."){
	swal({
        title: "Cargando...",
        text: "Espere un poco por favor.",
        imageUrl: "../framework/public/images/cargando.gif",
        imageWidth: 140,
        imageHeight: 70,
        showConfirmButton: false,
        allowOutsideClick: false,
		allowEscapeKey: false,
        backdrop: `
            rgba(0,0,123,0.4)
        `
        });
}

function cerrarCargando(){
	swal.close();
}

function mostrarAlerta(tipo="error",titulo="Mensaje del sistema",mensaje,ejecutar='',timer_=15000){
	swal({
		type: tipo,
		title: titulo,
		html:mensaje,
		timer: timer_
	}).then(function(){
		eval(ejecutar);
	});
}


function getFechaYHoraServidor(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getFechaYHoraServidor',
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function consultarDatosBasicosUsuario(id_usuario){
	var mostrar = "";
	var datos = {
		'funcion' : 'consultarDatosBasicosUsuario',
		'p1' : id_usuario
	};
	$.ajax({
		url: url_service_options,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}


/*
* funciones para convertir html en pdfmake
*/
function ParseContainer(cnt, e, p, styles = [], tipo = 1) {
	let elements = [];
	let children = e.childNodes;
	if (children.length != 0) {
		for (let i = 0; i < children.length; i++) {
			if($(children[i]).is( "ul")){
				let temp = children[i].outerHTML.replace(/\<\/?p.*?\/?\>/g,"");
				children[i] = $(temp)[0];
				p = ParseElement(elements, $(temp)[0], p, styles,tipo);
			}
			else
				p = ParseElement(elements, children[i], p, styles,tipo);

		}
	}
	if (elements.length != 0) {
		for (let i = 0; i < elements.length; i++) cnt.push(elements[i]);
	}
return p;
}
/**
 * Une los diferentes estilos y los "traduce" para que pdfmake los entienda
 * @param o      variable pdfmake a la que se le aplicaran los estilos
 * @param styles array de estilos del nodo html
 */
 function ComputeStyle(o, styles, tipo) {
 	for (let i = 0; i < styles.length; i++) {
 		let st = styles[i].trim().toLowerCase().split(":");
 		if (st.length == 2) {
 			st[1] = st[1].replace(/ /g, "");
 			switch (st[0]) {
 				case "font-size":{
                    //o.fontSize = parseInt(st[1]);
                    if (tipo == 1)
                    	o.fontSize = 10;
                    else
                    	o.fontSize = 12;
                    break;
                }
                case "text-align": {
                	switch (st[1]) {
                		case "right": o.alignment = 'right'; break;
                		case "center": o.alignment = 'center'; break;
                		case "justify": o.alignment = 'justify'; break;
                	}
                	break;
                }
                case "font-weight": {
                	switch (st[1]) {
                		case "bold": o.bold = true; break;
                	}
                	break;
                }
                case "text-decoration": {
                	switch (st[1]) {
                		case "underline": o.decoration = "underline"; break;
                	}
                	break;
                }
                case "font-style": {
                	switch (st[1]) {
                		case "italic": o.italics = true; break;
                	}
                	break;
                }
                case "background-color": {
                	color = st[1];
                	if (color != 'transparent' && color != 'inherit') {
                		if (st[1].indexOf('rgb') > -1) {
                			let colors = st[1].replace("rgb(","").replace(")","").replace(/ /g,"").split(",");
                			color = rgbToHex(parseInt(colors[0]),parseInt(colors[1]),parseInt(colors[2]));
                		}
                		o.background = color;
                	}
                	break;
                }
            }
        }
    }
}
/**
* convierte un elemento html a la estructura de pdfmake
* @param Array      cnt    contenedor final donde quedará el html en estructura pdfmake
* @param $(html)        e      elemento html
* @param Array pdfmake p      contenedor con la estructura principal a utilizar para el nodo
* @param array      styles array que contiene los estilos que se le estan aplicando a un nodo
*/
var contadorTabas = 0;
var rowspanTerm =0 ;
var tdPos = {} ;
var tdcount =0 ;
function ParseElement(cnt, e, p, styles = [] , tipo = 1){
	var tempWidth = 0;
	var tempHeight = 0;
	if (!styles) styles = [];
	if (e.getAttribute) {
		let nodeStyle = e.getAttribute("style");
		if (nodeStyle && e.nodeName.toLowerCase() == "img") {
			let ns = nodeStyle.split(";");
			for (let k = 0; k < ns.length; k++) {
				if (ns[k].indexOf("width") > -1) {
					tempWidth = parseInt(ns[k].split(":")[1].replace("px",""));

				}
				else{
					if (ns[k].indexOf("height") > -1) {
						tempHeight = parseInt(ns[k].split(":")[1].replace("px",""));

					}
					else
						styles.push(ns[k]);
				}

			}
		}
		if (nodeStyle && e.nodeName.toLowerCase() != "img") {
			let ns = nodeStyle.split(";");
			for (let k = 0; k < ns.length; k++) styles.push(ns[k]);
		}
        //
    }
    switch (e.nodeName.toLowerCase()) {
    	case "#text": {
    		let t = { text: e.textContent.replace(/\n/g, "") };
    		if (styles) ComputeStyle(t, styles,tipo);
    		p.text.push(t);
    		break;
    	}
    	case "b":case "strong": {
    		ParseContainer(cnt, e, p, styles.concat(["font-weight:bold"]),tipo);
    		break;
    	}
    	case "a": {
    		ParseContainer(cnt, e, p, styles,tipo);
    		break;
    	}
    	case "u": {
    		ParseContainer(cnt, e, p, styles.concat(["text-decoration:underline"]),tipo);
    		break;
    	}
    	case "i": {
    		ParseContainer(cnt, e, p, styles.concat(["font-style:italic"]),tipo);
    		break;
    	}
    	case "span": {
    		ParseContainer(cnt, e, p, styles,tipo);
    		break;
    	}
    	case "h5": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles,tipo);
    		cnt.push(p);
    		break;
    	}
    	case "h3": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles.concat(["font-weight:bold"]),tipo);
    		cnt.push(p);
    		break;
    	}
    	case "h1": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles.concat(["font-weight:bold"]),tipo);
    		cnt.push(p);
    		break;
    	}
    	case "h2": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles.concat(["font-weight:bold"]),tipo);
    		cnt.push(p);
    		break;
    	}
    	case "h4": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles,tipo);
    		cnt.push(p);
    		break;
    	}
    	case "o:p": case "w:sdt": case "w:sdtpr": case "#comment": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles,tipo);
    		cnt.push(p);
    		break;
    	}
    	case "h6": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles,tipo);
    		cnt.push(p);
    		break;
    	}
    	case "h7": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles,tipo);
    		cnt.push(p);
    		break;
    	}
    	case "h8": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles,tipo);
    		cnt.push(p);
    		break;
    	}
    	case "blockquote": {
    		p = CreateParagraph();
    		ParseContainer(cnt, e, p, styles,tipo);
    		cnt.push(p);
    		break;
    	}
    	case "br": {
    		p = CreateParagraph();
    		p.text.push("\n");
    		cnt.push(p);
    		break;
    	}
    	case "table":
    	{
    		tdPos = {};
    		let t = {
    			table: {
    				widths: [],
    				body: []
    			}
    		}
    		let border = e.getAttribute("border");
    		let isBorder = false;
    		if (border) if (parseInt(border) == 1) isBorder = true;
    		ParseContainer(t.table.body, e, p, styles,tipo);
    		contadorTabas++;
    		let widths = e.getAttribute("widths");
    		if (!widths && t.table.body[0] != undefined) {
    			let tamano = '*';
    			let cant = 0;
    			if (t.table.body[0].length != 0 && t.table.body[0][0].colSpan != undefined) {
    				cant = t.table.body[0][0].colSpan;
    				if (t.table.body[0].length > 1) {
    					cant = cant + t.table.body[0].length - 1;
    				}

    			}
    			else {
    				cant = t.table.body[0].length;
    			}
    			if (t.table.body[0] != undefined) {
    				if (tipo == 1)
    					tamano = 230 / cant;

    			}
    			if (t.table.body.length != 0) {
    				if (t.table.body[0].length != 0){
    					for (let k = 0; k < cant; k++) 
    						t.table.widths.push(tamano);
    				}
    			}
    		} else {
    			if (widths != null) {
    				let w = widths.split(",");
    				for (let k = 0; k < w.length; k++)
    					t.table.widths.push(w[k]);
    			}
    		}	
    	//
    	if (t.table.body.length != 0) {
    		console.log(t);
    		console.log(contadorTabas);
    		cnt.push(t);
    	}
    	break;
    }
    case "tbody": {
    	ParseContainer(cnt, e, p, styles,tipo);
    	break;
    }
    case "tr": {
    	let row = [];
    	tdcount = 0;
    	ParseContainer(row, e, p, styles,tipo);
    	console.log("row") ;
    	console.log(row) ;
    	cnt.push(row);
    	break;
    }
    case "ul": {
    	let row =  {ul: []};
    	ParseContainer(row.ul, e, p, styles,tipo);
    	cnt.push(row);
    	break;
    }
    case "ol": {
    	let row =  {ol: []};
    	ParseContainer(row.ol, e, p, styles,tipo);
    	cnt.push(row);
    	break;
    }
    case "li": {
    	p = CreateParagraph();
    	let st = {text: []};
    	st.text.push(p);
    	ParseContainer(st.text, e, p, styles,tipo);
    	cnt.push(st);
    	break;
    }
    case "td": {
    	tdcount++;
    	if (tdPos[tdcount] > 0){
    		tdPos[tdcount]--;
    		ParseElement(cnt, $('<td></td>')[0], p, styles.concat(["font-size:10px"]),tipo);

    	}
    	p = CreateParagraph();
    	let st = {stack: []}
    	st.stack.push(p);


    	let rspan = e.getAttribute("rowspan");
    	if (rspan) {
    		st.rowSpan = parseInt(rspan);
    	}

    	let cspan = e.getAttribute("colspan");
    	if (cspan) st.colSpan = parseInt(cspan);


    	ParseContainer(st.stack, e, p, styles.concat(["font-size:10px"]),tipo);
    	cnt.push(st);
    	if (cspan){
    		for (var i = 0; i < cspan-1; i++) {
    			tdcount++;
    			ParseElement(cnt, $('<td></td>')[0], p, styles.concat(["font-size:10px"]),tipo);
    		}
    	}
    	if (rspan) {
    		tdPos[tdcount] = parseInt(rspan) -1 ;
    	}
    	break;
    }
    case "th": {
    	tdcount++;
    	if (tdPos[tdcount] > 0){
    		tdPos[tdcount]--;
    		ParseElement(cnt, $('<td></td>')[0], p, styles.concat(["font-size:10px"]),tipo);

    	}
    	p = CreateParagraph();
    	let st = {stack: []}
    	st.stack.push(p);


    	let rspan = e.getAttribute("rowspan");
    	if (rspan) {
    		st.rowSpan = parseInt(rspan);
    	}

    	let cspan = e.getAttribute("colspan");
    	if (cspan) st.colSpan = parseInt(cspan);


    	ParseContainer(st.stack, e, p, styles.concat(["font-size:10px"]),tipo);
    	cnt.push(st);
    	if (cspan){
    		for (var i = 0; i < cspan-1; i++) {
    			tdcount++;
    			ParseElement(cnt, $('<td></td>')[0], p, styles.concat(["font-size:10px"]),tipo);
    		}
    	}
    	if (rspan) {
    		tdPos[tdcount] = parseInt(rspan) -1 ;
    	}
    	break;
    }
    case "img": {
    	if (e.src.indexOf("Base64") == -1 && e.src.indexOf("base64") == -1 ) {
    		var datos = {
    			'funcion' : 'getBase64Url',
    			'p1': e.src
    		};
    		$.ajax({
    			url: url_service_options,
    			type: 'POST',
    			async: false,
    			data: datos,
    			success: function(base64Img){
    				let st = {image: base64Img};
    				width = e.width;
    				height = e.height;
    				if (tempWidth != 0)
    					width = tempWidth;
    				if (tempHeight == 0)
    					height = tempHeight;
    				if (tipo == 1) {
    					st.width = width/3;
    					st.height = height/3;		
    				}
    				else{
    					st.width = width > 500 ? 500 : width;
    					st.height = width > 500 ? '' : height;
    				}
    				ComputeStyle(st, styles,tipo);

    				cnt.push(st);
    				p = CreateParagraph();
    				cnt.push(p);
    			},
    			async: false
    		});
    	}   
    	else{
    		let st = {image: e.src};
    		width = e.width;
    		height = e.height;
    		if (tempWidth != 0)
    			width = tempWidth;
    		if (tempHeight == 0)
    			height = tempHeight;
    		if (tipo == 1) {
    			st.width = width/3;
    			st.height = height/3;		
    		}
    		else
    		{
    			st.width = width > 500 ? 500 : width;
    			st.height = width > 500 ? '' : height;
    		}
    		ComputeStyle(st, styles,tipo);

    		cnt.push(st);
    		p = CreateParagraph();
    		cnt.push(p);
    	} 	
    	break;
    }
    case "div": {
    	p = CreateParagraph();
    	let st = {stack: []}
    	st.stack.push(p);
    	ComputeStyle(st, styles,tipo);
    	ParseContainer(st.stack, e, p,[],tipo);
    	cnt.push(st);
    	break;
    }
    case "p": {
    	p = CreateParagraph();
    	p.margin = [0,0,0,7];
    	let st = {stack: []}
    	st.stack.push(p);
    	ComputeStyle(st, styles,tipo);
    	ParseContainer(st.stack, e, p,[],tipo);
    	cnt.push(st);
    	break;
    }
    default: {
    	console.log("Parsing for node " + e.nodeName + " not found");
    	break;
    }
}
return p;
}
/**
 * funcion principal para convertir html en pdfmake
 * @param {array} cnt      contenedor donde quedará el html en estructura pdfmake
 * @param {text} htmlText  html en formato text
 */

 function ParseHtml(cnt, htmlText,tipo = 1) {
 	contadorTabas = 0;
 	var reg = /\<\/?FONT.*?\/?\>/gi;
    let html = htmlText.replace(/\t/g, "").replace(/\<\/?FONT.*?\/?\>/gi, "");;//.replace(/<font/g, "<span").replace(/font>/g, "span>");
    let p = CreateParagraph();
    for (let i = 0; i < $(html).length; i++) ParseElement(cnt, $(html).get(i), p ,[] ,tipo);
}
/**
 * Generador basico de un contenedor para un parrafo
 * retorna el contenedor
 */
 function CreateParagraph() {
 	let p = {text:[]};
 	return p;
 }
/**
 * convierte un numero decimal a hexadecimal
 * @param  {int} c numero que se desea convertir
 * @return {int}   numero hexa
 */
 function componentToHex(c) {
 	let hex = c.toString(16);
 	return hex.length == 1 ? "0" + hex : hex;
 }
/**
 * convierte tres numeros correspondientes a rgb a un color en hexadecimal
 * @param  {int}    r red
 * @param  {int}    g green
 * @param  {int}    b blue
 * @return {text}   retorna el valor hexa de un color rgb
 */
 function rgbToHex(r, g, b) {
 	return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
 }

 function getParametros(){
 	var mostrar = "";
 	var datos = {
 		'funcion' : 'getParametros'
 	};
 	$.ajax({
 		url: url_service_options,
 		type: 'POST',
 		data: datos,
 		success: function(data){
 			mostrar += data;
 		},
 		async: false
 	});
 	return mostrar;
 }

 function getTiposIndicadores(in_seccion){
 	var mostrar = "";
 	var datos = {
 		'funcion' : 'getTiposIndicadores',
 		'p1': in_seccion
 	};
 	$.ajax({
 		url: url_service_options,
 		type: 'POST',
 		data: datos,
 		success: function(data){
 			mostrar += data;
 		},
 		async: false
 	});
 	return mostrar;

 }

 function getAllTiposIndicadores(){
 	var mostrar = "";
 	var datos = {
 		'funcion' : 'getAllTiposIndicadores'
 	};
 	$.ajax({
 		url: url_service_options,
 		type: 'POST',
 		data: datos,
 		success: function(data){
 			mostrar += data;
 		},
 		async: false
 	});
 	return mostrar;

 }

 function getTipoDeGraficas(){
 	var mostrar = "";
 	var datos = {
 		'funcion' : 'getTipoDeGraficas'
 	};
 	$.ajax({
 		url: url_service_options,
 		type: 'POST',
 		data: datos,
 		success: function(data){
 			mostrar += data;
 		},
 		async: false
 	});
 	return mostrar;
 }

 function getOptionsFormatosPedagogicos(){
 	var mostrar = "";
 	var datos = {
 		'funcion' : 'getOptionsFormatosPedagogicos'
 	};
 	$.ajax({
 		url: url_service_options,
 		type: 'POST',
 		data: datos,
 		success: function(data){
 			mostrar += data;
 		},
 		async: false
 	});
 	return mostrar;
 }

 function getTipoDeFiltrosGraficos(){
 	var mostrar = "";
 	var datos = {
 		'funcion' : 'getTipoDeFiltrosGraficos'
 	};
 	$.ajax({
 		url: url_service_options,
 		type: 'POST',
 		data: datos,
 		success: function(data){
 			mostrar += data;
 		},
 		async: false
 	});
 	return mostrar;
 }

 function diasDuracionEvento(id_evento){
 	var fecha_inicio = "";
 	var fecha_fin = "";
 	datos = {
 		p1: {
 			'id_evento':id_evento
 		}
 	};
 	$.ajax({
 		url:'../src/ArtistaFormador/RegistrarAsistenciaController/consultarFechaInicioYFechaFinEvento',
 		type:'POST',
 		data: datos,
 		async: false
 	}).done(function(data){
 		if(data != ""){
 			try{
 				data = $.parseJSON(data)[0];
 				fecha_inicio = data['DT_Fecha_Inicio'].split(" ")[0];
 				fecha_fin = data['DT_Fecha_Fin'].split(" ")[0];
 			}catch(ex){
 				mostrarAlerta("warning","Advertencia!!","No se ha podido decodificar el JSON de fechas de inicio y fin del evento");
 				console.log("Excepcion: " + ex + data);
 			}
 		}
 	}).fail(function(data){
 		mostrarAlerta("error","Error!","No se ha podido cargar las fechas de inicio y fin del evento.");
 	});
 	return [fecha_inicio,fecha_fin];
 }

 function getOptionsGruposLineaArea(year,linea,area_artistica){
 	var mostrar = "";
 	datos = {
 		funcion: 'getOptionsGruposLineaArea',
 		p1: {
 			anio:year,
 			linea:linea,
 			area: area_artistica
 		}
 	};
 	$.ajax({
 		url:url_service_options,
 		type:'POST',
 		data: datos,
 		async: false
 	}).done(function(data){
 		mostrar += data;
 	}).fail(function(data){
 		console.log("fail" + data);
 	});
 	return mostrar;
 }

 function getEspaciosCREA(id_crea){
	var mostrar;
	var datos = {
		'funcion' : 'getEspaciosCrea',
		'p1': id_crea
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType: "JSON",
		success: function(data){
			for (var i = 0 ; i < data.length; i++) {
				mostrar += "<option value='" + data[i]['PK_Id_Salon'] + "'>" + data[i]['VC_Nombre'] + "</option>";
			}
		},
		async: false
	});
	return mostrar;
}

function getListadoTodosBeneficiariosGrupo(id_grupo, tipo_grupo){
	var mostrar = "";
	var datos = {
		funcion : 'getListadoTodosBeneficiariosGrupo',
		p1:id_grupo,
		p2:tipo_grupo,
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function consultarGruposActivosActualmente(){
	var mostrar = "";
	var datos = {
		funcion : 'consultarGruposActivosActualmente'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(resul){
		mostrar += resul;
	});
	return mostrar;
}

function getCargos(){
	var mostrar = {};
	var datos = {
		'funcion' : 'getListadoCargos'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType: 'json',
		success: function(data){
			mostrar = data;
		},
		async: false
	});
	return mostrar;
}

function consultarZonas(){
	var mostrar = "";
	var datos = {
		funcion : 'consultarZonas'
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(resul){
		mostrar += resul;
	});
	return mostrar;
}

function getOptionsBarriosLocalidad(id_localidad){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsBarriosLocalidad',
		p1:id_localidad
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		dataType: "JSON",
		success: function(data){
			for (var i = 0 ; i < data.length; i++) {
				mostrar += "<option value='" + data[i]['PK_Id_Tabla'] + "'>" + data[i]['VC_Barrio'] + "</option>";
			}
		},
		async: false
	});
	return mostrar;
}

 function convertImgToBase64(url, callback, outputFormat){
 	var img = new Image();
 	img.crossOrigin = 'Anonymous';
 	img.onload = function(){
 		var canvas = document.createElement('CANVAS');
 		var ctx = canvas.getContext('2d');
 		canvas.height = this.height;
 		canvas.width = this.width;
 		ctx.drawImage(this,0,0);
 		var dataURL = canvas.toDataURL(outputFormat || 'image/png');
 		callback(dataURL);
 		canvas = null; 
 	};
 	img.src = url;
 }

 function getOptionsColegiosCreaNew(id_crea,anio){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsColegiosCreaNew',
		p1:{
			'id_crea' : id_crea
		},
		p2:anio
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}