$(document).ready(function(){ 
	$("#FORM_CONSULTA_REPORTE").on("submit", function(e){
		e.preventDefault();
		$("#tabla_proyectos").empty();
		$("#tabla_proyectos").append("<tr><th colspan=3><center>PROPUESTAS PRESENTADAS</center></th></tr><tr><th>Nombre Proyecto</th><th>Fecha Radicación</th><th>Opción</th></tr>");
		//CONSULTA SI EXISTE PROPUESTA CON EL NIT ESPECIFICADO
		var nit = $("#TXT_NIT").val();
		$.ajax({
			async : false,
			url: '../../Controlador/Administrativo/Convocatoria/C_ConsultarPropuestas.php',
			type: 'POST',
			dataType: 'json',
			data: {'nit': nit},
			success: function(datos)
			{
				//console.log(datos);
				$.each(datos, function(i) 
				{
					//console.log(datos[i].VC_Nombre_Proyecto);			
					$("#tabla_proyectos").append("<tr><td>"+datos[i].VC_Nombre_Proyecto+"</td><td>"+datos[i].DA_Fecha_Radicacion+"</td><td><a id="+datos[i].PK_Id_Proyecto+" name="+datos[i].PK_Id_Proyecto+" onclick=mostrar(this.id)>Ver Reporte</a></td><tr>");
				});
			}
		});//FIN AJAX CONSULTA 
	});
});
function mostrar(id_proyecto){	
/*
	$.ajax({
		async : false,
		url: '../../Controlador/Administrativo/Convocatoria/C_crearPDF.php',
		type: 'POST',
		dataType: 'json',
		data: {'id_proyecto': id_proyecto},
		success: function(datos)
		{
			window.open("../../Controlador/Administrativo/Convocatoria/C_crearPDF.php");				
		}
	});//FIN AJAX CONSULTA Metas.*/

	window.open("../../Controlador/Administrativo/Convocatoria/C_crearPDF.php?id_proyecto="+id_proyecto);

}