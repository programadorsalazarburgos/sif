var url_ok_obj = '../../../src/Territorial/Controlador/AdministrarLugaresController.php';
var url_ben = '../../../src/Beneficiarios/Controlador/RegistroBeneficiariosController.php';
var url_aten = '../../../src/CirculacionNidos/Controlador/AtencionesVirtualesController.php';

$(document).ready(function(){
  getInfoFormulario();

  /**
   * [getInfoFormulario Función que obtiene el estado e información del formulario]
   * @return {[json]} [Información del formulario]
   */
   function getInfoFormulario(){
    var datos = {
      funcion: 'getInfoFormulario',
      p1: $("#TX_Formulario").val()
    };

    $.ajax({
      url: url_aten,
      type: "POST",
      data: datos,
      dataType: 'json',
      success: function(data){
        if(data["IN_Estado"] == 0){
          $(".form").empty();
          $("#div_info_formulario_cerrado").html("").html(data["VC_Contenido_Cerrado"])
        }
      },
      async: false
    });
  }

  /**
   * [Cargue de listados: Entidad, tipo atención, tipo documento yenfoque]
   */
   if($("#TX_Formulario").val() == 2 || $("#TX_Formulario").val() == 3)
    $("#SL_Entidad").html(getOptionsEntidades()).selectpicker("refresh");
  
  $("#SL_Tipo_Atencion").html(getTiposAtencionDisponible()).selectpicker("refresh");
  $("#SL_Tipo_Doc_Cuidador").html(getTipoDocumento()).selectpicker("refresh");
  $("#SL_Tipo_Doc_Beneficiario").html(getTipoDocumento()).selectpicker("refresh");
  $("#SL_Enf_Beneficiario").html(getEtnia()).selectpicker("refresh");

  $("#SL_Tipo_Atencion").change(function() {
    $("#SL_Horario_Atencion").html(getHorarios()).selectpicker("refresh");
  }).selectpicker("refresh");

  $("#SL_Localidad_Cuidador").on('change', function() {
    if($(this).val() == '21'){
      $("#TX_Otro").attr("disabled", false);
    }else{
      if($("#TX_Otro").val() != ""){
        $("#TX_Otro").val("");
      }
      $("#TX_Otro").attr("disabled", true);
    }
  });

  /**
   * [Conversión de letras a mayúscula para campos tipo texto]
   */
   $(".mayuscula").keyup(function() {
    $(this).val($(this).val().toUpperCase());
  });

  /**
   * [getTiposAtencionDisponible Función que obtiene el listado de opciones de los tipos de atención]
   * @return {[select]} [Opciones de tipos de atención disponibles]
   */
   function getTiposAtencionDisponible(){
    var mostrar = "";
    var datos = {
      funcion: 'getTiposAtencionDisponible',
      p1: $("#TX_Formulario").val()
    };
    $.ajax({
      url: url_aten,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    });
    return mostrar;
  }

  /**
   * [getTipoDocumento Función que obtiene el listado de los tipos de documento]
   * @return {[select]} [Opciones de tipos de documento disponibles]
   */
   function getTipoDocumento() {
    var mostrar = "";
    var datos = {
      funcion: 'getTipoDocumento'
    };
    $.ajax({
      url: url_ben,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    });
    return mostrar;
  }

  /**
   * [getEtnia Función que obtiene el listado de los tipos de enfoque]
   * @return {[select]} [Opciones de tipos de enfoque disponibles]
   */
   function getEtnia() {
    var mostrar = "";
    var datos = {
      funcion: 'getEtnia'
    };
    $.ajax({
      url: url_ben,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
      },
      async: false
    });
    return mostrar;
  }

  /**
   * [getEtnia Función que obtiene el listado de los tipos de entidades]
   * @return {[select]} [Opciones de tipos de entidades disponibles]
   */
   function getOptionsEntidades() {
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

  $("input[type='radio']").on("change", function(){
    if($(this).attr("id") == "RB_Atendido_Si"){
      $("#div-busqueda").show();
      $("#Informacion_Basica").hide();
      $("#Informacion_ninos").hide();
      $("#Informacion_atencion").hide();
    }
    if($(this).attr("id") == "RB_Atendido_No"){
      limpiarFormulario(0);
      $("#Informacion_Basica").show();
      $("#div-busqueda").hide();
    }
  });

  $("#BTN_Buscar").on("click", function(){
    consultarAtencionPrevia();
  });

  /**
   * [guardarSolicitud Función que guarda la información del formulario]
   * @return {[Bool]} [1 si guarda, 0 sino guarda]
   */
   function guardarSolicitud(){
     var datos = {
      funcion: 'guardarSolicitud',
      p1: {
        "TX_Nombre_Cuidador" : $("#TX_Nombre_Cuidador").val(),
        "TX_Correo_Cuidador" : $("#TX_Correo_Cuidador").val(),
        "SL_Tipo_Doc_Cuidador" : $("#SL_Tipo_Doc_Cuidador").val(),
        "TX_Identificacion_Cuidador" : $("#TX_Identificacion_Cuidador").val(),
        "SL_Localidad_Cuidador" : $("#SL_Localidad_Cuidador").val(),
        "TX_Otro" : $("#TX_Otro").val(),
        "TX_Barrio_Cuidador" : $("#TX_Barrio_Cuidador").val(),
        "TX_Direccion_Cuidador" : $("#TX_Direccion_Cuidador").val(),
        "SL_Estrato_Cuidador" : $("#SL_Estrato_Cuidador").val(),
        "TX_Edad_Cuidador" : $("#TX_Edad_Cuidador").val(),
        "SL_Dirigida" : $("#SL_Dirigida").val(),
        "SL_Parentesco" : $("#SL_Parentesco").val(),
        "SL_Potestad" : $("#SL_Potestad").val(),
        "TX_Nombres_Beneficiario" : $("#TX_Nombres_Beneficiario").val(),
        "TX_Apellidos_Beneficiario" : $("#TX_Apellidos_Beneficiario").val(),
        "SL_Tipo_Doc_Beneficiario" : $("#SL_Tipo_Doc_Beneficiario").val(),
        "TX_Identificacion_Beneficiario" : $("#TX_Identificacion_Beneficiario").val(),
        "TX_Fec_Nac_Beneneficiario" : $("#TX_Fec_Nac_Beneneficiario").val(),
        "SL_Edad_Beneficiario" : $("#SL_Edad_Beneficiario").val(),
        "TX_Institucion": $("#TX_Institucion").val(),
        "SL_Entidad": $("#SL_Entidad").val(),
        "TX_Celular" : $("#TX_Celular").val(),
        "SL_Tipo_Atencion" : $("#SL_Tipo_Atencion").val(),
        "SL_Horario_Atencion" : $("#SL_Horario_Atencion").val(),
        "TX_Comentario" : $("#TX_Comentario").val(),
        "TX_Formulario" : $("#TX_Formulario").val(),
        "SL_Enf_Beneficiario": $("#SL_Enf_Beneficiario").val()
      }
    };

    // if($("#SL_Enf_Beneficiario").val() == ""){
    //   datos["p1"]["SL_Enf_Beneficiario"] = null;
    // }else{
    //   ids = "";
    //   $("#SL_Enf_Beneficiario :selected").each(function(i, selected) {
    //     ids += $(selected).val() + ",";
    //   });
    //   ids = ids.slice(0,-1);
    //   datos["p1"]["SL_Enf_Beneficiario"] = ids;
    // }

    datos["p1"]["RB_Autorizacion"] = $("#RB_Aceptado").is(':checked') == true ? 1 : 0;

    $.ajax({
      url: url_aten,
      type: "POST",
      data: datos,
      dataType: 'json',
      success: function(data){
        if(data == 1){
          parent.swal({
            confirmButtonColor: '#3f9a9d',
            title: 'Operación exitosa!',
            html: '<small>La solicitud se ha guardado exitosamente</small>',
            type: 'success',
            confirmButtonText: 'Aceptar',
          }).then(() => {
            limpiarFormulario(1);
          }).catch(parent.swal.noop);
        }else{
          swal("Error!", "No se ha podido guardar la información, por favor vuelva a intentarlo", "error");
        }
      },
      async: false
    });
  }

  /**
   * [Validación del formulario]
   */
   $(".form").submit(function(e){
    e.preventDefault();
    guardarSolicitud();
  });

  /**
   * [limpiarFormulario Función que limpia el formulario]
   * @param  {Number} guardar [1 para resetear todo los input radio, 0 no resetea los input radio]
   */
   function limpiarFormulario(guardar){
    $("#Informacion_Basica").hide();
    $("#Informacion_ninos").hide();
    $("#Informacion_atencion").hide();
    $("#Informacion_potestaNo").hide();
    $("#Informacion_potestaSi").hide();

    if(guardar == 1)
      $("input[type=radio]").prop("checked", false);

    $('.form :input').val("");
    $("#SL_Tipo_Atencion").html(getTiposAtencionDisponible()).selectpicker("refresh");
    $(".selectpicker").selectpicker("refresh");
  }

  /**
   * [consultarAtencionPrevia Función que obtiene los datos de una atención previa]
   * @return {[json]} [Datos de la atención previas]
   */
   function consultarAtencionPrevia(){
    var datos = {
      funcion: 'consultarAtencionPrevia',
      "p1" : $("#TX_Busqueda").val()
    };
    $.ajax({
      url: url_aten,
      type: "POST",
      data: datos,
      dataType: 'json',
      success: function(data){
        if(data.length >= 1){
          parent.swal({
            confirmButtonColor: '#3f9a9d',
            title: 'Exito!',
            html: '<small>Beneficiario encontrado, se cargará toda la información</small>',
            type: 'success',
            confirmButtonText: 'Aceptar',
          }).then(() => {
            precargarDatosAtencion(data);
          }).catch(parent.swal.noop);
        }else{
         parent.swal("Error!", "No se ha encontrado información con el número de documento diligenciado.", "error");
       }
     },
     async: false
   });
  }

  /**
   * [precargarDatosAtencion Función que pinta la información de una atención previa en el formulario]
   * @param  {[json]} datos [Datos en forrmato json]
   */
   function precargarDatosAtencion(datos){
    $("#div-busqueda").hide();
    $("#Informacion_Basica").show();
    $("#TX_Nombre_Cuidador").val(datos["0"]["VC_Nombre_Cuidador"]);
    $("#TX_Correo_Cuidador").val(datos["0"]["VC_Correo"]);
    $("#SL_Tipo_Doc_Cuidador").val(datos["0"]["IN_Tipo_Doc_Cuidador"]).selectpicker('refresh').trigger('change');
    $("#TX_Identificacion_Cuidador").val(datos["0"]["IN_Identificacion_Cuidador"]);
    $("#SL_Localidad_Cuidador").val(datos["0"]["IN_Localidad"]).selectpicker('refresh').trigger('change');
    $("#TX_Otro").val(datos["0"]["VC_Otro_Lugar"]);
    $("#TX_Barrio_Cuidador").val(datos["0"]["VC_Barrio"]);
    $("#TX_Direccion_Cuidador").val(datos["0"]["VC_Direccion"]);
    $("#SL_Estrato_Cuidador").val(datos["0"]["IN_Estrato"]).selectpicker('refresh').trigger('change');
    $("#TX_Edad_Cuidador").val(datos["0"]["VC_Edad_Cuidador"]);
    $("#SL_Dirigida").val(datos["0"]["IN_Dirigida_Atencion"]).selectpicker('refresh').trigger('change');

    if(datos["0"]["IN_Dirigida_Atencion"] == 2 || datos["0"]["IN_Dirigida_Atencion"] == 3){
      $("#Informacion_ninos").show();

      $("#TX_Nombres_Beneficiario").val(datos["0"]["VC_Nombres"]);
      $("#TX_Apellidos_Beneficiario").val(datos["0"]["VC_Apellidos"]);
      $("#SL_Parentesco").val(datos["0"]["IN_Parentesco"]).selectpicker('refresh').trigger('change');
      $("#SL_Potestad").val(datos["0"]["IN_Potestad"]).selectpicker('refresh').trigger('change');
      $("#SL_Enf_Beneficiario").selectpicker("val", datos["0"]["VC_Grupo_Poblacional"]);

      if(datos["0"]["IN_Potestad"] == 1){
        $("#Informacion_potestaSi").show()
        $("#div-check-si").show();
        $("#TX_Fec_Nac_Beneneficiario").val(datos["0"]["DD_F_Nacimiento"]);
        $("#SL_Tipo_Doc_Beneficiario").val(datos["0"]["FK_Tipo_Identificacion"]).selectpicker('refresh').trigger('change');
        $("#TX_Identificacion_Beneficiario").val(datos["0"]["VC_Identificacion"]);
        //$("#SL_Enf_Beneficiario").val(datos["0"]["VC_Grupo_Poblacional"]).selectpicker('val', datos["0"]["VC_Grupo_Poblacional"].split(',').map(Number));
      }else{
        $("#Informacion_potestaNo").show()
        $("#div-check-no").show();
        $("#SL_Edad_Beneficiario").val(datos["0"]["VC_Edad_Beneficiario"]).selectpicker('refresh').trigger('change');
      }
    }

    $("#Informacion_atencion").show();

    if($("#TX_Formulario").val() == 2 || $("#TX_Formulario").val() == 3){
      $("#TX_Institucion").val(datos["0"]["VC_Institucion"]);
      $("#SL_Entidad").val(datos["0"]["VC_Entidad"]).selectpicker('refresh').trigger('change');
    }

    $("#TX_Celular").val(datos["0"]["VC_Telefono"]);
    $("#TX_Comentario").val(datos["0"]["VC_Comentarios"]);
  }

  /**
   * [getHorarios Función que obtiene el listado de horarios según el tipo de atención seleccionada]
   * @return {[select]} [Opciones de horarios disponibles]
   */
   function getHorarios(){
    var mostrar = "";
    var datos = {
      funcion: 'getHorarios',
      p1: $("#TX_Formulario").val(),
      p2: $("#SL_Tipo_Atencion").val()
    };
    $.ajax({
      url: url_aten,
      type: "POST",
      data: datos,
      dataType: 'html',
      success: function(data){
        mostrar += data;
      },
      async: false
    });
    return mostrar;
  }

  /**
   * [Mostrado y ocultamiento de secciones dependiendo hacia quien se dirija la atención]
   */
   $("#SL_Dirigida").on("change", function(){
    posicion = window.innerHeight > 657 ? 350 : 600;
    $("html, body").animate({
      scrollTop: posicion
    }, 1000);
    if($(this).val() == 1){
      $("#Informacion_ninos").hide();
      $("#Informacion_ninos :input").attr("required", false);
      $("#Informacion_ninos .selectpicker").attr("required", false);
    }
    if($(this).val() == 2 || $(this).val() == 3){
      $("#Informacion_ninos").show();
      $("#SL_Parentesco").attr("required", true);
      $("#SL_Potestad").attr("required", true);
      $("#TX_Nombres_Beneficiario").attr("required", true);
      $("#TX_Apellidos_Beneficiario").attr("required", true);
      $("#SL_Enf_Beneficiario").attr("required", true);
    }
    $("#Informacion_atencion").show();
  });
  /**
   * [Mostrado y ocultamiento de sección patria potestad dependiendo si se tiene o no]
   */
   $("#SL_Potestad").on("change", function(){
    if($(this).val() == 1){
      $("#div-check-si").show();
      $("#div-check-no").hide();
      $("#Informacion_potestaNo").show();
      $("#Informacion_potestaSi").show();
      $("#TX_Fec_Nac_Beneneficiario").attr("required", true);
      $("#SL_Tipo_Doc_Beneficiario").attr("required", true);
      $("#TX_Identificacion_Beneficiario").attr("required", true);
    }
    if($(this).val() == 0){
      $("#div-check-si").hide();
      $("#div-check-no").show();
      $("#Informacion_potestaNo").show();
      $("#Informacion_potestaSi").hide();
      $("#TX_Fec_Nac_Beneneficiario").attr("required", false);
      $("#SL_Tipo_Doc_Beneficiario").attr("required", false);
      $("#TX_Identificacion_Beneficiario").attr("required", false);
      $("#SL_Edad_Beneficiario").attr("required", true);
    }
  });
 });
