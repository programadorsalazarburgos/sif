var url_ok_obj = '../../../src/Territorial/Controlador/AdministrarLugaresController.php';
var lugar_eliminar = $("#lugarAeliminar").val();
var id_territorio;
$(document).ready(function() {
  NombreTerritorio();
  //Cargue Elementos Creación
  $("#SL_Localidad").html(parent.getOptionsLocalidadesGestor(parent.idUsuario)).selectpicker("refresh");
  $("#SL_Localidad").html(parent.getOptionsLocalidadesGestor(parent.idUsuario)).change(function() {
    $("#SL_Upz").html(parent.getOptionsUpz($("#SL_Localidad").val())).selectpicker("refresh");
  }).selectpicker("refresh");
  $("#SL_Entidad").html(getEntidades()).selectpicker("refresh");
  $("#SL_TLugar").html(getTiposLugar()).selectpicker("refresh");
  //Cargue Elementos COnsulta
  $("#nav_consultar_lugares").click(function() {
    $("#SL_Entidad_Div").html(getEntidades()).selectpicker("refresh");
    $("#SL_TLugar_Div").html(getTiposLugar()).selectpicker("refresh");
    $("#SL_Localidad_Div").html(parent.getOptionsLocalidadesGestor(parent.idUsuario)).selectpicker("refresh");
    $("#SL_Localidad_Div").html(parent.getOptionsLocalidadesGestor(parent.idUsuario)).change(function() {
      $("#SL_Upz_Div").html(parent.getOptionsUpz($("#SL_Localidad_Div").val())).selectpicker("refresh");
    }).selectpicker("refresh");
    $("#TX_Total").html(getTotalLugares()).selectpicker("refresh");
    getLugares("refresh");
  });
  $(".mayuscula").keyup(function() {
    $(this).val($(this).val().toUpperCase());
  });

  //Cargue Elementos Modificar
  $("#nav_Modificar_lugares").click(function() {
    $("#SL_Localidad_Modificar").html(parent.getOptionsLocalidadesGestor(parent.idUsuario)).selectpicker("refresh");
    $("#SL_Localidad_Modificar").html(parent.getOptionsLocalidadesGestor(parent.idUsuario)).change(function() {
      $("#SL_Upz_Modificar").html(parent.getOptionsUpz($("#SL_Localidad_Modificar").val())).selectpicker("refresh");
    }).selectpicker("refresh");
    $("#SL_NombreLugar_Modificar").html(getConsultarLugarM()).selectpicker("refresh");
    $("#SL_Entidad_Modificar").html(getEntidades()).selectpicker("refresh");
    $("#SL_TLugar_Modificar").html(getTiposLugar()).selectpicker("refresh");
    $("#div_modificar_lugar").hide("fast");
  });

  // modal
  $("table").delegate(".solucionar_soporte", "click", function() {
    $("#nombre").html($(this).data("nombre_lugar"));
    $("#lugarAeliminar").val($(this).data("id_lugar"));
  });

  $("table").delegate(".modificar_lugar_div", "click", function() {
    $("#TX_lugar_Modificar_Div").val($(this).data("id_lugar"));
    $("#TX_Barrio_Div").val($(this).data("barrio"));
    $("#TX_NombreLugar_Div").val($(this).data("nombre_lugar"));
    $("#TX_Direccion_Div").val($(this).data("direccion"));
    $("#TX_Telefono_Div").val($(this).data("telefono"));
    $("#TX_Coordinador_Div").val($(this).data("coordinador"));
    $("#TX_EMail_Div").val($(this).data("email"));
    $("#TX_CelularRespon_Div").val($(this).data("celular"));
    $("#SL_Localidad_Div").val($(this).data("id_localidad")).selectpicker('refresh').trigger('change');
    $("#SL_Upz_Div").val($(this).data("id_upz")).selectpicker('refresh').trigger('change');
    $("#SL_Entidad_Div").val($(this).data("id_entidad")).selectpicker('refresh').trigger('change');
    $("#SL_TLugar_Div").val($(this).data("id_tipolugar")).selectpicker('refresh').trigger('change');
  });

  $("#SL_NombreLugar_Modificar").change(cargarDatosLugaresCambio);

  function getTiposLugar() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsTipoLugar'
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

function getEntidades() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsEntidades'
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

  function getTotalLugares() {
    var mostrar = "";
    var datos = {
      funcion: 'getLugaresTerritorio',
      'p1':  id_territorio
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

    function getConsultarLugarM() {
    var mostrar = "";
    var datos = {
      funcion: 'getConsultarLugarM',
      'p1': id_territorio
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
      'funcion': 'consultarDatosCompletosLugar',
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
        $("#SL_Entidad_Modificar").val(datos['Fk_Id_Entidad']).selectpicker('refresh').trigger('change');
        $("#SL_TLugar_Modificar").val(datos['VC_Tipo_Lugar']).selectpicker('refresh').trigger('change');
        $("#TX_NombreLugar_Modificar").val(datos['VC_Nombre_Lugar']);
        $("#TX_Direccion_Modificar").val(datos['VC_Direccion']);
        $("#TX_Telefono_Modificar").val(datos['VC_Telefono']);
        $("#TX_Coordinador_Modificar").val(datos['VC_Coordinador']);
        $("#TX_EMail_Modificar").val(datos['VC_Email']);
        $("#TX_CelularRespon_Modificar").val(datos['VC_Celular']);
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
    $("#SL_Entidad").val("");
    $("#SL_Entidad").selectpicker("refresh");
    $("#SL_TLugar").val("");
    $("#SL_TLugar").selectpicker("refresh");
    $("#TX_NombreLugar").val("");
    $("#TX_Direccion").val("");
    $("#TX_Telefono").val("");
    $("#TX_Coordinador").val("");
    $("#TX_EMail").val("");
    $("#TX_CelularRespon").val("");
  }

  function getLugares() {
    var mostrar = "";
    var datos = {
      funcion: 'getLugaresNidos',
      'p1': id_territorio
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data) {
      var table_lugares_nidos = null;
      if ($.fn.dataTable.isDataTable('#table_lugares_nidos')) {
        table_lugares_nidos = $('#table_lugares_nidos').DataTable().destroy();
      }
      $("#table_lugares_nidos tbody").html(data);
      if ($.fn.dataTable.isDataTable('#table_lugares_nidos')) {
        table_lugares_nidos = $('#table_lugares_nidos').DataTable();
      } else {
        table_lugares_nidos = $("#table_lugares_nidos").DataTable({
          autoWidth: false,
          responsive: true,
          pageLength: 50,
          order: [[ 5, "asc" ]],
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
      table_lugares_nidos.draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Mensaje del sistema", "No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }
  ///****************************  CREAR UN NUEVO LUGAR DE ATENCIÓN
  function crearLugarAtencion() {
    datos = {
      funcion: 'crearNuevoLugar',
      p1: {
        'fk_localidad': $("#SL_Localidad").val(),
        'fk_upz': $("#SL_Upz").val(),
        'vc_barrio': $("#TX_Barrio").val(),
        'vc_Entidad': $("#SL_Entidad").val(),
        'vc_tipo_lugar': $("#SL_TLugar").val(),
        'vc_nombre_lugar': $("#TX_NombreLugar").val(),
        'vc_direccion': $("#TX_Direccion").val(),
        'vc_telefono': $("#TX_Telefono").val(),
        'vc_coordinador': $("#TX_Coordinador").val(),
        'vc_email': $("#TX_EMail").val(),
        'vc_celular': $("#TX_CelularRespon").val(),
        'id_usuario': parent.idUsuario,
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.mostrarAlerta("success","Operación Exitosa","Lugar de Atención NIDOS creado Correctamente!!!");
        limpiarFormulario();
      },
      async: false
    });
  }

  ///****************************  MODIFICAR LUGAR DE ATENCIÓN
  function modificarLugarAtencion() {
    datos = {
      funcion: 'modificarLugar',
      p1: {
        'fk_id_lugar': $("#SL_NombreLugar_Modificar").val(),
        'sl_localidad_modificar': $("#SL_Localidad_Modificar").val(),
        'sl_upz_modificar': $("#SL_Upz_Modificar").val(),
        'tx_barrio_modificar': $("#TX_Barrio_Modificar").val(),
        'sl_entidad_modificar': $("#SL_Entidad_Modificar").val(),
        'sl_tipo_modificar': $("#SL_TLugar_Modificar").val(),
        'tx_nombre_modificar': $("#TX_NombreLugar_Modificar").val(),
        'tx_direccion_modificar': $("#TX_Direccion_Modificar").val(),
        'tx_telefono_modificar': $("#TX_Telefono_Modificar").val(),
        'tx_coordinador_modificar': $("#TX_Coordinador_Modificar").val(),
        'tx_email_modificar': $("#TX_EMail_Modificar").val(),
        'tx_celularrespon_modificar': $("#TX_CelularRespon_Modificar").val(),
        'tx_estado_modificar': '1'
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
        parent.mostrarAlerta("success","Mensaje del sistema","Lugar de Atención INACTIVO Correctamente!!!");
        $("#TX_Total").html(getTotalLugares()).selectpicker("refresh");
        getLugares("refresh");
        $("#miModal").modal('hide');
      },
      async: false
    });
    return mostrar;
  });

  $("#form_modificar_lugar_div").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var mostrar = "";
    datos = {
      funcion: 'modificarLugar',
      p1: {
            'fk_id_lugar': $("#TX_lugar_Modificar_Div").val(),
            'sl_localidad_modificar': $("#SL_Localidad_Div").val(),
            'sl_upz_modificar': $("#SL_Upz_Div").val(),
            'tx_barrio_modificar': $("#TX_Barrio_Div").val(),
            'sl_entidad_modificar': $("#SL_Entidad_Div").val(),
            'sl_tipo_modificar': $("#SL_TLugar_Div").val(),
            'tx_nombre_modificar': $("#TX_NombreLugar_Div").val(),
            'tx_direccion_modificar': $("#TX_Direccion_Div").val(),
            'tx_telefono_modificar': $("#TX_Telefono_Div").val(),
            'tx_coordinador_modificar': $("#TX_Coordinador_Div").val(),
            'tx_email_modificar': $("#TX_EMail_Div").val(),
            'tx_celularrespon_modificar': $("#TX_CelularRespon_Div").val(),
            'tx_estado_modificar': '1'
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Mensaje del sistema","Lugar de atención actualizado y ACTIVADO correctamente!!!");
        $("#TX_Total").html(getTotalLugares()).selectpicker("refresh");
        getLugares("refresh");
        $("#miModalActivacion").modal('hide');
      },
      async: false
    });
    return mostrar;
  });

  $("#form_nuevo_lugar_nidos").validate({
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
      SL_Entidad: {
        required: true
      },
      SL_TLugar: {
        required: true
      },
      TX_NombreLugar: {
        required: true,
        minlength: 3,
        maxlength: 200
      },
      TX_Direccion: {
        required: true,
        minlength: 10,
        maxlength: 70
      },
      TX_Telefono: {
        required: true,
        digits: true,
        minlength: 7,
        maxlength: 10
      },
      TX_Coordinador: {
        required: true,
        minlength: 3,
        maxlength: 50
      },
      TX_EMail: {
        required: true,
        email: true
      },
      TX_CelularRespon: {
        required: true,
        digits: true,
        minlength: 7,
        maxlength: 10
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
      SL_Entidad: {
        required: "Por favor elija una entidad"
      },
      SL_TLugar: {
        required: "Por favor elija el tipo de lugar"
      },
      TX_NombreLugar: {
        required: "Por favor ingrese el nombre del lugar",
        minlength: "El nombre del lugar debe contener al menos tres caracteres"
      },
      TX_Direccion: {
        required: "Por favor ingrse la dirección del lugar",
        minlength: "La dirección del lugar debe contener al menos diez caracteres"
      },
      TX_Telefono: {
        required: "Por favor ingrese el teléfono del lugar",
        minlength: "El número de teléfono debe contener al menos siete caracteres",
        maxlength: "El número de teléfono no puede contener mas de diez caracteres",
        digits: "El número de teléfono no puede contener letras"
      },
      TX_Coordinador: {
        required: "Por favor ingrese el nombre del Coordinador(a) o Maestro(a) Responsable",
        minlength: "El nombre del Coordinador(a) o Maestro(a) Responsable debe contener al menos tres caracteres"
      },
      TX_EMail: {
        required: "Por favor ingrese el email del Coordinador(a) o Maestro(a) Responsable",
        email: "Por favor ingrese un email valido"
      },
      TX_CelularRespon: {
        required: "Por favor ingrese el email del Coordinador(a) o Maestro(a) Responsable",
        minlength: "El número celular del Coordinador(a) o Maestro(a) Responsable debe contener al menos siete caracteres",
        maxlength: "El número celular  del Coordinador(a) o Maestro(a) Responsable no puede contener mas de diez caracteres",
        digits: "l número celular  del Coordinador(a) o Maestro(a) Responsable no puede contener letras"
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
      SL_Entidad_Modificar: {
        required: true
      },
      SL_TLugar_Modificar: {
        required: true
      },
      TX_NombreLugar_Modificar: {
        required: true,
        minlength: 3,
        maxlength: 200
      },
      TX_Direccion_Modificar: {
        required: true,
        minlength: 10,
        maxlength: 70
      },
      TX_Telefono_Modificar: {
        required: true,
        digits: true,
        minlength: 7,
        maxlength: 10
      },
      TX_Coordinador_Modificar: {
        required: true,
        minlength: 3,
        maxlength: 50
      },
      TX_EMail_Modificar: {
        required: true,
        email: true
      },
      TX_CelularRespon_Modificar: {
        required: true,
        digits: true,
        minlength: 7,
        maxlength: 10
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
      SL_Entidad_Modificar: {
        required: "Por favor elija una entidad"
      },
      SL_TLugar_Modificar: {
        required: "Por favor elija el tipo de lugar"
      },
      TX_NombreLugar_Modificar: {
        required: "Por favor ingrese el nombre del lugar",
        minlength: "El nombre del lugar debe contener al menos tres caracteres"
      },
      TX_Direccion_Modificar: {
        required: "Por favor ingrse la dirección del lugar",
        minlength: "La dirección del lugar debe contener al menos diez caracteres"
      },
      TX_Telefono_Modificar: {
        required: "Por favor ingrese el teléfono del lugar",
        minlength: "El número de teléfono debe contener al menos siete caracteres",
        maxlength: "El número de teléfono no puede contener mas de diez caracteres",
        digits: "El número de teléfono no puede contener letras"
      },
      TX_Coordinador_Modificar: {
        required: "Por favor ingrese el nombre del Coordinador(a) o Maestro(a) Responsable",
        minlength: "El nombre del Coordinador(a) o Maestro(a) Responsable debe contener al menos tres caracteres"
      },
      TX_EMail_Modificar: {
        required: "Por favor ingrese el email del Coordinador(a) o Maestro(a) Responsable",
        email: "Por favor ingrese un email valido"
      },
      TX_CelularRespon_Modificar: {
        required: "Por favor ingrese el email del Coordinador(a) o Maestro(a) Responsable",
        minlength: "El número celular del Coordinador(a) o Maestro(a) Responsable debe contener al menos siete caracteres",
        maxlength: "El número celular  del Coordinador(a) o Maestro(a) Responsable no puede contener mas de diez caracteres",
        digits: "l número celular  del Coordinador(a) o Maestro(a) Responsable no puede contener letras"
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
