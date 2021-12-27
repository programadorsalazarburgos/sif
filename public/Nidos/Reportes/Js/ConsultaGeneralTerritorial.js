var url_ok_obj = '../../../src/Reportes/Controlador/ConsultaGeneralController.php';
var id_territorio = "";
$(document).ready(function() {

  $("#acordion_territorios").html(getConsultarTerritorios());
  $(".cargar_datos_territorio").click(function() {
    var id_territorio = $(this).data('id_territorio')
    consultarDatosCompletosTerritorio(id_territorio);
  });

  function getConsultarTerritorios() {
    var mostrar = "";
    var datos = {
      funcion: 'getConsultarTerritorios'
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

  function consultarDatosCompletosTerritorio(id_territorio) {
    var datos = {
      funcion: 'consultarDatosCompletosTerritorio',
      p1: {
        'id_territorio': id_territorio
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data) {
      $("#panel_" + id_territorio).html(data);
      var nombre_territorio = $("#panel_" + id_territorio).data("nombre_territorio");
      $(".total_lugares").click(function() {
        consultarDatosDetalladosTerritorio(id_territorio, 0);
        $("#modal_informacion").modal('show');
        $(".modal-title").text("Lugares de atención del territorio de: " + nombre_territorio);
      });
      $(".total_duplas").click(function() {
        consultarDatosDetalladosTerritorio(id_territorio, 1);
        $("#modal_informacion").modal('show');
        $(".modal-title").text("Duplas de artistas del territorio de: " + nombre_territorio);
      });
      $(".total_grupos").click(function() {
        consultarDatosDetalladosTerritorio(id_territorio, 2);
        $("#modal_informacion").modal('show');
        $(".modal-title").text("Grupos del territorio de: " + nombre_territorio);
      });
      $(".total_beneficiarios").click(function() {
        consultarDatosDetalladosTerritorio(id_territorio, 3);
        $("#modal_informacion").modal('show');
        $(".modal-title").text("Beneficiarios atendidos del territorio de: " + nombre_territorio);
      });

    }).fail(function(data) {
      console.log("Error consultando los datos completos del territorio " + id_territorio);
    });

  }

  $(".modal.modal-wide .modal-dialog").css({
    "width": "90%"
  });

  function consultarDatosDetalladosTerritorio(id_territorio, tipo_consulta) {
    var datos = {
      funcion: 'consultarDatosDetalladosTerritorio',
      'p1': id_territorio,
      'p2': tipo_consulta
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        $("#div_info_detallada_territorio").html(data);
        $("#tabla_info_detallada_territorios").DataTable({
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
