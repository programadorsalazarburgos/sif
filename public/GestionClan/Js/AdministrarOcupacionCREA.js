var url_ok_obj = '../../src/GestionClan/GestionClanController/';
$(function(){
  $("#SL_crea").html(parent.getOptionsClanes()).selectpicker("refresh");
  $("#SL_mes_reporte_ocupacion").html(parent.getOptionsParametroDetalle(8)).selectpicker("refresh");
  $("#SL_anio_reporte_ocupacion").html(parent.getOptionsParametroDetalle(7)).selectpicker("refresh");
  var table_ocupaciones = $("#table_ocupaciones").DataTable({
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
    title: 'Ocupaciones del CREA'
  }
  ]
});

  var hoy = new Date();
  var ini = new Date(hoy.setDate(hoy.getDate()+10));
  ini.setHours(0);
  $('#TX_fecha_hora_inicio').datetimepicker({
    autoclose: true,
    minuteStep: 10,
    weekStart: 1,
    //startDate: '+9d'
    //startDate: ini
  });
  $('#TX_fecha_hora_fin').datetimepicker({
    autoclose:true,
    minuteStep: 10,
    weekStart:1,
    //startDate: '+9d'
    //startDate: ini
  });

  $('#TX_fecha_hora_inicio_modificar').datetimepicker({
    autoclose: true,
    minuteStep: 10,
    weekStart: 1,
    //startDate: '+9d'
    //startDate: ini
  });
  $('#TX_fecha_hora_fin_modificar').datetimepicker({
    autoclose:true,
    minuteStep: 10,
    weekStart:1,
    //startDate: '+9d'
    //startDate: ini
  });
  $("#TX_fecha_hora_inicio").on("change", function (e) {
    $("#TX_fecha_hora_fin input").val("");
    $("#TX_fecha_hora_fin").datetimepicker("setStartDate",$("#TX_fecha_hora_inicio input").val());
  });

  $("#TX_fecha_hora_fin").on("change", function (e) {
    $("#TX_fecha_hora_inicio").datetimepicker("setEndDate",$("#TX_fecha_hora_fin input").val());
  });

  $("#SL_crea").on("change", function (e) {
    $("#SL_salones").html('');
    var datos = {
      p1: $(this).val()
    }
    $.ajax({
      url: url_ok_obj+'getSalonesCrea',
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data){
      if(data != null){
        $("#SL_salones").html(data).selectpicker('refresh');
      }
      else{
        parent.mostrarAlerta("error","Algo salió mal","No se logró cargar los salones");
      }
    }).fail(function(data){
      parent.mostrarAlerta("warning","Error","No se han podido listar los salones.");
      console.log(data);
    });
  });

  $("#form_nuevo_registro_ocupacion").submit(function(e){
    e.preventDefault();
    var datos = {
      p1: {
        "id_usuario" : parent.IdUsuario,
        "nombre_actividad" : $("#TX_nombre_actividad").val(),
        "descripcion_actividad" : $("#TX_descripcion_actividad").val(),
        "responsable_actividad" : $("#TX_responsable").val(),
        "numero_asistentes" : $("#IN_total_asistentes").val(),
        "fecha_hora_inicio" : $("#TX_fecha_hora_inicio").val(),
        "fecha_hora_fin" : $("#TX_fecha_hora_fin").val(),
        "id_crea" : $("#SL_crea").val(),
        "salones" : $("#SL_salones").val().join()
      }
    }
    $.ajax({
      url: url_ok_obj+'crearRegistroOcupacionCREA',
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data){
      if(data == 1){
        parent.mostrarAlerta("success","Ocupación Guardada","Se ha registrado la nueva ocupación correctamente");
        $("#form_nuevo_registro_ocupacion")[0].reset();
      }else{
        parent.mostrarAlerta("warning","Al parecer ha ocurrido un error","Verifique la consulta de ocupaciones del CREA para confirmar que se guardo correctamente la ocupación. De lo contrario contactese con el equipo de soporte SIF.")
      }
    }).fail(function(data){
      parent.mostrarAlerta("warning","Error","No se ha podido crear el registro de asignacion.");
      console.log(data);
    });
  });

  $("#nav_modificar_ocupacion").click(function(){
    $("#SL_salones_modificar").html('').selectpicker('refresh');
    $("#SL_ocupacion_modificar").html('').selectpicker('refresh');
    $("#SL_crea_modificar_ocupacion").html(parent.getOptionsClanes()).selectpicker("refresh");    
  });

  $("#SL_crea_modificar_ocupacion").on("change",function(){
    var datos = {
      p1: $(this).val()
    }
    $.ajax({
      url: url_ok_obj+'consultarRegistrosOcupacionCREA',
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data){
      try{
        var option = "";
        data = $.parseJSON(data);
        for (var i = 0; i < data.length; i++) {
          option += "<option value='" + data[i]['id'] + "' data-nombre_actividad='" + data[i]['TX_nombre_actividad'] + "' data-descripcion_actividad='" + data[i]['TX_descripcion'] + "' data-responsable_actividad='" + data[i]['TX_responsable'] + "' data-total_asistentes='" + data[i]['IN_asistentes'] + "' data-salones='" + data[i]['FK_Salones'] + "' data-fecha_hora_inicio='" + data[i]['DT_fecha_hora_inicio'] + "'  data-fecha_hora_fin='" + data[i]['DT_fecha_hora_fin'] + "'>" + data[i]['TX_nombre_actividad'] + " en la fecha hora (" +  data[i]['DT_fecha_hora_inicio'] + ")</option>";
        }
        $("#form_modificar_registro_ocupacion")[0].reset();
        $("#SL_ocupacion_modificar").html(option).selectpicker("refresh");
      }catch(ex){
        parent.mostrarAlerta("warning","Error decodificando JSON","No se ha podido extraer la información de las ocupaciones registradas en el CREA");
        console.log("Excepcion: " + ex + data);
      }
    }).fail(function(data){
      parent.mostrarAlerta("warning","Error","No se ha podido consultar los registros de asignacion.");
      console.log(data);
    });
    $.ajax({
      url: url_ok_obj+'getSalonesCrea',
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data){
      if(data != null){
        $("#SL_salones_modificar").html(data).selectpicker('refresh');
      }
      else{
        parent.mostrarAlerta("error","Algo salió mal","No se logró cargar los salones");
      }
    }).fail(function(data){
      parent.mostrarAlerta("warning","Error","No se han podido listar los salones.");
      console.log(data);
    });
  });

  $("#SL_ocupacion_modificar").change(function(){
    $("#TX_nombre_actividad_modificar").val($(this).find(':selected').data("nombre_actividad"));
    $("#TX_descripcion_actividad_modificar").text($(this).find(':selected').data("descripcion_actividad"));
    $("#TX_responsable_modificar").val($(this).find(':selected').data("responsable_actividad"));
    $("#IN_total_asistentes_modificar").val($(this).find(':selected').data("total_asistentes"));
    $("#TX_fecha_hora_inicio_modificar").val($(this).find(':selected').data("fecha_hora_inicio"));
    $("#TX_fecha_hora_fin_modificar").val($(this).find(':selected').data("fecha_hora_fin"));
    var salones = $(this).find(':selected').data("salones");
    $("#SL_salones_modificar").selectpicker('reset');
    $("#SL_salones_modificar").val('default').selectpicker('refresh');
    if(salones.length > 1){
      var array_salones = salones.split(',');
      $.each(array_salones,function(index,value){
        $("#SL_salones_modificar option").filter(function() { return $(this).val() == value }).prop('selected', true);
        $("#SL_salones_modificar").selectpicker('refresh');
      });
    }
    else{
      $("#SL_salones_modificar option").filter(function() { return $(this).val() == salones }).prop('selected', true);
      $("#SL_salones_modificar").selectpicker('refresh');
    }
  });

  $("#form_modificar_registro_ocupacion").submit(function(e){
    e.preventDefault();
    var datos = {
      p1: {
        "id_usuario" : parent.IdUsuario,
        "id_registro_ocupacion" : $("#SL_ocupacion_modificar").val(),
        "nombre_actividad" : $("#TX_nombre_actividad_modificar").val(),
        "descripcion_actividad" : $("#TX_descripcion_actividad_modificar").val(),
        "responsable_actividad" : $("#TX_responsable_modificar").val(),
        "numero_asistentes" : $("#IN_total_asistentes_modificar").val(),
        "salones" : $("#SL_salones_modificar").val().join(),
        "fecha_hora_inicio" : $("#TX_fecha_hora_inicio_modificar").val(),
        "fecha_hora_fin" : $("#TX_fecha_hora_fin_modificar").val()
      }
    }
    $.ajax({
      url: url_ok_obj+'modificarRegistroOcupacionCREA',
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data){
      console.log(data);
      if(data == 1){
        parent.mostrarAlerta("success","Ocupación Guardada","Se ha modificado ocupación correctamente");
      }else{
        parent.mostrarAlerta("warning","Al parecer ha ocurrido un error","Verifique la consulta de ocupaciones del CREA para confirmar que se guardo correctamente la modificación de la ocupación. De lo contrario contactese con el equipo de soporte SIF.")
      }
      $("#SL_crea_modificar_ocupacion").trigger("change");
    }).fail(function(data){
      parent.mostrarAlerta("warning","Error","No se ha podido modificar el registro de asignacion.");
      console.log(data);
    });
  });

  $("body").delegate('.mostrar-salones','click',function(){
    $("#modal_salones").modal('show');
    $("#modal_title").html('Ocupación: '+$(this).attr('data-nombre'));
    var salones = $(this).attr('data-salones');
    // if(salones.length > 1){
    //   var array_salones = salones.split(',');
    //   $.each(array_salones,function(index,value){
    //     $("#modal_body").append("<p>"+value+"</p>");
    //   });
    // }
    // else{
    //   $("#modal_body").append("<p>"+salones+"</p>");
    // }
    var datos = {
      p1: salones
    }
    $.ajax({
      url: url_ok_obj+'getSalonesOcupacion',
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data){
      if(data != null){
        $("#table_salones_modal").html(data);
      }
      else{
        parent.mostrarAlerta("error","Algo salió mal","No se logró cargar los salones");
      }
    }).fail(function(data){
      parent.mostrarAlerta("warning","Error","No se han podido listar los salones.");
      console.log(data);
    });
  });

  $("#nav_consultar_ocupacion").click(function(){
    $("#SL_crea_consultar_ocupaciones").html(parent.getOptionsClanes()).selectpicker("refresh").change(function(){
      var datos = {
        p1: $(this).val()
      }
      $.ajax({
        url: url_ok_obj+'consultarRegistrosOcupacionCREA',
        type: 'POST',
        data: datos,
        async: false
      }).done(function(data){
        try{
          var table = "";
          data = $.parseJSON(data);
          for (var i = 0; i < data.length; i++) {
            table += "<tr>";
            table += "<td>" + data[i]["TX_nombre_actividad"] + "</td>";
            table += "<td>" + data[i]["TX_descripcion"] + "</td>";
            table += "<td>" + data[i]["TX_responsable"] + "</td>";
            table += "<td>" + data[i]["IN_asistentes"] + "</td>";
            table += "<td><a class='btn btn-primary mostrar-salones' data-salones='"+data[i]["FK_Salones"]+"' data-nombre='"+data[i]["TX_nombre_actividad"]+"' data-asistentes='"+data[i]["IN_asistentes"]+"'><span class='fas fa-search'></span></a></td>";
            table += "<td>" + data[i]["DT_fecha_hora_inicio"] + "</td>";
            table += "<td>" + data[i]["DT_fecha_hora_fin"] + "</td>";
            table += "</tr>";
          }
          table_ocupaciones.clear().draw();
          table_ocupaciones.rows.add($(table)).draw();
        }catch(ex){
          parent.mostrarAlerta("warning","Error decodificando JSON","No se ha podido extraer la información de las ocupaciones registradas en el CREA");
          console.log("Excepcion: " + ex + data);
        }
      }).fail(function(data){
        parent.mostrarAlerta("warning","Error","No se ha podido consultar los registros de asignacion.");
        console.log(data);
      });
    });
  });

  $("#BT_descargar_reporte_ocupacion").on('click', function(){
    if($("#SL_crea_consultar_ocupaciones").val() == ''){
      parent.swal("","Debe seleccionar un CREA","warning");
    }
    else{
      if($("#SL_mes_reporte_ocupacion").val() == ''){
        parent.swal("","Debe seleccionar un mes","warning");
      }
      else{
        if($("#SL_anio_reporte_ocupacion").val() == ''){
          parent.swal("","Debe seleccionar un año","warning");
        }
        else{
          generarReporteOcupacion();
        }
      }
    }
  });

  function generarReporteOcupacion(){
    pdfMake.fonts = {
      arial: {
        normal: 'arial.ttf',
        bold: 'arialbd.ttf',
        italics: 'ariali.ttf',
        bolditalics: 'arialbi.ttf'
      },
      Roboto: {
        normal: 'Roboto-Regular.ttf',
        bold: 'Roboto-Medium.ttf',
        italics: 'Roboto-Italic.ttf',
        bolditalics: 'Roboto-MediumItalic.ttf' 
      }
    }
    var datos_usuario = $.parseJSON(parent.consultarDatosBasicosUsuario(parent.idUsuario))[0];
    var nombre_completo_usuario = datos_usuario['VC_Primer_Nombre']+' '+datos_usuario['VC_Segundo_Nombre']+' '+datos_usuario['VC_Primer_Apellido']+' '+datos_usuario['VC_Segundo_Apellido'];
    var rol_usuario = datos_usuario['rol_usuario'];
    //if(rol_usuario == 'Coordinador CREA' || rol_usuario == 'Asistente Administrativo CREA'){
      var texto_revision_informacion = "";
      var firma_coordinador_crea = "";
      var nombre_crea = $("#SL_crea_consultar_ocupaciones option:selected").text();
      var nombre_coordinador_crea = "";
      var fecha_hora_servidor = parent.getFechaYHoraServidor();
      var mes_reporte = $("#SL_mes_reporte_ocupacion option:selected").text() + "/" + $("#SL_anio_reporte_ocupacion option:selected").text();
      var codigo_verificacion = fecha_hora_servidor.replace(/-/g,"").replace(/:/g,"").replace(/ /g,"");
      codigo_verificacion += " (No valido aún por desarrollo)";
      var ocupaciones = [];

      var datos = {
        p1: {
          "id_crea" : $("#SL_crea_consultar_ocupaciones").val(),
          "anio" : $("#SL_anio_reporte_ocupacion").val(),
          "mes" : $("#SL_mes_reporte_ocupacion").val()
        }
      }
      $.ajax({
        url: url_ok_obj+'consultarOcupacionesMesCrea',
        type: 'POST',
        data: datos,
        async: false
      }).done(function(data){
        console.log(data);
        data = $.parseJSON(data);
        for (var i = 0; i < data.length; i++) {
          ocupaciones.push(
          {
            table: {
              widths: ['100%'],
              body: [
              [{ text: 'Nombre: '+data[i]["TX_nombre_actividad"], bold: true }]
              ]
            }
          },
          {
            table: {
              widths: ['30%','25%','15%','30%'],
              body: [
              [{ text: 'Descripción', bold: true },{ text: 'Responsable', bold: true },{ text: 'Total asistentes', bold: true },{ text: 'Fecha-Hora', bold: true }],
              [data[i]["TX_descripcion"],data[i]["TX_responsable"],data[i]["IN_asistentes"],data[i]["DT_fecha_hora_inicio"]+' - '+data[i]["DT_fecha_hora_fin"]],
              ]
            }
          },
          '\n',
          );
        }
      }).fail(function(data){
        parent.mostrarAlerta("warning","Error","No se ha podido consultar la información.");
        console.log(data);
      });

      for (var i = 0; i < 5; i++) {

      }
      var contenido_reporte = {
        content:[
        {
          table: {
            widths: ['20%','55%', '*'],

            body: [
            [
            {
              image: 'data:image/png;base64,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',
              height:60,
              width:80,
              border: [false, false, false, false]
            },
            {
              text: '\nREPORTE DE OCUPACIÓN MENSUAL \n('+mes_reporte+')',alignment:'center', style: 'header',
              border: [false, false, false, false]
            },
            {
              image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABBCAYAAAAzOl11AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMUZGNkY4MkZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMUZGNkY4M0ZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjMxRkY2RjgwRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjMxRkY2RjgxRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+uMYxfgAADCNJREFUeNrsXQ2YVUUZ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',
              height:60,
              width:120,
              border: [false, false, false, false]
            },
            ]
            ]

          }
      },/*
      {
        table: {
          widths: ['15%','85%'],
          body: [
          [{ text: 'Código de verificación', bold: true },{ text : codigo_verificacion,alignment:'center' }]
          ]
        }
      },*/
      '\n',
      {
        table: {
          widths: ['15%','50%','15%','20%'],
          body: [
          [{ text: 'CREA', bold: true },nombre_crea,{ text: 'Fecha de reporte', bold: true },fecha_hora_servidor],
          [{ text: 'Funcionario', bold: true },nombre_completo_usuario,{ text: 'Identificación', bold: true },datos_usuario['VC_Identificacion']],
          [{ text: 'Correo', bold: true },datos_usuario['VC_Correo'],{ text: 'Mes reporte', bold: true },mes_reporte]
          ]
        }
      },
      '\nA continuación se encuentra el listado de las actividades de ocupación registradas en el Sistema Integrado de Formación (SIF) para el mes de ' + mes_reporte,
      '\n',
      ocupaciones,
      // '\nTotal estudiantes asignados: '+total_asignados,
      // 'Total estudiantes removidos: '+total_removidos,
      // '\nYo '+nombre_completo_usuario+', certifico que la información reportada en el presente formato es verdadera, correcta y corresponde exactamente a la creación y asignación de beneficiarios del programa CREA registrados en el Sistema Integrado de Formación (SIF) durante el mes '+mes_reporte,
      // texto_revision_informacion,
      {
        columns: [
        {
          width: '50%',
          text: '\n\n\n\n_______________________________________\n'+nombre_completo_usuario+'\nContratista - '+rol_usuario+'\nPrograma CREA- Formación y Creación Artística\nSubdirección de Formación Artística\nInstituto Distrital de las Artes - Idartes'
        },
        {
          width: '50%',
          text: firma_coordinador_crea
        }
        ]
      }
      ],
      styles: {
        header: {
          fontSize: 13,
          bold: true,
          margin: [0, 0, 0, 10]
        },
        subheader: {
          fontSize: 12,
          bold: true,
          margin: [0, 10, 0, 5]
        },
        tableExample: {
          margin: [0, 0, 0, 10]
        },
        tableData: {
          margin: [0, -0.2, 0, -1]
        },
        tableHeader: {
          bold: true,
          fontSize: 10,
          color: 'black'
        }
      },
      defaultStyle: {
        fontSize: 10
      }};
      pdfMake.createPdf(contenido_reporte).open();
    //}else{
    //  parent.mostrarAlerta('warning','Permisos insuficientes','Este reporte unicamente puede ser descargado por Coordinador CREA y/o Asistente Administrativo CREA');
    //}
  }
});