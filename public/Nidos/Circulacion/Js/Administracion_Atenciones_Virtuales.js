var url_ok_obj = '../../../src/CirculacionNidos/Controlador/AtencionesVirtualesController.php';    
var url_aten = '../../../src/AtencionesVirtuales/Controlador/AtencionesVirtualesController.php';
var url_ben = '../../../src/Beneficiarios/Controlador/RegistroBeneficiariosController.php';

var Cupos = '';
var Localidad = '';
$(document).ready(function() {
  ///JS para administración de formularios

  $("#TX_TipoAcudiente_Editar").html(getTipoDocumento()).selectpicker("refresh");
  $("#TX_TipoBeneficiario_Editar").html(getTipoDocumento()).selectpicker("refresh");

  function getTipoDocumento() {
    var mostrar = "";
    var datos = {
      funcion: 'getTipoDocumento'
    };
    $.ajax({
      url: url_ben,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    });
    return mostrar;
  }
  
  $("#tx-contenido").summernote({
    minHeight: 300,
  });

  $("#sl-formulario").on("change", function() {
    getInfoFormulario();    
  });

  function getInfoFormulario(){
    var datos = {
      funcion: 'getInfoFormulario',
      p1: $("#sl-formulario").val()
    };

    $.ajax({
      url: url_ok_obj,
      type: "POST",
      data: datos,
      dataType: 'json',
      success: function(data){
        $("#tx-contenido").summernote("code", data["VC_Contenido_Cerrado"]);
        data["IN_Estado"] == 1 ? $('#cb-estado-formulario').prop('checked', false).change() : $('#cb-estado-formulario').prop('checked', true).change();
      },
      async: false
    });
  }

  function guardarConfiguracionFormulario(){
    estado = $('#cb-estado-formulario').prop("checked") == true ? 0 : 1;
    var datos = {
      funcion: 'guardarConfiguracionFormulario',
      p1: {
        "id-formulario": $("#sl-formulario").val(),
        "tx-contenido": $("#tx-contenido").summernote('code'),
        "cb-estado-formulario": estado
      },
    };

    $.ajax({
      url: url_ok_obj,
      type: "POST",
      data: datos,
      dataType: 'html',
      success: function(data){
        if(data == 1){
          parent.swal("Exito!", "Información actualizada correctamente", "success");
          $("#sl-formulario").selectpicker("val", "");
          $('#tx-contenido').summernote("reset");
          $('#cb-estado-formulario').prop('checked', false);
        }else{
          parent.swal("Error!", "No se pudo actualizar la información, por favor intentelo nuevamente", "error");
        }
      },
      async: false
    });
  }

  $("#form-formulario").submit(function(e){
    e.preventDefault();
    guardarConfiguracionFormulario();
  });
  ///Fin JS para administración de formularios

  $("#SL_Mes").html(getMes()).selectpicker("refresh");

  var Id_Registro = 1;
  var weekday=new Array(7);
  weekday[0]="Domingo";
  weekday[1]="Lunes";
  weekday[2]="Martes";
  weekday[3]="Miércoles";
  weekday[4]="Jueves";
  weekday[5]="Viernes";
  weekday[6]="Sábado";

  $(".calendario").datepicker({
    format: 'yyyy-mm-dd',
    language: 'es',
    autoclose: true,
    startDate: '01-01-2019'
  });

  $('.hora_inicio').timepicker({
    timeFormat: 'HH:mm',
    interval: 30,
    minTime: '7',
    maxTime: '18:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });

  $("#TX_Fecha_Atencion").on("change", function(){
    var date = $(this).datepicker('getDate');
    var dayOfWeek = weekday[date.getUTCDay()];
    for (var i = 1; i <= Id_Registro; i++) {
      document.getElementById("TX_Dia_" + i).value = dayOfWeek;
      document.getElementById("TX_Fecha_" + i).value = document.getElementById("TX_Fecha_Atencion").value;
    }
    console.log(dayOfWeek);
  });

  var Id_Registro = 1;
  $("#btn_Agregar").click(function() {
    Id_Registro++;
    $("#tabla_Titulos_Registro").append("<tr id='" + Id_Registro + "'>"+
      "<td style='width: 1%; vertical-align: middle;'>"+Id_Registro+"</td>"+
      "<td style='width: 33%'>"+
      "<div class='form-group'>"+
      "<input type='text' class='form-control' placeholder='Día' id='TX_Dia_"+Id_Registro+"' name='TX_Dia_"+Id_Registro+"'><span class='help-block' id='error'></span>"+
      "</div>"+
      "</td>"+
      "<td style='width: 33%'>"+
      "<div class='form-group'>"+
      "<input type='text' class='form-control hora_inicio' readonly='readonly' placeholder='Hora de inicio' id='TX_Hora_Inicio_"+Id_Registro+"'' name='TX_Hora_Inicio_"+Id_Registro+"''><span class='help-block' id='error'></span>"+
      "<input type='hidden' class='form-control fecha' placeholder='Fecha' id='TX_Fecha_"+Id_Registro+"'' name='TX_Fecha_"+Id_Registro+"''>"+
      "</div>"+
      "</td>"+
      "<td style='width: 33%'>"+
      "<div class='form-group'>"+
      "<input type='text' class='form-control' placeholder='Cupos' id='TX_Cupos_"+Id_Registro+"'' name='TX_Cupos_"+Id_Registro+"''><span class='help-block' id='error'></span>"+
      "</div>"+
      "</td>"+
      "</tr>");    
    $('.hora_inicio').timepicker({
      timeFormat: 'HH:mm',
      interval: 30,
      minTime: '7',
      maxTime: '18:00',
      dynamic: false,
      dropdown: true,
      scrollbar: true
    });
  });

  $("#btn_Quitar").click(function() {
    $("table#tabla_Titulos_Registro tr#" + Id_Registro).remove();
    if (Id_Registro > 1) {
      Id_Registro--;
    }
  });

  $("#BT_guardar_oferta").click(function(){
    rules = {};
    messages = {};
    for(i=1 ; i<=Id_Registro; i++){
      rules["TX_Dia_"+i] = {required: true};
      messages["TX_Dia_"+i] = {required: 'Por favor seleccione la fecha en el calendario'};
      rules["TX_Hora_Inicio_"+i] = {required: true};
      messages["TX_Hora_Inicio_"+i] = {required: 'Por favor seleccione la hora de la atención'};
      rules["TX_Cupos_"+i] = {required: true};
      messages["TX_Cupos_"+i] = {required: 'Por favor indique la cantidad de cupos'};
    }
    validator = $("#form_crear_oferta_diaria").validate({      
      rules:rules,
      messages:messages,
      invalidHandler: function(event, validator) {
        return false;
      },
      errorPlacement: function(error, element) {
        $(element).closest('.form-group').find('.help-block').html(error.html());
      },
      highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        $(element).closest('.form-group').find('.help-block').html('');
      },
      submitHandler: function(form) {
        crearOfertaDiaria();
      },
    });
  });

  function crearOfertaDiaria(dayOfWeek){
    var mostrar = "";
    var horario_oferta = "";
    var hora_fin = "";
    var cupos_oferta = "";
    var day = '4';
    for(i=1;i<=Id_Registro;i++){
      horario_oferta += $("#TX_Hora_Inicio_" + i).val() + ";";
      var hora = $("#TX_Hora_Inicio_" + i).val().split(':');
      var divi = parseFloat(hora[0]) + 2;
      var hora_concat = divi + ":" + hora[1];
      hora_fin += hora_concat + ";"; 
      cupos_oferta += $("#TX_Cupos_" + i).val() + ";";
    }
    datos = {
      funcion: 'crearOfertaDiaria',
      p1: {
        'formulario': $("#SL_Formulario").val(),
        'tipo_atencion': $("#TX_TipoAtencion").val(),
        'fecha_oferta': $("#TX_Fecha_Atencion").val(),
        'dia': $("#TX_Dia_1").val(),
        'horario': horario_oferta,
        'horario_fin': hora_fin,
        'cupos': cupos_oferta,
        'cupos_disponibles': cupos_oferta,        
        'id_usuario': parent.idUsuario,
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.swal("Operación exitosa", "Se ha guardado de manera correcta la oferta para este día", "success");
        $("#TX_Fecha_Encuentro").val("");
        $("#div_Registro_Beneficiarios").hide();
        for (i = Id_Registro; i >= 1; i--) {
          if (i != 1) {
            $("table#tabla_Titulos_Registro tr#" + i).remove();
          } else {
            $("#SL_Formulario").val("");
            $("#SL_Formulario").selectpicker("refresh");
            $("#TX_TipoAtencion").val("");
            $("#TX_TipoAtencion").selectpicker("refresh");
            $("#TX_Fecha_Atencion").val("");
            $("#TX_Dia_1").val("");
            $("#TX_Hora_Inicio_1").val("");
            $("#TX_Fecha_1").val("");
            $("#TX_Cupos_1").val("");
            $("#TX_Dia_1").popover("destroy");
            Id_Registro = 1;
          }
        }
      },
      async: false
    });
    return mostrar;
  }

  function getMes() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsMes'
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data
      },
      async: false
    });
    return mostrar;
  }

  function getArtistasComunitarios() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsArtistas'
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data
      },
      async: false
    });
    return mostrar;
  }

  $("#BT_Consultar_Horarios").click(function(){
    $("#div_oferta_atenciones_mes").show();
    ConsultarOfertaVirtual();     
  });

  /*--------------------------------------------------------------------------------------*/
  var tabla_oferta_mensual = $("#tabla_oferta_mensual").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    info: false,
    dom: 'Bfrtip',
    order: [[ 3, 'asc' ]],
    buttons: [
    'excel'
    ],
    "language": {
      "lengthMenu": "Ver _MENU_ registros por pagina",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando pagina _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Filtrar"
    }
  });
  function ConsultarOfertaVirtual() {
    var mostrar = "";
    tabla_oferta_mensual.clear().draw();
    var datos = {
      funcion: 'consultarOfertaVirtual',
      'p1': $("#SL_Mes").val(),
      'p2': $("#SL_Formulario_Horario").val()
      
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    }).done(function(data) {
      tabla_oferta_mensual.rows.add($(data)).draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }

  $("table").delegate(".editarFranja", "click", function() {
    var idFranjaEditar = $(this).data("id-frnaja");
    $("#TX_ID_Franja_Editar").val($(this).data("id-frnaja"));
    $("#SL_Formulario_Editar").val($(this).data("formulario")).selectpicker('refresh').trigger('change');
    $("#TX_TipoAtencion_Editar").val($(this).data("atencion")).selectpicker('refresh').trigger('change');
    $("#TX_Fecha_Editar").val($(this).data("fecha"));
    $("#TX_Hora_Editar").val($(this).data("hora"));
    $("#TX_CuposDis_Editar").val($(this).data("disponible"));
    Cupos = $(this).data("cupos");
  });



  /* ----------------------------------------*/

  $("#form_editar_franja_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var horainicio = $("#TX_Hora_Editar").val().split(':');
    var divi = parseFloat(horainicio[0]) + 2;
    var horafin = divi + ":" + horainicio[1];
    var cuposdisp = $("#TX_CuposDis_Editar").val();
    var sumarcupos = $("#TX_Sumar_Cupos").val();
    var cupostotal = parseFloat(Cupos) + parseFloat(sumarcupos);     
    var nuevoscupos = parseFloat(cuposdisp) + parseFloat(sumarcupos);   
    var mostrar = "";
    datos = {
      funcion: 'EditarFranjaHoraria',
      p1: {
        'tx_id_franja': $("#TX_ID_Franja_Editar").val(),
        'sl_formulario': $("#SL_Formulario_Editar").val(),
        'sl_atencion': $("#TX_TipoAtencion_Editar").val(),
        'tx_fecha': $("#TX_Fecha_Editar").val(),
        'tx_horainicio': $("#TX_Hora_Editar").val(),
        'tx_horafin': horafin,
        'tx_cupostotal': cupostotal,
        'tx_disponibles': nuevoscupos,
        'id_usuario': parent.idUsuario
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Mensaje del sistema","Se modifico correctamente la información de la franja horaria !!!");
        $("#miModalEditarFranja").modal('hide');
        ConsultarOfertaVirtual();
        $("#TX_Sumar_Cupos").val("");
      },
      async: false
    });
    return mostrar;
  });


  /* ---------- */
  /*---------------ASIGNACIÓN DE ARTISTAS-----------------------------------------------*/


  $("#SL_Formulario_Artista").on("change", function(){

    $("#div_demanda_atenciones").hide("slow");

    if($(this).val() == 4 || $(this).val() == 5){
     $("#div-horario-asignar-artista").hide();
     $("#TX_Fecha_Asignacion").attr("required", false);
   }else{
     $("#div-horario-asignar-artista").show();
     $("#TX_Fecha_Asignacion").attr("required", true);
   }
 });

  $('#form-asignacion-artista').on('submit', function (event) {
    event.preventDefault();
    $("#div_demanda_atenciones").show();
    consultarDemandaVirtual();
  });

  var tabla_demanda_diaria = $("#tabla_demanda_diaria").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    info: false,
    dom: 'Bfrtip',
    order: [[ 3, 'asc' ]],
    buttons: [
    'excel'
    ],
    "language": {
      "lengthMenu": "Ver _MENU_ registros por pagina",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando pagina _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Filtrar"
    }
  });
  function consultarDemandaVirtual() {
    var mostrar = "";
    tabla_demanda_diaria.clear().draw();
    var datos = {
      funcion: 'consultarDemandaVirtual',
      'p1': $("#TX_Fecha_Asignacion").val(),
      'p2': $("#SL_Formulario_Artista").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    }).done(function(data) {
      tabla_demanda_diaria.rows.add($(data)).draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }  

  $("table").on("click", ".asignarArtista", function() {
    var idFranjaArtista = $(this).data("id-registro");
    Localidad = $(this).data("idlocalidad");
    formulario = $(this).data("formulario");
    
    $("#TX_ID_Franja_Artista").val($(this).data("id-registro"));
    $("#formulario").html($(this).data("formulario"));
    $("#atencion").html($(this).data("atencion"));
    $("#horario").html($(this).data("horario"));
    
    if($(this).data("formulario") == "Arn" || $(this).data("formulario") == "Aulas hospitalarias"){
      $("#fecha-llamada").attr("readonly", false);
    }else{
      $("#fecha-llamada").attr("readonly", true);
    }

    $("#fecha-llamada").val($(this).data("fecha"));
    $("#localidad").html($(this).data("localidad"));
    $("#barrio").html($(this).data("barrio"));
    $("#direccion").html($(this).data("direccion"));
    $("#SL_Artista").html(getArtistasComunitarios()).selectpicker("refresh");
    $("#SL_Artista").val($(this).data("artista")).selectpicker('refresh').trigger('change');
    $("#SL_Upz").html(getUpzLocalidad(Localidad)).selectpicker("refresh");
    $("#SL_Upz").val($(this).data("idupz")).selectpicker('refresh').trigger('change');
  });

  function getUpzLocalidad(Localidad) {
    var mostrar = "";
    var datos = {
      funcion: 'getUpzLocalidad',
      'p1': Localidad
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data
      },
      async: false
    });
    return mostrar;
  }

  $("#form_Asignacion_Artista_div").on("submit", function(event) {
    event.stopPropagation();
    event.preventDefault();

    datos = {
      funcion: 'validarFechaAsignacion',
      p1: $("#TX_ID_Franja_Artista").val(),
    };

    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      dataType: 'json',
      success: function(data) {
        if(formulario == "Arn" || formulario == "Aulas hospitalarias"){
          if(data.DT_Fecha_Llamada == $("#fecha-llamada").val()){
            parent.mostrarAlerta("warning","Alerta","Ya se asignó una llamada para la fecha seleccionada, por favor elija otra fecha");
          }else{
            asignarArtista();
          }
        }else{
          asignarArtista();
        }
      },
      async: false
    });
  });

  function asignarArtista(){
    datos = {
      funcion: 'AsignarArtista',
      p1: {
        'formulario': $("#formulario").text(),
        'tx_id_franja': $("#TX_ID_Franja_Artista").val(),
        'sl_artista': $("#SL_Artista").val(),
        'sl_upz': $("#SL_Upz").val(),
        'fecha_llamada': $("#fecha-llamada").val(),
        'quien_asigno': parent.idUsuario
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.mostrarAlerta("success","Mensaje del sistema","Se asigno correctamente el artista comunitario a la atención virtual !!!");
        $("#miModalAsignarArtista").modal('hide');
        consultarDemandaVirtual();       
      },
      async: false
    });
  }

  /* JS Consulta total de atenciones por mes  */
  $("#SL_Mes_Total").html(getMes()).selectpicker("refresh");
  $("#SL_Mes_Total").change(cargarTotalAtenciones);

  function cargarTotalAtenciones() {
    $("#div_total_atenciones").show();
    ConsultarTotalAtenciones();     
  }

  /*--------------------------------------------------------------------------------------*/
  var tabla_total_atenciones = $("#tabla_total_atenciones").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    info: false,
    dom: 'Bfrtip',
    order: [[ 3, 'asc' ]],
    buttons: [
    'excel'
    ],
    "language": {
      "lengthMenu": "Ver _MENU_ registros por pagina",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando pagina _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Filtrar"
    }
  });
  function ConsultarTotalAtenciones() {
    var mostrar = "";
    tabla_total_atenciones.clear().draw();
    var datos = {
      funcion: 'consultarTotalAtencionesMes',
      'p1': $("#SL_Mes_Total").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    }).done(function(data) {
      tabla_total_atenciones.rows.add($(data)).draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }


  $("table").delegate(".editarllamada", "click", function() {
    var idregistro = $(this).data("id-registro");
    $("#TX_ID_Llamada").val($(this).data("id-registro"));
    $("#TX_TipoAcudiente_Editar").val($(this).data("tipo-cuidador")).selectpicker('refresh').trigger('change');
    $("#TX_Documento_Acudiente_Editar").val($(this).data("numero-cuidador"));
    $("#TX_Nombre_Acudiente_Editar").val($(this).data("cuidador"));
    $("#TX_Correo_Editar").val($(this).data("correo"));
    $("#TX_Localidad_Editar").val($(this).data("localidad")).selectpicker('refresh').trigger('change'); 
    $("#TX_Barrio_Editar").val($(this).data("barrio"));
    $("#TX_Direccion_Editar").val($(this).data("direccion")); 
    $("#TX_Estrato_Editar").val($(this).data("estrato")).selectpicker('refresh').trigger('change');
    $("#TX_Dirigido_Editar").val($(this).data("id-dirigida")).selectpicker('refresh').trigger('change');
    $("#TX_Parentesco_Editar").val($(this).data("id-parentesco")).selectpicker('refresh').trigger('change');
    $("#TX_Potestad_Editar").val($(this).data("id-potestad")).selectpicker('refresh').trigger('change');
    $("#TX_TipoBeneficiario_Editar").val($(this).data("tipo-beneficiario")).selectpicker('refresh').trigger('change');
    $("#TX_Num_Documento_Editar").val($(this).data("identificacion"));
    $("#TX_Nombres_Editar").val($(this).data("nombres"));
    $("#TX_Apellidos_Editar").val($(this).data("apellidos")); 
    $("#TX_F_Nacimiento_Editar").val($(this).data("fecha-nacimiento"));
    $("#TX_Fecha_Editar").val($(this).data("fecha"));
    $("#TX_Horario_Editar").val($(this).data("hora"));
    $("#TX_Telefono_Editar").val($(this).data("celular"));
  });

  $("#form_editar_llamado_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var mostrar = "";
    datos = {
      funcion: 'EditarInformacionLlamada',
      p1: {
        'tx_id_llamada': $("#TX_ID_Llamada").val(),       
        'tx_tdoc_acudiente': $("#TX_TipoAcudiente_Editar").val(),   
        'tx_num_acudiente': $("#TX_Documento_Acudiente_Editar").val(),
        'tx_nombre_acudiente': $("#TX_Nombre_Acudiente_Editar").val(),
        'tx_correo': $("#TX_Correo_Editar").val(),
        'tx_localidad': $("#TX_Localidad_Editar").val(),
        'tx_barrio': $("#TX_Barrio_Editar").val(),
        'tx_direccion': $("#TX_Direccion_Editar").val(),
        'tx_estrato': $("#TX_Estrato_Editar").val(),
        'tx_dirigido': $("#TX_Dirigido_Editar").val(),
        'tx_parentesco': $("#TX_Parentesco_Editar").val(),
        'tx_potestad': $("#TX_Potestad_Editar").val(),
        'tx_tdoc_beneficiario': $("#TX_TipoBeneficiario_Editar").val(),       
        'tx_num_beneficiario': $("#TX_Num_Documento_Editar").val(),
        'tx_nombres': $("#TX_Nombres_Editar").val(),
        'tx_apellidos': $("#TX_Apellidos_Editar").val(),
        'tx_fecha_nacimiento': $("#TX_F_Nacimiento_Editar").val(),
        'tx_fecha_llamada': $("#TX_Fecha_Editar").val(),
        'tx_horario': $("#TX_Horario_Editar").val(),   
        'tx_telefono': $("#TX_Telefono_Editar").val()       
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Mensaje del sistema","Se actualizo correctametne la información de la atención, ya se puede descargar la información en PDF!!!");
        $("#miModalEditarLlamada").modal('hide');
        ConsultarTotalAtenciones();
      },
      async: false
    });
    return mostrar;
  });
});