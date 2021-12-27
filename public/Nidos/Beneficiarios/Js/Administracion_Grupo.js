var url_ok_obj = '../../../src/Beneficiarios/Controlador/AdministrarGruposController.php';
var url_ok_obj1 = '../../../src/Territorial/Controlador/AdministrarLugaresController.php';
var idDupla;  
$(document).ready(function() {

  ConsultarTotalesGruposDupla();

  var table_grupos_nidos = $("#table_grupos_nidos").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
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
  consultarGrupos();

  var table_consolidado_dupla = $("#table_consolidado_dupla").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
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

  $('a[href="#consolidado_grupos"]').click(function() {
    consolidadoAtencionesDupla();
  });
  

  $("#SL_Tipo_Grupo").html(parent.getOptionsParametroDetalle(45)).selectpicker("refresh");
  $("#SL_nivel_escolaridad").html(parent.getOptionsParametroDetalle(58)).selectpicker("refresh");
  $("#SL_EAtencion").html(getTipoEstrategia()).selectpicker("refresh");
  $("#SL_LAtencion").html(getLugaresAtencion()).selectpicker("refresh");
  $("#SL_Lugar_Grupo").html(getLugaresAtencion()).selectpicker("refresh"); 

  $("#SL_Tipo_Grupo_Modificar").html(parent.getOptionsParametroDetalle(45)).selectpicker("refresh");
  $("#SL_nivel_escolaridad_Modificar").html(parent.getOptionsParametroDetalle(58)).selectpicker("refresh");
  $("#SL_EAtencion_Modificar").html(getTipoEstrategia()).selectpicker("refresh");
  $("#SL_LAtencion_Modificar").html(getLugaresAtencion()).selectpicker("refresh");
  $("#SL_Lugar_Grupo_Modificar").html(getLugaresAtencion()).selectpicker("refresh");

  $(".registrar-grupo").click(function() {   
    guardarFormularioCreacion();
  });

  $(".modificar-grupo").click(function() {
    guardarFormularioModificacion();
  });


  function ConsultarTotalesGruposDupla() {
    datos = {
      'funcion': 'ConsultarTotalesGruposDupla',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
      success: function(data){
        datos = $.parseJSON(data);
        $("#LB_Grupos").text(datos['TOTAL']);
        $("#LB_Grupales").text(datos['GRUPALES']);
        $("#LB_Bene_Grupales").text(datos['BENEFICIARIOSGRUPALES']);
        $("#LB_Laboratorios").text(datos['LABORATORIOS']);
        $("#LB_Bene_Laboratorios").text(datos['BENEFICIARIOSLABORATORIOS']);

      },
    });
  }



  getIdCodigoDupla();

  function getIdCodigoDupla() {
    var mostrar = "";
    var datos = {
      funcion: 'getIdCodigoDupla',
      'p1': parent.idUsuario
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
    var array = JSON.parse(mostrar, function(key, value) {
      if (key == 'Fk_Id_Dupla') {
        idDupla = value;
      }
      if (key == 'VC_Codigo_Dupla') {
        $(".SP_codigo_dupla").text(value);
      }
    });
    return mostrar;
  }




  function consultarGrupos() {
    var mostrar = "";
    table_grupos_nidos.clear().draw();
    var datos = {
      funcion: 'consultarGrupos',
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
    }).done(function(data) {
      table_grupos_nidos.rows.add($(data)).draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }

  function getTipoEstrategia() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsEstrategias'
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

  function getLugaresAtencion() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsLugares',
      'p1': parent.idUsuario
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



  function guardarFormularioCreacion() {
    var idsNiveles = "";
    
    $('#SL_nivel_escolaridad :selected').each(function(i, selected) {
      if (idsNiveles == "") {
       idsNiveles = $(selected).val() + ",";
     }else{
       idsNiveles += $(selected).val() + ",";
     }
   });
    datos = {
      funcion: 'crearNuevoGrupo',
      p1: {
        'fk_id_estrategia_atencion': $("#SL_EAtencion").val(),
        'fk_id_lugar_atencion': $("#SL_LAtencion").val(),
        'vc_nombre_grupo': $("#TX_Nombre_Grupo").val(),
        'fk_id_dupla': idDupla,
        'fk_nivel_escolaridad': idsNiveles,
        'vc_profesional': $("#TX_Nombre_Responsable").val(),
        'tipo_grupo': $("#SL_Tipo_Grupo").val(),
        'lugar_grupo': $("#SL_Lugar_Grupo").val(),
        'fk_id_usuario_creacion': parent.idUsuario
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
      success: function(data) {
        parent.mostrarAlerta("success","Operación exitosa","Grupo creado correctamente");
        $('#modal-nuevo-grupo').modal('hide');
        consultarGrupos();
        limpiarFormulario();       
        
      }
    });
  } 

  function limpiarFormulario() {
    $(".has-error").removeClass("has-error");
    $(".has-success").removeClass("has-success");
    $('.help-block').html('');
    $("#TX_Nombre_Grupo").val("");
    $("#TX_Nombre_Responsable").val("");
    $("#SL_LAtencion").val("");
    $("#SL_LAtencion").selectpicker("refresh");
    $("#SL_EAtencion").val("");
    $("#SL_EAtencion").selectpicker("refresh");
    $("#SL_Tipo_Grupo").val("");
    $("#SL_Tipo_Grupo").selectpicker("refresh");
    $("#SL_nivel_escolaridad").val("");
    $("#SL_nivel_escolaridad").selectpicker("refresh");
    $("#SL_Lugar_Grupo").val("");
    $("#SL_Lugar_Grupo").selectpicker("refresh");    
  }

  $("#SL_EAtencion").on('change', function() {
    if($(this).val() == '2'){
      $("#lugar_grupo_laboratorio").show();
    }else{
      $("#lugar_grupo_laboratorio").hide();
      $("#SL_Lugar_Grupo").selectpicker("val",'');
    }
  });

  $("table").delegate(".inactivar-grupo", "click", function() {
    $("#nombreGrupoI").html($(this).data("nombre-grupo"));
    $("#idGrupoI").val($(this).data("id-grupo"));
  });

  $("table").delegate(".activar-grupo", "click", function() {
    $("#nombreGrupoA").html($(this).data("nombre-grupo"));
    $("#idGrupoA").val($(this).data("id-grupo"));
  });

  $(".confirmar-inactivacion").click(function() {
    inactivarGrupo(); 
  });
  $(".confirmar-activacion").click(function() {
    ActivarGrupo();
  });

  /*-----------------Función para inactivar el grupo-----------------------*/
  function inactivarGrupo() {
    var datos = {
      funcion: 'inactivarGrupo',
      'p1': $("#idGrupoI").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        $('#modalInactivacion').modal('hide');
        ConsultarTotalesGruposDupla();
        consultarGrupos();
      },
      async: false
    });
  }
/*-----------------Función para inactivar el grupo-----------------------*/
  function ActivarGrupo() {
    var datos = {
      funcion: 'activarGrupo',
      'p1': $("#idGrupoA").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        $('#modalActivacion').modal('hide');
        ConsultarTotalesGruposDupla();
        consultarGrupos();
      },
      async: false
    });
  }

  $("table").delegate(".editar-grupo", "click", function() {
    var idGrupo = $(this).data("id-grupo");
    var idEstrategia = $(this).data("idestrategia");    
    $("#TX_Id_Grupo").val($(this).data("id-grupo"));
    $("#SL_EAtencion_Modificar").val($(this).data("idestrategia")).selectpicker('refresh').trigger('change');
    $("#SL_LAtencion_Modificar").val($(this).data("idlugar")).selectpicker('refresh').trigger('change');
    $("#TX_Nombre_Grupo_Modificar").val($(this).data("nombre-grupo"));
    $("#SL_Tipo_Grupo_Modificar").val($(this).data("idtipogrupo")).selectpicker('refresh').trigger('change');
    $("#SL_nivel_escolaridad_Modificar").val($(this).data("idnivel")).selectpicker('val', $(this).data("idnivel").split(',').map(Number));
    $("#TX_Nombre_Responsable_Modificar").val($(this).data("responsable"));
    $("#SL_Lugar_Grupo_Modificar").val($(this).data("idlaboratorio")).selectpicker('refresh').trigger('change');
    if(idEstrategia == '2'){
      $("#lugar_grupo_laboratorio_modificar").show();
    }else{
      $("#lugar_grupo_laboratorio_modificar").hide();
      $("#SL_Lugar_Grupo_Modificar").selectpicker("val",'');
    }
  });




  function guardarFormularioModificacion() {
    var idsNiveles = "";
    
    $('#SL_nivel_escolaridad_Modificar :selected').each(function(i, selected) {
      if (idsNiveles == "") {
       idsNiveles = $(selected).val() + ",";
     }else{
       idsNiveles += $(selected).val() + ",";
     }
   });
    datos = {
      funcion: 'modificarGrupo',
      p1: {
        'pk_id_grupo': $("#TX_Id_Grupo").val(),
        'fk_id_estrategia_atencion': $("#SL_EAtencion_Modificar").val(),
        'fk_id_lugar_atencion': $("#SL_LAtencion_Modificar").val(),
        'vc_nombre_grupo': $("#TX_Nombre_Grupo_Modificar").val(),
        'tipo_grupo': $("#SL_Tipo_Grupo_Modificar").val(),
        'fk_nivel_escolaridad': idsNiveles,
        'vc_profesional': $("#TX_Nombre_Responsable_Modificar").val(),        
        'lugar_grupo': $("#SL_Lugar_Grupo_Modificar").val()
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
      success: function(data) {
        parent.mostrarAlerta("success","Operación exitosa","Se actualizo correctamente la información del grupo");
        $('#modal-modificar-grupo').modal('hide');
        consultarGrupos();
      }
    });
  } 

  function consolidadoAtencionesDupla() {
    var mostrar = "";
    table_consolidado_dupla.clear().draw();
    var datos = {
      funcion: 'consolidadoAtencionesDupla',
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
    }).done(function(data) {
      table_consolidado_dupla.rows.add($(data)).draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }


  /* 

  $('a[href="#modificacion_grupos_nidos"]').click(function() {
    $("#SL_Tipo_Grupo_Modificar").html(parent.getOptionsParametroDetalle(45)).selectpicker("refresh");
    $("#SL_nivel_escolaridad_Modificar").html(parent.getOptionsParametroDetalle(58)).selectpicker("refresh");
    $("#SL_EAtencion_Modificar").html(getTipoEstrategia()).selectpicker("refresh");
    $("#SL_LAtencion_Modificar").html(getLugaresAtencion()).selectpicker("refresh");
  });

  $("#SL_Lugar_Atencion").html(getLugaryGrupoArtista()).selectpicker("refresh");
  $("#div_modificar_grupo_nidos").hide();
  $("#SL_Lugar_Atencion").change(cargarDatosGrupos);
  $("#SL_Entidad_Grupo_Modificar").html(getEntidades()).selectpicker("refresh");



  $(".info-grupo").append("<div class='form-group'><div class='col-xs-12 col-md-12'><p></p><p><strong>Artistas: </strong><span class='artista1'></span> - <span class='artista2'></span> - <span class='artista3'>.</span></p><p><strong>Código de la dupla: </strong><span class='SP_codigo_dupla'></span></p><p><strong>Territorio asignado: </strong><span class='TX_NombreTerritorio'></span></p></div></div>");
  NombreTerritorio()
  getIdCodigoDupla();
  getDupla();

  /*-----------------Función para obtener los grupos filtrados por el lugar de atención-----------------------*/

 /*-----------------Función para obtener los tipos de estrategias-----------------------*/
  /* function getTipoEstrategia() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsEstrategias'
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
  /*-----------------Función para mostrar los lugares y grupos -----------------------*/
  /* function getLugaryGrupoArtista() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsLugaryGrupoArtista',
      'p1': parent.idUsuario
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
  /*-----------------Función para obtener el lugar de atención dependiendo del usuario que ingrese-----------------------*/
  /* 
  /*-----------------Función para obtener id de la dupla-----------------------*/
  /* 

/*-----------------Función para obtener la dupla de artistas-----------------------*/
 /* function getDupla() {
    var mostrar = "";
    var datos = {
      funcion: 'getDupla',
      'p1': idDupla
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
    var dupla = JSON.parse(mostrar);
    $.each(dupla[0], function(key, value) {
      $(".artista1").text(value);
    });
    $.each(dupla[1], function(key, value) {
      $(".artista2").text(value);
    });
    $.each(dupla[2], function(key, value) {
      $(".artista3").text(value);
    });
    return mostrar;
  }
  /*--------------------------------------------------------------------------------------*/
  
  /*-----------------Función para consultar los grupos-----------------------*/

  /*-----------------Función para guardar los datos del nuevo grupo-----------------------*/
  /*

/*-----------------Función para limpiar el formulario despues de guardar los datos-----------------------*/
 /* 
/*-----------------Función para mostrar el div con los datos del grupo a modificar-----------------------*/
 /* function cargarDatosGrupos() {
    if ($("#SL_Lugar_Atencion").val() == '0') {
      $("#div_modificar_grupo_nidos").hide();
    } else {
      $("#div_modificar_grupo_nidos").show();
      precargarDatosModificarGrupo();
    }
  }
/*-----------------Función para precargar los datos guardados del grupo a modificar-----------------------*/
 /* function precargarDatosModificarGrupo() {
    var mostrar = "";
    datos = {
      funcion: 'consultarDatosCompletosGrupo',
      'p1': $("#SL_Lugar_Atencion").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
    }).done(function(data) {
      try {
        datos = $.parseJSON(data);
        $("#TX_Nombre_Grupo_Modificar").val(datos['VC_Nombre_Grupo']);
        $("#TX_Nombre_Responsable_Modificar").val(datos['VC_Profesional_Responsable']);
        $("#SL_EAtencion_Modificar").val(datos['FK_Id_Estrategia_Atencion']).selectpicker('refresh').trigger('change');
        $("#SL_LAtencion_Modificar").val(datos['Fk_Id_Lugar_Atencion']).selectpicker('refresh').trigger('change');
        $("#SL_Tipo_Grupo_Modificar").val(datos['Fk_Id_Tipo_Grupo']).selectpicker('refresh').trigger('change');
        $("#SL_nivel_escolaridad_Modificar").val(datos['Fk_Id_Nivel_Escolaridad']).selectpicker('refresh').trigger('change');
        $("#SL_Entidad_Grupo_Modificar").val(datos['Fk_Id_Entidad_Grupo']).selectpicker('refresh').trigger('change');
      } catch (ex) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos del grupo");
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos del grupo");
    });
  }
/*-----------------Función para modificar los datos del grupo-----------------------*/
/*  function guardarFormularioModificacion() {
    var mostrar = "";
    datos = {
      funcion: 'modificarGrupo',
      p1: {
        'pk_id_grupo': $("#SL_Lugar_Atencion").val(),
        'fk_id_estrategia_atencion': $("#SL_EAtencion_Modificar").val(),
        'fk_id_lugar_atencion': $("#SL_LAtencion_Modificar").val(),
        'vc_nombre_grupo': $("#TX_Nombre_Grupo_Modificar").val(),
        'vc_tipo_grupo': $("#SL_Tipo_Grupo_Modificar").val(),
        'fk_nivel_escolaridad': $("#SL_nivel_escolaridad_Modificar").val(),
        'vc_profesional': $("#TX_Nombre_Responsable_Modificar").val(),
        'fk_entidad_grupo': $("#SL_Entidad_Grupo_Modificar").val()
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Operación exitosa","Grupo Nidos modificado correctamente");
        $("#SL_Lugar_Atencion").html(getLugaryGrupoArtista()).selectpicker("refresh");
        $("#div_modificar_grupo_nidos").hide();
      },
      async: false
    });
    return mostrar;
  }
/*-----------------Validación del formulario de creación de grupo-----------------------*/
/*  $("#form_nuevo_grupo_nidos").validate({
    rules: {
      TX_Nombre_Grupo: {
        required: true,
        minlength: 1,
        maxlength: 100
      },
      SL_EAtencion: {
        required: true
      },
      SL_LAtencion: {
        required: true
      },
      SL_Tipo_Grupo: {
        required: true
      },
      SL_nivel_escolaridad: {
        required: true
      },
      TX_Nombre_Responsable: {
        required: true,
        minlength: 3
      }
    },
    messages: {
      TX_Nombre_Grupo: {
        required: "Por favor ingrese el nombre del grupo",
        minlength: "El nombre del grupo debe contener al menos un caracter"
      },
      SL_EAtencion: {
        required: "Por favor elija una estrategia de atención"
      },
      SL_LAtencion: {
        required: "Por favor elija un lugar de atención"
      },
      SL_Tipo_Grupo: {
        required: "Por favor elija el tipo del grupo"
      },
      SL_nivel_escolaridad: {
        required: "Por favor elija el nivel de escolaridad"
      },      
      TX_Nombre_Responsable: {
        required: "Por favor ingrese el nombre de la persona responsable del grupo",
        minlength: "El nombre de la persona responsable debe contener al menos tres caracteres"
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
      guardarFormularioCreacion();
    }
  });
  /*-----------------Validación del formulario de modificación de grupo-----------------------*/
/*  $("#form_modificar_grupo_nidos").validate({
    rules: {
      TX_Nombre_Grupo_Modificar: {
        required: true,
        minlength: 1
      },
      SL_EAtencion_Modificar: {
        required: true
      },
      SL_LAtencion_Modificar: {
        required: true
      },
      SL_Tipo_Grupo_Modificar: {
        required: true
      },
      TX_Nombre_Responsable_Modificar: {
        required: true,
        minlength: 3
      }
    },
    messages: {
      TX_Nombre_Grupo_Modificar: {
        required: "Por favor ingrese el nombre del grupo",
        minlength: "El nombre del grupo debe contener al menos un caracter"
      },
      SL_EAtencion_Modificar: {
        required: "Por favor elija una estrategia de atención"
      },
      SL_LAtencion_Modificar: {
        required: "Por favor elija un lugar de atención"
      },
      SL_Tipo_Grupo_Modificar: {
        required: "Por favor elija el tipo del grupo"
      },
      TX_Nombre_Responsable_Modificar: {
        required: "Por favor ingrese el nombre de la persona responsable del grupo",
        minlength: "El nombre de la persona responsable debe contener al menos tres caracteres"
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
      guardarFormularioModificacion();
    }
  });

/*-----------------Función para mostrar territorio de la dupla al crear el grupo-----------------------*/
/*  function NombreTerritorio() {
    var mostrar = "";
    var datos = {
      funcion: 'getNombreTerritorio',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        //mostrar += data;
        //mostrar = JSON.parse(data)
        var mostrar = JSON.parse(data, function(key, value) {
          if (key == 'Vc_Nom_Territorio') {
            $(".TX_NombreTerritorio").html(value);
          }
        });
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
      url: url_ok_obj1,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    });
    return mostrar;
  } */
});
