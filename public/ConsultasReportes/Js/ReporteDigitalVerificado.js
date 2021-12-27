const url_ok_obj = '../../src/ArtistaFormador/RegistrarAsistenciaController/'
const url_ok_reporte = '../../src/ArtistaFormador/ReporteMensualController/'

$(function(){ 
    consultarUsuariosVerificanReporte()
    consultarPeriodosReporteDigitalMensual()
    function consultarUsuariosVerificanReporte(){
        $.ajax({ 
            url:url_ok_reporte+'consultarUsuariosVerificanReporte',
            type:'POST',
            beforeSend: function(){
                parent.mostrarCargando()
            },
            async: false
        }).done(function(data){
            parent.cerrarCargando()
            $("#SL_usuario").html(data).selectpicker("refresh")
        }).fail(function(jqXHR,textStatus){
            parent.error('error','Error','No se ha podido consultar los usuarios que revisan reporte : ' + textStatus)
            console.log(textStatus)
        })
    }
    function consultarPeriodosReporteDigitalMensual(){
        var datos = {
            'p1' : {}
        }
        $.ajax({
            url: url_ok_reporte+'consultarPeriodosReporteDigitalMensual',
            type: 'POST',
            data: datos,
            async: false
        }).done(function(data){
            $("#SL_anio_mes").html(data).selectpicker('refresh')
        }).fail(function(){
            parent.mostrarAlerta("error","No se pudo consultar fechas","Ocurrió un error al intentar consultar el listado de periodos de reportes.")
        })
    }
    function cargarFormularioInforme(){
		var html_informe = ""
		$.ajax({
			url: url_ok_reporte+'consultarFormularioReporteMensual',
			type: 'POST',
			dataType: 'html',
			async: false
		}).done(function(data){
			html_informe += data
		}).fail(function(result){
			console.log("Error: "+result)
			parent.mostrarAlerta("error","No se pudo cargar reporte","Por favor recargue el sitio e intente de nuevo. Si el problema persiste comuniquese con soporte")
			html_informe += "Error"
		})
		return html_informe
	}
    $("#SL_usuario").change(consultarReportesAsignadosParaRevisar)
    $("#SL_anio_mes").change(consultarReportesAsignadosParaRevisar)
    $("#div_table_listado_informes").delegate(".btn_modal_reporte","click",function(ev){
		var id_informe = $(this).data("id_informe")
		$("#cerrar_modal_novedad").data("id_informe",id_informe)
		$("#div_modal_reporte").html(cargarFormularioInforme())
		datos = {
            'p1': {
                'id_informe': id_informe
            }
        }
        $.ajax({
            url: url_ok_reporte+'consultarJSONReporte',
            type: 'POST',
            data: datos,
            async: true
        }).done(function(data){
            try{
                data = $.parseJSON(data)[0]['TX_json']
                data = $.parseJSON(data)
                establecerDatosHTMLReporte(data,'uno',id_informe)
            }catch(ex){
                console.log(ex)
                parent.mostrarAlerta("error","Fallo decodificar JSON","El sistema no ha podido decodificar los datos del reporte, por favor intente nuevamente y si el problema persiste comuniquese con soporte.")
            }
        }).fail(function(result){
            parent.mostrarAlerta("Error","No se pudó cargar reporte","Por favor recargue el sitio e intente de nuevo. Si el problema persiste comuniquese con soporte")
            console.log(result)
        })
    })
    function consultarReportesAsignadosParaRevisar(){
        const datos= {
            'p1':{
                'id_usuario':$("#SL_usuario").val(),
                'anio_mes':$("#SL_anio_mes").val()
            }
        }
        let consultar=true
        console.log(datos)
        if(datos.p1.id_usuario==""){
            consultar=false
            console.log(datos.p1.id_usuario)
            parent.mostrarAlerta("warning","Use ambos seleccionables","Por favor seleccione un usuario")
        }
        if(datos.p1.anio_mes==""){
            consultar=false
            parent.mostrarAlerta("warning","Use ambos seleccionables","Por favor seleccione un periodo de tiempo")
            console.log(datos.p1.anio_mes)
        }
        if(consultar){
            $.ajax({ 
                url:url_ok_reporte+'consultarReportesAsignadosParaRevisar',
                type:'POST',
                data:datos,
                beforeSend: function(){
                    parent.mostrarCargando()
                },
                async: false
            }).done(function(data){
                parent.cerrarCargando()
                $("#div_table_listado_informes").html(data)
                $("#table_listado_informes").DataTable({
					responsive: false,
                    "order": [[ 2, "asc" ]],
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
						extend: 'excelHtml5',

						title: 'Reporte de Informes de Asitencia Aprobados'
					}
					]
                }).draw()
            }).fail(function(jqXHR,textStatus){
                parent.error('error','Error','No se ha podido consultar los usuarios que revisan reporte : ' + textStatus)
                console.log(textStatus)
            })
        }else{
            console.log("No se consulta nada")
        }
    }
    function establecerDatosHTMLReporte (data, tipo_accion, id_informe=0){
		dr = data
		data = null
		setTimeout(function(){
			$(".SPAN_nombre_artista").text(dr['datos_basicos']['nombre_artista'])
			$("#SPAN_identificacion_artista").text(dr['datos_basicos']['VC_Identificacion'])
			$("#SPAN_correo_artista").text(dr['datos_basicos']['VC_Correo'])
			if(dr['datos_basicos']['convenio'] === undefined){
				dr['datos_basicos']['convenio'] = '';
			}
			$("#SPAN_nombre_grupo").text(dr['datos_basicos']['nombre_grupo']+dr['datos_basicos']['convenio'])
			$("#SPAN_linea_atencion").text(dr['datos_basicos']['linea_atencion'])
			$("#SPAN_mes_reporte").text(dr['datos_basicos']['mes_reporte'])
			$("#SPAN_organizacion").text(dr['datos_basicos']['nombre_organizacion'])
			$("#SPAN_nombre_colegio").text(dr['datos_basicos']['nombre_colegio'])
			$("#SPAN_area_artistica").text(dr['datos_basicos']['nombre_area_artistica'])
			$("#SPAN_nombre_coordinador_crea").text(dr['datos_basicos']['nombre_coordinador_crea'])

			$("#SPAN_total_horas_sesion_clase").text(dr['total_horas_sesiones_clase'])
			$("#SPAN_total_horas_sesion_evento").text(dr['total_horas_sesiones_evento'])

			var detallado_sesiones_clase_y_eventos = ""
			var i = 1
			let es_suplencia = false
			$.each( dr['detallado_sesiones_clase'], function(k,v){
				detallado_sesiones_clase_y_eventos += "<tr>"

				detallado_sesiones_clase_y_eventos += "<td align='center'>" + (i++) + ((v['VC_anexo'] == null || v['VC_anexo'] == "")?'':'<button title="Ver Anexo" type="button" class="btn btn-info descargar_anexo" data-vc_anexo="'+v['VC_anexo']+'"><span class="glyphicon glyphicon glyphicon-save-file" aria-hidden="true"></span></button>') + "</td>"
				detallado_sesiones_clase_y_eventos += "<td>" + v['fecha_clase'] + "</td>"
				if(v['lugar_atencion'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['lugar_atencion'] + "</td>";
				}
				if(v['tipo_atencion'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['tipo_atencion'] + "</td>";
				}
				if(v['material'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['material'] + "</td>";
				}
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['horas_clase'] + "</td>"
				detallado_sesiones_clase_y_eventos += "<td>" + v['observaciones'] + "</td>"
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['estudiantes_matriculados'] + "</td>"
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['estudiantes_con_asistencia'] + "</td>"
				detallado_sesiones_clase_y_eventos += "</tr>"
				if(v['suplencia']==1){
					es_suplencia=true
				}
			})

			if(es_suplencia){
				$("#span_suplencia").text('  -  SUPLENCIA')
			}

			$.each( dr['detallado_sesiones_evento'], function(k,v){
				detallado_sesiones_clase_y_eventos += "<tr>"
				detallado_sesiones_clase_y_eventos += "<td align='center'>EV-" + (i + 1) + "</td>"
				detallado_sesiones_clase_y_eventos += "<td>" + v['DA_fecha_sesion_clase'] + "</td>"
				if(v['lugar_atencion'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['lugar_atencion'] + "</td>";
				}
				if(v['tipo_atencion'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['tipo_atencion'] + "</td>";
				}
				if(v['material'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['material'] + "</td>";
				}
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['IN_horas_clase'] + "</td>"
				detallado_sesiones_clase_y_eventos += "<td>" + v['TX_observaciones'] + "</td>"
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['estudiantes_matriculados'] + "</td>"
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['estudiantes_con_asistencia'] + "</td>"
				detallado_sesiones_clase_y_eventos += "</tr>"
			})

			$("#table_listado_sesiones tbody").html(detallado_sesiones_clase_y_eventos).delegate(".descargar_anexo","click",function(){
				const url_anexo=$(this).data('vc_anexo')
				const url_actual = window.location.href
				let indice = url_actual.indexOf("public")
				let extraida = url_actual.substring(0, indice)
				const url_final=extraida+'uploadedFiles/'+url_anexo
				var win = window.open(url_final, '_blank')
				win.focus()
			})

			var detallado_novedades = ""
			$.each( dr['detallado_novedades'], function(k,v){
				detallado_novedades += "<tr>"
				detallado_novedades += "<td align='center'>" + v['DA_fecha_sesion_clase'] + "</td>"
				detallado_novedades += "<td align='center'>" + (v['IN_asistencia']==0?'NO':'SÍ') + "</td>"
				detallado_novedades += "<td>" + v['novedad_texto'] + "</td>"
				detallado_novedades += "<td>" + v['TX_observacion'] + "</td>"
				detallado_novedades += "</tr>"
			})
			switch(tipo_accion){
				case 'nuevo':
					$("#div_botones").html("<p><div class='container'><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-warning form-control' id='BT_modificar_datos_informe' value='Modificar los datos'></div></div><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-success form-control' id='BT_enviar_para_revision' value='Enviar para revisión'></div></div><!--<div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-info form-control' id='BT_descargar_pre' value='Descargar parcial'></div></div>--></p>")
					datos_array_reporte_mensual = dr
					break
				case 'consulta' :
					$("#div_botones").html("<p class='alert alert-info'>Debe esperar la aprobación o rechazo del reporte para poder realizar su impresión o corrección.</p>")
					datos_array_reporte_mensual = dr
					break
				case 'revisar':
					$("#div_botones").html("<p class='alert alert-danger'>Si encuentra errores en la tabla de <b>novedades</b> y desea corregir por favor haga click aquí: <button type='button' class='btn btn-warning' id='BT_corregir_novedades' data-id_grupo='" + dr['datos_basicos']['id_grupo'] + "' data-tipo_grupo='" + dr['datos_basicos']['tipo_grupo'] + "' data-mes_reporte='" + dr['datos_basicos']['mes_reporte'] + "' data-id_crea='" + dr['datos_basicos']['id_crea'] + "' + data-id_artista_formador='" + dr['datos_basicos']['id_usuario'] + "'><span class='glyphicon glyphicon-calendar' aria-hidden='true'></span></button></p>")
					$("#div_botones").append("<p><div class='container'><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-danger form-control' id='BT_rechazar_informe' value='Rechazar Reporte' data-id_informe='" + id_informe + "'></div></div><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-success form-control' id='BT_aprobar_informe' value='Aprobar Reporte' data-id_informe='" + id_informe + "'></div></div></p>")
					datos_array_reporte_mensual = dr
					break
				case 'corregir':
					$("#div_botones").html("<p class='alert alert-danger'>Si la corrección corresponde a la tabla de <b>novedades</b> debe realizarla directamente el <b>coordinador CREA.</b></p>")
					$("#div_botones").append("<p><div class='container'><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-warning form-control' id='BT_modificar_datos_informe' value='Corregir los datos'></div></div><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-success form-control' id='BT_enviar_corregido' value='Enviar reporte corregido' data-id_informe='" + id_informe + "'></div></div></p>")
					mostrarObservacionesInforme(id_informe)
					datos_array_reporte_mensual = dr
					break
				case 'eliminar_novedad':

					break
				default:
					console.log(tipo_accion + "Desconocido.")
					break
				}

				var detallado_asistencia_beneficiario = "<tr>"
				detallado_asistencia_beneficiario += "<th>Identificación</th>"
				detallado_asistencia_beneficiario += "<th>Nombre</th>"
				$.each( dr['detallado_sesiones_clase_participante'], function(k,v){
					detallado_asistencia_beneficiario += "<th>" + k.slice(-2) + "</th>"
				})
				detallado_asistencia_beneficiario += "</tr>"
				$.each( dr['listado_participantes'], function(k,v){
					detallado_asistencia_beneficiario += "<tr>"
					detallado_asistencia_beneficiario += "<td>" + v.documento + "</td>"
					detallado_asistencia_beneficiario += "<td>" + v.nombre + "</td>"
					$.each( dr['detallado_sesiones_clase_participante'], function(k1,v1){
						var asistencia_texto = ""
						switch(v1[v.id]){
							case '1':
							asistencia_texto = 'SÍ'
							break
							case '0':
							asistencia_texto = 'NO'
							break
							default:
							break

						}
						// detallado_asistencia_beneficiario += "<td align='center'>" + ((asistencia_texto != '')?asistencia_texto:'N/R') + "</td>"
						detallado_asistencia_beneficiario += "<td align='center'>" + ((asistencia_texto != '')?asistencia_texto:'N0') + "</td>"
					})
					detallado_asistencia_beneficiario += "</tr>"
				})

				$("#table_listado_beneficiarios").html(detallado_asistencia_beneficiario)
        }, 77)
    }
})