var url_ok_obj = '../../../src/Territorial/Controlador/AsignarPersonaTerritorioController.php';
var idTerritorio;
$(document).ready(function() {
  $("#SL_Buscar_Usuario").html(consultarUsuarios()).selectpicker("refresh");
  $("#SL_territorios").html(consultarTerritorios()).selectpicker("refresh");
  $("#SL_Buscar_Usuario").change(cargarInformacionUsuario);
  $("#SL_Buscar_Usuario").change(cargarTerritorioUsuario);
  $('a[href="#consulta_asignacion_territorios"]').click(function() {
    $("#SL_territorios_consulta").html(consultarTerritorios()).selectpicker("refresh");
  });
  $("#BTN_consultar_territorio").on("click", function() {
    var ids = "";
    $('#SL_territorios_consulta :selected').each(function(i, selected) {
      if (ids == "") {
        ids = $(selected).val();
      } else {
        ids += "," + $(selected).val();
      }
    });
    if (ids == "") {
      parent.mostrarAlerta("warning","Error", "Por favor elija al menos un territorio.");
    } else {
      $("#SL_territorios_consulta").change(mostrarUsuariosTerritorio(ids));
    }
  });
  $("#BTN_asignar_territorio").on("click", function() {
    if ($("#SL_territorios").val() == '') {
      parent.mostrarAlerta("warning","Mensaje del sistema", "Por favor elija un territorio.");
    } else {
      $("#nombre_territorio").html($("#SL_territorios option:selected").text());
      $("#nombre_usuario").html($("#SL_Buscar_Usuario option:selected").text());
      $('#modal_asignar_territorio').modal('show');
      var datos = {
        'pk_id_person_territo': idTerritorio,
        'fk_id_persona': $("#SL_Buscar_Usuario").val(),
        'fk_id_territorio': $("#SL_territorios").val()
      }
      if ($("#BTN_asignar_territorio").val() == "Asignar") {
        delete datos.pk_id_person_territo;
        asignarTerritorio(datos);
      } else {
        actualizarTerritorio(datos);
      }
    }
  });
  /*-----------------Función para obtener todos los usuarios NIDOS-----------------------*/
  function consultarUsuarios() {
    var mostrar = "";
    var datos = {
      funcion: 'getUsuariosNidos'
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
  /*--------------------------------------------------------------------------------------*/

  /*-----------------Función para obtener toda la información del usuario seleccionado-----------------------*/
  function cargarInformacionUsuario() {
    var mostrar = "";
    var datos = {
      funcion: 'getInformacionUsusario',
      'p1': $("#SL_Buscar_Usuario").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        $("#div_informacion_usuario").show();
        var array = JSON.parse(data, function(key, value) {
          if (key == 'VC_Identificacion') {
            $("#SP_identificacion_usuario").text(value);
          }
          if (key == 'Nombre') {
            $("#SP_nombre_usuario").text(value);
          }
        });
      },
      async: false
    });
    return mostrar;

  }
  /*--------------------------------------------------------------------------------------*/

  /*-----------------Función para obtener el territorio asociado al usuario seleccionado-----------------------*/
  function cargarTerritorioUsuario() {
    var mostrar = "";
    var datos = {
      funcion: 'getTerritorioUsuario',
      'p1': $("#SL_Buscar_Usuario").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        if (data.length == '2') {
          $("#SP_territorio_actual_usuario").text("Sin territorio");
          $("#BTN_asignar_territorio").val("Asignar");

        } else {
          var array = JSON.parse(data, function(key, value) {
            if (key == 'Pk_Id_Person_Territo') {
              idTerritorio = value;
            }
            if (key == 'Vc_Nom_Territorio') {
              $("#SP_territorio_actual_usuario").text(value);
            }
          });
          $("#BTN_asignar_territorio").val("Cambiar");
        }
      },
      async: false
    });
    return mostrar;
  }
  /*--------------------------------------------------------------------------------------*/

  /*-----------------Función para obtener todos los territorios-----------------------*/
  function consultarTerritorios() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsTerritorios'
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
  /*--------------------------------------------------------------------------------------*/

  /*-----------------Función para asignar el territorio a una persona-----------------------*/
  function asignarTerritorio(datos) {
    var datos = {
      funcion: 'asignarTerritorio',
      p1: datos
    };
    $(".confirmar_asignacion_territorio").on("click", function() {
      $.ajax({
        url: url_ok_obj,
        type: 'POST',
        data: datos,
        success: function(data) {
          $('#modal_asignar_territorio').modal('hide');
          $("#div_informacion_usuario").hide();
          parent.mostrarAlerta("success","Operación exitosa", "Territorio asignado correctamente.");
          $("#SL_Buscar_Usuario").html(consultarUsuarios()).selectpicker("refresh");
          $("#SL_territorios").html(consultarTerritorios()).selectpicker("refresh");
          datos = "";
        },
        async: false
      });
    });
  }
  /*--------------------------------------------------------------------------------------*/

  /*-----------------Función para actualizar el territorio a una persona-----------------------*/
  function actualizarTerritorio(datos) {
    var datos = {
      funcion: 'actualizarTerritorio',
      p1: datos
    };
    $(".confirmar_asignacion_territorio").on("click", function() {
      $.ajax({
        url: url_ok_obj,
        type: 'POST',
        data: datos,
        success: function(data) {
          $('#modal_asignar_territorio').modal('hide');
          $("#div_informacion_usuario").hide();
          parent.mostrarAlerta("success","Operación exitosa", "Territorio actualizado correctamente.");
          $("#SL_Buscar_Usuario").html(consultarUsuarios()).selectpicker("refresh");
          $("#SL_territorios").html(consultarTerritorios()).selectpicker("refresh");
        },
        async: false
      });
    });
  }
  /*--------------------------------------------------------------------------------------*/

  /*-----------------Función para mostrar los usuarios asignados a cada territorio-----------------------*/
  function mostrarUsuariosTerritorio(ids) {
    $("#div_usuarios_territorio").show();
    tabla_usuarios_territorio.clear().draw();
    var datos = {
      funcion: 'getUsuariosTerritorio',
      'p1': ids
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        tabla_usuarios_territorio.rows.add($(data)).draw();
      },
      async: false
    });
  }
  /*--------------------------------------------------------------------------------------*/

  /*-----------------Tabla consulta de usuarios por territorio-----------------------*/
  var tabla_usuarios_territorio = $("#tabla_usuarios_territorio").DataTable({
    responsive: true,
    "language": {
      "lengthMenu": "Ver _MENU_ registros por pagina",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando pagina _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Filtrar"
    }
  });
  /*--------------------------------------------------------------------------------------*/

});
