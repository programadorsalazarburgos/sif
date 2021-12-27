var url_ok_obj = '../../../src/CirculacionNidos/Controlador/SolicitudEventosController.php';
var url_ok_obj2 = '../../../src/Territorial/Controlador/AdministrarLugaresController.php'; 
var idLugarEventoSelected = 0;
var options_mes;
var options_localidad;
var options_tipo_lugar;
var arreglo;
var EquiposSoli = "";

$(document).ready(function(){

  options_mes = getMes();
  options_localidad = parent.getOptionsLocalidadesGestor(parent.idUsuario);
  options_tipo_lugar = parent.getOptionsParametroDetalle(50);

  $("#SL_Localidad_Div").html(options_localidad).change(function() {
    $("#TX_Lugar_Div").html(parent.getOptionsUpz($("#SL_Localidad_Div").val())).selectpicker("refresh");
  }).selectpicker("refresh");

  $(".selectpicker.tipo-lugar").html(options_tipo_lugar).selectpicker("refresh");

  $("#SL_Modalidad_Div").html(parent.getOptionsParametroDetalle(51)).selectpicker("refresh");

  $(".Mes").html(options_mes).selectpicker("refresh");
  $("#SL_Mes").change(cargarDatosOferta);
  $("#SL_Mes_Eventos").change(cargarDatosMisEventos);

  //Cargue Elementos Modificar

  $(".selectpicker.tipo-atencion").on("change", function(){
    let id_elemento_tipo_lugar;
    id_elemento_tipo_lugar = $(this).attr("id") == "SL_Tipo_Atencion_Div" ? "#SL_Tipo_Lugar_Div" : "#SL_Tipo_Lugar_Conf_Div";
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


  $("#SL_Localidad_Modificar").html(options_localidad).change(function() {
    $("#SL_Upz_Modificar").html(parent.getOptionsUpz($("#SL_Localidad_Modificar").val())).selectpicker("refresh");
  }).selectpicker("refresh");
  $("#SL_Entidad_Modificar").html(getEntidades()).selectpicker("refresh");


  $(".selectpicker.tipo-lugar").on("change", function(){
    let input_id;
    input_id = $(this).attr("id") == "SL_Tipo_Lugar_Div" ? "#TX_Otro_Lugar_Div" : "#TX_Otro_Lugar_Conf_Div";

    $(this).val() == 10 ? $(input_id).attr("disabled", false) : $(input_id).attr("disabled", true);
    $(this).val() == 10 ? $(input_id).attr("required", true) : $(input_id).attr("required", false);
    $(this).val() != 10 ? $(input_id).val("") : "";
  });

  function cargarDatosOferta() {
    $("#div_oferta_mes").show("refresh");
    ConsultarOfertaMensual();
  }

  function cargarDatosMisEventos() {
    $("#div_mis_eventos").show("refresh");
    consultarMisEventos();
  }

  $("table").on("click", ".Consultar-Reporte", function() {
    var idEvento = $(this).data("id-evento");
    procesarInfoPDFInforme(idEvento);
  });

  $(".modal.modal-wide .modal-dialog").css({
    "width": "90%"
  });


  $(document).on("change", "#TX_Lugar_Evento_Div", function() {
    var idlugarA = $(this).val();

    if($(this).val() == 999){ 
      $("#miModalConfirmar").modal('hide');
      $("#miModalLugarA").modal('show');

      $("#SL_Localidad_Modificar").val("");
      $("#SL_Localidad_Modificar").selectpicker('refresh');
      $("#SL_Upz_Modificar").val("");
      $("#SL_Upz_Modificar").selectpicker('refresh');
      $("#SL_Entidad_Modificar").val("");
      $("#SL_Entidad_Modificar").selectpicker('refresh');

      $("#TX_ID_Lugar_Atencion").val("");
      $("#TX_Barrio_Modificar").val("");
      $("#TX_NombreLugar_Modificar").val("");
      $("#TX_Direccion_Modificar").val("");
    }
  });

  var tabla_oferta_mensual = $("#tabla_oferta_mensual").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    dom: 'Bfrtip',
    order: [[ 1, 'asc' ]],
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

  var tabla_mis_eventos_mes = $("#tabla_mis_eventos_mes").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    info: false,
    dom: 'Bfrtip',
    order: [[ 1, 'asc' ]],
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

  function ConsultarOfertaMensual() {
    tabla_oferta_mensual.clear().draw();
    var datos = {
      funcion: 'getOfertaMensual',
      'p1': $("#SL_Mes").val(),
      'p2': parent.idUsuario,
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {},
      async: false
    }).done(function(data) {
      tabla_oferta_mensual.rows.add($(data)).draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
  }

  /*-----------------Función para consultar los grupos-----------------------*/
  function consultarMisEventos() {
    var mostrar = "";
    tabla_mis_eventos_mes.clear().draw();
    var datos = {
      funcion: 'consultarMisEventos',
      'p1': $("#SL_Mes_Eventos").val(),
      'p2': parent.idUsuario,

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
      tabla_mis_eventos_mes.rows.add($(data)).draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }

  $("table").on("click", ".reserva", function() {
    $("#TX_ID_Evento_Div").val($(this).data("id-evento"));    
    $("#fecha").html($(this).data("fecha-evento"));
    Disponible = $(this).data("disponible"); 
    $("#SL_Equipos_solicitados").html(SelectDisponible(Disponible)).selectpicker("refresh");
    Id_Disponible = $(this).data("iddisponible") + ','; 
    arreglo = Id_Disponible.split(",");
  });

  $("table").on("click", ".confirmar_reserva", function() {
    $("#LB_Dia_Evento").html($(this).data("dia"));
    $("#LB_Fecha_Evento").html($(this).data("fecha"));
    $("#LB_Franja_Evento").html($(this).data("franja"));
    $("#TX_ID_Evento_Confirmar_Div").val($(this).data("id-evento"));
    $("#TX_Nombre_Div").val($(this).data("evento"));  
    $("#SL_Tipo_Lugar_Conf_Div").val($(this).data("id_atencion")).selectpicker('refresh').trigger('change');
    $("#TX_Otro_Lugar_Conf_Div").val($(this).data("otro-lugar"));
    $("#SL_Tipo_Atencion_Conf_Div").val($(this).data("vc-tipo-atencion")).selectpicker("refresh").trigger("change");
    $("#TX_Entidad_Conf_Div").val($(this).data("entidad"));
    $("#Solicita").html($(this).data("solicita"));
    $("#NomEvento").html($(this).data("evento"));
    $("#localidad").html($(this).data("localidad"));
    $("#TX_Ninos_Conf").val($(this).data("ninos"));
    $("#TX_Adultos_Conf").val($(this).data("adulto"));
    idLugarEventoSelected = $(this).data("id-evento");
    $("#TX_Lugar_Evento_Div").html(getLugarAtencion(idLugarEventoSelected)).selectpicker("refresh");
  });

  $("#form_reservar_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();

    var SolicitudEquip = $("#SL_Equipos_solicitados").val();

    arreglo.length = SolicitudEquip;
    EquiposSoli = arreglo;    
    var stringEquiposSoli = EquiposSoli.toString();

    datos = {
      funcion: 'reservaEventoGestor',
      p1: {
        'tx_id_evento': $("#TX_ID_Evento_Div").val(),
        'tx_evento_nombre': $("#TX_Evento_Div").val(),
        'sl_localidad': $("#SL_Localidad_Div").val(),
        'tx_solicita': parent.idUsuario,
        'tx_entidad': $("#TX_Entidad_Div").val(),
        'sl_tipo_atencion': $("#SL_Tipo_Atencion_Div").val(),
        'sl_atencion': $("#SL_Tipo_Lugar_Div").val(),
        'tx_otro_lugar' : $("#TX_Otro_Lugar_Div").val(),
        'sl_cantidad_equipos': $("#SL_Equipos_solicitados").val(),
        'tx_estado': '2',
        'Equipos_Soli': stringEquiposSoli,
        'tx_ninos': $("#TX_Ninos_Div").val(),
        'tx_adultos': $("#TX_Adultos_Div").val()
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.mostrarAlerta("success","Mensaje del sistema","Se ha realizado la reserva del evento de manera exitosa!!!");
        $("#miModalReservar").modal('hide');
        ConsultarOfertaMensual("refresh");
        limpiarFormulario();       
      },
      async: false
    });
  });

  $("#form_confirmar_evento_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();

    var idsModalidad = "";
    var idsLinea = "";
    var ids_lugar_atencion = "";

    $('#SL_Modalidad_Div :selected').each(function(i, selected) {
      if(idsModalidad == "") {
        idsModalidad = $(selected).val() + ",";
      }else{
        idsModalidad += $(selected).val() + ",";
      }
    });

    $('#SL_Linea_Atencion_Div :selected').each(function(i, selected) {
      if(idsLinea == ""){
        idsLinea = $(selected).val() + ",";
      }else{
        idsLinea += $(selected).val() + ",";
      }
    });

    $('#TX_Lugar_Evento_Div :selected').each(function(i, selected) {
      if(ids_lugar_atencion == ""){
        ids_lugar_atencion = $(selected).val() + ",";
      }else{
        ids_lugar_atencion += $(selected).val() + ",";
      }
    });

    datos = {
      funcion: 'ConfirmarEventoGestor',
      p1: {
        'tx_id_evento': $("#TX_ID_Evento_Confirmar_Div").val(),
        'tx_nombre': $("#TX_Nombre_Div").val(),
        'sl_atencion': $("#SL_Tipo_Lugar_Conf_Div").val(),
        'tx_otro_lugar': $("#TX_Otro_Lugar_Conf_Div").val(),
        'sl_tipo_atencion': $("#SL_Tipo_Atencion_Conf_Div").val(),
        'tx_entidad': $("#TX_Entidad_Conf_Div").val(),
        'tx_contacto': $("#TX_Contacto_Div").val(),
        'sl_solicitud': $("#SL_Solicitud_Div").val(),
        'sl_poblacion': idsModalidad,
        'sl_gestor': $("#SL_Gestor_Asis_Div").val(),
        'sl_linea': idsLinea,
        'tx_propuesta': $("#TX_Propuesta_Div").val(),
        'tx_artistas': $("#TX_Artistas_Div").val(),
        'tx_transporte': $("#TX_Transporte_Div").val(),
        'tx_contacto_trans': $("#TX_Contacto_Trans_Div").val(),
        'tx_hora_llegada': $("#TX_Hora_Llegada_Div").val(),
        'tx_terreno': $("#TX_Terreno_Div").val(),
        'tx_lugar': ids_lugar_atencion,
        //'tx_lugar': $("#TX_Lugar_Evento_Div").val(),
        'tx_ubicacion': $("#TX_Ubicacion_Div").val(),
        'tx_indicaciones': $("#TX_Indicaciones_Div").val(),
        'tx_ninos_conf': $("#TX_Ninos_Conf").val(),
        'tx_adultos_conf': $("#TX_Adultos_Conf").val(),    
        'tx_estado_modificar': '3'
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.mostrarAlerta("success","Mensaje del sistema","Se confirmo el evento de manera correcta, en espera de la aprobación del componente de circulación!!!");
        $("#miModalConfirmar").modal('hide');
        consultarMisEventos("refresh");
        ConsultarOfertaMensual("refresh");
        limpiarFormularioConfirmar();
      },
      async: false
    });
  });

  $('#form_creacion_lugar').on('submit', function (event) {
    event.preventDefault();
    $("#miModalLugarA").modal('hide');
    $("#miModalConfirmar").modal('show');
    crearLugarAtencion();
  });

  $("#form_creacion_lugar").on("click", "#BT_Cerrar_Lugar", function(){
    $("#miModalLugarA").modal('hide');
    $("#miModalConfirmar").modal('show');
  });

  function getEntidades() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsEntidades'
    };
    $.ajax({
      url: url_ok_obj2,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    });
    return mostrar;
  }

  /*---------------Función para limpiar el formulario despues de guardar los datos-----------------------*/
  function limpiarFormulario() {
    $("#form_reservar_div")[0].reset();
    $(".selectpicker").selectpicker("val", "");
  } 

  /*---------------Función para limpiar el formulario despues de guardar los datos-----------------------*/
  function limpiarFormularioConfirmar() {
    $("#form_confirmar_evento_div")[0].reset();
    $("#form_confirmar_evento_div .selectpicker").selectpicker("val", "");
  }


  ///****************************  CREAR UN NUEVO LUGAR DE ATENCIÓN
  function crearLugarAtencion() {
    datos = {
      funcion: 'crearNuevoLugar',
      p1: {
        'pk_id_lugar': $("#TX_ID_Lugar_Atencion").val(),
        'fk_localidad': $("#SL_Localidad_Modificar").val(),
        'fk_upz': $("#SL_Upz_Modificar").val(),
        'vc_barrio': $("#TX_Barrio_Modificar").val(),
        'vc_Entidad': $("#SL_Entidad_Modificar").val(),
        'vc_tipo_lugar': 1,
        'vc_nombre_lugar': $("#TX_NombreLugar_Modificar").val(),
        'vc_direccion': $("#TX_Direccion_Modificar").val(),
        'id_usuario': parent.idUsuario,
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        var idLugarEvento = data;
        $("#TX_Lugar_Evento_Div").html(getLugarAtencion(idLugarEventoSelected)).selectpicker("refresh");  
        $("#TX_Lugar_Evento_Div").val(idLugarEvento).selectpicker("refresh");  
        $("#TX_Lugar_Evento_Div").selectpicker("refresh");  
        //parent.mostrarAlerta("success","Operación Exitosa","Lugar de Atención NIDOS creado Correctamente!!!");
        //limpiarFormulario();
      },
      async: false
    });
  }

  function getLugarAtencion(idLugarEvento) {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsLAtencion',
      'p1': idLugarEvento
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

  function SelectDisponible(Disponible) {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsEquiposDisponibles',
      'p1': Disponible
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

});

