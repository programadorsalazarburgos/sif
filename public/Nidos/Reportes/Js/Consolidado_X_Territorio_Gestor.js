var url_ok_obj = '../../../src/Reportes/Controlador/ConsolidadoTerritorioGestorController.php';
var id_dupla = "";
$(document).ready(function() {

  $("#acordion_duplas").html(getConsultarDuplaTerritorio());
  $(".cargar_datos_dupla").click(function() {
    var id_dupla = $(this).data('id_dupla')
    consultarDatosConsolidadoDupla(id_dupla);
  });

  function getConsultarDuplaTerritorio() {
    var mostrar = "";
    var datos = {
      funcion: 'ConsultarDuplasTerritorio',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        $("#panel_" + id_dupla).html(data);
        mostrar += data;
      },
      async: false
    });
    return mostrar;

  }

  function consultarDatosConsolidadoDupla(id_dupla) {
    var datos = {
      funcion: 'consultarDatosTerritorioGestor',
      p1: {
        'id_dupla': id_dupla
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        $("#div_info_detallada_dupla_"+id_dupla).html(data);
        $("#table_grupos_dupla_"+id_dupla).DataTable({
          autoWidth: false,
          responsive: true,
          dom: 'Blfrtip',
          buttons: [{
            extend: 'excel',
            text: 'Descargar datos',
            filename: 'Datos terrritorio'
          }],
          "language": {
            "lengthMenu": "Ver _MENU_ registros por pagina",
            "zeroRecords": "No hay información, lo sentimos.",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Filtrar",
            "paginate": {
              "first": "Primera",
              "last": "Ultima",
              "next": "Siguiente",
              "previous": "Anterior"
            },
          }
        });
      },
      async: false
    })
  }


});
