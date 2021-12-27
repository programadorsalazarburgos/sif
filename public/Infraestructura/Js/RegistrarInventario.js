var url_service_inventario = '../../Controlador/Infraestructura/Inventario/C_Inventario.php';
var url_inventario_obj = '../../src/Infraestructura/Controlador/InfraestructuraController.php';
var session = "";
var availableDescriptions = ["Sin descripcion"];
cantidad_archivos_elemento = [];
$(document).ready(function(){
	//ALIMENTA LAS LISTAS DESPLEGABLES
	$("#SL_LUGAR").change(function(){
		if ($("#SL_LUGAR").val() == ""){
			$("#div_registro_inventario").hide();	
		}else{
			$("#div_registro_inventario").hide();	
			$("#div_registro_inventario").show("slow");
		}
	});
	$("#SL_ELEMENTO").on('change',function(){
		if ($("#SL_ELEMENTO").val() == "2"){
			$("#div_donante").show();
			$("#TXT_DONANTE").prop("required", true);
			$("#div_fungibles").hide();
			$("#div_tipo_bien").show();
		}else{
			$("#div_donante").hide();
			$("#TXT_DONANTE").prop("required", false);
			$("#TXT_DONANTE").val("");
			$("#div_tipo_bien").show();
		}
		$('.required').prop('required', function(){
			return  $(this).is(':visible');
		});
	});
	$("#SL_TIPO_BIEN").on('change', function(){
		if ($(this).val() == "1" || $(this).val() == "3"){
			$("#TXT_CANTIDAD").val("1");
			// $("#TXT_CANTIDAD").prop("readonly",true);
		}
		else{
			$("#TXT_CANTIDAD").val("");
			// $("#TXT_CANTIDAD").prop("readonly",false);	
		}
	});

	$("#TXT_CANTIDAD").on('change', function(){
		if($("#SL_TIPO_BIEN").val() == "1" || $("#SL_TIPO_BIEN").val() == "3"){
			if ($(this).val()>1) {
				parent.swal("","Se hará un registro MÚLTIPLE de bienes de tipo "+$("#SL_TIPO_BIEN option:selected").text(),"warning");
			}
			var cantidad = $(this).val();
			$("#div_placas_multiples").html("");
			for (var i = 1; i < cantidad; i++) {
				var vacio = "'"+"'";
				$("#div_placas_multiples").append("<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='padding-top:1%'><div class='col-xs-6 col-sm-6 col-md-6 col-lg-6' style='text-align:right;'><label><p>Placa*:</p></label></div><div class='input-group col-xs-6 col-sm-6 col-md-6 col-lg-6'><input id='TXT_PLACA_"+(i+1)+"' name='TXT_PLACA_"+(i+1)+"' class='TXT_PLACA form-control required' type='text' onkeyup='this.value=this.value.replace(/[^\d]+/,"+vacio+")' maxlength='10' required><span class='input-group-btn'><input type='button' value='S/P' class='BT_SIN_PLACA btn btn-success form-control' data-id-input='"+(i+1)+"'></span><input type='file' multiple class='btn btn-primary filestyle' id='REGISTRO_FOTOGRAFICO_"+(i+1)+"' name='REGISTRO_FOTOGRAFICO_"+(i+1)+"[]'></div></div>");
				$(":file").filestyle({text: 'Fotografía(s)'});
				$(":file").filestyle('btnClass', 'btn-success');
			}
		}
		else{
			$("#div_placas_multiples").html("");
		}
	});

	$(document).delegate('input[type=file]','change', function(e){
		prepareUpload(e,$(this).attr("name"));
	});

	$.ajax({
		url: '../../Controlador/Consultas/getSession.php', 
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			session = data;
		},
		async : false
	});

	//$('#SL_LUGAR').html(parent.getOptionsLugarInventario()).selectpicker('refresh');
	$('#SL_PROYECTO').html(parent.getProyectos()).selectpicker('refresh');

	$("#SL_PROYECTO").on('change', function(){
		$('#SL_LUGAR').html(parent.getParametroDetalleProyectoEstado(27, $(this).val(), 1)).selectpicker('refresh');
	});

	$.ajax({
		async : false,
		url: url_service_inventario,
		type: 'POST',
		dataType: 'json',
		data: {opcion: 'listar_tipo_bien'},
		success: function(datos)
		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#SL_TIPO_BIEN').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
			$('#SL_TIPO_BIEN').selectpicker("refresh");
		}
	});

	$.ajax({
		async : false,
		url: url_service_inventario,
		type: 'POST',
		dataType: 'json',
		data: {opcion: 'listar_elementos'},
		success: function(datos)
		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#SL_ELEMENTO').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
			$('#SL_ELEMENTO').selectpicker("refresh");
		}
	});

	listarDonantes();

	$.ajax({
		async : false,
		url: url_service_inventario,
		type: 'POST',
		dataType: 'json',
		data: {opcion: 'listar_estado_bien'},
		success: function(datos)
		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#SL_ESTADO_BIEN').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
			$('#SL_ESTADO_BIEN').selectpicker("refresh");	
		}
	});

	listarSugerenciasDescripciones();

	$("#TXT_DESCRIPCION").on("keydown", function () {
		$( "#TXT_DESCRIPCION" ).autocomplete('option', 'source', availableDescriptions);
	});

	$("#TXT_DESCRIPCION ").autocomplete({
		source: availableDescriptions
	});

	function formatMoney(n, currency) {
		var string = String(n).replace(/\$ /g, "");
		console.log(string);
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
		return currency+" "+string;
	}
	function deformatMoney(text) {
		var deformated = text.replace(/\$/g, "").replace(/\ /g, "").replace(/\,/g, "").replace(/\./g, "");
		return deformated;
	}

	function listarDonantes(){
		$.ajax({
			async : false,
			url: url_service_inventario,
			type: 'POST',
			dataType: 'json',
			data: {opcion: 'listar_donantes'},
			success: function(datos)
			{
				$.each(datos, function(i) 
				{
					$('#donantes').append("<option value=\""+datos[i].VC_Donante+"\">");
				});
			}
		});
	}

	function listarSugerenciasDescripciones(){
		availableDescriptions = [''];
		$.ajax({
			async : false,
			url: url_service_inventario,
			type: 'POST',
			dataType: 'json',
			data: {opcion: 'listar_descripciones'},
			success: function(datos)
			{
				$.each(datos, function(i) 
				{
					availableDescriptions.push(datos[i].VC_Descripcion);
				});

			}
		});
	}
	// PREPARE UPLOAD DE ARCHIVOS
	// Grab the files and set them to our variable
	function prepareUpload(event, name)
	{
		files = event.target.files;
		var numero_item = name.slice(21,-2);
		cantidad_archivos_elemento[numero_item]=0;
		$("#div_archivos_elemento_"+numero_item).remove();
		/*document.getElementById('div_archivos_adjuntos').innerHTML = numero_item;*/
		newdiv = document.createElement('div');
		newdiv.setAttribute("id", "div_archivos_elemento_"+numero_item);
		newdiv.style.cssText = 'font-size:14px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
		newdiv.innerHTML = "<b>Fotografías elemento "+numero_item+"</b>:";
		files_size = 0;
		$.each(files, function(index, value) {
			files_size += files[index]["size"];
			newp = document.createElement('p');
			newp.style.cssText = 'font-size:14px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
			newp.innerHTML= files[index]["name"];
			newdiv.appendChild(newp);
			cantidad_archivos_elemento[numero_item] = cantidad_archivos_elemento[numero_item]+1;
		});
		document.getElementById('div_archivos_adjuntos').appendChild(newdiv);
		if(files_size > 20500000){
			$("#div_archivos_elemento_"+numero_item).remove();
			parent.mostrarAlerta("warning","Tamaño excedido", "El tamaño máximo por elemento es 20MB");
			$("#REGISTRO_FOTOGRAFICO_"+numero_item).filestyle('clear');
		}
	}

	$(document).delegate( "input", "focus", function() {
		if ($(this).hasClass( "change-event" )){
			if(this.value.length == 0){
				this.value = "0";	
			}
			// $(this).val(deformatMoney($(this).val()));
		}
	});
	$(document).delegate( "input", "blur", function() {
		if ($(this).hasClass( "change-event" )){
			if(this.value.length == 0){
				this.value = "0";
			}
			$(this).val(formatMoney($(this).val(),"$"));
		}
	});

	var flags_placas=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
	$("body").delegate(".BT_SIN_PLACA", 'click', function(){
		var id_input = $(this).attr('data-id-input');
		var nombre_input = "TXT_PLACA_"+$(this).attr('data-id-input');
		if(flags_placas[id_input]== 0)
		{
			$("#"+nombre_input).val("S/P");
			$("#"+nombre_input).prop('readonly', true);
			$(this).removeClass("btn-success");
			$(this).addClass("btn-danger	");
			flags_placas[id_input]=1;
			return;
		}
		if(flags_placas[id_input]== 1)
		{
			$("#"+nombre_input).prop('readonly', false);
			$("#"+nombre_input).val("");
			$(this).removeClass("btn-danger");
			$(this).addClass("btn-success");
			flags_placas[id_input]=0;
			return;
		}
	});
	// $(".BT_SIN_PLACA").click(function(){

		var flag_numero_traslado=0;
		$("#BT_SIN_NUMERO_TRASLADO").click(function(){
			if(flag_numero_traslado==0)
			{
				$('#TXT_NUMERO_TRASLADO').val("S/E");
				$('#TXT_NUMERO_TRASLADO').prop('readonly', true);
				$(this).removeClass("btn-success");
				$(this).addClass("btn-danger");
				flag_numero_traslado=1;
				return;
			}
			if(flag_numero_traslado==1)
			{
				$('#TXT_NUMERO_TRASLADO').prop('readonly', false);
				$('#TXT_NUMERO_TRASLADO').val("");
				$(this).removeClass("btn-danger");
				$(this).addClass("btn-success");
				flag_numero_traslado=0;
				return;
			}
		});

		$('#BT_LIMPIAR').on('click', function(){
			$('#TXT_PLACA').prop('readonly', false);
			$(".BT_SIN_PLACA").removeClass("btn-danger");
			$(".BT_SIN_PLACA").addClass("btn-success");
			flag=0;

			$('#TXT_NUMERO_TRASLADO').prop('readonly', false);
			$("#BT_SIN_NUMERO_TRASLADO").removeClass("btn-danger");
			$("#BT_SIN_NUMERO_TRASLADO").addClass("btn-success");
			flag_numero_traslado=0;

			$('#TXT_CANTIDAD').prop('readonly', false);
			$("#SL_LUGAR").val("").selectpicker("refresh");
			$("#div_donante").hide();
		});

		$('#fm_registrar_inventario').on('submit', function(e){
			e.preventDefault();

			$("#BT_REGISTRAR").attr("disabled", "disabled");
			$("#BT_REGISTRAR").addClass("disabled");
			var cantidad = $("#TXT_CANTIDAD").val();
			var placa = [];
			var item_placa = "TXT_PLACA_";
			for (var i = 0; i < cantidad; i++) {
				var item_placa = "TXT_PLACA_"+(i+1);
				placa[i] = $('#'+item_placa).val();
			}
			var sl_lugar = document.getElementById("SL_LUGAR");
			var sl_tipo_bien = document.getElementById("SL_TIPO_BIEN");
			//var sl_procedencia = document.getElementById("SL_PROCEDENCIA");
			var sl_elemento = document.getElementById("SL_ELEMENTO");
			var donante = $("#TXT_DONANTE").val();
			var descripcion = $("#TXT_DESCRIPCION").val();
			var sl_estado = document.getElementById("SL_ESTADO_BIEN");
			var numero_traslado = $('#TXT_NUMERO_TRASLADO').val();
			var valor = $("#TXT_VALOR_INICIAL").val();
			if (valor == "" ) {
				valor = " - - -";
			};
			if (donante == "" ) {
				donante = " - - -";
			};
			var ident="";
			var datos = {
				'funcion': 'validarPlaca',
				p1:{
					'placa' : placa,
					'id' : ident
				}
			}

		$.ajax({
			async : false,
			url: url_inventario_obj,
			type: 'POST',
			dataType: 'json',
			data: datos,
			success: function(datos)
			{
				var mensaje = "";
				if($("#SL_TIPO_BIEN").val() == "1" || $("#SL_TIPO_BIEN").val() == "3"){
					if ($("#TXT_CANTIDAD").val()>1) {
						mensaje = '<b>REGISTRO MÚLTIPLE ('+cantidad+' UNIDADES)</b><br><small>Registrar el Elemento al <span style=color:rgb(166,0,17)>'+sl_lugar.options[sl_lugar.selectedIndex].text+'?</span><br><br><span style=color:rgb(166,0,17)>Cantidad: </span>'+cantidad+'<br><span style=color:rgb(166,0,17)>Placa:</span> <b>PLACAS MÚLTIPLES</b><br><span style=color:rgb(166,0,17)>Elemento: </span>'+sl_elemento.options[sl_elemento.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Donante: </span>'+donante+'<br><span style=color:rgb(166,0,17)>Tipo Bien: </span>'+sl_tipo_bien.options[sl_tipo_bien.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Descripción: </span>'+descripcion+'<br><span style=color:rgb(166,0,17)>Estado: </span>'+sl_estado.options[sl_estado.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Número de Traslado: </span>'+numero_traslado+'<br><span style=color:rgb(166,0,17)>Valor Unitario Inicial: </span>'+valor+'</strong></i></small>';
					}
					else{
						mensaje = '<small>Registrar el Elemento al <span style=color:rgb(166,0,17)>'+sl_lugar.options[sl_lugar.selectedIndex].text+'?</span><br><br><span style=color:rgb(166,0,17)>Cantidad: </span>'+cantidad+'<br><span style=color:rgb(166,0,17)>Placa:</span> '+placa[0]+'<br><span style=color:rgb(166,0,17)>Elemento: </span>'+sl_elemento.options[sl_elemento.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Donante: </span>'+donante+'<br><span style=color:rgb(166,0,17)>Tipo Bien: </span>'+sl_tipo_bien.options[sl_tipo_bien.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Descripción: </span>'+descripcion+'<br><span style=color:rgb(166,0,17)>Estado: </span>'+sl_estado.options[sl_estado.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Número de Traslado: </span>'+numero_traslado+'<br><span style=color:rgb(166,0,17)>Valor Unitario Inicial: </span>'+valor+'</strong></i></small>';
					}
				}
				else{
					mensaje = '<small>Registrar el Elemento al <span style=color:rgb(166,0,17)>'+sl_lugar.options[sl_lugar.selectedIndex].text+'?</span><br><br><span style=color:rgb(166,0,17)>Cantidad: </span>'+cantidad+'<br><span style=color:rgb(166,0,17)>Placa:</span> '+placa[0]+'<br><span style=color:rgb(166,0,17)>Elemento: </span>'+sl_elemento.options[sl_elemento.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Donante: </span>'+donante+'<br><span style=color:rgb(166,0,17)>Tipo Bien: </span>'+sl_tipo_bien.options[sl_tipo_bien.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Descripción: </span>'+descripcion+'<br><span style=color:rgb(166,0,17)>Estado: </span>'+sl_estado.options[sl_estado.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Número de Traslado: </span>'+numero_traslado+'<br><span style=color:rgb(166,0,17)>Valor Unitario Inicial: </span>'+valor+'</strong></i></small>';					
				}
				var placas = "";
				if (Object.keys(datos).length > 0) {
					$.each(datos, function(key, value){
						placas += value+",";
					});
					parent.swal("La(s) placa(s) "+placas+" ya existe(n)", "Digite una(s) distinta(s).", "warning");
					$("#BT_REGISTRAR").removeAttr("disabled");
					$("#BT_REGISTRAR").removeClass("disabled");
				}
				if (Object.keys(datos).length == 0) {
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: 'Confirmar Acción!',
						html: mensaje,
						type: 'warning',
						allowOutsideClick: false,
						allowEscapeKey: false,
						confirmButtonText: 'SI',
						cancelButtonText: 'NO',
						showCancelButton: true,
					}).then(() => {
						var formulario = parent.getFormData($("#fm_registrar_inventario"));
						formulario["usuario_registro"] = session;

						// Create a formdata object and add the files
						var datos = new FormData();
						var nombre_elemento = "";
						if(sl_tipo_bien == 1 || sl_tipo_bien == 3){
							for (var n = 0; n < cantidad; n++) {
								nombre_elemento = "#REGISTRO_FOTOGRAFICO_"+(n+1);
								var files = $(nombre_elemento)[0].files;
								$.each(files, function(key, value)
								{
									datos.append("archivo_"+(n+1)+"_"+(key+1), value);
								});
							}
						}
						if (sl_tipo_bien == 2) {
							nombre_elemento = "#REGISTRO_FOTOGRAFICO_1";
							var files = $(nombre_elemento)[0].files;
							$.each(files, function(key, value)
							{
								datos.append("archivo_"+(n+1)+"_"+(key+1), value);
							});
						}

						datos.append("funcion", 'registrarInventario');
						datos.append("p1", JSON.stringify(formulario));
						datos.append("p3", JSON.stringify(cantidad_archivos_elemento));

						$.ajax({
							async : false,
							url: url_inventario_obj,
							type: 'POST',
							dataType: 'json',
							processData: false, // Don't process the files
        					contentType: false, // Set content type to false as jQuery will tell the server its a query string request
							data: datos,
							success: function(datos)
							{
								if (datos == 1) {
									parent.swal({
										confirmButtonColor: '#3f9a9d',
										title: 'Registrado Exitosamente!',
										//html: '<small>Desea registrar más elementos?</strong></i></small>',
										type: 'success',
										allowOutsideClick: false,
										allowEscapeKey: false,
										//cancelButtonText: 'NO',
										confirmButtonText: 'OK',
									}).then(() => {
										$("#fm_registrar_inventario").trigger("reset");
										$("#SL_LUGAR").selectpicker("refresh");
										$("#SL_PROYECTO").selectpicker("refresh");
										$("#SL_TIPO_BIEN").selectpicker("refresh");
										$("#SL_ELEMENTO").selectpicker("refresh");
										$("#SL_ESTADO_BIEN").selectpicker("refresh");
										$('#donantes').html('');
										listarDonantes();
										$('.TXT_PLACA').prop('readonly', false);
										$('.TXT_PLACA').val("");
										$(".BT_SIN_PLACA").removeClass("btn-danger");
										$(".BT_SIN_PLACA").addClass("btn-success");
										$("#BT_REGISTRAR").removeAttr("disabled");
										$("#BT_REGISTRAR").removeClass("disabled");
										$('#TXT_NUMERO_TRASLADO').prop('readonly', false);
										$('#TXT_NUMERO_TRASLADO').val("");
										$("#div_placas_multiples").html("");
										$("#div_archivos_adjuntos").html("<h4>Se subirán los siguientes archivos:</h4>");
										cantidad_archivos_elemento = [];
										flag=0;
									}).catch(parent.swal.noop);
								}
								else{
									parent.swal("Lo sentimos!", "No se pudo registrar el elemento.<br>Porfavor intente de nuevo", "error").then(() => {
										$("#BT_REGISTRAR").removeAttr("disabled");
										$("#BT_REGISTRAR").removeClass("disabled");
									});
								}
								listarSugerenciasDescripciones();
							}
						});
					},() => {
						$("#BT_REGISTRAR").removeAttr("disabled");
						$("#BT_REGISTRAR").removeClass("disabled");
					}).catch(parent.swal.noop);
				}// Fin IF
			}//Fin Success
		});//Fin Ajax Validar Placa
	}); //Fin submit Formulario
});