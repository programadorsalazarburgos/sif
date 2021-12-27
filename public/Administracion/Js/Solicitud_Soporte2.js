//var url_service = '../../Controlador/Administracion/C_Solicitud_Soporte.php';
var url_service = '../../src/Administracion/Controlador/AdministracionController.php';
//var url_service = '../src/Administracion/Controlador/AdministracionController.php'; 
var incidenteCodigo=null; 
$(function(e){
	//cargaActividadesUsuario();
	desHabilitarCampos();
	cargarDatosUsuario();	

	var url = window.location.href;
	if(url.indexOf("#historico_soportes")!=-1){
		$("#ver_historico").trigger('click'); 
		cargarHistoricoSolicitudes();   
	}
	/*efecto borde animado sobre el div*/
	$("#div_SL_observadores").on("click",function(e){
		$("#div_SL_observadores").css("overflow", "visible");
	});

	$("#div_SL_observadores").on("mouseleave",function(e){
		$("#div_SL_observadores").css("overflow", "hidden");
	});

	$('#TX_solicitud').summernote({
		  height: 100,                 // set editor height
		  minHeight: null,             // set minimum height of editor
		  maxHeight: null,             // set maximum height of editor
		  placeholder: 'Detalle su incidente..., recuerde que ahora puede insertar videos e imagenes del clipboard con CTRL+V ',
		  lang: 'es-ES'
		});
	$('#observacionesIncidente').summernote({
		  height: 100,                 // set editor height
		  minHeight: null,             // set minimum height of editor
		  maxHeight: null,             // set maximum height of editor
		  placeholder: 'Detalle su incidente..., recuerde que ahora puede insertar videos e imagenes del clipboard con CTRL+V ',
		  lang: 'es-ES'
		});
 

    $('#archivos_adjuntos_incidente').hide();
    
	$("#BT_enviar_solicitud").click(function(){
		if($("#TX_solicitud").summernote('code').length < 50 || $("#titulo").val().length < 5 ){
			//alert("Debe diligenciar detalle y título de la solicitud");
			/*alertify.set('notifier','position', 'top-right');
			alertify 
			  .alert("Mensaje de SICLAN","Debe especificar más el detalle (Minimo 70 caracteres) y título (Minimo 5 caracteres) de la solicitud", function(){});  			*/
			parent.mostrarAlerta('warning','Mensaje del sistema',"Debe especificar más el detalle (Minimo 70 caracteres) y título (Minimo 5 caracteres) de la solicitud",'',null); 
		}else{
			//limite para MEDIUMTEXT equivalente a 16777216 caracteres
			if($("#TX_solicitud").summernote('code').length > Math.pow(2,24))
				parent.mostrarAlerta('warning','Mensaje del sistema',"El mensaje no debe exceder los "+Math.pow(2,24)+" caracteres",'',null); 
				//alertify.alert("Mensaje de SICLAN","El mensaje no debe exceder los "+Math.pow(2,24)+" caracteres", function(){}); 
			else 					
			agregarSolicitudSoporte(e);
		} 
	});

	$("#ver_historico").click(function(){
		cargarHistoricoSolicitudes();
	});

	/* click en pestaña formulario*/
	$("#formulario").click(function(){ 
		$("#div_SL_observadores > .input-group").trigger('mouseenter'); 
	});	

	$("#SL_tipo_soporte").html(getTiposSoporte()).selectpicker('refresh'); 	
	$("#SL_observadores").html(parent.getOptionsUsuariosRol(parent.$('#id_rol').val(),1,'Usuarios Activos en el sistema')).selectpicker('refresh');
	$("#SL_tipo_soporte").change(function(){ 
		//if($(this).val()=='0') 
			desHabilitarCampos();
		if($(this).val()=='4'){
			cargaActividadesUsuario(); 
			habilitarCampos();
		} 
		else if($(this).val()!='0') 
			habilitarCampos();

	});
	$('#TFK_Actividad_Apertura').on('click', function(){
		cargaActividadesUsuario(); 
		habilitarCampos();		
	});
	$('input[type=file]').on('change', prepareUpload);
	//requerido para que funcione el responsive
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } ); 
 
 	$( "#modal_observaciones" ).on('shown.bs.modal', function(){ 
	    $("#guardarObservacion").prop("disabled",false);  
	});

    //Eventos boton de observaciones

	var table_observacion_incidentes = $("#table_observacion_incidentes").DataTable({
		responsive: true,
		"language": {	
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
			"search": "Filtrar"
		}
	});
		
    $("body").delegate(".linkObservaciones","click",function(){    	

   		$("#incidente_codigo").val($(this).data("incidente")); 
   		$("#observadores").val($(this).data("observadores")); 
   		$("#atendido").val($(this).data("atendido")); 
   		$("#estado").val($(this).data("estado")); 
   		$("#usuario").val($(this).data("usuario")); 
   		if($("#estado").val()=='cerrado'){ 
   			$(".div_cerrarIncidente").show();			
   		}else{
   			$(".div_cerrarIncidente").hide();
   		}
		mostrarObservacionesIncidente();
		mostrarAdjuntosIncidente();
   });    

	$("#guardarObservacion").click(function(){
		if($("#tipoObservacion").val()==''){  
			//alert("Debe diligenciar detalle de la observación"); 
			//alertify.set('notifier','position', 'top-right');
			//alertify.alert("Mensaje de SIF","Debe diligenciar el tipo de observación", function(){});  			
			parent.mostrarAlerta('warning','Mensaje del sistema',"Debe diligenciar el tipo de observación",'',null); 
		}else{
			//console.log('tipoObservacion: ('+$("#tipoObservacion").val()+') type: '+typeof($("#tipoObservacion").val())); 
			//limite para MEDIUMTEXT equivalente a 16777216 caracteres
			if($("#observacionesIncidente").summernote('code').length > Math.pow(2,24) ||
			   $("#observacionesIncidente").summernote('code').length < 20 ) 
				//alertify.alert("Mensaje de SIF","El mensaje debe contener mas contenido y no debe exceder los "+Math.pow(2,24)+" caracteres ("+$("#observacionesIncidente").summernote('code').length+")", function(){}); 
				parent.mostrarAlerta('warning','Mensaje del sistema',"El mensaje debe contener mas contenido y no debe exceder los "+Math.pow(2,24)+" caracteres ("+$("#observacionesIncidente").summernote('code').length+")",'',null); 
			else{
				$("#guardarObservacion").prop("disabled",true);
				agregarObservacionIncidente(); //notificar a los usuarios observadores cuando se añade una observación y al que funcionario que responde
				//Si re abrir incidente....
				if($("#cerrarIncidente").prop( "checked")==true && $("#estado").val()=='cerrado') {					
					var estado="'abierto'"; 				
					ajaxCambiarEstadoIncidente(estado);
				} 				
			}
			$("#modal_observaciones").modal('hide');
		}
	});

	function ajaxCambiarEstadoIncidente(estado){
		datos = { 
			funcion: 'cambiarDatosIncidente',
			p1: {
				codigo : $("#incidente_codigo").val(), 
				sla_codigo: $("#sla_codigo").val(),
				estado: estado,
				fecha_cierre: ''
			},
			p2: 'cerrado',   
			p3: $("#id_usuario").val()  
		};
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos, 
			success: function(data){
				var mensaje="";
				console.log(data); 
				if(data){ 
					mensaje='Se cambio el estado del incidente # <strong style="color:red;">'+$("#incidente_codigo").val()+'</strong> a '+estado; 
					tab="";
					//enviarNotificaciones(mensaje,tab);	
					parent.mostrarAlerta('success','Mensaje del sistema',mensaje,'',null); 								
					$('#tx_solucion').summernote('code', '');					
				}
				else{
					parent.mostrarAlerta('warning','Mensaje del sistema','No fue posible actualizar los datos del incidente','',null); 
				} 		
			},
			error: function( jqXHR, textStatus, errorThrown){			
				$("#actividades").html("Presentamos disculpas, ocurrio un error  " + textStatus + " / " + errorThrown ); 
			} 					
		});	 				
	}

	function enviarNotificaciones(mensaje,tab){		
		//Envia a quien atiende
		if($("#atendido").val()!=""){			
			var notificacion = {
				VC_Url:"Administracion/Solucion_Soporte2.php"+tab, 
				VC_Icon:"fa fa-list-alt",
				VC_Contenido:mensaje,
				userId:$("#atendido").val(),
				//email:1
			} 
			window.parent.sendNotificationUser(notificacion);
		}
		//Enviar Notificación a observadores
		res = $("#observadores").val().split(",");
		$.each(res,function(i, selected){ 
			if($("#id_usuario").val() != selected){				
				var notificacion = {
					VC_Url:"Administracion/Solicitud_Soporte2.php#historico_soportes", 
					VC_Icon:"fa fa-list-alt",
					VC_Contenido:mensaje,
					userId:selected,
					//email:1
				} 			
				window.parent.sendNotificationUser(notificacion);						
			}
		});
		//Envia a quien regisro el incidente
		if($("#id_usuario").val() != $("#usuario").val()){				
			var notificacion = {
				VC_Url:"Administracion/Solicitud_Soporte2.php#historico_soportes", 
				VC_Icon:"fa fa-list-alt",
				VC_Contenido:mensaje,
				userId:$("#usuario").val(),
				email:1
			} 			
			window.parent.sendNotificationUser(notificacion);						
		}			 		
	}
 
	function mostrarObservacionesIncidente()
	{ 
		table_observacion_incidentes.clear().draw();
		$("#tituloObservaciones").html('Observaciones incidente: '+$("#incidente_codigo").val());
		datos = {
			funcion: 'getObservacionesIncidente', 
			p1: {
				incidente_codigo :  $("#incidente_codigo").val(),
				sla_codigo: $("#sla_codigo").val()				
			}, 
			p2: {
				usuario: $("#id_usuario").val() 
			}    
		};
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos,
			success: function(data){					
				datos=JSON.parse(data);	
				//console.log(datos);
				$.each(datos.observaciones, function(i) 
				{
					var fila = table_observacion_incidentes.row.add( [
						datos.observaciones[i].fecha,
						datos.observaciones[i].nombre,
						datos.observaciones[i].observaciones
						]).draw().node();
					if(datos.observaciones[i].tipo_observacion=="1")
						$(fila).addClass("alert alert-info");  
					//habilitar el Toogle de re abrir
				});			
				if(!datos.tipoObservacion) {
					$("#tipoObservacion").val('0').selectpicker('refresh');
					$("#tipoObservacion").prop( "disabled", true );
				}
			},
			error: function( jqXHR, textStatus, errorThrown){			
				$("#actividades").html("Presentamos disculpas, ocurrio un error  " + textStatus + " / " + errorThrown ); 
			} 
		});		
	}

	function agregarObservacionIncidente()
	{  
		var observaciones =  $('#observacionesIncidente').summernote('code');
		datos = {
			funcion: 'addObservacionesIncidente', 
			p1: {
				incidente_codigo : $("#incidente_codigo").val(),
				fk_id_persona: $("#id_usuario").val(),
				observaciones: observaciones,
				tipo_observacion: $("#tipoObservacion").val(),
				sla_codigo:$("#sla_codigo").val()
				
			} 

		};	
		$.ajax({
			url: url_service,
			type: 'POST',
			data: datos,
			success: function(data){
				console.log(data); 
				incidenteCodigo=data;

				//console.log('incidenteCodigo: '+incidenteCodigo); 
				if(!data) 
					respuestaObservacion='No ha sido posible crear la observación';
				else{

					respuestaObservacion='Se ha añadido una observación para el incidente # <strong style="color:red;">'+$("#incidente_codigo").val()+'</strong><br>';
					tab="#historico_soportes";   
					enviarNotificaciones(respuestaObservacion,tab);						
				}
				//alertify.set('notifier','position', 'top-right');
				/*alertify
				  .alert("Mensaje de SIF",respuestaObservacion, function(){
					$('#observacionesIncidente').summernote('code', '');
				  	mostrarObservacionesIncidente();
				    //alertify.success('Revise el estado de los incidentes en la pestaña Historico mis soportes');
				  }); */
				parent.swal({
  					type:"success", 
				  	title: 'Mensaje del sistema',		
			    	html:respuestaObservacion,
			    	//timer: 3000
			  	}).then(() => {							
					$('#observacionesIncidente').summernote('code', '');
				  	mostrarObservacionesIncidente();
			  	});				  
			}
		});	

	}
	    

});

function cargaActividadesUsuario(){
	datos = {
		funcion: 'getActividadesUsuario',
		p1:      $("#id_usuario").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			$("#actividades").html(data);
			$("#modal_actividades").modal({backdrop: 'static',
  										   keyboard: false});  
			//d = $.parseJSON(data);			
		},
		error: function( jqXHR, textStatus, errorThrown){			
			$("#actividades").html("Presentamos disculpas, ocurrio un error  " + textStatus + " / " + errorThrown ); 
		} 
	});	
}

function cargarDatosUsuario(){
	datos = {
		funcion: 'getDatosUsuarioById',
		p1: $("#id_usuario").val() 
	}
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		//dataType: 'json',
		success: function(data){
			//console.log(data);
			d = $.parseJSON(data)[0];
			//console.log(d);
			$("#TB_nombre_usuario").val(d['nombre']);
			$("#TB_identificacion_usuario").val(d['identificacion']);
			$("#TB_correo_usuario").val(d['correo']);
			$("#sla_codigo").val(d['sla']); 
		},
		async: false
	});
}

function agregarSolicitudSoporte(e){
	var fk_observadores="";
	var observadores=0; 
	$('#SL_observadores :selected').each(function(i, selected){ 
		if(fk_observadores=="") fk_observadores = $(selected).val();
		else fk_observadores += ","+$(selected).val();
		observadores++;
	});		 
	if(observadores>=15){		
		parent.swal({
			title: "Mensaje de confirmación",
			html: "Esta seguro de querer copiar este incidente a "+observadores+" usuarios?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si',
			showCancelButton: true,
			cancelButtonText: 'No, cancelar!',
			//reverseButtons: true,
		}).then(() => {
			adicionarSolicitudSoporte(e);
			
		},function(dismiss) {
			console.log(dismiss);
			if (dismiss == 'cancel') {
				parent.swal({
  					type:"success",
				  	title: "Mensaje del sistema",		
			    	html:"Seleccione los observadores del incidente",
			    	//timer: 3000
			  	}).then(() => {
					$('#SL_observadores').selectpicker('val', '');
					$("#SL_observadores").selectpicker('refresh');
			  	}); 
				
			}
		}).catch(parent.swal.noop); 
	}
	else{ 
		adicionarSolicitudSoporte(e);
	} 


}

function adicionarSolicitudSoporte(e){
	var apertura = $("#FK_Actividad_Apertura").val();	
	var sintomas =  $("#TX_solicitud").summernote('code');
	var fk_observadores = "";
	$('#SL_observadores :selected').each(function(i, selected){ 
		if(fk_observadores=="") fk_observadores = $(selected).val();
		else fk_observadores += ","+$(selected).val();
	});		
	var datos = {
		funcion: 'addSolicitudSoporte',
		p1: {
			fk_id_usuario: $("#id_usuario").val(),
			fk_tipo_soporte: $("#SL_tipo_soporte").val(),
			titulo: $("#titulo").val(),		
			descripcion_sintomas: sintomas,
			sla_codigo: $("#sla_codigo").val(),
			fk_observadores: fk_observadores 

		}  
	};
	if(apertura!=='')
		datos.p1.fk_actividad_apertura= apertura;
	var combinedSize = 0; 
	for(var i=0;i<($("#archivos_incidente"))[0].files.length;i++) 
		combinedSize += (($("#archivos_incidente"))[0].files[i].size);

	if(combinedSize>3145728)
		alert("El tamaño de los archivos excede el limite establecido: 3 Megabytes.");
	else
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		async: false,
		success: function(data){
			//alert(data);
			incidenteCodigo=data;
			var subidos=null;
			//console.log('incidenteCodigo: '+incidenteCodigo); 

				if(!data) 
					respuestaIncidente='No ha sido posible crear el incidente';
				else{ 
					$("#BT_enviar_solicitud").prop("disabled",true);
					respuestaIncidente='Se ha Creado el incidente # <strong style="color:red;">'+incidenteCodigo+'</strong><br>';			 
					respuestaIncidenteNotificacion=respuestaIncidente+' En el cual ha sido añadido como observador';
					$('#SL_observadores :selected').each(function(i, selected){ 
						var notificacion = {
							VC_Url:"Administracion/Solicitud_Soporte2.php#historico_soportes", 
							VC_Icon:"fa fa-list-alt",
							VC_Contenido:respuestaIncidenteNotificacion,
							userId:$(selected).val(),
							email:1
						} 
						window.parent.sendNotificationUser(notificacion);						
					}); 					
				}
			$("#respuestaFinal").append(respuestaIncidente);
			if(($("#archivos_incidente"))[0].files.length > 0)
	        	subirAdjuntosIncidente(e);
	        else
	        	mensajeFinal();
 			

			//alert("Se ha enviado correctamente su solicitud, recuerde verificar la respuesta en la pestaña de 'Historico mis soportes'");
			//$("#TX_solicitud").val("");
		}
	});	
}

function cargarHistoricoSolicitudes(){
	$("#table_historico_solicitudes > tbody").html("");
	//alert("entra a cargar historico");
	var table_historico_solicitudes	= null;
	var datos = {
		funcion: 'getHistoricoSolicitudes',
		p1: {
			fk_id_usuario: $("#id_usuario").val(),
			sla_codigo:$("#sla_codigo").val()  

		}  		
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			//console.log(data);
			//Para que limpie la pantalla ante una nueva consulta
			if ( $.fn.dataTable.isDataTable( '#table_historico_solicitudes' ) )
			    $("#table_historico_solicitudes").DataTable().destroy();  	
		
			$("#table_historico_solicitudes > tbody").html(data); 
			if ( $.fn.dataTable.isDataTable( '#table_historico_solicitudes' ) ) {
			    table_historico_solicitudes = $("#table_historico_solicitudes").DataTable();  			
			}
			else {
				table_historico_solicitudes = $("#table_historico_solicitudes").DataTable({
					responsive: true,
					"language": {	
						"lengthMenu": "Ver _MENU_ registros por pagina",
						"zeroRecords": "No hay información, lo sentimos.",
						"info": "Mostrando pagina _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
						"search": "Filtrar"
					}
				});
			}			
			//table_historico_solicitudes.destroy(); 
			 
			table_historico_solicitudes.draw();		
		},
		async: false
	});
	/**/ 
}

function getTiposSoporte(){
	var mostrar = "";
	var datos = {
		funcion: 'getOptionsTipoSoporte'
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}

function desHabilitarCampos()
{
	//$("#TX_solicitud").prop( "disabled", true );
	$('#TX_solicitud').summernote('disable');
	$("#titulo").prop( "disabled", true );
	$("#BT_enviar_solicitud").prop( "disabled", true );
	$("#archivos_incidente").prop( "disabled", true );
	$(".actividadInicio").hide();
}

function habilitarCampos()
{
	//$("#TX_solicitud").prop( "disabled", false );
	$('#TX_solicitud').summernote('enable'); 
	$("#titulo").prop( "disabled", false );
	$("#BT_enviar_solicitud").prop( "disabled", false );
	$("#archivos_incidente").prop( "disabled", false );   
}

function limpiarCampos()
{
	$('#TX_solicitud').summernote('code', '');
	$("#titulo").val("");
	$("#BT_enviar_solicitud").val("");
	$("#archivos_incidente").val("");
	$("#SL_tipo_soporte").val('0');
	$("#FK_Actividad_Apertura").val("");
	$('#archivos_adjuntos_incidente').html("");
	$("#SL_observadores").val('');
	$("#SL_observadores").selectpicker('refresh');

}

// PREPARE UPLOAD DE HABILITANTES
// Grab the files and set them to our variable
function prepareUpload(event)
{
    files = event.target.files;
    var contenedorNombres=$('#archivos_adjuntos_incidente');
    contenedorNombres.show();
    contenedorNombres.html("");
    var newp = $('<p></p>');
    newp.css('font-size:18px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;');
    newp.html("<strong>Estos son TODOS los archivos que se van a enviar:</strong>");  
    newp.appendTo(contenedorNombres);
    $.each(files, function(index, value) {
        var newp = $('<p></p>');
        newp.css('font-size:16px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;');
        newp.html(files[index]["name"]);
        newp.appendTo(contenedorNombres); 
    });
} 


function subirAdjuntosIncidente(event)
{
	//event.stopPropagation(); // Stop stuff happening
    //event.preventDefault(); // Totally stop stuff happening
  
	var data = new FormData();
	//Añade los archivos a la global _FILES
	$.each(files, function(key, value)
	{
		data.append(key, value);
	});

	data.append("funcion","addAdjuntosSoporte"); 
	data.append("incidente_codigo",incidenteCodigo);    
	data.append("sla_codigo",$("#sla_codigo").val());    
	$.ajax({
        url: url_service,
        type: 'POST',
        data: data,
        cache: false,
        //dataType: 'html',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        /*beforeSend: function(){
    		$("#modal_enviando").modal('show');
 		},*/
        success: function(d)
        {
        	//console.log(d);  
        	var retornoAdjuntos=$.parseJSON(d);
            //console.log('retornoAdjuntos: '+retornoAdjuntos);
            var subidos=0;
			var noSubidos=0;               
            $.each(retornoAdjuntos,function(clave,valor){
            	if(valor!=0)
            		subidos++;
            	else
            		noSubidos++;
    			//console.log(clave+'-'+valor);
    		});
    		var respuesta='';
    		if(subidos>0)
    			respuesta+=' '+subidos+' adjuntos subidos <br>'; 
    		if(noSubidos>0)
    			respuesta+=' '+noSubidos+' adjuntos sin subir <br>'; 
    		$("#respuestaFinal").append(respuesta); 
    		mensajeFinal();

        } 
    }); 
}

function mostrarAdjuntosIncidente()
{
	$("#contenedorAdjuntos").html("");    
	datos = {
		funcion: 'consultarAdjuntosSoporte', 
		p1: { 	
			incidente_codigo : $("#incidente_codigo").val(), 
      		sla_codigo: $("#sla_codigo").val()	
		}   
	};  

	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){		 		
		    $("#contenedorAdjuntos").html(data);
		},
		error: function( jqXHR, textStatus, errorThrown){			
			$("#actividades").html("Presentamos disculpas, ocurrio un error  " + textStatus + " / " + errorThrown ); 
		} 
	});		
}

function mensajeFinal()
{

  	limpiarCampos();
  	desHabilitarCampos();
	/*alertify.set('notifier','position', 'top-right');
	alertify
	  .alert("Mensaje de SIF",$("#respuestaFinal").html(), function(){
	    alertify.success('Revise el estado de los incidentes en la pestaña Historico mis soportes');
	  }); */
	parent.mostrarAlerta("success",'Revise el estado de los incidentes en la pestaña Historico mis soportes',$("#respuestaFinal").html(),'',null);
	$("#respuestaFinal").html("")	;
	$("#ver_historico").trigger('click'); 
}