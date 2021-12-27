var url_ok_obj = '../../../src/CirculacionNidos/Controlador/RegistroBeneficiariosController.php'; 
var url_ben_reg = '../../../src/Beneficiarios/Controlador/RegistroBeneficiariosController.php';
var url_asis = '../../../src/Beneficiarios/Controlador/RegistroAsistenciaController.php';
var array_beneficiarios;
var fecha_evento;
var fecha_nacimiento;
var years;
var vr = 0;
var re;
var n;
var info_beneficiarios = {};
var doc_beneficiarios = {};
var tipo_persona;
var options_tipo_documento;
var options_genero;
var options_estrato;
var options_enfoque;
var options_nivel;
var asistencia_asistentes;
var options_mes;
var termino_cargue = false;

$(function() {

  getTipoDocumento();
  getGenero();
  getTPoblacional();
  getEtnia();
  getNivel();
  getMes();
  getTipoPersona();

  $("#SL_Mes_Programacion").html(options_mes).selectpicker("refresh");  
  $("#SL_Mes_Programacion").change(cargarDatosProgramacion);
  $("#SL_Mes_Info").html(options_mes).selectpicker("refresh");
  $("#SL_Mes_Info").change(function() {
    $("#SL_Evento_Info").html(getEventosEquipo($("#SL_Mes_Info").val())).selectpicker("refresh");
  }).selectpicker("refresh");

  $("#SL_Mes_Beneficiarios").html(options_mes).selectpicker("refresh");
  $("#SL_Mes_Beneficiarios").change(function() {
    $("#SL_Evento_Beneficiarios").html(getEventosEquipo($("#SL_Mes_Beneficiarios").val())).selectpicker("refresh");
  }).selectpicker("refresh");

  $("#SL_Evento_Beneficiarios").change(function(){
    $("#SL_Lugar_Atencion_Beneficiarios").html(getLugarAtencionEvento($("#SL_Evento_Beneficiarios").val())).selectpicker("refresh");
  }).selectpicker("refresh");

  $("#SL_Lugar_Atencion_Beneficiarios").change(function(){
    getBeneficiariosEvento();
    informacionEvento("#SL_Evento_Beneficiarios");
  });

  $("#SL_Mes_Asistentes").html(options_mes).selectpicker("refresh");
  $("#SL_Mes_Asistentes").change(function() {
    $("#SL_Evento_Asistentes").html(getEventosEquipo($("#SL_Mes_Asistentes").val())).selectpicker("refresh");
  }).selectpicker("refresh");

  $("#SL_Evento_Asistentes").change(function(){
    $("#SL_Lugar_Atencion_Asistentes").html(getLugarAtencionEvento($("#SL_Evento_Asistentes").val())).selectpicker("refresh");
  });

  $("#SL_Lugar_Atencion_Asistentes").change(function(){
    informacionEvento("#SL_Evento_Asistentes");
    getAsistentesEvento();
  });

  $("#SL_Mes_Reporte_Beneficiarios").html(options_mes).selectpicker("refresh");
  $("#SL_Mes_Reporte_Beneficiarios").change(function() {
    $("#SL_Evento_Consulta_Beneficiarios").html(getEventosEquipo($("#SL_Mes_Reporte_Beneficiarios").val())).selectpicker("refresh");
  }).selectpicker("refresh");

  $("#SL_Mes_Reporte").html(options_mes).selectpicker("refresh");

  $("#SL_Evento_Registrados").change(function(){
    informacionEvento("#"+$(this).attr("id"))
  });

  $("#SL_Evento_Info").change(function(){
    informacionEvento("#"+$(this).attr("id"))
  });

  $("body").on("click", ".delete", function() {
    parent.mostrarCargando();
    let arrayDelete = $($(this).closest("tr").children()[2]).find(".n-doc").attr("id").split("_")[3] - 1;
    $(this).closest("table").children().children().css("background-color", "white");
    $(this).closest("tr").remove();
    array_beneficiarios.splice(arrayDelete,1);
    pintarInfo(array_beneficiarios);
    validarDocumentos();
  });

  $("body").on("keyup", ".mayuscula", function(){
    $(this).val($(this).val().toUpperCase());
  });

  $("body").on("change", ".date", function(){
    if(termino_cargue == true){
      var row_id = $(this).attr("id").split("_")[3];
      mostrarRangoEdad(fecha_evento, $(this).val(), $("#SL_Genero_"+row_id+" option:selected").text(), row_id);
    }
  }); 
  
  $("body").on("change", ".selectpicker.genero", function() {
    var row_id = $(this).attr("id").split("_")[2];
    mostrarRangoEdad(fecha_evento, $("#TX_Fecha_Nac_"+row_id).val(), $("#SL_Genero_"+row_id+" option:selected").text(), row_id);
  });

  $("#archivo-beneficiarios").on("change", function(){
    if($("#archivo-beneficiarios").val() != ""){
      $("#btn-cargar-archivo").attr("disabled", false);
      $("#btn-cargar-archivo").removeClass("btn-default").addClass("btn-primary");
    } 
  });

  tabla_reporte_evento = $("#tabla-reporte-evento").DataTable({
    paging: false,
    scrollX: true,
    scrollCollapse: true,
    fixedColumns:{
      leftColumns: 3,
    },
    scrollY: "300px",
    dom: 'Bfrtip',
    buttons: [
    'excel'
    ],
    "language": {
      "lengthMenu": "Ver _MENU_ registros por página",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Filtrar"
    }
  });

  $('#form-reporte-consolidado').on('submit', function (event) {
    event.preventDefault();
    $("#div-reporte-evento").show();

    tabla_reporte_evento.clear().draw();
    var datos = {
      funcion: 'getReporteEvento',
      'p1': $("#SL_Mes_Reporte").val(),
      'p2': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        tabla_reporte_evento.rows.add($(data)).draw();
      },
      async: false
    });
  });

  /*-----------------Función para obtener tipo persona-----------------------*/
  function getTipoPersona() {
    var datos = {
      funcion: 'getTipoPersona',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_asis,
      type: 'POST',
      data: datos,
      dataType: 'json',
      success: function(data) {
        tipo_persona = data['FK_Tipo_Persona'];
      },
      async: false
    });
  }

  function getTipoDocumento() {
    var datos = {
      funcion: 'getTipoDocumento'
    };
    $.ajax({
      url: url_ben_reg,
      type: 'POST',
      data: datos,
      success: function(data) {
        options_tipo_documento = data;
      },
      async: false
    });
    return options_tipo_documento;
  }

  function getGenero() {
    var datos = {
      funcion: 'getGenero'
    };
    $.ajax({
      url: url_ben_reg,
      type: 'POST',
      data: datos,
      success: function(data) {
        options_genero = data;
      },
      async: false
    });
    return options_genero;
  }

  function getTPoblacional() {
    var datos = {
      funcion: 'getTPoblacional'
    };
    $.ajax({
      url: url_ben_reg,
      type: 'POST',
      data: datos,
      success: function(data) {
        options_estrato = data;
      },
      async: false
    });
    return options_estrato;
  }

  function getEtnia() {
    var datos = {
      funcion: 'getEtnia'
    };
    $.ajax({
      url: url_ben_reg,
      type: 'POST',
      data: datos,
      success: function(data) {
        options_enfoque = data;
      },
      async: false
    });
    return options_enfoque;
  }

  function getNivel() {
    var datos = {
      funcion: 'getNivel'
    };
    $.ajax({
      url: url_ben_reg,
      type: 'POST',
      data: datos,
      success: function(data) {
        options_nivel = data;
      },
      async: false
    });
    return options_nivel;
  }

  function getValidarBeneficiario(){
    $(".n-doc").each(function(index, el) {
      let id_element = "#"+$(this).attr("id");
      let id_row = $(this).attr("id").split("_")[3]

      var datos = {
        funcion: 'getValidarBeneficiario',
        p1: $(this).val(),
        p2: 1
      };
      $.ajax({
        url: url_ben_reg,
        type: 'POST',
        data: datos,
        dataType: 'json',
        success: function(data) {
          if(data.length != 0){

            $(id_element).closest("tr").css("background-color", "#4BB543");
            $(id_element).attr("readonly", true);
            $(id_element).closest("tr").find(".name").attr("readonly", true);
            $(id_element.replace("TX_Num_Doc_", "SL_Tipo_Documento_")).selectpicker("val", data[0]["FK_Tipo_Identificacion"]);
            $(id_element.replace("TX_Num_Doc_", "TX_Seg_Nom_")).val(data[0]["VC_Segundo_Nombre"]);
            $(id_element.replace("TX_Num_Doc_", "TX_Pri_Ape_")).val(data[0]["VC_Primer_Apellido"]);
            $(id_element.replace("TX_Num_Doc_", "TX_Seg_Ape_")).val(data[0]["VC_Segundo_Apellido"]);
            $(id_element.replace("TX_Num_Doc_", "TX_Fecha_Nac_")).val(moment(data[0]["DD_F_Nacimiento"]).format('DD/MM/YYYY'));
            $(id_element.replace("TX_Num_Doc_", "SL_Genero_")).selectpicker("val", data[0]["FK_Id_Genero"]);
            $(id_element.replace("TX_Num_Doc_", "SL_Estrato_")).selectpicker("val", data[0]["IN_Estrato"]);
            $(id_element.replace("TX_Num_Doc_", "SL_Enfoque_")).selectpicker("val", data[0]["IN_Grupo_Poblacional"]);

            mostrarRangoEdad(fecha_evento, $("#TX_Fecha_Nac_"+id_row).val(), $("#SL_Genero_"+id_row+" option:selected").text(), id_row);
          }
        },
        async: false
      });
    });
  }

  function validarDocumentos(){
    vr = 0;
    $(".n-doc").each(function(index, el) {
      $(this).closest("tr").css("background-color", "#ffffff");
      $($(this).closest("tr").children()[0]).find("div").html("");
      for (var i = 0; i < array_beneficiarios.length; i++) {
        if(index != i){
          if($.inArray($(this).val(), array_beneficiarios[i]) == 1){
            vr = 1;
            $(this).closest("tr").css("background-color", "#F7C6C6");
            $($(this).closest("tr").children()[0]).children().html("<a href='#' class='delete'><i class='fas fa-times-circle fa-1x'></i></a>");
            $("#btn-guardar-beneficiarios").attr("disabled", true);
          }
        }
      }
    });
    if(vr == 0){
      getValidarBeneficiario();
      $("#btn-guardar-beneficiarios").attr("disabled", false);
    }
    parent.cerrarCargando();
  }

  function pintarInfo(array_beneficiarios){
    $("#datos tbody").html("");
    n=1;
    for (var i = 0; i < array_beneficiarios.length; i++) {
      $("#datos tbody").append("<tr>"+
        "<td style='width: 1%; vertical-align: middle;'>"+n+"<div></div></td>"+

        "<td><select class='selectpicker' data-container='body' data-width='130px' required id='SL_Tipo_Documento_"+n+"' title='Seleccione una opción'></select></td>"+

        "<td><input type='text' class='form-control n-doc' pattern='[A-Za-z0-9]{3,}' required title='Mínimo tres caracteres sin caracteres especiales' style='width: 110px;' id='TX_Num_Doc_"+n+"'></td>"+

        "<td><input type='text' class='form-control date' readonly required id='TX_Fecha_Nac_"+n+"' style='width: 90px;'></td>"+

        "<td><input type='text' class='form-control name mayuscula' pattern='.{3,}' required title='Mínimo tres caracteres' data-input='name' id='TX_Pri_Nom_"+n+"' style='width: 110px;'></td>"+

        "<td><input type='text' class='form-control mayuscula' data-input='name' id='TX_Seg_Nom_"+n+"' style='width: 110px;'></td>"+

        "<td><input type='text' class='form-control name mayuscula' pattern='.{3,}' required title='Mínimo tres caracteres' data-input='name' id='TX_Pri_Ape_"+n+"' style='width: 110px;'></td>"+

        "<td><input type='text' class='form-control mayuscula' data-input='name' id='TX_Seg_Ape_"+n+"' style='width: 110px;'></td>"+

        "<td><select class='selectpicker genero' data-container='body' data-width='90px' required id='SL_Genero_"+n+"' title='Seleccione una opción'></select></td>"+

        "<td><select class='selectpicker' data-container='body' data-width='90px' required id='SL_Estrato_"+n+"' title='Seleccione una opción'></select></td>"+

        "<td><select class='selectpicker enfoque' data-container='body' data-width='160px' required id='SL_Enfoque_"+n+"' title='Seleccione una opción'></select></td>"+

        "<td><select class='selectpicker' data-container='body' required id='SL_Nivel_"+n+"' title='Seleccione una opción' data-width='140px'></select></td>"+

        "<td><span class='edad' id='SP_Rango_Edad_"+n+"'></span></td>"+

        "</tr>");

      $("#SL_Tipo_Documento_"+n).html(options_tipo_documento).selectpicker("refresh");
      $("#SL_Tipo_Documento_"+n+" option").filter(function(){
        return $.trim($(this).text()) == array_beneficiarios[i][0]
      }).prop('selected', true);
      $("#SL_Tipo_Documento_"+n).selectpicker("refresh");

      $("#TX_Num_Doc_"+n).val(array_beneficiarios[i][1]);

      $("#TX_Fecha_Nac_"+n).datepicker({
        format: 'dd/mm/yyyy',
        language: 'es', 
        autoclose: true,
        endDate: '+0d'
      });
      $("#TX_Fecha_Nac_"+n).datepicker("setDate", array_beneficiarios[i][2]);

      $("#TX_Pri_Nom_"+n).val(array_beneficiarios[i][3].toUpperCase());
      $("#TX_Seg_Nom_"+n).val(array_beneficiarios[i][4].toUpperCase());
      $("#TX_Pri_Ape_"+n).val(array_beneficiarios[i][5].toUpperCase());
      $("#TX_Seg_Ape_"+n).val(array_beneficiarios[i][6].toUpperCase());

    //$("#SL_Genero_"+n).html(options_genero).selectpicker("refresh");
    //$("#SL_Genero_"+n+" option").each((key,element)=>{
    //if ($(element).text() == array_beneficiarios[i][7]) {$(element).prop('selected', true);}
    //if ($(element).val() == array_beneficiarios[i][7]) {$(element).prop('selected', true);}
    //});
    //$("#SL_Genero_"+n).selectpicker("refresh");

    $("#SL_Genero_"+n).html(options_genero).selectpicker("refresh");
    $("#SL_Genero_"+n+" option").filter(function(){
      return $.trim($(this).text()) == array_beneficiarios[i][7]
    }).prop('selected', true);
    $("#SL_Genero_"+n).selectpicker("refresh");

    $("#SL_Estrato_"+n).html(options_estrato).selectpicker("refresh");
    $("#SL_Estrato_"+n+" option").filter(function(){
      return $.trim($(this).text()) == array_beneficiarios[i][8]
    }).prop('selected', true);
    $("#SL_Estrato_"+n).selectpicker("refresh");

    $("#SL_Enfoque_"+n).html(options_enfoque).selectpicker("refresh");
    $("#SL_Enfoque_"+n+" option").filter(function(){
      return $.trim($(this).text()) == array_beneficiarios[i][9]
    }).prop('selected', true);
    $("#SL_Enfoque_"+n).selectpicker("refresh");

    $("#SL_Nivel_"+n).html(options_nivel).selectpicker("refresh");
    $("#SL_Nivel_"+n+" option").filter(function(){
      return $.trim($(this).text()) == array_beneficiarios[i][10]
    }).prop('selected', true);
    $("#SL_Nivel_"+n).selectpicker("refresh");

    mostrarRangoEdad(fecha_evento, $("#TX_Fecha_Nac_"+n).val(), $("#SL_Genero_"+n+" option:selected").text(), n);

    n++;
  }
  termino_cargue = true;
}

function mostrarRangoEdad(fecha_evento, fecha_nacimiento_sf, genero, id_row){
  var fecha_nacimiento = moment(fecha_nacimiento_sf, "DD/MM/YYYY");

  var years = fecha_evento.diff(fecha_nacimiento, 'year');

  if(years >= 0 && years < 4){
    re = genero == "MASCULINO" ? "Niño de 1 mes <br>a 3 años" : "Niña de 1 mes <br>a 3 años";
  }
  if(years >= 4 && years < 6){
    re = genero == "MASCULINO" ? "Niño de 4 <br>a 5 años" : "Niña de 4 <br>a 5 años";
  }
  if(years >= 6 && years < 12){
    re = genero == "MASCULINO" ? "Niño fuera del rango <br>de edad" : "Niña fuera del rango <br>de edad";
  }
  if(years >= 12){
    re = genero == "MASCULINO" ? "Niño fuera del rango <br>de edad" : "Mujer gestante";
  }
  $("#SP_Rango_Edad_"+id_row).html(re);
}

$("#form-beneficiarios-evento").submit(function(e){
  e.preventDefault();

  var html;
  var h1a3 = 0;
  var m1a3 = 0;
  var h4a6 = 0;
  var m4a6 = 0;
  var h6a99 = 0;
  var m6a12 = 0;
  var gestante = 0;
  var comunidad_rural = 0;
  var indigena = 0;
  var afro = 0;
  var rom = 0;
  var raizal = 0;
  var palenquera = 0;
  var comunidades_negras = 0;
  var poblacion_carcelaria = 0;
  var discapacidad = 0;
  var habitantes_calle = 0;
  var actividades_sexuales = 0;
  var poblacion_conflicto = 0;
  var desplazamiento = 0;
  var poblacion_migrante = 0;
  var familias_deterioro = 0;
  var familias_emergencia = 0;
  var lgbtiq = 0;
  var sin_enfoque = 0;
  $("span.edad").each(function() {
    switch($(this).text()){
      case "Niño de 1 mes a 3 años":
      h1a3++;
      break;
      case "Niña de 1 mes a 3 años":
      m1a3++;
      break;
      case "Niño de 4 a 5 años":
      h4a6++;
      break;
      case "Niña de 4 a 5 años":
      m4a6++;
      break;
      case "Niño fuera del rango de edad":
      h6a99++;
      break;
      case "Niña fuera del rango de edad":
      m6a12++;
      break;
      case "Mujer gestante":
      gestante++;
      break;
    }
  });

  for(i=1; i<n; i++){
    switch($("#SL_Enfoque_"+i).val()){
      case "14":
      comunidad_rural++;
      break;
      case "3":
      indigena++;
      break;
      case "1":
      afro++;
      break;
      case "2":
      rom++;
      break;
      case "13":
      raizal++;
      break;
      case "21":
      palenquera++;
      break;
      case "25":
      comunidades_negras++;
      break;
      case "10":
      poblacion_carcelaria++;
      break;
      case "5":
      discapacidad++;
      break;
      case "12":
      habitantes_calle++;
      break;
      case "18":
      actividades_sexuales++;
      break;
      case "4":
      poblacion_conflicto++;
      break;
      case "26":
      desplazamiento++;
      break;
      case "19":
      poblacion_migrante++;
      break;
      case "20":
      familias_deterioro++;
      break;
      case "23":
      familias_emergencia++;
      break;
      case "22":
      lgbtiq++;
      break;
      case "6":
      sin_enfoque++;
      break;
    }
  }

  (h1a3 == 0) ? h1a3 = "" : h1a3 = h1a3 == 1 ? h1a3+" Niño de 1 mes a 3 años<br>" : h1a3+" Niños de 1 mes a 3 años<br>";
  (m1a3 == 0) ? m1a3 = "" : m1a3 = m1a3 == 1 ? m1a3+" Niña de 1 mes a 3 años<br>" : m1a3+" Niñas de 1 mes a 3 años<br>";
  (h4a6 == 0) ? h4a6 = "" : h4a6 = h4a6 == 1 ? h4a6+" Niño de 4 a 5 años<br>" : h4a6+" Niños de 4 a 5 años<br>";
  (m4a6 == 0) ? m4a6 = "" : m4a6 = m4a6 == 1 ? m4a6+" Niña de 4 a 5 años<br>" : m4a6+" Niñas de 4 a 5 años<br>";
  (h6a99 == 0) ? h6a99 = "" : h6a99 = h6a99 == 1 ? h6a99+" Niño fuera del rango de edad<br>" : h6a99+" Niños fuera del rango de edad<br>";
  (m6a12 == 0) ? m6a12 = "" : m6a12 = m6a12 == 1 ? m6a12+" Niña fuera del rango de edad<br>" : m6a12+" Niñas fuera del rango de edad<br>";
  (gestante == 0) ? gestante = "" : gestante = gestante == 1 ? gestante+" Mujer gestante<br>" : gestante+" Mujeres gestantes<br>";

  (comunidad_rural == 0) ? comunidad_rural = "" : comunidad_rural = comunidad_rural+" Beneficiario(s) de comunidad rural y campesina<br>";
  (indigena == 0) ? indigena = "" : indigena = indigena+" Beneficiario(s) indígena<br>";
  (afro == 0) ? afro = "" : afro = afro+" Beneficiario afrodescendiente<br>";
  (rom == 0) ? rom = "" : rom = rom+" Beneficiario(s) Rrom<br>";
  (raizal == 0) ? raizal = "" : raizal = raizal+" Beneficiario(s) raizal<br>";
  (palenquera == 0) ? palenquera = "" : palenquera = palenquera+" Beneficiario(s) palenquera<br>";
  (comunidades_negras == 0) ? comunidades_negras = "" : comunidades_negras = comunidades_negras+" Beneficiario(s) comunidades negras<br>";
  (poblacion_carcelaria == 0) ? poblacion_carcelaria = "" : poblacion_carcelaria = poblacion_carcelaria+" Beneficiario(s) población carcelaria<br>";
  (discapacidad == 0) ? discapacidad = "" : discapacidad = discapacidad+" Beneficiario(s) en situación o condición de discapacidad<br>";
  (habitantes_calle == 0) ? habitantes_calle = "" : habitantes_calle = habitantes_calle+" Beneficiario(s) personas habitantes de calle<br>";
  (actividades_sexuales == 0) ? actividades_sexuales = "" : actividades_sexuales = actividades_sexuales+" Beneficiario(s) personas que ejercen actividades sexuales pagadas<br>";
  (poblacion_conflicto == 0) ? poblacion_conflicto = "" : poblacion_conflicto = poblacion_conflicto+" Beneficiario(s) población victima del conflicto<br>";
  (desplazamiento == 0) ? desplazamiento = "" : desplazamiento = desplazamiento+" Beneficiario(s) personas en situación de desplazamiento<br>";
  (poblacion_migrante == 0) ? poblacion_migrante = "" : poblacion_migrante = poblacion_migrante+" Beneficiario(s) población migrante<br>";
  (familias_deterioro == 0) ? familias_deterioro = "" : familias_deterioro = familias_deterioro+" Beneficiario(s) familias ubicadas en zonas de deterioro urbano<br>";
  (familias_emergencia == 0) ? familias_emergencia = "" : familias_emergencia = familias_emergencia+" Beneficiario(s) familias en emergencia social y catastrófica<br>";
  (lgbtiq == 0) ? lgbtiq = "" : lgbtiq = lgbtiq+" Beneficiario(s) sectores LGBTIQ<br>";
  (sin_enfoque == 0) ? sin_enfoque = "" : sin_enfoque = sin_enfoque+" Beneficiario(s) sin ningún enfoque<br>";

  html = "<small>¿Está seguro de que quiere guardar la siguiente cantidad de beneficiarios?<br>"+h1a3+m1a3+h4a6+m4a6+h6a99+m6a12+gestante+comunidad_rural+indigena+afro+rom+raizal+palenquera+comunidades_negras+poblacion_carcelaria+discapacidad+habitantes_calle+actividades_sexuales+poblacion_conflicto+desplazamiento+poblacion_migrante+familias_deterioro+familias_emergencia+lgbtiq+sin_enfoque+"</small>";

  parent.swal({
    confirmButtonColor: '#3f9a9d',
    title: 'Guardar beneficiarios',
    html: html,
    type: 'warning',
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
    showCancelButton: true, 
    width: 800,
  }).then(() => {
    guardarBeneficiariosEvento();
  },(confirm) => {
    if (confirm == "cancel"){
    }
  }).catch(parent.swal.noop);
});

function guardarBeneficiariosEvento(){
  for (i = 1; i < n; i++) {
    info_beneficiarios[i] = [];
    info_beneficiarios[i].push({
      "numdoc": $("#TX_Num_Doc_"+i).val(),
      "tipdoc": $("#SL_Tipo_Documento_"+i).val(),
      "fecha": $("#TX_Fecha_Nac_"+i).val(),
      "prinom": $("#TX_Pri_Nom_"+i).val(),
      "segnom": $("#TX_Seg_Nom_"+i).val(),
      "priape": $("#TX_Pri_Ape_"+i).val(),
      "segape": $("#TX_Seg_Ape_"+i).val(),
      "gene": $("#SL_Genero_"+i).val(),
      "estra": $("#SL_Estrato_"+i).val(),
      "enfo": $("#SL_Enfoque_"+i).val(),
      "nivel": $("#SL_Nivel_"+i).val(),
      "id_usuario": parent.idUsuario
    });

    doc_beneficiarios[i] = [];
    doc_beneficiarios[i].push({
      "id_evento": $("#SL_Evento_Beneficiarios").val(),
      "numdoc": $("#TX_Num_Doc_"+i).val(),
      "nivel": $("#SL_Nivel_"+i+" option:selected").text(),
      "id_lugar_atencion": $("#SL_Lugar_Atencion_Beneficiarios").val() 
    });

  }    
  datos = {
    'funcion': 'guardarBeneficiariosEvento',
    p1: info_beneficiarios
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    dataType: 'json',
    data: datos,
    async: false,
    success: function(data){
    },
  });

  datos = {
    'funcion': 'guardarAsistenciaEvento',
    p1: doc_beneficiarios
  }

  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    dataType: 'json',
    data: datos,
    async: false,
    success: function(data){
      if(data >= 1){
        $("#div-registro-beneficiarios").hide();
        $("#datos tbody").html("");
        $("#archivo-beneficiarios").val("");
        $("#btn-cargar-archivo").attr("disabled", true);
        limpiarDatos("Beneficiarios");
        info_beneficiarios = {};
        doc_beneficiarios = {};
        parent.swal("Operación exitosa", "Los datos se han guardado exitosamente", "success");
      }else{
        parent.swal("Error", "No se han podido guardar los datos, por favor inténtelo nuevamente", "error");
      }
    },
  });
}

function getMes() {
  var datos = {
    funcion: 'getOptionsMes'
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      options_mes += data
    },
    async: false
  });
  return options_mes;
}

function getEventosEquipo(select_mes) {
  var mostrar = "";
  var datos = {
    funcion: 'consultarEventosEquipo',
    'p1': select_mes,
    'p2': parent.idUsuario,
    'p3': tipo_persona
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

function getLugarAtencionEvento(id_evento){
  var mostrar = "";
  var datos = {
    funcion: 'getLugarAtencionEvento',
    'p1': id_evento
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

$("#btn-cargar-archivo").click(function(){

  parent.mostrarCargando();

  var file = $("#archivo-beneficiarios")[0].files[0];
  // input canceled, return
  if (!file) return;

  var FR = new FileReader();
  FR.onload = function(e) {
    var data = new Uint8Array(e.target.result);
    var workbook = XLSX.read(data, {type: 'array'});
    var firstSheet = workbook.Sheets[workbook.SheetNames[0]];

    // header: 1 instructs xlsx to create an 'array of arrays'
    array_beneficiarios = XLSX.utils.sheet_to_json(firstSheet, { header: 1, defval: "", blankrows: false, raw: false, dateNF:'dd/mm/yyyy' });
    array_beneficiarios.splice(0,1);

    validacion_fechas = 0;

    $.each(array_beneficiarios, function( index, value ){
      $.each(array_beneficiarios[index], function( sub_index, sub_value ){
        if(array_beneficiarios[index][2].length < 9){
          validacion_fechas++;
        }
      });
    });
    if(validacion_fechas > 0){
      parent.mostrarAlerta("warning","Aviso","El formato de fechas de nacimiento es incorrecto, por favor revise el archivo y vuelva a cargarlo");
      $("#archivo-beneficiarios").val("");
      $("#btn-cargar-archivo").removeClass("btn-primary").addClass("btn-default");
      $("#btn-cargar-archivo").attr("disabled", true);
    }else{
      pintarInfo(array_beneficiarios);
      validarDocumentos();
    }
  };
  FR.readAsArrayBuffer(file);
});

function limpiarDatos(form){

  $("#SL_Mes_"+form).html(options_mes).selectpicker("refresh");
  $("#SL_Evento_"+form).html(getEventosEquipo($("#SL_Mes_"+form).val())).selectpicker("refresh");
  $("#SL_Lugar_Atencion_"+form).html(getLugarAtencionEvento($("#SL_Evento_"+form).val())).selectpicker("refresh");

  if(form == "Asistentes"){
    $("#div-registro-asistentes").hide();
    $("#TX_Observacion").val("");
    $("#form-asistentes-evento input[type=number]").each(function() {
      $(this).val("");
    });
  }
  if(form == "Info"){
    $("#div-informacion-evento").hide();
    $("#SL_Mes_Info").selectpicker("val", "");
    $("#SL_Evento_Info").selectpicker("val", "");
    $("#TX_Num_Art").val("");
    $("#TX_Num_Grupos").val("");
    $("#SL_Espacio_Publico").selectpicker("val", "");
    $("#TX_Num_Exp").val("");
    $("#TX_Listado_Asistencia").val("")
  }
}

function informacionEvento(tipo) {
  datos = {
    'funcion': 'consultarInformacionEvento',
    'p1': $(tipo).val()
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    dataType: 'json',
    data: datos,
    async: false,
    success: function(data){

      if(tipo == "#SL_Evento_Beneficiarios")
        $("#div-registro-beneficiarios").show();

      if(tipo == "#SL_Evento_Asistentes")
        $("#div-registro-asistentes").show();

      if(tipo == "#SL_Evento_Consulta_Beneficiarios")
        $("#div-reporte-evento-beneficiarios").show();

      if(tipo == "#SL_Evento_Info"){
        $("#div-informacion-evento").show();

        if(data["APROBACION"] == 1){
          parent.mostrarAlerta("warning","Aviso","El evento ha sido aprobado, ya no podrá realizar modificaciones sobre la información");
        }else{
          if(data["NUMERO_ARTISTAS"] != "" && data["NUMERO_GRUPOS"] != "" && data["ESPACIO_PUBLICO"] != "" && data["NUMERO_EXPERIENCIAS"] && data["LISTADO_ASISTENCIA"] != ""){
            parent.mostrarAlerta("warning","Aviso","Ya se ha registrado información para el evento seleccionado, se cargará la información almacenada");
          }
        }

        let disabled;
        let required;

        disabled = data["APROBACION"] == 0 ? false : true;
        required = data["LISTADO_ASISTENCIA"] == "" ? true : false;

        $("#TX_Num_Art").val(data["NUMERO_ARTISTAS"]);
        $("#TX_Num_Grupos").val(data["NUMERO_GRUPOS"]);
        $("#SL_Espacio_Publico").selectpicker("val",  data["ESPACIO_PUBLICO"]);
        $("#TX_Num_Exp").val(data["NUMERO_EXPERIENCIAS"]);
        $("#TX_Num_Cuidadores").val(data["NUMERO_CUIDADORES"]);

        $("#BTN_Ver_Listado").removeClass();

        if(data["LISTADO_ASISTENCIA"] == ""){
          $("#BTN_Ver_Listado").removeAttr("href");
          $("#BTN_Ver_Listado").addClass("form-control btn btn-default");
        }
        else{
          $("#BTN_Ver_Listado").attr("href", data["LISTADO_ASISTENCIA"]);
          $("#BTN_Ver_Listado").addClass("form-control btn btn-info");
        }

        $("#TX_Num_Art").attr("disabled", disabled);
        $("#TX_Num_Grupos").attr("disabled", disabled);
        $("#SL_Espacio_Publico").attr("disabled", disabled);
        $("#TX_Num_Exp").attr("disabled", disabled);
        $("#TX_Num_Cuidadores").attr("disabled", disabled);
        $("#TX_Listado_Asistencia").attr("disabled", disabled);
        $("#TX_Listado_Asistencia").attr("required", required);
        $("#BTN_Guardar_Info_Evento").attr("disabled", disabled);
      }

      fecha_evento = moment(data['FECHA_CALCULO']);

      $(".datos-evento").html("").html("<h3>Información del evento</h3>"+ 
        "<div class='col-lg-6'>"+
        "<p><strong>Lugar(es) de atención: </strong>"+data['LUGAR']+"</p>"+
        "<p><strong>Localidad: </strong>"+data['LOCALIDAD']+"</p>"+
        "<p><strong>Fecha: </strong>"+data['FECHA']+"</p>"+
        "</div>"+
        "<div class='col-lg-6'>"+
        "<p><strong>Horario: </strong>"+data['INICIO'] +" a "+ data['FINALIZACION']+"</p>"+
        "<p><strong>Día: </strong>"+data['DIA']+"</p>"+
        "<p><strong>Franja: </strong>"+data['FRANJA']+"</p>"+
        "</div>");
    },
  });
}

function guardarAsistentesEvento(){
  let funcion_ajax = asistencia_asistentes == 0 ? "guardarAsistentesEvento" : "actualizarAsistentesEvento";
  datos = {
    'funcion': funcion_ajax,
    p1: {
      'id_evento' : $("#SL_Evento_Asistentes").val(),
      'id_lugar_atencion': $("#SL_Lugar_Atencion_Asistentes").val(),
      'ninos_0_3' : $("#TX_Ninos_0_3").val(),
      'ninos_4_6' : $("#TX_Ninos_4_6").val(),
      'ninos_6_10' : $("#TX_Ninos_6_10").val(),
      'ninas_0_3' : $("#TX_Ninas_0_3").val(),
      'ninas_4_6' : $("#TX_Ninas_4_6").val(),
      'ninas_6_10' : $("#TX_Ninas_6_10").val(),
      'madres' : $("#TX_Madres").val(),
      'observacion': $("#TX_Observacion").val(),
      'id_persona' : parent.idUsuario
    }
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    dataType: 'json',
    data: datos,
    async: false,
    success: function(data){
      if(data == 1){
        asistencia_asistentes == 0 ? parent.swal("Operación exitosa", "Los datos se han guardaddo exitosamente", "success") : parent.swal("Operación exitosa", "Los datos se han actualizado exitosamente", "success")
        limpiarDatos("Asistentes");
        asistencia_asistentes;
      }else{
        parent.swal("Error", "No se han podido guardar los datos, por favor inténtelo nuevamente", "error");
      }
    },
  });
}

$('#form-asistentes-evento').on('submit', function (event) { 
  var vacio;
  event.preventDefault();
  $("#form-asistentes-evento input[type=number]").each(function() {
    if($(this).val() == ""){
      parent.swal("Advertencia", "Por favor compruebe que ha diligenciado todos los datos", "warning");
      vacio = 1;
    }
  });
  if(vacio != 1) guardarAsistentesEvento();
});

function cargarDatosProgramacion() {
  $("#div_programacion").show("refresh");
  ConsultarProgramacionAsignada();
}

/*--------------------------------------------------------------------------------------*/
var tabla_programacion = $("#tabla_programacion").DataTable({
  autoWidth: false,
  responsive: true,
  pageLength: 100,
  paging: false,
  info: false,
  dom: 'Bfrtip',
  order: [[ 1, 'asc' ]],
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

/*--------------------------------------------------------------------------------------*/
var tabla_reporte_evento_beneficiarios = $("#tabla-reporte-evento-beneficiarios").DataTable({
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

$('#form-reporte-evento-beneficiarios').on('submit', function (event) {
  event.preventDefault();
  informacionEvento("#"+$("#SL_Evento_Consulta_Beneficiarios").attr("id"))
  tabla_reporte_evento_beneficiarios.clear().draw();
  var datos = {
    funcion: 'getReporteBeneficiariosEvento',
    'p1':  $("#SL_Evento_Consulta_Beneficiarios").val(),
    'p2': $("#SL_Mes_Reporte_Beneficiarios").val()
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    dataType: 'html',
    success: function(data) {
      tabla_reporte_evento_beneficiarios.rows.add($(data)).draw();
      $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust()
      .responsive.recalc()
    },
    async: false
  });
});

/*-----------------Función para consultar los grupos-----------------------*/
function ConsultarProgramacionAsignada() {
  var mostrar = "";
  tabla_programacion.clear().draw();
  var datos = {
    funcion: 'getProgramacionAsignada',
    'p1': $("#SL_Mes_Programacion").val(),
    'p2': parent.idUsuario
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
    tabla_programacion.rows.add($(data)).draw();
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust()
    .responsive.recalc()
  }).fail(function(data) {
    parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
  });
  return mostrar;
}

$('#form-informacion-evento').on('submit', function (event) {
  event.preventDefault();

  var datos = new FormData();
  formulario = {};

  formulario["id_evento"] = $("#SL_Evento_Info").val();
  formulario["num_artistas"] = $("#TX_Num_Art").val();
  formulario["num_grupos"] = $("#TX_Num_Grupos").val();
  formulario["espacio_publico"] = $("#SL_Espacio_Publico").val();
  formulario["experiencias"] = $("#TX_Num_Exp").val();
  formulario["cuidadores"] = $("#TX_Num_Cuidadores").val();

  archivo = $("#TX_Listado_Asistencia")[0].files[0]

  datos.append('funcion', 'RegistroInformacionEvento');
  datos.append("p1", JSON.stringify(formulario));
  datos.append("p3", archivo);

  $.ajax({
    url: url_ok_obj,
    contentType: false,
    processData: false,
    type: 'POST',
    data: datos,
    success: function(data) {
      parent.swal("Operación exitosa", "Se registró exitosamente la información general del evento", "success");
      limpiarDatos("Info");
    },
    async: false
  });
});

function getBeneficiariosEvento(){
  var datos = {
    funcion: 'getBeneficiariosEvento',
    p1: {
      'id_evento': $("#SL_Evento_Beneficiarios").val(),
      'id_lugar_atencion': $("#SL_Lugar_Atencion_Beneficiarios").val(),
    } 
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    dataType: 'json',
    success: function(data) {

      let disabled;
      disabled = data["IN_Aprobacion"] == 0 ? false : true;

      $("#archivo-beneficiarios").attr("disabled", disabled);
      $("#btn-guardar-beneficiarios").attr("disabled", disabled);
      
      if(data["IN_Aprobacion"] == 1){
        parent.mostrarAlerta("warning","Aviso","El evento ha sido aprobado, ya no podrá realizar modificaciones sobre la información");
      }else{
        if(data["data"] > 0){
          parent.mostrarAlerta("warning","Precaución","Ya se han registrado "+data["data"]+" beneficiarios para el evento y lugar de atención seleccionados, para evitar duplicidad en la información por favor consulte la pestaña <strong>Reporte evento</strong>");
        }
      }
    },
    async: false
  });
}

function getAsistentesEvento(){
  var datos = {
    funcion: 'getAsistentesEvento',
    p1:  {
      'id_evento': $("#SL_Evento_Asistentes").val(),
      'id_lugar_atencion': $("#SL_Lugar_Atencion_Asistentes").val(),
    }
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    dataType: 'json',
    success: function(data) {

      let disabled;
      disabled = data["IN_Aprobacion"] == 0 ? false : true;

      if(data["IN_Aprobacion"] == 1)
        parent.mostrarAlerta("warning","Aviso","El evento ha sido aprobado, ya no podrá realizar modificaciones sobre la información");

      $("#TX_Ninos_0_3").attr("disabled", disabled);
      $("#TX_Ninas_0_3").attr("disabled", disabled);
      $("#TX_Ninos_4_6").attr("disabled", disabled);
      $("#TX_Ninas_4_6").attr("disabled", disabled);
      $("#TX_Ninos_6_10").attr("disabled", disabled);
      $("#TX_Ninas_6_10").attr("disabled", disabled);
      $("#TX_Madres").attr("disabled", disabled);
      $("#TX_Observacion").attr("disabled", disabled);
      $("#btn-guardar-asistentes").attr("disabled", disabled);

      $("#TX_Ninos_0_3").val(data["VC_Ninos_0_3"]);
      $("#TX_Ninas_0_3").val(data["VC_Ninas_0_3"]);
      $("#TX_Ninos_4_6").val(data["VC_Ninos_4_6"]);
      $("#TX_Ninas_4_6").val(data["VC_Ninas_4_6"]);
      $("#TX_Ninos_6_10").val(data["VC_Ninos_6_10"]);
      $("#TX_Ninas_6_10").val(data["VC_Ninas_6_10"]);
      $("#TX_Madres").val(data["VC_Madres"]);

      $("#TX_Observacion").val(data["TX_Observacion"]);

      asistencia_asistentes = data["PK_Id_Asistentes_Evento"] == "" ? 0 : 1; 

    },
    error: function(data){
      parent.mostrarAlerta("error","Error","No se pudo obtener la información del evento, por favor vuelva a intentarlo");
    },
    async: false
  });
}
});