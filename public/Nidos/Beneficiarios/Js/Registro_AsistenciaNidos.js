var url_ok_obj = '../../../src/Beneficiarios/Controlador/RegistroAsistenciaController.php';    
var url_ok_obj2 = '../../../src/CirculacionNidos/Controlador/RegistroBeneficiariosController.php'; 

var id_dupla;
var ids_artistas=[];
var nom_artis_pri;
var artista_invitado;
var artistas_asistencia=[];
var bandera_existencia = 0;
var tipo_suplencia;
var options_mes;
$(function() {

  $(".numbers").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });

  $(".modal.modal-wide .modal-dialog").css({
    "width": "90%"
  });


  getTipoPersona();
  getMes();

  if(tipo_persona == 16){
    $("#SL_Grupos").html(getLugaryGrupoArtista()).change(function(){
      $("#SL_Atenciones").html(getAtencionesGrupo($("#SL_Grupos").val(), tipo_persona)).selectpicker("refresh");
    }).selectpicker("refresh");
  }else{
    $("#div-duplas").show();
    $("#SL_Duplas").html(getDuplas()).change(function(){
      $("#SL_Grupos").html(getGruposDupla($("#SL_Duplas").val())).change(function(){
        $("#SL_Atenciones").html(getAtencionesGrupo($("#SL_Grupos").val(), tipo_persona)).selectpicker("refresh");
      }).selectpicker("refresh");
    }).selectpicker("refresh");

    $("#SL_Duplas_Eli").html(getDuplas()).change(function(){
      $("#SL_Grupos_Eli").html(getGruposDupla($("#SL_Duplas_Eli").val())).change(function(){
      }).selectpicker("refresh");
    }).selectpicker("refresh");
  }

  $("#SL_Grupos_Eli").change(function(){
    getExperienciasEliminar($(this).val());
  });

  $("#SL_Atenciones").change(cargarDatosExperiencia);
  

  function cargarDatosExperiencia(){
    limpiarArtistas(0);
    $("#div-experiencia").show();
    getInformacionExperiencia();
    getBeneficiariosModificarExperiencia();
  }

  $("#SL_Lugar_Atencion").html(getLugaryGrupoArtista()).selectpicker("refresh");
  $("#SL_Lugar_Atencion_Proteccion").html(getLugaryGrupoArtista()).selectpicker("refresh");  


  $("#SL_Lugar_Grupo").html(getLugaryGrupoArtista()).change(function() {
    $("#SL_Atencion").html(getExperienciasGrupo($("#SL_Lugar_Grupo").val())).selectpicker("refresh");
  }).selectpicker("refresh");

  $("#SL_Mes_Reporte").html(options_mes).selectpicker("refresh"); 


  $("#SL_Lugar_Atencion").change(cargarDatos);
  $("#SL_Lugar_Atencion_Proteccion").change(cargarDatosProteccion);

  $("#TX_Fecha_Encuentro").on('change', function(){
    validarExperienciaDuplicada();
  });

  function cargarDatos(){
    limpiarArtistas(0);
    $("#TX_Fecha_Encuentro").val("");
    $("#TX_Hora_Inicio").val("");
    $("#TX_Hora_Finalizacion").val("");
    $("#TX_NomExperiencia").val("");
    $("#div_registro_asistencia_beneficiarios").show("refresh");
    getInformacionGrupo("refresh");
    $("#div_tabla_asistencia_beneficiarios").hide();
  }

  function cargarDatosProteccion(){
    limpiarArtistas(0);
    getDuplaArtista();
    getLugarGrupo();
    $("#TX_Fecha_Encuentro_Proteccion").val("");
    $("#TX_Hora_Inicio_Proteccion").val("");
    $("#TX_Hora_Finalizacion_Proteccion").val("");
    $("#TX_NomExperiencia_Proteccion").val("");
    $("#div_registro_experiencia_proteccion").show("refresh");
    getInformacionGrupoProteccion("refresh");
    $("#div_registro_cifras").show("refresh");
  }

  $("#SL_Atencion").change(function() {
    getInformacionExperienciaGuardada();
    consultarAsistenciaExperiencia();
    $("#div_consulta_atenciones").show("refresh");
  });

  $("body").delegate("#checkbox_all", "change", function() {
    if($(this).is(":checked")){
      $("input[type='checkbox']").not(this).bootstrapToggle('on');
    }else{
      $("input[type='checkbox']").not(this).bootstrapToggle('off');
    }
  });

  $("#div-experiencias-eliminar").on("click", "button", function(){
    parent.swal({
      confirmButtonColor: '#3f9a9d',
      title: 'Confirmación',
      html: '<small>¿Está seguro que desea eliminar la experiencia <strong>'+$(this).attr("data-nombre")+'</strong> con fecha de <strong>'+$(this).attr("data-fecha")+'</strong>?</small>',
      type: 'warning',
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
      showCancelButton: true, 
      width: 800,
    }).then(() => {
      eliminarExperiencia($(this).attr("data-experiencia"));
    },(confirm) => {
      if (confirm == "cancel"){
      }
    }).catch(parent.swal.noop);
  });

  $("#BT_Invitado").click(function(){
    $("#SL_Artista_Invitado").html(getArtistas(0)).selectpicker("refresh");
    $(".modal-title").text("Agregar artista invitado");
    $("#cambio").hide();
    $("#suplencia").hide();
    $("#invitado").show();
    if($("#BT_Invitado").hasClass("btn-danger")){
      $("#BT_Invitado").removeClass("btn-danger");
      $("#BT_Invitado").addClass("btn-success");
    }
    if($("#BT_Cambio").hasClass("btn-success")){
      $("#BT_Cambio").removeClass("btn-success");
      $("#BT_Cambio").addClass("btn-danger");
    }
    if($("#BT_Suplencia").hasClass("btn-success")){
      $("#BT_Suplencia").removeClass("btn-success");
      $("#BT_Suplencia").addClass("btn-danger");
    }
  });

  $("#BT_Cambio").click(function(){
    $("#artista_remover").empty();
    if(tipo_persona == 16){
      artistaRemover();
      $("#artista_remover").append("Desde esta opción puede remover su compañero de dupla y agregar el artista que realizó la atención del grupo, el artista a remover es: <strong>"+artista_remover[0]['Artista']+"</strong>");
      $("#cambio").append("<select class='form-control selectpicker' data-live-search='true' name='SL_Artista_Cambio' id='SL_Artista_Cambio' title='Seleccione un artista'></select><span class='error' style='display: none; color: red;'></span>");
      $("#SL_Artista_Cambio").html(getArtistas(0)).selectpicker("refresh");
    }else{
      $("#artista_remover").append("Desde esta opción puede modificar el artista de reemplazo<br><br><strong><span style='color:red;'>Recuerde que*: </span></strong>Debe elegir uno de los artistas de la dupla: <strong>"+ nom_artis_pri +" </strong> y el artista de reemplazo que acompañó la experiencia.");
      $("#cambio").append("<select class='form-control selectpicker' multiple data-max-options='2' data-live-search='true' name='SL_Artista_Cambio' id='SL_Artista_Cambio' title='Seleccione un artista'></select><span class='error' style='display: none; color: red;'></span>");
      $("#SL_Artista_Cambio").html(getArtistas(1)).selectpicker("refresh");
    }
    $("#suplencia").hide();
    $("#invitado").hide();
    $("#cambio").show();
    $(".modal-title").text("Reemplazar artista");
    if($("#BT_Cambio").hasClass("btn-danger")){
      $("#BT_Cambio").removeClass("btn-danger");
      $("#BT_Cambio").addClass("btn-success");
    }
    if($("#BT_Invitado").hasClass("btn-success")){
      $("#BT_Invitado").removeClass("btn-success");
      $("#BT_Invitado").addClass("btn-danger");
    }
    if($("#BT_Suplencia").hasClass("btn-success")){
      $("#BT_Suplencia").removeClass("btn-success");
      $("#BT_Suplencia").addClass("btn-danger");
    }
  });

  $("#BT_Suplencia").click(function(){
    $(".modal-title").text("Agregar artistas suplentes");
    $("#SL_Artista_Suplencia").html(getArtistas(0)).selectpicker("refresh");
    $("#invitado").hide();
    $("#cambio").hide();
    $("#suplencia").show();
    if($("#BT_Suplencia").hasClass("btn-danger")){
      $("#BT_Suplencia").removeClass("btn-danger");
      $("#BT_Suplencia").addClass("btn-success");
    }
    if($("#BT_Cambio").hasClass("btn-success")){
      $("#BT_Cambio").removeClass("btn-success");
      $("#BT_Cambio").addClass("btn-danger");
    }
    if($("#BT_Invitado").hasClass("btn-success")){
      $("#BT_Invitado").removeClass("btn-success");
      $("#BT_Invitado").addClass("btn-danger");
    }
  });

  $("#BT_Confirmar_artistas").click(function(){
    if($("#invitado").is(':visible')){
      if(artistas_asistencia != ""){
        artistas_asistencia="";
      }
      if($("#SL_Artista_Invitado").val() != ""){
        artista_invitado = $("#SL_Artista_Invitado option:selected").text();
        if(artista_invitado == ""){
          $("#SP_Artista").append(" Y "+ artista_invitado);
        }else{
          $("#SP_Artista").empty();
          $("#SP_Artista").text(nom_artis_pri+" Y "+ artista_invitado);
        }
        artistas_asistencia=ids_artistas.split(',');
        artistas_asistencia.push($("#SL_Artista_Invitado").val());
        tipo_suplencia=1;
        undo();
      }else{
        $(".error").text("Por favor seleccione un artista");
        $(".error").show();
      }
    }

    if($("#cambio").is(':visible')){
      if(artistas_asistencia != ""){
        artistas_asistencia="";
      }

      if($("#SL_Artista_Cambio").val() != ""){
        $("#SP_Artista").empty();
        if(tipo_persona == 16){
          for(i=0;i<=1;i++){
            nombre_artista = nom_artis_pri.split(" Y ")[i];
            if(nombre_artista != artista_remover[0]['Artista']){
              artista_principal = nombre_artista;
            }
          }
          $("#SP_Artista").append(artista_principal + " Y " + $("#SL_Artista_Cambio option:selected").text());
          artistas_asistencia=[parent.idUsuario, $("#SL_Artista_Cambio").val()];
        }else{
          $("#SP_Artista").append($("#SL_Artista_Cambio option:selected").map(function(){ return this.text }).get().join(" Y "));
          artistas_asistencia = $("#SL_Artista_Cambio").val();
        }
        tipo_suplencia=2;
        undo();
      }else{
        $(".error").text("Por favor seleccione una opción");
        $(".error").show();
      }
    }

    if($("#suplencia").is(':visible')){
      if(artistas_asistencia != ""){
        artistas_asistencia="";
      }

      if($("#SL_Artista_Suplencia").val() != ""){
        artistas_suplentes = $("#SL_Artista_Suplencia option:selected").map(function(){ return this.text }).get().join(" Y ");
        artistas_suplentes_ids = $("#SL_Artista_Suplencia option:selected").map(function(){ return this.value }).get().join(",");
        artistas_asistencia=artistas_suplentes_ids.split(',');
        if(artistas_asistencia.length < 2){
          $(".error").text("Recuerde que debe seleccionar dos artistas");
          $(".error").show();
        }else{
          $("#SP_Artista").empty();
          $("#SP_Artista").text(artistas_suplentes);
          tipo_suplencia=3;
          undo();
        }
      }else{
        $(".error").text("Por favor seleccione dos artistas");
        $(".error").show();
      }
    }
  });

  function undo(){
    $("#undo").show();
    $("#modal_artistas").modal('hide');
    $(".error").hide();
  }

  function limpiarArtistas(val){
    if(val == 1){
      $("#SP_Artista").empty();
      $("#SP_Artista").text(nom_artis_pri);
      artistas_asistencia=ids_artistas.split(',');
      tipo_suplencia=0;
    }
    $("#BT_Invitado").removeClass();
    $("#BT_Invitado").addClass("btn btn-success btn-xs");
    $("#BT_Cambio").removeClass();
    $("#BT_Cambio").addClass("btn btn-success btn-xs");
    $("#BT_Suplencia").removeClass();
    $("#BT_Suplencia").addClass("btn btn-success btn-xs");
    $("#undo").hide();
  }

  $("#undo").click(function(){
    limpiarArtistas(1);
  });

  $("#popover-artistas").popover({
    title: '<strong>Ayuda suplencia artistas</strong>',
    placement: 'top',
    trigger: 'hover',
    html: true,
    content: function () {
      return "<span>Por medio de los botones <strong>Invitado, Reemplazo y Suplencia</strong> puede cambiar fácilmente la asistencia de los artistas que realizaron la atención del día seleccionado.<br><br>"+
      "Por favor tenga en cuenta que:</span>"+
      "<ol>"+
      "<li>Solo podrá utilizar una de las tres opciones.</li>"+
      "<li>Los nombres de los artistas se actualizarán una vez haga clic en el botón <strong>Guardar</strong> de la ventana emergente.</li>"+
      "<li>Puede utilizar el botón <i class='fa fa-undo' style='color: red;'></i> para restablecer los cambios de artistas que haya realizado.</li>"+
      "</ol>";
    }
  });

  var tabla_asistencia_beneficiarios = $("#tabla_asistencia_beneficiarios").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    info: false,
    order: [[ 1, "asc" ]],
    "language": {
      "lengthMenu": "Ver _MENU_ registros por página",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
      "search": "Filtrar"
    },
  });

  $(".mayuscula").keyup(function() {
    $(this).val($(this).val().toUpperCase());
  });

  $(".calendario").datepicker({
    format: 'yyyy-mm-dd',
    language: 'es',
    autoclose: true,
    endDate: '+0d',
    startDate: '2021-08-26'
  });

  $("body").delegate("#TX_Fecha_Encuentro", "change", function() {
    getBeneficiariosXGrupo();
  });

  $('.horainicio').timepicker({
    timeFormat: 'HH:mm',
    interval: 10,
    minTime: '7',
    maxTime: '18:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });

  $('.horafin').timepicker({
    timeFormat: 'HH:mm',
    interval: 10,
    minTime: '8',
    maxTime: '19:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });

  $('#TX_Hora_Inicio_Mod').timepicker({
    timeFormat: 'HH:mm',
    interval: 10,
    minTime: '7',
    maxTime: '18:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });

  $('#TX_Hora_Fin_Mod').timepicker({
    timeFormat: 'HH:mm',
    interval: 10,
    minTime: '8',
    maxTime: '19:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });

  $("#BT_registrar_asistencia").click(function() {
    var hora_inicio = $('#TX_Hora_Inicio').val().split(":")[0];
    var hora_fin = $('#TX_Hora_Finalizacion').val().split(":")[0];
    var min_inicio = $('#TX_Hora_Inicio').val().split(":")[1];
    var min_fin = $('#TX_Hora_Finalizacion').val().split(":")[1];
    if ($("#TX_Fecha_Encuentro").val() == "" || $("#TX_Hora_Inicio").val() == "" || $("#TX_Hora_Finalizacion").val() == "" || $("#TX_NomExperiencia").val() == "" || $("#TX_Cuidadores").val() == "" || $("#TX_Modalidad").val() == "") {
      $(".modal-title").text("ATENCIÓN");
      mensajeError("Por favor compruebe que ha diligenciado la fecha, hora de inicio y finalización, nombre de la experiencia, # de Cuidadores y Modalidad.");
    } else if (hora_inicio > hora_fin) {
      mensajeError("La hora de inicio de la experiencia no puede ser mayor a la hora de finalización.");
    } else if (hora_inicio == hora_fin) {
      if (min_inicio > min_fin) {
        mensajeError("La hora de inicio de la experiencia no puede ser mayor a la hora de finalización.");
      } else if (min_inicio == min_fin) {
        mensajeError("La hora de inicio de la experiencia no puede ser igual a la hora de finalización.");
      }
      else {
        mostrarModalRegistrar();
      }
    } else if (hora_inicio < hora_fin) {
      mostrarModalRegistrar();
    }
  });
  function mensajeError(error) {
    $("#info_asistencia").html(error);
    $("#BT_confirmar_asistencia").hide();
    $("#BT_cancelar_guardado").val("Ok");
  }
  function mostrarModalRegistrar() {
    $(".modal-title").text("Confirmar asistencia a experiencia");
    $("#info_asistencia").html("");
    $("#BT_confirmar_asistencia").show();
    $("#BT_cancelar_guardado").val("No");
    var filas_tabla = tabla_asistencia_beneficiarios.data().length;
    var m1a3 = 0;
    var f1a3 = 0;
    var m4a6 = 0;
    var f4a6 = 0;
    var mg = 0;
    var afro = 0;
    var crc = 0;
    var cd = 0;
    var ca = 0;
    var indi = 0;
    var mpl = 0;
    var rai = 0;
    var rom = 0;
    for (i = 0; i <= filas_tabla; i++) {
      if ($("#checkbox_" + i).is(':checked')) {
        if ($("#checkbox_" + i).data("genero_beneficiario") == "MASCULINO" && $("#checkbox_" + i).data("rango_edad_beneficiario") == "Niño de 1 mes a 3 años") {
          m1a3++;
        }
        if ($("#checkbox_" + i).data("genero_beneficiario") == "FEMENINO" && $("#checkbox_" + i).data("rango_edad_beneficiario") == "Niña de 1 mes a 3 años") {
          f1a3++;
        }
        if ($("#checkbox_" + i).data("genero_beneficiario") == "MASCULINO" && $("#checkbox_" + i).data("rango_edad_beneficiario") == "Niño de 4 años a 6 años") {
          m4a6++;
        }
        if ($("#checkbox_" + i).data("genero_beneficiario") == "FEMENINO" && $("#checkbox_" + i).data("rango_edad_beneficiario") == "Niña de 4 años a 6 años") {
          f4a6++;
        }
        if ($("#checkbox_" + i).data("genero_beneficiario") == "FEMENINO" && $("#checkbox_" + i).data("rango_edad_beneficiario") == "Madre gestante") {
          mg++;
        }
        if($("#checkbox_" + i).data("enfoque-beneficiario")  == "AFRODESCENDIENTE"){
          afro++;
        }
        if($("#checkbox_" + i).data("enfoque-beneficiario") == "COMUNIDAD RURAL Y CAMPESINA"){
          crc++;
        }
        if($("#checkbox_" + i).data("enfoque-beneficiario") == "CONDICIÓN DE DISCAPACIDAD"){
          cd++;
        }
        if($("#checkbox_" + i).data("enfoque-beneficiario") == "CONFLICTO ARMADO"){
          ca++;
        }
        if($("#checkbox_" + i).data("enfoque-beneficiario") == "INDÍGENA"){
          indi++;
        }
        if($("#checkbox_" + i).data("enfoque-beneficiario") == "MENORES PRIVADOS DE LA LIBERTAD"){
          mpl++;
        }
        if($("#checkbox_" + i).data("enfoque-beneficiario") == "RAIZALES"){
          rai++;
        }
        if($("#checkbox_" + i).data("enfoque-beneficiario") == "ROM"){
          rom++;
        }
      }
    }
    $("#info_asistencia").append("<center>¿Esta seguro que quiere guardar la asistencia de?</center><br>Los siguientes beneficiarios agrupados por rango de edad (Asistencia real): <br><br>");

    if(m1a3 != 0 || f1a3 != 0 || m4a6 != 0 || f4a6 != 0 || mg != 0){
      if (m1a3 != 0) {
        if(m1a3 == 1){
          $("#info_asistencia").append("<strong>" + m1a3 + " </strong> niño de 1 mes a 3 años de edad.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + m1a3 + " </strong> niños de 1 mes a 3 años de edad.<br>");
        }
      }
      if (f1a3 != 0) {
        if(f1a3 == 1){
          $("#info_asistencia").append("<strong>" + f1a3 + " </strong> niña de 1 mes a 3 años de edad.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + f1a3 + " </strong> niñas de 1 mes a 3 años de edad.<br>");
        }
      }
      if (m4a6 != 0) {
        if(m4a6 == 1){
          $("#info_asistencia").append("<strong>" + m4a6 + " </strong> niño de 4 a 6 años de edad.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + m4a6 + " </strong> niños de 4 a 6 años de edad.<br>");
        }
      }
      if (f4a6 != 0) {
        if(f4a6 == 1){
          $("#info_asistencia").append("<strong>" + f4a6 + " </strong> niña de 4 a 6 años de edad.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + f4a6 + " </strong> niñas de 4 a 6 años de edad.<br>");
        }
      }
      if (mg != 0) {
        if(mg == 1){
          $("#info_asistencia").append("<strong>" + mg + " </strong> madre gestante.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + mg + " </strong> madres gestantes.<br>");
        }
      }
    }else{
      $("#info_asistencia").html("");
      $("#info_asistencia").append("¿Esta seguro que ningún niño, niña o madre gestante asistió a la experiencia?");
    }

    if(afro != 0 || crc != 0 || cd != 0 || ca != 0 || indi != 0 || mpl != 0 || rai != 0 || rom != 0){
      $("#info_asistencia").append("<br><hr><br>Los siguientes beneficiarios agrupados por enfoque diferencial:<br><br>");
      if(afro != 0){
        if(afro == 1){
          $("#info_asistencia").append("<strong>" + afro + "</strong> niño afrodescendiente.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + afro + "</strong> niños afrodescendientes.<br>");
        }
      }
      if(crc != 0){
        if(crc == 1){
          $("#info_asistencia").append("<strong>" + crc + " </strong> niño de comunidad rural y campesina.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + crc + " </strong> niños de comunidad rural y campesina.<br>");
        }
      }
      if(cd != 0){
        if(cd == 1){
          $("#info_asistencia").append("<strong>" + cd + " </strong> niño en condición de discapacidad.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + cd + " </strong> niños en condición de discapacidad.<br>");
        }
      }
      if(ca != 0){
        if(ca == 1){
          $("#info_asistencia").append("<strong>" + ca + " </strong> niño de conflicto armado.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + ca + " </strong> niños de conflicto armado.<br>");
        }
      }
      if(indi != 0){
        if(indi == 1){
          $("#info_asistencia").append("<strong>" + indi + " </strong> niño indigena.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + indi + " </strong> niños indigenas.<br>");
        }
      }
      if(mpl != 0){
        if(mpl == 1){
          $("#info_asistencia").append("<strong>" + mpl + "  </strong> niño privado de la libertad.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + mpl + "  </strong> niños privados de la libertad.<br>");
        }
      }
      if(rai != 0){
        if(rai == 1){
          $("#info_asistencia").append("<strong>" + rai + " </strong> niño raizal.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + rai + " </strong> niños raizales.<br>");
        }
      }
      if(rom != 0){
        if(rom == 1){
          $("#info_asistencia").append("<strong>" + rom + " </strong> niño ROM.<br>");
        }else{
          $("#info_asistencia").append("<strong>" + rom + " </strong> niños ROM.<br>");
        }
      }
      $("#info_asistencia").append("<br><span style='color: red; font-weight: bold;'>Nota*:</span> Recuerde que este conteo no <strong>resta</strong> del total de la asistencia real.");
    }
  }
  var check;

  ///****************************  Registrar asistencia experiencia
  $("#form_nueva_experiencia").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    if(artistas_asistencia == ""){
      artistas_asistencia=ids_artistas.split(',');;
      tipo_suplencia=0;
    }
    artistas_asistencia = JSON.stringify(artistas_asistencia);
    var mostrar = "";
    var checkbox_asistencia_beneficiario = new Array();
    $('.asistencia_experiencia').each(function() {
      var check;
      if($(this).is(":checked")){
        check=1;
      }else{
        check=0;
      }
      //checkbox_asistencia_beneficiario.push(new Array($(this).data('id_beneficiario'), $(this).prop('checked')));
      checkbox_asistencia_beneficiario.push(new Array($(this).data('id_beneficiario'), check));
    });
    checkbox_asistencia_beneficiario = JSON.stringify(checkbox_asistencia_beneficiario);
    datos = {
      funcion: 'crearNuevaExperiencia',
      p1: {
        'LugarAtencion': $("#SP_IdLugar").val(),
        'Dupla': $("#SP_IdDupla").val(),
        'Grupo': $("#SP_IdGrupo").val(),
        'FechaEncuentro': $("#TX_Fecha_Encuentro").val(),
        'HoraInicio': $("#TX_Hora_Inicio").val(),
        'HoraFin': $("#TX_Hora_Finalizacion").val(),
        'Experiencia': $("#TX_NomExperiencia").val(),
        'Cuidadores': $("#TX_Cuidadores").val(),
        'Modalidad': $("#TX_Modalidad").val(),
        'Identificacion': $("#TX_Identificacion").val(),
        'Asistencia': $(".asistencia_clase").val(),
        'CH_asistencia_beneficiario': checkbox_asistencia_beneficiario,
        'id_usuario': parent.idUsuario,
        'artistas_asistencia': artistas_asistencia,
        'tipo_suplencia': tipo_suplencia
      }
    };

    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        // mostrar += data;
        if (data) {
          parent.swal("Operación Exitosa.", "<small>Se registró correctamente la asistencia de este grupo.</small>", "success");
          $("#div_registro_asistencia_beneficiarios").hide();
          $("#modal_confirmar_asistencia").modal('hide');
          $("#TX_Fecha_Encuentro").val("");
          $("#TX_Hora_Inicio").val("");
          $("#TX_Hora_Finalizacion").val("");
          $("#TX_NomExperiencia").val("");
          $("#TX_Cuidadores").val("");
          $("#TX_Cuidadores").selectpicker("refresh");
          $("#SL_Lugar_Atencion").html(getLugaryGrupoArtista()).selectpicker("refresh");
          limpiarArtistas(1);
        }
        else
          parent.swal("Operación NO Exitosa.", "<small>Ha ocurrido un error, intente nuevamente.</small>", "error");
      },
      async: false
    });
    return mostrar;
  });

  ///**************************** Modificar asistencia experiencia
  $("#form-modificar-asistencia").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    a_mod_asis = [];
    $('input:checkbox').each(function() {
      a_mod_asis.push({id_asistencia:$(this).data("id_asistencia"),id_beneficiario:$(this).data("id_beneficiario"), estado:Number($(this).is(':checked'))});
    });
    datos = {
      funcion: 'modificarAsistencia',
      p1: {
        'IdExperiencia': id_experiencia,
        'FechaAtencion': $("#SP_Fecha_Mod").val(),
        'HoraInicio': $("#TX_Hora_Inicio_Mod").val(),
        'HoraFin': $("#TX_Hora_Fin_Mod").val(),
        'Experiencia': $("#TX_Nom_Exp_Mod").val(),
        'Modalidad': $("#TX_Modalidad_Mod").val(),
        'tipo_suplencia': tipo_suplencia,
        'artistas_asistencia': artistas_asistencia,
        'cuidadores': $("#TX_Cuidadores_Mod").val(),
        'array_asistencia': a_mod_asis
      }
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        parent.swal("Operación exitosa","Se ha modificado la asistencia correctamente","success");
        if(tipo_persona == 20){
         $("#SL_Duplas").html(getDuplas()).selectpicker("refresh");
       }
       $("#SL_Grupos").html(getLugaryGrupoArtista()).selectpicker("refresh");
       $("#SL_Atenciones").html(getAtencionesGrupo($("#SL_Grupos").val(), tipo_persona)).selectpicker("refresh");
       $("#div-experiencia").hide();
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
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        datos = $.parseJSON(data);
        if(datos['FK_Tipo_Persona'] == 16){
          $("#li-eliminar-experiencia").hide();
          $("#eliminar-experiencia").hide();
        }
        tipo_persona = datos['FK_Tipo_Persona'];
      },
      async: false
    });
  }

  /*-----------------Función para mostrar los lugares y grupos -----------------------*/
  function getLugaryGrupoArtista() {
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

  /*-----------------Función para mostrar las atenciones guardadas-----------------------*/
  function getAtencionesGrupo(id_grupo, tipo_persona){
    var mostrar = "";
    var datos = {
      funcion: 'getAtencionesGrupo',
      'p1': id_grupo,
      'p2': tipo_persona
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

  /*-----------------Función para consultar duplas-----------------------*/
  function getDuplas() {
    var mostrar = "";
    var datos = {
      funcion: 'getConsultarDuplaM',
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
    });
    return mostrar;
  }

  /*-----------------Función para consultar grupos por dupla para los gestores-----------------------*/
  function getGruposDupla(id_dupla) {
    var mostrar = "";
    var datos = {
      funcion: 'getGruposDupla',
      'p1': id_dupla
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



  /*-----------------Función para consultar todas las experiencias registradas en la sección de eliminar-----------------------*/
  function getExperienciasEliminar(id_grupo){
    var datos = {
      funcion: 'getExperienciasEliminar',
      'p1': id_grupo
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        $("#div-experiencias-eliminar").html(data);
        $("#tabla-experiencias-eliminar").DataTable({
          autoWidth: false,
          responsive: true,
          pageLength: 100,
          "order": [[ 2, "asc" ]],
          "language": {
            "lengthMenu": "Ver _MENU_ registros por página",
            "zeroRecords": "No hay información, lo sentimos.",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Filtrar",
            "paginate": {
              "first": "Primera",
              "last": "Ultima",
              "next": "Siguiente",
              "previous": "Anterior"
            },
          }
        });
      },
      async: false
    });
  }

  /*-----------------Función para eliminar una experiencia-----------------------*/
  function eliminarExperiencia(id_experiencia){
    var datos = {
      funcion: 'eliminarExperiencia',
      'p1': id_experiencia
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        if(data > 0){
          parent.swal("Operación exitosa", "Se ha eliminado la experiencia seleccionada", "success");
          getExperienciasEliminar($("#SL_Grupos_Eli").val());
        }else{
          parent.swal("Error", "No se ha podido eliminar la experiencia seleccionada, por favor vuelva a intentarlo", "error"); 
        }
      },
      async: false
    });
  }

  /*----------------ENCABEZADO DE LA EXPERIENCIA---------------------------------------------------*/
  function getInformacionExperiencia() {
    datos = {
      'funcion': 'getInfoExperienciaEncabezado',
      'p1': $("#SL_Atenciones").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      dataType: 'json',
      data: datos,
      success: function(datos){
        id_experiencia = datos["IdExperiencia"];
        $("#SP_Fecha_Mod").val(datos['Fecha']);
        $("#SP_Codigo_Dupla").text(datos['Dupla']);
        $("#SP_Artista").text(datos['NomArtExp']);
        id_dupla = datos['IdDupla'];
        nom_artis_pri = datos['NomArtOri'];
        ids_artistas = datos['IdsArtistasOri'];
        //artistas_asistencia = datos['IdsArtistasExp'].split(",");
        tipo_suplencia = datos["TipoSuplencia"];
        $("#BT_Invitado").removeClass();
        $("#BT_Cambio").removeClass();
        $("#BT_Suplencia").removeClass();
        switch(tipo_suplencia) {
          case "0":
          $("#BT_Invitado").addClass("btn btn-success btn-xs");
          $("#BT_Cambio").addClass("btn btn-success btn-xs");
          $("#BT_Suplencia").addClass("btn btn-success btn-xs");
          break;
          case "1":
          $("#BT_Invitado").addClass("btn btn-success btn-xs");
          $("#BT_Cambio").addClass("btn btn-danger btn-xs");
          $("#BT_Suplencia").addClass("btn btn-danger btn-xs");
          break;
          case "2":
          $("#BT_Invitado").addClass("btn btn-danger btn-xs");
          $("#BT_Cambio").addClass("btn btn-success btn-xs");
          $("#BT_Suplencia").addClass("btn btn-danger btn-xs");
          break;
          case "3":
          $("#BT_Invitado").addClass("btn btn-danger btn-xs");
          $("#BT_Cambio").addClass("btn btn-danger btn-xs");
          $("#BT_Suplencia").addClass("btn btn-success btn-xs");
          break;
        }
        $("#SP_Lugar").text(datos['Tipo_Grupo']);
        $("#SP_Estrategia").text(datos['Estrategia']);
        $("#TX_Hora_Inicio_Mod").val(datos['HoraInicio']);
        $("#TX_Hora_Fin_Mod").val(datos['HoraFin']);
        $("#TX_Nom_Exp_Mod").val(datos['Experiencia']);
        $("#TX_Modalidad_Mod").val(datos['modalidad']).selectpicker('refresh').trigger('change');
        $("#SP_Gestor").text(datos['GESTOR']);
        $("#SP_Eaat").text(datos['EAAT']);
        $("#SP_Responsable").text(datos['Responsable']);
        $("#SP_Grupo").text(datos['Grupo']);
        $("#SP_Localidad").text(datos['Localidad']);
        $("#SP_Tipo_Grupo").text(datos['TIPO_GRUPO']);
        $("#SP_Grado").text(datos['GRADO']);
        datos['Cuidadores'] = datos['Cuidadores'] == null ? 0 : datos['Cuidadores'];
        $("#TX_Cuidadores_Mod").val(datos['Cuidadores']);
      },error:function(data){

      },
      async: false,
    });
  }

  /*----------------Tabla asistencia beneficiarios---------------------------------------------------*/
  var tabla_beneficiarios_modificar_asistencia = $("#tabla-beneficiarios-modificar-asistencia").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    order: [[ 1, "asc" ]],
    "language": {
      "lengthMenu": "Ver _MENU_ registros por pagina",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando pagina _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Filtrar"
    }
  });

  /*----------------BENEFICIARIOS DE LA EXPERIENCIA---------------------------------------------------*/
  function getBeneficiariosModificarExperiencia() {
    tabla_beneficiarios_modificar_asistencia.clear().draw();
    var datos = {
      funcion: 'getBeneficiariosModificarExperiencia',
      'p1': $("#SL_Atenciones").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {},
      async: false
    }).done(function(data) {
      tabla_beneficiarios_modificar_asistencia.rows.add($(data)).draw();
      $('input[type="checkbox"]').bootstrapToggle();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
  }

  /*-----------------Función para obtener el lugar de atención dependiendo del usuario que ingrese-----------------------*/
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
  /*--------------------------------------------------------------------------------------*/

  /*-----------------Función para obtener todos los artistas-----------------------*/
  function getArtistas(tp) {
    var mostrar = "";
    if(tp == 1){
      var datos = {
        funcion: 'getOptionsArtistas',
        'p1': id_dupla,
        'p2': tipo_persona
      };
    }else{
      var datos = {
        funcion: 'getOptionsArtistas',
        'p1': id_dupla,
        'p2': 0
      };
    }
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

  /*--------------------------------------------------------------------------------------*/

  function artistaRemover(){
    var datos = {
      funcion: 'artistaRemover',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        artista_remover = $.parseJSON(data);
      },
      async: false
    });
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
        nom_artis_pri = datos['ARTISTAS'];
        ids_artistas = datos['IdsArtistas'];
        $(".SP_Localidad").text(datos['VC_Nom_Localidad']);
        $(".SP_Codigo_Dupla").text(datos['VC_Codigo_Dupla']);
        $(".SP_Lugar_Atencion").text(datos['VC_Nombre_Lugar']);
        $(".SP_Grupo").text(datos['VC_Nombre_Grupo']);
        $(".SP_Tipo_Grupo").text(datos['TIPO_GRUPO']);
        $(".SP_Grado").text(datos['GRADO']);    
        $(".SP_Artista").text(datos['ARTISTAS']);
        $(".SP_Gestor").text(datos['GESTOR']);
        $(".SP_Eaat").text(datos['EAAT']);    
        /*$("#SP_Upz").text(datos['VC_Nombre_Upz']);
        $("#SP_Responsable").text(datos['VC_Profesional_Responsable']);
        $(".SP_Lugar").text(datos['Vc_Descripcion']);
        $("#SP_Estrategia").text(datos['Vc_Estrategia']);   
        $("#SP_Barrio").text(datos['VC_Barrio']);
        $("#SP_Direccion").text(datos['VC_Direccion']);*/
        $("#SP_IdLugar").val(datos['Pk_Id_Lugar_atencion']);
        $("#SP_IdGrupo").val(datos['Pk_Id_Grupo']);
        $("#SP_IdDupla").val(datos['Pk_Id_Dupla']);        
        id_dupla = datos['Pk_Id_Dupla'];
      } catch (ex) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos del grupo");
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se ha podido precargar los datos del lugar que desea modificar");
    });
  }

  function getInformacionGrupoProteccion() {
    var mostrar = "";
    datos = {
      'funcion': 'getInfoExperiencia',
      'p1': $("#SL_Lugar_Atencion_Proteccion").val()
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
        nom_artis_pri = datos['ARTISTAS'];
        ids_artistas = datos['IdsArtistas'];
        $(".SP_Localidad_Proteccion").text(datos['VC_Nom_Localidad']);
        $(".SP_Codigo_Dupla_Proteccion").text(datos['VC_Codigo_Dupla']);
        $(".SP_Lugar_Atencion_Proteccion").text(datos['VC_Nombre_Lugar']);
        $(".SP_Grupo_Proteccion").text(datos['VC_Nombre_Grupo']);
        $(".SP_Tipo_Grupo_Proteccion").text(datos['TIPO_GRUPO']);
        $(".SP_Grado_Proteccion").text(datos['GRADO']);    
        $(".SP_Artista_Proteccion").text(datos['ARTISTAS']);
        $(".SP_Gestor_Proteccion").text(datos['GESTOR']);
        $(".SP_Eaat_Proteccion").text(datos['EAAT']);    
        $("#SP_IdLugar_Proteccion").val(datos['Pk_Id_Lugar_atencion']);
        $("#SP_IdGrupo_Proteccion").val(datos['Pk_Id_Grupo']);
        $("#SP_IdDupla_Proteccion").val(datos['Pk_Id_Dupla']);        
        id_dupla = datos['Pk_Id_Dupla'];
      } catch (ex) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos del grupo");
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se ha podido precargar los datos del lugar que desea modificar");
    });
  }

  function getBeneficiariosXGrupo() {
    $("#SP_checkbox_all").remove();
    tabla_asistencia_beneficiarios.clear().draw();
    $("#tabla_asistencia_beneficiarios_filter").prepend("<span id='SP_checkbox_all'>Seleccionar/Deseleccionar todos&nbsp&nbsp<input id='checkbox_all' data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox'>&nbsp&nbsp</span>");
    $("#div_tabla_asistencia_beneficiarios").show();
    var fecha_encuentro = moment($("#TX_Fecha_Encuentro").datepicker('getDate'));

    var datos = {
      funcion: 'getBeneficiariosAsistencia',
      'p1': $("#SL_Lugar_Atencion").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        datos = $.parseJSON(data);
        console.log(datos);
        cantidad = Object.keys(datos).length;
        
        for(i=0;i<cantidad;i++){
          var edad = "";
          var fecha_nacimiento = moment(datos[i]["Fecha de nacimiento"]);
          var Imagen = datos[i]["Imagen"];
          var Primera = datos[i]["PRIMERA"];
          console.log(Imagen);

          var years = fecha_encuentro.diff(fecha_nacimiento, 'year');
          fecha_nacimiento.add(years, 'years');

          var months = fecha_encuentro.diff(fecha_nacimiento, 'months');
          fecha_nacimiento.add(months, 'months');

          var days = fecha_encuentro.diff(fecha_nacimiento, 'days');

          if(fecha_nacimiento > fecha_encuentro){
            edad = "Error, la fecha de nacimiento es mayor a la fecha de encuentro";

          }else{
            if(years == 1){
              edad = edad + years + " año ";
            }
            if(years > 1){
              edad = edad + years + " años ";
            }
            if(months == 1){
              edad = edad + months + " mes ";
            }
            if(months > 1){
              edad = edad + months + " meses ";
            }
            if(days == 1){
              edad = edad + days + " día";
            }
            if(days > 1){
              edad = edad + days + " días";
            }
          }
          var re = "";
          var cb = "";
          var pr = "";
          var be = "";
          var ud = "";
          var nb = "";
          var bgColor = "";
         /* if(Imagen == null){

            bgColor = "#f7b4b4";
            re = "<center> --- </center>";
            cb = "<center>No tiene Uso de Datos</center>";
            be = "<center><span  class='btn btn-warning UsoDatosManual' data-id-identificacion='"+datos[i]["IDENTIFICACION"]+"' data-id-beneficiario='"+datos[i]["BENEFICIARIO"]+"' data-toggle='modal' data-target='#modal-uso-datos-manual'>"+datos[i]["BENEFICIARIO"]+"</span></center>";

        }else{ */
          //be = "<center>"+datos[i]["BENEFICIARIO"]+"</center>";
          if(years < 0){
            bgColor = "#f7b4b4";
            re = "<center>Error, fecha de nacimiento es mayor a la fecha de encuentro</center>";
            cb = "<center>No se permite registrar asistencia</center>";
          }
          if(years >= 0 && years < 4){
            if(datos[i]["GENERO"] == "MASCULINO"){
              re = "<center>Niño de 1 mes a 3 años</center>";
              cb = "<center><input id='checkbox_"+ i +"' data-genero_beneficiario='MASCULINO' data-rango_edad_beneficiario='Niño de 1 mes a 3 años' data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario[]' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_beneficiario='"+datos[i]["IDBENEFICIARIO"]+"' class='asistencia_experiencia'></center>";
            }else{
              re = "<center>Niña de 1 mes a 3 años</center>";
              cb = "<center><input id='checkbox_"+ i +"' data-genero_beneficiario='FEMENINO' data-rango_edad_beneficiario='Niña de 1 mes a 3 años' data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario[]' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_beneficiario='"+datos[i]["IDBENEFICIARIO"]+"' class='asistencia_experiencia'></center>";
            }
          }
          if(years >= 4 && years < 6){
            if(datos[i]["GENERO"] == "MASCULINO"){
              re = "<center>Niño de 4 años a 5 años</center>";
              cb = "<center><input id='checkbox_"+ i +"' data-genero_beneficiario='MASCULINO' data-rango_edad_beneficiario='Niño de 4 años a 6 años' data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario[]' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_beneficiario='"+datos[i]["IDBENEFICIARIO"]+"' class='asistencia_experiencia'></center>";
            }else{
              re = "<center>Niña de 4 años a 5 años</center>";
              cb = "<center><input id='checkbox_"+ i +"' data-genero_beneficiario='FEMENINO' data-rango_edad_beneficiario='Niña de 4 años a 6 años' data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario[]' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_beneficiario='"+datos[i]["IDBENEFICIARIO"]+"' class='asistencia_experiencia'></center>";
            }
          }
          if(years == 6){
            if(datos[i]["GENERO"] == "MASCULINO"){
              re = "<center>Niño de 6 años</center>";
              cb = "<center><input id='checkbox_"+ i +"' data-genero_beneficiario='MASCULINO' data-rango_edad_beneficiario='Niño de 4 años a 6 años' data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario[]' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_beneficiario='"+datos[i]["IDBENEFICIARIO"]+"' class='asistencia_experiencia'></center>";
            }else{
              re = "<center>Niña de 6 años</center>";
              cb = "<center><input id='checkbox_"+ i +"' data-genero_beneficiario='FEMENINO' data-rango_edad_beneficiario='Niña de 4 años a 6 años' data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario[]' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_beneficiario='"+datos[i]["IDBENEFICIARIO"]+"' class='asistencia_experiencia'></center>";
            }
          }
          if(years >= 7 && years < 10){
            if(datos[i]["GENERO"] == "MASCULINO"){
              bgColor = "#f7b4b4";
              re = "<center>Niño supera la edad permitida</center>"
              cb = "<center>No se permite registrar asistencia</center>";
            }else{
              bgColor = "#f7b4b4";
              re = "<center>Niña supera la edad permitida</center>";
              cb = "<center>No se permite registrar asistencia</center>";
            }
          }
          if(years >= 11){
            if(datos[i]["GENERO"] == "MASCULINO"){
              bgColor = "#f7b4b4";
              re = "<center>Niño supera la edad permitida</center>"
              cb = "<center>No se permite registrar asistencia</center>";
            }else{
              re = "<center>Madre gestante</center>";
              cb = "<center><input id='checkbox_"+ i +"' data-genero_beneficiario='FEMENINO' data-rango_edad_beneficiario='Madre gestante' data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario[]' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_beneficiario='"+datos[i]["IDBENEFICIARIO"]+"' class='asistencia_experiencia'></center>";
            }
          }
        //}  
        var bgColor1 = "";
        if(Primera == null){
          bgColor1 = "#82E0AA";
          pr = "<center> NUEVO </center>";
        }else{
          pr = "<center>"+datos[i]["PRIMERA"]+"</center>";
        }

        var bgColorDatos = "";
        if(Imagen == null){
          bgColorDatos = "#f7b4b4";
          ud = "<center>NO TIENE AUTORIZACIÓN</center>";
        }else{
          bgColorDatos = "#82E0AA";
          ud = "<center>SI TIENE AUTORIZACIÓN</center>";
        }

        var bgColorDatos = "";
        if(Imagen == null){
          bgColorDatos = "#f7b4b4";
          nb = "<center><span  class='btn btn-warning UsoDatosManual' data-id-identificacion='"+datos[i]["IDENTIFICACION"]+"' data-id-beneficiario='"+datos[i]["BENEFICIARIO"]+"' data-toggle='modal' data-target='#modal-uso-datos-manual'>"+datos[i]["BENEFICIARIO"]+"</span></center>";
        }else{
          bgColorDatos = "#82E0AA";
          nb = "<center>"+datos[i]["BENEFICIARIO"]+"</center>";
        }
          

          var rowNode = tabla_asistencia_beneficiarios.row.add([
            "<center>"+datos[i]["IDENTIFICACION"]+"</center>",
            nb,
            "<center>"+datos[i]["GENERO"]+"</center>",
            "<center>"+datos[i]["Enfoque"]+"</center>",
            pr,
            "<center>"+edad+"</center>",
            re,
            ud,
            cb
            ]).draw().node();
          if (bgColor != "") {
            $( rowNode ).find('td').eq(5).css('background-color',bgColor);
            $( rowNode ).find('td').eq(6).css('background-color',bgColor);
            $( rowNode ).find('td').eq(8).css('background-color',bgColor);
          }
          if (bgColor1 != "") {
            $( rowNode ).find('td').eq(4).css('background-color',bgColor1);
          }

          if (bgColorDatos != "") {
            $( rowNode ).find('td').eq(7).css('background-color',bgColorDatos);
          }


          if(datos[i]["Enfoque"] == "AFRODESCENDIENTE"){
            $("#checkbox_"+ i).attr("data-enfoque-beneficiario", "AFRODESCENDIENTE");
          }
          if(datos[i]["Enfoque"] == "COMUNIDAD RURAL Y CAMPESINA"){
            $("#checkbox_"+ i).attr("data-enfoque-beneficiario", "COMUNIDAD RURAL Y CAMPESINA");
          }
          if(datos[i]["Enfoque"] == "CONDICIÓN DE DISCAPACIDAD"){
            $("#checkbox_"+ i).attr("data-enfoque-beneficiario", "CONDICIÓN DE DISCAPACIDAD");
          }
          if(datos[i]["Enfoque"] == "CONFLICTO ARMADO"){
            $("#checkbox_"+ i).attr("data-enfoque-beneficiario", "CONFLICTO ARMADO");
          }
          if(datos[i]["Enfoque"] == "INDÍGENA"){
            $("#checkbox_"+ i).attr("data-enfoque-beneficiario", "INDÍGENA");
          }
          if(datos[i]["Enfoque"] == "MENORES PRIVADOS DE LA LIBERTAD"){
            $("#checkbox_"+ i).attr("data-enfoque-beneficiario", "MENORES PRIVADOS DE LA LIBERTAD");
          }
          if(datos[i]["Enfoque"] == "RAIZALES"){
            $("#checkbox_"+ i).attr("data-enfoque-beneficiario", "RAIZALES");
          }
          if(datos[i]["Enfoque"] == "ROM"){
            $("#checkbox_"+ i).attr("data-enfoque-beneficiario", "ROM");
          }
        }
      },
      async: false
    }).done(function(data) {
      $('input[type="checkbox"]').bootstrapToggle();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
  }

  $("#tabla_asistencia_beneficiarios").on("click", ".UsoDatosManual",  function(){
    $("#TX_uso_datos").val("");
		$("#TX_identificacion").val($(this).attr("data-id-identificacion"));
    $("#lb_identificacion").html("").html($(this).attr("data-id-identificacion"));
		$("#lb_beneficiario").html("").html($(this).attr("data-id-beneficiario"));
	});

    ///**************************** Modificar asistencia experiencia
    $("#form-uso-datos-manual").submit(function(event) {
      event.stopPropagation();
      event.preventDefault();
      datos = {
        funcion: 'cargarUsoDatosManual',
        p1: {
          'Identificacion': $("#TX_identificacion").val(),
          'AutorizacionDatos': $("#TX_uso_datos").val()
        }
      };
      $.ajax({
        url: url_ok_obj,
        type: 'POST',
        data: datos,
        success: function(data) {
          parent.swal("Operación exitosa","Se cargo correctamente la autorización de uso de datos del beneficiario","success");
          $("#modal-uso-datos-manual").modal('hide');
          //getInformacionGrupo();
          //$("#tabla_asistencia_beneficiarios").show("refresh"); 
          //cargarDatos();
          getBeneficiariosXGrupo();
       },
       async: false
     });
    });

  //+++++++++++ FUNCIONES PESTAÑA DE CONSULTAR EXPERIENCIAS GUARDADAS
  /*-----------------Función para obtener todos los artistas-----------------------*/
  function getExperienciasGrupo(LugarGrupo) {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsExperienciaGrupo',
      'p1': LugarGrupo
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

  /*-----------------Función para obtener EL ENCABEZADO DE LAS EXPERIENCIAS GUARDADAS---------------------*/
  function getInformacionExperienciaGuardada() {
    var mostrar = "";
    datos = {
      'funcion': 'getInfoEncabezadoExperiencia',
      'p1': $("#SL_Atencion").val()
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
        $("#SP_Exp_Fecha").text(datos['FECHA']);
        $("#SP_Exp_CDupla").text(datos['CODIGO_DUPLA']);
        $("#SP_Exp_Artistas").text(datos['ARTISTAS']);
        $("#SP_Exp_TLugar").text(datos['TIPO_LUGAR']);
        $("#SP_Exp_Estrategia").text(datos['ESTRATEGIA']);
        $("#SP_Exp_Hora").text(datos['HORA']);
        $("#SP_Exp_Experiencia").text(datos['EXPERIENCIA']);
        $("#SP_Exp_Gestor").text(datos['GESTOR']);
        $("#SP_Exp_Eaat").text(datos['EAAT']);
        $("#SP_Exp_Responsable").text(datos['RESPONSABLE']);
        $("#SP_Exp_Localidad").text(datos['LOCALIDAD']);
        $("#SP_Exp_Upz").text(datos['UPZ']);
        $("#SP_Exp_Barrio").text(datos['BARRIO']);
        $("#SP_Exp_Lugar").text(datos['LUGAR']);
        $("#SP_Exp_Grupo").text(datos['GRUPO']);
        $("#SP_Exp_Cuidadores").text(datos['CUIDADORES']);

      } catch (ex) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos del grupo");
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se ha podido precargar los datos del lugar que desea modificar");
    });
  }


  /*--------------------------------------------------------------------------------------*/
  var tabla_asistencia_beneficiario = $("#tabla_asistencia_beneficiario").DataTable({
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
  function consultarAsistenciaExperiencia() {
    var mostrar = "";
    tabla_asistencia_beneficiario.clear().draw();
    var datos = {
      funcion: 'getConsultaAsistenciaBeneficiarios',
      'p1': $("#SL_Atencion").val()
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
      tabla_asistencia_beneficiario.rows.add($(data)).draw();
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
    return mostrar;
  }

  function validarExperienciaDuplicada(){
    datos = {
      'funcion': 'validarExperienciaDuplicada',
      'p1': $("#SL_Lugar_Atencion").val(),
      'p2': $("#TX_Fecha_Encuentro").val()
    };

    $.ajax({
      url: url_ok_obj,
      dataType: "html",
      type: "POST",
      data: datos,
      success: function(data){
        if (data == 1) {
          parent.swal("Alerta", "Por favor tenga en cuenta que ya se ha registrado una experiencia para la fecha seleccionada, si necesita realizar alguna modificación le sugerimos utilizar la actividad <strong>Modificar experiencia</strong>.", "warning"); 
        }
      },error: function(data){
      },
      async: false
    });

  }
   /*----------------ENCABEZADO DE LA EXPERIENCIA-----------------------------*/
   function getInformacionCifras() {
    datos = {
      'funcion': 'getInfoExperienciaEncabezado',
      'p1': $("#SL_Atencion_cifras").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      dataType: 'json',
      data: datos,
      success: function(datos){
        id_experiencia = datos["IdExperiencia"];
        $("#TX_Fecha_Encuentro_cifras").val(datos['Fecha']);
        $("#SP_Codigo_Dupla").text(datos['Dupla']);
        $("#TX_Hora_Inicio_cifras").val(datos['HoraInicio']);
        $("#TX_Hora_Finalizacion_cifras").val(datos['HoraFin']);
        $("#TX_NomExperiencia_cifras").val(datos['Experiencia']);        
        $("#TX_Cuidadores_cifras").val(datos['Cuidadores']);
        $("#LB_Uso_Datos").html(datos['BENEFICIARIOS']);
        
      },error:function(data){

      },
      async: false,
    });
  }

     /*----------------ENCABEZADO DE LA EXPERIENCIA CIFRAS-----------------------------*/
     function getDuplaArtista() {
      var datos = {
        funcion: 'ConsultaDuplaArtista',
        'p1': parent.idUsuario
      };
      $.ajax({
        url: url_ok_obj,
        type: 'POST',
        dataType: 'json',
        data: datos,
        success: function(datos){          
          $("#TX_Dupla_Proteccion").val(datos['IDDUPLA']);
        },error:function(data){
  
        },
        async: false,
      });
    }

    function getLugarGrupo() {
      var datos = {
        funcion: 'ConsultaLugarGrupo',
        'p1': $("#SL_Lugar_Atencion_Proteccion").val()
      };
      $.ajax({
        url: url_ok_obj,
        type: 'POST',
        dataType: 'json',
        data: datos,
        success: function(datos){          
          $("#TX_Lugar_Proteccion").val(datos['IDLUGAR']);
        },error:function(data){
  
        },
        async: false,
      });
    }



  $("#form-beneficiarios-sin-info").submit(function(e){
    e.preventDefault();
        guardarBeneficiariosSinInfo();
  });

  function guardarBeneficiariosSinInfo() {
    var totalninosreal = parseFloat($("#tx-ninos-cero-tres").val()) + parseFloat($("#tx-ninos-tres-seis").val()) + parseFloat($("#tx-ninos-seis-anios").val());
    var totalninasreal = parseFloat($("#tx-ninas-cero-tres").val()) + parseFloat($("#tx-ninas-tres-seis").val()) + parseFloat($("#tx-ninas-seis-anios").val());
    var totalninosnuevos = parseFloat($("#tx-ninos-cero-tres-nuevos").val()) + parseFloat($("#tx-ninos-tres-seis-nuevos").val()) + parseFloat($("#tx-ninos-seis-anios-nuevos").val());
    var totalninasnuevos = parseFloat($("#tx-ninas-cero-tres-nuevos").val()) + parseFloat($("#tx-ninas-tres-seis-nuevos").val()) + parseFloat($("#tx-ninas-seis-anios-nuevos").val());
    var datos = new FormData();
    formulario = {};   
      
    formulario['LugarAtencion'] = $("#TX_Lugar_Proteccion").val();
    formulario['Dupla'] = $("#TX_Dupla_Proteccion").val();
    formulario['Grupo'] = $("#SL_Lugar_Atencion_Proteccion").val();
    formulario['Experiencia'] = $("#TX_NomExperiencia_Proteccion").val();
    formulario['FechaEncuentro'] = $("#TX_Fecha_Encuentro_Proteccion").val();
    formulario['HoraInicio'] = $("#TX_Hora_Inicio_Proteccion").val();
    formulario['HoraFin'] = $("#TX_Hora_Finalizacion_Proteccion").val();
    formulario['Cuidadores'] = $("#TX_Cuidadores_Proteccion").val();
    formulario['id_usuario'] =  $("#TX_Dupla_Proteccion").val();
    formulario['tipo_suplencia' ] = '0';

    formulario['total_atendidos'] = $("#tx-total-beneficiarios-real").val();
    formulario['gestantes_atendidos'] = $("#tx-mujeres").val();
    formulario['ninos_atendidos'] = totalninosreal;
    formulario['ninos0a3_atendidos'] = $("#tx-ninos-cero-tres").val();
    formulario['ninos4a6_atendidos'] = $("#tx-ninos-tres-seis").val();
    formulario['ninos6_atendidos'] = $("#tx-ninos-seis-anios").val();
    formulario['ninas_atendidos'] = totalninasreal;
    formulario['ninas0a3_atendidos'] = $("#tx-ninas-cero-tres").val();
    formulario['ninas4a6_atendidos'] = $("#tx-ninas-tres-seis").val();
    formulario['ninas6_atendidos'] = $("#tx-ninas-seis-anios").val();

    formulario['afro'] = $("#tx-afro").val();
    formulario['rural'] = $("#tx-rural").val();
    formulario['discapacidad'] = $("#tx-discapacidad").val();
    formulario['conflicto'] = $("#tx-conflicto").val();
    formulario['indigena'] = $("#tx-indigena").val();
    formulario['liberta'] = $("#tx-libertad").val();
    formulario['violencia'] = $("#tx-violencia").val();
    formulario['raizal'] = $("#tx-raizal").val();
    formulario['rom'] = $("#tx-rom").val();

    formulario['total_nuevos'] = $("#tx-total-beneficiarios-nuevos").val();
    formulario['gestantes_nuevos'] = $("#tx-mujeres-nuevos").val();
    formulario['ninos_nuevos'] = totalninosnuevos;
    formulario['ninos0a3_nuevos'] = $("#tx-ninos-cero-tres-nuevos").val();
    formulario['ninos4a6_nuevos'] = $("#tx-ninos-tres-seis-nuevos").val();
    formulario['ninos6_nuevos'] = $("#tx-ninos-seis-anios-nuevos").val();
    formulario['ninas_nuevos'] = totalninasnuevos;
    formulario['ninas0a3_nuevos'] = $("#tx-ninas-cero-tres-nuevos").val();
    formulario['ninas4a6_nuevos'] = $("#tx-ninas-tres-seis-nuevos").val();
    formulario['ninas6_nuevos'] = $("#tx-ninas-seis-anios-nuevos").val();

    formulario['afro_nuevos'] = $("#tx-afro-nuevos").val();
    formulario['rural_nuevos'] = $("#tx-rural-nuevos").val();
    formulario['discapacidad_nuevos'] = $("#tx-discapacidad-nuevos").val();
    formulario['conflicto_nuevos'] = $("#tx-conflicto-nuevos").val();
    formulario['indigena_nuevos'] = $("#tx-indigena-nuevos").val();
    formulario['liberta_nuevos'] = $("#tx-libertad-nuevos").val();
    formulario['violencia_nuevos'] = $("#tx-violencia-nuevos").val();
    formulario['raizal_nuevos'] = $("#tx-raizal-nuevos").val();
    formulario['rom_nuevos'] = $("#tx-rom-nuevos").val(); 

    var archivo = $("#fl-documento")[0].files[0];

    datos.append('funcion', 'guardarBeneficiariosSinInfo'); 
    datos.append("p1", JSON.stringify(formulario));  
    datos.append("p3", archivo);

    $.ajax({
      contentType: false,
      processData: false,
      dataType: "html",
      type: "POST",
      url: url_ok_obj,
      data: datos,
      success: function(data){
        if(data == 1){
          parent.swal({
            confirmButtonColor: '#3f9a9d',
            title: 'Operación exitosa!',
            html: '<small>La información se ha guardado exitosamente</small>',
            type: 'success',
            confirmButtonText: 'Aceptar',
          }).then(() => {
            $(":input").val('');
            $('#suma-ninos03-real').html("");
            $('#suma-ninos45-real').html("");
            $('#suma-ninos6-real').html("");
            $('#total-beneficiarios-real').html("");            
            $('#suma-gestantes-real').html("");
            $('#suma-ninos03-nuevos').html("");
            $('#suma-ninos45-nuevos').html("");
            $('#suma-ninos6-nuevos').html("");
            $('#suma-gestantes-nuevos').html("");
            $('#total-beneficiarios-nuevos').html("");
            $('.selectpicker').selectpicker('val', '');
            $("#div_registro_experiencia").hide('refresh');
            $("#div_registro_cifras").hide("refresh");
          }).catch(parent.swal.noop);
        }else{
          parent.swal("Error!", "No se ha podido guardar la información, por favor vuelva a intentarlo", "error");
        }
      },
      async: false
    });
  }

  function getMes() {
    var datos = {
      funcion: 'getOptionsMes'
    };
    $.ajax({
      url: url_ok_obj2,
      type: 'POST',
      data: datos,
      success: function(data) {
        options_mes += data
      },
      async: false
    });
    return options_mes;
  }
  
  var table_lugar_atencion = $("#table-lugar-atencion").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
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

  var table_lugar_laboratorio = $("#table-lugar-laboratorio").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
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

  tabla_config = {
		paging: false,
		scrollX: true,
		scrollCollapse: true,
		fixedColumns:{
			leftColumns: 6,
		},
		scrollY: "600px",
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
	};

	table_reporte_experiencias = $("#table-reporte-experiencias").DataTable(tabla_config);

  $("#btn-beneficiarios-registrados").on("click", function(){
    $("#div-reporte-evento").show();
    consultarTotalExperienciasMes();
    consultarExperienciaLugarDupla();
    consultarExperienciaLaboratorioDupla();
    getReporteExperiencias();
    
  });

  function consultarTotalExperienciasMes() {
    var mostrar = "";
    datos = {
      'funcion': 'consultarTotalExperienciasMes',
      'p1': $("#SL_Mes_Reporte").val(),
      'p2': parent.idUsuario
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
        $("#SP_Total_Atenciones").text(datos['TOTAL']);
      } catch (ex) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos del grupo");
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se ha podido precargar los datos del lugar que desea modificar");
    });
  }

function getReporteExperiencias() {
  parent.mostrarCargando();
  table_reporte_experiencias.clear().draw();
  var datos = {
    funcion: 'getConsultaAsistenciasDupla',
    'p1': $("#SL_Mes_Reporte").val(),
    'p2': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      table_reporte_experiencias.rows.add($(data)).draw();
      parent.cerrarCargando();
    },
    async: true
  })
}

function consultarExperienciaLugarDupla() {
  parent.mostrarCargando();
  table_lugar_atencion.clear().draw();
  var datos = {
    funcion: 'consultarExperienciaLugarDupla',
    'p1': $("#SL_Mes_Reporte").val(),
    'p2': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      table_lugar_atencion.rows.add($(data)).draw();
      parent.cerrarCargando();
    },
    async: true
  })
}

function consultarExperienciaLaboratorioDupla() {
  parent.mostrarCargando();
  table_lugar_laboratorio.clear().draw();
  var datos = {
    funcion: 'consultarExperienciaLaboratorioDupla',
    'p1': $("#SL_Mes_Reporte").val(),
    'p2': parent.idUsuario
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    success: function(data) {
      table_lugar_laboratorio.rows.add($(data)).draw();
      parent.cerrarCargando();
    },
    async: true
  })
}


$("#table-lugar-atencion").on("click", ".borrar", function() {
  parent.swal({
    confirmButtonColor: '#3f9a9d',
    title: 'Eliminar listado de asistencia',
    html: '<small>¿Está seguro de que quiere eliminar el soporte del listado de asistencia?</small>',
    type: 'warning',
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
    showCancelButton: true, 
    width: 800,
  }).then(() => {
    var idExperiencia = $(this).data("id-soporte");
    var soporte = $(this).data("soporte");
    borrarArchivo(idExperiencia,soporte);
  },(confirm) => {
    if (confirm == "cancel"){
    }
  }).catch(parent.swal.noop);
});

$("#table-lugar-laboratorio").on("click", ".borrar", function() {
  parent.swal({
    confirmButtonColor: '#3f9a9d',
    title: 'Eliminar listado de asistencia',
    html: '<small>¿Está seguro de que quiere eliminar el soporte del listado de asistencia?</small>',
    type: 'warning',
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
    showCancelButton: true, 
    width: 800,
  }).then(() => {
    var idExperiencia = $(this).data("id-soporte");
    var soporte = $(this).data("soporte");
    borrarArchivo(idExperiencia,soporte);
  },(confirm) => {
    if (confirm == "cancel"){
    }
  }).catch(parent.swal.noop);
});

function borrarArchivo(idExperiencia,soporte){
  datos = {
    'funcion': 'borrarArchivo',
    'p1': idExperiencia,
    'p2': soporte
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
          html: '<small>Se ha eliminado el documento de soporte de la institución</small>',
          type: 'success',
          confirmButtonText: 'Aceptar', 
          width: 800,
        }).then(() => {
          consultarExperienciaLugarDupla();
          consultarExperienciaLaboratorioDupla();
        });
      }
      else
        parent.swal("Error","No se ha podido eliminar el documento, por favor vuelva a intentarlo","danger");
    },
    fail: function(data){
    },
  });

}
/*  table-lugar-atencion  */
$("#table-lugar-atencion").on("click", ".subir-imagen", function() {
  var idLugar = $(this).data("idlugar");
  var idDupla = $(this).data("dupla");

  if($(this).closest("td").find(".TX_Listado_Asistencia").val() == ""){
    parent.swal("Advertencia", "Por favor seleccione un archivo", "warning");
  }else{
    if($(this).closest("td").find(".TX_Listado_Asistencia")[0].files[0].size > 10242880){
      parent.swal("Advertencia", "El archivo no puede pesar más de 10MB", "warning");
    }else{
     var archivo = $(this).closest("td").find(".TX_Listado_Asistencia")[0].files[0];
     subirUsoImagen(archivo, idLugar, idDupla);
   }
 }
});

$("#table-lugar-laboratorio").on("click", ".subir-imagen", function() {
  var idLugar = $(this).data("idlugar");
  var idDupla = $(this).data("dupla");

  if($(this).closest("td").find(".TX_Listado_Asistencia").val() == ""){
    parent.swal("Advertencia", "Por favor seleccione un archivo", "warning");
  }else{
    if($(this).closest("td").find(".TX_Listado_Asistencia")[0].files[0].size > 10242880){
      parent.swal("Advertencia", "El archivo no puede pesar más de 10MB", "warning");
    }else{
     var archivo = $(this).closest("td").find(".TX_Listado_Asistencia")[0].files[0];
     subirUsoImagen(archivo, idLugar, idDupla);
   }
 }
});


function subirUsoImagen(archivo, idLugar, idDupla){
  var datos = new FormData();
  formulario = {};

  formulario['id_lugar'] = idLugar;
  formulario['id_dupla'] = idDupla;
  formulario['id_mes'] = $("#SL_Mes_Reporte").val();

  datos.append('funcion', 'subirUsoImagen');
  datos.append('p1', JSON.stringify(formulario));
  datos.append('p3', archivo);

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
          html: '<small>Se ha subido el soporte de las atenciones del lugar seleccionado.</small>',
          type: 'success',
          confirmButtonText: 'Aceptar', 
          width: 800,
        }).then(() => {
          consultarExperienciaLugarDupla();
          consultarExperienciaLaboratorioDupla();
        });
      }
      else
        parent.swal("Error","No se ha podido subir el documento, por favor vuelva a intentarlo","danger");

    },
    fail: function(data){
    },
  });
}


$("#table-reporte-experiencias").on("click", ".eliminarexperiencia", function() {
  var idExperiencia = $(this).data("id-registro");
  var Nombre = $(this).data("experiencia");
  var Grupo = $(this).data("grupo");
  var Fecha = $(this).data("fecha");
  parent.swal({
    confirmButtonColor: '#3f9a9d',
    title: 'Eliminar registro de experiencia',
    html: '<small>¿Está seguro de que quiere eliminar la experiencia del grupo '+ Grupo +' con nombre '+ Nombre +' del día '+ Fecha +'?</small>',
    type: 'warning',
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
    showCancelButton: true, 
    width: 800,
  }).then(() => {
    eliminarExperienciaCifras(idExperiencia);
  },(confirm) => {
    if (confirm == "cancel"){
    }
  }).catch(parent.swal.noop);
});

function eliminarExperienciaCifras(idExperiencia){
  console.log(idExperiencia);
  datos = {
    'funcion': 'eliminarExperienciaCifras',
    'p1': idExperiencia
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
          html: '<small>Se ha eliminado la experiencia en cifras correctamente</small>',
          type: 'success',
          confirmButtonText: 'Aceptar', 
          width: 800,
        }).then(() => {
          getReporteExperiencias();
        });
      }
      else
        parent.swal("Error","No se ha podido elimiar documento, por favor vuelva a intentarlo","danger");
    },
    fail: function(data){
    },
  });

}

$("table").delegate(".editarEvento", "click", function() {
  //var idEventoEditar = $(this).data("id-evento");
  $("#TX_ID_Experiencia_Editar").val($(this).data("id-experiencia"));

  $("#tx-ninos-cero-tres-M").val($(this).data("ninos03real"));
  $("#tx-ninos-tres-seis-M").val($(this).data("ninos46real"));
  $("#tx-ninos-M").val($(this).data("totalninosreal"));
  $("#tx-ninas-cero-tres-M").val($(this).data("ninas03real"));
  $("#tx-ninas-tres-seis-M").val($(this).data("ninas46real"));
  $("#tx-ninas-M").val($(this).data("totalninasreal"));
  $("#tx-mujeres-M").val($(this).data("gestantesreal"));
  $("#tx-total-M").val($(this).data("totalreal"));
  $("#tx-afro-M").val($(this).data("afroreal"));
  $("#tx-rural-M").val($(this).data("campesinoreal"));
  $("#tx-discapacidad-M").val($(this).data("discapacidadreal"));
  $("#tx-conflicto-M").val($(this).data("conflictoreal"));
  $("#tx-indigena-M").val($(this).data("indigenareal"));
  $("#tx-libertad-M").val($(this).data("privadosreal"));
  $("#tx-violencia-M").val($(this).data("victimasreal"));
  $("#tx-raizal-M").val($(this).data("raizalreal"));
  $("#tx-rom-M").val($(this).data("romreal"));	
  $("#tx-ninos-cero-tres-nuevos-M").val($(this).data("ninos03nuevos"));
  $("#tx-ninos-tres-seis-nuevos-M").val($(this).data("ninos46nuevos"));
  $("#tx-ninos-nuevos-M").val($(this).data("totalninosnuevos"));
  $("#tx-ninas-cero-tres-nuevos-M").val($(this).data("ninas03nuevos"));
  $("#tx-ninas-tres-seis-nuevos-M").val($(this).data("ninas46nuevos"));
  $("#tx-ninas-nuevos-M").val($(this).data("totalninasnuevos"));
  $("#tx-mujeres-nuevos-M").val($(this).data("gestantesnuevos"));
  $("#tx-total-nuevos-M").val($(this).data("totalnuevos"));
  $("#tx-afro-nuevos-M").val($(this).data("afronuevos"));
  $("#tx-rural-nuevos-M").val($(this).data("campesinonuevos"));
  $("#tx-discapacidad-nuevos-M").val($(this).data("discapacidadnuevos"));
  $("#tx-conflicto-nuevos-M").val($(this).data("conflictonuevos"));
  $("#tx-indigena-nuevos-M").val($(this).data("indigenasnuevos"));
  $("#tx-libertad-nuevos-M").val($(this).data("privadosnuevos"));
  $("#tx-violencia-nuevos-M").val($(this).data("victimasnuevos"));
  $("#tx-raizal-nuevos-M").val($(this).data("raizalnuevos"));
  $("#tx-rom-nuevos-M").val($(this).data("romnuevos"));
});

$("#form_editar_experiencia_div").submit(function(e){
  e.preventDefault();
  if(+$("#tx-ninos-M").val() + +$("#tx-ninas-M").val() + +$("#tx-mujeres-M").val() != +$("#tx-total-M").val()){
    parent.swal("Error","La cantidad debeneficiarios por grupo etario  es superior o inferior al total (ASISTENCIA REAL)","error");
  }else if(+$("#tx-ninos-cero-tres-M").val() + +$("#tx-ninos-tres-seis-M").val() != +$("#tx-ninos-M").val()){
    parent.swal("Error","La cantidad de niños por rango de edad es superior o inferior al total de niños (ASISTENCIA REAL)","error");
  }else if(+$("#tx-ninas-cero-tres-M").val() + +$("#tx-ninas-tres-seis-M").val() != +$("#tx-ninas-M").val()){
    parent.swal("Error","La cantidad de niñas por rango de edad es superior o inferior al total de niñas (ASISTENCIA REAL)","error");

  }else if(+$("#tx-ninos-nuevos-M").val() + +$("#tx-ninas-nuevos-M").val() + +$("#tx-mujeres-nuevos-M").val() != +$("#tx-total-nuevos-M").val()){
    parent.swal("Error","La cantidad de beneficiarios por grupo etario es superior o inferior al total (BENEFICIARIOS NUEVOS)","error");
  }else if(+$("#tx-ninos-cero-tres-nuevos-M").val() + +$("#tx-ninos-tres-seis-nuevos-M").val() != +$("#tx-ninos-nuevos-M").val()){
    parent.swal("Error","La cantidad de niños por rango de edad es superior o inferior al total de niños (BENEFICIARIOS NUEVOS)","error");
  }else if(+$("#tx-ninas-cero-tres-nuevos-M").val() + +$("#tx-ninas-tres-seis-nuevos-M").val() != +$("#tx-ninas-nuevos-M").val()){
    parent.swal("Error","La cantidad de niñas por rango de edad es superior o inferior al total de niñas (BENEFICIARIOS NUEVOS)","error");

  }else{
    total_enfoque = 0;
    $(".enfoque-M").each(function() {
      total_enfoque += +this.value;				
    });
    if(total_enfoque > +$("#tx-total-M").val()){
      parent.swal("Error","La cantidad de niños con enfoque es superior al total (ASISTENCIA REAL)","error");
    }else{
      ActualizarCifrasBeneficiarios();
    }
  }
});

function ActualizarCifrasBeneficiarios() {
  var datos = new FormData();
  formulario = {};   
    
  formulario['id_experiencia'] = $("#TX_ID_Experiencia_Editar").val();

  formulario['total_atendidos'] = $("#tx-total-M").val();
  formulario['gestantes_atendidos'] = $("#tx-mujeres-M").val();
  formulario['ninos_atendidos'] = $("#tx-ninos-M").val();
  formulario['ninos0a3_atendidos'] = $("#tx-ninos-cero-tres-M").val();
  formulario['ninos4a6_atendidos'] = $("#tx-ninos-tres-seis-M").val();
  formulario['ninas_atendidos'] = $("#tx-ninas-M").val();
  formulario['ninas0a3_atendidos'] = $("#tx-ninas-cero-tres-M").val();
  formulario['ninas4a6_atendidos'] = $("#tx-ninas-tres-seis-M").val();

  formulario['afro'] = $("#tx-afro-M").val();
  formulario['rural'] = $("#tx-rural-M").val();
  formulario['discapacidad'] = $("#tx-discapacidad-M").val();
  formulario['conflicto'] = $("#tx-conflicto-M").val();
  formulario['indigena'] = $("#tx-indigena-M").val();
  formulario['liberta'] = $("#tx-libertad-M").val();
  formulario['violencia'] = $("#tx-violencia-M").val();
  formulario['raizal'] = $("#tx-raizal-M").val();
  formulario['rom'] = $("#tx-rom-M").val();

  formulario['total_nuevos'] = $("#tx-total-nuevos-M").val();
  formulario['gestantes_nuevos'] = $("#tx-mujeres-nuevos-M").val();
  formulario['ninos_nuevos'] = $("#tx-ninos-nuevos-M").val();
  formulario['ninos0a3_nuevos'] = $("#tx-ninos-cero-tres-nuevos-M").val();
  formulario['ninos4a6_nuevos'] = $("#tx-ninos-tres-seis-nuevos-M").val();
  formulario['ninas_nuevos'] = $("#tx-ninas-nuevos-M").val();
  formulario['ninas0a3_nuevos'] = $("#tx-ninas-cero-tres-nuevos-M").val();
  formulario['ninas4a6_nuevos'] = $("#tx-ninas-tres-seis-nuevos-M").val();

  formulario['afro_nuevos'] = $("#tx-afro-nuevos-M").val();
  formulario['rural_nuevos'] = $("#tx-rural-nuevos-M").val();
  formulario['discapacidad_nuevos'] = $("#tx-discapacidad-nuevos-M").val();
  formulario['conflicto_nuevos'] = $("#tx-conflicto-nuevos-M").val();
  formulario['indigena_nuevos'] = $("#tx-indigena-nuevos-M").val();
  formulario['liberta_nuevos'] = $("#tx-libertad-nuevos-M").val();
  formulario['violencia_nuevos'] = $("#tx-violencia-nuevos-M").val();
  formulario['raizal_nuevos'] = $("#tx-raizal-nuevos-M").val();
  formulario['rom_nuevos'] = $("#tx-rom-nuevos-M").val(); 

  datos.append('funcion', 'ActualizarCifrasBeneficiarios'); 
  datos.append("p1", JSON.stringify(formulario));  

  $.ajax({
    contentType: false,
    processData: false,
    dataType: "html",
    type: "POST",
    url: url_ok_obj,
    data: datos,
    success: function(data){
      if(data == 1){
        parent.swal({
          confirmButtonColor: '#3f9a9d',
          title: 'Operación exitosa!',
          html: '<small>La información se ha guardado exitosamente</small>',
          type: 'success',
          confirmButtonText: 'Aceptar',
        }).then(() => {
          getReporteExperiencias();
          $("#miModalEditarEvento").modal('hide');
        }).catch(parent.swal.noop);
      }else{
        parent.swal("Error!", "No se ha podido guardar la información, por favor vuelva a intentarlo", "error");
      }
    },
    async: false
  });
}

$(document).delegate('.ninos03real', 'change', function() {
  var total = 0;
  $(".ninos03real").each(function() {
  	 var SumaNinos03Real = $(this).val();
    if (isNaN(parseFloat(SumaNinos03Real))) {
      total += 0;
    } else {
      total += parseFloat(SumaNinos03Real);
    }
  });
 $("#suma-ninos03-real").html(total);
 $("#tx-suma-ninos03-real").val(total);
  sumarbeneficiariosreal();
 });

 $(document).delegate('.ninos45real', 'change', function() {
  var total = 0;
  $(".ninos45real").each(function() {
  	 var SumaNinos45Real = $(this).val();
    if (isNaN(parseFloat(SumaNinos45Real))) {
      total += 0;
    } else {
      total += parseFloat(SumaNinos45Real);
    }
  });
 $("#suma-ninos45-real").html(total);
 $("#tx-suma-ninos45-real").val(total);
 sumarbeneficiariosreal();
 });

 $(document).delegate('.ninos6real', 'change', function() {
  var total = 0;
  $(".ninos6real").each(function() {
  	 var SumaNinos6Real = $(this).val();
    if (isNaN(parseFloat(SumaNinos6Real))) {
      total += 0;
    } else {
      total += parseFloat(SumaNinos6Real);
    }
  });
  $("#suma-ninos6-real").html(total);
  $("#tx-suma-ninos6-real").val(total);
    sumarbeneficiariosreal();
 });

 $(document).delegate('.gestantereal', 'change', function() {
  var GestantesReal = $("#tx-mujeres").val();
  $("#suma-gestantes-real").html(GestantesReal);
  $("#tx-suma-gestantes-real").val(GestantesReal);
  sumarbeneficiariosreal();
 });

 function sumarbeneficiariosreal(){
  var total = 0;
  $(".beneficiariosreal").each(function() {
  	 var beneficiariosreal = $(this).val();
    if (isNaN(parseFloat(beneficiariosreal))) {
      total += 0;
    } else {
      total += parseFloat(beneficiariosreal);
    }
  });
  $("#total-beneficiarios-real").html(total);
  $("#tx-total-beneficiarios-real").val(total);
}

$(document).delegate('.ninos03nuevos', 'change', function() {
  var total = 0;
  $(".ninos03nuevos").each(function() {
  	 var SumaNinos03Nuevos = $(this).val();
    if (isNaN(parseFloat(SumaNinos03Nuevos))) {
      total += 0;
    } else {
      total += parseFloat(SumaNinos03Nuevos);
    }
  });
 $("#suma-ninos03-nuevos").html(total);
 $("#tx-suma-ninos03-nuevos").val(total);
  sumarbeneficiariosnuevos();
 });

 $(document).delegate('.ninos45nuevos', 'change', function() {
  var total = 0;
  $(".ninos45nuevos").each(function() {
  	 var SumaNinos45Nuevos = $(this).val();
    if (isNaN(parseFloat(SumaNinos45Nuevos))) {
      total += 0;
    } else {
      total += parseFloat(SumaNinos45Nuevos);
    }
  });
 $("#suma-ninos45-nuevos").html(total);
 $("#tx-suma-ninos45-nuevos").val(total);
 sumarbeneficiariosnuevos();
 });

 $(document).delegate('.ninos6nuevos', 'change', function() {
  var total = 0;
  $(".ninos6nuevos").each(function() {
  	 var SumaNinos6Nuevos = $(this).val();
    if (isNaN(parseFloat(SumaNinos6Nuevos))) {
      total += 0;
    } else {
      total += parseFloat(SumaNinos6Nuevos);
    }
  });
  $("#suma-ninos6-nuevos").html(total);
  $("#tx-suma-ninos6-nuevos").val(total);
  sumarbeneficiariosnuevos();
 });

 $(document).delegate('.gestantenuevos', 'change', function() {
  var GestantesNuevos = $("#tx-mujeres-nuevos").val();
  $("#suma-gestantes-nuevos").html(GestantesNuevos);
  $("#tx-suma-gestantes-nuevos").val(GestantesNuevos);
  sumarbeneficiariosnuevos();
 });

 function sumarbeneficiariosnuevos(){
  var total = 0;
  $(".beneficiariosnuevos").each(function() {
  	 var beneficiariosnuevos = $(this).val();
    if (isNaN(parseFloat(beneficiariosnuevos))) {
      total += 0;
    } else {
      total += parseFloat(beneficiariosnuevos);
    }
  });
  $("#total-beneficiarios-nuevos").html(total);
  $("#tx-total-beneficiarios-nuevos").val(total);
}

$("#table-reporte-experiencias").on("click", ".EliminarExperiencia", function() {
  parent.swal({
    confirmButtonColor: '#3f9a9d',
    title: 'ELIMINAR REGISTRO DE EXPERIENCIA',
    html: '<small>¿Está seguro de eliminar la experiencia registrada con <b> ID:'+ $(this).data("id-experiencia") +' </b> del día <b> '+ $(this).data("fecha") +' </b> con nombre de experiencia <b> '+ $(this).data("nombre") +' </b> perteneceinte al grupo <b> '+ $(this).data("grupo") +'</b>?</small>',
    type: 'warning',
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
    showCancelButton: true, 
    width: 800,
  }).then(() => {
    var idExperiencia = $(this).data("id-experiencia");
    eliminarExperienciaArtistica(idExperiencia);
  },(confirm) => {
    if (confirm == "cancel"){
    }
  }).catch(parent.swal.noop);
});

function eliminarExperienciaArtistica(idExperiencia){
  datos = {
    'funcion': 'eliminarExperiencia',
    'p1': idExperiencia
  };
  $.ajax({
    url: url_ok_obj,
    type: 'POST',
    data: datos,
    async: false,
    success: function(data){
      if(data >= 0){
        parent.swal({
          confirmButtonColor: '#3f9a9d',
          title: 'Operación exitosa',
          html: '<small>Se eliminado correctamente la experiencia artística, desde este momento no aparecera en la consulta</small>',
          type: 'success',
          confirmButtonText: 'Aceptar', 
          width: 800,
        }).then(() => {
          consultarTotalExperienciasMes();
          consultarExperienciaLugarDupla();
          getReporteExperiencias();
        });
      }
      else
        parent.swal("Error","No se ha podido elimiar la experiencia artistica, por favor vuelva a intentarlo","danger");
    },
    fail: function(data){
    },
  });
}

$("#table-reporte-experiencias").on("click", ".enfoque", function() {
  var idExperiencia = $(this).data("id-experiencia");
  subirUsoImagen(idExperiencia);

});

});
