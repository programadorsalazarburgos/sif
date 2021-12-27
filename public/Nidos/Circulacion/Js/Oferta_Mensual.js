var url_ok_obj = '../../../src/CirculacionNidos/Controlador/OfertaCirculacionController.php';
var url_ok_obj2 = '../../../src/CirculacionNidos/Controlador/SolicitudEventosController.php';
var options_franja;
var options_tipo_lugar;
var options_modalidad_atencion;
var options_equipo;

$(document).ready(function() {

  options_franja = parent.getOptionsParametroDetalle(48);
  options_tipo_lugar = parent.getOptionsParametroDetalle(50);
  options_modalidad_atencion = parent.getOptionsParametroDetalle(51);
  options_equipo = getEquiposCirculacion();

  $("#TX_Localidad_Editar").html(parent.getOptionsParametroDetalle(19)).selectpicker("refresh");

  $('a[href="#consultar_oferta"]').click(function() {
    ConsultarOfertaMensual();
  });
  $("#SL_Mes").html(getMes()).selectpicker("refresh");
  $("#SL_Mes").change(cargarDatosOferta);

  $(".selectpicker.franja").html(options_franja).selectpicker("refresh");
  $(".selectpicker.tipo-lugar").html(options_tipo_lugar).selectpicker("refresh");

  $(".selectpicker.modalidad-atencion").html(options_modalidad_atencion).selectpicker("refresh");
  $(".selectpicker.equipo").html(options_equipo).selectpicker("refresh");

  $(".selectpicker.tipo-lugar").on("change", function(){
    let input_id;
    input_id = $(this).attr("id") == "SL_Tipo_Lugar_Editar" ? "#TX_OtroLugar_Editar" : "#TX_OtroLugar_Div";

    $(this).val() == 10 ? $(input_id).attr("disabled", false) : $(input_id).attr("disabled", true);
    $(this).val() == 10 ? $(input_id).attr("required", true) : $(input_id).attr("required", false);
    $(this).val() != 10 ? $(input_id).val("") : "";
  });

  $(".selectpicker.tipo-atencion").on("change", function(){
    let id_elemento_tipo_lugar;
    id_elemento_tipo_lugar = $(this).attr("id") == "SL_Tipo_Atencion_Div" ? "#SL_Tipo_Lugar_Div" : "#SL_Tipo_Lugar_Editar";
    if($(this).val() == "Virtual"){
      $(id_elemento_tipo_lugar).attr("disabled", true);
      $(id_elemento_tipo_lugar).val(11).selectpicker("refresh").trigger("change");
    }else{
      $(id_elemento_tipo_lugar).attr("disabled", false);
      $(id_elemento_tipo_lugar).children("option[value^='11']").hide();
      if($(id_elemento_tipo_lugar).val() != 11){
        $(id_elemento_tipo_lugar).selectpicker("refresh").trigger("change");
      }else{
        $(id_elemento_tipo_lugar).val("").selectpicker("refresh").trigger("change");        
      }
    }
  });

  function cargarDatosOferta() {
    $("#div_oferta_mes").show("refresh");
    ConsultarOfertaMensual();
  }

  $("table").delegate(".aprobar_evento", "click", function() {
    var idEventoAprobar = $(this).data("id-evento");
    $("#SL_Lugar_Evento_Div").html(getLugarAtencion(idEventoAprobar)).selectpicker("refresh");

    $("#LB_Dia_Evento").html($(this).data("dia"));
    $("#LB_Fecha_Evento").html($(this).data("fecha"));
    $("#LB_Franja_Evento").html($(this).data("franja"));
    $("#LB_Solicita_Equipos").html($(this).data("soliequipos")); 


    $("#TX_ID_Evento_Aprobar_Div").val($(this).data("id-evento"));
    $("#LB_Solicita").html($(this).data("solicita"));
    $("#LB_Localidad").html($(this).data("localidad"));
    $("#LB_Evento").html($(this).data("evento"));
    $("#LB_Entidad").html($(this).data("entidad"));
    $("#LB_Contacto").html($(this).data("contacto"));
    $("#LB_Gestor").html($(this).data("gestor-asis"));
    $("#LB_Ninos").html($(this).data("ninos"));
    $("#LB_Adultos").html($(this).data("adultos"));
    $("#LB_Artistas").val($(this).data("artistas"));
    $("#TX_Ubicacion_Div").val($(this).data("ubicacion"));
    $("#TX_Indicaciones_Div").val($(this).data("llegada"));
    $("#SL_Lugar_Evento_Div").val($(this).data("idlugarate")).selectpicker('val', $(this).data("idlugarate").split(',').map(Number));
    $("#SL_Solicitud_Div").val($(this).data("solicitud-info")).selectpicker('refresh').trigger('change');
    $("#SL_Tipo_Lugar_Div").val($(this).data("tipo-atencion")).selectpicker('refresh').trigger('change');
    $("#TX_OtroLugar_Div").val($(this).data("otro-tipo-lugar"));
    $("#SL_Ficha_Tecnica_Div").val($(this).data("ficha")).selectpicker('refresh').trigger('change');
    $("#SL_Modalidad_Div").val($(this).data("modalidad")).selectpicker('val', $(this).data("modalidad").split(',').map(Number));
    $("#SL_Linea_Atencion_Div").val($(this).data("linea")).selectpicker('val', $(this).data("linea").split(',').map(Number));
    $("#TX_Propuesta_Div").val($(this).data("propuesta"));
    $("#TX_Transporte_Div").val($(this).data("transporte"));
    $("#TX_Contacto_Trans_Div").val($(this).data("contac-trans"));
    $("#TX_Hora_Llegada_Div").val($(this).data("llegada-trans"));
    $("#TX_Terreno_Div").val($(this).data("terreno"));
    $("#TX_Acompanamiento_Div").val($(this).data("acirculacion"));
    $("#TX_Llegada_Artistas_Div").val($(this).data("llegadaartistas"));
    $("#TX_Montaje_Nido").val($(this).data("montajenido"));
    $("#TX_Inicio_Atencion_Div").val($(this).data("inicioatencion"));    
    $("#TX_Fin_Atencion_Div").val($(this).data("finalizacion"));
    $("#TX_Hora_Montaje_Div").val($(this).data("montaje"));    
    $("#TX_Hora_Desmontaje_Div").val($(this).data("desmontaje"));
    $("#SL_Equipo_Div").val($(this).data("equipo")).selectpicker('val', $(this).data("equipo").split(',').map(Number));
    $("#SL_Tipo_Atencion_Div").val($(this).data("vc-tipo-atencion")).selectpicker("refresh").trigger("change");

  });

  $("table").delegate(".editarEvento", "click", function() {
    console.log($(this).data("tipo-atencion"));


    var idEventoEditar = $(this).data("id-evento");
    var idlugar = $(this).data("idlugarate");    
    $("#TX_LAtencion_Editar").html(getLugarAtencion(idEventoEditar)).selectpicker("refresh");

    $("#TX_ID_Evento_Editar").val($(this).data("id-evento"));
    $("#TX_Dia_Editar").val($(this).data("dia")).selectpicker('refresh').trigger('change');
    $("#TX_Fecha_Editar").val($(this).data("fecha"));
    $("#TX_Franja_Editar").val($(this).data("franja")).selectpicker('refresh').trigger('change'); 
    $("#TX_Solicita_Editar").val($(this).data("solicita"));    
    $("#TX_Localidad_Editar").val($(this).data("localidad")).selectpicker('refresh').trigger('change');
    $("#TX_NomEvento_Editar").val($(this).data("evento"));
    $("#TX_Entidad_Editar").val($(this).data("entidad"));
    $("#TX_ContactoL_Editar").val($(this).data("contacto"));
    $("#TX_LAtencion_Editar").val($(this).data("idlugarate")).selectpicker('val', $(this).data("idlugarate").split(',').map(Number));
    $("#TX_Gestor_Editar").val($(this).data("idgestor")).selectpicker('refresh').trigger('change');
    $("#TX_VisitaTecnica_Editar").val($(this).data("ficha")).selectpicker('refresh').trigger('change');
    $("#TX_ArtistasL_Editar").val($(this).data("artistas"));
    $("#TX_Ubicacion_Editar").val($(this).data("ubicacion"));
    $("#TX_Indicaciones_Editar").val($(this).data("llegada"));    
    $("#TX_SInformacion_Editar").val($(this).data("solicitud-info")).selectpicker('refresh').trigger('change');
    

    $("#SL_Tipo_Lugar_Editar").val($(this).data("tipo-atencion")).selectpicker('refresh').trigger('change');



    $("#TX_OtroLugar_Editar").val($(this).data("otro-tipo-lugar"));
    $("#TX_Propuesta_Editar").val($(this).data("propuesta"));
    $("#LB_Artistas_Editar").val($(this).data("artistas"));
    $("#TX_Transporte_Editar").val($(this).data("transporte"));
    $("#TX_ContactoTrans_Editar").val($(this).data("contac-trans"));
    $("#TX_LlegadaTrans_Editar").val($(this).data("llegada-trans"));
    $("#TX_Particularidades_Editar").val($(this).data("terreno"));
    $("#TX_Ninos_Editar").val($(this).data("ninos"));
    $("#TX_Adultos_Editar").val($(this).data("adultos"));
    $("#TX_Circulacion_Editar").val($(this).data("acirculacion"));
    $("#TX_LlegadaArtistas_Editar").val($(this).data("llegadaartistas"));
    $("#TX_MontajeNido_Editar").val($(this).data("montajenido"));
    $("#TX_InicioAtencion_Editar").val($(this).data("inicioatencion"));
    $("#TX_FinAtencion_Editar").val($(this).data("finalizacion"));
    $("#TX_HoraMontaje_Editar").val($(this).data("montaje"));
    $("#TX_Hora_Desmontaje_Editar").val($(this).data("desmontaje"));
    $("#SL_Equipo_Editar").val($(this).data("equipo")).selectpicker('val', $(this).data("equipo").split(',').map(Number));
    $("#SL_Modalidad_Editar").val($(this).data("modalidadeditar")).selectpicker('val', $(this).data("modalidadeditar").split(',').map(Number));
    $("#TX_Lineatencion_Editar").val($(this).data("linea")).selectpicker('val', $(this).data("linea").split(',').map(Number));
    $("#SL_Tipo_atencion_editar").val($(this).data("vc-tipo-atencion")).selectpicker("refresh").trigger("change");

  });


  $("table").delegate(".cancelar_evento", "click", function() {

    $("#TX_ID_Evento_Cancelar").val($(this).data("id-evento"));
    $("#LB_EventoCa").html($(this).data("evento"));
    $("#LB_Dia").html($(this).data("dia"));
    $("#LB_Fecha").html($(this).data("fecha")); 
  });

  $("table").delegate(".Consultar-Reporte", "click", function() {
    var idEvento = $(this).data("id-evento");
    procesarInfoPDFInforme(idEvento);
  });


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

  function getTipoEvento() {
    var mostrar = "";
    var datos = {
      funcion: 'consultarTipoEvento'
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
  
  /*-----------------Función para mostrar los equipos -----------------------*/
  function getEquiposCirculacion() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsEquipos'
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    });
    return mostrar;
  }

  function getLugarAtencion(idEventoEditar) {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsLAtencion',
      'p1': idEventoEditar
    };
    $.ajax({
      url: url_ok_obj2,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data        
      },
      async: false
    });
    return mostrar;
  }


  var Id_Registro = 1;
  var weekday=new Array(7);
  weekday[0]="Domingo";
  weekday[1]="Lunes";
  weekday[2]="Martes";
  weekday[3]="Miércoles";
  weekday[4]="Jueves";
  weekday[5]="Viernes";
  weekday[6]="Sábado";


  $("#TX_Fecha_Encuentro").datepicker({
    format: 'yyyy-mm-dd',
    language: 'es',
    autoclose: true,
    startDate: '01-01-2019'
  });


  $("#TX_Fecha_Encuentro").on("change", function(){
    var date = $(this).datepicker('getDate');
    var dayOfWeek = weekday[date.getUTCDay()];
    for (var i = 1; i <= Id_Registro; i++) {
      document.getElementById("TX_Dia_" + i).value = dayOfWeek;
      document.getElementById("TX_Fecha_" + i).value = document.getElementById("TX_Fecha_Encuentro").value;
    }
    console.log(dayOfWeek);
  });

  $(".modal.modal-wide .modal-dialog").css({
    "width": "90%"
  });


  var Id_Registro = 1;
  $("#btn_Agregar").click(function() {
    Id_Registro++;
    $("#tabla_Titulos_Registro").append("<tr id='" + Id_Registro + "'>"+
      "<td style='width: 1%; vertical-align: middle;'>"+Id_Registro+"</td>"+
      "<td style='width: 33%'>"+
      "<div class='form-group'>"+
      "<input type='text' class='form-control' placeholder='Día' id='TX_Dia_"+Id_Registro+"' name='TX_Dia_"+Id_Registro+"' required>"+
      "</div>"+
      "</td>"+
      "<td style='width: 33%'>"+
      "<div class='form-group'>"+
      "<input type='text' class='form-control fecha' placeholder='Fecha' id='TX_Fecha_"+Id_Registro+"'' name='TX_Fecha_"+Id_Registro+"' required>"+
      "</div>"+
      "</td>"+
      "<td style='width: 33%'>"+
      "<div class='form-group'>"+
      "<select class='form-control selectpicker franja' data-live-search='true' id='TX_Franja_"+Id_Registro+"' name='TX_Franja_"+Id_Registro+"' title='Seleccione una opción' required></select>"+
      "</div>"+
      "</td>"+
      "</tr>");
    $("#TX_Franja_" + Id_Registro).html(options_franja).selectpicker("refresh");
  });

  $("#btn_Quitar").click(function() {
    $("table#tabla_Titulos_Registro tr#" + Id_Registro).remove();
    if (Id_Registro > 1) {
      Id_Registro--;
    }
  });

  $('#form_crear_oferta_diaria').on('submit', function (event) {
    event.preventDefault();
    crearOfertaDiaria();
  });

  function crearOfertaDiaria(dayOfWeek){
    var mostrar = "";
    var franja_oferta = "";
    var day = '4';
    for(i=1;i<=Id_Registro;i++){
      franja_oferta += $("#TX_Franja_" + i).val() + ";";
    }
    datos = {
      funcion: 'crearOfertaDiaria',
      p1: {
        'dia_oferta': $("#TX_Dia_1").val(),
        'fecha_oferta': $("#TX_Fecha_Encuentro").val(),
        'franja_oferta': franja_oferta,
        'id_usuario': parent.idUsuario,
        'aprobacion': 0
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
            $("#TX_Dia_1").val("");
            $("#TX_Fecha_1").val("");
            $("#TX_Franja_1").val("");
            $("#TX_Franja_1").selectpicker("refresh");
            $("#TX_Dia_1").popover("destroy");
            Id_Registro = 1;
          }
        }
      },
      async: false
    });
    return mostrar;
  }

  /*--------------------------------------------------------------------------------------*/
  var tabla_oferta_mensual = $("#tabla_oferta_mensual").DataTable({
    paging: false,
    scrollX: true,
    scrollCollapse: true,
    fixedColumns:{
      leftColumns: 4,
    },
    scrollY: "300px",
    dom: 'Bfrtip',
    buttons: [
    'excel'
    ],
    "language": {
      "lengthMenu": "Ver _MENU_ registros por página",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Filtrar"
    }
  });


  /*-----------------Función para consultar los grupos-----------------------*/
  function ConsultarOfertaMensual() {
    var mostrar = "";
    tabla_oferta_mensual.clear().draw();
    var datos = {
      funcion: 'consultarOfertaCreada',
      'p1': $("#SL_Mes").val()
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

  $("#form_aprobar_evento_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var ids = "";
    var idsModalidad = "";
    var idsLinea = "";
    var ids_lugar_atencion = "";

    $('#SL_Equipo_Div :selected').each(function(i, selected) {
      if (ids == "") {
        ids = $(selected).val() + ",";
      }else{
        ids += $(selected).val() + ",";
      }
    });

    $('#SL_Modalidad_Div :selected').each(function(i, selected) {
      if (idsModalidad == "") {
        idsModalidad = $(selected).val() + ",";
      }else{
        idsModalidad += $(selected).val() + ",";
      }
    });

    $('#SL_Linea_Atencion_Div :selected').each(function(i, selected) {
      if (idsLinea == "") {
        idsLinea = $(selected).val() + ",";
      }else{
        idsLinea += $(selected).val() + ",";
      }
    });

    $('#SL_Lugar_Evento_Div :selected').each(function(i, selected) {
      if(ids_lugar_atencion == ""){
        ids_lugar_atencion = $(selected).val() + ",";
      }else{
        ids_lugar_atencion += $(selected).val() + ",";
      }
    });

    var mostrar = "";
    datos = {
      funcion: 'AprobarEventoCirculacion',
      p1: {
       'tx_id_evento': $("#TX_ID_Evento_Aprobar_Div").val(),
       'sl_solicitud': $("#SL_Solicitud_Div").val(),
       'sl_poblacion': idsModalidad,
       'sl_atencion':  $("#SL_Tipo_Lugar_Div").val(), 
       'sl_linea': idsLinea,
       'tx_propuesta': $("#TX_Propuesta_Div").val(),
       'tx_transporte': $("#TX_Transporte_Div").val(),
       'tx_contac_trans': $("#TX_Contacto_Trans_Div").val(),
       'tx_hora_llegada': $("#TX_Hora_Llegada_Div").val(),
       'tx_terreno': $("#TX_Terreno_Div").val(),
       'tx_equipo': ids,
       'tx_fichatecnica': $("#SL_Ficha_Tecnica_Div").val(),       
       'tx_acompana': $("#TX_Acompanamiento_Div").val(),
       'tx_llegada': $("#TX_Llegada_Artistas_Div").val(),
       'tx_montaje_nido': $("#TX_Montaje_Nido").val(),
       'tx_inicio_aten': $("#TX_Inicio_Atencion_Div").val(),
       'tx_fin_aten': $("#TX_Fin_Atencion_Div").val(),
       //'tx_lugar':    $("#SL_Lugar_Evento_Div").val(),
       'tx_lugar': ids_lugar_atencion,
       'tx_ubicacion': $("#TX_Ubicacion_Div").val(),
       'tx_indicaciones': $("#TX_Indicaciones_Div").val(),
       'tx_hora_montaje': $("#TX_Hora_Montaje_Div").val(),
       'tx_hora_desmontaje': $("#TX_Hora_Desmontaje_Div").val(),
       'tx_estado_modificar': '4'
     }
   };
   $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      mostrar += data;
      parent.mostrarAlerta("success","Mensaje del sistema","Se Aprobó el evento de manera correcta, ya se puede descargar la información en PDF!!!");
      $("#miModalAprobar").modal('hide');
      ConsultarOfertaMensual("refresh");
      limpiarFormularioAprobar();
    },
    async: false
  });
   return mostrar;
 });



  $("#form_editar_evento_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var idsEditar = "";
    var idsModalidadEditar = "";
    var idsLineaEditar = "";
    var ids_lugar_atencion = "";

    $('#SL_Equipo_Editar :selected').each(function(i, selected) {
      if(idsEditar == "") {
        idsEditar = $(selected).val() + ",";
      }else{
        idsEditar += $(selected).val() + ",";
      }
    });

    $('#SL_Modalidad_Editar :selected').each(function(i, selected) {
      if(idsModalidadEditar == "") {
        idsModalidadEditar = $(selected).val() + ",";
      }else{
        idsModalidadEditar += $(selected).val() + "," ;
      }
    });

    $('#TX_Lineatencion_Editar :selected').each(function(i, selected) {
      if(idsLineaEditar == "") {
        idsLineaEditar = $(selected).val() + ",";
      }else{
        idsLineaEditar += $(selected).val() + "," ;
      }
    });

    $('#TX_LAtencion_Editar :selected').each(function(i, selected) {
      if(ids_lugar_atencion == ""){
        ids_lugar_atencion = $(selected).val() + ",";
      }else{
        ids_lugar_atencion += $(selected).val() + ",";
      }
    });

    var mostrar = "";
    datos = {
      funcion: 'EditarEventoCirculacion',
      p1: {
        'tx_id_evento': $("#TX_ID_Evento_Editar").val(),
        'tx_dia': $("#TX_Dia_Editar").val(),
        'tx_fecha': $("#TX_Fecha_Editar").val(),
        'tx_franja': $("#TX_Franja_Editar").val(),
        'tx_nombreevento': $("#TX_NomEvento_Editar").val(),
        'tx_localidad': $("#TX_Localidad_Editar").val(),
        //'tx_lugar_atencion': $("#TX_LAtencion_Editar").val(),
        'tx_lugar_atencion': ids_lugar_atencion,
        'tx_entidad': $("#TX_Entidad_Editar").val(),
        'tx_linea_atencion': idsLineaEditar,
        'tx_tipo_atencion': $("#SL_Tipo_atencion_editar").val(),
        'tx_modalidad': idsModalidadEditar,
        'tx_gestor': $("#TX_Gestor_Editar").val(), 
        'tx_contactoL': $("#TX_ContactoL_Editar").val(),
        'sl_atencion': $("#SL_Tipo_Lugar_Editar").val(),
        'tx_otro_lugar': $("#TX_OtroLugar_Editar").val(),
        
        'tx_propuesta': $("#TX_Propuesta_Editar").val(),
        'tx_artistas': $("#LB_Artistas_Editar").val(),
        'tx_transporte': $("#TX_Transporte_Editar").val(),
        'tx_contac_trans': $("#TX_ContactoTrans_Editar").val(),
        'tx_hora_llegada': $("#TX_LlegadaTrans_Editar").val(),
        'tx_terreno': $("#TX_Particularidades_Editar").val(),               
        'tx_ubicacion': $("#TX_Ubicacion_Editar").val(),
        'tx_indicaciones': $("#TX_Indicaciones_Editar").val(),

        'tx_equipo_asignado': idsEditar,
        'tx_visitatecnica': $("#TX_VisitaTecnica_Editar").val(),
        'tx_acompana': $("#TX_Circulacion_Editar").val(),
        'tx_llegada': $("#TX_LlegadaArtistas_Editar").val(),
        'tx_hora_montaje': $("#TX_HoraMontaje_Editar").val(),
        'tx_montaje_nido': $("#TX_MontajeNido_Editar").val(),
        'tx_inicio_aten': $("#TX_InicioAtencion_Editar").val(),
        'tx_fin_aten': $("#TX_FinAtencion_Editar").val(),
        'tx_hora_desmontaje': $("#TX_Hora_Desmontaje_Editar").val(),
        'tx_ninos': $("#TX_Ninos_Editar").val(),
        'tx_adultos': $("#TX_Adultos_Editar").val(),

      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Mensaje del sistema","Se Aprobó el evento de manera correcta, ya se puede descargar la información en PDF!!!");
        $("#miModalEditarEvento").modal('hide');
        ConsultarOfertaMensual("refresh");
      //limpiarFormularioAprobar();
    },
    async: false
  });
    return mostrar;
  });

  /*---------------Función para limpiar el formulario despues de guardar los datos-----------------------*/
  function limpiarFormularioAprobar() {
    $("#SL_Equipo_Div").val("");
    $("#SL_Equipo_Div").selectpicker("refresh");
    $("#SL_Ficha_Tecnica_Div").val("");
    $("#SL_Ficha_Tecnica_Div").selectpicker("refresh");
    $("#TX_Acompanamiento_Div").val("");       
    $("#TX_Llegada_Artistas_Div").val("");
    $("#TX_Montaje_Nido").val("");
    $("#TX_Inicio_Atencion_Div").val("");
    $("#TX_Fin_Atencion_Div").val("");
    $("#TX_Montaje_EMusical").val("");
    $("#TX_Hora_Montaje_Div").val("");
    $("#TX_Hora_Desmontaje_Div").val("");
  }

  /*-----------------CANCELAR OFERTA O EVENTO-----------------------*/
  $("#form_cancelar_evento_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var mostrar = "";
    datos = {
      funcion: 'CancelarEventoCirculacion',
      p1: {
       'tx_id_evento': $("#TX_ID_Evento_Cancelar").val(),
       'tx_estado_modificar': '5'
     }
   };
   $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      mostrar += data;
      parent.mostrarAlerta("success","Mensaje del sistema","Se cancelo la oferta o Evento de manera correcta!!!");
      $("#miModalCancelar").modal('hide');
      ConsultarOfertaMensual("refresh");
        //limpiarFormularioConfirmar();
      },
      async: false
    });
   return mostrar;
 });
});