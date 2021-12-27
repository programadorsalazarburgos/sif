var url_ok_obj = '../../../src/Reportes/Controlador/EncuentrosGrupalestotalController.php';
var id_dupla = "";
$(document).ready(function() {

  $(".SeleccionarMes").html(getMes()).selectpicker("refresh");
  $("#SL_Territorio").html(getTerritorios()).selectpicker("refresh");
  $("#SL_Mes").change(cargarDatosEncuentros);
  $("#SL_Mes_Territorio").change(cargarDatosEncuentrosTerritorio);
  $("#SL_Mes_Laboratorios").change(cargarDatosLaboratoriosMes);
  $("#SL_Mes_Meta").change(cargarDatosMetas);

  function cargarDatosEncuentros() {
    $("#div_Encuentros").show();
    consultarConsolidadoTotalEncuentrosL_A();
  }

  function cargarDatosEncuentrosTerritorio() {
    $("#div_Encuentros_Territorio").show();
    consultarConsolidadoEncuentrosTotalUPZ();
  }
  $("#BT_Consultar_Atenciones_Territorio").click(function(){
    $("#div_Atenciones_Territorio").show();
    consultarConsolidadoTerritorio();
  });
  function cargarDatosLaboratoriosMes() {
    $("#div_Laboratorios_Intervenciones").show();
    consultarConsolidadoLaboratoriosMes();
  }
  function cargarDatosMetas() {
    $("#div_Metas_Primera_Infancia").show();
    consultarMetasEncuentros();
  }

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
//******* Consulta Territorios
function getTerritorios() {
  var mostrar = "";
  var datos = {
    funcion: 'getOptionsTerritorio'
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

function getConsultarDuplaTerritorio() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsultarDuplasTerritoriales',
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
    funcion: 'consultarInfoDuplaEncuentros',
    p1: {
      'id_dupla': id_dupla
    },
      'p2': $("#SL_Mes").val()
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
function consultarConsolidadoTotalEncuentrosL_A() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsolidadoTotalEncuentrosgGrupalesL_A',
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
    $("#div_table_Consolidado_Familiar").html(data);
    var table_Consolidado_Familiar = $("#table_Consolidado_Familiar").DataTable({
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
    var table_Consolidado_Institucional = $("#table_Consolidado_Institucional").DataTable({
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
    var total_encuentros_grupales = $("#total_encuentros_grupales").DataTable({
      autoWidth: false,
      responsive: true,
      pageLength: 100,
      ordering: false,
      paging: false,
      info: false,
      dom: 'Bfrtip',
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
function consultarConsolidadoEncuentrosTotalUPZ() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsolidadoTotalEncuentrosGrupalesUPZ',
    'p1': $("#SL_Mes_Territorio").val()
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
    $("#div_table_Consolidado_Upz").html(data);
    var table_Consolidado_Upz = $("#table_Consolidado_Upz").DataTable({
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
function consultarConsolidadoLaboratoriosMes() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsolidadoTotalLaboratoriosMes',
    'p1': $("#SL_Mes_Laboratorios").val()
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
/*-----------------Función para consultar las atenciones del territorio por mes-----------------------*/
function consultarConsolidadoTerritorio() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsultaAtencionesTerritorioCoordinador',
    'p1': $("#SL_Territorio").val(),
    'p2': $("#SL_Mes_Atenciones").val()
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
    $("#div_table_Atenciones_Territorio").html(data);
    var table_Atenciones_Familiar = $("#table_Atenciones_Familiar").DataTable({
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
    var table_Atenciones_Institucional = $("#table_Atenciones_Institucional").DataTable({
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
    var total_Atenciones_territorio = $("#total_Atenciones_territorio").DataTable({
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
function consultarMetasEncuentros() {
  var mostrar = "";
  var datos = {
    funcion: 'MetasEncuentrosArtisticos',
    'p1': $("#SL_Mes_Meta").val()
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
    $("#div_Metas_Primera_Infancia").html(data);
    var table_Metas_Primera_Infancia = $("#table_Metas_Primera_Infancia").DataTable({
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
