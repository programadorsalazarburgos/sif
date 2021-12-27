var url_service = '../../src/Administracion/Controlador/AdministracionController.php';
var urgenciaInicial;
var impactoInicial;
var hoy = new Date(), y = hoy.getFullYear(), m = hoy.getMonth();
var primerDia = new Date(y-5, 0, 1);
var UltimoDia = new Date();	
var incidenteCodigo=null; 
$(function(){	
	$("#SL_observadores").html(parent.getOptionsUsuariosRol(parent.$('#id_rol').val(),1,'Usuarios Activos en el sistema')).selectpicker('refresh');

	$("#archivos_incidente").filestyle({
		htmlIcon: '<i class="fas fa-folder-open"></i>',
		btnClass: "btn-primary",
		text: "Seleccionar Archivos",
	});
	
	var respuesta = '<div dir="ltr" style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: small;">El Grupo del Sistema de Información CREA le desea un muy buen día.<br><br>Agradecemos al reportar su soporte, de acuerdo a su solicitud nos permitimos comunicarle que:&nbsp;<br><br><br><br>Fue un gusto colaborarle.<br><br></div><div style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: small;"><p class="MsoNormal" style="margin-bottom: 0.0001pt; line-height: normal;"><span style="font-size: 10pt; font-family: verdana, sans-serif; color: black;">Conocer su opinión sobre nuestro servicio es muy importante. ¡Califíquenos! Por favor diligencia la encuesta por medio del link:</span><b><u><span style="font-size: 10pt; font-family: verdana, sans-serif; color: rgb(17, 85, 204);"></span></u></b></p><p class="MsoNormal" style="margin-bottom: 0.0001pt; line-height: normal;"><a href="https://docs.google.com/forms/d/1COYnNhoHFnc-qo6W0a0FUO74DDrseXbh09uTb73P3o8/viewform" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=https://docs.google.com/forms/d/1COYnNhoHFnc-qo6W0a0FUO74DDrseXbh09uTb73P3o8/viewform&amp;source=gmail&amp;ust=1497543099307000&amp;usg=AFQjCNH6exZPR5iThdIByXiNiqLhuWq9tg" style="color: rgb(17, 85, 204);"><b><u><span style="font-size: 10pt; font-family: verdana, sans-serif;">ENCUESTA DE SATISFACCIÓN (https://docs.google.com/forms<wbr>/d/e/1FAIpQLSfllwA__aVVad9YLBq<wbr>xf3L-L8D0vlXid_2tTUIcjXgkVFacY<wbr>g/viewform)</span></u></b></a></p></div>';
	$('#tx_solucion').summernote({
		  height: 100,                 // set editor height
		  minHeight: null,             // set minimum height of editor
		  maxHeight: null,             // set maximum height of editor
		  placeholder: 'Detalle su incidente..., recuerde que ahora puede insertar videos e imagenes del clipboard con CTRL+V ',
		  lang: 'es-ES'
		});	


	$("#sla_codigo").change(function(){
		cargarSolicitudesPendientes();
	});
	$('#archivos_adjuntos_incidente').hide(); 
	//Eventos del boton de solucionar soporte

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
	$("table").delegate(".solucionar_soporte","click",function(){
		//$("#tx_solicitud").data("id_persona",$(this).data("id_persona"));
		//$("#tx_solicitud").data("fecha_creacion",$(this).data("fecha_creacion"));

		$("#titulo_incidente").html($(this).data("titulo_incidente"));
		$("#usuario_solicita").html("("+$(this).data("id_persona")+") "+$(this).data("nombre_usuario") );
		var observadores = $(this).data("observadores").split(',');
		$("#SL_observadores").val("");
		$("#SL_observadores").selectpicker("refresh");	
		$.each(observadores, function(i) {
			$("#SL_observadores option").filter(function() { return $(this).text() == observadores[i]; }).prop('selected', true);
			$("#SL_observadores").selectpicker("refresh");	
		});	 

		$("#fecha_incidente").html($(this).data("fecha_creacion")); 
		$("#tx_solicitud").html($(this).data("texto_solicitud"));
		$("#incidente_codigo").val($(this).data("incidente"));
		$("#id_persona").val($(this).data("id_persona"));
		$("#actividad_apertura").html($(this).data("actividad_apertura"));
		$("#fk_actividad_apertura").val($(this).data("fk_actividad_apertura")); 
		$("#fk_actividad_cierre").val("");
		$("#actividad_cierre").html();
		//$("#cerrarIncidente").prop( "checked", false ).change();
		$("#urgencia").val($(this).data("urgencia")).selectpicker('refresh');
		urgenciaInicial = $(this).data("urgencia");
		$("#impacto").val($(this).data("impacto")).selectpicker('refresh');
		impactoInicial= $(this).data("impacto");
		incidenteCodigo=$(this).data("incidente");
		mostrarPrioridad($(this).data("prioridad"));
		mostrarObservacionesIncidente();    
		mostrarAdjuntosIncidente();		
		$('#archivos_adjuntos_incidente').html("");

	});

	$("#urgencia").change(asignarPrioridad);
	$("#impacto").change(asignarPrioridad);
	$('input[type=file]').on('change', prepareUpload);  

	/*$("#urgencia").on("change",function(){
		alert("cambio");
	});*/

	$('#modal_solucion_soporte').on('hidden.bs.modal', function () {
		$("#prioridad").html("");
		$("#prioridad").removeClass("alert alert-success");
	});	

	$("#cerrarIncidente").change(function(){

	});

	$("#ver_historico").click(function(){
		setCalendar("#fecha_inicio",primerDia,UltimoDia,"Fecha Inicial");
		setCalendar("#fecha_fin",primerDia,UltimoDia,"Fecha Final");				
	});



	$("#fecha_inicio").on("changeDate", function (e) {
		if($("#fecha_inicio").val()!=""){
			var limiteInicio = stringADate($("#fecha_inicio").val());
			$("#fecha_fin").datepicker('setStartDate',limiteInicio);

		}    	
	});

	$("#fecha_fin").on("changeDate", function (e) {

		if($("#fecha_fin").val()!=""){
			var limiteFin = stringADate($("#fecha_fin").val());
			$("#fecha_inicio").datepicker('setEndDate',limiteFin);

		}
	});

	$("#cargarHistorico").click(function(){
		cargarIncidentesCerrados();
	});

	function asignarPrioridad()
	{
		var urgencia=$("#urgencia").val();
		var impacto=$("#impacto").val();
		//console.log("urgencia: "+urgencia+" - impacto: "+impacto);
		//console.log("urgencia: "+urgencia+" - impacto: "+impacto+" - urgenciaInicial: "+urgenciaInicial+" impactoInicial: "+impactoInicial);
		if(urgencia==urgenciaInicial && impacto==impactoInicial)
			return;

		if(urgencia!=='' && impacto!=='') {			
			datos = {
				funcion: 'setPrioridadIncidente', 
				p1: {
					codigo : $("#incidente_codigo").val(),
					urgencia: urgencia,
					impacto: impacto,
					sla_codigo: $("#sla_codigo").val()			
				}  
			};
			$.ajax({
				url:url_service,
				type:'POST',
				data: datos,
				success: function(data){					
					if(data!=0) {
						$("#prioridad").html(data);
						$("#prioridad").addClass("alert alert-success");
						var mensaje="Se ha asignado la prioridad "+data+" al incidente: "+$("#incidente_codigo").val();
						//Notificar prioridad a usuario 
						/*var notificacion = { 
							VC_Url:"Administracion/Solicitud_Soporte2.php#historico_soportes",
							VC_Icon:"fa fa-list-alt", 
							VC_Contenido:mensaje,
							userId:$("#id_persona").val(),
							email:0
						}
						window.parent.sendNotificationUser(notificacion);*/
						//Notificar a Observadores
						/*$('#SL_observadores :selected').each(function(i, selected){ 
							var notificacion = {
								VC_Url:"Administracion/Solicitud_Soporte2.php#historico_soportes", 
								VC_Icon:"fa fa-list-alt",
								VC_Contenido:mensaje,
								userId:$(selected).val(),
								email:0
							} 
							window.parent.sendNotificationUser(notificacion);						
						}); */	 							  						
					} 
					else {
						$("#prioridad").html("");
						$("#prioridad").removeClass("alert alert-success");						
					}				
					
				}, 
				error: function( jqXHR, textStatus, errorThrown){	
					parent.mostrarAlerta('error','Mensaje del sistema','No se puedo guardar la prioridad, mensaje: ('+textStatus+ '/ '+errorThrown+')','',null);					
				} 
			});				
			//console.log("urgencia: "+urgencia+" - impacto: "+impacto);
		}

	} 

	function mostrarPrioridad(prioridad)
	{
		switch(prioridad) {
			case 1:
			data='CRITICA';
			break;
			case 2:
			data='ALTA';
			break;
			case 3:
			data='MEDIA';
			break;	
			case 4:
			data='BAJA';
			break;	
			case 5:
			data='PLANEADA';
			break;			        		        	        
			default:
			data='SIN ASIGNAR';

		}		
		$("#prioridad").html(data);
		$("#prioridad").addClass("alert alert-success");
	}

	function mostrarObservacionesIncidente()
	{
		//alert($("#id_usuario").val());
		table_observacion_incidentes.clear().draw();
		$("#tituloObservaciones").html('Observaciones incidente: '+$("#incidente_codigo").val());
		datos = {
			funcion: 'getObservacionesIncidente', 
			p1: {
				incidente_codigo : $("#incidente_codigo").val(),
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
			    //console.log('data: '+data);				
			    datos=JSON.parse(data);	
				//console.log('tabla: '+datos);
				$.each(datos.observaciones, function(i) 
				{
					var fila = table_observacion_incidentes.row.add( [
						datos.observaciones[i].fecha,
						datos.observaciones[i].nombre,
						datos.observaciones[i].observaciones
						]).draw().node();
					if(datos.observaciones[i].tipo_observacion=="1")
						$(fila).addClass("alert alert-info");  
				});	
				//console.log("datos.tipoObservacion: "+datos.tipoObservacion)		;
				if(!datos.tipoObservacion) {
					$("#tipoObservacion").val('0').selectpicker('refresh');
					$("#tipoObservacion").prop( "disabled", true );
					//Desabilita cerrar incidente 
					$("#cerrarIncidente").prop( "disabled", true );					
				}
			},
			error: function( jqXHR, textStatus, errorThrown){			
				$("#actividades").html("Presentamos disculpas, ocurrio un error  " + textStatus + " / " + errorThrown ); 
			} 
		});		
	}

	function mostrarAdjuntosIncidente()
	{

		datos = {
			funcion: 'consultarAdjuntosSoporte', 
			p1: {
				incidente_codigo : $("#incidente_codigo").val(),
				sla_codigo:  $("#sla_codigo").val()  		
			}   
		};
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos,
			success: function(data){	
			    //console.log('data: '+data);		 		
			    $("#contenedorAdjuntos").html(data);
			    //datos=JSON.parse(data);	
				//console.log('tabla: '+datos);
				/*$.each(datos.observaciones, function(i) 
				{
					var fila = table_observacion_incidentes.row.add( [
						datos.observaciones[i].fecha,
						datos.observaciones[i].nombre,
						datos.observaciones[i].observaciones
						]).draw().node();
					if(datos.observaciones[i].tipo_observacion=="1")
						$(fila).addClass("alert alert-info");  
				});	
				//console.log("datos.tipoObservacion: "+datos.tipoObservacion)		;
				if(!datos.tipoObservacion) {
					$("#tipoObservacion").val('0').selectpicker('refresh');
					$("#tipoObservacion").prop( "disabled", true );
					//Desabilita cerrar incidente 
					$("#cerrarIncidente").prop( "disabled", true );					
				}*/
			},
			error: function( jqXHR, textStatus, errorThrown){			
				$("#actividades").html("Presentamos disculpas, ocurrio un error  " + textStatus + " / " + errorThrown ); 
			} 
		});		
	}	

	function agregarObservacionIncidente()
	{ 

		datos = {
			funcion: 'addObservacionesIncidente', 
			p1: {
				incidente_codigo : $("#incidente_codigo").val(),
				fk_id_persona: $("#id_usuario").val(),
				observaciones: $('#tx_solucion').summernote('code'), 
				tipo_observacion: $("#tipoObservacion").val(),
				sla_codigo: $("#sla_codigo").val()
				
			} 

		};	
		$.ajax({
			url: url_service,
			type: 'POST',
			data: datos,
			success: function(data){
				//console.log(data);
				incidenteCodigo=data;

				//console.log('incidenteCodigo: '+incidenteCodigo); 
				if(!data) 
					respuestaObservacion='No ha sido posible crear la observación';
				else
					respuestaObservacion='Se ha añadido una observación para el incidente # <strong style="color:red;">'+$("#incidente_codigo").val()+'</strong><br>';
				
				if(data){
					//Enviar notificación
					var notificacion = {
						VC_Url:"Administracion/Solicitud_Soporte2.php#historico_soportes",
						VC_Icon:"fa fa-list-alt",
						VC_Contenido:respuestaObservacion,
						userId:$("#id_persona").val(),
						email:1
					}
					window.parent.sendNotificationUser(notificacion);
					//Notificar a Observadores
					$('#SL_observadores :selected').each(function(i, selected){ 
						var notificacion = {
							VC_Url:"Administracion/Solicitud_Soporte2.php#historico_soportes", 
							VC_Icon:"fa fa-list-alt",
							VC_Contenido:respuestaObservacion,
							userId:$(selected).val(),
							email:1
						} 
						window.parent.sendNotificationUser(notificacion);						
					}); 					
				}

				if($("#cerrarIncidente").prop( "checked")==true) {
					//preguntar si se cierra con el mismo módulo o no					
					cambiarEstadoIncidente(true);
					$("#modal_solucion_soporte").modal('hide');
				} 
				else {   
					cambiarEstadoIncidente(false);
					parent.mostrarAlerta('info','Mensaje del sistema',respuestaObservacion,"$('#tx_solucion').summernote('code', ''); mostrarObservacionesIncidente(); ",2000);
					/*alertify
					.alert("Mensaje de SICLAN",respuestaObservacion, function(){
						$('#tx_solucion').summernote('code', '');
						mostrarObservacionesIncidente();
					    //alertify.success('Revise el estado de los incidentes en la pestaña Historico mis soportes');
					}); */
				}
			}
		});	

	}

	function cambiarEstadoIncidente(cierra)
	{
		var estado="'desarrollo'"; 
		if(cierra){
			estado="'cerrado'";

			if($("#fk_actividad_apertura").val()!='' && 
				$("#fk_actividad_apertura").val()!=undefined) {
				//Pregunta actividad cierre


			parent.swal({
				title: "Mensaje de confirmación",
				html: "Desea cerrar el incidente con una actividad diferente a: "+$("#actividad_apertura").html(),
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si',
				showCancelButton: true,
				cancelButtonText: 'No, cancelar!',
				//reverseButtons: true,
			}).then(() => {
				cargaActividadesUsuario();
				
			},function(dismiss) {
				console.log(dismiss);
				if (dismiss == 'cancel') {
					$("#fk_actividad_cierre").val($("#fk_actividad_apertura").val()); 
					//parent.mostrarAlerta("success","Mensaje del sistema","Se asignó la actividad de apertura como actividad de cierre","",3000);
					parent.swal({
	  					type:"success",
					  	title: "Mensaje del sistema",		
				    	html:"Se asignó la actividad de apertura como actividad de cierre",
				    	//timer: 3000
				  	}).then(() => {
						ajaxCambiarEstadoIncidente(estado);
				  	});
					
				}
			}).catch(parent.swal.noop);





		}
		else
			ajaxCambiarEstadoIncidente(estado); 

	}
	else
		ajaxCambiarEstadoIncidente(estado);
		//Preguntar
		
	} 

	function ajaxCambiarEstadoIncidente(estado)
	{
		//Debe añadir el historial de funcionarios que tienen relación con el incidente
		//Debe Debe consultar el estado actual del incidente para no re grabar el estado si es el mismo
		var estadoActual="";
		datos = { 
			funcion: 'getEstadoIncidente',
			p1: {
				codigo : $("#incidente_codigo").val(),
				sla_codigo: $("#sla_codigo").val()	
			},
			p2: true     
		};

		$.ajax({
			url:url_service,
			type:'POST',
			data: datos, 
			success: function(data){
				estadoActual = data;
				//console.log(estadoActual);
			},
			async: false 					
		});		 

		//console.log("estadoActual: ("+estadoActual+") - estado: ("+estado+")"); 
		if(estadoActual=="cerrado" && estado=="'cerrado'")
			return false;

		var fk_observadores = "";
		$('#SL_observadores :selected').each(function(i, selected){ 
			if(fk_observadores=="") fk_observadores = $(selected).val();
			else fk_observadores += ","+$(selected).val();
		});	

		fk_observadores="'"+fk_observadores+"'"; 

		datos = { 
			funcion: 'cambiarDatosIncidente',
			p1: {
				codigo : $("#incidente_codigo").val(), 
				estado: estado,
				fk_actividad_cierre: $("#fk_actividad_cierre").val(),
				fk_id_usuario_funcionario:  $("#id_usuario").val(),
				sla_codigo: $("#sla_codigo").val(),
				fk_observadores: fk_observadores
			},
			p2: estadoActual,
			p3: $("#id_usuario").val() 
		};
		if(estado=="'cerrado'")
			datos.p1.descripcion_solucion= "\""+$('#tx_solucion').summernote('code')+"\"";   
		//if(estado=="'desarrollo'")
		//	datos.p1.fk_id_usuario_funcionario= $("#id_usuario").val(); 
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos, 
			success: function(data){
				var mensaje="";
				console.log(data); 
				if(data){ 

					mensaje='Se cambio el estado del incidente # <strong style="color:red;">'+$("#incidente_codigo").val()+'</strong> a '+estado; 
					parent.mostrarAlerta('success','Mensaje del sistema',mensaje,'',null); 
					//Enviar Notificación al usuario que registra
					/*var notificacion = {
						VC_Url:"Administracion/Solicitud_Soporte2.php#historico_soportes", 
						VC_Icon:"fa fa-list-alt",
						VC_Contenido:mensaje,
						userId:$("#id_persona").val(),
						email:1
					} 
					window.parent.sendNotificationUser(notificacion);
					//Enviar Notificación a observadores
					$('#SL_observadores :selected').each(function(i, selected){ 
						var notificacion = {
							VC_Url:"Administracion/Solicitud_Soporte2.php#historico_soportes", 
							VC_Icon:"fa fa-list-alt",
							VC_Contenido:mensaje,
							userId:$(selected).val(),
							email:0
						} 
						window.parent.sendNotificationUser(notificacion);						
					});	 	*/					
					
					$('#tx_solucion').summernote('code', '');					
					cargarSolicitudesPendientes();  
				}
				else{
					parent.mostrarAlerta('warning','Mensaje del sistema','No fue posible actualizar los datos del incidente','',null); 
				} 
				//Cerrar el modal cuando se responde y cargar solicitudes pendientes cuando se cierra
				$("#modal_solucion_soporte").modal('hide');				
			},
			error: function( jqXHR, textStatus, errorThrown){			
				$("#actividades").html("Presentamos disculpas, ocurrio un error  " + textStatus + " / " + errorThrown ); 
			} 					
		});	 
	} 

	function cargaActividadesUsuario(){
		console.log("cargaActividadesUsuario");
		datos = {
			funcion: 'getActividadesUsuario',
			p1:      $("#id_persona").val(),
			p2:      'getActividadesUsuarioCierre'
		};
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos, 
			success: function(data){
				$("#actividades").html(data);
				$("#modal_actividades").modal({backdrop: 'static',
					keyboard: false});  
				$('#side-menu2').metisMenu(); 
				$("#side-menu2").delegate("a","click",function(){
					var actividadCierre=$(this).prop("id");
					var nombreActividadCierre=$(this).prop("title");				
					if(actividadCierre!==''){  
						$('#fk_actividad_cierre').val(actividadCierre);						
						$('#actividad_cierre').html(nombreActividadCierre+' 									<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>');
						$("#modal_actividades").modal('hide');
						parent.swal({
		  					type:"info", 
						  	title: 'Mensaje del sistema',		
					    	html:'Se asigno la actividad de cierre: '+nombreActividadCierre,
					    	//timer: 3000
					  	}).then(() => {							
							ajaxCambiarEstadoIncidente("'cerrado'"); 
					  	});
						//alert("luego de cerrarse2");
					}
						//alert("actividad: "+$(this).prop("id"));

					});	
				//d = $.parseJSON(data);			
			},
			error: function( jqXHR, textStatus, errorThrown){			
				$("#actividades").html("Presentamos disculpas, ocurrio un error  " + textStatus + " / " + errorThrown ); 
			} 
		});	
	}	

	$("#respuesta_soporte").click(function(){
		var respuesta = 'El equipo del Sistema Integrado de Formación SIF te desea un muy buen día.<br><br>Agradecemos al reportar el incidente, de acuerdo a tu solicitud nos permitimos comunicar que:&nbsp;<br><br><br><br>Fue un gusto colaborarte.<br><br>Conocer tu opinión sobre nuestro servicio es muy importante. ¡Califícanos! Por favor diligencia la encuesta por medio del link:&nbsp;<a href="https://docs.google.com/forms/d/1COYnNhoHFnc-qo6W0a0FUO74DDrseXbh09uTb73P3o8/viewform" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=https://docs.google.com/forms/d/1COYnNhoHFnc-qo6W0a0FUO74DDrseXbh09uTb73P3o8/viewform&amp;source=gmail&amp;ust=1497543099307000&amp;usg=AFQjCNH6exZPR5iThdIByXiNiqLhuWq9tg">ENCUESTA DE SATISFACCIÓN (https://docs.google.com/forms<wbr>/d/e/1FAIpQLSfllwA__aVVad9YLBq<wbr>xf3L-L8D0vlXid_2tTUIcjXgkVFacY<wbr>g/viewform)</a>';
		$('#tx_solucion').summernote('code', respuesta);
	});
	$("#BT_solucionar_soporte").click(function(){

		if($("#tipoObservacion").val()==''){  

			parent.mostrarAlerta('error','Mensaje del sistema','Debe diligenciar el tipo de observación '); 			
		}else{
			//console.log('tipoObservacion: ('+$("#tipoObservacion").val()+') type: '+typeof($("#tipoObservacion").val())); 
			//limite para MEDIUMTEXT equivalente a 16777216 caracteres
			if($("#tx_solucion").summernote('code').length > Math.pow(2,24) ||
				$("#tx_solucion").summernote('code').length < 20)
				parent.mostrarAlerta('error','Mensaje del sistema',"El mensaje debe contener mas contenido  y no debe exceder los "+Math.pow(2,24)+" caracteres");
			else{
				//Añadir observadores

				agregarObservacionIncidente();
				if(($("#archivos_incidente"))[0].files.length > 0)	        	
					subirAdjuntosIncidente();
			}
		}		
	});

	//requerido para que funcione el responsive
	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
		$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
	} ); 	

	function cargarSolicitudesPendientes(){
		parent.mostrarCargando();
		var datos = {
			funcion: 'getSoportesASolucionar',
			p1: { 
				estado:"'cerrado'",
				sla_codigo: $("#sla_codigo").val()   
			}
		};
		$.ajax({
			url: url_service,
			type: 'POST',
			data: datos,
			success: function(data){	
				//Para que limpie la pantalla ante una nueva consulta
				if ( $.fn.dataTable.isDataTable( '#table_solicitudes_pendientes' ) )
					$("#table_solicitudes_pendientes").DataTable().destroy();  				    

				$("#table_solicitudes_pendientes > tbody").html(data);
				if ( $.fn.dataTable.isDataTable( '#table_solicitudes_pendientes' ) ) {
					table_solicitudes_pendientes = $("#table_solicitudes_pendientes").DataTable();
				}
				else {
					table_solicitudes_pendientes = $("#table_solicitudes_pendientes").DataTable({
						responsive: true,
						"language": {
							"lengthMenu": "Ver _MENU_ registros por pagina",
							"zeroRecords": "Felicidades, No hay más soportes pendientes.",
							"info": "Mostrando pagina _PAGE_ de _PAGES_",
							"infoEmpty": "No hay registros disponibles",
							"infoFiltered": "(filtered from _MAX_ total records)",
							"search": "Filtrar"
						}
					});
				}	 		
				
				table_solicitudes_pendientes.draw();
				parent.cerrarCargando();
			},
			async: true
		});

	}

	function cargarIncidentesCerrados(){
	parent.mostrarCargando();
	$("#table_historico_solicitudes > tbody").html("");
	//alert("entra a cargar historico");
	var table_historico_solicitudes	= null;
	var datos = {
		funcion: 'getIncidentesCerrados',
		p1: {
			estado: "'cerrado'",
			fecha_creacion: {
				mayorque:  "'"+$('#fecha_inicio').val()+" 00:00:00'",
				menorque:  "'"+$("#fecha_fin").val()+" 23:59:59'"
			},
			sla_codigo: $("#sla_codigo").val()
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
					},
		        	dom: 'Bfrtip',
					buttons: [
			            {
			                extend: 'excelHtml5',
			            	title: 'Soportes'
			            }
			        ]
				});
			}			
			//table_historico_solicitudes.destroy(); 

			table_historico_solicitudes.draw();
			parent.cerrarCargando();
		},
		async: true
	});
	/**/
}

function setCalendar(selector,minimo,maximo,titulo){
	if(typeof(minimo)=='number') minimo='-' + minimo + 'd';				
	if(typeof(maximo)=='number') maximo='+' + maximo + 'd';
	$(selector).datepicker('destroy');
	$(selector).datepicker({
		format: 'yyyy-mm-dd',
		startDate: minimo,
		endDate: maximo,
		weekStart: 1,
		language: 'es',
		autoclose: true,
		title: titulo
	});
} 

function stringADate(fechaString)
{
		//2017-09-01
		ano= fechaString.substring(0,4);
		mes= fechaString.substring(5,7)-1;
		dia= fechaString.substring(8,10);
		return new Date(ano,mes,dia);
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


});
