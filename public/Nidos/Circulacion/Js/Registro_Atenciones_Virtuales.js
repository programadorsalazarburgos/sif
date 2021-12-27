var url_ok_obj = '../../../src/CirculacionNidos/Controlador/AtencionesVirtualesController.php';
var url_ben = '../../../src/Beneficiarios/Controlador/RegistroBeneficiariosController.php';
var numero_documento_beneficiario;

$(document).ready(function() {

  $(".modal.modal-wide .modal-dialog").css({
    "width": "90%"
  });

  $(".mayuscula").keyup(function() {
    $(this).val($(this).val().toUpperCase());
  });

  var tabla_atenciones_asignadas = $("#tabla_atenciones_asignadas").DataTable({
    paging: false,
    /*scrollX: true,
    scrollCollapse: true,
    fixedColumns:{
      leftColumns: 3,
    },
    scrollY: "300px",*/
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

  $("#SL_Mes").html(getMes()).selectpicker("refresh");

  $("#form-consultar-atenciones-virtuales-aignadas").on("submit", function(e){
    e.preventDefault();
    cargarAtencionesAsignadas();    
  });

  $("#sl-tipo-doc-cuidador-editar").html(getTipoDocumento()).selectpicker("refresh");
  $("#sl-tipo-doc-beneficiario-editar").html(getTipoDocumento()).selectpicker("refresh");
  $("#sl-enfoque-beneficiario-editar").html(getEtnia()).selectpicker("refresh");

  $('a[href="#articulacion-arn"]').click(function() {
    getBeneficiariosArticulacionArn();
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

  function getEtnia() {
    var mostrar = "";
    var datos = {
      funcion: 'getEtnia'
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


  $("table").delegate(".cancelar_evento", "click", function() {
    $("#TX_ID_Evento_Cancelar").val($(this).data("id-evento"));
    $("#LB_EventoCa").html($(this).data("evento"));
    $("#LB_Dia").html($(this).data("dia"));
    $("#LB_Fecha").html($(this).data("fecha"));
  });

  /*---------------ASIGNACIÓN DE ARTISTAS-----------------------------------------------*/

  function cargarAtencionesAsignadas() {
    $("#div_atenciones_asignadas").show();
    consultarAtencionesAsignadas();
  }

  function consultarAtencionesAsignadas() {

    tabla_atenciones_asignadas.clear().draw();
    var datos = {
      funcion: 'consultarAtencionesAsignadas',
      'p1': $("#SL_Mes").val(),
      'p2': parent.idUsuario,
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        tabla_atenciones_asignadas.rows.add($(data)).draw();
        $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .responsive.recalc();
      },
      error: function(data){
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
      },
      async: false
    });
  }

  $("table").on("click", ".registrollamada", function() {
    var idFranja = $(this).data("id-registro");
    numero_documento_beneficiario = $(this).data("numero-documento-beneficiario");
    id_asignacion = $(this).data("id-asignacion");
    formulario = $(this).data("formulario");
    $("#TX_ID_Franja_Artista").val($(this).data("id-registro"));
    $(this).data("dirigida") != "MUJER GESTANTE" ? $("#modal-title").html("").html("REGISTRO DE LLAMADA - "+$(this).data("nombre-beneficiario")) : $("#modal-title").html("").html("REGISTRO DE LLAMADA - "+$(this).data("nombre-cuidador"));

    $("#fecha-formulario-sin-horario").val($(this).attr("data-fecha-llamada-sin-horario"));
    
    $("#formulario-sin-horario").hide();
    $("#fecha-formulario-sin-horario").attr("required", false);

    if($(this).data("formulario") == "Arn" || $(this).data("formulario") == "Aulas hospitalarias"){
      $("#formulario-sin-horario").show();
      $("#fecha-formulario-sin-horario").attr("required", true);
    }
  });

  $("#SL_Llamada_Realizada").on("change", function(){
    if($(this).val() == 1){
     $("#div_modal_llamadaSI").show();
     $("#div_modal_llamadaNO").show();
     $("#TX_Observaciones").attr("required", false);
     $('#div_modal_llamadaSI :text').attr("required", true)
   }
   if($(this).val() == 2){
     $("#div_modal_llamadaSI").hide();
     $("#div_modal_llamadaNO").show();
     $("#TX_Observaciones").attr("required", true);
     $('#div_modal_llamadaSI :text').attr("required", false)
   }
 });

  $("#form_Registro_Llamada_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var mostrar = "";
    datos = {
      funcion: 'RegistroLlamadasArtistas',
      p1: {
        'tx_id_franja': $("#TX_ID_Franja_Artista").val(),
        'id_asignacion':id_asignacion,
        'fecha_llamada': $("#fecha-formulario-sin-horario").val(),
        'quien_llamo': parent.idUsuario,
        'sl_llamada': $("#SL_Llamada_Realizada").val(),
        'tx_duracion': $("#TX_Duracion_Llamada").val(),
        'tx_material': $("#TX_Material").val(),
        'tx_lectura': $("#TX_Lectura").val(),
        'tx_reacciono': $("#TX_Reacciono").val(),
        'tx_observaciones': $("#TX_Observaciones").val(),
        'numero_documento_beneficiario': numero_documento_beneficiario,
        'formulario': formulario
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Mensaje del sistema","Se registro correctamente la información de la llamada telefónica !!!");
        $("#SL_Llamada_Realizada").val("");
        $("#SL_Llamada_Realizada").selectpicker("refresh");
        $("#TX_Duracion_Llamada").val("");
        $("#TX_Material").val("");
        $("#TX_Lectura").val("");
        $("#TX_Reacciono").val("");
        $("#TX_Observaciones").val("");
        $("#miModalRegistroLlamada").modal('hide');
        consultarAtencionesAsignadas();
        $("#div_modal_llamadaSI").hide();
        $("#div_modal_llamadaNO").hide();
      },
      async: false
    });
    return mostrar;
  });  

  $("table").delegate(".consultallamada", "click", function() {
    var idFranja = $(this).data("id-registro");
    $("#TX_ID_Franja_Artista").val($(this).data("id-registro"));
    $("#NombreConsulta").html($(this).data("nombre"));
    $("#ApellidoConsulta").html($(this).data("apellido"));
    $("#Duracion").html($(this).data("duracion"));
    $("#Material").html($(this).data("material"));
    $("#Parecido").html($(this).data("parecido"));
    $("#Reacciono").html($(this).data("reacciono"));
    $("#Observaciones").html($(this).data("observaciones"));
  });


  $("table").on("click", ".editarllamada", function() {
    //var idregistro = $(this).data("id-registro");

    $(this).data("dirigida") != "MUJER GESTANTE" ? $("#div-dirigido-ninos").show() : $("#div-dirigido-ninos").hide();
    
    $("#tx-id-llamada").val($(this).data("id-registro"));
    $("#tx-dirigida-editar").html("").html($(this).data("dirigida"));
    $("#sl-tipo-doc-cuidador-editar").selectpicker("val", $(this).data("tipo-doc-cuidador"));
    $("#tx-documento-cuidador-editar").val($(this).data("documento-cuidador"));
    $("#tx-nombre-cuidador-editar").val($(this).data("nombre-cuidador"));
    $("#tx-correo-cuidador-editar").val($(this).data("correo-cuidador"));
    $("#sl-localidad-cuidador-editar").selectpicker("val", $(this).data("localidad-cuidador"));
    $("#tx-barrio-cuidador-editar").val($(this).data("barrio-cuidador"));
    $("#tx-direccion-cuidador-editar").val($(this).data("direccion-cuidador"));
    $("#sl-estrato-cuidador-editar").selectpicker("val", $(this).data("estrato-cuidador"));
    $("#tx-edad-cuidador-editar").val($(this).data("edad-cuidador"));

    $("#tx-potestad-editar").html("").html($(this).data("potestad"));
    $("#tx-parentesco-editar").selectpicker("val", $(this).data("id-parentesco"));
    $("#tx-nombres-beneficiario-editar").val($(this).data("nombres-beneficiario"));
    $("#tx-apellidos-beneficiario-editar").val($(this).data("apellidos-beneficiario"));
    $("#sl-enfoque-beneficiario-editar").selectpicker("val", $(this).data("enfoque-beneficiario"));


    if($(this).data("potestad") == "SI"){
      $("#div-check-si").show();
      $("#div-check-no").hide();
      $("#Informacion_potestaSi").show();
      $("#tx-fecha-nacimiento-beneficiario-editar").val($(this).data("fecha-nacimiento-beneficiario"));
      $("#sl-tipo-doc-beneficiario-editar").selectpicker("val", $(this).data("tipo-doc-beneficiario"));
      $("#tx-numero-doc-beneficiario-editar").val($(this).data("numero-doc-beneficiario"));
      $("#sl-tipo-doc-beneficiario-editar").attr("required", true);
      $("#tx-numero-doc-beneficiario-editar").attr("required", true);
      $("#tx-fecha-nacimiento-beneficiario-editar").attr("required", true);
      $("#sl-edad-beneficiario-editar").attr("required", false);
    }else{
      $("#div-check-si").hide();
      $("#div-check-no").show();
      $("#Informacion_potestaSi").hide();
      $("#sl-edad-beneficiario-editar").selectpicker("val", $(this).data("edad-beneficiario"));
      $("#sl-tipo-doc-beneficiario-editar").attr("required", false);
      $("#tx-numero-doc-beneficiario-editar").attr("required", false);
      $("#tx-fecha-nacimiento-beneficiario-editar").attr("required", false);
      $("#sl-edad-beneficiario-editar").attr("required", true);
    }

    // $("#p-fecha-llamada").html("").html($(this).data("fecha-llamada"));
    // $("#p-inicio-llamada").html("").html($(this).data("inicio-llamada"));
    // $("#p-fin-llamada").html("").html($(this).data("fin-llamada"));
    // $("#p-telefono-llamada").html("").html($(this).data("telefono-llamada"));

  });

  $("table").on("click", ".ver-llamada", function() {
    $("#s-nombre-beneficiario-consulta").html("").html($(this).data("nombres-beneficiario"));
    $("#s-apellido-beneficiario-consulta").html("").html($(this).data("apellidos-beneficiario"));
    $("#div-consulta-llamada-no-realizada").show();

    $("#p-duracion").html("").html($(this).data("duracion"));
    $("#p-material").html("").html($(this).data("material"));
    $("#p-parecio").html("").html($(this).data("parecio"));
    $("#p-reaccion").html("").html($(this).data("reaccion"));
    $("#p-observaciones").html("").html($(this).data("observaciones"));

    $(this).data("estado") == 1 ? $("#div-consulta-llamada-realizada").show() : $("#div-consulta-llamada-realizada").hide();

    $("#miModalConsultarLlamada").modal("show");
  });

  $("#form_editar_llamado_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();

    // var idsLineaEditar = "";
    // $('#TX_Lineatencion_Editar :selected').each(function(i, selected) {
    //   if (idsLineaEditar == "") {
    //     idsLineaEditar = $(selected).val() + ",";
    //   }else{
    //     idsLineaEditar += $(selected).val() + ",";
    //   }
    // });

    datos = {
      funcion: 'EditarInformacionLlamada',
      p1: {
        "tx-id-llamada": $("#tx-id-llamada").val(),
        "sl-tipo-doc-cuidador-editar": $("#sl-tipo-doc-cuidador-editar").val(),
        "tx-documento-cuidador-editar": $("#tx-documento-cuidador-editar").val(),
        "tx-nombre-cuidador-editar": $("#tx-nombre-cuidador-editar").val(),
        "tx-correo-cuidador-editar": $("#tx-correo-cuidador-editar").val(),
        "sl-localidad-cuidador-editar": $("#sl-localidad-cuidador-editar").val(),
        "tx-barrio-cuidador-editar": $("#tx-barrio-cuidador-editar").val(),
        "tx-direccion-cuidador-editar": $("#tx-direccion-cuidador-editar").val(),
        "sl-estrato-cuidador-editar": $("#sl-estrato-cuidador-editar").val(),
        "tx-edad-cuidador-editar": $("#tx-edad-cuidador-editar").val(),
        "tx-parentesco-editar": $("#tx-parentesco-editar").val(),
        "tx-nombres-beneficiario-editar": $("#tx-nombres-beneficiario-editar").val(),
        "tx-apellidos-beneficiario-editar": $("#tx-apellidos-beneficiario-editar").val(),
        "sl-enfoque-beneficiario-editar": $("#sl-enfoque-beneficiario-editar").val(),
        "tx-fecha-nacimiento-beneficiario-editar": $("#tx-fecha-nacimiento-beneficiario-editar").val(),
        "sl-tipo-doc-beneficiario-editar": $("#sl-tipo-doc-beneficiario-editar").val(),
        "tx-numero-doc-beneficiario-editar": $("#tx-numero-doc-beneficiario-editar").val(),
        "sl-edad-beneficiario-editar": $("#sl-edad-beneficiario-editar").val(), 
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.swal("Éxito", "Se ha actualizado la información de la llamada correctamente", "success");
        $("#miModalEditarLlamada").modal('hide');
        consultarAtencionesAsignadas();
      },
      error: function(data){
        parent.swal("Error", "No se pudo actualizar la información de la llamada, por favor vuelva a intentarlo", "error");
      },
      async: false
    });
  });
});