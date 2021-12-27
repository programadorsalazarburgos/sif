var url_psicosocial = '../../src/Psicosocial/PsicosocialController/';
var url_grupo = '../../src/ArtistaFormador/RegistrarAsistenciaController/';
var url_beneficiario = '../../src/Beneficiario/BeneficiarioController/';
var origen = "";
var finalizado = 0;
var tabla_casos = "";
$(function(){
  $("#SL_crea").html(parent.getOptionsClanes()).selectpicker("refresh");
  var tabla_casos = $("#tabla_casos").DataTable({
    iDisplayLength: '10',
    "language": {
     "lengthMenu": "Ver _MENU_ registros por pagina",
     "zeroRecords": "No hay información, lo sentimos.",
     "info": "Mostrando pagina _PAGE_ de _PAGES_",
     "infoEmpty": "No hay registros disponibles",
     "infoFiltered": "(filtered from _MAX_ total records)",
     "search": "Filtrar"
   },
   dom: 'Bfrtip',
   buttons: [
   {
    extend: 'excel',
    exportOptions: {
      columns: ':visible' 
    },
    title: 'Casos Reportados'
  }
  ]
});

  $("#SL_crea").on("change", function (e) {
    $("#SL_Colegio").html(parent.getOptionsColegiosCrea($(this).val())).selectpicker("refresh");
  });

  $("#SL_Grupo").on("change", function (e) {
    $("#SL_Beneficiario").html(parent.getListadoTodosBeneficiariosGrupo($(this).val(), $("#SL_Grupo").find(':selected').data('tipo_grupo'))).selectpicker("refresh");
    if($("#SL_Grupo :selected").data("tipo_grupo") == "arte_escuela")
    {
     $("#SL_Colegio").val("").prop("disabled", false).selectpicker("refresh").trigger("change");
   }
   else
   {
    $("#SL_Colegio").val(0).prop("disabled", true).selectpicker("refresh").trigger("change");
  }
});

  $('#input-finalizado-1').on('change', function(e){
    e.preventDefault();
    if ($('#input-finalizado-1').is(":checked")){
      $("#label-state-finalizado-1").text("Finalizado");
      $(".required").attr('required', 'required');
      finalizado = 1;
    }
    else{
      $("#label-state-finalizado-1").text("Sin Finalizar");
      $(".required").removeAttr('required');
      finalizado = 0;
    }
  });

  $("#SL_Grupo").html(parent.getGruposDeUnUsuario(1)).selectpicker("refresh");

  $("#SL_Beneficiario").on("change", function (e) {
    if($(this).val() != 0){
      var datos = {
        p1: $("#SL_Beneficiario :selected").val(),
      }
      $.ajax({
        url: url_beneficiario+'consultarDatosBasicosEstudiante',
        type: 'POST',
        data: datos,
        dataType: 'json',
        async: false
      }).done(function(data){
        if(data != null){
          $("#TX_Primer_Nombre").val(data[0].VC_Primer_Nombre);
          $("#TX_Segundo_Nombre").val(data[0].VC_Segundo_Nombre);
          $("#TX_Primer_Apellido").val(data[0].VC_Primer_Apellido);
          $("#TX_Segundo_Apellido").val(data[0].VC_Segundo_Apellido);
          $("#TX_Fecha_Nacimiento").val(data[0].DD_F_Nacimiento);
          $("#SL_Tipo_Documento option").filter(function() { return $(this).text() == data[0].tipo_identificacion; }).prop('selected', true);
          $("#SL_Tipo_Documento").selectpicker("refresh");
          $("#TX_Documento").val(data[0].IN_Identificacion);
          $("#TX_Direccion").val(data[0].VC_Direccion);
        }
        else{
          parent.mostrarAlerta("error","Algo salió mal","No se logró cargar los salones");
        }
      }).fail(function(data){
        parent.mostrarAlerta("warning","Error","No se han podido listar los beneficiarios.");
        console.log(data);
      });
    }
    else{
      $("#TX_Primer_Nombre").val('');
      $("#TX_Segundo_Nombre").val('');
      $("#TX_Primer_Apellido").val('');
      $("#TX_Segundo_Apellido").val('');
      $("#TX_Fecha_Nacimiento").val('');
      $("#SL_Tipo_Documento").val('').selectpicker("refresh");
      $("#TX_Documento").val('');
      $("#TX_Barrio").val('');
      $("#TX_Direccion").val('');
      $("#SL_Localidad").val('').selectpicker("refresh");
    }
  });

  $("#SL_Grado").html(parent.getOptionsGrados()).selectpicker("refresh");
  $("#SL_Jornada").html(parent.getOptionParametroDetalle(11)).selectpicker("refresh");
  $("#SL_Tipo_Documento").html(parent.getOptionParametroDetalle(13)).selectpicker("refresh");
  $("#SL_Localidad").html(parent.getOptionParametroDetalle(19)).selectpicker("refresh");
  $("#SL_Parentesco").html(parent.getOptionParametroDetalle(49)).selectpicker("refresh");
  $("#SL_Year_Consulta").html(parent.getOptionParametroDetalle(7)).selectpicker("refresh");

  $("#SL_Colegio").on("change", function (e) {
    if($(this).val() === "0")
    {
      $("#SL_Grado").val(-100).prop("disabled",true).selectpicker("refresh");
      $("#SL_Jornada").val(100).prop("disabled",true).selectpicker("refresh");
    }
    else
    {
      $("#SL_Grado").val("").prop("disabled",false).selectpicker("refresh");
      $("#SL_Jornada").val("").prop("disabled",false).selectpicker("refresh");
    }
  });

  $(".origen").on('click', function(){
    origen = $(this).html();
  });

  $("#TX_Descripcion").summernote({
    height: 100,
    minHeight: null,
    maxHeight: null,
    placeholder: 'Detalle los hechos, tenga en cuenta que puede insertar videos e imagenes con CTRL+V ',
    lang: 'es-ES'
  });
  $('.btn-secondary').on('click', function(){
    $('.btn-secondary').removeClass('selected');
    $(this).addClass('selected');
  });

  $("body").delegate('.BT_EDITAR', 'click', function(){
    $(".modal-content").html($("#form_nuevo_reporte_de_caso").clone());
    $("#modal_editar_caso").modal('show');
  });

  $("#form_nuevo_reporte_de_caso").submit(function(e){
    e.preventDefault();
    
    var warning = "";
    json_datos = {};
    json_datos.datos = {
      estudiante: {
        colegio : $("#SL_Colegio selected").val(),
        grado : $("#SL_Grado selected").val(),
        jornada : $("#SL_Jornada selected").val(),
        primer_nombre : $("#TX_Primer_Nombre").val(),
        segundo_nombre : $("#TX_Segundo_Nombre").val(),
        primer_apellido : $("#TX_Primer_Apellido").val(),
        segundo_apellido : $("#TX_Segundo_Apellido").val(),
        fecha_nacimietno : $("#TX_Fecha_Nacimiento").val(),
        tipo_documento : $("#SL_Tipo_Documento selected").val(),
        identificacion : $("#TX_Documento").val(),
        barrio : $("#TX_Barrio").val(),
        direccion : $("#SL_Localidad selected").val()
      },
      acudiente: {
        parentesco : $("#SL_Parentesco selected").val(),
        nombre : $("#TX_Acudiente").val(),
        telefono : $("#TX_Telefono").val()
      }
    };
    
    if($('#input-finalizado-1').is(":checked") && $("#TX_Descripcion").val() == "")
      warning = "Debe describir los hechos. <br>(Numeral 5)";
    
    if($('#input-finalizado-1').is(":checked") && origen == "")
      warning = "Debe seleccionar un origen de la solicitud. <br>(Numeral 4)";

    if (warning != "") {
      parent.mostrarAlerta("warning", warning);
    }
    else {
      var datos = {
        p1: {
          "FK_Beneficiario": $("#SL_Beneficiario").val(),
          "FK_Crea": $("#SL_crea").val(),
          "TX_Linea_Atencion": $("#SL_Grupo :selected").data("tipo_grupo"),
          "FK_Grupo": $("#SL_Grupo").val(),
          "TX_Datos": JSON.stringify(json_datos),
          "TX_Origen_Reporte": origen,
          "TX_Descripcion_Hechos": $("#TX_Descripcion").val(),
          "FK_Usuario_Registro" : parent.idUsuario,
          "IN_Finalizado": finalizado
        }
      }
      $.ajax({
        url: url_psicosocial+'saveReporteCaso',
        type: 'POST',
        data: datos,
        async: false
      }).done(function(data){
        if(data == 1){
          if (finalizado == 1) { 
            var notificacion = { 
              vc_url:"Psicosocial/ReporteCasos.php#panel_consultar",
              vc_icon:"fa fa-list-alt",
              vc_contenido: 'Nuevo Caso registrado para el Beneficiario <strong>'+$("#TX_Primer_Nombre").val()+' '+$("#TX_Primer_Apellido").val()+'</strong> del '+$("#SL_crea :selected").text()
            }
            window.parent.sendNotificationRole(notificacion,'27');
          }
          parent.mostrarAlerta("success","Reporte Guardado","Se ha guardado el reporte");
          $("#form_nuevo_reporte_de_caso")[0].reset();
          $("#TX_Descripcion").summernote('code', '');
          $(".origen").removeClass('selected');
          origen = "";
          $(".selectpicker").selectpicker('refresh');
        }else{
          parent.mostrarAlerta("warning","Al parecer ha ocurrido un error","Verifique la consulta de Casos Reportados para confirmar que se haya guardado el reporte. De lo contrario contacte al equipo de soporte SIF.")
        }
      }).fail(function(data){
        parent.mostrarAlerta("warning","Error","No se ha podido guardar el reporte.");
        console.log(data);
      });
    }
  });

  $("#SL_Year_Consulta").on('change', function(){
    var datos = {
      p1: {
       'year': $(this).val() 
     }
   }
   $.ajax({
    url: url_psicosocial+'consultarCasosReportados',
    type: 'POST',
    data: datos,
    dataType: 'html',
    async: false
  }).done(function(data){
    if(data != null){
      tabla_casos.clear().draw();
      tabla_casos.rows.add($(data)).draw();
    }
    else{
      parent.mostrarAlerta("error","Algo salió mal","No se logró cargar la información");
    }
  }).fail(function(data){
    parent.mostrarAlerta("warning","Error","No se han podido listar los Casos Reportados.");
    console.log(data);
  });
});

});
