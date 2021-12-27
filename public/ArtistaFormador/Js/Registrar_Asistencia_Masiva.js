var url_ok_obj = '../../src/ArtistaFormador/RegistrarAsistenciaController/';
$(function(){
    //parent.mostrarAlerta("warning","Subsanciones mes FEBRERO","<br>Informamos que la subsanación de sesiones de clase del mes de FEBRERO cierran el día lunes uno (01) de MARZO de 2021 a las 11:59 P.M.",null,8000)
    parent.mostrarAlerta("warning","Subsanciones mes MARZO","<br>Informamos que la subsanación de sesiones de clase del mes de MARZO cierran el día lunes Cinco (05) de ABRIL de 2021 a las 11:59 P.M.",null,38000)
    var anio_mes = parent.getFechaYHoraServidor().substring(0,7);
    $("#SL_artista_formador").html('<optgroup label="Artistas formadores con grupos activos">' +parent.getOptionsArtistasFormadores(1) + '</optgroup>').selectpicker('refresh').trigger('change').change(function(ev){
        $("#SL_grupo").html(parent.getGruposDeUnUsuario($(this).val())).selectpicker("refresh").trigger('change');
    });
    setTimeout(() => {
        $("#SL_artista_formador").val(parent.idUsuario).selectpicker('refresh').trigger('change');
    }, 10);
    $("#SL_grupo").change(function(){
        setLugardeAtencion($("#SL_grupo").find(':selected').data('tipo_grupo'), $("#SL_grupo").find(':selected').data('tipo_ubicacion'));
        datos = {
            p1: {
                'id_grupo': $("#SL_grupo").val(),
                'estado': 1,
                'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo'),
                'fecha_mes': anio_mes,
                'id_usuario': parent.idUsuario
            }
        }
        $.ajax({ 
            url:url_ok_obj+'consultarEstudiantesParaAsistenciaMasiva',
            type:'POST',
            data: datos,
            beforeSend: function(){
                parent.mostrarCargando();
            },
            async: false
        }).done(function(data){
            $("#div_table_beneficiarios_grupo").html(data);
            var table_asistencia_masiva = $("#table_asistencia_masiva").DataTable({ 
                // scrollY:        "300px",
                scrollX:        true,
                scrollCollapse: true,
                paging:         false,
                // fixedColumns:   {
                //     leftColumns: 3,
                //     rightColumns: 0
                // },
                "pageLength": 500,
                "language": {
                    "lengthMenu": "Ver _MENU_ registros por pagina",
                    "zeroRecords": "No hay información, lo sentimos.",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Filtrar",
                },
                // fixedColumns:   {
                //     leftColumns: 2,
                // },
                // scrollCollapse: true,
                // dom: 'Bfrtip',
                // buttons: [
                // {
                //     extend: 'excel',
                //     exportOptions: {
                //         columns: ':visible' 
                //     },
                //     title: 'Asistencias clase grupo ' + $("#SL_grupo").val()
                // }
                // ]
            }).on( 'draw', function () {
                $('.asistencia_clase').bootstrapToggle({
                    on: 'SÍ',
                    off: 'NO',
                    onstyle: 'success',
                    offstyle: 'danger'
                });
            }).draw();
            table_asistencia_masiva.search('').draw();
            parent.cerrarCargando();
        }).fail(function(jqXHR,textStatus){
            parent.error('error','Error','No se ha podido cargar los datos de los beneficiarios:  ' + textStatus)
            console.log('No se ha podido cargar los datos de los beneficiarios:  ' + textStatus);
        });
    });
    
    $("#div_table_beneficiarios_grupo").delegate(".asistencia_clase","change",function(ev){
        datos = {
            p1: {
                'id_sesion_clase': $(this).data('id_sesion_clase'),
                'id_beneficiario': $(this).data('id_beneficiario'),
                'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo'),
                'estado_asistencia': ($(this).prop('checked')?'1':'0')
            }
        }
        $.ajax({ 
            url:url_ok_obj+'actualizarEstadoAsistenciaBeneficiarioSesionClase',
            type:'POST',
            data: datos,
            beforeSend: function(){
                
            },
            async: false
        }).done(function(data){
            
        }).fail(function(jqXHR,textStatus){
            parent.error('error','Error','No se ha podido actualizar el estado de asistencia del beneficiario : ' + textStatus)
            console.log('No se ha podido actualizar el estado de asistencia del beneficiario:  ' + textStatus);
        });
    }).delegate(".crear_sesion_clase","click",function(ev){
        var dia_sesion = $(this).data("dia");
        datos = {
            p1: {
                'id_formador_titular': $("#SL_artista_formador").val(),
                'id_grupo': $("#SL_grupo").val(),
                'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo'),
                'tipo_ubicacion': $("#SL_lugar_atencion").val(),
                'id_organizacion': $("#SL_grupo").find(':selected').data('id_organizacion'),
                'fecha': anio_mes + '-' + dia_sesion,
                'id_usuario': parent.idUsuario
            }
        }
        $.ajax({ 
            url:url_ok_obj+'crearDiaSesionClase',
            type:'POST',
            data: datos,
            beforeSend: function(){
                parent.mostrarCargando();
            },
            async: false
        }).done(function(data){
            if(data > 1){
                $('#btn_upload').data("id_sesion_clase",data);
                $('#btn_upload').data("linea_atencion",$("#SL_grupo").find(':selected').data('tipo_grupo'))
                $("#SL_grupo").trigger("change");
                parent.cerrarCargando();
                // $("#uploadModal").modal({backdrop: 'static', keyboard: false});
            }else{
                parent.mostrarAlerta("warning","Duplicidad","Otro usuario ya registro asistencia para este día (" + dia_sesion + ")");
                console.log("ya existe sesión par este día");
            }
        }).fail(function(jqXHR,textStatus){
            parent.error('error','Error','No se ha podido actualizar el estado de asistencia del beneficiario : ' + textStatus)
            console.log('No se ha podido actualizar el estado de asistencia del beneficiario:  ' + textStatus);
        });
    }).delegate(".subir_anexo","click",function(ev){
        const id_sesion_clase=$(this).data('id_sesion_clase')
        $('#btn_upload').data("id_sesion_clase",id_sesion_clase);
        $('#btn_upload').data("linea_atencion",$("#SL_grupo").find(':selected').data('tipo_grupo'))
        $("#uploadModal").modal({backdrop: 'static', keyboard: false});
    });

    $('#btn_upload').click(function(){
        const id_sesion_clase=$(this).data('id_sesion_clase')
        const linea_atencion=$(this).data('linea_atencion')

        var data_form = new FormData();
        try{
            anexo_sesion = $("#file")[0].files;
        }catch(err){
            console.log(err);
        }
        try{
			data_form.append(0, anexo_sesion[0]);
		}catch(err){
			console.log(err);
		}
        // var files = $('#file')[0].files[0];
        // fd.append('file',files);
        data_form.append('p1',JSON.stringify({'id_sesion_clase':id_sesion_clase,'linea_atencion':linea_atencion}));
        // AJAX request
        $.ajax({
            url:url_ok_obj+'subirAnexoSesion',
            type: 'POST',
            data: data_form,
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            async: false
        }).done(function(data){
            if(data == 1){
              $("#uploadModal").modal("hide")
              parent.mostrarAlerta('success','Documento subido','El anexo a sido cargado correctamente')
              $("#file").val('')
            }else{
              parent.mostrarAlerta("warning","Advertencia",'Al parecer el archivo no pudo ser subido');
            }
        });
    });

    $("#div_table_beneficiarios_grupo").delegate(".bioseguridad","click",function(ev){
        const id_sesion_clase = $(this).data("id_sesion_clase")
        const id_estudiante = $(this).data("id_estudiante")
        $("#BT_bioseguridad").data("id_sesion_clase",id_sesion_clase)
        $("#BT_bioseguridad").data("id_estudiante",id_estudiante)
    })

    $("#BT_bioseguridad").click(function(ev){
        const datos = {
            id_sesion_clase : $(this).data("id_sesion_clase"),
            id_estudiante : $(this).data("id_estudiante"),
            temperatura : $("#IN_temperatura").val(),
            sintomas : $("#SL_sintomas").val(),
            contacto_sintomas : $("#SL_contacto_sintomas").val(),
        }
        $.ajax({
            url:url_ok_obj+'encuestaBioseguridad',
            type: 'POST',
            data: {
                'p1':datos
            },
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            async: false
        }).done(function(data){
            console.log(data)
            // parent.mostrarAlerta('success','Documento subido','El anexo a sido cargado correctamente')
        });
        console.log(datos)
    });
});

function setLugardeAtencion(tipo_grupo, tipo_ubicacion){
    if(tipo_grupo == "arte_escuela"){
        $("#SL_lugar_atencion").html(parent.getOptionParametroDetalle(56)).selectpicker('refresh');  
    }
    if (tipo_grupo == "emprende_clan") {
        $("#SL_lugar_atencion").html(parent.getOptionParametroDetalle(57)).selectpicker('refresh');
    }
    if (tipo_grupo == "laboratorio_clan") {
        $("#SL_lugar_atencion").html(parent.getOptionParametroDetalle(39)).selectpicker('refresh');
    }
    $("#SL_lugar_atencion").val(tipo_ubicacion).selectpicker("refresh");
}