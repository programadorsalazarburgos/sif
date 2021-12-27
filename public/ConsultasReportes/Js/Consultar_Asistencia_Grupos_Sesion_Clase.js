var url_service = '../../Controlador/ConsultasReportes/C_Consultar_Asistencia_Grupos_Sesion_Clase.php';
$(function(){
	$("#SL_clan").html(getClanes()).change(getGruposForSelectClan).selectpicker("refresh");
	$("#SL_grupo").change(cargarMesesAsistenciaClaseGrupo);
	getGruposForSelectClan();
	cargarMesesAsistenciaClaseGrupo();

	$("#BT_consultar_Asistencia").click(consultarAsistenciasMes);
	$("table").delegate(".pop_over","click",function(){
		mostrar = $(this).data("mostrar");
		if(mostrar == 1){
			$(this).popover('hide');
			$(this).data("mostrar","0");
		}else if(mostrar == 0){
			$(this).popover('show');
			$(this).data("mostrar","1");
		}
	});

	$("#div_table_asistencia").delegate('.ver_anexo','click',function(){
		const url_anexo=$(this).data('vc_anexo')
		if("" == url_anexo){
			parent.mostrarAlerta("warning","No hay anexo","No se subió anexo para este día")
		}else{
			const url_actual = window.location.href
			let indice = url_actual.indexOf("public")
			let extraida = url_actual.substring(0, indice)
			const url_final=extraida+'uploadedFiles/'+url_anexo
			var win = window.open(url_final, '_blank')
			win.focus()
		}
	})
});

function getGruposArteEscuela(){
	var mostrar = "";
	var datos = {
		'opcion':'get_grupos_arte_escuela',
		'id_usuario': $("#id_usuario").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	})
	return mostrar;
}

function getGruposEmprendeClan(){
	var mostrar = "";
	var datos = {
		'opcion':'get_grupos_emprende_clan',
		'id_usuario': $("#id_usuario").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	})
	return mostrar;
}

function getGruposForSelectClan(){
	
	var mostrar_ec = "";
	var datos = {
		'opcion':'get_grupos_emprende_clan_by_clan',
		'id_clan': $("#SL_clan").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar_ec += data;
		},
		async: false
	});
	var mostrar_ae = "";
	var datos = {
		'opcion':'get_grupos_arte_escuela_by_clan',
		'id_clan': $("#SL_clan").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar_ae += data;
		},
		async: false
	});
	var mostrar_lc = "";
	var datos = {
		'opcion':'get_grupos_laboratorio_clan_by_clan',
		'id_clan': $("#SL_clan").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar_lc += data;
		},
		async: false
	});
	$("#SL_grupo").html(mostrar_ae + mostrar_ec + mostrar_lc).selectpicker('refresh');
	cargarMesesAsistenciaClaseGrupo();
}

function getClanes(){
	var mostrar = ""
	var datos = {
		'opcion': 'get_clanes'
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data
		},
		async: false
	});
	return mostrar;
}

function cargarMesesAsistenciaClaseGrupo(){
	var datos = {
		opcion: 'get_mes_asistencia_clase_grupo',
		id_grupo: $("#SL_grupo").val(),
		tipo_grupo : $("#SL_grupo").find(':selected').data('tipo_grupo')
	}
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#SL_mes_clase").html(data).selectpicker("refresh");
		}
	});
}

function consultarAsistenciasMes(){
	var datos = {
		opcion: 'get_asistencia_clase_grupo',
		id_grupo: $("#SL_grupo").val(),
		tipo_grupo : $("#SL_grupo").find(':selected').data('tipo_grupo'),
		mes_anio : $("#SL_mes_clase").val()
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){			
			$("#div_table_asistencia").html(data);
			
			$("#table_asistencia").DataTable({ 
				"pageLength": 100,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				},
				dom: 'Bfrtip',
				buttons: [
				{
					extend: 'excel',
					exportOptions: {
						columns: ':visible' 
					},
					title: 'Asistencias clase grupo ' + $("#SL_grupo").val() + ' del mes ' + $("#SL_mes_clase").val()
				}
				]
			}).draw();	

			$("#table_detalle_sesion").DataTable({ 
				"pageLength": 100,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				},
				dom: 'Bfrtip',
				buttons: [
				{
					extend: 'excel',
					exportOptions: {
						columns: ':visible' 
					},
					title: 'Detalle de sesiones  clase grupo ' + $("#SL_grupo").val() + ' del mes ' + $("#SL_mes_clase").val()
				}
				]
			}).draw();				

					
		},
		async: false
	});
	/*table_asistencia.destroy();
    $("#table_asistencia").DataTable({
        responsive: true,
        "pageLength": 100,
        "language": {
            "lengthMenu": "Ver _MENU_ registros por pagina",
            "zeroRecords": "No hay información, lo sentimos.",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Filtrar"
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible'
            	},
            	title: 'Asistencias clase grupo ' + $("#SL_grupo").val() + ' del mes ' + $("#SL_mes_clase").val()
            }
        ]
    });
    table_asistencia.draw();*/
}

function getEncabezadosSesionesClase(){
	var mostrar = "";
	var datos = {
		opcion: 'get_encabezados_sesiones_asistencia_clase_grupo',
		id_grupo: $("#SL_grupo").val(),
		tipo_grupo : $("#SL_grupo").find(':selected').data('tipo_grupo'),
		mes_anio : $("#SL_mes_clase").val()
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar = data;
		},
		async: false
	});
	return mostrar;
}