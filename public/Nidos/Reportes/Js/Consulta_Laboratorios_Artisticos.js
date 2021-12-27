var url_ok_obj = '../../../src/Reportes/Controlador/LaboratoriosArtisticosController.php'; 
var id_dupla = "";
$(document).ready(function() {

  $(".SeleccionarMes").html(getMes()).selectpicker("refresh");



  $("#BT_Consultar_Laboratorios_Mes").click(function(){
    $("#div_Laboratorios_Intervenciones").show();
    consultarConsolidadoLaboratoriosMes();
  });

  $("#BT_Consultar_Grupos_Comunidad").click(function(){
    $("#div_Grupos_Comunidad").show();
    consultarGruposComunidadMes();
  });

  BT_Consultar_Laboratorios_Mes


//******* Consulta Duplas para Modificar
function getMes() {
  var mostrar = "";
  var datos = {
    funcion: 'getMesParametro'
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

/*-----------------Función para consultar los grupos-----------------------*/
function consultarConsolidadoLaboratoriosMes() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsolidadoTotalLaboratoriosMes',
      'p1': $("#SL_Mes_Atenciones").val(),
      'p2': $("#SL_Tipo_Laboratorio").val()
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
    $("#div_table_Consolidado_Laboratorios").html(data);
    var table_Consolidado_Laboratorios = $("#table_Consolidado_Laboratorios").DataTable({
      autoWidth: false,
      responsive: true,
      pageLength: 100,
      ordering: false,
      paging: false,
      info: false,
      dom: 'Bfrtip',
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
  }).fail(function(data) {
    parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
  });
  return mostrar;
}

/*-----------------Función para consultar los grupos-----------------------*/
function consultarGruposComunidadMes() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsolidadoGruposComunidadMes',
      'p1': $("#SL_Mes_Comunidad").val(),
      'p2': $("#SL_Tipo_Comunidad").val()
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
    $("#div_table_Grupos_Comunidad").html(data);
    var table_Consolidado_Grupos_Comunidad = $("#table_Consolidado_Grupos_Comunidad").DataTable({
      autoWidth: false,
      responsive: true,
      pageLength: 100,
      ordering: false,
      paging: false,
      info: false,
      dom: 'Bfrtip',
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
  }).fail(function(data) {
    parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
  });
  return mostrar;
}

});
