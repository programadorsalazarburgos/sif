var url_ok_obj = '../../../src/Territorial/Controlador/CambiarDuplaGruposController.php';
//var idTerritorio;
$(function() {


$("#SL_Duplas").html(consultarDuplasTerritorios()).selectpicker("refresh");
$("#SL_TDuplas").html(consultarDuplasTerritorios()).selectpicker("refresh");


$("#SL_Duplas").change(function() {
  getGruposDuplaCambiar();
  $("#div_Consulta_Grupos").show("refresh");
});


  function consultarDuplasTerritorios(){
  	var mostrar = "";
  	var datos = {
  		'funcion' : 'getOptionsDuplasTerritorios',
  		'p1': parent.idUsuario
  	};
  	$.ajax({
  		url: url_ok_obj,
  		data :datos,
  		type :'POST',
  		success: function(data){
  			mostrar += data;
  		},
  		async: false
  	});
  	return mostrar;
  }

// MODAL INFORMACIÓN DE GRUPOS
$("table").delegate("#BT_cambiar_dupla", "click", function() {
  $("#lugar").html($(this).data("lugar"));
  $("#nomgrupo").html($(this).data("nomgrupo"));
  $("#IdBeneficiarioInactivar").val($(this).data("idgrupo"));
});


$("#BT_cambiar_dupla").click(function() {
  mostrarModalRegistrar();
});

function mostrarModalRegistrar() {
    $(".modal-title").text("Confirmar cambio de grupos");
    $("#info_grupos").html("");
    $("#BT_confirmar_asistencia").show();
    $("#BT_cancelar_guardado").val("No");
    var filas_tabla = table_grupos_dupla.data().length;
    var cg = 0;
    var nombre_grupos = "";
   for (i = 0; i <= filas_tabla; i++) {
     if ($("#checkbox_" + i).is(':checked')) {
       cg++;
       nombre_grupos += $("#checkbox_" + i).data("lugar")+" - "+$("#checkbox_" + i).data("nomgrupo")+"<br>";
  }
}

  $("#info_grupos").append("¿Esta seguro que desea cambiar estos <strong>"+ cg +"</strong> grupos de dupla?:<br>(Lugar de atención - Grupo)<br>");
  $("#info_grupos").append(nombre_grupos);
  }

  ///////////////////////////////////////

  var table_grupos_dupla = $("#table_grupos_dupla").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
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
  function getGruposDuplaCambiar() {
    table_grupos_dupla.clear().draw();
    var datos = {
      funcion: 'getGruposDuplaCambiar',
      'p1': $("#SL_Duplas").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {},
      async: false
    }).done(function(data) {
      table_grupos_dupla.rows.add($(data)).draw();
      $('input[type="checkbox"]').bootstrapToggle();
    }).fail(function(data) {
      parent.swal("Error", "No se han podido cargar los datos de la tabla", "error");
    });
  }


  ///****************************  Registrar asistencia experiencia
    $("#form_cambiar_grupos_Dupla").submit(function(event) {
      event.stopPropagation();
      event.preventDefault();
      var mostrar = "";
      var checkbox_cambiar_grupos = new Array();
      $('.cambiar_grupo').each(function() {
        var check;
        if($(this).is(":checked")){
          //check=1;
          checkbox_cambiar_grupos.push($(this).data('idgrupo'));
        }
      });
      checkbox_cambiar_grupos = JSON.stringify(checkbox_cambiar_grupos);
      datos = {
        funcion: 'cambiarGruposDupla',
        p1: {
          'Dupla_Nueva': $("#SL_TDuplas").val(),
          'CH_grupos_cambiar': checkbox_cambiar_grupos,
        }
      };
      $.ajax({
        url: url_ok_obj,
        type: 'POST',
        data: datos,
        success: function(data) {
          // mostrar += data;
          if (data) {
            parent.swal("Operación Exitosa", "Se realizó correctamente el cambio de grupos a la nueva dupla", "success");

            $("#div_Consulta_Grupos").hide();
            $("#miModalCambiarGrupo").modal('hide');
            $("#SL_Duplas").val("");
            $("#SL_Duplas").html(consultarDuplasTerritorios()).selectpicker("refresh");
            $("#SL_TDuplas").val("");
            $("#SL_TDuplas").html(consultarDuplasTerritorios()).selectpicker("refresh");
          }
          else
          parent.swal("Operación NO Exitosa", "Ha ocurrido un error, intente nuevamente", "error");
        },
        async: false
      });
      return mostrar;
    });

});
