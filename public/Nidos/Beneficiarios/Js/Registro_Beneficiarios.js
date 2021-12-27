var url_ok_obj = '../../../src/Beneficiarios/Controlador/RegistroBeneficiariosController.php'; 
var bandera_existencia = 0;
var observacion = {};
var provisional_existente;
$(document).ready(function() {

  $("#SL_Lugar_Atencion").html(getLugaresAtencion()).selectpicker("refresh");
  $("#SL_Lugar_Atencion_Consulta").html(getLugaresAtencion()).selectpicker("refresh");

  $("#SL_Lugar_Atencion_Consulta").change(function() {
    getBeneficiariosXGrupo($("#SL_Lugar_Atencion_Consulta").val(),1);
    $("#div_Consulta_Beneficiarios").show("refresh");
  });

  $("body").on("keyup",".mayuscula", function(){
    $(this).val($(this).val().toUpperCase());
  });
  var IdBeneficiarioSelected  = 0;
  var elementoBeneficiarioSelected = null;
  $("#tabla_inactivar_beneficiario").on( "change", "input[type=checkbox]", function() {
    IdBeneficiarioSelected = $(this).data("idbeneficiario");
    elementoBeneficiarioSelected = $(this);

    $("#form-inactivar-beneficiario").empty();
    $("#form-activar-beneficiario").empty();
    $(".modal-footer").empty();
    $("#div-modal-activacion").modal("show");
    if($(this).is(":checked")){
      $(".modal-title").text("Inactivar Beneficiario");
      $("#form-inactivar-beneficiario").show();
      $("#form-inactivar-beneficiario").append("Por favor indique el motivo por el cual va a inactivar al beneficiario <strong>" +  $(this).data("beneficiario") + "</strong> del grupo <strong>" + $(this).data("grupo") + "</strong>.<br><input type='text' required='required' class='form-control' id='TX_Observacion' name='TX_Observacion'>");
      $("#BT_confirmar_inactivacion").show();
      $(".modal-footer").append("<input type='button' class='btn btn-success' id='BT-confirmar-inactivacion' value='Guardar' /><input type='button' class='btn btn-danger' data-dismiss='modal' id='BT-cancelar-activacion' value='Cancelar' />");
    }else{
      $(".modal-title").text("Activar Beneficiario");
      $("#form-activar-beneficiario").show();
      $("#form-activar-beneficiario").append("Esta seguro de activar nuevamente al beneficiario <strong>" +  $(this).data("beneficiario") + "</strong> del grupo <strong>" + $(this).data("grupo") + "</strong>.");
      $("#BT_confirmar_activacion").show();
      $(".modal-footer").append("<input type='button' class='btn btn-success' id='BT-confirmar-activacion' value='Guardar' /><input type='button' class='btn btn-danger' data-dismiss='modal' id='BT-cancelar-activacion' value='Cancelar' />");
    }


  });
  $("body").delegate("#BT-cancelar-activacion", "click", function(){
    var elemento = $("input[type=checkbox]").filter(function(key,value) {
      return $(value).data("idbeneficiario") == IdBeneficiarioSelected;
    });
    if ($(elemento).is(":checked")) {
      $(elemento).attr("checked", "");
    }
    else {
      $(elemento).attr("checked", true);
    }
  });

  $("#btn-guardar-observacion").click(function(){
    if($(".observacion").val() == ""){
      $("#error-observacion").empty();
      $("#error-observacion").css("color", "red");
      $("#error-observacion").text("Por favor escriba una observación");
    }else{
      var datetime = new Date();
      //var stringHours = datetime.getHours()+":"+datetime.getMinutes()+":"+datetime.getSeconds()+"."+datetime.getMilliseconds();
      var stringHours = parent.getFechaYHoraServidor().split(" ")[1];
      valueTime = (new Date(parent.getFechaYHoraServidor())).getTime() - 946702800000;
      id_provisional = "SIFPROV" + valueTime; //(Math.floor(Math.random() * 8888888) + 1000000);
      num_elemento = $("#div-observacion input[type=text]").attr("id").split("-")[4];
      $("#TX_Identificacion_"+ num_elemento).prop("readonly", true);
      $("#TX_Identificacion_"+ num_elemento).val(id_provisional);
      observacion[num_elemento] = $("#div-observacion input[type=text]").val();
      $("#modal_observacion_documento_provisional").modal("hide");
    }
  });

  $("#btn-cancelar-observacion").click(function(){
    num_elemento = $("#div-observacion input[type=text]").attr("id").split("-")[4];
    $("#SL_Tipo_Documento_" + num_elemento).html(getTipoDocumento()).selectpicker("refresh");
    $("#TX_Identificacion_"+ num_elemento).prop("readonly", false);
  });

  $("body").delegate("input[type=text].fecha", "focusin", function(){
    $(this).datepicker({
      format: 'yyyy-mm-dd',
      language: 'es',
      autoclose: true,
      endDate: '+0d',
      startDate: '1950-01-01'
    });
  });

  $("#documento_provisional").click(function(){
    consultarBeneficiariosDocumentoProvisional();
	});

  $("#BT_beneficiarios_grupo").click(function(){
    getBeneficiariosXGrupo($("#SL_Lugar_Atencion").val(),2);
  });

  var characterRegex = /([a-zA-Z])$/;
  $.validator.addMethod("validCharacter", function( value, element ) {
    return this.optional( element ) || characterRegex.test( value );
  });

  var characterIdentificacionRegex = /^(?=.*[0-9])([a-zA-Z0-9]+)$/;
  $.validator.addMethod("validIdentificacion", function( value, element ) {
    return this.optional( element ) || characterIdentificacionRegex.test( value );
  });

  $("#BT_guardar_beneficiarios").click(function(){
    rules = {};
    messages = {};
    for(i=1 ; i<=Id_Registro; i++){
      //Reglas y mensajes para la validación de los campos de número de documento
      rules["TX_Identificacion_"+i] = {required: true, validIdentificacion: true,minlength: 3, maxlength: 25};
      messages["TX_Identificacion_"+i] = {required: 'Por favor ingrese un número de identificación',validIdentificacion: 'El número de identificación no puede contener caracteres especiales',minlength: 'El número de identificación debe contener al menos 3 caracteres', maxlength: 'El número de identificación no puede contener mas de 15 caracteres'};
      //Reglas y mensajes para la validación de los select de tipo de documento
      rules["SL_Tipo_Documento_"+i] = {required: true};
      messages["SL_Tipo_Documento_"+i] = {required: 'Por favor elija un tipo de documento'};
      //Reglas y mensajes para la validación de los campos de fecha de nacimiento
      rules["TX_F_Nacimiento_"+i] = {required: true};
      messages["TX_F_Nacimiento_"+i] = {required: 'Por favor elija una fecha'};
      //Reglas y mensajes para la validación de los campos de primer nombre
      rules["TX_P_Nombre_"+i] = {required: true, minlength: 3};
      messages["TX_P_Nombre_"+i] = {required: 'Por favor ingrese el nombre', minlength: 'El nombre debe contener al menos 3 caracteres'};
      //Reglas y mensajes para la validación de los campos de primer apellido
      rules["TX_P_Apellido_"+i] = {required: true, minlength: 3};
      messages["TX_P_Apellido_"+i] = {required: 'Por favor ingrese el apellido', minlength: 'El apellido debe contener al menos 3 caracteres'};
      //Reglas y mensajes para la validación de los select de género
      rules["SL_Genero_"+i] = {required: true};
      messages["SL_Genero_"+i] = {required: 'Por favor elija el género'};
      //Reglas y mensajes para la validación de los select de enfoque diferecial género
      rules["SL_Etnia_"+i] = {required: true};
      messages["SL_Etnia_"+i] = {required: 'Por favor elija el enfoque diferencial'};
      //Reglas y mensajes para la validación de los select de enfoque diferecial género
      rules["SL_Ip_"+i] = {required: true};
      messages["SL_Ip_"+i] = {required: 'Por favor elija el estrato'};
    }
    validator = $("#form_nueva_experiencia").validate({
      rules:rules,
      messages:messages,
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
        crearNuevaExperiencia();
      },
    });
  });


  $("#SL_Tipo_Documento_1").html(getTipoDocumento()).selectpicker("refresh");
  $("#SL_Genero_1").html(getGenero()).selectpicker("refresh");
  $("#SL_Etnia_1").html(getEtnia()).selectpicker("refresh");
  $("#SL_Ip_1").html(getTPoblacional()).selectpicker("refresh");
  $(document).delegate('.identificacion', 'change', function() {
    ValidarExistenciaBeneficiario($(this).val(), $(this).attr("id"));
  });

  $("#SL_Lugar_Atencion").change(cargarDatos);

  $("body").on("change", ".tipo-documento", function(){
    let element = $(this).find($("select"))[0];
    id_elemen_tipo_doc = $(element).attr("id").split("_")[3];
    if($(element).val() == 8) {
      if(provisional_existente != 1){
        $("#TX_Identificacion_"+ id_elemen_tipo_doc).prop("readonly", true);
        $("#modal_observacion_documento_provisional").modal("show");
        $("#div-observacion").empty();
        $("#div-observacion").append("Por favor indique el motivo por el cual el beneficiario utilizará un documento provisional <br><input type='text' class='form-control observacion' id='observacion-sl-tipo-doc-"+id_elemen_tipo_doc+"' name='observacion-sl-tipo-doc-"+id_elemen_tipo_doc+"'>");
        $("#div-observacion").append("<span id='error-observacion'></span>")
      }
    }else{
      str = $("#TX_Identificacion_"+ id_elemen_tipo_doc).val();
      res = str.substring(0, 7);
      if(res == "SIFPROV"){
        $("#TX_Identificacion_"+ id_elemen_tipo_doc).val("");
      }
      $("#TX_Identificacion_"+ id_elemen_tipo_doc).prop("readonly", false);
      observacion[id_elemen_tipo_doc] = null;
    }
  });

  var Id_Registro = 1;
  $("#btn_Agregar").click(function() {
    Id_Registro++;
    $("#tabla_Titulos_Registro").append("<tr id='" + Id_Registro + "'>"+
      "<td style='width: 2%; vertical-align: middle;'>"+Id_Registro+"</td>"+
      "<td style='width: 20%;'>"+
      "<div class='form-group'><input type='text' class='form-control identificacion' placeholder='Identificación' id='TX_Identificacion_"+Id_Registro+"' name='TX_Identificacion_" + Id_Registro + "'><span class='help-block' id='error'></span></div>"+
      "<div class='form-group tipo-documento'><select class='form-control selectpicker' data-live-search='true' id='SL_Tipo_Documento_" + Id_Registro + "' name='SL_Tipo_Documento_" + Id_Registro + "' title='Tipo de documento'></select><span class='help-block' id='error'></span></div>"+
      "</td>"+
      "<td style='width: 20%;'>"+
      "<div class='form-group'><input type='text' placeholder='Primer nombre' class='form-control mayuscula' id='TX_P_Nombre_" + Id_Registro + "' name='TX_P_Nombre_" + Id_Registro + "'><span class='help-block' id='error'></span></div>"+
      "<div class='form-group'><input type='text' placeholder='Segundo nombre' class='form-control mayuscula' id='TX_S_Nombre_" + Id_Registro + "' name='TX_S_Nombre_" + Id_Registro + "'><span class='help-block' id='error'></span></div>"+
      "</td>"+
      "<td style='width: 20%;'>"+
      "<div class='form-group'><input type='text' placeholder='Primer apellido' class='form-control mayuscula' id='TX_P_Apellido_" + Id_Registro + "' name='TX_P_Apellido_" + Id_Registro + "'><span class='help-block' id='error'></span></div>"+
      "<div class='form-group'><input type='text' placeholder='Segundo apellido' class='form-control mayuscula' id='TX_S_Apellido_" + Id_Registro + "' name='TX_S_Apellido_" + Id_Registro + "'><span class='help-block' id='error'></span></div>"+
      "</td>"+
      "<td style='width: 18%;'>"+
      "<div class='form-group'><div class='input-group date'><input type='text' placeholder='Fecha de nacimiento' readonly='readonly' class='form-control fecha' id='TX_F_Nacimiento_" + Id_Registro + "' name='TX_F_Nacimiento_" + Id_Registro + "'><div class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></div></div><span class='help-block' id='error'></span></div>"+
      "<div class='form-group'><select class='form-control selectpicker' data-live-search='true' id='SL_Genero_" + Id_Registro + "' name='SL_Genero_" + Id_Registro + "' title='Género'></select><span class='help-block' id='error'></span></div>"+
      "</td>"+
      "<td style='width: 20%;'>"+
      "<div class='form-group'><select class='form-control selectpicker' data-live-search='true' id='SL_Etnia_" + Id_Registro + "' name='SL_Etnia_" + Id_Registro + "' title='Enfoque diferencial'></select><span class='help-block' id='error'></span></div>"+
      "<div class='form-group'><select class='form-control selectpicker' data-live-search='true' id='SL_Ip_" + Id_Registro + "' name='SL_Ip_" + Id_Registro + "' title='Estrato'></select><input type='hidden' class='form-control' id='TX_Existe_" + Id_Registro + "' name='TX_Existe_" + Id_Registro + "'><span class='help-block' id='error'></span></div>"+
      "</td>"+
      "</tr>");

    $("#SL_Tipo_Documento_" + Id_Registro).html(getTipoDocumento()).selectpicker("refresh");
    $("#SL_Genero_" + Id_Registro).html(getGenero()).selectpicker("refresh");
    $("#SL_Etnia_" + Id_Registro).html(getEtnia()).selectpicker("refresh");
    $("#SL_Ip_" + Id_Registro).html(getTPoblacional()).selectpicker("refresh");

    validator = $("#form_nueva_experiencia").validate();
    validator.destroy();
    $('.form-group').removeClass("has-success");
  });

  $("#btn_Quitar").click(function() {
    $("table#tabla_Titulos_Registro tr#" + Id_Registro).remove();
    if (Id_Registro > 1) {
      delete observacion[Id_Registro];
      Id_Registro--;
    }
  });

  function cargarDatos() {
    $("#div_Registro_Beneficiarios").show("refresh");
    getInformacionGrupo("refresh");
  }

  // MODAL INACTIVAR BENEFICIARIO
  $("table").delegate(".Inactivar_beneficiario", "click", function() {
    $("#nombre").html($(this).data("beneficiario"));
    $("#grupo").html($(this).data("grupo"));
    $("#IdBeneficiarioInactivar").val($(this).data("idbeneficiario"));
  });
  // MODAL ACTIVAR BENEFICIARIO
  $("table").delegate(".Activar_beneficiario", "click", function() {
    $("#nombreA").html($(this).data("beneficiario"));
    $("#grupoA").html($(this).data("grupo"));
    $("#IdBeneficiarioActivar").val($(this).data("idbeneficiario"));
  });

  /*----------------- Función para obtener el lugar de atención dependiendo del usuario que ingrese-----------------------*/
  function getLugaresAtencion() {
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
  /*--------------------------------------------------------------------------------------*/

  /*-----------------Función para mostrar los grupos en el select-----------------------*/
  function getGrupos(lugar) {
    console.log(lugar);
    if (lugar == 0) {
      p2 = $("#SL_Lugar_Atencion").val();
    } else {
      p2 = $("#SL_Lugar_Atencion_Consulta").val();
    }
    var mostrar = "";
    var datos = {
      funcion: 'getGrupos',
      'p1': parent.idUsuario,
      'p2': p2
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


  function getTipoDocumento() {
    var mostrar = "";
    var datos = {
      funcion: 'getTipoDocumento'
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

  function getGenero() {
    var mostrar = "";
    var datos = {
      funcion: 'getGenero'
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

  function getEtnia() {
    var mostrar = "";
    var datos = {
      funcion: 'getEtnia'
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

  function getTPoblacional() {
    var mostrar = "";
    var datos = {
      funcion: 'getTPoblacional'
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

  function getInformacionGrupo() {
    var mostrar = "";
    datos = {
      'funcion': 'getInfoExperiencia',
      'p1': $("#SL_Lugar_Atencion").val()
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
        $("#SP_IdGrupo").val(datos['Pk_Id_Grupo']);
        $("#SP_IdEntidad").val(datos['Fk_Id_Entidad']);
        $("#SP_Artista").text(datos['ARTISTAS']);
        $(".SP_Codigo_Dupla").text(datos['VC_Codigo_Dupla']);
        $("#SP_Grupo").text(datos['VC_Nombre_Grupo']);
        $("#SP_Responsable").text(datos['VC_Profesional_Responsable']);
        $("#SP_Lugar").text(datos['Vc_Descripcion']);
        $(".SP_Estrategia").text(datos['Vc_Estrategia']);
      } catch (ex) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos del grupo");
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos del grupo");
    });
  }

  function crearNuevaExperiencia(){
    var mostrar = "";
    var beneficiarios_grupo = "";
    //Crea los Beneficiarios que no Existen.
    for(i=1;i<=Id_Registro;i++){
      //if($("#TX_Existe_"+i).val()==0){
      //	alert($("#TX_Existe_"+i).val());
      datos = {
        funcion: 'crearBeneficiarioNidos',
        p1: {
          'identificacion' : $("#TX_Identificacion_"+i).val(),
          'tipo_identifi' : $("#SL_Tipo_Documento_"+i).val(),
          'p_nombre' : $("#TX_P_Nombre_"+i).val(),
          's_nombre' : $("#TX_S_Nombre_"+i).val(),
          'p_apellido' : $("#TX_P_Apellido_"+i).val(),
          's_apellido' : $("#TX_S_Apellido_"+i).val(),
          'f_nacimiento' : $("#TX_F_Nacimiento_"+i).val(),
          'genero' : $("#SL_Genero_"+i).val(),
          'etnia' : $("#SL_Etnia_"+i).val(),
          'i_poblacional' : $("#SL_Ip_"+i).val(),
          'uso_imagen' : $("#SP_IdEntidad").val(),
          'id_usuario' : parent.idUsuario,
          'existe' : $("#TX_Existe_"+i).val(),
          'observacion' : observacion[i],
        }
      };
      //console.log(datos);
      $.ajax({
        url: url_ok_obj,
        type: 'POST',
        data: datos,
        success: function(data){
          mostrar += data;
        },
        async: false
      });
      //}
      beneficiarios_grupo += $("#TX_Identificacion_" + i).val() + ";";
    }

    datos = {
      funcion: 'crearBeneficiarioGrupo',
      p1: {
        'id_grupo': $("#SP_IdGrupo").val(),
        'beneficiarios_grupo': beneficiarios_grupo,
        'id_usuario': parent.idUsuario,
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.swal("Operación exitosa", "Se ha guardado de manera correcta los beneficiarios del grupo, desde este momento podrá registrar la asistencia", "success");
        $("#SL_Lugar_Atencion").val("");
        $("#SL_Lugar_Atencion").selectpicker("refresh");
        $("#div_Registro_Beneficiarios").hide();

        for (i = Id_Registro; i >= 1; i--) {
          if (i != 1) {
            $("table#tabla_Titulos_Registro tr#" + i).remove();
          } else {
            $("#TX_Identificacion_1").val("");
            $("#SL_Tipo_Documento_1").val("");
            $("#SL_Tipo_Documento_1").selectpicker("refresh");
            $("#TX_F_Nacimiento_1").val("");
            $("#TX_P_Nombre_1").val("");
            $("#TX_S_Nombre_1").val("");
            $("#TX_P_Apellido_1").val("");
            $("#TX_S_Apellido_1").val("");
            $("#SL_Genero_1").val("");
            $("#SL_Genero_1").selectpicker("refresh");
            $("#SL_Etnia_1").val("");
            $("#SL_Etnia_1").selectpicker("refresh");
            $("#SL_Ip_1").val("");
            $("#SL_Ip_1").selectpicker("refresh");
            $("#TX_Identificacion_1").popover("destroy");
            Id_Registro = 1;
            observacion = {};
          }
        }
      },
      async: false
    });
    return mostrar;
  }

  function consultarGruposBeneficiario(no_identificacion, nombre_elemento){
    datos = {
      'funcion': 'getGruposBeneficiario',
      'p1': no_identificacion
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
    }).done(function(data){
      datos = $.parseJSON(data);
      let grupo = "";
      if(Object.keys(datos).length == 0){
        $("#"+nombre_elemento).css({"background-color" : "#82FA58"});
        grupo = "<span>Este beneficiario no se encuentra registrado en ningún grupo.</span>";
      }else{
        $("#"+nombre_elemento).css({"background-color" : "#F4FA58"});
        grupo = "<ol>";
        for(i=0;i<Object.keys(datos).length;i++){
          grupo += "<li>Este beneficiario se encuentra <strong>"+datos[i]['Estado']+"</strong> en "+datos[i]['Lugar']+" -> "+datos[i]['Grupo']+".</li>";
        }
        grupo+="</ol>";
      }


      $("#"+nombre_elemento).popover({
        title: '<strong>Información grupos beneficiario</strong>',
        placement: 'top',
        trigger: 'hover',
        html: true,
        content: function () {
          return grupo;
        }
      });

      $("#"+nombre_elemento).on("show.bs.popover", function() {
        setTimeout(function() {
          $("#"+nombre_elemento).popover("hide");
        }, 10000);
      });

      $("#"+nombre_elemento).popover("show");

    });
  }

  function ValidarExistenciaBeneficiario(no_identificacion, nombre_elemento) {
    provisional_existente = 0;
    var mostrar = "";
    var id_registro = nombre_elemento.split("_")[2];
    datos = {
      'funcion': 'getValidarBeneficiario',
      'p1': no_identificacion
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      dataType: 'json',
      async: false,
      beforeSend: function() {}
    }).done(function(data) {
      try {
        provisional_existente = 1;
        $("#TX_P_Nombre_" + id_registro).val(data.VC_Primer_Nombre);
        $("#TX_P_Nombre_" + id_registro).prop('readonly', true);
        $("#TX_S_Nombre_" + id_registro).val(data.VC_Segundo_Nombre);
        $("#TX_S_Nombre_" + id_registro).prop('readonly', true);
        $("#TX_P_Apellido_" + id_registro).val(data.VC_Primer_Apellido);
        $("#TX_P_Apellido_" + id_registro).prop('readonly', true);
        $("#TX_S_Apellido_" + id_registro).val(data.VC_Segundo_Apellido);
        $("#TX_S_Apellido_" + id_registro).prop('readonly', true);
        $("#TX_F_Nacimiento_" + id_registro).val(data.DD_F_Nacimiento);
        $("#SL_Genero_" + id_registro).val(data.FK_Id_Genero).selectpicker('refresh').trigger('change');
        $("#SL_Etnia_" + id_registro).val(data.IN_Grupo_Poblacional).selectpicker('refresh').trigger('change');
        $("#SL_Ip_" + id_registro).val(data.IN_Estrato).selectpicker('refresh').trigger('change');
        $("#TX_Existe_" + id_registro).val('1');
        $("#SL_Tipo_Documento_" + id_registro).focus();
        $("#SL_Tipo_Documento_" + id_registro).val(data.FK_Tipo_Identificacion).selectpicker('refresh').trigger('change');
        consultarGruposBeneficiario(no_identificacion, nombre_elemento);
      } catch (ex) {
        //alertify.alert("Error cargando datos", "No se han podido cargar los datos del niñoxxxx:");
        //console.log(ex);
      }
    }).fail(function(data) {
      $("#SL_Tipo_Documento_" + id_registro).focus();
      $("#SL_Tipo_Documento_" + id_registro).val("");
      $("#SL_Tipo_Documento_" + id_registro).selectpicker("refresh");
      $("#TX_P_Nombre_" + id_registro).val("");
      $("#TX_P_Nombre_" + id_registro).prop('readonly', false);
      $("#TX_S_Nombre_" + id_registro).val("");
      $("#TX_S_Nombre_" + id_registro).prop('readonly', false);
      $("#TX_P_Apellido_" + id_registro).val("");
      $("#TX_P_Apellido_" + id_registro).prop('readonly', false);
      $("#TX_S_Apellido_" + id_registro).val("");
      $("#TX_S_Apellido_" + id_registro).prop('readonly', false);
      $("#TX_F_Nacimiento_" + id_registro).val("");
      $("#SL_Genero_" + id_registro).val("");
      $("#SL_Genero_" + id_registro).selectpicker("refresh");
      $("#SL_Etnia_" + id_registro).val("");
      $("#SL_Etnia_" + id_registro).selectpicker("refresh");
      $("#SL_Ip_" + id_registro).val("");
      $("#SL_Ip_" + id_registro).selectpicker("refresh");
      $("#TX_Existe_" + id_registro).val('0');
      $("#"+nombre_elemento).css('background-color', 'transparent');
      $("#"+nombre_elemento).popover("destroy");
    });
  }

  ///////////////////////////////////////

  var tabla_inactivar_beneficiario = $("#tabla_inactivar_beneficiario").DataTable({
    // autoWidth: false,
    // responsive: true,
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

  var tabla_beneficiarios_grupo = $("#tabla_beneficiarios_grupo").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
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

  ///////////////////////////////////////
  //******** CONSULTAR LOS BENEFICIARIOS DE UN GRUPO
  function getBeneficiariosXGrupo(id_grupo, consulta) {
    tabla_inactivar_beneficiario.clear().draw();
    tabla_beneficiarios_grupo.clear().draw();
    var datos = {
      funcion: 'getBeneficiariosXGrupo',
      'p1': id_grupo,
      'p2': consulta
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {},
      async: false
    }).done(function(data) {
      if(consulta == 1){
        tabla_inactivar_beneficiario.rows.add($(data)).draw();
        $("#tabla_inactivar_beneficiario input[type='checkbox']").bootstrapToggle();
      }else{
        tabla_beneficiarios_grupo.rows.add($(data)).draw();
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
  }

  ///****************************  INACTIVAR BENEFICIARIO DEL GRUPO
  //$("#form_inactivar_beneficiario").submit(function(event) {
    $("body").delegate("#BT-confirmar-inactivacion", "click", function(){
      event.stopPropagation();
      event.preventDefault();
      var mostrar = "";
      datos = {
        funcion: 'InactivarBeneficiario',
        p1: {
          'Id_Beneficiario_Inactivar':IdBeneficiarioSelected,
          'Observacion': $("#TX_Observacion").val(),
          'id_usuario': parent.idUsuario,
        }
      };
      $.ajax({
        url: url_ok_obj,
        type: 'POST',
        data: datos,
        success: function(data) {
          mostrar += data;
          parent.mostrarAlerta("success","Operación exitosa","El beneficiario se inactivo del grupo correctamente");
          $("#div-modal-activacion").modal('hide');
          $("#TX_Observacion").val("");
        },
        async: false
      });
      return mostrar;
    });

  ///**************************** ACTIVAR BENEFICIARIO DE LA DUPLA



  $("body").delegate("#BT-confirmar-activacion", "click", function(){
    event.stopPropagation();
    event.preventDefault();
    var mostrar = "";
    datos = {
      funcion: 'ActivarBeneficiario',
      p1: {
        'Id_Beneficiario_Activar': IdBeneficiarioSelected

      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Operación exitosa","El beneficiaro se activó nuevamente en el grupo seleccionado");
        $("#div-modal-activacion").modal('hide');
      },
      async: false
    });
    return mostrar;
  });

  /*--------------------------------------------------------------------------------------*/
  var tabla_beneficiarios_provisional = $("#tabla_beneficiarios_provisional").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    order: [[ 1, "asc" ]],
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
  /*-----------------Función para consultar los grupos-----------------------*/
  function consultarBeneficiariosDocumentoProvisional() {
    var mostrar = "";
    tabla_beneficiarios_provisional.clear().draw();
    var datos = {
      funcion: 'getBeneficiariosDocumentoProvisional'
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
      tabla_beneficiarios_provisional.rows.add($(data)).draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }

});
