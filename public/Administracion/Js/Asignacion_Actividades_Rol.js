var url_service_administracion = '../../src/Administracion/Controlador/AdministracionController.php';
$(function(){

	var tableActividades = $("#table-actividades").DataTable({
		responsive: true,
		paginate: false,
		searching: false,
		ordering: false,
		info:false,
		columnDefs: [
		{
			"targets": [ 0,3 ],
			"visible": false,
			"searchable": false
		}],
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información, lo sentimos.",
			"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
			"search": "Filtrar"
		},
		"drawCallback": function ( settings ) {
			var api = this.api();
			var rows = api.rows( {page:'current'} ).nodes();
			var last=null;
			api.column(3, {page:'current'} ).data().each( function ( group, i ) {
				if ( last !== group ) {
					$(rows).eq( i ).before(
						'<tr class="group"><td colspan="2">'+group+'</td></tr>'
						);

					last = group;
				}
			} );
		}
	});

	$("#select-programa").html("");
	var programas = parent.getParametroDetalle(1);
	$.each(programas, function (i) {
		$('#select-programa').append($('<option>', {
			value : programas[i].PK_Id_Tabla,
			text : programas[i].VC_Descripcion
		}));
	});
	$('.selectpicker').selectpicker('refresh');
	$('#select-programa').on('change', function(e){
		e.preventDefault();
		tableActividades.clear().draw();
		$("#table-actividades").hide();
		//console.log($(this).val());
		$("#select-rol").html("");
		var roles = null;
		if ($(this).val() != null){

			if ($(this).val().includes("100")){ // 100 hace referencia a perfiles Crea en la tabla parametro detalle
				roles = parent.getParametroDetalle(2);
			}
			if ($(this).val().includes("101")){ // 101 hace referencia a perfiles Nidos en la tabla parametro detalle
					roles = parent.getParametroDetalle(3);
			}
			if ($(this).val().includes("1704")){ // 1704 hace referencia a perfiles Nidos en la tabla parametro detalle
				roles = parent.getParametroDetalle(98);
			}
			if ($(this).val().includes("100") && $(this).val().includes("101") && $(this).val().includes("1704")){ // Hace referencia a perfiles transversales en la tabla parametro detalle
				roles = parent.getParametroDetalle(4);
			}

			if (roles != null)
				$.each(roles, function (i) {
					$('#select-rol').append($('<option>', {
						value : roles[i].FK_Value,
						text : roles[i].VC_Descripcion
					}));
				});
		}

		$('.selectpicker').selectpicker('refresh');
	});
	$('#select-rol').on('change', function(e){
		e.preventDefault();
		tableActividades.clear().draw();
		$("#table-actividades").show();
		var rolId = $(this).val();
		permisos = parent.getPermisosRol(rolId);
		$.each(permisos, function (i,permiso) {
			checkbox = '';

			if (permiso.estado != '0') {
				checkbox = 'checked';
			}
			tableActividades.row.add( [
				permiso.PK_Id_Actividad,
				permiso.VC_Nom_Actividad,
				`<div class="material-switch pull-right">
				<input id="someSwitchOptionSuccess`+i+`" name="someSwitchOption`+i+`" data-activity="`+permiso.PK_Id_Actividad+`" class="checkState" type="checkbox" `+checkbox+`/>
				<label for="someSwitchOptionSuccess`+i+`" class="label-info"></label>
				</div>`,
				permiso.VC_Nom_Modulo,
				]).draw();
		});
		$('.checkState').on('change', function(e){
			e.preventDefault();
			activityId = $(this).data('activity');
			if ($(this).prop('checked')) saveActivityRol(activityId,rolId);
			else deleteActivityRol(activityId,rolId);
		});
	});

	function saveActivityRol(activityId,rolId) {
		$.ajax({
			async : false,
			url: url_service_administracion,
			dataType: 'json',
			type: 'POST',
			data: {
				'funcion' : 'saveActivityRol',
				p1:activityId,
				p2:rolId
			},
			success: function(datos)
			{

			}
		});
	}

	function deleteActivityRol(activityId,rolId){
		$.ajax({
			async : false,
			url: url_service_administracion,
			dataType: 'json',
			type: 'POST',
			data: {
				'funcion' : 'deleteActivityRol',
				p1:activityId,
				p2:rolId

			},
			success: function(datos)
			{


			}
		});
	}

});
