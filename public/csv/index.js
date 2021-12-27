var url_ok_obj = '../../src/Beneficiarios/Controlador/RegistroBeneficiariosController.php';
var arrayBeneficiarios;
var vr = 0;
$(document).ready(function(){

	$("body").on("click", ".delete", function() {
		let arrayDelete = $($(this).closest("tr").children()[1]).find(".n-doc").attr("id").split("_")[3] - 1;
		$(this).closest("table").children().children().css("background-color", "white");
		$(this).closest("tr").remove();
		arrayBeneficiarios.data.splice(arrayDelete,1);
		pintarInfo(arrayBeneficiarios);

		setTimeout(function(){
			$("#enviar").click();
		}, 500);

		validarDocumentos();
	});

	$("body").on("focus", ".date", function() {
		$(this).datepicker({
			format: 'dd/mm/yyyy',
			language: 'es',	
			autoclose: true,
			endDate: '+0d'
		});
	});

	$("#fileInput").on("change", function(){
		if($("#fileInput").val() != ""){
			$("#cargar").attr("disabled",false);
			$("#cargar").removeClass("btn-default").addClass("btn-primary");
		} 
	});

	var characterNameRegex = /^[a-zA-Z]+$/;
	$.validator.addMethod("validName", function( value, element ) {
		return this.optional( element ) || characterNameRegex.test( value );
	});

	var characterIdentificacionRegex = /^(?=.*[0-9])([a-zA-Z0-9]+)$/;
	$.validator.addMethod("validIdentificacion", function( value, element ) {
		return this.optional( element ) || characterIdentificacionRegex.test( value );
	});

	var characterDateRegex = /^(0[1-9]|1\d|2\d|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/;
	$.validator.addMethod("validDate", function(value, element) {
		return this.optional(element) || characterDateRegex.test(value);
	});

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
				mostrar += data
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
				mostrar += data
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
				mostrar += data
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
				mostrar += data
			},
			async: false
		});
		return mostrar;
	}

	function getValidarBeneficiario(id_beneficiario, id_element){
		$(".n-doc").each(function(index, el) {
			let id_element = "#"+$(this).attr("id");

			var datos = {
				funcion: 'getValidarBeneficiario',
				p1: $(this).val(),
				p2: 1
			};
			$.ajax({
				url: url_ok_obj,
				type: 'POST',
				data: datos,
				dataType: 'json',
				success: function(data) {
					if(data.length != 0){

						$(id_element).closest("tr").css("background-color", "#4BB543");
						$(id_element).attr("disabled", true);
						$(id_element).closest("tr").find(".name").attr("disabled", true);
						$(id_element.replace("TX_Num_Doc_", "TX_Pri_Nom_")).val(data[0]["VC_Primer_Nombre"]);
						$(id_element.replace("TX_Num_Doc_", "TX_Seg_Nom_")).val(data[0]["VC_Segundo_Nombre"]);
						$(id_element.replace("TX_Num_Doc_", "TX_Pri_Ape_")).val(data[0]["VC_Primer_Apellido"]);
						$(id_element.replace("TX_Num_Doc_", "TX_Seg_Ape_")).val(data[0]["VC_Segundo_Apellido"]);
						$(id_element.replace("TX_Num_Doc_", "TX_Fecha_Nac_")).val(moment(data[0]["DD_F_Nacimiento"]).format('DD/MM/YYYY'));

						$(id_element).closest("tr").find(".name").each((key,element)=>{
							$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
							$(element).closest('.form-group').find('.help-block').html('');
						})

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
			for (var i = 0; i < Object.keys(arrayBeneficiarios.data).length; i++) {
				if(index != i){
					if($.inArray($(this).val(), arrayBeneficiarios.data[i]) == 0){
						vr = 1;
						$(this).closest("tr").css("background-color", "#F7C6C6");
						$($(this).closest("tr").children()[0]).children().html("<a href='#' class='delete'><i class='fas fa-times-circle fa-1x'></i></a>");
					}
				}
			}
		});
		if(vr == 0){
			getValidarBeneficiario();
		}

	}

	$("#cargar").click(function(){

		leerArchivo();

		setTimeout(function(){
			validarDocumentos();
		}, 500);

		setTimeout(function(){
			$("#enviar").click();
		}, 500);
	});

	function leerArchivo(){
		Papa.parse(fileInput.files[0], {
			complete: function(results) {
				arrayBeneficiarios=results;
				pintarInfo(arrayBeneficiarios);
			}
		});
	}

	function pintarInfo(arrayBeneficiarios){
		$("#datos tbody").html("");
		var n=1;
		for (var i = 0; i < Object.keys(arrayBeneficiarios.data).length; i++) {
			$("#datos tbody").append("<tr>"+
				"<td style='width: 1%; vertical-align: middle;''>"+n+"<div></div></td>"+
				"<td><div class='form-group'>"+
				"<input type='text' class='form-control n-doc' name='TX_Num_Doc_"+n+"' id='TX_Num_Doc_"+n+"'>"+
				"<span class='help-block' id='error'></span></div></td>"+

				"<td><div class='form-group'>"+
				"<select class='selectpicker form-control' data-live-search='true' id='SL_Tipo_Documento_"+n+"' name='SL_Tipo_Documento_"+n+"' title='Tipo de documento'></select>"+
				"<span class='help-block' id='error'></span></div></td>"+

				"<td><div class='form-group'>"+
				"<input type='text' class='form-control date' readonly='readonly' name='TX_Fecha_Nac_"+n+"' id='TX_Fecha_Nac_"+n+"'>"+
				"<span class='help-block' id='error'></span></div>"+
				"</td>"+

				"<td><div class='form-group'>"+
				"<input type='text' class='form-control name' data-input='name' name='TX_Pri_Nom_"+n+"' id='TX_Pri_Nom_"+n+"'>"+
				"<span class='help-block' id='error'></span></div></td>"+

				"<td><div class='form-group'>"+
				"<input type='text' class='form-control name' data-input='name' name='TX_Seg_Nom_"+n+"' id='TX_Seg_Nom_"+n+"'>"+
				"<span class='help-block' id='error'></span></div></td>"+

				"<td><div class='form-group'>"+
				"<input type='text' class='form-control name' data-input='name' name='TX_Pri_Ape_"+n+"' id='TX_Pri_Ape_"+n+"'>"+
				"<span class='help-block' id='error'></span></div></td>"+

				"<td><div class='form-group'>"+
				"<input type='text' class='form-control name' data-input='name' name='TX_Seg_Ape_"+n+"' id='TX_Seg_Ape_"+n+"'>"+
				"<span class='help-block' id='error'></span></div></td>"+

				"<td><div class='form-group'>"+
				"<select class='selectpicker form-control' data-live-search='true' id='SL_Genero_"+n+"' name='SL_Genero_"+n+"' title='Género'></select>"+
				"<span class='help-block' id='error'></span></div></td>"+

				"<td><div class='form-group'>"+
				"<select class='selectpicker form-control' data-live-search='true' id='SL_Estrato_"+n+"' name='SL_Estrato_"+n+"' title='Estrato'></select>"+
				"<span class='help-block' id='error'></span></div></td>"+

				"<td><div class='form-group'>"+
				"<select class='selectpicker form-control' data-live-search='true' id='SL_Enfoque_"+n+"' name='SL_Enfoque_"+n+"' title='Enfoque diferencial'></select>"+
				"<span class='help-block' id='error'></span></div>"+
				"</td>"+


				"</tr>");

			$("#TX_Num_Doc_"+n).val(arrayBeneficiarios.data[i][0]);
			$("#SL_Tipo_Documento_"+n).html(getTipoDocumento()).selectpicker("refresh");
			$("#SL_Tipo_Documento_"+n+" option").each((key,element)=>{
				if ($(element).text() == arrayBeneficiarios.data[i][1]) {$(element).prop('selected', true);}
				if ($(element).val() == arrayBeneficiarios.data[i][1]) {$(element).prop('selected', true);}
			});
			$("#SL_Tipo_Documento_"+n).selectpicker("refresh");

			$("#TX_Pri_Nom_"+n).val(arrayBeneficiarios.data[i][2]);
			$("#TX_Seg_Nom_"+n).val(arrayBeneficiarios.data[i][3]);
			$("#TX_Pri_Ape_"+n).val(arrayBeneficiarios.data[i][4]);
			$("#TX_Seg_Ape_"+n).val(arrayBeneficiarios.data[i][5]);
			$("#TX_Fecha_Nac_"+n).val(arrayBeneficiarios.data[i][6]);

			$("#SL_Genero_"+n).html(getGenero()).selectpicker("refresh");
			$("#SL_Genero_"+n+" option").each((key,element)=>{
				if ($(element).text() == arrayBeneficiarios.data[i][7]) {$(element).prop('selected', true);}
				if ($(element).val() == arrayBeneficiarios.data[i][7]) {$(element).prop('selected', true);}
			});
			$("#SL_Genero_"+n).selectpicker("refresh");

			$("#SL_Enfoque_"+n).html(getEtnia()).selectpicker("refresh");
			$("#SL_Enfoque_"+n+" option").each((key,element)=>{
				if ($(element).text() == arrayBeneficiarios.data[i][8]) {$(element).prop('selected', true);}
				if ($(element).val() == arrayBeneficiarios.data[i][8]) {$(element).prop('selected', true);}
			});
			$("#SL_Enfoque_"+n).selectpicker("refresh");

			$("#SL_Estrato_"+n).html(getTPoblacional()).selectpicker("refresh");
			$("#SL_Estrato_"+n+" option").each((key,element)=>{
				if ($(element).text() == arrayBeneficiarios.data[i][9]) {$(element).prop('selected', true);}
				if ($(element).val() == arrayBeneficiarios.data[i][9]) {$(element).prop('selected', true);}
			});
			$("#SL_Estrato_"+n).selectpicker("refresh");

			n++;
		}

	}

	$("#enviar").click(function(){
		var rules = {};
		var messages = {};
		$(".form-control").each(function(index, el) {
			if ($(this).attr("id") != undefined) {

				if($(this).attr("id").indexOf("TX_Num_Doc_") == 0){
					rules[$(this).attr("name")] = {required: true, minlength: 3, validIdentificacion: true};
					messages[$(this).attr("name")] = {required: "Este campo no puede estar vacio", minlength:"Minimo tres carateres", validIdentificacion: "No se permiten caracteres especiales"};
				}

				if($(this).attr("id").indexOf("SL_Tipo_Documento_") == 0){
					rules[$(this).attr("name")] = {required: true};
					messages[$(this).attr("name")] = {required: "Este campo no puede estar vacio"};
				}

				if($(this).hasClass("name")){
					let campo = $(this).attr("id").split("_")[2] == "Nom" ? "nombre" : "apellido";

					if($(this).attr("id").indexOf("TX_Seg_Nom_") == 0 || $(this).attr("id").indexOf("TX_Seg_Ape_") == 0){

						rules[$(this).attr("name")] = {minlength: 3};
						messages[$(this).attr("name")] = {minlength:"El "+campo+" debe contener al menos tres caracteres"};

					}else{
						rules[$(this).attr("name")] = {required: true, minlength: 3, validName: true};
						messages[$(this).attr("name")] = {required: "Este campo no puede estar vacio", minlength:"El "+campo+" debe contener al menos tres caracteres", validName: "No número ni caracrteres"};
					}
				}
				
				if($(this).attr("id").indexOf("TX_Fecha_Nac_") == 0){
					rules[$(this).attr("name")] = {required: true, validDate: true,  date: false};
					messages[$(this).attr("name")] = {required: "Este campo no puede estar vacio", validDate: "Ingrese un fecha valida"};
				}

				if($(this).attr("id").indexOf("SL_Genero_") == 0){
					rules[$(this).attr("name")] = {required: true};
					messages[$(this).attr("name")] = {required: "Este campo no puede estar vacio"};
				}

				if($(this).attr("id").indexOf("SL_Enfoque_") == 0){
					rules[$(this).attr("name")] = {required: true};
					messages[$(this).attr("name")] = {required: "Este campo no puede estar vacio"}
				}

				if($(this).attr("id").indexOf("SL_Estrato_") == 0){
					rules[$(this).attr("name")] = {required: true};
					messages[$(this).attr("name")] = {required: "Este campo no puede estar vacio"}
				}
			}
		});
		validator = $("#form-beneficiarios").validate({
			rules: rules,
			messages: messages,
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
			//crearNuevaExperiencia();
		},
	});
	});

});