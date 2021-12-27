var url_ok_obj = '../../../src/Reportes/Controlador/ConsultaGeneralController.php';
var url_ok_obj1 = '../../../src/Reportes/Controlador/ConsolidadoMensualGestorController.php';  

$(function(){
$("#SL_Mes_Cifras").html(getMes()).selectpicker("refresh");


function getMes() {
  var mostrar = "";
  var datos = {
    funcion: 'getOptionsMes'
  };
  $.ajax({
    url: url_ok_obj1,
    type: 'POST',
    data: datos,
    success: function(data) {
      mostrar += data
    },
    async: false
  });
  return mostrar;
}




  var table_reporte_pandora = $("#table-reporte-pandora").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    aaSorting: [],
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

  $("#BT_Pandora").click(function(){
    console.log("rtuuhhihiyhuoiuby");
    $("#div-reporte-evento").show();
   getReportePandoraTerritorial();
  });

/////////////////////////////////////

function getReportePandoraTerritorial() {
  console.log("asuidhsdiansiu");
  parent.mostrarCargando();
  table_reporte_pandora.clear().draw();
  var datos = {
    funcion: 'getReportePandoraTerritorial',
    'p1': $("#SL_Mes_Cifras").val()
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


});