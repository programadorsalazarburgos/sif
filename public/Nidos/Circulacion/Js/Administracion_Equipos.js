var url_ok_obj = '../../../src/Territorial/Controlador/AdministrarDuplasController.php';
$(function() {
  var id_usuario = $("#id_usuario").val();

  InfoNombreGestor();
  getTerritorio();
  $("#SL_Tipo_Dupla").html(getTiposDupla()).selectpicker("refresh");
  $("#SL_Artistas").html(getArtistas(0)).selectpicker("refresh");
    //Cargue Elementos Consulta
  $("#nav_consultar_duplas").click(function() {
    $("#TX_Total").html(getTotalDuplas()).selectpicker("refresh");
    getDuplasCreadas();
  });
  // Carga Elementos para MODIFICAR
  $("#nav_modificar_duplas").click(function() {
    $("#SL_NombreDupla_Modificar").html(getConsultarDuplaM()).selectpicker("refresh");
    $("#SL_Tipo_Dupla_Modificar").html(getTiposDupla()).selectpicker("refresh");
    $("#SL_NombreDupla_Modificar").change(function() {
      $("#SL_Artistas_Modificar").html(getArtistas($("#SL_NombreDupla_Modificar").val())).selectpicker("refresh");
    });
    $("#div_modificar_dupla").hide("fast");
  });

  // Modal Inactivar artista
  $("table").delegate(".Inactivar_Artista", "click", function() {
    $("#nombre").html($(this).data("nombre"));
    $("#IdArtistaInactivar").val($(this).data("id_artista"));
  });
  // Modal Activar artista
  $("table").delegate(".Activar_Artista", "click", function() {
    $("#nombreA").html($(this).data("nombre"));
    $("#IdArtistaActivar").val($(this).data("id_artista"));
  });

  $("#SL_NombreDupla_Modificar").change(cargarDatosDuplasCambio);


  /*----------------ENCABEZADO DE LA EXPERIENCIA---------------------------------------------------*/

  function InfoNombreGestor() {
    datos = {
      'funcion': 'getNombreGestor',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
      success: function(data){
        datos = $.parseJSON(data);
        $(".TX_Gestor").val(datos['GESTOR']);
        $(".TX_GestorC").text(datos['GESTOR']);
      },
    });
  }

  function getTerritorio(id_usuario) {
    datos = {
      'funcion': 'getOptionsTerritorios',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
      success: function(data){
        datos = $.parseJSON(data);
        $("#TX_IdTerritorio").val(datos['Pk_Id_Territorio']);
        $("#SL_Territorio").val(datos['Vc_Nom_Territorio']);
        $(".SL_TerritorioC").text(datos['Vc_Nom_Territorio']);
      },
    });
  }

  //******** Obtener Tipos de Dupla
  function getTiposDupla() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsDuplas'
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
  //******** Obtener Artistas
  function getArtistas(id_dupla) {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsArtistas',
      'p1': id_dupla
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
  //******** Obtener Gestor Territorial
  function getGestor() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsGestores'
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
  //******** Obtener Total de Duplas
  function getTotalDuplas(id_usuario) {
    var mostrar = "";
    var datos = {
      funcion: 'getDuplasTerritorio',
      'p1': parent.idUsuario
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
  //******** Consulta Duplas para Modificar
  function getConsultarDuplaM(id_usuario) {
    var mostrar = "";
    var datos = {
      funcion: 'getConsultarDuplaM',
      'p1': parent.idUsuario
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
  //******** Cargar Datos Duplas
  function cargarDatosDuplasCambio() {
    $("#div_modificar_dupla").show();
    precargarDatosModificarDupla();
  }
  //******** Obtiene los artistas de una Dupla
  function getArtistasDupla() {
    var mostrar = "";
    var datos = {
      funcion: 'consultarDatosArtistasDupla',
      'p1': {
        'id_dupla': $("#SL_NombreDupla_Modificar").val()
      }
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
  //******** Carga los Datos para Modificar una Dupla
  function precargarDatosModificarDupla() {
    var mostrar = "";
    datos = {
      'funcion': 'consultarDatosCompletosDupla',
      'p1': {
        'id_dupla': $("#SL_NombreDupla_Modificar").val()
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
      beforeSend: function() {}
    }).done(function(data) {
      try {
        datos = $.parseJSON(data);
        console.log(datos);

        $("#SL_Tipo_Dupla_Modificar").val(datos['Fk_Id_Tipo_Dupla']).selectpicker('refresh').trigger('change');
        $("#TX_CodigoDupla_Modificar").val(datos['VC_Codigo_Dupla']);
        $("#SL_Artista1").html(getArtistasDupla()).selectpicker("refresh");

      } catch (ex) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la dupla");
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se ha podido precargar los datos de la dupla que desea modificar");
    });
  }

  //******** Función para limpiar el formulario despues de guardar los datos
  function limpiarFormulario() {
    $(".has-error").removeClass("has-error");
    $(".has-success").removeClass("has-success");
    $('.help-block').html('');
    $("#SL_Tipo_Dupla").val("");
    $("#SL_Tipo_Dupla").selectpicker("refresh");
    $("#TX_CodigoDupla").val("");
    $("#SL_Artistas").val("");
    $("#SL_Artistas").selectpicker("refresh");

  }
  //******** Consulta Duplas Creadas
  function getDuplasCreadas(id_usuario) {
    var mostrar = "";
    var datos = {
      funcion: 'getDuplasCreadas',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data) {
      var table_duplas_nidos = null;
      if ($.fn.dataTable.isDataTable('#table_duplas_nidos')) {
        table_duplas_nidos = $('#table_duplas_nidos').DataTable().destroy();
      }
      $("#table_duplas_nidos tbody").html(data);
      if ($.fn.dataTable.isDataTable('#table_duplas_nidos')) {
        table_duplas_nidos = $('#table_duplas_nidos').DataTable();
      } else {
        table_duplas_nidos = $("#table_duplas_nidos").DataTable({
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
      }
      table_duplas_nidos.draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }
  //******** Funcion para guardar una nueva Dupla
  function crearNuevaDupla() {
    datos = {
      funcion: 'crearNuevaDupla',
      p1: {
        'fk_id_gestor': $("#SL_Territorial").val(),
        'fk_id_territorio': $("#TX_IdTerritorio").val(),
        'tipo_dupla': $("#SL_Tipo_Dupla").val(),
        'codigo_dupla': $("#TX_CodigoDupla").val(),
        'Artistas': $("#SL_Artistas").val(),
        'fk_id_EAAT': '0',
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.mostrarAlerta("success","Operación exitosa","Dupla Creada Correctamente");
        limpiarFormulario();
      },
      async: false
    });

  }

  function modificarDupla() {
    datos = {
      funcion: 'modificarDupla',
      p1: {
        'fk_id_dupla_Modificar': $("#SL_NombreDupla_Modificar").val(),
        'tipo_dupla_Modificar': $("#SL_Tipo_Dupla_Modificar").val(),
        'codigo_dupla_Modificar': $("#TX_CodigoDupla_Modificar").val(),
        'Artistas_Modificar': $("#SL_Artistas_Modificar").val(),
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.mostrarAlerta("success","Operación exitosa","Información de Dupla modificada correctamente");
        $("#SL_NombreDupla_Modificar").html(getConsultarDuplaM()).selectpicker("refresh");
        $("#div_modificar_dupla").hide();
        $("#SL_Artistas_Modificar").html(getArtistas()).selectpicker("refresh");
      },
      async: false
    });
  }
  ///****************************  INACTIVAR ARTISTA DE LA DUPLA
  $("#form_inactivar_artista").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var mostrar = "";
    datos = {
      funcion: 'InactivarArtista',
      p1: {
        'Id_Artista_Inactivar': $("#IdArtistaInactivar").val(),
        'nombre_Inactivar': $("#nombre").val()
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Operación exitosa","El artista se inactivo de la dupla Correctamente");
        $("#SL_NombreDupla_Modificar").html(getConsultarDuplaM()).selectpicker("refresh");
        $("#div_modificar_dupla").hide();
        $("#miModalInactivar").modal('hide');
      },
      async: false
    });
    return mostrar;
  });
  ///**************************** ACTIVAR ARTISTA DE LA DUPLA
  $("#form_activar_artista").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var mostrar = "";
    datos = {
      funcion: 'ActivarArtista',
      p1: {
        'Id_Artista_Activar': $("#IdArtistaActivar").val(),
        'nombre_Activar': $("#nombre").val()
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Operación exitosa","El artista se activo correctamente a la dupla");
        $("#SL_NombreDupla_Modificar").html(getConsultarDuplaM()).selectpicker("refresh");
        $("#div_modificar_dupla").hide();
        $("#miModalActivar").modal('hide');
      },
      async: false
    });
    return mostrar;
  });

  $("#form_nuevo_dupla").validate({
    rules: {
      SL_Territorio: {
        required: true
      },
      SL_Tipo_Dupla: {
        required: true
      },
      TX_CodigoDupla: {
        required: true
      },
      SL_Artistas: {
        required: true
      }
    },
    messages: {
      SL_Territorio: {
        required: "Por favor seleccione un territorio"
      },
      SL_Tipo_Dupla: {
        required: "Por favor seleccione un tipo de dupla"
      },
      TX_CodigoDupla: {
        required: "Por favor ingrese el código de la dupla"
      },
      SL_Artistas: {
        required: "Por favor seleccione los artistas comunitarios que conformarán la dupla"
      }
    },
    invalidHandler: function(event, validator) {
      return false;
    },
    errorPlacement: function(error, element) {
      $(element).closest('.form-group').find('.help-block').html(error.html());
    },
    highlight: function(element) {
      $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
      $(element).closest('.form-group').find('.help-block').html('');
    },
    submitHandler: function(form) {
      crearNuevaDupla();
    }
  });
  $("#form_modificar_dupla").validate({
    rules: {
      TX_CodigoDupla_Modificar: {
        required: true
      }
    },
    messages: {
      TX_CodigoDupla_Modificar: {
        required: "Por favor ingrese el código de la dupla"
      }
    },
    invalidHandler: function(event, validator) {
      return false;
    },
    errorPlacement: function(error, element) {
      $(element).closest('.form-group').find('.help-block').html(error.html());
    },
    highlight: function(element) {
      $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
      $(element).closest('.form-group').find('.help-block').html('');
    },
    submitHandler: function(form) {
      modificarDupla();
    }
  });
});
