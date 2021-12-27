var url_beneficiario_controller = '../../src/Beneficiario/BeneficiarioController/';
$(function(){
  var datos_beneficiario = {
    // DATOS PERSONALES
    "numero_documento":"",
    "id_tipo_identificacion":"",
    "primer_nombre":"",
    "segundo_nombre":"",
    "primer_apellido":"",
    "segundo_apellido":"",
    "fecha_nacimiento":"",
    "id_sexo":"",
    "id_grupo_poblacional":"",
    "estrato":"1",
    "puntaje_sisben":"0.0",
    "nacionalidad":"",
    "observaciones":"",
    // SALUD
    "id_tipo_afiliacion":"",
    "id_eps":"",
    "id_grupo_sanguineo":"",
    "enfermedades":"",
    // INFORMACIÓN ACADEMICA
    "id_crea":$("#SL_crea_cargar_grupos").val(),
    "id_colegio":"",
    "id_jornada":"",
    "id_grado":"",
    // INFORMACIÓN ACUDIENTE
    "nombre_acudiente":"",
    "documento_acudiente":"",
    "telefono_acudiente":"",
    // GEOREFERENCIACIÓN
    "id_localidad":"",
    "barrio":"",
    "direccion":"",
    "correo_electronico":"",
    "telefono_fijo":"",
    "telefono_celular":"",
    // INTERESES DEL BENEFICIARIO Y EXPERIENCIA
    "id_area_artistica_interes" : "",
    "experiencia" : "0",
    "experiencia_empirica" : "0",
    "experiencia_academia" : "0",
    "experiencia_anios" : "0",
    // FUENTE DE DATOS DEL ESTUDIANTE
    "fuente": "FORMULARIO",
    "id_usuario" : parent.idUsuario,
    //  OTROS DATOS QUE NO SE ESTÁN RECOPILANDO EN EL FORMULARIO Y VALE LA PENA ANALIZAR PARA PONERLOS EN ESTE NUEVO FormData
    "id_tipo_poblacion_victima": "9",
    "id_tipo_discapacidad" : "99",
    "id_etnia" : "0"
  };

  var documento_beneficiario_identificacion = null;
  var documento_beneficiario_recibo_publico = null;
  var documento_beneficiario_eps = null;
  var documento_beneficiario_uso_imagen = null;

  $("#bt_mostrar_formulario_registro_estudiante").click(function(){
    $("#modal_formulario_registro_estudiante").modal({backdrop: 'static', keyboard: false});
    $("#modal_agregar_estudiante_grupo").modal("hide");
    cargarDatosFormulario('DatosPersonales',obtenerFormulario('DatosPersonales'));
  });

  $("#contenido_modal_formulario_registro_estudiante").delegate("#form_formulario_registro","submit",function(e){
    e.preventDefault();
    var actual = $("#BT_submit_siguiente").data("formulario_actual");
    var siguiente = $("#BT_submit_siguiente").data("siguiente_formulario");
    actualizarDatosBeneficiario(actual,siguiente);
    
  });

  $("#contenido_modal_formulario_registro_estudiante").delegate("#BT_submit_anterior","click",function(){
    var anterior = $(this).data("siguiente_formulario");
    $("#BT_submit_siguiente").data("siguiente_formulario",anterior);
    $("#BT_submit_siguiente").trigger("click");
  });

  $("#contenido_modal_formulario_registro_estudiante").delegate("#BT_fecha_nacimiento_sin_especificar","click",function(){
    $("#TX_fecha_nacimiento").val("0000-00-00");
  });

  $("#contenido_modal_formulario_registro_estudiante").delegate("#BT_documento_sin_especificar","click",function(){
    if($(this).data("tiene_documento") == 1){
      $("#TX_numero_documento").val("Sin Documento").attr("disabled","disabled");
      $(this).data("tiene_documento",0).removeClass("btn-danger").addClass("btn-success");
    }else{
      $("#TX_numero_documento").val("").removeAttr("disabled");
      $(this).data("tiene_documento",1).removeClass("btn-success").addClass("btn-danger");
    }
  });

  $("#contenido_modal_formulario_registro_estudiante").delegate("[name^='FILE_archivo_beneficiario']","change",function(){
    var nombres_archivos = "";
    var files = $("input[name^='FILE_archivo_beneficiario']");
    for (var i = 0, f; f = files[i]; i++) {
      try{
        nombres_archivos += (files[i].files[0]['name']) + "<br>";
      }catch(err){
        console.log(err);
      }
     }
    $("#archivos_adjuntos_estudiante").html(nombres_archivos);
  });

  function cargarDatosFormulario(vista_cargar,html_formulario){
    $("#contenido_modal_formulario_registro_estudiante").html(html_formulario);
    switch(vista_cargar){
      case 'DatosPersonales':
      switch (linea_atencion){
        case 'arte_escuela':
          $("#SPAN_documento_sin_especificar").hide();
          $("#SPAN_fecha_nacimiento_sin_especificar").hide();
          break;
        case 'emprende_clan': 
          $("#SPAN_documento_sin_especificar").hide();
          $("#SPAN_fecha_nacimiento_sin_especificar").show();
          break;
        case 'laboratorio_clan':;
          $("#SPAN_documento_sin_especificar").show();
          $("#SPAN_fecha_nacimiento_sin_especificar").show();
          break;
        default:
          break;
      }
      $("#TX_numero_documento").val(datos_beneficiario["numero_documento"]);
      $("#SL_tipo_identificacion").html(parent.getOptionsTiposDeIdentificacion()).selectpicker("refresh");
      $("#SL_tipo_identificacion").val(datos_beneficiario['id_tipo_identificacion']);
      $("#TX_primer_nombre").val(datos_beneficiario["primer_nombre"]);
      $("#TX_segundo_nombre").val(datos_beneficiario["segundo_nombre"]);
      $("#TX_primer_apellido").val(datos_beneficiario["primer_apellido"]);
      $("#TX_segundo_apellido").val(datos_beneficiario["segundo_apellido"]);
      $("#TX_fecha_nacimiento").val(datos_beneficiario["fecha_nacimiento"]).datepicker({format: 'yyyy-mm-dd'}).prop("readonly","readonly");
      $('#SL_sexo').html(parent.getOptionsGenero()).selectpicker("refresh");
      switch (datos_beneficiario['id_sexo']){
        case 'M':
          $('#SL_sexo').val(1);
        break;
        case 'F':
          $('#SL_sexo').val(2);
        break;
          $('#SL_sexo').val(3);
        case 'I':
          parent.mostrarAlerta("error","error","no se ha podido determinar el genero para precargar el seleccionable");
          console.log("Error, no se ha podido determinar el genero para precargar el seleccionable");
        break;
        default:

        break;
      }
      $('#SL_grupo_poblacional').html(parent.getOptionsGPoblacional()).selectpicker("refresh");
      $('#SL_grupo_poblacional').val(datos_beneficiario['id_grupo_poblacional']);
      $("#IN_estrato").val(datos_beneficiario["estrato"]);
      $("#IN_puntaje_sisben").val(datos_beneficiario["puntaje_sisben"]);
      $("#TX_nacionalidad").val(datos_beneficiario["nacionalidad"]);
      $("#TX_observaciones").val(datos_beneficiario["observaciones"]);
      break;
      case 'Salud':
      switch (linea_atencion){
        case 'arte_escuela':
          break;
        case 'laboratorio_clan':
          $("#SL_tipo_afiliacion").removeAttr("required");
          $("#SL_eps").removeAttr("required");
          $("#SL_grupo_sanguineo").removeAttr("required");
          break;
        case 'emprende_clan':
          // $("#SL_tipo_afiliacion").attr("required","required");
          // $("#SL_eps").attr("required","required");
          $("#SL_tipo_afiliacion").removeAttr("required");
          $("#SL_eps").removeAttr("required");
          $("#SL_grupo_sanguineo").removeAttr("required");
          break;
        default:
          break;
      }
      $("#SL_tipo_afiliacion").selectpicker("refresh");
      $("#SL_tipo_afiliacion").val(datos_beneficiario['id_tipo_afiliacion']);
      $('#SL_eps').html(parent.getOptionsEPS()).selectpicker("refresh");
      $('#SL_eps').val(datos_beneficiario['id_eps']);
      $("#SL_grupo_sanguineo").html(parent.getOptionsGSanguineo()).selectpicker("refresh");
      $("#SL_grupo_sanguineo").val(datos_beneficiario['id_grupo_sanguineo']);
      $("#TX_enfermedades").val(datos_beneficiario['enfermedades']);
      break;
      case 'InformacionAcademica':
      $("#SL_crea_registro_beneficiario").html(parent.getOptionsClanes()).change(function(){
        $('#SL_colegio_registro_beneficiario').html(parent.getOptionsColegiosCrea($(this).val(),0)).val(datos_beneficiario['id_colegio']).selectpicker('refresh');
      }).val(datos_beneficiario['id_crea']).trigger("change").selectpicker("refresh");
      $("#SL_jornada_registro_beneficiario").html(parent.getOptionsParametroDetalle(11)).selectpicker("refresh");
      $("#SL_jornada_registro_beneficiario").val(datos_beneficiario['id_jornada']);
      $("#SL_grado_registro_beneficiario").html(parent.getOptionsGrados()).selectpicker("refresh");
      $("#SL_grado_registro_beneficiario").val(datos_beneficiario['id_grado']);
      $("#SL_colegio_registro_beneficiario").selectpicker("refresh");
      $("#SL_colegio_registro_beneficiario").val(datos_beneficiario['id_colegio']);
      break;
      case 'InformacionAcudiente':
      switch (linea_atencion){
        case 'arte_escuela':
        case 'laboratorio_clan':
          $("#TX_nombre_acudiente").removeAttr("required");
          $("#TX_telefono_acudiente").removeAttr("required");
          break;
        case 'emprende_clan':
          // $("#TX_nombre_acudiente").attr("required","required");
          // $("#TX_telefono_acudiente").attr("required","required");
          $("#TX_nombre_acudiente").removeAttr("required");
          $("#TX_telefono_acudiente").removeAttr("required");
          break;
        default:
          break;
      }
      $("#TX_nombre_acudiente").val(datos_beneficiario['nombre_acudiente']);
      $("#TX_numero_documento_acudiente").val(datos_beneficiario['documento_acudiente']);
      $("#TX_telefono_acudiente").val(datos_beneficiario['telefono_acudiente']);
      break;
      case 'Georeferenciacion':
      switch (linea_atencion){
        case 'arte_escuela':
        case 'laboratorio_clan':
          $("#TX_barrio").removeAttr("required");
          $("#TX_direccion").removeAttr("required");
          //$("#TX_email").removeAttr("required");
          break;
        case 'emprende_clan':
          // $("#TX_barrio").attr("required","required");
          $("#TX_direccion").attr("required","required");
          $("#TX_email").attr("required","required");
          break;
        default:
          break;
      }
      $("#SL_localidad").html(parent.getOptionsLocalidad()).selectpicker("refresh");
      $("#SL_localidad").on('change', function(){
        $("#SL_Barrio").html(parent.getOptionsBarriosLocalidad($(this).val())).selectpicker("refresh");
      });
      $("#SL_localidad").val(datos_beneficiario['id_localidad']).change();  

      $("#TX_direccion").val(datos_beneficiario['direccion']);
      $("#TX_email").val(datos_beneficiario['correo_electronico']);
      $("#TX_telefono_beneficiario").val(datos_beneficiario['telefono_fijo']);
      $("#TX_celular_beneficiario").val(datos_beneficiario['telefono_celular']);
      break;
      case 'Documentos':
      switch (linea_atencion){
        case 'arte_escuela':
        case 'emprende_clan':
        case 'laboratorio_clan':
          $("#FILE_archivo_beneficiario_identificacion").removeAttr("required");
          $("#FILE_archivo_beneficiario_recibo_publico").removeAttr("required");
          $("#FILE_archivo_beneficiario_eps").removeAttr("required");
          break;
        // case 'emprende_clan':
        //   $("#FILE_archivo_beneficiario_identificacion").attr("required","required");
        //   $("#FILE_archivo_beneficiario_recibo_publico").attr("required","required");
        //   $("#FILE_archivo_beneficiario_eps").attr("required","required");
        //   break;
        default:
          break;
      }
      try{
        $("#FILE_archivo_beneficiario_identificacion")[0].files = documento_beneficiario_identificacion;
        $("#FILE_archivo_beneficiario_recibo_publico")[0].files = documento_beneficiario_recibo_publico;
        $("#FILE_archivo_beneficiario_eps")[0].files = documento_beneficiario_eps;
        $("#FILE_archivo_beneficiario_uso_imagen")[0].files = documento_beneficiario_uso_imagen;
      }catch(err){
        console.log(err);
      }
      var nombres_archivos = "";
      var files = $("input[name^='FILE_archivo_beneficiario']");
      for (var i = 0, f; f = files[i]; i++) {
        try{
          nombres_archivos += (files[i].files[0]['name']) + "<br>";
        }catch(err){
          console.log(err);
        }
      }
      $("#archivos_adjuntos_estudiante").html(nombres_archivos);
      $("#SL_Autoriza_Uso_Imagen").bootstrapToggle({
        on: 'SÍ',
        off: 'NO',
        onstyle: 'success',
        offstyle: 'danger'
      })

      $("#SL_Autoriza_Uso_Obras").bootstrapToggle({
        on: 'SÍ',
        off: 'NO',
        onstyle: 'success',
        offstyle: 'danger'
      })

      $("#SL_Autoriza_Uso_Datos").bootstrapToggle({
        on: 'SÍ',
        off: 'NO',
        onstyle: 'success',
        offstyle: 'danger'
      })
      break;
      case 'ExperienciaArtistica':
      $("#div_tiene_experiencia").hide();
      $("#SL_area_artistica_interes").html(parent.getOptionsAreasArtisticas()).selectpicker("refresh");
      $("#SL_area_artistica_interes").val(datos_beneficiario['id_area_artistica_interes']);
      $("#CH_area_artistica_interes_experiencia").bootstrapToggle({
        on: 'SÍ TIENE',
        off: 'NO TIENE',
        onstyle: 'success',
        offstyle: 'danger'
      }).change(function(){
        if($(this).prop("checked")){
          $("#div_tiene_experiencia").show("slow");
          datos_beneficiario['experiencia'] = 1;
        }else{
          datos_beneficiario['experiencia'] = 0;
          datos_beneficiario['experiencia_academia'] = 0;
          datos_beneficiario['experiencia_empirica'] = 0;
          $("#div_tiene_experiencia").hide("slow");
        }
      });
      if(datos_beneficiario['experiencia'] == 1){
        if(datos_beneficiario['experiencia_empirica'] == 1 && datos_beneficiario['experiencia_academia'] == 0){
          $("#SL_tipo_experiencia").val(1).selectpicker("refresh");
        }else if(datos_beneficiario['experiencia_empirica'] == 0 && datos_beneficiario['experiencia_academia'] == 1){
          $("#SL_tipo_experiencia").val(2).selectpicker("refresh");
        }else if(datos_beneficiario['experiencia_empirica'] == 1 && datos_beneficiario['experiencia_academia'] == 1){
          $("#SL_tipo_experiencia").val(3).selectpicker("refresh");
        }
        $("#CH_area_artistica_interes_experiencia").bootstrapToggle('on');
        $("#IN_experiencia_anios").val(datos_beneficiario['experiencia_anios']);
      }
      break;
      case 'FinalizarRegistro':
      break;
      case 'intentarRegistrarBeneficiario':
      parent.swal({
        title: 'Intentar registrar beneficiario',
        text: "¿Esta seguro que desea registrar al nuevo beneficiario?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, registrar beneficiario',
        cancelButtonText: 'Cancelar y verificar datos'
      }).then(function(){
        intentarRegistrarBeneficiario();
      }, function(dismiss){
        console.log("Cancelada la promesa");
        $("#contenido_modal_formulario_registro_estudiante").html(obtenerFormulario('FinalizarRegistro'));
        return false;
      });
      break;
      default:
      parent.mostrarAlerta("error","Vista desconocida","El formulario solicitado no existe, por favor comuniquese con el equipo de soporte SIF.");
      console.log("vista desconocida" + vista_cargar);
      break;
    }
    $(".selectpicker").selectpicker("refresh");
  }

  function actualizarDatosBeneficiario(vista_actual,siguiente_formulario){
    var datos_validos = true;
    switch(vista_actual){
      case 'DatosPersonales':
      if($("#TX_numero_documento").val() != "Sin Documento"){
        datos_beneficiario['numero_documento'] = $("#TX_numero_documento").val();
        if(verificarExistenciaDocumento($("#TX_numero_documento").val())){
          parent.mostrarAlerta("error","Advertencia","El número de documento ya se encuentra registrado")
          datos_validos = false;
        }
      }else{
        datos_beneficiario['numero_documento'] = "";
      }
      datos_beneficiario['id_tipo_identificacion'] = $("#SL_tipo_identificacion").val();
      datos_beneficiario['primer_nombre'] = $("#TX_primer_nombre").val();
      datos_beneficiario['segundo_nombre'] = $("#TX_segundo_nombre").val();
      datos_beneficiario['primer_apellido'] = $("#TX_primer_apellido").val();
      datos_beneficiario['segundo_apellido'] = $("#TX_segundo_apellido").val();
      datos_beneficiario['fecha_nacimiento'] = $("#TX_fecha_nacimiento").val();
      if(datos_beneficiario['fecha_nacimiento'] == ""){
        datos_validos = false;
        parent.mostrarAlerta("warning","Advertencia","Fecha de nacimiento es un campo requerido, por favor diligencielo");
      }
      switch($("#SL_sexo").val()){
        case '1':
          datos_beneficiario['id_sexo'] = 'M';
        break;
        case '2':
          datos_beneficiario['id_sexo'] = 'F';
        break;
        case '3':
          datos_beneficiario['id_sexo'] = 'I';
        break;
        default:
          datos_beneficiario['id_sexo'] = 'X';
        break;
      }
      datos_beneficiario['id_sexo'] = (($("#SL_sexo").val() == 1)?'M':'F');
      datos_beneficiario['id_grupo_poblacional'] = $("#SL_grupo_poblacional").val();
      datos_beneficiario['estrato'] = $("#IN_estrato").val();
      datos_beneficiario['puntaje_sisben'] = $("#IN_puntaje_sisben").val();
      datos_beneficiario['nacionalidad'] = $("#TX_nacionalidad").val();
      datos_beneficiario['observaciones'] = $("#TX_observaciones").val();
      break;
      case 'Salud':
      datos_beneficiario['id_eps'] = $("#SL_eps").val();
      datos_beneficiario['id_grupo_sanguineo'] = $("#SL_grupo_sanguineo").val();
      datos_beneficiario['id_tipo_afiliacion'] = $("#SL_tipo_afiliacion").val();
      datos_beneficiario['enfermedades'] = $("#TX_enfermedades").val();
      break;
      case 'InformacionAcademica':
      datos_beneficiario['id_crea'] = $("#SL_crea_registro_beneficiario").val();
      datos_beneficiario['id_colegio'] = $("#SL_colegio_registro_beneficiario").val();
      datos_beneficiario['id_jornada'] = $("#SL_jornada_registro_beneficiario").val();
      datos_beneficiario['id_grado'] = $("#SL_grado_registro_beneficiario").val();
      break;
      case 'InformacionAcudiente':
      datos_beneficiario['nombre_acudiente'] = $("#TX_nombre_acudiente").val();
      datos_beneficiario['documento_acudiente'] = $("#TX_numero_documento_acudiente").val();
      datos_beneficiario['telefono_acudiente'] = $("#TX_telefono_acudiente").val();
      break;
      case 'Georeferenciacion':
      datos_beneficiario['id_localidad'] = $("#SL_localidad").val();
      datos_beneficiario['barrio'] = $("#SL_Barrio option:selected").text();
      datos_beneficiario['direccion'] = $("#TX_direccion").val();
      datos_beneficiario['correo_electronico'] = $("#TX_email").val();
      datos_beneficiario['telefono_fijo'] = $("#TX_telefono_beneficiario").val();
      datos_beneficiario['telefono_celular'] = $("#TX_celular_beneficiario").val();
      break;
      case 'Documentos':
        var combinedSize = 0;
        datos_beneficiario['acepta_uso_imagen'] = $("#SL_Autoriza_Uso_Imagen").prop('checked') ? 1:0;
        datos_beneficiario['acepta_uso_obras'] = $("#SL_Autoriza_Uso_Obras").prop('checked') ? 1:0;
        datos_beneficiario['acepta_uso_datos'] = $("#SL_Autoriza_Uso_Datos").prop('checked') ? 1:0;
        var files = $("input[name^='FILE_archivo_beneficiario']");
        for (var i = 0, f; f = files[i]; i++) {
          try{
            combinedSize += (files[i].files[0].size);

          }catch(err){
            console.log(err);
          }
        }
        if(combinedSize>8388608){
          parent.mostrarAlerta("warning","Alerta del sistema","El tamaño de los archivos excede el límite establecido: 8 Megabytes.");
          datos_validos = false;
        }else{
          try{
            documento_beneficiario_identificacion = $("#FILE_archivo_beneficiario_identificacion")[0].files;
          }catch(err){
            console.log(err);
          }
          try{
            documento_beneficiario_recibo_publico = $("#FILE_archivo_beneficiario_recibo_publico")[0].files;
          }catch(err){
            console.log(err);
          }
          try{
            documento_beneficiario_eps = $("#FILE_archivo_beneficiario_eps")[0].files;
          }catch(err){
            console.log(err);
          }
          try{
            documento_beneficiario_uso_imagen = $("#FILE_archivo_beneficiario_uso_imagen")[0].files;
          }catch(err){
            console.log(err);
          }
        }
      break;
      case 'ExperienciaArtistica':
      datos_beneficiario['id_area_artistica_interes'] = $("#SL_area_artistica_interes").val();
      datos_beneficiario['experiencia_anios'] = $("#IN_experiencia_anios").val();
      switch($("#SL_tipo_experiencia").val()){
        case '1':
        datos_beneficiario['experiencia_empirica'] = 1;
        datos_beneficiario['experiencia_academia'] = 0;
        break;
        case '2':
        datos_beneficiario['experiencia_empirica'] = 0;
        datos_beneficiario['experiencia_academia'] = 1;
        break;
        case '3':
        datos_beneficiario['experiencia_empirica'] = 1;
        datos_beneficiario['experiencia_academia'] = 1;
        break;
        default:
        console.log("No se ha podido determinar el tipo de experiencia que tiene el beneficiario");
        parent.mostrarAlerta("danger","Error","No se ha podido determinar el tipo de experiencia que tiene el beneficiario");
        break;
      }
      break;
      case 'FinalizarRegistro':

      break;
      default:
      parent.mostrarAlerta("error","Vista desconocida","No se han podido actualizar los datos del formulario indicado.");
      console.log("vista desconocida" + vista_cargar);
      break;
    }
    if(datos_validos){
      cargarDatosFormulario(siguiente_formulario,obtenerFormulario(siguiente_formulario));
    }
  }

  function obtenerFormulario(tipo_formulario){
    var mostrar = '';
    var datos = {
      p1: {
        'tipo_formulario': tipo_formulario
      }
    }
    $.ajax({
      url: url_beneficiario_controller+'obtenerFormulario',
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data){
      mostrar += data;
    }).fail(function(data){
      parent.mostrarAlerta("warning","Error","No se ha podido cargar el formulario: " + tipo_formulario);
      console.log(data);
    });
    return mostrar;
  }

  function intentarRegistrarBeneficiario(){
    var id_beneficiario_nuevo = 0;
    var data_form = new FormData();
    try{
      data_form.append(0, documento_beneficiario_identificacion[0]);
    }catch(err){
      console.log(err);
    }
    try{
      data_form.append(1, documento_beneficiario_recibo_publico[0]);
    }catch(err){
      console.log(err);
    }
    try{
      data_form.append(2, documento_beneficiario_eps[0]);
    }catch(err){
      console.log(err);
    }
    try{
      data_form.append(3, documento_beneficiario_uso_imagen[0]);
    }catch(err){
      console.log(err);
    }
    data_form.append("p1",JSON.stringify(datos_beneficiario));
    $.ajax({
     url: url_beneficiario_controller+'registrarBeneficiario',
     type: 'POST',
     data: data_form,
     dataType: 'json',
      processData: false, // Don't process the files
      contentType: false, // Set content type to false as jQuery will tell the server its a query string request
      async: false
    }).done(function(data){
      id_beneficiario_nuevo = data;
      if(datos_beneficiario['numero_documento'] == ""){
        datos_beneficiario['numero_documento'] = 'SIFPROV' + id_beneficiario_nuevo;
      }
      $("#modal_formulario_registro_estudiante").modal("hide");
      $("#modal_agregar_estudiante_grupo").modal("show");
      $("#nro_documento").val(datos_beneficiario['numero_documento']);
      $("#BT_buscar_estudiante").trigger("click");
      documento_beneficiario_identificacion = null;
      documento_beneficiario_recibo_publico = null;
      documento_beneficiario_eps = null;
      documento_beneficiario_uso_imagen = null;
      parent.mostrarAlerta("success","Estudiante Registrado","Se ha registrado el estudiante " + datos_beneficiario['numero_documento'] + ", ahora debe continuar con el procedimiento para agregarlo al grupo.")
      $(".cargar_datos_estudiante").trigger("click");
      $("#BT_asignar_estudiante_grupo").trigger("click");

    }).fail(function(data){
      parent.mostrarAlerta("error","Error","No se ha podido crear el Beneficiario por: " + data);
      console.log(data);
    });

  }

  function verificarExistenciaDocumento(numero_documento){
    var mostrar = false;
    var datos = {
      p1: numero_documento
    }
    $.ajax({
      url: url_beneficiario_controller+'consultarEstudiantePorDocumento',
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data){
      if (data == 1) {
        mostrar = true;
      }
    }).fail(function(data){
      parent.mostrarAlerta("warning","Error","No se ha podido consultar la existencia del documento: " + tipo_formulario);
      console.log(data);
    });
    return mostrar;
  }
});