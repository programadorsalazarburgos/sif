var url_ok_obj = '../../../src/Reportes/Controlador/ConsultaEncuentrosGrupalesController.php';
var id_dupla = "";
var id_territorio;
$(document).ready(function() {
  NombreTerritorio();

  $(".SeleccionarMes").html(getMes()).selectpicker("refresh");
  $("#SL_Mes").change(cargarDatosEncuentros);
  $("#SL_Mes_Territorio").change(cargarDatosEncuentrosTerritorio);
  $("#SL_Mes_TerritorioUpz").change(cargarDatosEncuentrosTerritorioUpz);
  $("#SL_Mes_Laboratorio").change(cargarDatosLaboratoriosTerritorio);
  $("#SL_Mes_Real_Dupla").change(cargarDatosAtencionRealTerritorio);
  $("#SL_Mes_Beneficiario").change(cargarDatosBeneficiariosAtendidos);

  $("#acordion_duplas").html(getConsultarDuplaTerritorio());

  $(".cargar_datos_dupla").click(function() {
    var id_dupla = $(this).data('id_dupla')
    consultarDatosConsolidadoDupla(id_dupla);
  });

  function cargarDatosEncuentros() {
    $("#div_Encuentros").show();
  }
  function cargarDatosEncuentrosTerritorio() {
    $("#div_Encuentros_Territorio").show();
    consultarConsolidadoFamiliar();
  }
  function cargarDatosEncuentrosTerritorioUpz() {
    $("#div_Encuentros_TerritorioUpz").show();
    consultarConsolidadoEncuentrosTotalUPZ();
  }
  function cargarDatosLaboratoriosTerritorio() {
    $("#div_Laboratorios_Territorio").show();
    ConsultarLaboratoriosTerritorio();
  }
  function cargarDatosAtencionRealTerritorio() {
    $("#div_Atencion_Real_Territorio").show();
    ConsultarAtencionRealTerritorio();
  }
  function cargarDatosBeneficiariosAtendidos() {
    $("#div_Beneficiarios_Atendidos").show();
    ConsultarBeneficiariosAtendidos();
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
/**************** TERRITORIO   *****************/
function NombreTerritorio(id_usuario) {
  datos = {
    'funcion': 'getNombreTerritorio',
    'p1': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    async: false,
    success: function(data){
      datos = $.parseJSON(data);
      $(".TX_NombreTerritorio").text(datos['Vc_Nom_Territorio']);
      id_territorio = datos['Pk_Id_Territorio'];
    },
  });
}
/**************** Datos de Dupla   *****************/
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
/*-----------------Función para consultar los grupos-----------------------*/
function consultarConsolidadoFamiliar() {
  var mostrar = "";
  var datos = {
    funcion: 'consultarConsolidadoFamiliar',
    'p1': parent.idUsuario,
    'p2': $("#SL_Mes_Territorio").val()
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
/*-----------------Función para consultar consolidado por UPZ-----------------------*/
function consultarConsolidadoEncuentrosTotalUPZ() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsolidadoGestorTerritorioUPZMes',
    'p1': $("#SL_Mes_TerritorioUpz").val(),
    'p2': id_territorio
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
      autoWidth: false,
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
/*-----------------Función para consultar consolidado TERRITORIO por LABORATORIO-----------------------*/
function ConsultarLaboratoriosTerritorio() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsolidadoGestorTerritorioLaboratoriosMes',
    'p1': $("#SL_Mes_Laboratorio").val(),
    'p2': id_territorio

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
    $("#div_table_consolidado_laboratorios").html(data);
    var table_Consolidado_Upz = $("#table_Consolidado_Laboratorios").DataTable({
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


/*-----------------Función para consultar Atención Real por DUPLA TERRITORIO-----------------------*/
function ConsultarAtencionRealTerritorio() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsolidadoAtencionRealTerritorioMes',
    'p1': $("#SL_Mes_Real_Dupla").val(),
    'p2': id_territorio

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
    $("#div_table_consolidado_atencion_dupla").html(data);
    var table_Consolidado_Atencion = $("#table_Consolidado_Atencion").DataTable({
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

/*-----------------Función para consultar Atención Real por DUPLA TERRITORIO-----------------------*/
function ConsultarBeneficiariosAtendidos() {
  var mostrar = "";
  var datos = {
    funcion: 'ConsolidadoBeneficiariosAtendidosMes',
    'p1': $("#SL_Mes_Beneficiario").val(),
    'p2': id_territorio
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
    $("#div_table_beneficiarios_atendidos").html(data);
    var table_beneficiarios_atendidos = $("#table_beneficiarios_atendidos").DataTable({
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
