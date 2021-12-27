var url_service = '../../src/GestionClan/GestionClanController/';
//$=parent.$;
//jQuery=parent.jQuery;

// document.onload = function() {
// 	if (typeof(jQuery) == "undefined") {
// 	    window.jQuery = function (selector) { return parent.jQuery(selector, document); };
// 	    jQuery = parent.$.extend(jQuery, parent.$);
// 	    window.$ = jQuery;
// 	}	
// }
 

/*if (typeof(jQuery) == "undefined") {
    var iframeBody = document.getElementsByTagName("body")[0];
    var jQuery = function (selector) { return parent.jQuery(selector, iframeBody); };
    var $ = jQuery;
}*/
/*if (typeof(jQuery) == "undefined") {
    window.jQuery = function (selector) { return parent.jQuery(selector, document); };
    jQuery = parent.$.extend(jQuery, parent.$);
    window.$ = jQuery;
    setTimeout(function(){
		var id_usuario=$("#id_usuario").val(); 
		console.log("**id_usuario: "+id_usuario); 
	    //$(document).ready(function(){ 
		$(function(){
			//alert("entro");
			var id_usuario=$("#id_usuario").val(); 
			console.log("id_usuario: "+id_usuario);
			//$("#SL_organizacion").html(parent.getOptionsOrganizacionesRol(id_usuario));
			$("#SL_artista").html(parent.getOptionsArtistasFormadores(false)); // activos con o sin Grupos activos 	
		}); 	  
    },2000);
 



}*/
 
$(function(){
	//alert("entro");
	var id_usuario=$("#id_usuario").val(); 
	//console.log("id_usuario: "+id_usuario);
	$("#SL_organizacion").html(parent.getOptionsOrganizacionesRol(id_usuario));
	$("#SL_artista").html(parent.getOptionsArtistasFormadores(false)); // activos con o sin Grupos activos 	
	$("#BT_cargar_datos").click(function(){
		var organizacion=$("#SL_organizacion").val();
		var artista= $("#SL_artista").val();
		var selectorO = "#SL_organizacion option[value='"+organizacion+"']";
		nombreOrganizacion=$(selectorO).text();		
		var selectorA = "#SL_artista option[value='"+artista+"']";
		nombreArtista=$(selectorA).text();	
		console.log('organizacion: '+organizacion+" - "+nombreOrganizacion);
		console.log('artista: '+artista+" - "+nombreArtista);
		if(organizacion!="" && artista!="") {
			var datos={
				p1:{
					'organizacion': organizacion,
					'artista': artista,
				}
			} 
			$.ajax({ 
				url: url_service+'asignarArtistaOrganizacion',
				type: 'POST',
				data: datos,
				success: function(data){ 
					console.log("data:"+data);
					if(data==1){
						//Enviar notificación
						respuestaObservacion="El AF "+nombreArtista+" ha asignado a la organizacion "+nombreOrganizacion;
						var notificacion = {
							VC_Url:"Administracion/inicio.php",
							VC_Icon:"fa fa-list-alt",
							VC_Contenido:respuestaObservacion,
							userId:artista,
						}						
						window.parent.sendNotificationUser(notificacion);

						parent.mostrarAlerta("warning","Mensaje de SICREA",respuestaObservacion, function(){
							//Limpiar campos
							$("#SL_organizacion").val('default');
							$("#SL_organizacion").selectpicker("refresh");		
							$("#SL_artista").val('default');
							$("#SL_artista").selectpicker("refresh");													
													    
						}); 
						
					}
					else{ 
						parent.mostrarAlerta("error","Mensaje de SICREA","No se pudo guardar el registro en este momento", function(){});						
					}						
				}
			});	

		}
		else {
			parent.mostrarAlerta("warning","Mensaje de SICREA","Debe Elegir datos de las listas de selección", function(){});  	
		}
		
	});
}); 


