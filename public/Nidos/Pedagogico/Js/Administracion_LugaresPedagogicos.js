var url_ok_obj = '../../../src/Territorial/Controlador/AdministrarLugaresController.php';  
$(function() {
  var id_usuario = $("#id_usuario").val();
  var lugar_eliminar = $("#lugarAeliminar").val();

  //Cargue Elementos Creación
  $("#SL_Localidad").html(parent.getOptionsLocalidad()).selectpicker("refresh");
  $("#SL_Localidad").html(parent.getOptionsLocalidad()).change(function() {
    $("#SL_Upz").html(parent.getOptionsUpz($("#SL_Localidad").val())).selectpicker("refresh");
  }).selectpicker("refresh");


  //Cargue Elementos COnsulta
  $("#nav_consultar_lugares").click(function() {
    $("#TX_Total").html(getTotalLugares()).selectpicker("refresh");
    getLugaresPedagogico("refresh");
  });
  $(".mayuscula").keyup(function() {
    $(this).val($(this).val().toUpperCase());
  });

  //Cargue Elementos Modificar
  $("#nav_Modificar_lugares").click(function() {

    $("#SL_Localidad_Modificar").html(parent.getOptionsLocalidad()).selectpicker("refresh");
    $("#SL_Localidad_Modificar").html(parent.getOptionsLocalidad()).change(function() {
      $("#SL_Upz_Modificar").html(parent.getOptionsUpz($("#SL_Localidad_Modificar").val())).selectpicker("refresh");
    }).selectpicker("refresh");
    $("#SL_NombreLugar_Modificar").html(getConsultarLugarM()).selectpicker("refresh");
    $("#div_modificar_lugar").hide("fast");
  });

  // modal
  $("table").delegate(".solucionar_soporte", "click", function() {
    $("#nombre").html($(this).data("nombre_lugar"));
    $("#lugarAeliminar").val($(this).data("id_lugar"));
  });

  $("#SL_NombreLugar_Modificar").change(cargarDatosLugaresCambio);

  function getConsultarLugarM() {
    var mostrar = "";
    var datos = {
      funcion: 'getConsultarLugarPedagogicosM'
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



  function getTotalLugares() {
    var mostrar = "";
    var datos = {
      funcion: 'getTotalLugaresPedagogico'
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

  function cargarDatosLugaresCambio() {
    $("#div_modificar_lugar").show();
    precargarDatosModificarLugar();
  }

  function precargarDatosModificarLugar() {
    var mostrar = "";
    datos = {
      'funcion': 'consultarDatosPedagogicoLugar',
      'p1': {
        'id_lugar': $("#SL_NombreLugar_Modificar").val()
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
      beforeSend: function() {

      }
    }).done(function(data) {
      try {
        datos = $.parseJSON(data);
        console.log(datos);

        $("#SL_Localidad_Modificar").val(datos['Fk_Id_Localidad']).selectpicker('refresh').trigger('change');
        $("#SL_Upz_Modificar").val(datos['Fk_Id_Upz']).selectpicker('refresh').trigger('change');
        $("#TX_Barrio_Modificar").val(datos['VC_Barrio']);
        $("#TX_NombreLugar_Modificar").val(datos['VC_Nombre_Lugar']);
        

      } catch (ex) {
        parent.mostrarAlerta("error","Error cargando datos para editar", "No se han podido cargar los datos del lugar de atención por error: " + ex);
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Mensaje del sistema", "No se ha podido pregargar los datos del lugar que desea modificar." + data);
      console.log(data)
    });
  }

  /*---------------Función para limpiar el formulario despues de guardar los datos-----------------------*/
  function limpiarFormulario() {
    $(".has-error").removeClass("has-error");
    $(".has-success").removeClass("has-success");
    $('.help-block').html('');
    $("#SL_Localidad").val("");
    $("#SL_Localidad").selectpicker("refresh");
    $("#SL_Upz").val("");
    $("#SL_Upz").selectpicker("refresh");
    $("#TX_Barrio").val("");
    $("#TX_NombreLugar").val("");

  }

  function getLugaresPedagogico(id_usuario) {
    var mostrar = "";
    var datos = {
      funcion: 'getLugaresPedagogicos',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data) {
      var table_lugares_pedagogico = null;
      if ($.fn.dataTable.isDataTable('#table_lugares_pedagogico')) {
        table_lugares_pedagogico = $('#table_lugares_pedagogico').DataTable().destroy();
      }
      $("#table_lugares_pedagogico tbody").html(data);
      if ($.fn.dataTable.isDataTable('#table_lugares_pedagogico')) {
        table_lugares_pedagogico = $('#table_lugares_pedagogico').DataTable();
      } else {
        table_lugares_pedagogico = $("#table_lugares_pedagogico").DataTable({
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
      table_lugares_pedagogico.draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Mensaje del sistema", "No se han podido cargar los datos de la tabla");
    });
    return mostrar;

  }
  ///****************************  CREAR UN NUEVO LUGAR DE ATENCIÓN

  function crearLugarAtencion() {
    datos = {
      funcion: 'crearNuevoLugarPedagogico',
      p1: {
        'fk_localidad': $("#SL_Localidad").val(),
        'fk_upz': $("#SL_Upz").val(),
        'vc_barrio': $("#TX_Barrio").val(),
        'vc_nombre_lugar': $("#TX_NombreLugar").val(),
        'id_usuario': parent.idUsuario,
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.mostrarAlerta("success","Operación Exitosa","Lugar de Atención pedagogico creado Correctamente!!!");
        limpiarFormulario();
      },
      async: false
    });
  }

  ///****************************  MODIFICAR LUGAR DE ATENCIÓN

  function modificarLugarAtencion() {
    datos = {
      funcion: 'modificarLugarPedagogico',
      p1: {
        'fk_id_lugar': $("#SL_NombreLugar_Modificar").val(),
        'sl_localidad_modificar': $("#SL_Localidad_Modificar").val(),
        'sl_upz_modificar': $("#SL_Upz_Modificar").val(),
        'tx_barrio_modificar': $("#TX_Barrio_Modificar").val(),
        'tx_nombre_modificar': $("#TX_NombreLugar_Modificar").val(),
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.mostrarAlerta("success","Operación Exitosa","Lugar de Atención MODIFICADO Correctamente!!!");
        $("#SL_NombreLugar_Modificar").html(getConsultarLugarM()).selectpicker("refresh");
        $("#div_modificar_lugar").hide();

      },
      async: false
    });
  }
  ///****************************  ELIMINAR LUGAR DE ATENCIÓN
  $("#form_eliminar_lugar").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var mostrar = "";
    datos = {
      funcion: 'EliminarLugar',
      p1: {
        'fk_lugar_eliminar': $("#lugarAeliminar").val(),
        'nombre_eliminar': $("#nombre").val()
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Mensaje del sistema","Lugar de Atención ELIMINADO Correctamente!!!");
        $("#TX_Total").html(getTotalLugares()).selectpicker("refresh");
        getLugares("refresh");
        $("#miModal").modal('hide');

      },
      async: false
    });
    return mostrar;
  });

///****************************  VALIDATE FORMULARIOS
  $("#form_nuevo_lugar_pedagogico").validate({
    rules: {
      SL_Localidad: {
        required: true
      },
      SL_Upz: {
        required: true
      },
      TX_Barrio: {
        required: true,
        minlength: 3,
        maxlength: 50
      },
      TX_NombreLugar: {
        required: true,
        minlength: 3,
        maxlength: 50
      }
    },
    messages: {
      SL_Localidad: {
        required: "Por favor elija una localidad"
      },
      SL_Upz: {
        required: "Por favor elija una Upz"
      },
      TX_Barrio: {
        required: "Por favor ingrese el nombre del barrio",
        minlength: "El nombre del barrio debe contener al menos tres caracteres"
      },
      TX_NombreLugar: {
        required: "Por favor ingrese el nombre del lugar",
        minlength: "El nombre del lugar debe contener al menos tres caracteres"
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
      crearLugarAtencion();
    }
  });


  $("#form_modificar_lugar").validate({
    rules: {
      SL_Localidad_Modificar: {
        required: true
      },
      SL_Upz_Modificar: {
        required: true
      },
      TX_Barrio_Modificar: {
        required: true,
        minlength: 3,
        maxlength: 50
      },
      TX_NombreLugar_Modificar: {
        required: true,
        minlength: 3,
        maxlength: 50
      }  
    },
    messages: {
      SL_Localidad_Modificar: {
        required: "Por favor elija una localidad"
      },
      SL_Upz_Modificar: {
        required: "Por favor elija una Upz"
      },
      TX_Barrio_Modificar: {
        required: "Por favor ingrese el nombre del barrio",
        minlength: "El nombre del barrio debe contener al menos tres caracteres"
      },
       TX_NombreLugar_Modificar: {
        required: "Por favor ingrese el nombre del lugar",
        minlength: "El nombre del lugar debe contener al menos tres caracteres"
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
      modificarLugarAtencion();
    }
  });
});
