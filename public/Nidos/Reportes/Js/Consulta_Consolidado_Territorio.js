var url_ok_obj = '../../../src/Reportes/Controlador/ConsolidadoMensualGestorController.php'; 
 
$(function(){

  $("#SL_Mes_Reporte").html(getMes()).selectpicker("refresh");

  tabla_config = {
    paging: false,
    scrollX: true,
    scrollCollapse: true,
    ordering: false,
    scrollY: "600px",
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
  }; 

  
  table_consolidado_territorio = $("#table-consolidado-territorio").DataTable(tabla_config);
  table_consolidado_entidades = $("#table-consolidado-entidades").DataTable(tabla_config);
  table_consolidado_dupla = $("#table-consolidado-dupla").DataTable(tabla_config);
  table_consolidado_lugar = $("#table-consolidado-lugar").DataTable(tabla_config);
  table_reporte_pandora = $("#table-reporte-pandora").DataTable(tabla_config);
  table_listado_beneficiario = $("#table-listado-beneficiario").DataTable(tabla_config);

  ConsultarTotalesTerritorio();
  ConsultarTotalesMensualesTerritorio();
  ConsultarTotalesMensualesEntidades();
  ConsultarTotalesDuplaTerritorio();
  ConsultarTotalesEntidadTerritorio();
  ConsultarTotalesLugarTerritorio();
  ConsultarListadoBeneficiariosTerritorio();

  $("#BT_Consultar_Pandora").click(function(){
    $("#div_Consolidado_Pandora").show();
    ConsultarPandoraTerritorio();
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


function ConsultarTotalesTerritorio() {
  datos = {
    'funcion': 'ConsultarTotalesTerritorio',
    'p1': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    async: false,
    success: function(data){
      datos = $.parseJSON(data);
      $("#LB_NombreTerritorio").text(datos['TERRITORIO']);
      $("#LB_Unicos").text(datos['UNICOS']);
      $("#LB_Meta").text(datos['META']);
      $("#LB_Atendidos").text(datos['ATENDIDOS']);
      $("#LB_Repetidos").text(datos['REPETIDOS']);
      $("#LB_UsoDatos").text(datos['USODATOS']);      
      var porcentaje =  (datos['UNICOS'] * 100 ) / datos['META'];
      var resultado = porcentaje.toFixed(2);
      $("#LB_Porcentaje").text(resultado);
    },
  });
}

function ConsultarTotalesMensualesTerritorio() {
  parent.mostrarCargando();
  table_consolidado_territorio.clear().draw();
  datos = {
    'funcion': 'ConsultarTotalesMensualesTerritorio',
    'p1': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      table_consolidado_territorio.rows.add($(data)).draw();
      parent.cerrarCargando();
    },
    async: true
  })
}

function ConsultarTotalesMensualesEntidades() {
  parent.mostrarCargando();
  table_consolidado_entidades.clear().draw();
  datos = {
    'funcion': 'ConsultarTotalesMensualesEntidades',
    'p1': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      table_consolidado_entidades.rows.add($(data)).draw();
      parent.cerrarCargando();
    },
    async: true
  })
}




function ConsultarTotalesDuplaTerritorio() {
  parent.mostrarCargando();
  table_consolidado_dupla.clear().draw();
  var datos = {
    funcion: 'ConsultarTotalesDuplaTerritorio',
    'p1': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      table_consolidado_dupla.rows.add($(data)).draw();
      parent.cerrarCargando();
    },
    async: true
  })
}

function ConsultarTotalesLugarTerritorio() {
  parent.mostrarCargando();
  table_consolidado_lugar.clear().draw();
  var datos = {
    funcion: 'ConsultarTotalesLugarTerritorio',
    'p1': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      table_consolidado_lugar.rows.add($(data)).draw();
      parent.cerrarCargando();
    },
    async: true
  })
}

function ConsultarPandoraTerritorio() {
  var $mes_consulta = $("#SL_Mes_Reporte").val();
  var $mes_anterior = $mes_consulta - 1;
  parent.mostrarCargando();
  table_reporte_pandora.clear().draw();
  var datos = {
    funcion: 'ConsultarPandoraTerritorio',
    'p1': parent.idUsuario,
    'p2': $("#SL_Mes_Reporte").val(),
    'p3': $mes_anterior,
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      table_reporte_pandora.rows.add($(data)).draw();
      parent.cerrarCargando();
    },
    async: true
  })
}

function ConsultarTotalesEntidadTerritorio() {
  datos = {
    'funcion': 'ConsultarTotalesEntidadTerritorio',
    'p1': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    async: false,
    success: function(data){
      datos = $.parseJSON(data);
      $("#LB_ICBF").text(datos['ICBF']);
      $("#LB_SDIS").text(datos['SDIS']);
      $("#LB_SED").text(datos['SED']);
      $("#LB_IDARTES").text(datos['IDARTES']);
      $("#LB_PRIVADA").text(datos['PRIVADA']);  
      $("#LB_GRC").text(datos['GRC']); 
      $("#LB_SM").text(datos['SM']);  
    },
  });
}

function ConsultarListadoBeneficiariosTerritorio() {
  parent.mostrarCargando();
  table_listado_beneficiario.clear().draw();
  var datos = {
    funcion: 'ConsultarListadoBeneficiariosTerritorio',
    'p1': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      table_listado_beneficiario.rows.add($(data)).draw();
      parent.cerrarCargando();
    },
    async: true
  })
}



});