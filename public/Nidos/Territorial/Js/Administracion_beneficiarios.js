var url_ok_obj = '../../../src/Beneficiarios/Controlador/RegistroBeneficiariosController.php'; 
var id_beneficiario;
$(document).ready(function() {

  $("body").delegate(".mayuscula", "keyup", function(){
    $(this).val($(this).val().toUpperCase());
  });

  $(".regresar").click(function(){
    $("#info_basica").show();
    $("#info_detallada").hide();
    $("#div-info-historico").hide();
  });

  $("body").delegate("#TX_F_Nacimiento", "focus", function() {
    $("#TX_F_Nacimiento").datepicker({
      format: 'yyyy-mm-dd',
      language: 'es',
      autoclose: true,
      endDate: '+0d',
      startDate: '1950-01-01'
    });
  });


  $("#BT_Buscar_Beneficiario").click(function(e){
    e.preventDefault();
    getDatosBasicosBeneficiarios();
    $("#info_detallada").hide("");
  });


  $("#table_datos_basicos").delegate( ".modificar", "click", function() {
    $("#info_basica").hide("slow");
    $("#info_detallada").show("slow");
    $("#SL_Tipo_Documento").html(getTipoDocumento()).selectpicker("refresh");
    $("#SL_Genero").html(getGenero()).selectpicker("refresh");
    $("#SL_Etnia").html(getEtnia()).selectpicker("refresh");
    $("#SL_Ip").html(getTPoblacional()).selectpicker("refresh");
    id_beneficiario = $(this).data("id-beneficiario");
    getDatosDetalladosBeneficiario(id_beneficiario);
  });

  $("#table_datos_basicos").on("click", ".historico", function() {
    $("#div-p-historico").empty();
    $("#info_basica").hide("slow");
    $("#div-info-historico").show("slow");
    var row = table_datos_basicos.row( $(this).parents('tr') ).data();
    $("#div-p-historico").append("Histórico de grupos beneficiario<br><strong>"+$(row[1]).text()+"</strong>");
    id_beneficiario = $(this).data("id-beneficiario");
    consultarGruposBeneficiario(id_beneficiario);
  });

  $("#table_datos_basicos").on("click", ".subir-imagen", function() {
    if($(this).closest("td").find(".TX_Uso_Imagen").val() == ""){
      parent.swal("Advertencia", "Por favor seleccione un archivo", "warning");
    }else{
      if($(this).closest("td").find(".TX_Uso_Imagen")[0].files[0].size > 5242880){
        parent.swal("Advertencia", "El archivo no puede pesar más de 5MB", "warning");
      }else{
       var archivo = $(this).closest("td").find(".TX_Uso_Imagen")[0].files[0];
       subirUsoImagen($(this).data("id-beneficiario"), archivo);
     }
   }
 });

  $("#table_datos_basicos").on("click", ".borrar", function() { 
    parent.swal({
      confirmButtonColor: '#3f9a9d',
      title: 'Eliminar uso de imagen',
      html: '<small>¿Está seguro de que quiere eliminar el documento de <strong>'+table_datos_basicos.row( $(this).parents('tr') ).data()[1].replace("<center>", "")+'</strong>?</small>',
      type: 'warning',
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
      showCancelButton: true, 
      width: 800,
    }).then(() => {
      borrarArchivo($(this).data("id-beneficiario"));
    },(confirm) => {
      if (confirm == "cancel"){
      }
    }).catch(parent.swal.noop);
  });

  var table_datos_basicos = $("#table_datos_basicos").DataTable({
    autoWidth: false,
    responsive: true,
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

  var tabla_historico = $("#tabla-historico").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    info: false,
    "language": {
      "lengthMenu": "Ver _MENU_ registros por página",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
      "search": "Filtrar"
    },
  });

  function borrarArchivo(id_beneficiario){
    datos = {
      'funcion': 'borrarArchivo',
      'p1': id_beneficiario
    };

    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
      success: function(data){
        if(data == 1){
          parent.swal({
            confirmButtonColor: '#3f9a9d',
            title: 'Operación exitosa',
            html: '<small>Se ha eliminado el documento correctamente</small>',
            type: 'success',
            confirmButtonText: 'Aceptar', 
            width: 800,
          }).then(() => {
            getDatosBasicosBeneficiarios();
          });
        }
        else
          parent.swal("Error","No se ha podido elimiar documento, por favor vuelva a intentarlo","danger");
      },
      fail: function(data){
      },
    });

  }

  function subirUsoImagen(id_beneficiario, archivo){
    var datos = new FormData();
    datos.append('funcion', 'subirUsoImagen');
    datos.append("p1", id_beneficiario);  
    datos.append("p3", archivo);

    $.ajax({
      url: url_ok_obj,
      contentType: false,
      processData: false,
      type: 'POST',
      data: datos,
      async: false,
      success: function(data){
        if(data == 1){
          parent.swal({
            confirmButtonColor: '#3f9a9d',
            title: 'Operación exitosa',
            html: '<small>Se ha subido el documento correctamente</small>',
            type: 'success',
            confirmButtonText: 'Aceptar', 
            width: 800,
          }).then(() => {
            getDatosBasicosBeneficiarios();
          });
        }
        else
          parent.swal("Error","No se ha podido subir el documento, por favor vuelva a intentarlo","danger");

      },
      fail: function(data){
      },
    });
  }

  function consultarGruposBeneficiario(id_beneficiario){
    tabla_historico.clear().draw();
    datos = {
      'funcion': 'getGruposBeneficiario',
      'p1': id_beneficiario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
    }).done(function(data){
      datos = $.parseJSON(data);
      for(i=0; i<Object.keys(datos).length; i++){
        var rowNode = tabla_historico.row.add([
          "<center>"+datos[i]["LOCALIDAD"]+"</center>",
          "<center>"+datos[i]["LUGAR"]+"</center>",
          "<center>"+datos[i]["GRUPO"]+"</center>",
          "<center>"+datos[i]["TIPO_GRUPO"]+"</center>",
          "<center>"+datos[i]["DUPLA"]+"</center>",
          "<center>"+datos[i]["FECHA"]+"</center>",
          "<center>"+datos[i]["ASISTENCIA"]+"</center>",
          ]).draw().node();
      }
    });
  }

  function getDatosBasicosBeneficiarios() {
    parent.mostrarCargando("Por favor espere, estamos cargando los datos de los beneficiarios");
    table_datos_basicos.clear().draw();
    var datos = {
      funcion: 'getDatosBasicosBeneficiarios',
      'p1': $("#TX_Busqueda_Beneficiario").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: true
    }).done(function(data) {
      $("#info_basica").show();
      table_datos_basicos.rows.add($(data)).draw();
      $(".TX_Uso_Imagen").filestyle({
        htmlIcon: '<i class="fas fa-folder-open"></i>',
        placeholder: "Seleccione un archivo",
        btnClass: "btn-primary",
        badge: true,
        text: "",
      });
      parent.cerrarCargando();
    }).fail(function(data) {
      parent.swal("Error", "No se han podido cargar los datos de la tabla", "error");
    });
  }
  function getDatosDetalladosBeneficiario(id_beneficiario){
    var datos = {
      funcion: 'getDatosDetalladosBeneficiario',
      'p1': id_beneficiario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        $("#TX_Identificacion").val(id_beneficiario);
        datos = $.parseJSON(data);
        $("#SL_Tipo_Documento").val(datos['FK_Tipo_Identificacion']).selectpicker('refresh').trigger('change');
        $("#TX_P_Nombre").val(datos['VC_Primer_Nombre']);
        $("#TX_S_Nombre").val(datos['VC_Segundo_Nombre']);
        $("#TX_P_Apellido").val(datos['VC_Primer_Apellido']);
        $("#TX_S_Apellido").val(datos['VC_Segundo_Apellido']);
        $("#TX_F_Nacimiento").val(datos['DD_F_Nacimiento']);
        $("#SL_Genero").val(datos['FK_Id_Genero']).selectpicker('refresh').trigger('change');
        $("#SL_Etnia").val(datos['IN_Grupo_Poblacional']).selectpicker('refresh').trigger('change');
        $("#SL_Ip").val(datos['IN_Estrato']).selectpicker('refresh').trigger('change');
      },
      async: false
    });
  }

  function modificarDatosBeneficiario(){
    var datos = {
      funcion: 'crearBeneficiarioNidos',
      p1: {
        'identificacion': id_beneficiario,
        'tipo_identifi': $("#SL_Tipo_Documento").val(),
        'p_nombre': $("#TX_P_Nombre").val(),
        's_nombre': $("#TX_S_Nombre").val(),
        'p_apellido': $("#TX_P_Apellido").val(),
        's_apellido': $("#TX_S_Apellido").val(),
        'f_nacimiento': $("#TX_F_Nacimiento").val(),
        'genero': $("#SL_Genero").val(),
        'etnia': $("#SL_Etnia").val(),
        'i_poblacional': $("#SL_Ip").val(),
        'existe': 1
      },
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.swal("Operación Exitosa", "Se ha modificado correctamente la información del beneficiario", "success");
        $("#info_detallada").hide("fast");
        $("#SL_Tipo_Documento").val("");
        $("#TX_P_Nombre").val("");
        $("#TX_S_Nombre").val("");
        $("#TX_P_Apellido").val("");
        $("#TX_S_Apellido").val("");
        $("#TX_F_Nacimiento").val("");
        $("#SL_Genero").val("");
        $("#SL_Etnia").val("");
        $("#SL_Ip").val("");
      },
      fail: function(data){
        console.log(data);
      },
      async: false
    });
  }

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
        mostrar+=data;
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
        mostrar+=data;
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
        mostrar+=data;
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
        mostrar+=data;
      },
      async: false
    });
    return mostrar;
  }

  var characterRegex = /([a-zA-ZñÑ\s])$/;
  //var characterRegex = /([a-zA-Z])$/;
  $.validator.addMethod("validCharacter", function( value, element ) {
    return this.optional( element ) || characterRegex.test( value );
  });

  $("#form_modificar_beneficiario").validate({
    rules:{
      TX_P_Nombre:{
        required: true,
        validCharacter: true,
        minlength: 3
      },
      TX_S_Nombre:{
        validCharacter: true,
      },
      TX_P_Apellido:{
        required: true,
        validCharacter: true,
        minlength: 3
      },
      TX_S_Apellido:{
        validCharacter: true,
      },
      TX_F_Nacimiento:{
        required: true
      }
    },
    messages:{
      TX_P_Nombre:{
        required: 'Por favor ingrese el nombre',
        validCharacter: 'El nombre no puede contener números ni caracteres especiales',
        minlength: 'El nombre debe contener al menos 3 caracteres'
      },
      TX_S_Nombre:{
        validCharacter: 'El nombre no puede contener números ni caracteres especiales',
      },
      TX_P_Apellido:{
        required: 'Por favor ingrese el apellido',
        validCharacter: 'El apellido no puede contener números ni caracteres especiales',
        minlength: 'El nombre debe contener al menos 3 caracteres'
      },
      TX_S_Apellido:{
        validCharacter: 'El nombre no puede contener números ni caracteres especiales',
      },
      TX_F_Nacimiento:{
        required: 'Por favor seleccione una fecha de nacimiento',
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
      modificarDatosBeneficiario();
    },
  });


});
