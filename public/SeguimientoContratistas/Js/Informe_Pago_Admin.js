var convenios = []; 
var codigos = [];
var identificaciones = [];

$(document).ready(function(){
	var url_controller = '../../src/SeguimientoContratistas/InformePagoController/';
	var url_administracion_controller = '../../src/Administracion/Controlador/AdministracionController.php';
	var validatorInforme;
	validatorInforme = $('#form-informe-pago').validate({
		rules: {
			"input-periodo-inicio": {
				required: true
			},
			"input-periodo-fin": {
				required: true
			}
		},
		errorPlacement: function (error, element) {
			var popOverSettings = {
				placement: 'right',
				container: 'body',
				html: true,
				trigger: 'focus',
				selector: '.error',
				content: function () {
					return "<span style='padding:20px; color:red;'>Este dato es requerido</span>";
				}
			}

			$('body').popover("destroy");
			$('body').popover(popOverSettings);
			$(element).parent('div').addClass('has-error');
		}
	});
	var userData = null;
	$.ajax({
		url: url_controller+"getSession",
		type: 'POST',
		dataType: 'json',
		success: function(result){
			userData = result;
			init();
		},error: function(result){
			console.log("Error: "+result);
		}
	});

	$("#modal-editar-informe #select-contratista").selectpicker("hide");
	$('#informe_pago_link').on('click', function(e){
		e.preventDefault();

		$('#input-finalizado-1').prop('checked',false);
		$('#input-finalizado-1').change();
		loadForm();
	});

	$(".creacion").css('background-color','');
	$(".declaracion").removeAttr("disabled");
	$(".observacion-declaracion").removeAttr("disabled");

	$('#listado_link').on('click', function(e){
		e.preventDefault();
		refreshListado();
		$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
	});

	$('#BT_CREAR_CONTRATO').on('click', function(e){
		e.preventDefault();
		$(".creacion").css('background-color','#fbe25b');
		$("#modal-editar-informe #input-nombres-apellidos").css("display","none");
		$("#modal-editar-informe #select-contratista").selectpicker("show");
		$("#modal-editar-informe #input-numero-contrato").removeAttr("disabled");
		//$("#modal-editar-informe #input-ciiu").attr("disabled","disabled");
		$("#modal-editar-informe #input-plazo-inicial").attr("disabled","disabled");
		$("#modal-editar-informe #input-prorrogas").attr("disabled","disabled");
		$("#modal-editar-informe #input-fecha-plazo-fin").attr("disabled","disabled");
		$("#modal-editar-informe #input-numero-pagos").val('0').attr("disabled","disabled");
		$("#modal-editar-informe #input-pago-de-total").val('0').attr("disabled","disabled");

		$(".declaracion").attr("disabled","disabled");
		$(".observacion-declaracion").attr("disabled","disabled");

		$('#modal-editar-informe').modal("show");
		$('#modal-editar-informe #h4-modal-informe-title').text('Registrar Nuevo Contrato');
		
		clearForm();

		$("#submit-editar-informe").hide();
		$("#submit-crear-contrato").show();
	});

	var tableListado = null;
	function init() {
		tableListado = $('#table-listado-informes').DataTable( {
			"paging":   true,
			"ordering": true,
			"info":     false,
			"columnDefs": [
			{
				"targets": [ 0, 4 ],
				"visible": false,
				"searchable": false
			},],
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			language: {
				"lengthMenu": "Ver _MENU_ registros por pagina",
				"zeroRecords": "No hay información, lo sentimos.",
				"info": "Mostrando pagina _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros disponibles",
				"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
				"search": "Filtrar",
				paginate: {
					"first": "Primero",
					"previous": "Anterior",
					"next": "Siguiente",
					"last": "Último"
				}
			},
			dom: 'Blfrtip',
			buttons: [
			{
				extend: 'excelHtml5',
				text: 'Descargar Listado',
				filename: 'ListadoInformes',
				exportOptions: {
					columns: [ 1,2 ],
					modifier: {
						page: 'all'
					}
				}
			},
			]
		});
		loadForm();
		refreshListado();
	}
	function refreshListado() {
		parent.mostrarCargando();
		let datosGetAjax = {
			p1: {
				"fechaFin":$('#fecha-periodo').val(),
				"nIdentificacion":"",
				"estado":""
			}
		};
		tableListado.clear().draw();
		$.ajax({
			url: url_controller+'getListadoInformesBasicos',
			type: 'POST',
			dataType: 'html',
			data: datosGetAjax,
			async: true,
			success: function(result){
				tableListado.rows.add($(result)).draw();
				$('[data-toggle="tooltip"]').tooltip();
				parent.cerrarCargando();
			},error: function(result){
				console.error("Error: "+result);
			}
		});
	}
	$('#btn-consultar').on('click', function(e){
		e.preventDefault();
		refreshListado();
	});


	function loadForm() {
		$('#select-identificacion').html("");
		$('#select-identificacion-cedente').html("");
		$('#select-convenio-a').html("");
		$('#select-convenio-b').html("");
		$('#select-convenio-c').html("");
		$('#select-convenio-d').html("");
		$('#select-codigo-a').html("");
		$('#select-codigo-b').html("");
		$('#select-codigo-c').html("");
		$('#select-codigo-d').html("");
		$('#select-banco').html("");
		$(".datepicker-class").datepicker({
			format: 'dd/mm/yyyy',
			weekStart: 1,
			language: 'es',
			autoclose: true,
		});
		identificaciones = [{id:1,nombre:"C.C"},{id:2,nombre:"C.E"},{id:3,nombre:"PASAPORTE"},{id:4,nombre:"NIT"}];
		$.each(identificaciones, function (i) {
			$('#select-identificacion').append($('<option>', {
				value : identificaciones[i].id,
				text : identificaciones[i].nombre
			}));
			$('#select-identificacion-cedente').append($('<option>', {
				value : identificaciones[i].id,
				text : identificaciones[i].nombre
			}));
		});

		convenios = parent.getParametroDetalle(20); //21 id tabla parametro para convenios
		$.each(convenios, function (i) {
			$('#select-convenio-a').append($('<option>', {
				value : convenios[i].FK_Value,
				text : convenios[i].VC_Descripcion
			}));
			$('#select-convenio-b').append($('<option>', {
				value : convenios[i].FK_Value,
				text : convenios[i].VC_Descripcion
			}));
			$('#select-convenio-c').append($('<option>', {
				value : convenios[i].FK_Value,
				text : convenios[i].VC_Descripcion
			}));
			$('#select-convenio-d').append($('<option>', {
				value : convenios[i].FK_Value,
				text : convenios[i].VC_Descripcion
			}));
		});
		bancos = parent.getParametroDetalle(30); //30 id tabla parametro para bancos
		bancosPDF = {};
		$.each(bancos, function (i) {
			$('#select-banco').append($('<option>', {
				value : bancos[i].FK_Value,
				text : bancos[i].VC_Descripcion
			}));
			bancosPDF[bancos[i].FK_Value]  = bancos[i].VC_Descripcion;
		});

		var usuarios_activos = parent.getUsuariosActivos();
		$('#select-contratista').html(usuarios_activos);
		$('#select-supervisor').html(usuarios_activos);
		$('#select-apoyo').html(usuarios_activos);
		$('#select-apoyo-dos').html(usuarios_activos);
		$('#select-apoyo-financiero').html(usuarios_activos);
		$('#select-apoyo-auxiliar').html(usuarios_activos);
		$(".selectpicker").selectpicker("refresh");

		codigos = parent.getParametroDetalle(21); //21 id tabla parametro para convenios
		$.each(codigos, function (i) {
			$('#select-codigo-a').append($('<option>', {
				value : codigos[i].FK_Value,
				text : codigos[i].VC_Descripcion
			}));
			$('#select-codigo-b').append($('<option>', {
				value : codigos[i].FK_Value,
				text : codigos[i].VC_Descripcion
			}));
			$('#select-codigo-c').append($('<option>', {
				value : codigos[i].FK_Value,
				text : codigos[i].VC_Descripcion
			}));
			$('#select-codigo-d').append($('<option>', {
				value : codigos[i].FK_Value,
				text : codigos[i].VC_Descripcion
			}));
		});

		numerRow = 0;
		$("#form-informe-pago-container .obligacion").remove();
	}

	function clearForm(){
		parent.mostrarCargando("Por favor espere, se está preparando el formulario.");
		//Registro genérico para usar la estructura de algun resultado y llenar todo con vacío.
		var datos = {
			'p1' : 2534
		};
		$.ajax({
			url: url_controller+"getInformePagoBasicoPk",
			type: 'POST',
			dataType: 'json',
			data: datos,
			async: true,
			success: function(result){
				$(".datepicker-class").datepicker({
					format: 'dd/mm/yyyy',
					weekStart: 1,
					language: 'es',
					autoclose: true,
				});
				$.each(result, function(key, value) {

					if (!key.includes("span")){
						if (key.includes("fecha") && key != 'input-fecha-inicio' && key != 'input-fecha-fin' && key != 'input-fecha-plazo-fin')
							$('#contenedor-editar-informe #'+key).datepicker("setDate", '');
						else{
							if (key.includes("valor") || key.includes("giros") || key.includes("saldo"))
								$('#contenedor-editar-informe #'+key).val(0);
							else
								$('#contenedor-editar-informe #'+key).val('');
							
						}
					}
					else{
						key = key.replace("span-","");
						$('#contenedor-editar-informe #'+key).text('');
					}
					$(".rp-contenido").keyup();
				});
				$('#modal-editar-informe').modal("show");
				$('#modal-editar-informe #h4-modal-informe-title').text('Registrar Nuevo Contrato'); 
				$("#contenedor-editar-informe input,#contenedor-editar-informe textarea,#contenedor-editar-informe select").addClass('edicion');
				$("#select-contratista").val('');
				$("#select-identificacion").val(1);
				$('.selectpicker').selectpicker("refresh");
				refreshGeneral("#contenedor-editar-informe");
				parent.cerrarCargando();
			},error: function(result){
				console.log("Error: "+result);
			}
		});
	}

	function refreshGeneral(form) {
		$(form+" .decimalPesos").each(function() {
			$(this).val(function (index, value ) {
				var string = value.replace(/\$ /g, "");
				string = string.replace(/[^0-9^,]/g, "");
				if (string.indexOf(",") == -1) 
					string = string.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
				else
				{
					if (string.length != string.indexOf(",")+1) {
						var splitstring = string.split(",");
						string = splitstring[0].replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".")+","+splitstring[1];
					}
					else
						string = string.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
				}
				return "$ "+string;
			});
		});		
		$(form+' #input-valor-pago-efectuar').change();
		$(form+' #input-valor-pago-efectuar').keyup();
	}
	$('#select-supervisor').on('change', function(e){
		e.preventDefault();
		console.log($("#select-supervisor option:selected").data("cargo"));
		$('#cargo-supervisor').text($("#select-supervisor option:selected").data("cargo"));
	});
	$('#select-apoyo').on('change', function(e){
		e.preventDefault();
		console.log($("#select-apoyo option:selected").data("cargo"));
		$('#cargo-apoyo').text($("#select-apoyo option:selected").data("cargo"));
	});
		$('#select-apoyo-dos').on('change', function(e){
		e.preventDefault();
		console.log($("#select-apoyo-dos option:selected").data("cargo"));
		$('#cargo-apoyo-dos').text($("#select-apoyo-dos option:selected").data("cargo"));
	});
	$('#select-contratista').on('change', function(e){
		var datos = {
			funcion: 'getInfoUsuarioContratoById',
			p1: $(this).val()
		};
		$.ajax({
			url: url_administracion_controller,
			type: 'POST',
			dataType: 'json',
			data: datos,
			async: true,
			success: function(result){
				$("#input-identificacion").val(result[0].VC_Identificacion);

				if(result[0].VC_Numero_Contrato){
					parent.swal({
						confirmButtonColor: '#cc121a',
						title: 'Este usuario tiene un contrato activo',
						html: '<small><b>Número del Contrato</b>: '+result[0].VC_Numero_Contrato+'</small><br><small><b>Fecha Inicio</b>: '+result[0].VC_Fecha_Inicio+'</small><br><small><b>Fecha Fin</b>: '+result[0].VC_Fecha_Fin+'</small><br><small><b>Si este contrato YA FINALIZÓ y si el contratista YA PRESENTÓ todos los informes de pago del mismo, puede inactivarlo y continuar diligenciando el formulario para registrar el nuevo, de lo contrario de click en CANCELAR.</b></small>',
						type: 'warning',
						confirmButtonText: 'Inactivar contrato',
						cancelButtonText: 'Cancelar',
						showCancelButton: true, 
						width: 800,
					}).then(() => {
						inactivarInforme(result[0].PK_Id_Tabla, $('#id-usuario').val());
					},(confirm) => {
						if (confirm == "cancel"){
							$('#modal-editar-informe').modal("hide");
						}
					}).catch(parent.swal.noop);
				}
			},error: function(result){
				console.error("Error: "+result);
			}
		});
	});


	$('body').delegate('.rp-contenido', 'keyup', function(event) {

		$(event.target).val(function (index, value ) {
			let item = $(this).attr("name").replace("input-rp-contenido-","");
			item +=")";
			var string = value.replace(item, "").replace(item, "").replace(item, "");
			item +=" ";
			string = string.replace(item, "").replace(item, "").replace(item, "");
			string = $.trim(string);

			return item+string;
		});
	});
	$('body').delegate('.decimal', 'keyup', function(event) {
		$(event.target).val(function (index, value ) {
			var string = value.replace(/\$ /g, "");
			string = string.replace(/[^0-9^,]/g, "");
			if (string.indexOf(",") == -1) 
				string = string.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
			else
			{
				if (string.length != string.indexOf(",")+1) {
					var splitstring = string.split(",");
					string = splitstring[0].replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".")+","+splitstring[1];
				}
				else
					string = string.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
			}
			return string;
		});		
	});
	$("body").delegate('.decimalPesos', 'blur', function(e) {

		e.preventDefault();
		var string = $(this).val().replace(/\$ /g, "");
		string = string.replace(/[^0-9^,]/g, "");
		if (string.indexOf(",") == -1) 
			string = string.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
		else
		{
			if (string.length != string.indexOf(",")+1) {
				var splitstring = string.split(",");
				string = splitstring[0].replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".")+","+splitstring[1];
			}
			else
				string = string.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
		}
		$(this).val("$ "+string);
		let formChanged = "#"+$(this).closest('form')[0].id;
		$(formChanged+' #input-valor-pago-efectuar').keyup();
	});
	$('body').delegate('.number', 'keyup', function(event) {
		$(event.target).val(function (index, value ) {
			string = string.replace(/[^0-9]/g, "");
			return string;
		});
	});
	$("body").delegate('.sum-total', 'change', function(e) {

		e.preventDefault();
		total = 0;
		let formChanged = "#"+$(this).closest('form')[0].id;
		$(formChanged+' .sum-total').each(function(key, value) {
			let valor = $(value).val().replace(/\$ /g,"").replace(/\./g,"").replace(/\,/g,".");
			valor = parseFloat(valor);
			total += valor;
		});
		total += "";
		total = total.replace(/\./g,",");
		if (total.indexOf(",") == -1) 
			total = total.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
		else
		{
			if (total.length != total.indexOf(",")+1) {
				var splitstring = total.split(",");
				total = splitstring[0].replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".")+","+splitstring[1];
			}
			else
				total = total.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
		}
		total = "$ "+total;
		$(formChanged+' #input-valor-total-contrato').val(total);
		refreshSaldo(formChanged);
	});
	$("body").delegate('.refresh-saldo', 'change', function(e) {
		e.preventDefault();
		refreshSaldo("#"+$(this).closest('form')[0].id);
	});

	function refreshSaldo(form) {
		total = 0;
		let valor = $(form+' #input-valor-total-contrato').val().replace(/\$ /g,"").replace(/\./g,"").replace(/\,/g,".");
		let valorTotalContrato = parseFloat(valor);
		valor = $(form+' #input-valor-pago-efectuar').val().replace(/\$ /g,"").replace(/\./g,"").replace(/\,/g,".");
		let valorPagoEfectuar = parseFloat(valor);
		valor = $(form+' #input-giros-efectuados').val().replace(/\$ /g,"").replace(/\./g,"").replace(/\,/g,".");
		let girosEfectuados = parseFloat(valor);
		total = valorTotalContrato - valorPagoEfectuar - girosEfectuados;
		total += "";
		total = total.replace(/\./g,",");
		if (total.indexOf(",") == -1) 
			total = total.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
		else
		{
			if (total.length != total.indexOf(",")+1) {
				var splitstring = total.split(",");
				total = splitstring[0].replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".")+","+splitstring[1];
			}
			else
				total = total.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
		}
		total = "$ "+total;
		$(form+' #input-saldo-pediente').val(total);
	}
	$('#input-numero-obligaciones').on('change', function(e){
		e.preventDefault();
		changeObligaciones(this);

	});
	var numerRow = 0;
	function changeObligaciones(selfData) {
		if ($("#"+$(selfData).closest("form")[0].id+" .obligacion")[0] == undefined) {
			for (var i = $(selfData).val() - 1; i >= 0; i--) {
				numerRow = i+1;
				$(selfData).parent().parent().after(`
					<tr data-cantidad="`+$(selfData).val()+`" class="obligacion obligacion-`+numerRow+`" height=42 style='mso-height-source:userset;height:31.5pt'>
					<td height=42 class=xl6325986 style='height:31.5pt'></td>
					<td colspan=35 class=xl12925986 width=1086 style='width:815pt;height:10px;color:black;'><textarea rows="2" style="margin-bottom: -5px;width: 100%; height: 100%;" type="text" name="input-oblicacion-`+numerRow+`" id="input-oblicacion-`+numerRow+`" placeholder="`+numerRow+`. ESCRIBA TEXTUALMENTE LA OBLIGACIÓN No. `+numerRow+` DE SU CONTRATO)"></textarea></td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					</tr>`);
			}
		}
		else{
			let cantidadAnterior = $($("#"+$(selfData).closest("form")[0].id+" .obligacion")[0]).data("cantidad");
			if (cantidadAnterior > $(selfData).val()) {
				for (var i = cantidadAnterior ; i > $(selfData).val(); i--) {
					numerRow = i+1;
					$("#"+$(selfData).closest("form")[0].id+" .obligacion-"+i).remove();
				}
			}
			if (cantidadAnterior < $(selfData).val()) {
				for (var i = $(selfData).val() - 1; i >= cantidadAnterior; i--) {
					numerRow = i+1;
					$("#"+$(selfData).closest("form")[0].id+" #input-oblicacion-"+cantidadAnterior).parent().parent().after(`
						<tr data-cantidad="`+$(selfData).val()+`" class="obligacion obligacion-`+numerRow+`" height=42 style='mso-height-source:userset;height:31.5pt'>
						<td height=42 class=xl6325986 style='height:31.5pt'></td>
						<td colspan=35 class=xl12925986 width=1086 style='width:815pt;height:10px;color:black;'><textarea rows="2" style="margin-bottom: -5px;width: 100%; height: 100%;" type="text" name="input-oblicacion-`+numerRow+`" id="input-oblicacion-`+numerRow+`" placeholder="`+numerRow+`. ESCRIBA TEXTUALMENTE LA OBLIGACIÓN No. `+numerRow+` DE SU CONTRATO)"></textarea></td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						<td class=xl6425986>&nbsp;</td>
						</tr>`);
				}
			}
			$("#"+$(selfData).closest("form")[0].id+" .obligacion").data("cantidad",$(selfData).val());
		}
	}

	function inactivarInforme(id_informe, id_usuario){
	parent.mostrarCargando("Por favor espere, se está inactivando el contrato.");
	var datos = {
			'p1' : id_informe,
			'p2' : id_usuario
		};
		$.ajax({
			url: url_controller+'inactivarInformePagoBasico',
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(result){
				if (result == 1) {
					parent.cerrarCargando();
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: 'El informe anterior fue inactivado, puede continuar registrando el nuevo.',
						type: 'success',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					});
				}
			},error: function(result){
				console.log("Error: "+result);
			}
		});
	}

	$('.declaracion').on('change', function(e){
		e.preventDefault();
		let formChanged = "#"+$(event.target).closest('form')[0].id;
		if ($(formChanged+" #"+$($(this)[0]).attr("id")).val() == "X") {
			if ($($(this)[0]).attr("id").split("-")[3] == "si")
				$(formChanged+" #"+$($(this)[0]).attr("id").slice(0, -2)+"no").val("");
			else
				$(formChanged+" #"+$($(this)[0]).attr("id").slice(0, -2)+"si").val("");

		}
	});
	$('body').delegate('.declaracion', 'keyup', function(event) {
		let formChanged = "#"+$(event.target).closest('form')[0].id;
		$(event.target).val(function (index, value ) {
			return value.replace(/[^X]/g, "X") != "X"? (value != ""?"X":value):"X";
		});
		if ($(formChanged+" #"+event.target.id).val() == "X") {
			if (event.target.id.split("-")[3] == "si")
				$(formChanged+" #"+event.target.id.slice(0, -2)+"no").val("");
			else
				$(formChanged+" #"+event.target.id.slice(0, -2)+"si").val("");
		}
	});
	$('[data-toggle="tooltip"]').tooltip();

	$('body').delegate('.pago-efectuar', 'keyup', function(e) {

		e.preventDefault();
		let formChanged = "#"+$(this).closest('form')[0].id;
		value = $(this).val().replace(/\$ /g,"").replace(/\./g,"").replace(/\,/g,".");
		$(formChanged+' #input-valor-letras').val(numeroALetras(value, {
			plural: 'PESOS',
			singular: 'PESO',
			centPlural: 'centavos',
			centSingular: 'centavo'
		})+" / MCTE");
	});

	$('.clear-select').on('click', function(e){
		$("#"+$(this).data("select")).val("").selectpicker("refresh");
	});

	$("#input-numero-contrato").on('keyup', function(){
		$(this).val($(this).val().replace(/ /g, ""));
		$(this).val($(this).val().replace(/\//g, "-"));
	});
	$("#input-numero-contrato").on('blur', function(){
		var datos = {
			'p1' : $(this).val()
		};
		$.ajax({
			url: url_controller+"validarExistenciaContrato",
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(result){
				if (result == 1) {
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: 'Ya existe un contrato con este código.',
						html: 'No es posible crear un contrato con este código, por favor ingrese un código distinto.',
						type: 'warning',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					}).then(() => {
						$('#input-numero-contrato').val("");
					})
				}
			},error: function(result){
				console.log("Error: "+result);
			}
		});
	});

	$('#submit-informe-pago').on('click', function(e){
		e.preventDefault();
		var valid = $('#form-informe-pago').valid();
		if (valid) {
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Guardar Informe',
				html: '<small>¿Está seguro que desea guardar este informe?</small>',
				type: 'warning',
				confirmButtonText: 'Sí',
				cancelButtonText: 'No',
				showCancelButton: true,
			}).then(() => {
				var formularioJson = getFormData($("#form-informe-pago"));
				var datos = {
					'p1' : formularioJson,
					'p2' : $('#input-finalizado-1').is(":checked")
				};
				$.ajax({
					url: url_controller+"saveInformePago",
					type: 'POST',
					dataType: 'html',
					data: datos,
					success: function(result){
						if (result == 1) {
							parent.swal({
								confirmButtonColor: '#3f9a9d',
								title: 'El informe fue almacenado correctamente.',
								type: 'success',
								confirmButtonText: 'Aceptar',
								showCancelButton: false,
							}).then(() => {
								$('#listado_link').click();
								$('#modal-editar-informe').modal("hide");
							});

						}
						else if (result == 5) {
							parent.swal({
								confirmButtonColor: '#3f9a9d',
								html: "<small>Ya existe un informe diligenciado para el período seleccionado (Mes - Fecha final).</small>",
								type: 'error',
								confirmButtonText: 'Aceptar',
								showCancelButton: false,
							});
						}
						else {
							parent.swal({
								confirmButtonColor: '#3f9a9d',
								html: "<small>Ha ocurrido un error, intente nuevamente.</small>",
								type: 'error',
								confirmButtonText: 'Aceptar',
								showCancelButton: false,
							});
						}
					},error: function(result){
						console.log("Error: "+result);
					}
				});
			}).catch(parent.swal.noop);
		}
		else
			validatorInforme.focusInvalid();
	});

	var selectedData = {};
	var informeSelected = 0;
	var fk_persona = 0;
	$('#table-listado-informes').delegate('.editar_informe', 'click', function(event) {
		parent.mostrarCargando();
		
		$("#modal-editar-informe #select-contratista").selectpicker("hide");
		$("#input-nombres-apellidos").css("display","block");
		$("#modal-editar-informe #input-numero-contrato").attr("disabled","disabled");
		//$("#modal-editar-informe #input-ciiu").removeAttr("disabled");
		$("#modal-editar-informe #input-plazo-inicial").removeAttr("disabled");
		$("#modal-editar-informe #input-prorrogas").removeAttr("disabled");
		$("#modal-editar-informe #input-fecha-plazo-fin").removeAttr("disabled");
		$("#modal-editar-informe #input-numero-pagos").val('').removeAttr("disabled");
		$("#modal-editar-informe #input-pago-de-total").val('').removeAttr("disabled");
		$("#modal-editar-informe #input-rp-contenido-a").removeAttr("disabled");

		$("#modal-editar-informe #input-rp-contenido-a").removeAttr("disabled");
		$("#modal-editar-informe #input-rp-contenido-b").removeAttr("disabled");
		$("#modal-editar-informe #input-rp-contenido-c").removeAttr("disabled");
		$("#modal-editar-informe #input-rp-contenido-d").removeAttr("disabled");

		$("#modal-editar-informe #select-codigo-a").removeAttr("disabled");
		$("#modal-editar-informe #select-codigo-b").removeAttr("disabled");
		$("#modal-editar-informe #select-codigo-c").removeAttr("disabled");
		$("#modal-editar-informe #select-codigo-d").removeAttr("disabled");

		$("#modal-editar-informe #select-convenio-a").removeAttr("disabled");
		$("#modal-editar-informe #select-convenio-b").removeAttr("disabled");
		$("#modal-editar-informe #select-convenio-c").removeAttr("disabled");
		$("#modal-editar-informe #select-convenio-d").removeAttr("disabled");

		$("#modal-editar-informe #input-rp-valor-a").removeAttr("disabled");
		$("#modal-editar-informe #input-rp-valor-b").removeAttr("disabled");
		$("#modal-editar-informe #input-rp-valor-c").removeAttr("disabled");
		$("#modal-editar-informe #input-rp-valor-d").removeAttr("disabled");

		$(".creacion").css('background-color','');
		$(".declaracion").removeAttr("disabled");
		$(".observacion-declaracion").removeAttr("disabled");

		$("#submit-crear-contrato").hide();
		$("#submit-editar-informe").show();

		nContrato = "";
		$('#select-supervisor').val(""); //21 id tabla parametro para convenios
		$('#select-apoyo').val(""); //21 id tabla parametro para convenios
		$('#select-apoyo-dos').val("");
		$('#select-apoyo-financiero').val("");
		$('#select-apoyo-auxiliar').val("");
		$('.selectpicker').selectpicker("refresh");
		
		//$('#contenedor-editar-informe').html($('#form-informe-pago-container').clone());
		$("#contenedor-editar-informe .obligacion").remove();
		$('[data-toggle="tooltip"]').tooltip();
		informeSelected = $(this).data('informe_id');
		fk_persona = $(this).data('fk_persona');
		numerRow = 0;
		var datos = {
			'p1' : informeSelected
		};
		$.ajax({
			url: url_controller+"getInformePagoBasicoPk",
			type: 'POST',
			dataType: 'json',
			data: datos,
			async: true,
			success: function(result){
				informeSelectedData = result;
				$(".datepicker-class").datepicker({
					format: 'dd/mm/yyyy',
					weekStart: 1,
					language: 'es',
					autoclose: true,
				});
				nContrato = result["input-numero-contrato"];
				if (result["input-finalizado"] == 1) {
					$('#input-finalizado-2').prop('checked',true);
					$('#input-finalizado-2').change();
				}
				else{
					$('#input-finalizado-2').prop('checked',false);
					$('#input-finalizado-2').change();
				}
				$.each(result, function(key, value) {

					if (!key.includes("span")){
						if (key.includes("fecha") && key != 'input-fecha-inicio' && key != 'input-fecha-fin' && key != 'input-fecha-plazo-fin')
							$('#contenedor-editar-informe #'+key).datepicker("setDate", value);
						else{
							if (key.includes("valor") || key.includes("giros") || key.includes("saldo"))
								$('#contenedor-editar-informe #'+key).val(value != "" && value != null ? value : 0);
							else
								$('#contenedor-editar-informe #'+key).val(value);
							
						}
					}
					else{
						key = key.replace("span-","");
						$('#contenedor-editar-informe #'+key).text(value);
					}
					$(".rp-contenido").keyup();
				});
				$('#modal-editar-informe').modal("show");
				$('#modal-editar-informe #h4-modal-informe-title').text('Datos generales informe de pago '+nContrato); 
				$("#contenedor-editar-informe input,#contenedor-editar-informe textarea,#contenedor-editar-informe select").addClass('edicion');
				$('.selectpicker').selectpicker("refresh");
				refreshGeneral("#contenedor-editar-informe");
				parent.cerrarCargando();
			},error: function(result){
				console.log("Error: "+result);
			}
		});
		/*$('#contenedor-editar-informe #input-numero-obligaciones').on('change', function(e){
			e.preventDefault();
			changeObligaciones(this);
		});*/
	});
	//
	$('#submit-editar-informe').on('click', function(e){
		e.preventDefault();
		var correcciones = "";
		if ($("#input-identificacion").val() == '') {
			correcciones += "<br>- Diligencie el Número de Identificación del Contratista.";
		}
		if ($("#input-ciiu").val() == '') {
			correcciones += "<br>- Diligencie la actividad económica (CIIU).";
		}
		if ($("#input-objeto").val() == '') {
			correcciones += "<br>- Diligencie el Objeto del Contrato.";
		}
		if ($("#input-fecha-inicio").val() == '') {
			correcciones += "<br>- Diligencie la Fecha de Inicio del Contrato.";
		}
		if ($("#input-fecha-fin").val() == '') {
			correcciones += "<br>- Diligencie la Fecha de Terminación del Contrato.";
		}
		if ($("#input-valor-inicial").val() == '' || $("#input-valor-inicial").val() == '$ 0' || $("#input-valor-inicial").val() == '$ ') {
			correcciones += "<br>- Diligencie el Valor inicial del Contrato.";
		}
		if ($("#select-supervisor").val() == '') {
			correcciones += "<br>- Seleccione el Supervisor del Contrato.";
		}

		if (correcciones == "") {
			var formularioJson = getFormData($('#form-editar-informe'));
			var datos = {
				'p1' : formularioJson,
				'p2' : informeSelected,
				'p3' : fk_persona,
			};
			$.ajax({
				url: url_controller+'updateInformePagoBasicoAdmin',
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(result){
					if (result == 1) {
						parent.swal({
							confirmButtonColor: '#3f9a9d',
							title: 'Los cambios realizados al informe fueron almacenados correctamente.',
							type: 'success',
							confirmButtonText: 'Aceptar',
							showCancelButton: false,
						}).then(() => {
							refreshListado();
							$('#modal-editar-informe').modal("hide");
						});
					}
				},error: function(result){
					console.log("Error: "+result);
				}
			});
		}
		else{
			parent.mostrarAlerta("warning", "Realice las siguientes correcciones:",correcciones);
		}
	});

	$('#submit-crear-contrato').on('click', function(e){
		e.preventDefault();
		var correcciones = "";
		if ($("#select-contratista").val() == '') {
			correcciones += "<br>- Seleccione un Contratista.";
		}
		if ($("#input-numero-contrato").val() == '' || $("#input-numero-contrato").val().length <= 5) {
			correcciones += "<br>- Diligencie el Número de Contrato. Ej: 1150-2020.";
		}
		if ($("#input-identificacion").val() == '') {
			correcciones += "<br>- Diligencie el Número de Identificación del Contratista.";
		}
		if ($("#input-ciiu").val() == '') {
			correcciones += "<br>- Diligencie la actividad económica (CIIU).";
		}
		if ($("#input-objeto").val() == '') {
			correcciones += "<br>- Diligencie el Objeto del Contrato.";
		}
		if ($("#input-fecha-inicio").val() == '') {
			correcciones += "<br>- Diligencie la Fecha de Inicio del Contrato.";
		}
		if ($("#input-fecha-fin").val() == '') {
			correcciones += "<br>- Diligencie la Fecha de Terminación del Contrato.";
		}
		if ($("#input-rp-contenido-a").val() == '' || $("#input-rp-contenido-a").val().length <= 3) {
			correcciones += "<br>- Diligencie el Número del RP.";
		}
		if ($("#select-codigo-a").val() == null || $("#select-codigo-a").val() == "0") {
			correcciones += "<br>- Seleccione el Código fuente del RP.";
		}
		if ($("#select-convenio-a").val() == null) {
			correcciones += "<br>- Seleccione el Convenio del RP.";
		}
		if ($("#input-valor-inicial").val() == '' || $("#input-valor-inicial").val() == '$ 0' || $("#input-valor-inicial").val() == '$ ') {
			correcciones += "<br>- Diligencie el Valor inicial del Contrato.";
		}
		if ($("#select-supervisor").val() == '') {
			correcciones += "<br>- Seleccione el Supervisor del Contrato.";
		}
		if (correcciones == ""){
			parent.swal({
						confirmButtonColor: '#cc121a',
						title: '¿Confirma que desea registrar el contrato?',
						html: '<small><b>Contratista</b>: '+$("#select-contratista option:selected").text()+'</small><br><small><b>Número del Contrato</b>: '+$("#input-numero-contrato").val()+'</small>',
						type: 'warning',
						confirmButtonText: 'SI',
						cancelButtonText: 'Cancelar',
						showCancelButton: true, 
						width: 800,
					}).then(() => {
						var formularioJson = getFormData($('#form-editar-informe'));
						var datos = {
							'p1' : formularioJson,
							'p2' : $("#id-usuario").val()
						};
						$.ajax({
							url: url_controller+'saveInformePagoBasicoAdmin',
							type: 'POST',
							dataType: 'html',
							data: datos,
							success: function(result){
								if (result == 1) {
									parent.swal({
										confirmButtonColor: '#3f9a9d',
										title: 'El contrato fue registrado correctamente.',
										type: 'success',
										confirmButtonText: 'Aceptar',
										showCancelButton: false,
									}).then(() => {
										refreshListado();
										$('#modal-editar-informe').modal("hide");
										var contenido = "Se ha registrado el contrato <b>"+$("#input-numero-contrato").val()+"</b> a su nombre.<br><br>Ahora puede crear su primer informe de pago para el nuevo contrato.";
										var notificacion = {
        									VC_Url:"SeguimientoContratistas/Informe_Pago.php",
        									VC_Icon:"fa fa-list-alt",
        									VC_Contenido:contenido,
        									userId:$("#select-contratista option:selected").val()
        							}
        							window.parent.sendNotificationUser(notificacion);
									});
								}
							},error: function(result){
								console.log("Error: "+result);
							}
						});
					},(confirm) => {
						/*if (confirm == "cancel"){
							$('#modal-editar-informe').modal("hide");
						}*/
					}).catch(parent.swal.noop);
		}
		else{
			parent.mostrarAlerta("warning", "Realice las siguientes correcciones:",correcciones);
		}
	});
});

function getFormData(form){
	var unindexed_array = form.serializeArray();
	var indexed_array = {};

	$.map(unindexed_array, function(n, i){
		indexed_array[n['name']] = n['value'];
	});
	indexed_array["userId"] = $('#id-usuario').val();
	return indexed_array;
}
function convertInput(context) {
	$("span.view", context).remove();
	$('input,textarea,select', context).each(function() {
		$("<span />", { text: this.value, "class":"view" }).insertAfter(this);
		$(this).hide();
	});
}

numeroALetras = (function() {
	function Unidades(num){

		switch(num)
		{
			case 1: return 'UN';
			case 2: return 'DOS';
			case 3: return 'TRES';
			case 4: return 'CUATRO';
			case 5: return 'CINCO';
			case 6: return 'SEIS';
			case 7: return 'SIETE';
			case 8: return 'OCHO';
			case 9: return 'NUEVE';
		}

		return '';
    }//Unidades()

    function Decenas(num){

    	let decena = Math.floor(num/10);
    	let unidad = num - (decena * 10);

    	switch(decena)
    	{
    		case 1:
    		switch(unidad)
    		{
    			case 0: return 'DIEZ';
    			case 1: return 'ONCE';
    			case 2: return 'DOCE';
    			case 3: return 'TRECE';
    			case 4: return 'CATORCE';
    			case 5: return 'QUINCE';
    			default: return 'DIECI' + Unidades(unidad);
    		}
    		case 2:
    		switch(unidad)
    		{
    			case 0: return 'VEINTE';
    			default: return 'VEINTI' + Unidades(unidad);
    		}
    		case 3: return DecenasY('TREINTA', unidad);
    		case 4: return DecenasY('CUARENTA', unidad);
    		case 5: return DecenasY('CINCUENTA', unidad);
    		case 6: return DecenasY('SESENTA', unidad);
    		case 7: return DecenasY('SETENTA', unidad);
    		case 8: return DecenasY('OCHENTA', unidad);
    		case 9: return DecenasY('NOVENTA', unidad);
    		case 0: return Unidades(unidad);
    	}
    }//Unidades()

    function DecenasY(strSin, numUnidades) {
    	if (numUnidades > 0)
    		return strSin + ' Y ' + Unidades(numUnidades)

    	return strSin;
    }//DecenasY()

    function Centenas(num) {
    	let centenas = Math.floor(num / 100);
    	let decenas = num - (centenas * 100);

    	switch(centenas)
    	{
    		case 1:
    		if (decenas > 0)
    			return 'CIENTO ' + Decenas(decenas);
    		return 'CIEN';
    		case 2: return 'DOSCIENTOS ' + Decenas(decenas);
    		case 3: return 'TRESCIENTOS ' + Decenas(decenas);
    		case 4: return 'CUATROCIENTOS ' + Decenas(decenas);
    		case 5: return 'QUINIENTOS ' + Decenas(decenas);
    		case 6: return 'SEISCIENTOS ' + Decenas(decenas);
    		case 7: return 'SETECIENTOS ' + Decenas(decenas);
    		case 8: return 'OCHOCIENTOS ' + Decenas(decenas);
    		case 9: return 'NOVECIENTOS ' + Decenas(decenas);
    	}

    	return Decenas(decenas);
    }//Centenas()

    function Seccion(num, divisor, strSingular, strPlural) {
    	let cientos = Math.floor(num / divisor)
    	let resto = num - (cientos * divisor)

    	let letras = '';

    	if (cientos > 0)
    		if (cientos > 1)
    			letras = Centenas(cientos) + ' ' + strPlural;
    		else
    			letras = strSingular;

    		if (resto > 0)
    			letras += '';

    		return letras;
    }//Seccion()

    function Miles(num) {
    	let divisor = 1000;
    	let cientos = Math.floor(num / divisor)
    	let resto = num - (cientos * divisor)

    	let strMiles = Seccion(num, divisor, 'UN MIL', 'MIL');
    	let strCentenas = Centenas(resto);

    	if(strMiles == '')
    		return strCentenas;

    	return strMiles + ' ' + strCentenas;
    }//Miles()

    function Millones(num) {
    	let divisor = 1000000;
    	let cientos = Math.floor(num / divisor)
    	let resto = num - (cientos * divisor)
    	let strMillones = '';
    	if (resto == 0) 
    		strMillones = Seccion(num, divisor, 'UN MILLON DE', 'MILLONES DE');
    	else	
    		strMillones = Seccion(num, divisor, 'UN MILLON', 'MILLONES');
    	let strMiles = Miles(resto);

    	if(strMillones == '')
    		return strMiles;

    	return strMillones + ' ' + strMiles;
    }//Millones()

    return function NumeroALetras(num, currency) {
    	currency = currency || {};
    	let data = {
    		numero: num,
    		enteros: Math.floor(num),
    		centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
    		letrasCentavos: '',
            letrasMonedaPlural: currency.plural || 'PESOS CHILENOS',//'PESOS', 'Dólares', 'Bolívares', 'etcs'
            letrasMonedaSingular: currency.singular || 'PESO CHILENO', //'PESO', 'Dólar', 'Bolivar', 'etc'
            letrasMonedaCentavoPlural: currency.centPlural || 'CHIQUI PESOS CHILENOS',
            letrasMonedaCentavoSingular: currency.centSingular || 'CHIQUI PESO CHILENO'
        };
        if (data.centavos > 0) {
        	data.letrasCentavos = 'CON ' + (function () {
        		if (data.centavos == 1)
        			return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoSingular;
        		else
        			return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoPlural;
        	})();
        };

        if(data.enteros == 0)
        	return 'CERO ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
        if (data.enteros == 1)
        	return Millones(data.enteros) + ' ' + data.letrasMonedaSingular + ' ' + data.letrasCentavos;
        else
        	return Millones(data.enteros) + ' ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
    };
})();