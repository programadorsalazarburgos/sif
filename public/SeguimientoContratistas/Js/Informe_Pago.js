var convenios = []; 
var codigos = [];
var identificaciones = [];
var datosVersionFormato = {
	codigo: 'Código: GF-F-01',
	fecha: 'Fecha: 09/03/2021',
	version: 'Versión: 4'
};
var meses = ['','ENERO', 'FEBRERO', 'MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
var informeBasicoSelectedData;
var id_contrato_activo;
var flag = 0; //variable para ejecucion del modal
var parametros = [];//Array para almacenar opciones seleccionadas en los anexos orfeos
var codigo_confirmacion = "";
var id_informe_activo ="";
var validatorInforme = null;
var url_controller = '../../src/SeguimientoContratistas/InformePagoController/';

const TAMANO_MAXIMO_ARCHIVOS =57671680; 

(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "../jquery.validate"], factory );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

	/*
	* Translated default messages for the jQuery validation plugin.
	* Locale: ES (Spanish; EspaÃ±ol)
	*/
	$.extend($.validator.messages, {
		required: "Este campo es obligatorio.",
		remote: "Por favor, rellena este campo.",
		email: "Por favor, escribe una dirección de correo válida.",
		url: "Por favor, escribe una URL válida.",
		date: "Por favor, escribe una fecha válida.",
		dateISO: "Por favor, escribe una fecha (ISO) válida.",
		number: "Por favor, escribe un número válido.",
		digits: "Por favor, escribe sólo dí­gitos.",
		creditcard: "Por favor, escribe un número de tarjeta válido.",
		equalTo: "Por favor, escribe el mismo valor de nuevo.",
		extension: "Por favor, escribe un valor con una extensión aceptada.",
		maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
		minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
		rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
		range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
		max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
		min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}."),
		nifES: "Por favor, escribe un NIF válido.",
		nieES: "Por favor, escribe un NIE válido.",
		cifES: "Por favor, escribe un CIF válido."
	});

}));
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();  
	$('.td-codigo-formato').text(datosVersionFormato.codigo);
	$('.td-fecha-formato').text(datosVersionFormato.fecha);
	$('.td-version-formato').text(datosVersionFormato.version);

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
		},
		ArialOl: {
			normal: 'ARIAOTL.TTF',
			bold: 'ARIAOTL.TTF',
			italics: 'ARIAOTL.TTF',
			bolditalics: 'ARIAOTL.TTF' 
		}
	}
	$('.selectipcker').selectpicker('refresh');


   	/* VALIDACIÓN DE CAMPOS PERSONALIZADOS*/

	$.validator.addMethod('validaAnexos', function (value, element, param) { 
		return sumaBytesArchivos(param) < TAMANO_MAXIMO_ARCHIVOS;
	}, 'Tamaño de anexos excedido, los anexos no deben pesar mas de 50Mb');	
 

	$.validator.addMethod('validaFechas', function (value, element, param) {

		var vectorPeriodoInicio = $(element).val().split("/");
		var vectorPeriodoFin = $(param).val().split("/");
		var d1 = new Date(Number(vectorPeriodoFin[2]), Number(vectorPeriodoFin[1])-1, Number(vectorPeriodoFin[0]));
		var d2 = new Date(Number(vectorPeriodoInicio[2]), Number(vectorPeriodoInicio[1])-1, Number(vectorPeriodoInicio[0]));
		return d1 > d2;
	}, 'La fecha final debe ser mayor a la fecha inicial');	

		
	$(document).on('change','#input-periodo-fin',function(){
		$('#input-periodo-inicio').valid();
	});

	$(document).on('change','#input-finalizado-1, #input-finalizado-2',function(){
		if($(this).is(":checked")){
			$('input.archivo').each(function(v){
				if($(this).data('descarga')=='0'){
					$(this).attr('required','required');
				}else{
					$(this).removeAttr('required');
				}
			});
			
		}else{
			$('input.archivo').removeAttr('required');
		}
	}); 

	$(document).on('change','input.archivo',function(){
		$(this).valid();
		$('#validacion-anexos').val(bytesToSize(sumaBytesArchivos('.archivo')));
		$('#validacion-anexos').valid();
	});	
	
	

	var reglas = {
		'validacion-anexos': {
			validaAnexos: ".anexo_planilla",
		},  
		'input-periodo-inicio': {
			validaFechas: '#form-informe-pago #input-periodo-fin',
		}, 
	};

	var mensajes = {
		'validacion-anexos': {
			validaAnexos: 'Tamaño de anexos excedido, los anexos no deben pesar mas de 50Mb',
		},
		'input-periodo-inicio': {
			validaFechas: 'La fecha final debe ser mayor a la fecha inicial',
		}, 					
	};

	validatorInforme =  validarForm('#form-informe-pago',reglas,mensajes);

	/*
	validatorInforme = $('#form-informe-pago').validate({
		rules: {
			"input-periodo-inicio": {
				required: true
			},
			"input-periodo-fin": {
				required: true
			},
			"select-banco": {
				required: true
			},
			"input-tipo-cuenta": {
				required: true
			},
			"input-numero-cuenta": {
				required: true
			},
		},
        rules: reglas,
        messages: mensajes,
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
			
		},
        highlight : function(element) {
			$(element).addClass('has-error');
        }, 
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('has-error');
        	//$(element).closest('.form-group').find('.help-block').html('');
        }   		
	});
	*/
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

	$("#informe_pago_link").on('click', function(e){

		$("#form-informe-pago #select-convenio-a").attr('disabled', true);
		$("#form-informe-pago #select-convenio-b").attr('disabled', true);
		$("#form-informe-pago #select-convenio-c").attr('disabled', true);
		$("#form-informe-pago #select-convenio-d").attr('disabled', true);
		$("#form-informe-pago #select-codigo-a").attr('disabled', true);
		$("#form-informe-pago #select-codigo-b").attr('disabled', true);
		$("#form-informe-pago #select-codigo-c").attr('disabled', true);
		$("#form-informe-pago #select-codigo-d").attr('disabled', true);

		e.preventDefault();

		$('#contenedor-form-grid').html(
			'<div class="row" id="form-grid-crear"></div>'
		);

		let datosGetAjax = {
			p1: $('#id-usuario').val()
			// p1: {
			// 	// "fechaFin":$('#fecha-periodo').val(),
			// 	"userId":$('#id-usuario').val()
			// }
		};
		$.ajax({
			url: url_controller+"getUltimoContratoActivo",
			type: 'POST',
			dataType: 'json',
			data: datosGetAjax,
			success: function(result){
				//console.log(result);
				if (result == null) {
					parent.mostrarAlerta("warning",'No tiene contrato activo en SIF', 'Comuniquese con su supervisor de contrato');
					setTimeout(function() {$("#listado_link").trigger("click");}, 5000);
				}
				else{
					if(result[0].FK_Persona_Supervisor == null){
						parent.mostrarAlerta("warning",'No tiene supervisor asignado a su contrato.', 'Debe tener un supervisor asignado para poder diligenciar el informe.');
						setTimeout(function() {$("#listado_link").trigger("click");}, 5000);
					}
					id_contrato_activo = result[0].PK_Id_Tabla;

					cedente = result[0].VC_Nombres_Apellidos_Cedente != null ? result[0].VC_Nombres_Apellidos_Cedente : "";
					if(cedente.length > 0){

						$('#BT_agregar_documento_orfeo_cesion').data('informe',id_contrato_activo);
						$('#BT_agregar_documento_orfeo_cesion').show();
					}else{
						$('#BT_agregar_documento_orfeo_cesion').hide();
					}

					var datos = {
						'p1' :  result[0].PK_Id_Tabla,
						'p2' : 'C' //C: Creacion, E: Edicion, V: Visualizacion
					}; 				
					$.ajax({
						url: url_controller+"getInformePagoAnexos",
						type: 'POST',
						dataType: 'json',
						data: datos,
						success: function(data){
							$("#form-informe-pago-container #contenedor-form-grid").html(data.html);
							$(".archivo").filestyle({btnClass: "btn-primary",buttonBefore: "true", text: "Abrir"});
						},
						error: function(data){
							console.log("Error: "+data.responseText);
						}
					});	

					/*
					var datosGetAnexosO = {
						'p1': obtenerNumeroPagoAnexos(result[0].VC_Pago_Numero,result[0].VC_Numero_Pagos),
					};					
					$.ajax({
						url: url_controller+"getParametrosAnexosOrfeo",
						type: 'POST',
						dataType: 'json',
						data: datosGetAnexosO,
						success: function(result){
							
								$.each(result, function(key, value)
								{
									let options = `<option selected value="${value.PK_Id_Tabla}">${value.VC_nombre}</option>`;

									let nuevo_campo = ` 
										<div class="col-md-12 col-lg-12 item-grid" style="margin-top: 6px;">
											<div class="col-md-4 col-lg-4">
												<select name="tipo_documento" class="form-control tipo_documento" disabled>
													<option value="">- Seleccione -</option>${options}
												</select>
											</div>
											
											<div class="col-md-6 col-lg-6">
												<input type="file" name="anexo-${key}" class="filestyle form-control archivo anexo_planilla" required="required" data-btnClass="btn-primary" data-buttonBefore="true" runat="server"></input>
											</div> 
										</div>`;																		
										$("#form-grid-crear").append(nuevo_campo);	
						
									$(".archivo").filestyle({btnClass: "btn-primary",buttonBefore: "true", text: value.VC_nombre});
								});
						},error: function(result){
							console.log("Error: ", result);
						}
					});
					*/
				}
			},error: function(result){
				console.log("Error: ", result);
			}
		});
	});

	
	$(document).on('click','#BT_agregar_documento_orfeo_cesion',function(){
		idInforme = $(this).data('informe');
		var datos = {
			'p1' : idInforme,
			'p2' : 'C', //C: Creacion, E: Edicion, V: Visualizacion
			'p3' : 'CESION'
		}; 				
		$.ajax({
			url: url_controller+"getInformePagoAnexos",
			type: 'POST',
			dataType: 'json',
			data: datos,
			success: function(data){
				$("#form-informe-pago-container #contenedor-form-grid").html(data.html);
				$(".archivo").filestyle({btnClass: "btn-primary",buttonBefore: "true", text: "Abrir"});
			},
			error: function(data){
				console.log("Error: "+data.responseText);
			}
		});			
	});
	

	$('#btn-limpiar-informe').on('click', function(e){
		e.preventDefault();

		$('#input-finalizado-1').prop('checked',false);
		$('#input-finalizado-1').change();
		loadForm();
	});
	$('#listado_link').on('click', function(e){
		e.preventDefault();
		refreshListado();
		$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
	});
	var tableListado = null;
	function init() {
		tableListado = $('#table-listado-informes').DataTable( {
			"paging":   true,
			"ordering": true,
			"info":     false,
			"pageLength": 25,
			"columnDefs": [
			{
				"targets": [ 0 ],
				"visible": false,
				"searchable": false
			},
			/*{
				"targets": [ 7 ],
				"visible": false,
				"searchable": false
			}*/
			],
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

	//PROMESAS
	const refreshListado2 = ()=>{
		return new Promise((resolve, reject)=>{

			try{
				parent.mostrarCargando();

				let datosGetAjax = {
					p1: {
						"fecha_inicio":$('#fecha_inicio').val(),
						"fecha_fin":$('#fecha_fin').val(),
						"userId":$('#id-usuario').val(),
						"tipo":$('#select-tipo-lista').val(),
						"estado":$('#select-estado-lista').val()
					}
				};
				tableListado.clear().draw();
				$.ajax({
					url: url_controller+"getListadoInformesMejorado",
					type: 'POST',
					dataType: 'html',
					data: datosGetAjax,
					success: function(result){
						tableListado.rows.add($(result)).draw();
						parent.cerrarCargando();
						//parent.mostrarAlerta("warning","RECUERDA","<br>El usuario de Orfeo debe ser tramitado con el área de gestión documental",null,58000)
						$('[data-toggle="tooltip"]').tooltip();
						resolve ("tabla refrescada")
					},error: function(result){
						reject("No se pudo refrescar la tabla")
					}
				});

			}catch(err) {
			  reject('No se pudo refrescar la tabla');
			}
		  
		});
	}

	const radicarInformePagoArchivos = (informeSelected)=>{

		return new Promise((resolve, reject)=>{
			try{

				var datos = {
					'p1' : informeSelected
				};
				$.ajax({
					url: url_controller+"getInformePago",
					type: 'POST',
					dataType: 'json',
					data: datos,
					success: function(generalPDF){
						informe = renderInformePago(generalPDF,'legal');
						const pdfDocGenerator = pdfMake.createPdf(informe);
						pdfDocGenerator.getBase64((pdf_base64) => {
								
							certificadoCumplimiento = renderCertificadoCumpliemiento(generalPDF,'legal');
							const pdfDocGeneratorCertificado = pdfMake.createPdf(certificadoCumplimiento);
							pdfDocGeneratorCertificado.getBase64((pdf_base64Mensual) => {
								const datos = {
									p1: {
										"informePago":pdf_base64,
										"certificadoMensual":pdf_base64Mensual,
										//"certificadoFinal":pdf_base64Final
									},
									p2: informeSelected
								};
								$.ajax({
									url: url_controller+"radicarInformePagoArchivos",
									type: 'POST',
									data: datos,
									success: function(result){
										result = JSON.parse(result);
										if(result.type == 'success'){
											resolve ({'type' : result.type,'title' : result.title, 'message': result.message});
										}else{
											reject({'type' : result.type,'title' : result.title, 'message': result.message});
										}
									},error: function(result){
										reject({'type' : 'error','title' : '¡Algo salió mal!', 'message': 'Se presentó un error generando el radicado'});
									}
								});
							});
							
						});
						

					},error: function(result){
						console.error("Error: "+result);
						reject(false);
					}
				});				
			}catch(err) {
				console.error("Error: "+err);
				reject(false);
			
			}
		  
		});
	}

	function validarCantidadFirmasAprobadas(informeSelected,esinformeRadicado){
		var data = {
			'p1': informeSelected, 
		};
		$.ajax({
			url: url_controller+"validarCantidadFirmasAprobadas",
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(data){
				if(data.ultimaFirma){
					if (!esinformeRadicado){
						parent.mostrarCargando();
						radicarInformePagoArchivos(informeSelected)
						.then((mensaje)=>{
							firmarRadicado(informeSelected,mensaje);
						});
					}else{
						mensaje = {'type' : 'success','title' : 'Bien hecho!', 'message': ''}
						firmarRadicado(informeSelected,mensaje);
					}												
				}else{ 
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: data.title,
						html: `${data.message}`,
						type: data.type,
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					});
				}				
			},error: function(result){
				parent.swal({
					confirmButtonColor: '#3f9a9d',
					title: 'ERROR',
					html: '<small>No se pudo firmar electronicamente, consulte al administrador del sistema.</small>',
					type: 'error',
					confirmButtonText: 'Aceptar',
					showCancelButton: false,
				});							
			}
		});		
	}	
	
	function renderInformePago(informe,tamano)
	{
		var generalPDF = informe;
		generalPDF.obligacionesTabla = [];
		generalPDF.obligacionesTabla.push(
			[{text:'ACTIVIDADES DEL CONTRATISTA DURANTE EL PERÍODO DEL INFORME',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]
			);
		generalPDF.heightsTablaObligaciones = [];
		generalPDF.heightsTablaObligaciones.push(0);
		for (var i = 1; i <= generalPDF["input-numero-obligaciones"]; i++) {
			generalPDF.heightsTablaObligaciones.push(9);
			generalPDF.heightsTablaObligaciones.push(9);
			lastoblig = null;
			if (generalPDF["input-numero-obligaciones"] == i) {
				lastoblig = "lastoblig";
			}
			generalPDF.obligacionesTabla.push(
				[{margin: [0, 1, 0, 0],text:generalPDF['input-oblicacion-'+i],style: 'subtitlesmall',border: [true, true, true, false],id: lastoblig}],
				);
			
			generalPDF.obligacionesTabla.push(
				[{margin: [0, 1, 0, 0],text:generalPDF['input-descripcion-'+i],style: 'generalsmall',border: [true, true, true, false]}],
				);      
		}
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;

		var yyyy = today.getFullYear();
		if(dd < 10){
			dd='0'+dd;
		}
		if(mm < 10){
			mm="0"+mm;
		} 
		if (generalPDF["fecha-informe"]  == "" || generalPDF["fecha-informe"]  == null)
			generalPDF.fechaHoy = dd+'/'+mm+'/'+yyyy;
		else
			generalPDF.fechaHoy = generalPDF["fecha-informe"];	
			
		var fecha_producto = "";
		if (((generalPDF["input-fecha-fin"] == "15/12/2019") || (generalPDF["input-fecha-plazo-fin"] == "15/12/2019")) && (generalPDF["input-numero-pagos"] == generalPDF["input-pago-numero"]))  { fecha_producto = "15/12/2019";}
		else{fecha_producto = generalPDF.fechaHoy;}
		var dd = {
			pageSize: tamano,
			pageOrientation: 'portrait',
			pageMargins:[19,55,20,90],
			watermark: {text: 'APROBADO', color: 'gray', opacity: 0.8, bold: true, italics: false,marginX:0,marginY:60,font: 'ArialOl'},
			footer: {
				columns: [
				{ text: datosVersionFormato.codigo+'\n'+ 
				datosVersionFormato.fecha+'\n'+ 
				datosVersionFormato.version+'\n', style: 'footerStyle',id:"lastrow"}
				]
			},
			content: [
			{ 
				style: 'tableExample',
				table: {
					widths: [109, '*', 158],
					heights:[12,12,20],
					body: [
					[{image: 'idartes_logo',width: 70,rowSpan: 3,alignment:'center'},
					{text:'GESTIÓN FINANCIERA',style: 'titles',rowSpan: 2,margin: [0, 11, 0, 0]},
					{text:datosVersionFormato.codigo,style: 'general',margin: [0, 2, 0, 0]}],
					[{},{text:{}},{text:datosVersionFormato.fecha,style: 'general',margin: [0, 2, 0, 0]}],
					[{},{text:'INFORME PARA PAGO (PERSONA NATURAL Y/O JURÍDICA)',style: 'titles',margin: [0, 12, 0, 0]},{text:datosVersionFormato.version,style: 'general',margin: [0, 12, 0, 0]}]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{border: [true, false, true, false],text: ''}]
					]
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: [109, 150, '*'],
					body: [
					[{text:'Fecha del Informe',style: 'subtitle',fillColor:'#e6e6e6',border: [true, true, true, false]},{text:generalPDF.fechaHoy,style: 'generalcenter',border: [true, true, true, false]},{border: [true, false, true, false],text: ''}]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:'INFORMACIÓN BÁSICA DEL CONTRATISTA',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: [100, 75, 75, '*', 109],
					body: [
					[{text:'PERÍODO DEL INFORME',style: 'subtitle',border: [true, true, true, false]},
					{text:generalPDF["input-periodo-inicio"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-periodo-fin"],style: 'generalcenter',border: [true, true, true, false]},
					{text:'No. DEL CONTRATO',style: 'subtitle',border: [true, true, true, false]},
					{text:generalPDF["input-numero-contrato"],style: 'generalcenter',border: [true, true, true, false]}
					],
					[{text:'SUSPENSIÓN',style: 'subtitle',border: [true, true, true, false]},
					{text:generalPDF["input-suspension-inicio"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-suspension-fin"],style: 'generalcenter',border: [true, true, true, false]},
					{text:'',style: 'generalcenter',border: [true, true, false, false]},
					{text:'',style: 'generalcenter',border: [false, true, true, false]},
					],
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: [200, '*', 25,75],
					body: [
					[{text:'NOMBRES Y APELLIDOS DEL CONTRATISTA',style: 'subtitle',border: [true, true, true, false]},
					{text:generalPDF["input-nombres-apellidos"],style: 'generalcenter',border: [true, true, true, false]},
					{text:identificaciones[generalPDF["select-identificacion"]-1].nombre,style: 'subtitlecenter',border: [true, true, true, false]},
					{text:generalPDF["input-identificacion"],style: 'generalcenter',border: [true, true, true, false]},
					],
					[{text:'ACTIVIDAD ECONÓMICA (CIIU)',style: 'subtitle',border: [true, true, true, false]},
					{text:generalPDF["input-ciiu"],style: 'generalcenter',border: [true, true, true, false]},
					{text:'',border: [true, true, true, false],colSpan: 2},
					{},
					],
					[{text:'NOMBRES Y APELLIDOS DEL CONTRATISTA CEDENTE \n  (Diligencie este item, en caso de cesión de contrato) ',style: 'subtitle',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-nombres-apellidos-cedente"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:identificaciones[generalPDF["select-tipo-identificacion-cedente"]-1].nombre,style: 'subtitlecenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-identificacion-cedente"],style: 'generalcenter',border: [true, true, true, false]},
					],
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:'INFORMACIÓN BANCARIA DEL CONTRATISTA A QUIEN SE LE VA A GIRAR',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					heights: [15],
					widths: [75, 106, 70, 70, 72, "*"],
					body: [
					[{margin: [0, 3, 0, 0],text:'BANCO:',style: 'subtitle',border: [true, true, true, false]},
					{margin: [0, 3, 0, 0],text:bancosPDF[generalPDF["select-banco"]],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 3, 0, 0],text:'TIPO DE CUENTA:',style: 'subtitle',border: [true, true, true, false]},
					{margin: [0, 3, 0, 0],text:generalPDF["input-tipo-cuenta"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 3, 0, 0],text:'No. CUENTA:',style: 'subtitle',border: [true, true, true, false]},
					{margin: [0, 3, 0, 0],text:generalPDF["input-numero-cuenta"],style: 'generalcenter',border: [true, true, true, false]}
					]
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:'INFORMACIÓN DEL CONTRATO',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					heights: [15],
					widths: [75, 65, 50, 50, 50, 55, 69.6, "*"],
					body: [
					[
					{text:'Objeto:',style: 'subtitle',border: [true, true, true, false]},
					{text:generalPDF["input-objeto"],style: 'general',border: [true, true, true, false],colSpan:7},
					{},{},{},{},{},{}
					],[
					{text:'Fecha de Inicio',style: 'subtitle',border: [true, true, true, false]},
					{text:generalPDF["input-fecha-inicio"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 7, 0, 0],text:'Plazo Inicial:',style: 'subtitlecenter',border: [true, true, true, false],rowSpan:2},
					{margin: [0, 7, 0, 0],text:generalPDF["input-plazo-inicial"],style: 'generalcenter',border: [true, true, true, false],rowSpan:2},
					{margin: [0, 7, 0, 0],text:'Prórrogas:',style: 'subtitlecenter',border: [true, true, true, false],rowSpan:2},
					{margin: [0, 7, 0, 0],text:generalPDF["input-prorrogas"],style: 'generalcenter',border: [true, true, true, false],rowSpan:2},
					{margin: [0, 7, 0, 0],text:'Fecha Final:',style: 'subtitlecenter',border: [true, true, true, false],rowSpan:2},
					{margin: [0, 7, 0, 0],text:generalPDF["input-fecha-plazo-fin"],style: 'generalcenter',border: [true, true, true, false],rowSpan:2},
					],[
					{text:'Fecha Terminación',style: 'subtitle',border: [true, true, true, false]},
					{text:generalPDF["input-fecha-fin"],style: 'generalcenter',border: [true, true, true, false]},
					{},{},{},{},{},{}
					],[
					{text:'Número de pagos pactados',style: 'subtitle',border: [true, true, true, false],colSpan:2},{},
					{text:generalPDF["input-numero-pagos"],style: 'generalcenter',border: [true, true, true, false]},
					{text:'',border: [true, true, true, false],colSpan:5},{},{},{},{}
					]
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					widths: [75, 16, 16, 15.2, "*"],
					body: [
					[
					{margin: [0, 0, 0, 0],text:'Pago No.',style: 'subtitle',border: [true, true, true, false],},
					{margin: [0, 0, 0, 0],text:generalPDF["input-pago-numero"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:'de',style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["input-pago-de-total"],style: 'generalcenter',border: [true, true, true, false]},
					{text:'',border: [true, true, true, false]}
					]
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:'INFORMACIÓN FINANCIERA DEL CONTRATO',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					widths: [75, 65, 50, 50, 79.1, 65, 50, "*"],
					body: [
					[
					{margin: [0, 0, 0, 0],text:'No REGISTRO PRESUPUESTAL',style: 'subtitlecenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:'CÓDIGO FUENTE',style: 'subtitlecenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:'CONVENIO',style: 'subtitlecenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:'VALOR A PAGAR',style: 'subtitlecenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:'No REGISTRO PRESUPUESTAL',style: 'subtitlecenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:'CÓDIGO FUENTE ',style: 'subtitlecenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:'CONVENIO',style: 'subtitlecenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:'VALOR A PAGAR',style: 'subtitlecenter',border: [true, true, true, false]},
					],
					[
					{margin: [0, 0, 0, 0],text:generalPDF["input-rp-contenido-a"] != null ? generalPDF["input-rp-contenido-a"]:'',style: 'generalsmall',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["select-codigo-a"] != null ? codigos[generalPDF["select-codigo-a"]].VC_Descripcion:'',style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["select-convenio-a"] != null ? convenios[generalPDF["select-convenio-a"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["input-rp-valor-a"] != null ? generalPDF["input-rp-valor-a"]:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["input-rp-contenido-c"] != null ? generalPDF["input-rp-contenido-c"]:'', style: 'generalsmall',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["select-codigo-c"] != null ? codigos[generalPDF["select-codigo-c"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["select-convenio-c"] != null ? convenios[generalPDF["select-convenio-c"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["input-rp-valor-c"] != null ? generalPDF["input-rp-valor-c"]:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					],
					[
					{margin: [0, 0, 0, 0],text:generalPDF["input-rp-contenido-b"] != null ? generalPDF["input-rp-contenido-b"]:'', style: 'generalsmall',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["select-codigo-b"] != null ? codigos[generalPDF["select-codigo-b"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["select-convenio-b"] != null ? convenios[generalPDF["select-convenio-b"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["input-rp-valor-b"] != null ? generalPDF["input-rp-valor-b"]:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["input-rp-contenido-d"] != null ? generalPDF["input-rp-contenido-d"]:'', style: 'generalsmall',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["select-codigo-d"] != null ? codigos[generalPDF["select-codigo-d"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["select-convenio-d"] != null ? convenios[generalPDF["select-convenio-d"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["input-rp-valor-d"] != null ? generalPDF["input-rp-valor-d"]:'', style: 'generalsmallcenter',border: [true, true, true, false]},
					]
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					widths: [110, 60, 55, "*"],
					body: [
					[
					{text:'Valor inicial Contrato:',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-valor-inicial"],style: 'general',border: [true, true, true, false],colSpan:3},
					{},{}
					],[
					{text:'Valor Adición 1:',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-valor-adicion-1"],style: 'general',border: [true, true, true, false],colSpan:3},
					{},{}
					],[
					{text:'Valor Adición 2:',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-valor-adicion-2"],style: 'general',border: [true, true, true, false],colSpan:3},
					{},{}
					],[
					{text:'Valor Adición 3:',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-valor-adicion-3"],style: 'general',border: [true, true, true, false],colSpan:3},
					{},{}
					],[
					{text:'Valor total del Contrato \n(Incluidas adiciones)',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-valor-total-contrato"],style: 'general',border: [true, true, true, false],colSpan:3},
					{},{}
					],[
					{text:'Valor pago a efectuar',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-valor-pago-efectuar"],style: 'general',border: [true, true, true, false]},
					{text:'Valor en Letras',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-valor-letras"],style: 'general',border: [true, true, true, false]},
					],[
					{text:'Pagos efectuados a la fecha',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-giros-efectuados"],style: 'general',border: [true, true, true, false],colSpan:3},
					{},{}
					],[
					{text:'Saldo pendiente de pago',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-saldo-pediente"],style: 'general',border: [true, true, true, false],colSpan:3},
					{},{}
					],[
					{text:'Valor a liberar',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-valor-liberar"],style: 'general',border: [true, true, true, false],colSpan:3},
					{},{}
					],
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					heights:generalPDF.heightsTablaObligaciones,
					widths: ['*'],
					body:generalPDF.obligacionesTabla
					
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:'PRODUCTOS ENTREGADOS DURANTE EL PERÍODO DEL PRESENTE INFORME',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					}
				}
			},{
				style: 'tableExample',
				table: {
					widths: [215,85,"*"],
					body: [
					[
					{text:'PRODUCTO ENTREGADO ',style: 'subtitlecenter',border: [true, true, true, false]},
					{text:'FECHA DE ENTREGA \nDEL PRODUCTO ',style: 'subtitlecenter',border: [true, true, true, false]},
					{text:'MECANISMO DE VERIFICACIÓN  ',style: 'subtitlecenter',border: [true, true, true, false]},
					],[
					{text:generalPDF["textarea-producto"],style: 'general',border: [true, true, true, false]},
					{margin: [0,5, 0, 0],text:fecha_producto,style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["textarea-mecanismo-verificacion"],style: 'general',border: [true, true, true, false]},
					]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:'DECLARACIÓN JURAMENTADA',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					widths: [180,30,30,'*'],
					body: [
					[
					{text:'',style: 'subtitlecenter',border: [true, true, true, false]},
					{text:'SI',style: 'subtitlecenter',border: [true, true, true, false]},
					{text:'NO',style: 'subtitlecenter',border: [true, true, true, false]},
					{text:'OBSERVACIONES',style: 'subtitlecenter',border: [true, true, true, false]},
					],
					[
					{text:'¿De acuerdo con el Artículo 383. Parágrafo 2 del Estatuto Tributario, para la prestación del servicio o actividad he contratado o vinculado dos (2) o más trabajadores asociados a la actividad por al menos noventa (90) días continuos o discontinuos?',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-1-si"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-1-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-1-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Pertenece usted al nuevo Régimen Simple de tributación responsabilidad en el RUT (47)?',style: 'general',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-2-si"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-2-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-2-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Es usted responsable de Impuesto sobre Ventas (IVA)?',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-3-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-3-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-3-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Es responsable de declaración de renta año inmediatamente anterior?',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-4-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-4-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-4-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Es usted una Entidad Estatal o tiene régimen de tributacion especial?',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-5-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-5-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-5-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Actualmente tiene suscrito otros contratos con el Distrito o la Nación?',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-12-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-12-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-12-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Es usted Facturador Electrónico?',style: 'general',border: [true, true, true, false]},
					{margin: [0, 10, 0, 0],text:generalPDF["input-declaracion-6-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 10, 0, 0],text:generalPDF["input-declaracion-6-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-6-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Tiene dependientes a su cargo? (Decreto 1070 de 2013 Art. 387 E.T.) (solo se tomará encuenta si se anexan soportes mencionados en la tabla Disminución Retención Art 387 E.T.)',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-7-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-7-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-7-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Realizó pagos por intereses de vivienda en el año 2020? (solo se tomará encuenta si se anexan soportes mencionados en la tabla Disminución Retención Art 387 E.T.)',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-8-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-8-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-8-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Realizó pagos de Medicina Prepagada o Plan Complementario en el año 2020? (solo se tomará encuenta si se anexan soportes mencionados en la tabla Disminución Retención Art 387 E.T.)',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-9-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-9-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-9-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Efectúa pagos en una cuenta AFC? De ser así en observaciones indique el valor mensual pagado anexando certificación bancaria de la cuenta AFC',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-10-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-10-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-10-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿Efectúa pagos de Pensiones Voluntarias? De ser así en observaciones indique el valor mensual (Anexar copia del pago correspondiente)',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-11-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-11-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-11-observacion"],style: 'general',border: [true, true, true, false]},
					],
					/*[
					{text:'¿Actualmente tiene suscrito otros contratos con el Distrito o la Nación?',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-12-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-12-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-12-observacion"],style: 'general',border: [true, true, true, false]},
					],*/
					[
					{text:'¿Tiene alguna sanción o embargo?',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-13-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-13-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-13-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:'¿El pago de la ARL es asumido por el IDARTES?',style: 'general',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-14-si"],style: 'generalcenter',border: [true, true, true, false]},
					{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-14-no"],style: 'generalcenter',border: [true, true, true, false]},
					{text:generalPDF["input-declaracion-14-observacion"],style: 'general',border: [true, true, true, false]},
					],
					[
					{text:['Yo '+generalPDF["input-nombres-apellidos"]+', en mi calidad de contratista del IDARTES certifico bajo la gravedad de juramento, que los documentos soporte del pago de Salud, Pensión y ARL, corresponden a los ingresos provenientes del contrato materia del pago sujeto a retención y que estos aportes NO ',
					{text: generalPDF["input-disminucion-retencion-no"] == "" ? "  ": generalPDF["input-disminucion-retencion-no"], fontSize: 7,decoration: 'underline',decorationStyle: 'solid',decorationColor: 'black'},
					'  SI ',
					{text: generalPDF["input-disminucion-retencion-si"] == "" ? "  ": generalPDF["input-disminucion-retencion-si"], fontSize: 7,decoration: 'underline',decorationStyle: 'solid',decorationColor: 'black'},
					' sirvieron para la disminución de la base de Retención en la Fuente de Renta o del impuesto de Industria y Comercio en otro cobro, por lo tanto NO ',
					{text: generalPDF["input-tomados-retencion-no"] == "" ? "  ": generalPDF["input-tomados-retencion-no"], fontSize: 7,decoration: 'underline',decorationStyle: 'solid',decorationColor: 'black'},
					'  SI  ',
					{text: generalPDF["input-tomados-retencion-si"] == "" ? "  ": generalPDF["input-tomados-retencion-si"], fontSize: 7,decoration: 'underline',decorationStyle: 'solid',decorationColor: 'black'},
					'  pueden ser tomados para tal fin por el IDARTES.\n\n El (los) número(s) o referencias(s) de las(s) planilla(s) por el aporte de(l) (los) mes(es) de '+generalPDF["input-mes-planilla"]+' es(son):\n '+generalPDF["input-numero-planilla"]+' (Anexo copia(s) de la(s) planilla(s)).'],style: 'general',border: [true, true, true, false],colSpan:4},
					{text:'',style: 'general',border: [true, true, true, false]},
					{text:'',style: 'general',border: [true, true, true, false]},
					{text:'',style: 'general',border: [true, true, true, false]},
					],
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:'LOS PRODUCTOS QUE SE CERTIFICAN Y EL CUMPLIMIENTO DE OBLIGACIONES CONTRACTUALES HAN SIDO VERIFICADOS POR:',style: 'subtitlecenter',border: [true, true, true, false]}]
	
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},{
				style: 'tableExample',
	
				table: {
					heights: [0,1,10,0],
					widths: [10,200,'*',200,10],
					body: [
					[{text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{image: generalPDF['span-firma-supervisor'] != '' && generalPDF['span-firma-supervisor'] != 'data:,' ? 'firma_supervisor':'sin_firma',width: 180,height: 50, rowSpan: 3,alignment:'left', border: [false, false, false, false]},
					{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{image: generalPDF['span-firma-contratista'] != '' && generalPDF['span-firma-contratista'] != 'data:,' ? 'firma_contratista':'sin_firma',width: 180,height: 50,rowSpan: 3,alignment:'left', border: [false, false, false, false]},
					{text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{text:'',style: 'subtitle',border: [false, false, false, false]},
					{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{text:'',style: 'subtitle',border: [false, false, false, false]},
					{text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{text:generalPDF['span-nombre-supervisor'],style: 'subtitle',border: [false, true, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:generalPDF["input-nombres-apellidos"],style: 'subtitle',border: [false, true, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{margin: [0, -3, 0, 0],text:generalPDF['span-cargo-supervisor'],style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, -3, 0, 0],text:'Contratista',fontSize: 7.2,border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{margin: [0, -6, 0, 0],text:'Revisó Supervisor o Interventor',fontSize: 7.2,border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{image: generalPDF['span-firma-apoyo'] != '' && generalPDF['span-firma-apoyo'] != 'data:,' ? 'firma_apoyo':'sin_firma',width: 180,height: 50,rowSpan: 3,alignment:'left', border: [false, false, false, false]},
					{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{image: generalPDF['span-firma-apoyo_dos'] != '' && generalPDF['span-firma-apoyo_dos'] != 'data:,' ? 'firma_apoyo_dos':'sin_firma',width: 180,height: 50,rowSpan: 3,alignment:'left', border: [false, false, false, false]},
					{text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{margin: [0, 0, 0, 0],text:generalPDF['span-nombre-apoyo'],style: 'subtitle', border: generalPDF['span-nombre-apoyo'] != '' ? [false, true, false, false] : [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:generalPDF['span-nombre-apoyo_dos'],style: 'subtitle', border: generalPDF['span-nombre-apoyo_dos'] != '' ? [false, true, false, false] : [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}], 
	
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{margin: [0, -3, 0, 0],text:generalPDF['span-cargo-apoyo'],style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, -3, 0, 0],text:generalPDF['span-cargo-apoyo_dos'],style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{margin: [0, -3, 0, 0],text:generalPDF["span-etiqueta-apoyo"],fontSize: 7.2,border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, -3, 0, 0],text:generalPDF["span-nombre-apoyo_dos"]!= '' ? 'Revisó Apoyo a la Supervisión':'',fontSize: 7.2,border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
					{margin: [0, 3, 0, 0],text:'Vo.Bo Apoyo Financiero',fontSize: 7,border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
					{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],
	
					[{margin: [0, 0, 0, 0],text:'\n',style: 'subtitlecenter',border: [true, false, true, true],colSpan:5,id:"lastrow"},{},{},{},{}]
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},
			],
	
			pageBreakBefore: function(currentNode, followingNodesOnPage, nodesOnNextPage, previousNodesOnPage) {
				/*count = count + 1;
				bandera = false;
				var total = (generalPDF["input-numero-obligaciones"] * 2) - 2;
				console.log(currentNode);
				console.log(count);
				console.log(total);
				console.log(followingNodesOnPage);
				console.log(nodesOnNextPage);
				console.log(previousNodesOnPage);*/
				//check if signature part is compl etely on the last page, add pagebreak if not
				/*if (count > 108 && (count - 108) == (total)){
					bandera = true;
				}   
				if (bandera && (nodesOnNextPage.length !== 0 && nodesOnNextPage[nodesOnNextPage.length-1].id == "lastrow") ) 
				{
					bandera = false;
					return true; 
				}*/
				/*if (currentNode.id == 'lastoblig') {
					console.log(nodesOnNextPage);
				}*/
				if (currentNode.id == 'lastoblig' && nodesOnNextPage.length != 0 && nodesOnNextPage[nodesOnNextPage.length-1].id == "lastrow")
				{
					return true; 
				}
				else{
					return false; 
				}
	
			},
			images: {
				idartes_logo: 'data:image/png;base64,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',
				firma_apoyo: generalPDF["span-firma-apoyo"],
				firma_apoyo_dos: generalPDF["span-firma-apoyo_dos"],
				firma_supervisor: generalPDF["span-firma-supervisor"],
				firma_contratista: generalPDF["span-firma-contratista"],
				sin_firma: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAACFCAYAAAAtmkC4AAAABHNCSVQICAgIfAhkiAAAAF96VFh0UmF3IHByb2ZpbGUgdHlwZSBBUFAxAAAImeNKT81LLcpMVigoyk/LzEnlUgADYxMuE0sTS6NEAwMDCwMIMDQwMDYEkkZAtjlUKNEABZgamFmaGZsZmgMxiM8FAEi2FMk61EMyAAABH0lEQVR4nO3BMQEAAADCoPVPbQlPoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4GKMEAAdM062UAAAAASUVORK5CYII='
			},
			defaultStyle: {
				font: 'arial'
			},
			styles: {
				titles: {
					fontSize: 7.2,
					bold: true,
					alignment: 'center',
					margin: [0, 8, 0, 0]
				},
				subtitle: {
					fontSize: 7.2,
					bold: true,
					alignment: 'left',
				},
				subtitlecenter: {
					fontSize: 7.2,
					bold: true,
					alignment: 'center',
				},
				subtitlesmallcenter: {
					fontSize: 7.2,
					bold: true,
					alignment: 'center',
				},
				general: {
					fontSize: 7.2,
					alignment: 'left',
				},
				generalsmall: {
					fontSize: 6,
					alignment: 'left',
				},
				subtitlesmall: {
					fontSize: 6,
					bold: true,
					alignment: 'left',
				},
				generalcenter: {
					fontSize: 7.2,
					alignment: 'center',
				},
				generalsmallcenter: {
					fontSize: 6,
					alignment: 'center',
				},
				footerStyle: {
					bold: false,
					margin: [0, 20, 40, 0],
					alignment: 'right',
					fontSize: 7.2
				}
			}
	
		}
		return dd;			
	}

	function renderCertificadoCumpliemiento(informe,tamano){
		var generalPDF = informe;
		var fechaHoy = new Date();
		var dia = fechaHoy.getDate();
		var mes = fechaHoy.getMonth() + 1; 
		var anio = fechaHoy.getFullYear();
	
		var dd = {
			pageSize: tamano,
			pageOrientation: 'portrait',
			pageMargins:[50,55,50,110],
			footer: {
				columns: [
				{ text: '2TR-GJU-F-19'+'\n'+ 
				'23/10/2019'+'\n'+ 
				'Versión 3'+'\n', style: 'footerStyle',id:"lastrow"}
				]
			},
			content: [
			{ 
				style: 'tableExample',
				table: {
					widths: [100, '*', 110],
					heights:[12,12,20],
					body: [
					[{image: 'idartes_logo',width: 70,rowSpan: 4,alignment:'center'},
					{text:'GESTIÓN JURÍDICA',style: 'titles',rowSpan: 2,margin: [0, 11, 0, 0]},
					{text:'Código:GF-F-01',style: 'general',margin: [0, 2, 0, 0]}],
					[{},{text:{}},{text:'Fecha: 09/03/2021',style: 'general',margin: [0, 2, 0, 0]}],
					[{},{text:'CERTIFICACIÓN DE CUMPLIMIENTO CONTRATO DE PRESTACIÓN DE SERVICIOS PROFESIONALES, APOYO A LA GESTIÓN Y TRABAJOS ARTÍSTICOS',rowSpan: 2,style: 'titles',margin: [0, 0, 0, 0]},{text:'Versión 4',style: 'general',margin: [0, 6, 0, 0]}],
					[{},{text:{}},{text:'Página: 1 de 1',style: 'general',margin: [0, 2, 0, 0]}],
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{border: [false, false, false, false],text: ''}],
					[{border: [false, false, false, false],text: ''}],
					[{border: [false, false, false, false],text: ''}],
					[{border: [false, false, false, false],text: ''}]
					]
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:[
						{text: generalPDF["span-nombre-supervisor"]+', '+generalPDF["span-cargo-supervisor"]+', ', bold:true},
						{text:'actuando en mi calidad de supervisor(a) del Contrato de Prestación de Servicios N° '},
						{text: generalPDF["input-numero-contrato"]+' ', bold:true},
						{text:'suscrito por el INSTITUTO DISTRITAL DE LAS ARTES con el (la) contratista '},
						{text: generalPDF["input-nombres-apellidos"]+', ', bold:true},
						{text:'cuyo objeto es "'+generalPDF["input-objeto"]+'", '},
						{text:'certifico que de acuerdo con las obligaciones pactadas, el citado ha hecho entrega de la totalidad de los productos del contrato del periodo comprendido entre el '},
						{text:generalPDF["input-periodo-inicio"]+' al '+generalPDF["input-periodo-fin"]+', ', bold:true},
						{text:'por lo tanto se solicita a la subdirección Administrativa y Financiera hacer el pago correspondiente al contratista.'}
						],style: 'subtitle',border: [false, false, false, false]}]
						]
					}
				},
				{
					style: 'tableExample',
					table: {
						widths: ['*'],
						body: [
						[{border: [false, false, false, false],text: ''}],
						[{border: [false, false, false, false],text: ''}]
						]
					}
				},
				{
					style: 'tableExample',
					table: {
						widths: ['*'],
						body: [
						[{text:[
							{text: 'Así mismo certifico que el contratista se encuentra al día con los aportes al Sistema de Seguridad Social Integral de conformidad con la normatividad que rige la materia, tal y como se acredita en los soportes de liquidación de planilla y pago que se anexan con el informe para realizar el '},
							{text: 'PAGO NÚMERO '+generalPDF["input-pago-numero"]+' de '+generalPDF["input-pago-de-total"], bold:true},
							{text:' del contrato, los cuales han sido verificados con el operador que liquida la planilla para pagos al Sistema.'},
							],style: 'subtitle',border: [false, false, false, false]}]
							]
						}
					},
					{
						style: 'tableExample',
						table: {
							widths: ['*'],
							body: [
							[{border: [false, false, false, false],text: ''}],
							[{border: [false, false, false, false],text: ''}]
							]
						}
					},
					{
						style: 'tableExample',
						table: {
							widths: ['*'],
							body: [
							[{text:[
								{text: 'Con la suscripción de esta certificación también se advierte al contratista que su obligación es efectuar los aportes exigidos por la disposición de ley y es de su respectivo resorte el pago de las cotizaciones al Sistema de Seguridad Social Integral, el cual se debe efectuar mes vencido, por periodos mensuales, a través de la planilla integrada de Liquidación de Aportes (PILA) y teniendo en cuenta los ingresos percibidos en el periodo de cotización, esto es, el mes inmediatamente anterior; hecho que se da por conocido por el contratista con el recibo de la presente.'}
								],style: 'subtitle',border: [false, false, false, false]}]
								]
							}
						},
						{
							style: 'tableExample',
							table: {
								widths: ['*'],
								body: [
								[{border: [false, false, false, false],text: ''}],
								[{border: [false, false, false, false],text: ''}]
								]
							}
						},
						{
							style: 'tableExample',
							table: {
								widths: ['*'],
								body: [
								[{text:[
									{text: 'Esta certificación se expide en la ciudad de Bogotá, a los '},
									{text: dia, bold:true},
									{text: ' día(s) del mes de '},
									{text: meses[parseInt(mes)], bold:true},
									{text: '  de '},
									{text: anio+'.', bold:true},
									],style: 'subtitle',border: [false, false, false, false]}]
									]
								}
							},
							{
								style: 'tableExample',
								table: {
									widths: ['*'],
									body: [
									[{border: [false, false, false, false],text: ''}],
									[{border: [false, false, false, false],text: ''}],
									[{border: [false, false, false, false],text: ''}]
									]
								}
							},
							{
								style: 'tableExample',
	
								table: {
									heights: [0,1,10,0],
									widths: [130,'*',130],
									body: [
									[
									{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{image: generalPDF['span-firma-supervisor'] != '' && generalPDF['span-firma-supervisor'] != 'data:,' ? 'firma_supervisor':'sin_firma',width: 180,height: 50, rowSpan: 3,alignment:'center', border: [false, false, false, false]},
									{text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],
	
									[
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],
	
									[
									{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{text:'',style: 'subtitle',border: [false, false, false, false]},
									{text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],
	
									[
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{margin: [0, 3, 0, 0],text:generalPDF['span-nombre-supervisor'],style: 'subtitlecenter',border: [false, true, false, false], bold:true},
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],
	
									[
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{margin: [0, -3, 0, 0],text:generalPDF['span-cargo-supervisor'],style: 'subtitlecenter',border: [false, false, false, false], bold:true},
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],
	
									[
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{margin: [0, -6, 0, 0],text:'Supervisor(a)',style: 'subtitlecenter',border: [false, false, false, false], bold:true},
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									]
									]
								},layout: {
									vLineWidth: function (i, node) {
										return 0.9;
									},
									hLineWidth: function (i, node) {
										return 0.9;
									},
								}
							},
							],
							images: {
								idartes_logo: 'data:image/png;base64,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',
								firma_supervisor: generalPDF["span-firma-supervisor"],
								sin_firma: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAACFCAYAAAAtmkC4AAAABHNCSVQICAgIfAhkiAAAAF96VFh0UmF3IHByb2ZpbGUgdHlwZSBBUFAxAAAImeNKT81LLcpMVigoyk/LzEnlUgADYxMuE0sTS6NEAwMDCwMIMDQwMDYEkkZAtjlUKNEABZgamFmaGZsZmgMxiM8FAEi2FMk61EMyAAABH0lEQVR4nO3BMQEAAADCoPVPbQlPoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4GKMEAAdM062UAAAAASUVORK5CYII='
							},
							defaultStyle: {
								font: 'arial'
							},
							styles: {
								titles: {
									fontSize: 10,
									bold: true,
									alignment: 'center',
									margin: [0, 0, 0, 0]
								},
								subtitle: {
									fontSize: 11,
									bold: false,
									alignment: 'justify',
								},
								subtitlecenter: {
									fontSize: 11,
									bold: true,
									alignment: 'center',
								},
								general: {
									fontSize: 10,
									alignment: 'left',
								},
								footerStyle: {
									bold: false,
									margin: [0, 20, 40, 0],
									alignment: 'right',
									fontSize: 10
								}
							}
	
		}
		return dd;		
	}

	function refreshListado() {
		
		parent.mostrarCargando();
		let datosGetAjax = {
			p1: {
				"fecha_inicio":$('#fecha_inicio').val(),
				"fecha_fin":$('#fecha_fin').val(),
				"userId":$('#id-usuario').val(),
				"tipo":$('#select-tipo-lista').val(),
				"estado":$('#select-estado-lista').val()
			}
		};
		tableListado.clear().draw();
		$.ajax({
			url: url_controller+"getListadoInformesMejorado",
			type: 'POST',
			dataType: 'html',
			data: datosGetAjax,
			success: function(result){
				tableListado.rows.add($(result)).draw();
				parent.cerrarCargando();
				//parent.mostrarAlerta("warning","RECUERDA","<br>El usuario de Orfeo debe ser tramitado con el área de gestión documental",null,58000)
				$('[data-toggle="tooltip"]').tooltip();
			},error: function(result){
				console.error("Error: "+result);
			}
		});
	}
	$('#btn-consultar').on('click', function(e){
		e.preventDefault();
		refreshListado();
	});

	$('#input-periodo-fin').on('change', function(e){
		e.preventDefault();
		$.ajax({
			url: url_controller+"validarPeriodo",
			type: 'POST',
			dataType: 'html',
			data:{
				p1:$('#id-usuario').val(),
				p2:$(this).val()
			},
			success: function(result){
				if (result == "5") {
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						html: "Ya existe un informe guardado para el periodo seleccionado.<br><br><small>Debe trabajar sobre el informe que ya existe para el periodo seleccionado editandolo en la pestaña <b>Ver Informes</b>.",
						type: 'error',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					}).then(()=>{
						$("#input-fecha-informe, #input-periodo-inicio, #input-periodo-fin").datepicker( 'setDate', null);
					});
				}
			},error: function(result){
				console.log("Error: "+result);
			}
		});
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
		//$('#form-informe-pago #anexo_planilla').filestyle('clear');
		$('#form-informe-pago .anexo_planilla').filestyle('clear');
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

		convenios = parent.getParametroDetalle(20); //20 id tabla parametro para convenios
		$.each(convenios, function (i) {
			$('#select-convenio-a').append($('<option>', {
				value : convenios[i].FK_Value,
				text : convenios[i].VC_Descripcion
			}));
			$("#select-convenio-a").attr('disabled', true);
			$('#select-convenio-b').append($('<option>', {
				value : convenios[i].FK_Value,
				text : convenios[i].VC_Descripcion
			}));
			$("#select-convenio-b").attr('disabled', true);
			$('#select-convenio-c').append($('<option>', {
				value : convenios[i].FK_Value,
				text : convenios[i].VC_Descripcion
			}));
			$("#select-convenio-c").attr('disabled', true);
			$('#select-convenio-d').append($('<option>', {
				value : convenios[i].FK_Value,
				text : convenios[i].VC_Descripcion
			}));
			$("#select-convenio-d").attr('disabled', true);
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
		codigos = parent.getParametroDetalle(21); //21 id tabla parametro para codigos
		$.each(codigos, function (i) {
			$('#select-codigo-a').append($('<option>', {
				value : codigos[i].FK_Value,
				text : codigos[i].VC_Descripcion
			}));
			$("#select-codigo-a").attr('disabled', true);
			$('#select-codigo-b').append($('<option>', {
				value : codigos[i].FK_Value,
				text : codigos[i].VC_Descripcion
			}));
			$("#select-codigo-b").attr('disabled', true);
			$('#select-codigo-c').append($('<option>', {
				value : codigos[i].FK_Value,
				text : codigos[i].VC_Descripcion
			}));
			$("#select-codigo-c").attr('disabled', true);
			$('#select-codigo-d').append($('<option>', {
				value : codigos[i].FK_Value,
				text : codigos[i].VC_Descripcion
			}));
			$("#select-codigo-d").attr('disabled', true);
		});

		numerRow = 0;

		$("#form-informe-pago-container .obligacion").remove();
		$.ajax({
			url: url_controller+"getInformePagoBasico",
			type: 'POST',
			dataType: 'json',
			data:{p1:$('#id-usuario').val()},
			success: function(result){
				informeSelectedData = result;
				$.each(result, function(key, value) {
					if (key.includes("input-numero-pagos") ){
						$('#BT_agregar_documento_orfeo').data('totalPagos',value);
						$('#BT_editar_documento_orfeo').data('totalPagos',value);
					}
					if (key.includes("input-pago-numero") ){
						$('#BT_agregar_documento_orfeo').data('pagoActual',value);
						$('#BT_editar_documento_orfeo').data('pagoActual',value);
						
					}					
					if (!key.includes("span")){
						if (key.includes("fecha") && key != 'input-fecha-inicio' && key != 'input-fecha-fin' && key != 'input-fecha-plazo-fin')
							$('#form-informe-pago-container #'+key).datepicker("setDate", value);
						else{
							if (key.includes("valor") || key.includes("giros") || key.includes("saldo")){
								$('#form-informe-pago-container #'+key).val(value != "" && value != null ? value : 0);
							}
							else{
								$('#form-informe-pago-container #'+key).val(value);
								if (key.includes("input-numero-obligaciones"))
									changeObligaciones($('#form-informe-pago-container #input-numero-obligaciones'));
							}
						}
						if (key.includes("input-pago-numero"))
							$("#input-pago-numero").val(value+1);
					}
					else{
						key = key.replace("span-","");
						$('#form-informe-pago-container #'+key).text(value);
					}

					$(".rp-contenido").keyup();
				});
				//console.log(result);
				
				/*$('.sum-total').change();
				$('.refresh-saldo').change();*/
				refreshGeneral("#form-informe-pago-container");
			},error: function(result){
				console.log("Error: "+result);
			}
		});

	}
	function refreshGeneral(form) {
		$(form+" .decimalPesos").each(function() {
			$(this).val(function (index, value ) {
				var string = value.replace(/[$. ]/g,"");
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

	/*
	$("#select-tipo-lista").on('change', function(){
		if($(this).val() == 2){
			$("#select-estado-lista").html("<option value='1'>Ver</option><option value='3'>Descargar</option><option value='4' selected>Revisar</option>");
			$("#select-estado-lista").selectpicker('refresh');
		}
		if($(this).val() == 1){
			$("#select-estado-lista option").remove();
			$("#select-estado-lista").html("<option value='1' selected>Ver</option><option value='2' selected>Editar</option><option value='3' selected>Descargar</option>");
			$("#select-estado-lista").selectpicker('refresh');
		}

	});
	*/

	$('body').delegate('.rp-contenido', 'keyup', function(event) {
	/*$(".rp-contenido").on({
	"focus": function (event) {
		$(event.target).select();
	},
	"keyup": function (event) {*/

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
	/*$('#form-informe-pago #input-fecha-informe, #form-editar-informe #input-fecha-informe').on('change', function(e){
		e.preventDefault();
		let formChanged = "#"+$(this).closest('form')[0].id;
		$(formChanged+' #span-fecha-informe').text($(this).val());
	});*/
	$('body').delegate('#form-informe-pago #input-fecha-informe, #form-editar-informe #input-fecha-informe, #form-visualizar-informe #input-fecha-informe, #form-revisar-informe #input-fecha-informe', 'change', function(e) {
		e.preventDefault();

		let formChanged = "#"+$(this).closest('form')[0].id;
		// if ((informeSelectedData["input-fecha-fin"] == "15/12/2019")||((informeSelectedData["input-fecha-plazo-fin"] != "")&&(informeSelectedData["input-fecha-plazo-fin"] == "15/12/2019"))){
		// 	$(formChanged+' #span-fecha-informe').text("15/12/2019");		
		// }
		// else{
			$(formChanged+' #span-fecha-informe').text($(this).val());
		// }

	});
	$('body').delegate('.decimal', 'keyup', function(event) {
	/*$(".decimal").on({
	"focus": function (event) {
		$(event.target).select();
	},
	"keyup": function (event) {*/

		$(event.target).val(function (index, value ) {
			var string = value.replace(/[$ ]/g,"");
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
		var string = $(this).val().replace(/[$ ]/g,"")
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
	/*$(".number").on({
	"focus": function (event) {
	$(event.target).select();},
	"keyup": function (event) {*/

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
			let valor = $(value).val().replace(/[$. ]/g,"").replace(/\,/g,".");
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
		let valor = $(form+' #input-valor-total-contrato').val().replace(/[$. ]/g,"").replace(/\,/g,".");
		let valorTotalContrato = parseFloat(valor);
		valor = $(form+' #input-valor-pago-efectuar').val().replace(/[$. ]/g,"").replace(/\,/g,".");
		let valorPagoEfectuar = parseFloat(valor);
		valor = $(form+' #input-giros-efectuados').val().replace(/[$. ]/g,"").replace(/\,/g,".");
		let girosEfectuados = parseFloat(valor);
		valor = $(form+' #input-valor-liberar').val().replace(/[$. ]/g,"").replace(/\,/g,".");
		let valoraLiberar = parseFloat(valor);
		total = valorTotalContrato - valorPagoEfectuar - girosEfectuados - valoraLiberar;
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
		var cantidadDigitada = $(selfData).val();
		cantidadDigitada = parseInt(cantidadDigitada);
		if (cantidadDigitada > 100){
			cantidadDigitada = 100;
			$(selfData).val(100);
		}
		if ($("#"+$(selfData).closest("form")[0].id+" .obligacion")[0] == undefined) {
			for (var i = cantidadDigitada - 1; i >= 0; i--) {
				numerRow = i+1;
				$(selfData).parent().parent().after(`
					<tr data-cantidad="`+cantidadDigitada+`" class="obligacion obligacion-`+numerRow+`" height=42 style='mso-height-source:userset;height:31.5pt'>
					<td height=42 class=xl6325986 style='height:31.5pt'></td>
					<td colspan=35 class=xl12925986 width=1086 style='width:815pt;height:10px;color:black;'><textarea rows="3" class="supervision" style="resize: vertical; margin-bottom: -5px;width: 100%; height: 100%;" type="text" name="input-oblicacion-`+numerRow+`" id="input-oblicacion-`+numerRow+`" placeholder="`+numerRow+`. ESCRIBA TEXTUALMENTE LA OBLIGACIÓN No. `+numerRow+` DE SU CONTRATO)"></textarea></td>
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
					</tr>
					<tr data-cantidad="`+cantidadDigitada+`" class="obligacion obligacion-`+numerRow+`" height=42 style='mso-height-source:userset;height:31.5pt'>
					<td height=42 class=xl6325986 style='height:31.5pt'></td>
					<td colspan=35 class=xl12925986 width=1086 style='width:815pt;height:10px;color:black;'><textarea rows="3" class="supervision" style="resize: vertical; margin-bottom: -5px;width: 100%; height: 100%;" type="text" name="input-descripcion-`+numerRow+`" id="input-descripcion-`+numerRow+`" placeholder="En este espacio mencione las acciones desarrolladas por usted en cumplimiento de esta obligación contractual, durante el período del informe"></textarea></td>
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
			cantidadAnterior = parseInt(cantidadAnterior);
			if (cantidadAnterior > cantidadDigitada) {
				for (var i = cantidadAnterior ; i > cantidadDigitada; i--) {
					numerRow = i+1;
					$("#"+$(selfData).closest("form")[0].id+" .obligacion-"+i).remove();
				}
			}
			if (cantidadAnterior < cantidadDigitada) {
				for (var i = cantidadDigitada - 1; i >= cantidadAnterior; i--) {
					numerRow = i+1;
					$("#"+$(selfData).closest("form")[0].id+" #input-descripcion-"+cantidadAnterior).parent().parent().after(`
						<tr data-cantidad="`+cantidadDigitada+`" class="obligacion obligacion-`+numerRow+`" height=42 style='mso-height-source:userset;height:31.5pt'>
						<td height=42 class=xl6325986 style='height:31.5pt'></td>
						<td colspan=35 class=xl12925986 width=1086 style='width:815pt;height:10px;color:black;'><textarea rows="2"  class="supervision" style="margin-bottom: -5px;width: 100%; height: 100%;" type="text" name="input-oblicacion-`+numerRow+`" id="input-oblicacion-`+numerRow+`" placeholder="`+numerRow+`. ESCRIBA TEXTUALMENTE LA OBLIGACIÓN No. `+numerRow+` DE SU CONTRATO)"></textarea></td>
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
						</tr>
						<tr data-cantidad="`+cantidadDigitada+`" class="obligacion obligacion-`+numerRow+`" height=42 style='mso-height-source:userset;height:31.5pt'>
						<td height=42 class=xl6325986 style='height:31.5pt'></td>
						<td colspan=35 class=xl12925986 width=1086 style='width:815pt;height:10px;color:black;'><textarea rows="2" class="supervision"  style="margin-bottom: -5px;width: 100%; height: 100%;" type="text" name="input-descripcion-`+numerRow+`" id="input-descripcion-`+numerRow+`" placeholder="En este espacio mencione las acciones desarrolladas por usted en cumplimiento de esta obligación contractual, durante el período del informe"></textarea></td>
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
			$("#"+$(selfData).closest("form")[0].id+" .obligacion").data("cantidad",cantidadDigitada);
		}
	}
	var numerRowWord = 0;
	function changeObligacionesDetallado(selfData,cantidad,edit) {
		$("#"+$(selfData).closest("form")[0].id+" .obligacion").remove();
		for (var i = cantidad - 1; i >= 0; i--) {
			numerRowWord = i+1;
			var obligaciones = "";
			summernote = "summernote";
			if (!edit){
				oblicaciones = `<td><div class="`+summernote+` text-left" style="padding: 10px;resize: vertical;margin-bottom: -5px;width: 100%; height: 100%;" name="input-descripcion-`+numerRowWord+`" id="input-descripcion-`+numerRowWord+`" placeholder="En este espacio mencione las acciones desarrolladas por usted en cumplimiento de esta obligación contractual, durante el período del informe"></div></td>
				'<td><div class="`+summernote+` text-left" style="padding: 10px;resize: vertical;margin-bottom: -5px;width: 100%; height: 100%;" name="input-descripcion-anexo-`+numerRowWord+`" id="input-descripcion-anexo-`+numerRowWord+`" placeholder="Ejemplo: CD:carpeta ANEXOS: ANEXO `+numerRowWord+`."></div></td>`;
			}
			else{	
				oblicaciones = `<td><textarea class="`+summernote+` text-left" rows="3" style="resize: vertical;margin-bottom: -5px;width: 100%; height: 100%;" type="text" name="input-descripcion-`+numerRowWord+`" id="input-descripcion-`+numerRowWord+`" placeholder="En este espacio mencione las acciones desarrolladas por usted en cumplimiento de esta obligación contractual, durante el período del informe"></textarea></td> 
				<td><textarea class="`+summernote+` text-left" rows="3" style="resize: vertical;margin-bottom: -5px;width: 100%; height: 100%;" type="text" name="input-descripcion-anexo-`+numerRowWord+`" id="input-descripcion-anexo-`+numerRowWord+`" placeholder="Ejemplo: CD:carpeta ANEXOS: ANEXO `+numerRowWord+`."></textarea></td> `;
			}
			$(selfData).after(`
				<tr data-cantidad="`+cantidad+`" class="text-left obligacion obligacion-`+numerRowWord+`">
				<td style="background-color: #e6e6e6;" class="content-table" colspan="2"><span name="input-oblicacion-`+numerRowWord+`" id="input-oblicacion-`+numerRowWord+`"></span></td>
				</tr>
				<tr data-cantidad="`+cantidad+`" class="text-left obligacion obligacion-`+numerRowWord+`">`+oblicaciones+`
				</tr>`);
			/*if (edit) {
				$("#"+$(selfData).closest("form")[0].id+" #input-descripcion-"+numerRowWord).summernote({
					dialogsInBody: true,
					height: 100,
					width: "100%",
					placeholder: 'En este espacio mencione las acciones desarrolladas por usted en cumplimiento de esta obligación contractual, durante el período del informe',
					lang: 'es-ES'
				});
				$("#"+$(selfData).closest("form")[0].id+" #input-descripcion-anexo-"+numerRowWord).summernote({
					dialogsInBody: true,
					height: 100,
					width: "100%",
					placeholder: 'Ejemplo: CD:carpeta ANEXOS: ANEXO',
					lang: 'es-ES'
				});
			}*/

		}
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
		value = $(this).val().replace(/[$. ]/g,"").replace(/\,/g,".");
		$(formChanged+' #input-valor-letras').val(numeroALetras(value, {
			plural: 'PESOS',
			singular: 'PESO',
			centPlural: 'centavos',
			centSingular: 'centavo'
		})+" / MCTE");
	});	
	defProgress("#form-informe-pago #progressbar");

	$(document).on('click','.ver_historial',function(){
		idInforme = $(this).data('informe_id');
		var data = {
			'p1': idInforme,
		};
		$.ajax({
			url: url_controller+"getHistorial",
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(result){
				$('#modal-historial').modal("show");
	
				$("#cuerpo").html("");
				
				for(var i=0; i<result.length; i++){
				  var tr = `<tr>
					<td>`+result[i].VC_Primer_Nombre+`</td>
					<td>`+result[i].VC_Primer_Apellido+`</td>
					<td>`+result[i].VC_Observacion+`</td>
					<td>`+result[i].VC_Transaccion+`</td>
					<td>`+result[i].DT_Date+`</td>
					<td>`+((result[i].I_Aprobado==1)?"Aprobado":"Devuelto")+`</td>
				  </tr>`;
				  $("#cuerpo").append(tr)
				}

			},error: function(result){
				parent.swal({
					confirmButtonColor: '#3f9a9d',
					title: 'ERROR',
					html: '<small>No se encontro historico para el radicado</small>',
					type: 'error',
					confirmButtonText: 'Aceptar',
					showCancelButton: false,
				});
			}
		});	
	});

	$(document).on('click','.ver_firmantes',function(){
		idInforme = $(this).data('informe_id');
		var data = {
			'p1': idInforme,
		};
		$.ajax({
			url: url_controller+"verFirmantes",
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(data){
				$('#modal-firmantes').modal("show");
				$("#contenedor-firmantes").html(data.html);
			
			},error: function(result){
				parent.swal({
					confirmButtonColor: '#3f9a9d',
					title: 'ERROR',
					html: '<small>No se encontro firmantes para el informe</small>',
					type: 'error',
					confirmButtonText: 'Aceptar',
					showCancelButton: false,
				});
			}
		});	
	});	

	$('#aceptar_codigo').on('click', function(e){
		idForm = $(this).closest("form").attr("id");
		firmaOrfeo = $('#aceptar_codigo').data('firma_orfeo') != undefined ? $('#aceptar_codigo').data('firma_orfeo') : 1;
		var esinformeRadicado = $(this).data('radicado');
		if($(`#${idForm}`).valid()){ 
			var aprobacion = ($('#id-finalizado-cod').val()=="true") ? 1 : 0;			
			var informeSelected =$("#id-informe-cod").val();		
			var data = {
				'p1': $('#id-usuario-cod').val(),
				'p2': informeSelected,
				'p3': $('#codigo_confirmacion').val(),
				 p4: {
						"aprobacion":aprobacion,
						"sistemaOperativo": navigator.platform,
						"navegador": navigator.appCodeName,
						"navegadorVersion": navigator.appVersion,						
					  },
				'p5': $('#observacion-cod').val(),
			};
			//console.log(data);
			$.ajax({
				url: url_controller+"saveFirma",
				type: 'POST',
				dataType: 'json',
				data: data,
				success: function(result){
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: 'Su codigo de verificación fue almacenado correctamente.',
						type: 'success',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					});
					$('#modal-codigo-confirmacion').modal('hide');
	
					//Validar Cantidad de Firmas aprobadas
					if(firmaOrfeo == 1){
						validarCantidadFirmasAprobadas(informeSelected,esinformeRadicado);
					}
						
				},error: function(result){
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: 'ERROR',
						html: '<small>Su codigo de verificación no pudo ser almacenado.</small>',
						type: 'error',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					});
					$('#modal-codigo-confirmacion').modal('hide');
				}
			});
		}else{
			parent.mostrarAlerta("error",'Algo Salio mal!', 'Revise los campos resaltados en rojo');
		}
	});

	$('#submit-informe-pago').on('click', function(e){

		$("#form-informe-pago #select-convenio-a").attr('disabled', false);
		$("#form-informe-pago #select-convenio-b").attr('disabled', false);
		$("#form-informe-pago #select-convenio-c").attr('disabled', false);
		$("#form-informe-pago #select-convenio-d").attr('disabled', false);
		$("#form-informe-pago #select-codigo-a").attr('disabled', false);
		$("#form-informe-pago #select-codigo-b").attr('disabled', false);
		$("#form-informe-pago #select-codigo-c").attr('disabled', false);
		$("#form-informe-pago #select-codigo-d").attr('disabled', false);

		e.preventDefault();

		var valid = $('#form-informe-pago').valid();
		defProgress("#form-informe-pago #progressbar");
		updateProgress(Math.round(0),"#form-informe-pago #progressbar");
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
				//var files = $("#anexo_planilla")[0].files;
				var datos = new FormData();
				/*
				$.each(files, function(key, value)
				{
					datos.append(key, value);
				});
				*/
				datos.append("p1",JSON.stringify(formularioJson));  
				datos.append("p3",$('#input-finalizado-1').is(":checked"));  
				datos.append("p4",id_contrato_activo);
				
				$.ajax({
					url: url_controller+"saveInformePago",
					type: 'POST',
					dataType: 'json',
					processData: false, // Don't process the files
					contentType: false, // Set content type to false as jQuery will tell the server its a query string request
					data: datos,
					success: function(result){
						if (result == 1) {
							let idUser = {
								p1: $('#id-usuario').val()
							};
							//var arregloParametros;
							$.ajax({
								url: url_controller+"getUltimoInforme",
								type: 'POST',
								dataType: 'json',
								data: idUser,
								success: function(result){
									id_informe_activo = result[0].PK_Id_Tabla;
									//var i = 0;
									//var arregloParametros = [];
									/*$.each($('.item-grid'), function(key, value)
									{
										arregloParametros[i] = $(this).find('option').filter(':selected').val();
										i++;
									});*/

									$.each($('.item-grid'), function(key, value)
									{
										var idParametro = $(this).find('option').filter(':selected').val();
										var inputFile = $(this).find('.archivo').attr('id');
										
										/*if(inArray(idParametro, arregloParametros)) {
											console.log("ya existe un archivo");
											return false;	 
										}*/
										
										if(inputFile != undefined && idParametro != undefined){
											var datos = new FormData();
											var files = '';		

											files = ($("#"+inputFile)[0].files);
											
											datos.append(0, files[0]);	
											datos.append("p1",id_informe_activo);  
											datos.append("p3",$('#id-usuario').val());
											datos.append("p4",idParametro);
											datos.append("p5",id_contrato_activo);
												
											$.ajax({
												/*xhr: function()
												{
													
													var xhr = new window.XMLHttpRequest();
													xhr.upload.addEventListener("progress", function(evt){
														if (evt.lengthComputable) {
															var percentComplete = parseInt(100.0 * evt.loaded / evt.total, 10);
															if ($("#anexo_planilla").val() != "")
																updateProgress(Math.round(percentComplete),"#form-informe-pago #progressbar");
														}
													}, false);
													return xhr;
													
												},	*/											
												url: url_controller+'uploadedDocument',
												method: 'post',
												data: datos,
												processData: false,
												contentType: false
											});

											if ($('#input-finalizado-1').is(":checked")) {
												var contratista = 10;
												abrirModalCodigo(formularioJson["input-identificacion"],id_informe_activo, contratista,$('#input-finalizado-1').is(":checked"), true, 0);
												var contenido = "El informe de pago del contratista "+$("#form-informe-pago #input-nombres-apellidos").val()+" para el periodo "+$("#form-informe-pago #input-periodo-inicio").val()+" - "+
												$("#form-informe-pago #input-periodo-fin").val()+" ha sido diligenciado y se encuentra disponible para su revisión";
												var notificacion = {
													VC_Url:"SeguimientoContratistas/Informe_Pago.php",
													VC_Icon:"fa fa-list-alt",
													VC_Contenido:contenido,
													userId:informeSelectedData["FK_Persona_Apoyo_Supervisor"],
												}
												window.parent.sendNotificationUser(notificacion);
												notificacion = {
													VC_Url:"SeguimientoContratistas/Informe_Pago.php",
													VC_Icon:"fa fa-list-alt",
													VC_Contenido:contenido,
													userId:informeSelectedData["FK_Aprobacion_Administrativo"],
												}
												window.parent.sendNotificationUser(notificacion);
												notificacion = {
													VC_Url:"SeguimientoContratistas/Informe_Pago.php",
													VC_Icon:"fa fa-list-alt",
													VC_Contenido:contenido,
													userId:informeSelectedData["FK_Persona_Apoyo_Supervisor_Dos"],
												}
												window.parent.sendNotificationUser(notificacion);
											}											
										}
									});
								},error: function(result){
									console.log("Error: ", result);
								}
							});

							parent.swal({
								confirmButtonColor: '#3f9a9d',
								title: 'El informe fue almacenado correctamente.',
								type: 'success',
								confirmButtonText: 'Aceptar',
								showCancelButton: false,
							}).then(() => {
								$('#listado_link').click();
							});

						}  			
						if (result == 3 || result == 4) {
							parent.swal({
								confirmButtonColor: '#3f9a9d',
								title: 'El tamaño del archivo excedió el limite del servidor.',
								html: '<small>Recuerde que el tamaño maximo de los archivos es de 50 Mb</small>',
								type: 'error',
								confirmButtonText: 'Aceptar',
								showCancelButton: false,
							});
						}
						if (result == 5) {
							parent.swal({
								confirmButtonColor: '#3f9a9d',
								html: "No se puede guardar el informe porque ya existe un informe guardado para el período seleccionado.<br><br><small>Si el periodo que seleccionó es correcto, debe trabajar sobre el informe que ya existe para dicho periodo editandolo en la pestaña <b>Ver Informes</b>. <br>Si se trata de un nuevo periodo por favor <b>ajuste las fechas de inicio y fin del periodo</b> en la parte superior.</small>",
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
		else{
			parent.mostrarAlerta("error",'Algo Salio mal!', 'Revise los campos resaltados en rojo');
			validatorInforme.focusInvalid();
		}
			
		

	});

	$(document).on('click','#solicitar_codigo',function(){
		identificacion = $(this).data('cedula');
		abrirModalCodigo(identificacion,null, null,null, false,0);	
	});

	$(document).on('click','.firmar_radicado',function(){
		informe_id = $(this).data('informe_id');
		mensaje = {'type' : 'success','title' : 'Bien hecho!', 'message': ''}
		parent.mostrarCargando();
		firmarRadicado(informe_id,mensaje);		
	});	

	

	$(document).on('click','.resolicitar_codigo',function(){
		identificacion = $(this).data('cedula');
		informeSelected = $(this).data('informe_id');
		identificador = $(this).data('transaccion');
		esInformeRadicado = $(this).data('radicado'); 
		$('#aceptar_codigo').data('firma_orfeo',0);
		//$("#aprobadofinal").val($(this).data('ultima_firma'));				
		abrirModalCodigo(identificacion,informeSelected, identificador,true, true, esInformeRadicado);	
	});	

	$(document).on('click','.reiniciar_aprobaciones',function(){
		informeSelected = $(this).data('informe_id');
		var data = {
			'p1': informeSelected
		};
		$.ajax({
			url: url_controller+"reiniciarAprobaciones",
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(data){
				refreshListado2()
				.then((result)=>{
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: data.title,
						html: data.message,
						type: data.type,
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					});   
					$("#modal-datos-orfeo").modal('hide');  
				});			
			},error: function(result){
				parent.swal({
					confirmButtonColor: '#3f9a9d',
					title: 'Algo salió mal!',
					html: '<small>No fue posible devolver los estados de aprobación</small>',
					type: 'error',
					confirmButtonText: 'Aceptar',
					showCancelButton: false,
				});
			}
		});	

	});	
	
	$(document).on('click','.ver_datos_orfeo',function(){
		parent.mostrarCargando();
		informeSelected = $(this).data('informe_id');
		radicado = $(this).data('radicado');
		radicadoVerificacion = $(this).data('radicado_verificacion');
		var data = {
			'p1': informeSelected,
			'p2': radicado,
			'p3': radicadoVerificacion,
		};
		$.ajax({
			url: url_controller+"verDatosOrfeo",
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(data){
				$("#contenedor-datos-orfeo").html(data.html);
				$("#modal-datos-orfeo").modal("show");
				parent.cerrarCargando();
			},error: function(result){
				parent.swal({
					confirmButtonColor: '#3f9a9d',
					title: 'Algo salió mal!',
					html: '<small>No fue posible ver los datos de ORFEO</small>',
					type: 'error',
					confirmButtonText: 'Aceptar',
					showCancelButton: false,
				});
			}
		});	

	});		
	

	

	

var selectedData = {};
var usuariosObservacionJson;
var informeSelected = 0;
var dataObservaciones = {};
$('#table-listado-informes').delegate('.revisar_informe', 'click', function(event) {
	selectedData = {};
	dataObservaciones = {};
	nContrato = "";
	$("#submit-revisar-informe").data('firma',$(this).data('firma'));
	$("#input-obsGenerales").val('');
	//$("#aprobadofinal").val($(this).data("aprobadofinal"));
	$('#contenedor-revisar-informe').html($('#form-informe-pago-container').clone());
	$("#contenedor-revisar-informe .obligacion").remove();
	$('#contenedor-revisar-informe #div_anexo_planilla').html('');
	$('#contenedor-revisar-informe #div_progressbar_planilla').html('');
	$('#contenedor-revisar-informe #form-bt-orfeo').html('');

	informeSelected = $(this).data('informe_id');
	numerRow = 0;
	var datos = { 
		'p1' : informeSelected
	};

	$.ajax({
		url: url_controller+"getInformePago",
		type: 'POST',
		dataType: 'json',
		data: datos,
		success: function(result){

			informeSelectedData = result;
			$(".datepicker-class").datepicker({
				format: 'dd/mm/yyyy',
				weekStart: 1,
				language: 'es',
				autoclose: true,
			});

			nContrato = result["input-numero-contrato"];
			if (informeSelectedData["anexos-planillas"] != "") {
				arrayPlanillas = informeSelectedData["anexos-planillas"].split("///");
				$.each(arrayPlanillas, function(index, anexo) {
					sectoresUrl = anexo.split("/");
					nombre = sectoresUrl[sectoresUrl.length-1]; 
					$('#contenedor-revisar-informe #div_descarga_planilla').prepend('&nbsp&nbsp<a href="'+anexo+'" style="margin-top: 6px;" target="_blank" title="Descargar Archivo"  class="btn btn-info download" data-placement="left" data-toggle="tooltip"><span>'+nombre+'</span></a>');
				});
			}
			var datos = {
				'p1' : informeSelected,
				'p2' : 'V' //C: Creacion, E: Edicion, V: Visualizacion
			}; 				
			$.ajax({
				url: url_controller+"getInformePagoAnexos",
				type: 'POST',
				dataType: 'json',
				data: datos,
				success: function(data){ 
					$("#form-revisar-informe #contenedor-form-grid").html(data.html);
					$("#form-revisar-informe .archivo").filestyle({btnClass: "btn-primary",buttonBefore: "true", text: "Abrir"});
				},
				error: function(data){
					console.log("Error: "+data);
				}
			});	

			if (result["observacion"] != undefined && result["observacion"] != "" && result["observacion"] != null && JSON.parse(result["observacion"]) != "" ) {
				selectedData = JSON.parse(result["observacion"]);
				var usuariosObservacionJsonTemp = JSON.parse(result["usuarios_observaciones_json"]);
				usuariosObservacionJson = [];
				$.each(usuariosObservacionJsonTemp, function(index, usuarioOserv) {
					usuariosObservacionJson[usuarioOserv.PK_Id_Persona] = usuarioOserv.nombre;
				});
			}
			$.each(result, function(key, value) {
				if (selectedData != undefined && selectedData != null && selectedData[key+"-observacion"] != undefined && selectedData[key+"-observacion"] != null) {
					$('#contenedor-revisar-informe #'+key).css({ "background-color": "#ffff4e" });
				}
				if (!key.includes("span")){
					if (key.includes("fecha") && key != 'input-fecha-inicio' && key != 'input-fecha-fin' && key != 'input-fecha-plazo-fin')
						$('#contenedor-revisar-informe #'+key).datepicker("setDate", value);
					else{ 
						if (key.includes("valor") || key.includes("giros") || key.includes("saldo")){
							$('#contenedor-revisar-informe #'+key).val(value != "" && value != null ? value : 0);
						}
						else{
							$('#contenedor-revisar-informe #'+key).val(value);
							if (key.includes("input-numero-obligaciones"))
								changeObligaciones($('#contenedor-revisar-informe #input-numero-obligaciones'));
						}
					}
				}
				else{
					key = key.replace("span-","");
					$('#contenedor-revisar-informe #'+key).text(value);
				}

				$(".rp-contenido").keyup();
			});
			$("#contenedor-revisar-informe input").datepicker("remove");


			refreshGeneral("#contenedor-revisar-informe");
			$("#contenedor-revisar-informe select").each(function(index, elemento) {
				elemento.parentElement.innerHTML = '<input  style="width: 100%; height: 100%;" id="'+$(elemento).attr("id")+'" readonly type="text" value="'+$(elemento).find(":selected").text()+'"></input>';
			});
			$("#contenedor-revisar-informe input,#contenedor-revisar-informe textarea,#contenedor-revisar-informe select").addClass('revision');
			$("#contenedor-revisar-informe input,#contenedor-revisar-informe textarea,#contenedor-revisar-informe select").attr('readonly', 'readonly');
			$('.revision').on('click', function (e) {	
				e.preventDefault();		
				$(this).popover("hide");
				let id = $(this).attr('id');
				var historico = "";
				let contenido = "";
				if (selectedData != null && selectedData != "" && selectedData != "null" && selectedData != undefined) {
					$.each(selectedData[id+"-observacion"], function(index, observacionContent) {
						if (selectedData[id+"-observacion"].length-1 != index || selectedData[id+"-observacion"][selectedData[id+"-observacion"].length-1].usuario != $('#id-usuario').val())
							historico  += "<b>"+usuariosObservacionJson[observacionContent.usuario] + ":</b> " + observacionContent.contenido + "<br>";
					});
					if (selectedData[id+"-observacion"] != undefined && selectedData[id+"-observacion"] != "" && selectedData[id+"-observacion"] != null ) 
						$("#"+id+"-observacion").val(selectedData[id+"-observacion"][selectedData[id+"-observacion"].length-1].contenido);

					if (selectedData[id+"-observacion"] != undefined && selectedData[id+"-observacion"].length != 0 && selectedData[id+"-observacion"][selectedData[id+"-observacion"].length-1].usuario == $('#id-usuario').val()) {
						contenido = selectedData[id+"-observacion"][selectedData[id+"-observacion"].length-1].contenido;
					}
				}
				else{
					selectedData = {};
				}
				var popOverSettings = {
					placement: 'top',
					html: true,
					trigger: 'manual',
					content: function () {
						return `<b>Observaciones</b> <div id="`+$(this).attr('id')+`-historico">`+historico+`</div>
						<textarea row="2"  maxlength="200" style="resize:vertical;" 
						class="form-control observacion" id="`+$(this).attr('id')+`-observacion" type="text" name="`+$(this).attr('name')+`-observacion" >`+contenido+`</textarea>`;
					}
				}

				$('.revision').popover('hide');
				$(this).popover("destroy"); 
				self = this;
				setTimeout(function () {
					$(self).popover(popOverSettings);
					$(self).popover("show");
					/*$(".popover").each((index,element)=>{
						if (parseFloat($(element).css("top")) < 0)
							$(element).css("top","20px")
						if (parseFloat($(element).css("left")) < 0)
							$(element).css("left","20px")
               			// calcular el desborde por la derecha
               			contenedor = $(element).closest(".modal").attr("id");
               			var limiteLeft = $("#"+contenedor).outerWidth() + $("#"+contenedor).offset().left;
               			var posicionLeft = $("#"+contenedor).offset().left + parseFloat($(element).css("left")) + parseFloat($(element).css("width"));

               			if(limiteLeft < posicionLeft){
               				var  valor = parseFloat($(element).css("left")) - (posicionLeft - limiteLeft + 20);
               				$(element).css("left",valor+"px");
               			}

               		});*/
               	}, 200);

			});

			$('#modal-revisar-informe').modal("show");
			$('#modal-revisar-informe #h4-modal-informe-title').text('Informe de Pago '+nContrato);

			var ObservacionesGenerales = JSON.parse(result["observaciones-generales"]);
			var contador = 1;
			var idUser = $("#id-usuario").val();
			
			$('#observaciones-generales > tbody').empty();
			//console.log(ObservacionesGenerales.observacion);
			$.each(ObservacionesGenerales.observacion, function(index, observacion) {
				//console.log(index);
				var tabla_arm = '<tr>'+
				'<td>' + contador + '</td>'+
				'<td>' + (observacion.nombre_usuario === undefined ? '<k>Eliminado</k>' :observacion.nombre_usuario) + '</td>'+
				'<td>' + (observacion.contenido === undefined ? '<k>Eliminado</k>' :observacion.contenido) + '</td>'+
				'<td>' + (observacion.fecha === undefined ? '<k>Eliminado</k>' :observacion.fecha)+ '</td>';
				if(observacion.usuario === idUser){ 
					tabla_arm +='<td><a href="#" data-id='+index+' class="btn btn-danger eliminar"><i class="fa fa-trash"></i></a></td>';
				}
				'</tr>'
				contador++;
				if(!(observacion.contenido === undefined)){
					$("#observaciones-generales").append(tabla_arm);
				}
				
			});

		},error: function(result){
			console.log("Error: "+result);
		}
	});

$(document).on('click','.eliminar',function(e){ 
	e.preventDefault();
	var tr = $(this).closest("tr");
	tr.remove();
	var posicion = $(this).data('id');
	var datos = {
		'p1' : posicion,
		'p2' : informeSelected
	};
	$.ajax({
		url: url_controller+"deleteObservacionGen",
		type: 'POST',
		dataType: 'json',
		data: datos,
		success: function(result){    
			console.log(result);
		}
	});
});
		//

		$("#contenedor-revisar-informe").delegate('.observacion', 'change', function(event) {
			if ($(this).val() != ""){
				$("#contenedor-revisar-informe #"+$(this).attr("id").replace("-observacion","")).css({ "background-color": "#ffff4e" });
				if (selectedData[$(this).attr('id')]  == undefined){
					selectedData[$(this).attr('id')] = [];
				}
				if (selectedData[$(this).attr('id')].length == 0 || selectedData[$(this).attr('id')][selectedData[$(this).attr('id')].length-1].usuario != $('#id-usuario').val()) {
					selectedData[$(this).attr('id')].push({
						usuario:$('#id-usuario').val(),
						"contenido":$(this).val()
					});
				}
				else{
					selectedData[$(this).attr('id')][selectedData[$(this).attr('id')].length-1].contenido = $(this).val();
				}
			}
			else{
				$("#contenedor-revisar-informe #"+$(this).attr("id").replace("-observacion","")).css({ "background-color": "white" });
				selectedData[$(this).attr('id')].splice(selectedData[$(this).attr('id')].length-1,1);
			}
			
			//console.log(selectedData);
		});
	});


	function inArray(needle, haystack) {
		var length = haystack.length;
		for(var i = 0; i < length; i++) {
			if(haystack[i] == needle) return true;
		}
		return false;
	}
	//
	$('#table-listado-informes').delegate('.visualizar_informe', 'click', function(event) {
		selectedData = {};
		nContrato = "";
		$('#contenedor-visualizar-informe').html($('#form-informe-pago-container').clone());
		$("#contenedor-visualizar-informe .obligacion").remove();
		$('#contenedor-visualizar-informe #div_anexo_planilla').html('');
		$('#contenedor-visualizar-informe #div_progressbar_planilla').html('');
		informeSelected = $(this).data('informe_id');
		numerRow = 0;
		var datos = {
			'p1' : informeSelected
		};

		$.ajax({
			url: url_controller+"getInformePago",
			type: 'POST',
			dataType: 'json',
			data: datos,
			success: function(result){
				informeSelectedData = result;
				$(".datepicker-class").datepicker({
					format: 'dd/mm/yyyy',
					weekStart: 1,
					language: 'es',
					autoclose: true,
				});
				if (informeSelectedData["anexos-planillas"] != "") {
					arrayPlanillas = informeSelectedData["anexos-planillas"].split("///");
					$.each(arrayPlanillas, function(index, anexo) {
						sectoresUrl = anexo.split("/");
						nombre = sectoresUrl[sectoresUrl.length-1]; 
						$('#contenedor-visualizar-informe #div_descarga_planilla').prepend('&nbsp&nbsp<a href="'+anexo+'" style="margin-top: 6px;" target="_blank" title="Descargar Archivo"  class="btn btn-info download" data-placement="left" data-toggle="tooltip"><span>'+nombre+'</span></a>');
					});
				}
				nContrato = result["input-numero-contrato"];
				if (result["observacion"] != undefined && result["observacion"] != "" && result["observacion"] != null && JSON.parse(result["observacion"]) != "" ) {
					selectedData = JSON.parse(result["observacion"]);
					var usuariosObservacionJsonTemp = JSON.parse(result["usuarios_observaciones_json"]);
					usuariosObservacionJson = [];
					$.each(usuariosObservacionJsonTemp, function(index, usuarioOserv) {
						usuariosObservacionJson[usuarioOserv.PK_Id_Persona] = usuarioOserv.nombre;
					});
				}
				$.each(result, function(key, value) {
					if (!key.includes("span")){
						if (key.includes("fecha") && key != 'input-fecha-inicio' && key != 'input-fecha-fin' && key != 'input-fecha-plazo-fin')
							$('#contenedor-visualizar-informe #'+key).datepicker("setDate", value);
						else{
							if (key.includes("valor") || key.includes("giros") || key.includes("saldo")){
								$('#contenedor-visualizar-informe #'+key).val(value != "" && value != null ? value : 0);
							}
							else{
								$('#contenedor-visualizar-informe #'+key).val(value);
								if (key.includes("input-numero-obligaciones"))
									changeObligaciones($('#contenedor-visualizar-informe #input-numero-obligaciones'));
							}
						}
					}
					else{
						key = key.replace("span-","");
						$('#contenedor-visualizar-informe #'+key).text(value);
					}

					$(".rp-contenido").keyup();
				});
				$("#contenedor-visualizar-informe input").datepicker("remove");
				refreshGeneral("#contenedor-visualizar-informe");
				$("#contenedor-visualizar-informe select").each(function(index, elemento) {
					elemento.parentElement.innerHTML = '<input  style="width: 100%; height: 100%;" readonly type="text" value="'+$(elemento).find(":selected").text()+'"></input>';
				});
				$("#contenedor-visualizar-informe input,#contenedor-visualizar-informe textarea,#contenedor-visualizar-informe select").addClass('visualizacion');
				$("#contenedor-visualizar-informe input,#contenedor-visualizar-informe textarea,#contenedor-visualizar-informe select").attr('readonly', 'readonly');				
				$('#modal-visualizar-informe').modal("show");
				$('#modal-visualizar-informe #h4-modal-informe-title').text('Informe de Pago '+nContrato);
				var datos = {
					'p1' : informeSelected,
					'p2' : 'V' //C: Creacion, E: Edicion, V: Visualizacion
				}; 				
				$.ajax({
					url: url_controller+"getInformePagoAnexos",
					type: 'POST',
					dataType: 'json',
					data: datos,
					success: function(data){
						$("#contenedor-visualizar-informe #contenedor-form-grid").html(data.html);
						$(".archivo").filestyle({btnClass: "btn-primary",buttonBefore: "true", text: "Anexo Orfeo"});
					},
					error: function(data){
						console.log("Error: "+data);
					}
				});				
			},error: function(result){
				console.log("Error: "+result);
			}
		});
	});

	//Aprobación del Supervisor
	$('#table-listado-informes').delegate('.aprobacion_supervisor', 'click', function(event) {
		informeSelected = $(this).data('informe_id');
		personaInformeId = $(this).data('persona_id');
		periodo = $(this).data('periodo_informe');
		
		var datos = {
			'p1' : informeSelected
		};
		var mensaje = '<small>¿Está seguro que desea aprobar el informe?</small>';
		parent.swal({
			confirmButtonColor: '#3f9a9d',
			title: 'Aprobar Informe',
			html: mensaje,
			type: 'warning',
			confirmButtonText: 'Sí',
			cancelButtonText: 'No',
			showCancelButton: true,
		}).then(() => {
			informeSelected = $(this).data('informe_id');
			
			var datos = {
				'p1' : informeSelected,
				'p2' : 1
			};

			$.ajax({
				url: url_controller+"updateRevisionSupervisor",
				type: 'POST',
				dataType: 'json',
				data: datos,
				success: function(result){
					if (result == 1) {
						parent.swal({
							confirmButtonColor: '#3f9a9d',
							title: 'El informe fue aprobado.',
							type: 'success',
							confirmButtonText: 'Aceptar',
							showCancelButton: false,
						});
						refreshListado();
						var contenido = "Tu informe de pago del periodo "+periodo+" ha sido aprobado por el supervisor del contrato.";
						var notificacion = {
							VC_Url:"SeguimientoContratistas/Informe_Pago.php",
							VC_Icon:"fa fa-list-alt",
							VC_Contenido:contenido,
							userId:personaInformeId
						}
						window.parent.sendNotificationUser(notificacion);
					}
					else{
						parent.swal({
							confirmButtonColor: '#3f9a9d',
							title: 'Algo salió mal.<br>El informe no pudo ser aprobado.',
							type: 'error',
							confirmButtonText: 'Aceptar',
							showCancelButton: false,
						});
					}
				},error: function(result){
					error(console.log(result));
					swal({
						confirmButtonColor: '#3f9a9d',
						title: 'Ha ocurrido un error inesperado.',
						html: '<small>Por favor intente nuevamente, si el problema persiste contacte el servicio de soporte.</small>',
						type: 'error',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					});
				}
			});
		}).catch(parent.swal.noop);

	});
	//
	$( "a" ).delegate( ".download", "click", function(e) {
		e.preventDefault();
		window.open($(this).attr("href"), '_blank');
	});

	$('#table-listado-informes').delegate('.revisar_informe_detallado', 'click', function(event) {
		selectedData = {};
		nContrato = "";
		$('#form-revisar-informe-detallado #input-informe-territorial').prop("checked",false);
		if ($('#form-revisar-informe-detallado #input-informe-territorial').is(":checked")){
			$("#form-revisar-informe-detallado #label-state-informe-territorial").text("SI");
			$("#form-revisar-informe-detallado .administrativo").hide();
			$("#form-revisar-informe-detallado .operativo").hide();
			$("#form-revisar-informe-detallado .coordinador").show();
			$("#form-revisar-informe-detallado #label-state-informe-territorial").show();
			$("#form-revisar-informe-detallado #radio-tipo-territorial").show();
		}
		else{
			$("#form-revisar-informe-detallado #label-state-informe-territorial").text("NO");
			$("#form-revisar-informe-detallado .administrativo").hide();
			$("#form-revisar-informe-detallado .operativo").hide();
			$("#form-revisar-informe-detallado .coordinador").hide();
			$("#form-revisar-informe-detallado #label-state-informe-territorial").show();
			$("#form-revisar-informe-detallado #radio-tipo-territorial").hide();
		}
		$('#form-revisar-informe-detallado #input-informe-territorial').change();
		$('#contenedor-revisar-informe-detallado').html($('#form-informe-detallado-container').clone());
		$("#contenedor-revisar-informe-detallado .obligacion").remove();
		informeSelected = $(this).data('informe_id');
		numerRow = 0;
		var datos = {
			'p1' : informeSelected
		};
		$.ajax({
			url: url_controller+"getInformePago",
			type: 'POST',
			dataType: 'json',
			data: datos,
			success: function(result){

				informeSelectedData = result;
				nContrato = result["input-numero-contrato"];
				$(".datepicker-class").datepicker({
					format: 'dd/mm/yyyy',
					weekStart: 1,
					language: 'es',
					autoclose: true,
				});

				$.each(result, function(key, value) {
					if (key.includes("input-numero-obligaciones"))
						changeObligacionesDetallado($('#contenedor-revisar-informe-detallado #tr-producto'),value,0);
					if (key.includes("span"))
						key = key.replace("span-","");
					if ($('#form-informe-detallado-container #'+key).is("span"))
						$('#form-informe-detallado-container #'+key).text(value);
					else
						$('#form-informe-detallado-container #'+key).val(value);
					$(".rp-contenido").keyup();
				});
				datosDev = {
					'p1' : informeSelected
				};
				$.ajax({
					url: url_controller+"getInformeDetallado",
					type: 'POST',
					dataType: 'json',
					data: datosDev,
					success: function(result){
						if (result["tipo-territorial"] != 0 && result["tipo-territorial"] != null && result["tipo-territorial"] != undefined) {
							$('#form-revisar-informe-detallado #input-informe-territorial').prop("checked",true);
							$('#form-revisar-informe-detallado #input-informe-territorial').change();
							if ($('#form-revisar-informe-detallado #input-informe-territorial').is(":checked")){
								$("#form-revisar-informe-detallado #label-state-informe-territorial").text("SI");
								$("#form-revisar-informe-detallado .administrativo").hide();
								$("#form-revisar-informe-detallado .operativo").hide();
								$("#form-revisar-informe-detallado .coordinador").show();
								$("#form-revisar-informe-detallado #label-state-informe-territorial").show();
								$("#form-revisar-informe-detallado #radio-tipo-territorial").show();
							}
							else{
								$("#form-revisar-informe-detallado #label-state-informe-territorial").text("NO");
								$("#form-revisar-informe-detallado .administrativo").hide();
								$("#form-revisar-informe-detallado .operativo").hide();
								$("#form-revisar-informe-detallado .coordinador").hide();
								$("#form-revisar-informe-detallado #label-state-informe-territorial").show();
								$("#form-revisar-informe-detallado #radio-tipo-territorial").hide();
							}
							$('#form-revisar-informe-detallado input[name="tipo-territorial"][value="' + result["tipo-territorial"] + '"]').prop('checked', true);
							changeTipoTerritorial2();
						}
						else{
							$('#form-revisar-informe-detallado #input-informe-territorial').prop("checked",false);
						}
						
						$('#form-revisar-informe-detallado #input-numero-contrato').text(result["input-numero-contrato"]);
						if (result["observacion"] != undefined && result["observacion"] != "" && result["observacion"] != "null" && result["observacion"] != null && JSON.parse(result["observacion"]) != "" ) {
							selectedData = JSON.parse(result["observacion"]);
							var usuariosObservacionJsonTemp = JSON.parse(result["observacion"]);
							usuariosObservacionJson = [];
							$.each(usuariosObservacionJsonTemp, function(index, usuarioOserv) {
								usuariosObservacionJson[usuarioOserv.PK_Id_Persona] = usuarioOserv.nombre;
							});

						}
						$.each(result, function(key, value) {
							if (selectedData != undefined && selectedData != null && selectedData[key+"-observacion"] != undefined && selectedData[key+"-observacion"] != null) {
								$('#contenedor-revisar-informe-detallado #'+key).css({ "background-color": "#ffff4e" });
							}
							if ($('#form-revisar-informe-detallado #'+key).hasClass('summernote')) {
								//$('#contenedor-revisar-informe-detallado').parent().parent().prepend(value);
								/*$('#form-revisar-informe-detallado #'+key).summernote("code", value);
								$('#form-revisar-informe-detallado #'+key).summernote('disable',true);*/
								if (value == "")
									value = "<br><br>";
								$('#form-revisar-informe-detallado #'+key).addClass('revision');
								$('#form-revisar-informe-detallado #'+key).html(value);
							}else{
								$('#form-revisar-informe-detallado #'+key).val(value);
							}
						});
						if (result["input-url-anexo"] != "" && result["input-url-anexo"] != undefined&& result["input-url-anexo"] != "undefined" && result["input-url-anexo"] != null) 
							$("#contenedor-revisar-informe-detallado #anexo_archivo").parent().parent().html('<div class="col-md-4 col-lg-4"><a href="'+result["input-url-anexo"]+'"  target="_blank" title="Descargar Documento"  class="btn btn-warning download" data-placement="left" data-toggle="tooltip"><span>Descargar Archivo</span></a></div>');
						else
							$("#contenedor-revisar-informe-detallado #anexo_archivo").parent().parent().html('<div class="col-md-4 col-lg-4"><a href="'+result["input-url-anexo"]+'"  target="_blank" title="Descargar Documento"  class="btn btn-warning download disabled" disabled data-placement="left" data-toggle="tooltip"><span>Sin Archivo</span></a></div>');

						
						$("#contenedor-revisar-informe-detallado input,#contenedor-revisar-informe-detallado textarea,#contenedor-revisar-informe-detallado select").addClass('revision');
						$("#contenedor-revisar-informe-detallado input,#contenedor-revisar-informe-detallado textarea,#contenedor-revisar-informe-detallado select").attr('readonly', 'readonly');

						$(".revision").each(function(index, val) {
							$(val).popover({content: 'Observación <textarea row="2" style="resize:vertical;"  maxlength="200" class="form-control observacion" id="'+$(this).attr('id')+'-observacion" type="text" name="'+$(this).attr('name')+'-observacion" ></textarea>',placement:"top",trigger: 'click',html: true});
						});
						$("#contenedor-revisar-informe-detallado").delegate('.revision', 'click', function(event) {
							$('.revision').not(this).popover('hide');
							let id = $(this).attr('id');
							$("#contenedor-revisar-informe-detallado #"+id).popover('toggle');
							$("#"+id+"-observacion").val(selectedData[id+"-observacion"]);
						});
					},error: function(result){
						console.log("Error: "+result);
					}
				});

				/*$('.revision').on('click', function (e) {			
					$('.revision').not(this).popover('hide');
					let id = $(this).attr('id');
					$("#contenedor-revisar-informe-detallado #"+id).popover('toggle');
					$("#"+id+"-observacion").val(selectedData[id+"-observacion"]);
				});*/
				$('#modal-revisar-informe-detallado').modal("show");
				$('#modal-revisar-informe-detallado #h4-modal-informe-detallado-title').text('Informe de Pago '+nContrato);
			},error: function(result){
				console.log("Error: "+result);
			}
		});
		//
		$("#contenedor-revisar-informe-detallado").delegate('.observacion', 'change', function(event) {
			if ($(this).val() != "")
				$("#contenedor-revisar-informe-detallado #"+$(this).attr("id").replace("-observacion","")).css({ "background-color": "#ffff4e" });
			else
				$("#contenedor-revisar-informe-detallado #"+$(this).attr("id").replace("-observacion","")).css({ "background-color": "white" });
			selectedData[$(this).attr('id')] = $(this).val();
		});
		//
	});
$('#table-listado-informes').delegate('.visualizar_informe_detallado', 'click', function(event) {
	selectedData = {};
	nContrato = "";
	$('#form-visualizar-informe-detallado #input-informe-territorial').prop("checked",false);
	if ($('#form-visualizar-informe-detallado #input-informe-territorial').is(":checked")){
		$("#form-visualizar-informe-detallado #label-state-informe-territorial").text("SI");
		$("#form-visualizar-informe-detallado .administrativo").hide();
		$("#form-visualizar-informe-detallado .operativo").hide();
		$("#form-visualizar-informe-detallado .coordinador").show();
		$("#form-visualizar-informe-detallado #label-state-informe-territorial").show();
		$("#form-visualizar-informe-detallado #radio-tipo-territorial").show();
	}
	else{
		$("#form-visualizar-informe-detallado #label-state-informe-territorial").text("NO");
		$("#form-visualizar-informe-detallado .administrativo").hide();
		$("#form-visualizar-informe-detallado .operativo").hide();
		$("#form-visualizar-informe-detallado .coordinador").hide();
		$("#form-visualizar-informe-detallado #label-state-informe-territorial").show();
		$("#form-visualizar-informe-detallado #radio-tipo-territorial").hide();
	}
	$('#form-visualizar-informe-detallado #input-informe-territorial').change();
	$('#contenedor-visualizar-informe-detallado').html($('#form-informe-detallado-container').clone());
	$("#contenedor-visualizar-informe-detallado .obligacion").remove();
	informeSelected = $(this).data('informe_id');
	numerRow = 0;
	var datos = {
		'p1' : informeSelected
	};
	$.ajax({
		url: url_controller+"getInformePago",
		type: 'POST',
		dataType: 'json',
		data: datos,
		success: function(result){

			informeSelectedData = result;
			nContrato = result["input-numero-contrato"];
			$(".datepicker-class").datepicker({
				format: 'dd/mm/yyyy',
				weekStart: 1,
				language: 'es',
				autoclose: true,
			});

			$.each(result, function(key, value) {
				if (key.includes("input-numero-obligaciones"))
					changeObligacionesDetallado($('#contenedor-visualizar-informe-detallado #tr-producto'),value,0);
				if (key.includes("span"))
					key = key.replace("span-","");
				if ($('#form-informe-detallado-container #'+key).is("span"))
					$('#form-informe-detallado-container #'+key).text(value);
				else
					$('#form-informe-detallado-container #'+key).val(value);
				$(".rp-contenido").keyup();
			});
			datosDev = {
				'p1' : informeSelected
			};
			$.ajax({
				url: url_controller+"getInformeDetallado",
				type: 'POST',
				dataType: 'json',
				data: datosDev,
				success: function(result){
					$('#form-visualizar-informe-detallado #input-numero-contrato').text(result["input-numero-contrato"]);						
					$.each(result, function(key, value) {

						if ($('#form-visualizar-informe-detallado #'+key).hasClass('summernote')) {
								//$('#contenedor-visualizar-informe-detallado').parent().parent().prepend(value);
								/*$('#form-visualizar-informe-detallado #'+key).summernote("code", value);
								$('#form-visualizar-informe-detallado #'+key).summernote('disable',true);*/
								if (value == "")
									value = "<br><br>";
								$('#form-visualizar-informe-detallado #'+key).addClass('revision');
								$('#form-visualizar-informe-detallado #'+key).html(value);
							}else{
								$('#form-visualizar-informe-detallado #'+key).val(value);
							}
						});
					if (result["input-url-anexo"] != "" && result["input-url-anexo"] != undefined&& result["input-url-anexo"] != "undefined" && result["input-url-anexo"] != null) 
						$("#contenedor-visualizar-informe-detallado #anexo_archivo").parent().parent().html('<div class="col-md-4 col-lg-4"><a href="'+result["input-url-anexo"]+'"  target="_blank" title="Descargar Documento"  class="btn btn-warning download" data-placement="left" data-toggle="tooltip"><span>Descargar Archivo</span></a></div>');
					else
						$("#contenedor-visualizar-informe-detallado #anexo_archivo").parent().parent().html('<div class="col-md-4 col-lg-4"><a href="'+result["input-url-anexo"]+'"  target="_blank" title="Descargar Documento"  class="btn btn-warning download disabled" disabled data-placement="left" data-toggle="tooltip"><span>Sin Archivo</span></a></div>');


					$("#contenedor-visualizar-informe-detallado input,#contenedor-visualizar-informe-detallado textarea,#contenedor-visualizar-informe-detallado select").attr('readonly', 'readonly');
				},error: function(result){
					console.log("Error: "+result);
				}
			});

				/*$('.revision').on('click', function (e) {			
					$('.revision').not(this).popover('hide');
					let id = $(this).attr('id');
					$("#contenedor-visualizar-informe-detallado #"+id).popover('toggle');
					$("#"+id+"-observacion").val(selectedData[id+"-observacion"]);
				});*/
				$('#modal-visualizar-informe-detallado').modal("show");
				$('#modal-visualizar-informe-detallado #h4-modal-informe-detallado-title').text('Informe de Pago '+nContrato);
			},error: function(result){
				console.log("Error: "+result);
			}
		});
		//
		$("#contenedor-revisar-informe-detallado").delegate('.observacion', 'change', function(event) {
			if ($(this).val() != "")
				$("#contenedor-revisar-informe-detallado #"+$(this).attr("id").replace("-observacion","")).css({ "background-color": "#ffff4e" });
			else
				$("#contenedor-revisar-informe-detallado #"+$(this).attr("id").replace("-observacion","")).css({ "background-color": "white" });
			selectedData[$(this).attr('id')] = $(this).val();
		});
		//
	});
	//
	$('#table-listado-informes').delegate('.editar_informe', 'click', function(event) {
		nContrato = "";
		
		$('#contenedor-editar-informe').html($('#form-informe-pago-container').clone());

		$("#form-editar-informe #select-convenio-a").attr('disabled', true);
		$("#form-editar-informe #select-convenio-b").attr('disabled', true);
		$("#form-editar-informe #select-convenio-c").attr('disabled', true);
		$("#form-editar-informe #select-convenio-d").attr('disabled', true);
		$("#form-editar-informe #select-codigo-a").attr('disabled', true);
		$("#form-editar-informe #select-codigo-b").attr('disabled', true);
		$("#form-editar-informe #select-codigo-c").attr('disabled', true);
		$("#form-editar-informe #select-codigo-d").attr('disabled', true);
		
		$("#contenedor-editar-informe .obligacion").remove();
		/*
		$('#contenedor-editar-informe #div_anexo_planilla').html(
			'<input id="anexo_planilla_edit" multiple name="file[]" type="file" class="filestyle" data-btnClass="btn-danger" data-buttonBefore="true" runat="server" data-text="&nbspAnexos del Informe"><div class="alert-danger">En este espacio debe cargar los anexos del informe de pago, tenga en cuenta que el peso total no debe superar los 50mb.</div>'
		);
		$('#contenedor-editar-informe #div_anexo_planilla #anexo_planilla_edit').filestyle({btnClass: "btn-danger",buttonBefore: "true",text: "&nbspAnexos del Informe"});
		*/
		
		$('#contenedor-editar-informe #form-bt-orfeo').html(
			'<a class="btn btn-success" id="BT_editar_documento_orfeo" title="Anexos Orfeo"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Anexos Orfeo</a>'
		);
		$('#contenedor-editar-informe #contenedor-form-grid').html(
			'<div class="row" id="form-grid-editar"></div>'
		);

		$('[data-toggle="tooltip"]').tooltip();
		informeSelected = $(this).data('informe_id');
			
		numerRow = 0;
		var datos = {
			'p1' : informeSelected
		};
		$.ajax({
			url: url_controller+"getInformePago",
			type: 'POST',
			dataType: 'json',
			data: datos,
			success: function(result){
				//console.log(result);

				informeSelectedData = result;
				//console.log(informeSelectedData);
				id_contrato_activo = informeSelectedData["FK_Basico"];
				if(informeSelectedData["input-nombres-apellidos-cedente"].length > 0){
					$('#form-editar-informe #BT_agregar_documento_orfeo_cesion').data('informe',id_contrato_activo);
					$('#form-editar-informe #BT_agregar_documento_orfeo_cesion').show();
				}else{
					$('#form-editar-informe #BT_agregar_documento_orfeo_cesion').hide();
				}				
				$(".datepicker-class").datepicker({
					format: 'dd/mm/yyyy',
					weekStart: 1,
					language: 'es',
					autoclose: true,
				});
				if (informeSelectedData["anexos-planillas"] != "") {
					arrayPlanillas = informeSelectedData["anexos-planillas"].split("///");
					$.each(arrayPlanillas, function(index, anexo) {
						sectoresUrl = anexo.split("/");
						nombre = sectoresUrl[sectoresUrl.length-1]; 
						$('#contenedor-editar-informe #div_descarga_planilla').prepend('<a href="'+anexo+'" style="margin-top: 6px;" target="_blank" title="Descargar Archivo"  class="btn btn-info download" data-placement="left" data-toggle="tooltip"><span>'+nombre+'</span></a> ');
					});
				}
				nContrato = result["input-numero-contrato"];
				if (result["input-finalizado"] == 1) {
					$('#input-finalizado-2').prop('checked',true);
					$('#input-finalizado-2').change();
				}
				else{
					$('#input-finalizado-2').prop('checked',false);
					$('#input-finalizado-2').change();
				}
				observaciones = null;
				if (result["observacion"] != undefined && result["observacion"] != "" && result["observacion"] != null && JSON.parse(result["observacion"]) != "" ) {
					observaciones = JSON.parse(result["observacion"]);
					var usuariosObservacionJsonTemp = JSON.parse(result["usuarios_observaciones_json"]);
					usuariosObservacionJson = [];
					$.each(usuariosObservacionJsonTemp, function(index, usuarioOserv) {
						usuariosObservacionJson[usuarioOserv.PK_Id_Persona] = usuarioOserv.nombre;
					});
				}
				$.each(result, function(key, value) {

					if (observaciones != undefined && observaciones != null && observaciones != "" && observaciones[key+"-observacion"] != undefined && observaciones[key+"-observacion"] != null && observaciones[key+"-observacion"] != "") {
						$('#contenedor-editar-informe #'+key).css({ "background-color": "#ffff4e" });
						$('#contenedor-editar-informe #'+key).data('original-title', '');
					}

					if (!key.includes("span")){
						if (key.includes("fecha") && key != 'input-fecha-inicio' && key != 'input-fecha-fin' && key != 'input-fecha-plazo-fin')
							$('#contenedor-editar-informe #'+key).datepicker("setDate", value);
						else{
							if (key.includes("valor") || key.includes("giros") || key.includes("saldo")){
								$('#contenedor-editar-informe #'+key).val(value != "" && value != null ? value : 0);
							}
							else{
								$('#contenedor-editar-informe #'+key).val(value);
								if (key.includes("input-numero-obligaciones"))
									changeObligaciones($('#contenedor-editar-informe #input-numero-obligaciones'));
							}
						}
					}
					else{
						key = key.replace("span-","");
						$('#contenedor-editar-informe #'+key).text(value);
					}
					$(".rp-contenido").keyup();
				});

				$(".datepicker-class").datepicker({
					format: 'dd/mm/yyyy',
					weekStart: 1,
					language: 'es',
					autoclose: true,
				});
				var reglas = {
					'validacion-anexos': {
						validaAnexos: ".anexo_planilla",
					},  
					'input-periodo-inicio': {
						validaFechas: '#form-editar-informe #input-periodo-fin',
					}, 
				};
			
				var mensajes = {
					'validacion-anexos': {
						validaAnexos: 'Tamaño de anexos excedido, los anexos no deben pesar mas de 50Mb',
					},
					'input-periodo-inicio': {
						validaFechas: 'La fecha final debe ser mayor a la fecha inicial',
					}, 					
				};
			
				validatorInforme =  validarForm('#form-editar-informe',reglas,mensajes);

				var datos = {
					'p1' : informeSelected,
					'p2' : 'E' //C: Creacion, E: Edicion, V: Visualizacion
				}; 				
				$.ajax({
					url: url_controller+"getInformePagoAnexos",
					type: 'POST',
					dataType: 'json',
					data: datos,
					success: function(data){
						$("#contenedor-editar-informe #contenedor-form-grid").html(data.html);
						$(".archivo").filestyle({btnClass: "btn-primary",buttonBefore: "true", text: "Abrir"});
					},
					error: function(data){
						console.log("Error: "+data);
					}
				});	

				$('#modal-editar-informe').modal("show");
				$('#modal-editar-informe #h4-modal-informe-title').text('Informe de Pago '+nContrato); 
				$("#contenedor-editar-informe input,#contenedor-editar-informe textarea,#contenedor-editar-informe select").addClass('edicion');
				$('.edicion').on('click', function (e) {			
					$(this).popover("hide");
					let id = $(this).attr('id');
					var historico = "";
					if (observaciones != null) {
						$.each(observaciones[id+"-observacion"], function(index, observacionContent) {
							historico += usuariosObservacionJson[observacionContent.usuario] + ": " + observacionContent.contenido + "<br>";
						});					
						var popOverSettings = {
							placement: 'top',
							html: true,
							trigger: 'manual',
							content: function () {
								return historico;
							}
						}
						$('.edicion').popover('hide');
						$(this).popover("destroy");
						self = this;
						setTimeout(function () {
							$(self).popover(popOverSettings);
							$(self).popover("show");
						}, 200);
					}

				});
				if (informeSelectedData["input-estado"].indexOf("1") != -1 || informeSelectedData["input-estado"].indexOf("7") != -1 || informeSelectedData["input-estado"].indexOf("9") != -1) { //apoyo a la supervision o supervision.
					$("#contenedor-editar-informe .supervision").attr('readonly', 'readonly');
				}
				if (informeSelectedData["input-estado"].indexOf("2") != -1) { //financiera
					$("#contenedor-editar-informe .financiero").attr('readonly', 'readonly');
				}
				refreshGeneral("#contenedor-editar-informe");
				var ObservacionesGenerales = JSON.parse(result["observaciones-generales"]);
				var contador = 1;
				$('#observaciones-generales > tbody').empty();
			//console.log(ObservacionesGenerales.observacion);
			$.each(ObservacionesGenerales.observacion, function(index, observacion) {
				$('#observaciones-generales tbody').append('<tr>'+
					'<td>' + contador + '</td>'+
					'<td>' + observacion.nombre_usuario + '</td>'+
					'<td>' + observacion.contenido + '</td>'+
					'<td>' + observacion.fecha + '</td>'+
					'</tr>');
				contador++;
			});
		},error: function(result){
			console.log(result);
			console.log("Error: "+result);
		}
	});

$('#contenedor-editar-informe #input-numero-obligaciones').on('change', function(e){
	e.preventDefault();
	changeObligaciones(this);
});
});

$('#table-listado-informes').delegate('.descargar_informe', 'click', function(event) {
	informeSelected = $(this).data('informe_id');
	var datos = {
		'p1' : informeSelected
	};
	$.ajax({
		url: url_controller+"getInformePago",
		type: 'POST',
		dataType: 'json',
		data: datos,
		success: function(result){
			nContrato = result["input-numero-contrato"];
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: '¿Como desea descargar el documento?',
				html: '<small>Selecione el tamaño que mejor se ajuste a su informe.</small>',
				type: 'warning',
				confirmButtonText: 'Descargar en Oficio',
				cancelButtonText: 'Descargar en Carta',
				showCancelButton: true, 
				width: 800,
			}).then(() => {
				generarPDFInforme(result,'legal');
			},(confirm) => {
				if (confirm == "cancel"){
					generarPDFInforme(result,'letter');
				}
			}).catch(parent.swal.noop);

		},error: function(result){
			console.log("Error: "+result);
		}
	});
});

$('#table-listado-informes').delegate('.descargar_certificado', 'click', function(event) {
	informeSelected = $(this).data('informe_id');
	var datos = {
		'p1' : informeSelected
	};
	$.ajax({
		url: url_controller+"getInformePago",
		type: 'POST',
		dataType: 'json',
		data: datos,
		success: function(result){
			nContrato = result["input-numero-contrato"];
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: '¿Como desea descargar el documento?',
				html: '<small>Selecione el tamaño que mejor se ajusdescargarPDFCertificadote a su informe.</small>',
				type: 'warning',
				confirmButtonText: 'Descargar en Oficio',
				cancelButtonText: 'Descargar en Carta',
				showCancelButton: true, 
				width: 800,
			}).then(() => {
				descargarPDFCertificado(result,'legal');
			},(confirm) => {
				if (confirm == "cancel"){
					descargarPDFCertificado(result,'letter');
				}
			}).catch(parent.swal.noop);

		},error: function(result){
			console.log("Error: "+result);
		}
	});
});

$('#table-listado-informes').delegate('.habilitar_certificado_final', 'click', function(event) {
	personaInformeId = $(this).data('persona_id');
	let element = $(this);
	parent.swal({
		confirmButtonColor: '#3f9a9d',
		title: '¿Este es el último informe del contrato?',
		html: '<small>Si este es el <b>ÚLTIMO INFORME DEL CONTRATO</b> y desea habilitar la descarga del <b>Certificado Final</b> <br>del mismo, de click en HABILITAR, de lo contrario en CANCELAR.</small>',
		type: 'warning',
		confirmButtonText: 'HABILITAR',
		cancelButtonText: 'CANCELAR',
		showCancelButton: true,
		width: 800,
	}).then(() => {
		$.ajax({
			url: url_controller+"habilitarCertificadoFinalContrato",
			type: 'POST',
			dataType: 'html',
			data:{
				p1:personaInformeId,
				p2:$("#id-usuario").val()
			},
			success: function(result){
				if (result == "1") {
					element.removeClass('btn-warning');
					element.removeClass('habilitar_certificado_final');
					element.addClass('btn-success');
					element.addClass('descargar_certificado_final');
					element.html('Certificado Final');
					element.attr('title', 'Descargar Certificado Final').tooltip('fixTitle').tooltip('show');
					parent.mostrarAlerta('success','Certificado Habilitado','El certificado final del contrato ha sido habilitado, ahora el contratista podrá descargarlo.');
				}
			},error: function(result){
				console.log("Error: "+result);
			}
		});
	},(confirm) => {
		if (confirm == "cancel"){
			
		}
	}).catch(parent.swal.noop);
});

$('#table-listado-informes').delegate('.descargar_certificado_final', 'click', function(event) {
	informeSelected = $(this).data('informe_id');
	var datos = {
		'p1' : informeSelected
	};
	$.ajax({
		url: url_controller+"getInformePago",
		type: 'POST',
		dataType: 'json',
		data: datos,
		success: function(result){
			nContrato = result["input-numero-contrato"];
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: '¿Como desea descargar el documento?',
				html: '<small>Selecione el tamaño que mejor se ajuste a su informe.</small>',
				type: 'warning',
				confirmButtonText: 'Descargar en Oficio',
				cancelButtonText: 'Descargar en Carta',
				showCancelButton: true, 
				width: 800,
			}).then(() => {
				descargarPDFCertificadoFinal(result,'legal');
			},(confirm) => {
				if (confirm == "cancel"){
					descargarPDFCertificadoFinal(result,'letter');
				}
			}).catch(parent.swal.noop);

		},error: function(result){
			console.log("Error: "+result);
		}
	});
});

$('#table-listado-informes').delegate('.descargar_informe_detallado', 'click', function(event) {
	informeSelected = $(this).data('informe_id');
	var datos = {
		'p1' : informeSelected
	};
	$.ajax({
		url: url_controller+"getInformePago",
		type: 'POST',
		dataType: 'json',
		data: datos,
		success: function(informe){
			var datosDev = {
				'p1' : informeSelected
			};
			$.ajax({
				url: url_controller+"getInformeDetallado",
				type: 'POST',
				dataType: 'json',
				data: datosDev,
				success: function(informeDetallado){
					informe.detallado = informeDetallado;;
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: '¿Como desea descargar el documento?',
						html: '<small>Selecione el tamaño que mejor se ajuste a su informe.</small>',
						type: 'warning',
						confirmButtonText: 'Descargar en Oficio',
						cancelButtonText: 'Descargar en Carta',
						showCancelButton: true, 
						width: 800,
					}).then(() => {
						generarPDFInformeDetallado(informe,'legal');
					},(confirm) => {
						if (confirm == "cancel"){
							generarPDFInformeDetallado(informe,'letter');
						}
					}).catch(parent.swal.noop);

					
				},error: function(result){
					console.log("Error: "+result);
				}
			});
		},error: function(result){
			console.log("Error: "+result);
		}
	});

});
var contenidoOserv ="";
var estadoObserv = 0;
var ObservButton = function (context) {
	ui = $.summernote.ui;
	let textoObservacion = "";
	let classObservacion = "";
	let dataToogle = null;
	if (estadoObserv === 1 ) {
		textoObservacion = "Con Observaciones";
		classObservacion = "btn-observ";
		dataToogle = {
			toggle: 'dropdown'
		};
	}
	else{
		textoObservacion = "Sin Observaciones";
		classObservacion = "disabled";
	}
	let button = ui.buttonGroup([ui.button({
		className: 'dropdown-toggle '+classObservacion,
		contents: '<i class="fa fa-search"/> '+textoObservacion,
		tooltip: textoObservacion,
		data:dataToogle 
	}),
	ui.dropdownCheck({
		className: 'note-popup',
		items: [
		'<div>'+contenidoOserv+'</div>'
		].join('')
	})]);
	return button.render();
}


$('#table-listado-informes').delegate('.editar_informe_detallado', 'click', function(event) {
	informeSelected = $(this).data('informe_id');
	$('#input-informe-territorial').prop("checked",false);
	if ($('#input-informe-territorial').is(":checked")){
		$("#label-state-informe-territorial").text("SI");
		$(".administrativo").hide();
		$(".operativo").hide();
		$(".coordinador").show();
		$("#label-state-informe-territorial").show();
		$("#radio-tipo-territorial").show();
	}
	else{
		$("#label-state-informe-territorial").text("NO");
		$(".administrativo").hide();
		$(".operativo").hide();
		$(".coordinador").hide();
		$("#label-state-informe-territorial").show();
		$("#radio-tipo-territorial").hide();
	}
	$('#input-informe-territorial').change();
	fileSelectedInforme = "";
	var nContrato = "";
	var datosDev = {
		'p1' : informeSelected
	};
	$.ajax({
		url: url_controller+"getInformePago",
		type: 'POST',
		dataType: 'json',
		data: datosDev,
		success: function(result){
			nContrato = result["input-numero-contrato"];
			$('#form-informe-detallado-container #input-numero-contrato').text(nContrato);

			$.each(result, function(key, value) {


				if (key.includes("span"))
					key = key.replace("span-","");
				if ($('#form-informe-detallado-container #'+key).is("span"))
					$('#form-informe-detallado-container #'+key).text(value);
				else
					$('#form-informe-detallado-container #'+key).val(value);

				if (key.includes("input-numero-obligaciones"))
					changeObligacionesDetallado($('#form-informe-detallado-container #tr-producto'),value,1);

			});
			datosDev = {
				'p1' : informeSelected
			};
			$.ajax({
				url: url_controller+"getInformeDetallado",
				type: 'POST',
				dataType: 'json',
				data: datosDev,
				success: function(result){
					if (result["tipo-territorial"] != 0 && result["tipo-territorial"] != null && result["tipo-territorial"] != undefined) {
						$('#input-informe-territorial').prop("checked",true);
						$('#input-informe-territorial').change();
						$('input[name="tipo-territorial"][value="' + result["tipo-territorial"] + '"]').prop('checked', true);
						changeTipoTerritorial();
					}
					else{
						$('#input-informe-territorial').prop("checked",false);
					}
					observaciones = null;
					$('#form-informe-detallado-container #input-numero-contrato').text(result["input-numero-contrato"]);
					if (result["observacion"] != undefined && result["observacion"] != "" && result["observacion"] != null && JSON.parse(result["observacion"]) != "" ) {
						observaciones = JSON.parse(result["observacion"]);
					}
					$.each(result, function(key, value) {
						if ($('#form-informe-detallado-container #'+key).hasClass('summernote')) {
							if (observaciones != undefined && observaciones != null && observaciones != "" && observaciones[key+"-observacion"] != undefined && observaciones[key+"-observacion"] != null) {
									/*$('#form-informe-detallado-container #'+key).css({ "background-color": "#ffff4e" });
									$('#form-informe-detallado-container #'+key).tooltip({"placement":"left",'trigger':'focus', 'title':observaciones[key+"-observacion"] });*/
									contenidoOserv = observaciones[key+"-observacion"];
									estadoObserv = 1;
								}
								else{
									contenidoOserv = "";
									estadoObserv = 0;
								}
								$('#form-informe-detallado-container #'+key).summernote({
									dialogsInBody: true,
									lang: 'es-ES',
									buttons: {
										btnObserv: ObservButton
									},
									toolbar: [
									['custom', ['btnObserv']],
									['style', ['style']],
									['font', ['bold', 'underline', 'italic', 'clear']],
									['color', ['color']],
									['para', ['ul', 'ol', 'paragraph']],
									['table', ['table']],
									['insert', ['link', 'picture']],
									],
									"popover": {
										image: [],
										link: [],
										air: [
										]
									},
									callbacks: {
										onPaste: function(e) {
											input = $(this).closest("form").attr("id")+" #"+$(this).attr("id");
											setTimeout(function () {
												$.fn.removeAttributes = function() {
													return this.each(function() {
														var attributes = $.map(this.attributes, function(item) {
															return item.name;
														});
														var element = $(this);
														if(element.children().length != 0){
															element.children().removeAttributes();
														}	
														switch (element[0].nodeName.toLowerCase()) {
															case "img":{
																if($(element).attr("width") == undefined)
																	$(element).attr("width", "500px");
																if ($(element).css( "width" ) != "0px")
																	$(element).attr("width",$(element).css( "width" ));
																if($(element).css( "width" ).replace("px", "") > 500)
																	$(element).attr("width", "500px");													
																if ($(element).css( "height" ) != "0px")
																	$(element).attr("height",$(element).css( "height" ));
																element.removeAttr('style');
																break;
															}
															case "td":{
																$.each(attributes, function(i, item) {
																	if (item != "colspan" && item != "rowspan")
																		element.removeAttr(item);
																});
																element.css('border','solid windowtext 1.0pt');
																break;
															}
															default: {
																$.each(attributes, function(i, item) {
																	element.removeAttr(item);
																});
																break;
															}
														}
													});
												}
												var cleanText = $('<p>'+$($("#"+input)[0]).summernote("code")+'</p>').removeAttributes();
												$($("#"+input)[0]).summernote("code", cleanText);
											}, 500);
										}
									}
								});
								$('#form-informe-detallado-container #'+key).summernote("code",value);
								setSizeSummer(key);

							}else{
								if ($('#form-informe-detallado-container #'+key).is("span"))
									$('#form-informe-detallado-container #'+key).text(value);
								else
									$('#form-informe-detallado-container #'+key).val(value);
							}
							
							
						});
					$('#form-informe-detallado-container .summernote').summernote({
						dialogsInBody: true,
						lang: 'es-ES',
						buttons: {
							btnObserv: ObservButton
						},
						toolbar: [
						['custom', ['btnObserv']],
						['style', ['style']],
						['font', ['bold', 'underline', 'italic', 'clear']],
						['color', ['color']],
						['para', ['ul', 'ol', 'paragraph']],
						['table', ['table']],
						['insert', ['link', 'picture']],
						],
						"popover": {
							image: [],
							link: [],
							air: [
							]
						},
						callbacks: {
							onPaste: function(e) {
								input = $(this).closest("form").attr("id")+" #"+$(this).attr("id");
								setTimeout(function () {
									$.fn.removeAttributes = function() {
										return this.each(function() {
											var attributes = $.map(this.attributes, function(item) {
												return item.name;
											});
											var element = $(this);
											if(element.children().length != 0){
												element.children().removeAttributes();
											}	
											switch (element[0].nodeName.toLowerCase()) {
												case "img":{
													if($(element).attr("width") == undefined)
														$(element).attr("width", "500px");
													if ($(element).css( "width" ) != "0px")
														$(element).attr("width",$(element).css( "width" ));
													if($(element).css( "width" ).replace("px", "") > 500)
														$(element).attr("width", "500px");													
													if ($(element).css( "height" ) != "0px")
														$(element).attr("height",$(element).css( "height" ));
													element.removeAttr('style');
													break;
												}
												case "td":{
													$.each(attributes, function(i, item) {
														if (item != "colspan" && item != "rowspan")
															element.removeAttr(item);
													});
													element.css('border','solid windowtext 1.0pt');
													break;
												}
												default: {
													$.each(attributes, function(i, item) {
														element.removeAttr(item);
													});
													break;
												}
											}
										});
									}
									var cleanText = $('<p>'+$($("#"+input)[0]).summernote("code")+'</p>').removeAttributes();
									$($("#"+input)[0]).summernote("code", cleanText);
								}, 500);
							}
						}

					});
					$('#div-descargar-documento').remove();
					$('#form-informe-detallado-container #div_anexo_archivo').html('<input accept="application/zip" id="anexo_archivo" name="file[]" type="file" class="filestyle" data-btnClass="btn-danger" data-buttonBefore="true" runat="server" data-text="&nbspPlanilla(s) y/o Extras">');
					$('#form-informe-detallado-container #div_anexo_archivo #anexo_archivo').filestyle({btnClass: "btn-danger",buttonBefore: "true",text: "&nbspAnexo"});
						//$('#form-informe-detallado-container #anexo_archivo').filestyle({btnClass: "btn-danger",buttonBefore: "true",text: "&nbspPlanilla(s) y/o Extras"});
						defProgress("#form-informe-detallado-container #progressbar");
						fileSelectedInforme = result["input-url-anexo"];
						if (result["input-url-anexo"] != "" && result["input-url-anexo"] != undefined&& result["input-url-anexo"] != "undefined" && result["input-url-anexo"] != null) 
							$("#form-informe-detallado-container #anexo_archivo").parent().parent().parent().prepend('<div class="col-md-12 col-lg-12"><div class="col-md-12 col-lg-12" id="div-descargar-documento"><a href="'+result["input-url-anexo"]+'"  target="_blank" title="Descargar Documento"  class="btn btn-warning download" data-placement="left" data-toggle="tooltip"><span>Descargar Archivo</span></a> '+result["input-url-anexo"].split("/")[6]+'</div></div>');

					},error: function(result){
						console.log("Error: "+result);
					}
				});
				//
				$('#modal-informe-detallado-editar').modal("show");
				$('#modal-informe-detallado-editar #h4-modal-informe-title').text('Informe Detallado '+nContrato);
			},error: function(result){
				console.log("Error: "+result);
			}
		});
});
	/*html2canvas(document.getElementById('form-informe-pago-container')).then(function(canvas) {
		console.log(canvas);
	});
	*/
	$( window ).resize(function() {
		$.each($("#form-informe-detallado-container textarea.summernote"),(key,value)=>{setSizeSummer(value.id);});
	});
	function setSizeSummer(key){
		setTimeout(()=>{
			$($("#form-informe-detallado-container #"+key).closest("td").find($( ".panel-body" ))[0]).width(($("#form-informe-detallado-container #"+key).closest(".modal-ml").width()/2) -40);
		}, 100);
		setTimeout(()=>{
			let height = $("#form-informe-detallado-container #"+key).closest("td").height() - $($("#form-informe-detallado-container #"+key).closest("td").find($( ".note-toolbar" ))[0]).height();
			$($("#form-informe-detallado-container #"+key).closest("td").find($( ".panel-body" ))[0]).height(height-35);
		}, 100);
	}

	$('#submit-revisar-informe').on('click', function(e){
		e.preventDefault();
		var usuarioFirma = $(this).data('firma');
		if(usuarioFirma == "1"){
			mensaje = 'Si marco el botón de "Aprobado" y es la última persona firmante, se radicará y firmará electrónicamente el informe de pago en ORFEO';
		}else{
			mensaje = 'Su usuario no solicitará Firma Electrónica ¿Desea dar visto bueno al informe como apoyo?';
		}
		parent.swal({
			confirmButtonColor: '#3f9a9d',
			title: 'Guardar Revisión',
			html: `<small>${mensaje}</small>`,
			type: 'success',
			confirmButtonText: 'Aceptar',
			cancelButtonText: 'Cancelar',
			showCancelButton: true,
		}).then(() => {


			aprobado = $('#input-aprobado').is(":checked");
			//Guardar Observaciones y Crear Radicado
			var datos = {
				'p1' : selectedData,
				'p2' : informeSelected,
				'p3' : aprobado,
				'p4' : $('#id-usuario').val(),
				'p5' : $('#input-obsGenerales').val()
			};
			$.ajax({
				url: url_controller+"saveObservacion",
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(result){
				var identificador = result;
					var idUser = {
						'p1' : $('#id-usuario').val(),
					};

					$.ajax({
						url: url_controller+"getNumDocument",
						type: 'POST',
						dataType: 'json',
						data: idUser,
						success: function(result){		
							if (aprobado && usuarioFirma == "1"){
								abrirModalCodigo(result[0]["VC_Identificacion"],informeSelected, identificador,aprobado, true, 0);			
							}else{
	
								var revision = ($('#input-aprobado').val()=="true") ? 1 : 0;
								var token = null;
								var idInforme = {
									'p1' : $('#id-usuario').val(),
									'p2' : informeSelected,
									'p3' : token,
									 p4: {
											"aprobacion":revision,
											"sistemaOperativo": navigator.platform,
											"navegador": navigator.appCodeName,
											"navegadorVersion": navigator.appVersion,
										 },
									'p5' : $('#input-obsGenerales').val(),
								};
							
								$.ajax({
									url: url_controller+"saveFirma",
									type: 'POST',
									dataType: 'html',
									data: idInforme,
									success: function(result){
										if(result == 1){
											parent.swal({
												confirmButtonColor: '#3f9a9d',
												title: 'Se ha guardado la observación en el histórico.',
												type: 'success',
												confirmButtonText: 'Aceptar',
												showCancelButton: false,
											});											
											$("#modal-revisar-informe").modal('hide');
										}
									},error: function(result){
										console.log("Error: "+result);
									}
								});
							}
		
						},error: function(result){
							console.log("Error: "+result);
						}
					});
					
					if (result == 1 || result == 2 || result == 3 || result == 4 || result == 5) {
						parent.swal({
							confirmButtonColor: '#3f9a9d',
							title: 'El estado y las observaciones del informe fueron almacenadas correctamente.',
							type: 'success',
							confirmButtonText: 'Aceptar',
							showCancelButton: false,
						});
						refreshListado();
						$('#modal-revisar-informe').modal('hide');
						$('body').removeClass('modal-open');
						$('.modal-backdrop').remove();
						estado = "";
						if (aprobado)
							estado = "aprobado";
						else
							estado = "revisado y tiene correcciones";
						var  rol = "";
						if (result == 1)
							rol = "parte del apoyo a la supervisión.";
						if (result == 2)
							rol = "parte del apoyo financiero.";
						if (result == 3)
							rol = "parte del apoyo al supervisor.";
						if (result == 4)
							rol = "parte del supervisor.";
						if (result == 5)
							rol = "parte del segundo apoyo a la supervisión.";
						var contenido = "El informe de pago del periodo <b>"+informeSelectedData["input-periodo-inicio"]+" - "+informeSelectedData["input-periodo-fin"]+"</b> ha sido "+estado+" por "+rol;
						var notificacion = {
							VC_Url:"SeguimientoContratistas/Informe_Pago.php",
							VC_Icon:"fa fa-list-alt",
							VC_Contenido:contenido,
							userId:informeSelectedData["FK_Persona"],
							email: true
						}
						window.parent.sendNotificationUser(notificacion);
							
					}
				},error: function(result){
					console.log("Error: "+result);
				}
			});
		},() => {
			
			if (aprobado){
				$('#input-aprobado').prop("checked",false);
				$("#label-state").text("Sin Aprobar");
			}
		}).catch(parent.swal.noop);;


	});
	$('#submit-revisar-informe-detallado').on('click', function(e){
		e.preventDefault();
		var datos = {
			'p1' : selectedData,
			'p2' : informeSelected,
			'p3' : $('#input-aprobado-detallado').is(":checked"),
			'p4' : $('#id-usuario').val()
		};
		$.ajax({
			url: url_controller+"saveObservacionInformeDetallado",
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(result){
				if (result == 1 || result == 2 || result == 3) {
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: 'El estado y las observaciones del informe detallado fueron almacenadas correctamente.',
						type: 'success',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					});
					refreshListado();
					$('#modal-revisar-informe-detallado').modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					estado = "";
					if ($('#input-aprobado-detallado').is(":checked"))
						estado = "aprobado";
					else
						estado = "revisado y tiene correcciones";
					var  rol = "";
					if (result == 1)
						rol = "parte apoyo a la supervisión.";
					if (result == 2)
						rol = "parte apoyo financiero.";
					if (result == 3)
						rol = "parte apoyo al supervisor.";
					var contenido = "El informe detallado del periodo <b>"+informeSelectedData["input-periodo-inicio"]+" - "+informeSelectedData["input-periodo-fin"]+"</b> ha sido "+estado+" por "+rol;
					var notificacion = {
						VC_Url:"SeguimientoContratistas/Informe_Pago.php",
						VC_Icon:"fa fa-list-alt",
						VC_Contenido:contenido,
						userId:informeSelectedData["FK_Persona"],
						email: true
					}
					window.parent.sendNotificationUser(notificacion);
				}

			},error: function(result){
				console.log("Error: "+result);
			}
		});

	});
	$('#submit-editar-informe').on('click', function(e){
		e.preventDefault();

		var valid = $('#form-editar-informe').valid();
		if (valid) {

			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Guardar Informe',
				html: '<small>¿Está seguro que desea guardar los cambios de este informe?</small>',
				type: 'warning',
				confirmButtonText: 'Sí',
				cancelButtonText: 'No',
				showCancelButton: true,
			}).then(() => {

				$("#form-editar-informe #select-convenio-a").attr('disabled', false);
				$("#form-editar-informe #select-convenio-b").attr('disabled', false);
				$("#form-editar-informe #select-convenio-c").attr('disabled', false);
				$("#form-editar-informe #select-convenio-d").attr('disabled', false);
				$("#form-editar-informe #select-codigo-a").attr('disabled', false);
				$("#form-editar-informe #select-codigo-b").attr('disabled', false);
				$("#form-editar-informe #select-codigo-c").attr('disabled', false);
				$("#form-editar-informe #select-codigo-d").attr('disabled', false);

				var formularioJson = getFormData($('#form-editar-informe'));
				//var files = $("#anexo_planilla_edit")[0].files;
				var datos = new FormData();
				/*
				$.each(files, function(key, value)
				{
					datos.append(key, value);
				}); 
				*/
				datos.append("p1",JSON.stringify(formularioJson));  
				datos.append("p3",informeSelected);  
				datos.append("p4",$('#input-finalizado-2').is(":checked"));
				datos.append("p5",id_contrato_activo);
				$.ajax({
					/*xhr: function()
					{
						
						var xhr = new window.XMLHttpRequest();
						xhr.upload.addEventListener("progress", function(evt){
							if (evt.lengthComputable) {
								var percentComplete = parseInt(100.0 * evt.loaded / evt.total, 10);
								if ($("#anexo_planilla_edit").val() != "")
									updateProgress(Math.round(percentComplete),"#contenedor-editar-informe #progressbar");
							}
						}, false);
						return xhr;
						
					},*/
					url: url_controller+"updateInformePago",
					type: 'POST',
					dataType: 'json',
					processData: false,
					contentType: false,
					data: datos,
					success: function(result){
						if (result == 1) {
						
							
							$.each($('#form-editar-informe .item-grid'), function(key, value)
							{
								var idParametro = $(this).find('option').filter(':selected').val();
								var inputFile = $(this).find('.archivo').attr('id');
								if(inputFile != undefined && idParametro != undefined){
									var files = '';		
									
									files = ($("#"+inputFile)[0].files);
									if(files.length>0){
										var datos = new FormData();
										datos.append(0, files[0]);	
										datos.append("p1",informeSelected);  
										datos.append("p3",$('#id-usuario').val());
										datos.append("p4",idParametro);
										datos.append("p5",id_contrato_activo);
											
										$.ajax({
											url: url_controller+'uploadedDocument',
											method: 'post',
											data: datos,
											processData: false,
											contentType: false
										});
									}
								}							
							});
							
							parent.swal({
								confirmButtonColor: '#3f9a9d',
								title: 'Los cambios realizados al informe fueron almacenados correctamente.',
								type: 'success',
								confirmButtonText: 'Aceptar',
								showCancelButton: false,
							});
							//refreshListado();
							refreshListado2()
							.then((result)=>{
								if ($('#input-finalizado-2').is(":checked")) {	
									contratista = 10;	
									abrirModalCodigo(formularioJson["input-identificacion"],informeSelected, contratista,$('#input-finalizado-2').is(":checked"), true, 0);
								}         
							});
							$('#modal-editar-informe').modal('hide');
							$('body').removeClass('modal-open');
							$('.modal-backdrop').remove();
							if ($('#input-finalizado-2').is(":checked")) {

								var contenido = "El informe de pago del contratista "+$("#form-editar-informe #input-nombres-apellidos").val()+" para el periodo "+$("#form-editar-informe #input-periodo-inicio").val()+" - "+
								$("#form-editar-informe #input-periodo-fin").val()+" ha sido diligenciado y se encuentra disponible para su revisión";
								var notificacion = {
									VC_Url:"SeguimientoContratistas/Informe_Pago.php",
									VC_Icon:"fa fa-list-alt",
									VC_Contenido:contenido,
									userId:informeSelectedData["FK_Persona_Apoyo_Supervisor"],
								}
								window.parent.sendNotificationUser(notificacion);
								notificacion = {
									VC_Url:"SeguimientoContratistas/Informe_Pago.php",
									VC_Icon:"fa fa-list-alt",
									VC_Contenido:contenido,
									userId:informeSelectedData["FK_Aprobacion_Administrativo"],
								}
								window.parent.sendNotificationUser(notificacion);
								notificacion = {
									VC_Url:"SeguimientoContratistas/Informe_Pago.php",
									VC_Icon:"fa fa-list-alt",
									VC_Contenido:contenido,
									userId:informeSelectedData["FK_Persona_Supervisor"],
								}
								window.parent.sendNotificationUser(notificacion);
								notificacion = {
									VC_Url:"SeguimientoContratistas/Informe_Pago.php",
									VC_Icon:"fa fa-list-alt",
									VC_Contenido:contenido,
									userId:informeSelectedData["FK_Persona_Apoyo_Supervisor_Dos"],
								}
								window.parent.sendNotificationUser(notificacion);
							}
						}
						if (result == 3 || result == 4) {
							parent.swal({
								confirmButtonColor: '#3f9a9d',
								title: 'El tamaño del archivo excedió el limite del servidor.',
								html: '<small>Recuerde que el tamaño maximo de los archivos es de 50 Mb</small>',
								type: 'error',
								confirmButtonText: 'Aceptar',
								showCancelButton: false,
							});
						}
						if (result == 5) {
							parent.swal({
								confirmButtonColor: '#3f9a9d',
								html: "<small>Ya existe un informe diligenciado para el período seleccionado (Mes - Fecha final).</small>",
								type: 'error',
								confirmButtonText: 'Aceptar',
								showCancelButton: false,
							})
						}
					},error: function(result){
						error(console.log(result));
						swal({
							confirmButtonColor: '#3f9a9d',
							title: 'Ha ocurrido un error inesperado.',
							html: '<small>Por favor intente nuevamente, si el problema persiste contacte el servicio de soporte.</small>',
							type: 'error',
							confirmButtonText: 'Aceptar',
							showCancelButton: false,
						});
					}
				});
			}).catch(parent.swal.noop);
		}
		else{
			parent.mostrarAlerta("error",'Algo Salio mal!', 'Revise los campos resaltados en rojo');
			validatorInforme.focusInvalid();
		}		
	});
$('#input-aprobado').on('change', function(e){
	e.preventDefault();
	if ($('#input-aprobado').is(":checked"))
		$("#label-state").text("Aprobado");
	else
		$("#label-state").text("Sin Aprobar");

});
$('#input-historico').on('change', function(e){
	e.preventDefault();
	if ($('#input-historico').is(":checked"))
		$("#label-state-historico").text("SI");
	else
		$("#label-state-historico").text("NO");
	refreshListado();

});
$('#input-aprobado-detallado').on('change', function(e){
	e.preventDefault();
	if ($('#input-aprobado-detallado').is(":checked"))
		$("#label-state-detallado").text("Aprobado");
	else
		$("#label-state-detallado").text("Sin Aprobar");

});
$('#input-finalizado-2').on('change', function(e){
	e.preventDefault();
	if ($('#input-finalizado-2').is(":checked"))
		$("#label-state-finalizado-2").text("Finalizado");
	else
		$("#label-state-finalizado-2").text("Sin Finalizar");
});
$('#input-finalizado-detallado').on('change', function(e){
	e.preventDefault();
	if ($('#input-finalizado-detallado').is(":checked"))
		$("#label-state-finalizado-detallado").text("Finalizado");
	else
		$("#label-state-finalizado-detallado").text("Sin Finalizar");
});
$('#input-finalizado-1').on('change', function(e){
	e.preventDefault();
	if ($('#input-finalizado-1').is(":checked")) {
		$("#label-state-finalizado-1").text("Finalizado");
		//$('#modal-codigo-confirmacion').modal("show");
	}
	else
		$("#label-state-finalizado-1").text("Sin Finalizar");
});

$('#form-informe-detallado #input-informe-territorial').on('change', function(e){
	e.preventDefault();
	if ($('#form-informe-detallado #input-informe-territorial').is(":checked")){
		$("#form-informe-detallado #label-state-informe-territorial").text("SI");
		$("#form-informe-detallado .administrativo").hide();
		$("#form-informe-detallado .operativo").hide();
		$("#form-informe-detallado .coordinador").show();
		$("#form-informe-detallado #label-state-informe-territorial").show();
		$("#form-informe-detallado #radio-tipo-territorial").show();
	}
	else{
		$("#form-informe-detallado #label-state-informe-territorial").text("NO");
		$("#form-informe-detallado .administrativo").hide();
		$("#form-informe-detallado .operativo").hide();
		$("#form-informe-detallado .coordinador").hide();
		$("#form-informe-detallado #label-state-informe-territorial").show();
		$("#form-informe-detallado #radio-tipo-territorial").hide();
	}
});
$("#form-informe-detallado .administrativo").hide();
$("#form-informe-detallado .operativo").hide();
$("#form-informe-detallado .coordinador").hide();
$('#form-informe-detallado input[name="tipo-territorial"]:radio').on('change', function(e){
	e.preventDefault();
	changeTipoTerritorial();
});
$('#contenedor-revisar-informe #input-informe-territorial').on('change', function(e){
	e.preventDefault();
	if ($('#contenedor-revisar-informe-detallado #input-informe-territorial').is(":checked")){
		$("#contenedor-revisar-informe-detallado #label-state-informe-territorial").text("SI");
		$("#contenedor-revisar-informe-detallado .administrativo").hide();
		$("#contenedor-revisar-informe-detallado .operativo").hide();
		$("#contenedor-revisar-informe-detallado .coordinador").show();
		$("#contenedor-revisar-informe-detallado #label-state-informe-territorial").show();
		$("#contenedor-revisar-informe-detallado #radio-tipo-territorial").show();
	}
	else{
		$("#contenedor-revisar-informe-detallado #label-state-informe-territorial").text("NO");
		$("#contenedor-revisar-informe-detallado .administrativo").hide();
		$("#contenedor-revisar-informe-detallado .operativo").hide();
		$("#contenedor-revisar-informe-detallado .coordinador").hide();
		$("#contenedor-revisar-informe-detallado #label-state-informe-territorial").show();
		$("#contenedor-revisar-informe-detallado #radio-tipo-territorial").hide();
	}
});
$("#contenedor-revisar-informe-detallado .administrativo").hide();
$("#contenedor-revisar-informe-detallado .operativo").hide();
$("#contenedor-revisar-informe-detallado .coordinador").hide();
$('#contenedor-revisar-informe-detallado input[name="tipo-territorial"]:radio').on('change', function(e){
	e.preventDefault();
	changeTipoTerritorial2();
});
function changeTipoTerritorial() {
	var tipo = $('#form-informe-detallado input[name="tipo-territorial"]:checked').val(); 
	$("#form-informe-detallado .administrativo").hide();
	$("#form-informe-detallado .operativo").hide();
	$("#form-informe-detallado .coordinador").hide();
	switch(tipo) {
		case '1':
		$("#form-informe-detallado .coordinador").show();
		break;
		case '2':
		$("#form-informe-detallado .administrativo").show();
		break;
		case '3':
		$("#form-informe-detallado .operativo").show();
		break;
	}
}
function changeTipoTerritorial2() {
	var tipo = $('#contenedor-revisar-informe-detallado input[name="tipo-territorial"]:checked').val(); 
	$("#contenedor-revisar-informe-detallado .administrativo").hide();
	$("#contenedor-revisar-informe-detallado .operativo").hide();
	$("#contenedor-revisar-informe-detallado .coordinador").hide();
	switch(tipo) {
		case '1':
		$("#contenedor-revisar-informe-detallado .coordinador").show();
		break;
		case '2':
		$("#contenedor-revisar-informe-detallado .administrativo").show();
		break;
		case '3':
		$("#contenedor-revisar-informe-detallado .operativo").show();
		break;
	}
}

function generarPDFInformeDetallado(informe,tamano) {
	var generalPDF = informe;
	var generalPDFDetallado = informe.detallado;
	generalPDF.obligacionesTabla = [];
	generalPDF.obligacionesTabla.push(
		[{text:'OBJETO DEL CONTRATO',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, false, true, true],colSpan:2},{}],
		[{text:generalPDF['input-objeto'],style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, false, true, false],colSpan:2},{}],
		);
	generalPDF.supervisor = [];
	if (generalPDFDetallado['tipo-territorial'] != null & generalPDFDetallado['tipo-territorial'] != 0 ) {
		generalPDF.supervisor = [{
			style: 'tableExample',
			table: {
				heights: [0,1,10,0],
				widths: ["*",250,"*"],
				body: [
				[{text:'\n\n\n\n\n',style: 'subtitlecenter',border: [true, false, false, false]},
				{text:'\n\n\n\n\n',style: 'subtitlecenter',border: [false, false, false, true]},
				{text:'\n\n\n\n\n',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, 0, 0, 0],text:"Vb. "+generalPDF["span-nombre-apoyo"],style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -3, 0, 0],text:generalPDF["span-cargo-apoyo"],style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'\n',style: 'subtitlecenter',border: [true, false, true, true],colSpan:3,id:"lastrow"},{}]
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		}];
		switch(generalPDFDetallado['tipo-territorial']) {
			case "1":
			generalPDF.obligacionesTabla.push(
				[{text:'PRODUCTO',alignment:'center',style: 'subtitlecenter',border: [true, true, true, false],colSpan:2},{}],
				[{text:'Informe periódico donde indique el desarrollo de cada una de las obligaciones contractuales anexando los soportes correspondientes.',style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN ADMINSTRATIVA- INFRAESTRUCTURA: ',style: 'general', bold:true},'Coordinar con los equipos Crea y el componente administrativo las necesidades y oportunidades de mejora relacionadas con Infraestructura, dotaciones, servicios y otras necesidades para el óptimo funcionamiento del Crea.  (Operativo- Entrega de materiales a AF)'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DE LA INFORMACIÓN: ',style: 'general', bold:true},'Coordinar con el equipo de información la actualización de la información para la creación de grupos, seguimiento  a la cobertura, asistencia y a la permanencia. Verificar en el Sistema de Información SICrea-según su perfil realizar las consultas en las  líneas de Arte en la Escuela, Emprende  (Súbete a la Escena y Manos a la Obra) y otros convenios. Analizar reportes mensuales para hacer seguimiento a la cobertura- . radiografía de la atención nes a mes.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN PEDAGÒGICA: ',style: 'general', bold:true},'Coordinar con el Componente Pedagógico las acciones relacionadas con la convivencia en CREA, seguimiento a la asistencia de los Artistas Formadores que permite revisar la permanencia y apoyar el trabajo en equipo entre AF (Artistas Formadores), Gestores Pedagógicos  y Territoriales para el  desarrollo de las líneas AE(Arte en la Escuela, Emprende CREA, Manos a la Obra y Súbete a la Escena y Laboratorio Crea.) Acciones relacionadas con el clima organizacional.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN  DE LA COMUNIDAD: ',style: 'general', bold:true},'Coordinar en Crea  las (Relaciones con el entorno y contexto): Convocatorias a la comunidad, servicio de atención al ciudadano, acciones de movilización social y circulación (apoyo a la producción y a la comunicación, portafolio de servicios CREA, reuniones con la comunidad, colegios, reuniones internas y externas que garanticen la calidad del servicio CREA, Apoyo al área de Circulación.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DOCUMENTAL: ',style: 'general', bold:true},'Apoyar las acciones relacionadas con el Sistema de Gestión Documental de IDARTES.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],				
				);

			break;
			case "2":
			generalPDF.obligacionesTabla.push(
				[{text:'PRODUCTO',alignment:'center',style: 'subtitlecenter',border: [true, true, true, false],colSpan:2},{}],
				[{text:'Informe periódico donde indique el desarrollo de cada una de las obligaciones contractuales anexando los soportes correspondientes.',style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN ADMINSTRATIVA: ',style: 'general', bold:true},'Acciones relacionadas con novedades mensuales tales como: (infraestructura, Inventarios,). Reportes de adaptación de espacios, según necesidades y oportunidades de mejora para el desarrollo de las acciones en CREA.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DE LA INFORMACIÓN: ',style: 'general', bold:true},'Acciones relacionadas con el Sistema de Información según sus funciones como usuario- cada mes reportar las acciones asociadas con este componente. Datos de atención y seguimiento mensual relacionados con Cobertura, Permanencia y deserción en las líneas de Arte en la Escuela, Emprende (Súbete a la Escena y Manos a la Obra) y otros convenios.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DE LA COMUNIDAD (Relaciones con el entorno y contexto): ',style: 'general', bold:true},'Convocatorias a la comunidad, servicio de atención al ciudadano, acciones de movilización social y circulación (apoyo a la producción y a la comunicación, portafolio de servicios Crea, reuniones con la comunidad, colegios, reuniones internas y externas que garanticen la calidad del servicio Crea.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DEL COMPONENTE PEDAGÓGICO: ',style: 'general', bold:true},'Acciones relacionadas con la permanencia de los artistas formadores, articulación con los Gestores Pedagógicos y Territoriales para las líneas de atención de  AE (Arte en la Escuela, Emprende Crea, Manos a la Obra y Súbete a la Escena) y Laboratorio Crea.) Acciones relacionadas con la convivencia escolar en Crea, para la resolución de conflictos.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DOCUMENTAL: ',style: 'general', bold:true},'Acciones relacionadas con el Sistema de Gestión Documental del IDARTES.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],				
				);

			break;
			case "3":
			generalPDF.obligacionesTabla.push(
				[{text:'PRODUCTO',alignment:'center',style: 'subtitlecenter',border: [true, true, true, false],colSpan:2},{}],
				[{text:'Informe donde indique el desarrollo de cada una de las obligaciones contractuales anexando los soportes correspondientes.',style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN ADMINSTRATIVA: ',style: 'general', bold:true},'Acciones relacionadas con novedades mensuales tales como: (infraestructura, Inventarios). Reportes de adaptación de espacios, según necesidades y oportunidades de mejora para el desarrollo de las acciones en CREA. Bienes y servicios CREA.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DE LA INFORMACIÓN: ',style: 'general', bold:true},'Acciones relacionadas con el Sistema de Información SIF según el módulo- cada mes reportar las acciones asociadas con este componente. Datos de atención y seguimiento mensual relacionados con Cobertura, Permanencia y Porcentaje de ocupación del CREA en las líneas de Arte en la Escuela, Emprende CREA (Súbete a la Escena y Manos a la Obra) y otros convenios.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DE LA COMUNIDAD (Relaciones con el entorno y contexto): ',style: 'general', bold:true},'Convocatorias a la comunidad, servicio de atención al ciudadano, acciones de movilización social y circulación (apoyo a la producción y a la comunicación, portafolio de servicios CREA, reuniones con la comunidad, colegios, reuniones internas y externas que garanticen la calidad del servicio CREA.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DEL COMPONENTE PEDAGÓGICO: ',style: 'general', bold:true},'Acciones relacionadas con la pertinencia de la formación en territorio CREA con AF (Artistas Formadores), AFA, (Artistas Formadores Armonizadores), Orientadores de Línea: AE(Arte en la Escuela, Emprende CREA, Manos a la Obra y Súbete a la Escena y Laboratorio CREA.) Acciones relacionadas con la convivencia escolar en CREA. Reemplazos por ausencias.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],
				[{text:[{text:'GESTIÓN DOCUMENTAL: ',style: 'general', bold:true},'Acciones relacionadas con el Sistema de Gestión Documental de IDARTES, relacionadas con el cargo.'],style: 'general',border: [true, false, true, true],colSpan:2},{}],		
				);
			break;
		}
	}
	
	generalPDF.heightsTablaObligaciones = [];
	generalPDF.heightsTablaObligaciones.push(0);
	for (var i = 1; i <= generalPDF["input-numero-obligaciones"]; i++) {
		contentDescrip = [];
		parent.ParseHtml(contentDescrip, "<div>"+generalPDFDetallado['input-descripcion-'+i]+"</div>");
		contentDescrip[0].stack[0].margin = [0, 1, 0, 0];
		contentDescrip[0].stack[0].style = 'general';
		contentDescrip[0].stack[0].border =  [true, true, true, false];
		contentAnex = [];
		parent.ParseHtml(contentAnex, "<div>"+generalPDFDetallado['input-descripcion-anexo-'+i]+"</div>");
		contentAnex[0].stack[0].margin = [0, 1, 0, 0];
		contentAnex[0].stack[0].style = 'general';
		contentAnex[0].stack[0].border =  [true, true, true, false];
		


			//.push({margin: [0, 1, 0, 0],style: 'general',border: [true, true, true, false]})
			generalPDF.heightsTablaObligaciones.push(9);
			generalPDF.heightsTablaObligaciones.push(9);
			lastoblig = null;
			if (generalPDF["input-numero-obligaciones"] == i) {
				lastoblig = "lastoblig";
			}
			generalPDF.obligacionesTabla.push(
				[{margin: [0, 1, 0, 0],text:generalPDF['input-oblicacion-'+i],style: 'subtitlesmall',fillColor:'#e6e6e6',border: [true, true, true, false],colSpan:2,id: lastoblig},{}],
				);
			generalPDF.obligacionesTabla.push(
				[contentDescrip,contentAnex],
				);      
		}
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;

		var yyyy = today.getFullYear();
		if(dd < 10){
			dd='0'+dd;
		}
		if(mm < 10){
			mm="0"+mm;
		} 
		generalPDF.fechaHoy = dd+'/'+mm+'/'+yyyy;
		descargarPDFInformeDetallado(generalPDF,tamano);
		generalPDF.numeroObligaciones = informe["input-numero-obligaciones"];

	}
	function generarPDFInforme(informe,tamano,guardar_en_servidor=0,id_informe=0) {
		var generalPDF = informe;
		generalPDF.obligacionesTabla = [];
		generalPDF.obligacionesTabla.push(
			[{text:'ACTIVIDADES DEL CONTRATISTA DURANTE EL PERÍODO DEL INFORME',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]
			);
		generalPDF.heightsTablaObligaciones = [];
		generalPDF.heightsTablaObligaciones.push(0);
		for (var i = 1; i <= generalPDF["input-numero-obligaciones"]; i++) {
			generalPDF.heightsTablaObligaciones.push(9);
			generalPDF.heightsTablaObligaciones.push(9);
			lastoblig = null;
			if (generalPDF["input-numero-obligaciones"] == i) {
				lastoblig = "lastoblig";
			}
			generalPDF.obligacionesTabla.push(
				[{margin: [0, 1, 0, 0],text:generalPDF['input-oblicacion-'+i],style: 'subtitlesmall',border: [true, true, true, false],id: lastoblig}],
				);
			
			generalPDF.obligacionesTabla.push(
				[{margin: [0, 1, 0, 0],text:generalPDF['input-descripcion-'+i],style: 'generalsmall',border: [true, true, true, false]}],
				);      
		}
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;

		var yyyy = today.getFullYear();
		if(dd < 10){
			dd='0'+dd;
		}
		if(mm < 10){
			mm="0"+mm;
		} 
		if (generalPDF["fecha-informe"]  == "" || generalPDF["fecha-informe"]  == null)
			generalPDF.fechaHoy = dd+'/'+mm+'/'+yyyy;
		else
			generalPDF.fechaHoy = generalPDF["fecha-informe"];

		descargarPDFInforme(generalPDF,tamano,guardar_en_servidor,id_informe);
		generalPDF.numeroObligaciones = informe["input-numero-obligaciones"];
	}


	
	$( "body" ).delegate( "#BT_agregar_documento_orfeo, #BT_editar_documento_orfeo", "click", function(ev){ 
		var idForm = $(this).closest('form').attr('id');
		ev.preventDefault();
		let nuevo_campo = ``;
		var datosGetAnexosO = {
			'p1': 'N', //trae anexos no obligatorios
		};	
		var countOpcionales = 0;
		$.ajax({
			url: url_controller+"getParametrosAnexosOrfeo",
			type: 'POST',
			dataType: 'json',
			data: datosGetAnexosO,
			success: function(result){
				//console.log(result);
				let options = ``;
				$.each(result, function(key, value)
				{
					options += `<option selected value="${value.PK_Id_Tabla}">${value.VC_nombre}</option>`;
				});
				countOpcionales++;
				nuevo_campo+= ` 
					<div class="col-md-12 col-lg-12 item-grid" style="margin-top: 6px;">
						<div class="col-md-4 col-lg-4">
							<select id="tipo_documento" name="tipo_documento" class="form-control tipo_documento">
								<option value="">- Seleccione -</option>${options}
							</select>
						</div>
						
						<div class="col-md-6 col-lg-6">
							<input type="file" name="anexo_opcional-${countOpcionales}" data-descarga="1" class="filestyle form-control archivo anexo_planilla" data-btnClass="btn-primary" data-buttonBefore="true" runat="server"></input>
						</div>
						<div class="col-md-2 col-lg-2">
							<button type=button class="btn btn-danger limpiar_upload" title="subir">
								<span class="fa fa-times" aria-hidden="true"></span>
							</button>
						</div>
					</div>`;

				$(`#${idForm} #contenedor-form-grid`).append(nuevo_campo);
				$(`#${idForm} .archivo`).filestyle({btnClass: "btn-primary",buttonBefore: "true", text: "Abrir"});
				$('#input-finalizado-1, #input-finalizado-2').trigger('click');
			},error: function(result){
				console.log("Error: ", result);
			}
		});
	});

	$(document).on('change', '.tipo_documento', function(ev) {
		parametros.push($(this).val());
		var texto = $(this).find('option').filter(':selected').text();
		$(this).parents('.item-grid').find('.btn-primary').text(texto);
	});

	$( "body" ).delegate( ".upload_formulario", "click", function() {
		
		var idFile = $(this).data("idfile");
		var idPara = $(this).data("idpara");
		var datos = new FormData();
		var files = '';		
		
		files = ($("#"+idFile)[0].files);
			
			datos.append(0, files[0]);
			datos.append("p1",null);  
			datos.append("p3",$('#id-usuario').val());
			datos.append("p4",idPara);
			datos.append("p5",id_contrato_activo);
				
			$.ajax({
				url: url_controller+'uploadedDocument',
				method: 'post',
				data: datos,
				processData: false,
				contentType: false
			}).done(function (data) {
				if (data == 1)
				parent.swal("Buen trabajo!", "Archivos cargados con éxito!", "success")
				else
				parent.swal("Error!", "Los archivos no se cargaron con éxito!", "error")
			}).fail(function () {
				parent.swal("Error!", "Error en la carga, intente mas tarde", "error")
			});
	});

	$(document).on( "click", ".limpiar_upload", function() {
		var self = this;
		let idAnexo = $(this).data('id_anexo');
		let nombreAnexo = $(this).data('nombre_anexo');
		let campoObligatorio = Number($(this).data('campo_obligatorio'));
		if(idAnexo!=undefined){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Guardar Informe',
				html: `<small>¿Está seguro que desea eliminar el anexo ${nombreAnexo}?</small>`,
				type: 'warning',
				confirmButtonText: 'Sí',
				cancelButtonText: 'No',
				showCancelButton: true, 
			}).then(() => {
		
				var datos = {
					'p1': idAnexo,
				}
				
				$.ajax({			
					url: url_controller+"deleteAnexoOrfeo",
					type: 'POST',
					dataType: 'json',
					data: datos,
					success: function(result){
						if(result){
							if(campoObligatorio == 1){
								$(self).closest('.item-grid').find('input.archivo').attr('required','required');
								$(self).closest('.item-grid').find('a.descargar').remove(); 
							}else{
								$(self).parents('.item-grid').remove();
							}
						}else{
							parent.swal("Error!", "Error en la eliminando el archivo, contacte al administrador", "error")
						}
					},error: function(result){
						console.log("Error: "+result.responseText);
					}
				});
			}).catch(parent.swal.noop);			
		}else{
			$(this).parents('.item-grid').remove();
		}
		$('input.archivo').trigger('change');
	});
	
	function progressHandler(event) {
		var percent = (event.loaded / event.total) * 100;
		updateProgress(Math.round(percent),"#form-informe-detallado-container #progressbar");
	}

	function defProgress(elemetIdSelector){
		percentage = 0;
		if(percentage > 100) percentage = 100;
		$(elemetIdSelector).css('width', percentage+'%');
		$(elemetIdSelector).addClass('progress-bar-info').removeClass('progress-bar-danger');
		$(elemetIdSelector).addClass('active');
		$(elemetIdSelector).html(percentage+'%');
	}
	function errProgress(elemetIdSelector){
		percentage = 100;
		if(percentage > 100) percentage = 100;
		$(elemetIdSelector).css('width', percentage+'%');
		$(elemetIdSelector).addClass('progress-bar-danger').removeClass('progress-bar-info');
		$(elemetIdSelector).removeClass('active');
		$(elemetIdSelector).html('Error');
	}
	function updateProgress(percentage,elemetIdSelector){
		if(percentage >= 100) {
			percentage = 100;
			$(elemetIdSelector).removeClass('active');
		}
		$(elemetIdSelector).css('width', percentage+'%');
		$(elemetIdSelector).html(percentage+'%');
	}
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
function descargarPDFInforme(generalPDF,tamano,guardar_en_servidor,id_informe) {
	var count = 0 ;
	var bandera = false;
	var fecha_producto = "";
	if (((generalPDF["input-fecha-fin"] == "15/12/2019") || (generalPDF["input-fecha-plazo-fin"] == "15/12/2019")) && (generalPDF["input-numero-pagos"] == generalPDF["input-pago-numero"]))  { fecha_producto = "15/12/2019";}
	else{fecha_producto = generalPDF.fechaHoy;}
	var dd = {
		pageSize: tamano,
		pageOrientation: 'portrait',
		pageMargins:[19,55,20,90],
		watermark: {text: 'APROBADO', color: 'gray', opacity: 0.8, bold: true, italics: false,marginX:0,marginY:60,font: 'ArialOl'},
		footer: {
			columns: [
			{ text: datosVersionFormato.codigo+'\n'+ 
			datosVersionFormato.fecha+'\n'+ 
			datosVersionFormato.version+'\n', style: 'footerStyle',id:"lastrow"}
			]
		},
		content: [
		{ 
			style: 'tableExample',
			table: {
				widths: [109, '*', 158],
				heights:[12,12,20],
				body: [
				[{image: 'idartes_logo',width: 70,rowSpan: 3,alignment:'center'},
				{text:'GESTIÓN FINANCIERA',style: 'titles',rowSpan: 2,margin: [0, 11, 0, 0]},
				{text:datosVersionFormato.codigo,style: 'general',margin: [0, 2, 0, 0]}],
				[{},{text:{}},{text:datosVersionFormato.fecha,style: 'general',margin: [0, 2, 0, 0]}],
				[{},{text:'INFORME PARA PAGO (PERSONA NATURAL Y/O JURÍDICA)',style: 'titles',margin: [0, 12, 0, 0]},{text:datosVersionFormato.version,style: 'general',margin: [0, 12, 0, 0]}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{border: [true, false, true, false],text: ''}]
				]
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: [109, 150, '*'],
				body: [
				[{text:'Fecha del Informe',style: 'subtitle',fillColor:'#e6e6e6',border: [true, true, true, false]},{text:generalPDF.fechaHoy,style: 'generalcenter',border: [true, true, true, false]},{border: [true, false, true, false],text: ''}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{text:'INFORMACIÓN BÁSICA DEL CONTRATISTA',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: [100, 75, 75, '*', 109],
				body: [
				[{text:'PERÍODO DEL INFORME',style: 'subtitle',border: [true, true, true, false]},
				{text:generalPDF["input-periodo-inicio"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-periodo-fin"],style: 'generalcenter',border: [true, true, true, false]},
				{text:'No. DEL CONTRATO',style: 'subtitle',border: [true, true, true, false]},
				{text:generalPDF["input-numero-contrato"],style: 'generalcenter',border: [true, true, true, false]}
				],
				[{text:'SUSPENSIÓN',style: 'subtitle',border: [true, true, true, false]},
				{text:generalPDF["input-suspension-inicio"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-suspension-fin"],style: 'generalcenter',border: [true, true, true, false]},
				{text:'',style: 'generalcenter',border: [true, true, false, false]},
				{text:'',style: 'generalcenter',border: [false, true, true, false]},
				],
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: [200, '*', 25,75],
				body: [
				[{text:'NOMBRES Y APELLIDOS DEL CONTRATISTA',style: 'subtitle',border: [true, true, true, false]},
				{text:generalPDF["input-nombres-apellidos"],style: 'generalcenter',border: [true, true, true, false]},
				{text:identificaciones[generalPDF["select-identificacion"]-1].nombre,style: 'subtitlecenter',border: [true, true, true, false]},
				{text:generalPDF["input-identificacion"],style: 'generalcenter',border: [true, true, true, false]},
				],
				[{text:'ACTIVIDAD ECONÓMICA (CIIU)',style: 'subtitle',border: [true, true, true, false]},
				{text:generalPDF["input-ciiu"],style: 'generalcenter',border: [true, true, true, false]},
				{text:'',border: [true, true, true, false],colSpan: 2},
				{},
				],
				[{text:'NOMBRES Y APELLIDOS DEL CONTRATISTA CEDENTE \n  (Diligencie este item, en caso de cesión de contrato) ',style: 'subtitle',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-nombres-apellidos-cedente"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:identificaciones[generalPDF["select-tipo-identificacion-cedente"]-1].nombre,style: 'subtitlecenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-identificacion-cedente"],style: 'generalcenter',border: [true, true, true, false]},
				],

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{text:'INFORMACIÓN BANCARIA DEL CONTRATISTA A QUIEN SE LE VA A GIRAR',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				heights: [15],
				widths: [75, 106, 70, 70, 72, "*"],
				body: [
				[{margin: [0, 3, 0, 0],text:'BANCO:',style: 'subtitle',border: [true, true, true, false]},
				{margin: [0, 3, 0, 0],text:bancosPDF[generalPDF["select-banco"]],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 3, 0, 0],text:'TIPO DE CUENTA:',style: 'subtitle',border: [true, true, true, false]},
				{margin: [0, 3, 0, 0],text:generalPDF["input-tipo-cuenta"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 3, 0, 0],text:'No. CUENTA:',style: 'subtitle',border: [true, true, true, false]},
				{margin: [0, 3, 0, 0],text:generalPDF["input-numero-cuenta"],style: 'generalcenter',border: [true, true, true, false]}
				]
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{text:'INFORMACIÓN DEL CONTRATO',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				heights: [15],
				widths: [75, 65, 50, 50, 50, 55, 69.6, "*"],
				body: [
				[
				{text:'Objeto:',style: 'subtitle',border: [true, true, true, false]},
				{text:generalPDF["input-objeto"],style: 'general',border: [true, true, true, false],colSpan:7},
				{},{},{},{},{},{}
				],[
				{text:'Fecha de Inicio',style: 'subtitle',border: [true, true, true, false]},
				{text:generalPDF["input-fecha-inicio"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 7, 0, 0],text:'Plazo Inicial:',style: 'subtitlecenter',border: [true, true, true, false],rowSpan:2},
				{margin: [0, 7, 0, 0],text:generalPDF["input-plazo-inicial"],style: 'generalcenter',border: [true, true, true, false],rowSpan:2},
				{margin: [0, 7, 0, 0],text:'Prórrogas:',style: 'subtitlecenter',border: [true, true, true, false],rowSpan:2},
				{margin: [0, 7, 0, 0],text:generalPDF["input-prorrogas"],style: 'generalcenter',border: [true, true, true, false],rowSpan:2},
				{margin: [0, 7, 0, 0],text:'Fecha Final:',style: 'subtitlecenter',border: [true, true, true, false],rowSpan:2},
				{margin: [0, 7, 0, 0],text:generalPDF["input-fecha-plazo-fin"],style: 'generalcenter',border: [true, true, true, false],rowSpan:2},
				],[
				{text:'Fecha Terminación',style: 'subtitle',border: [true, true, true, false]},
				{text:generalPDF["input-fecha-fin"],style: 'generalcenter',border: [true, true, true, false]},
				{},{},{},{},{},{}
				],[
				{text:'Número de pagos pactados',style: 'subtitle',border: [true, true, true, false],colSpan:2},{},
				{text:generalPDF["input-numero-pagos"],style: 'generalcenter',border: [true, true, true, false]},
				{text:'',border: [true, true, true, false],colSpan:5},{},{},{},{}
				]
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				widths: [75, 16, 16, 15.2, "*"],
				body: [
				[
				{margin: [0, 0, 0, 0],text:'Pago No.',style: 'subtitle',border: [true, true, true, false],},
				{margin: [0, 0, 0, 0],text:generalPDF["input-pago-numero"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:'de',style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["input-pago-de-total"],style: 'generalcenter',border: [true, true, true, false]},
				{text:'',border: [true, true, true, false]}
				]
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{text:'INFORMACIÓN FINANCIERA DEL CONTRATO',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				widths: [75, 65, 50, 50, 79.1, 65, 50, "*"],
				body: [
				[
				{margin: [0, 0, 0, 0],text:'No REGISTRO PRESUPUESTAL',style: 'subtitlecenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:'CÓDIGO FUENTE',style: 'subtitlecenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:'CONVENIO',style: 'subtitlecenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:'VALOR A PAGAR',style: 'subtitlecenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:'No REGISTRO PRESUPUESTAL',style: 'subtitlecenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:'CÓDIGO FUENTE ',style: 'subtitlecenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:'CONVENIO',style: 'subtitlecenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:'VALOR A PAGAR',style: 'subtitlecenter',border: [true, true, true, false]},
				],
				[
				{margin: [0, 0, 0, 0],text:generalPDF["input-rp-contenido-a"] != null ? generalPDF["input-rp-contenido-a"]:'',style: 'generalsmall',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["select-codigo-a"] != null ? codigos[generalPDF["select-codigo-a"]].VC_Descripcion:'',style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["select-convenio-a"] != null ? convenios[generalPDF["select-convenio-a"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["input-rp-valor-a"] != null ? generalPDF["input-rp-valor-a"]:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["input-rp-contenido-c"] != null ? generalPDF["input-rp-contenido-c"]:'', style: 'generalsmall',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["select-codigo-c"] != null ? codigos[generalPDF["select-codigo-c"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["select-convenio-c"] != null ? convenios[generalPDF["select-convenio-c"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["input-rp-valor-c"] != null ? generalPDF["input-rp-valor-c"]:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				],
				[
				{margin: [0, 0, 0, 0],text:generalPDF["input-rp-contenido-b"] != null ? generalPDF["input-rp-contenido-b"]:'', style: 'generalsmall',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["select-codigo-b"] != null ? codigos[generalPDF["select-codigo-b"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["select-convenio-b"] != null ? convenios[generalPDF["select-convenio-b"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["input-rp-valor-b"] != null ? generalPDF["input-rp-valor-b"]:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["input-rp-contenido-d"] != null ? generalPDF["input-rp-contenido-d"]:'', style: 'generalsmall',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["select-codigo-d"] != null ? codigos[generalPDF["select-codigo-d"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["select-convenio-d"] != null ? convenios[generalPDF["select-convenio-d"]].VC_Descripcion:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["input-rp-valor-d"] != null ? generalPDF["input-rp-valor-d"]:'', style: 'generalsmallcenter',border: [true, true, true, false]},
				]
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				widths: [110, 60, 55, "*"],
				body: [
				[
				{text:'Valor inicial Contrato:',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-valor-inicial"],style: 'general',border: [true, true, true, false],colSpan:3},
				{},{}
				],[
				{text:'Valor Adición 1:',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-valor-adicion-1"],style: 'general',border: [true, true, true, false],colSpan:3},
				{},{}
				],[
				{text:'Valor Adición 2:',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-valor-adicion-2"],style: 'general',border: [true, true, true, false],colSpan:3},
				{},{}
				],[
				{text:'Valor Adición 3:',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-valor-adicion-3"],style: 'general',border: [true, true, true, false],colSpan:3},
				{},{}
				],[
				{text:'Valor total del Contrato \n(Incluidas adiciones)',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-valor-total-contrato"],style: 'general',border: [true, true, true, false],colSpan:3},
				{},{}
				],[
				{text:'Valor pago a efectuar',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-valor-pago-efectuar"],style: 'general',border: [true, true, true, false]},
				{text:'Valor en Letras',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-valor-letras"],style: 'general',border: [true, true, true, false]},
				],[
				{text:'Pagos efectuados a la fecha',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-giros-efectuados"],style: 'general',border: [true, true, true, false],colSpan:3},
				{},{}
				],[
				{text:'Saldo pendiente de pago',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-saldo-pediente"],style: 'general',border: [true, true, true, false],colSpan:3},
				{},{}
				],[
				{text:'Valor a liberar',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-valor-liberar"],style: 'general',border: [true, true, true, false],colSpan:3},
				{},{}
				],
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				heights:generalPDF.heightsTablaObligaciones,
				widths: ['*'],
				body:generalPDF.obligacionesTabla
				
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{text:'PRODUCTOS ENTREGADOS DURANTE EL PERÍODO DEL PRESENTE INFORME',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				}
			}
		},{
			style: 'tableExample',
			table: {
				widths: [215,85,"*"],
				body: [
				[
				{text:'PRODUCTO ENTREGADO ',style: 'subtitlecenter',border: [true, true, true, false]},
				{text:'FECHA DE ENTREGA \nDEL PRODUCTO ',style: 'subtitlecenter',border: [true, true, true, false]},
				{text:'MECANISMO DE VERIFICACIÓN  ',style: 'subtitlecenter',border: [true, true, true, false]},
				],[
				{text:generalPDF["textarea-producto"],style: 'general',border: [true, true, true, false]},
				{margin: [0,5, 0, 0],text:fecha_producto,style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["textarea-mecanismo-verificacion"],style: 'general',border: [true, true, true, false]},
				]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{text:'DECLARACIÓN JURAMENTADA',style: 'subtitlecenter',fillColor:'#e6e6e6',border: [true, true, true, false]}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				widths: [180,30,30,'*'],
				body: [
				[
				{text:'',style: 'subtitlecenter',border: [true, true, true, false]},
				{text:'SI',style: 'subtitlecenter',border: [true, true, true, false]},
				{text:'NO',style: 'subtitlecenter',border: [true, true, true, false]},
				{text:'OBSERVACIONES',style: 'subtitlecenter',border: [true, true, true, false]},
				],
				[
				{text:'¿De acuerdo con el Artículo 383. Parágrafo 2 del Estatuto Tributario, para la prestación del servicio o actividad he contratado o vinculado dos (2) o más trabajadores asociados a la actividad por al menos noventa (90) días continuos o discontinuos?',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-1-si"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-1-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-1-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Pertenece usted al nuevo Régimen Simple de tributación responsabilidad en el RUT (47)?',style: 'general',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-2-si"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-2-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-2-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Es usted responsable de Impuesto sobre Ventas (IVA)?',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-3-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-3-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-3-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Es responsable de declaración de renta año inmediatamente anterior?',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-4-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-4-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-4-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Es usted una Entidad Estatal o tiene régimen de tributacion especial?',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-5-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-5-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-5-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Actualmente tiene suscrito otros contratos con el Distrito o la Nación?',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-12-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-12-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-12-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Es usted Facturador Electrónico?',style: 'general',border: [true, true, true, false]},
				{margin: [0, 10, 0, 0],text:generalPDF["input-declaracion-6-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 10, 0, 0],text:generalPDF["input-declaracion-6-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-6-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Tiene dependientes a su cargo? (Decreto 1070 de 2013 Art. 387 E.T.) (solo se tomará encuenta si se anexan soportes mencionados en la tabla Disminución Retención Art 387 E.T.)',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-7-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-7-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-7-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Realizó pagos por intereses de vivienda en el año 2020? (solo se tomará encuenta si se anexan soportes mencionados en la tabla Disminución Retención Art 387 E.T.)',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-8-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-8-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-8-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Realizó pagos de Medicina Prepagada o Plan Complementario en el año 2020? (solo se tomará encuenta si se anexan soportes mencionados en la tabla Disminución Retención Art 387 E.T.)',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-9-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-9-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-9-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Efectúa pagos en una cuenta AFC? De ser así en observaciones indique el valor mensual pagado anexando certificación bancaria de la cuenta AFC',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-10-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-10-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-10-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿Efectúa pagos de Pensiones Voluntarias? De ser así en observaciones indique el valor mensual (Anexar copia del pago correspondiente)',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-11-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-11-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-11-observacion"],style: 'general',border: [true, true, true, false]},
				],
				/*[
				{text:'¿Actualmente tiene suscrito otros contratos con el Distrito o la Nación?',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-12-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-12-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-12-observacion"],style: 'general',border: [true, true, true, false]},
				],*/
				[
				{text:'¿Tiene alguna sanción o embargo?',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-13-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-13-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-13-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:'¿El pago de la ARL es asumido por el IDARTES?',style: 'general',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-14-si"],style: 'generalcenter',border: [true, true, true, false]},
				{margin: [0, 5, 0, 0],text:generalPDF["input-declaracion-14-no"],style: 'generalcenter',border: [true, true, true, false]},
				{text:generalPDF["input-declaracion-14-observacion"],style: 'general',border: [true, true, true, false]},
				],
				[
				{text:['Yo '+generalPDF["input-nombres-apellidos"]+', en mi calidad de contratista del IDARTES certifico bajo la gravedad de juramento, que los documentos soporte del pago de Salud, Pensión y ARL, corresponden a los ingresos provenientes del contrato materia del pago sujeto a retención y que estos aportes NO ',
				{text: generalPDF["input-disminucion-retencion-no"] == "" ? "  ": generalPDF["input-disminucion-retencion-no"], fontSize: 7,decoration: 'underline',decorationStyle: 'solid',decorationColor: 'black'},
				'  SI ',
				{text: generalPDF["input-disminucion-retencion-si"] == "" ? "  ": generalPDF["input-disminucion-retencion-si"], fontSize: 7,decoration: 'underline',decorationStyle: 'solid',decorationColor: 'black'},
				' sirvieron para la disminución de la base de Retención en la Fuente de Renta o del impuesto de Industria y Comercio en otro cobro, por lo tanto NO ',
				{text: generalPDF["input-tomados-retencion-no"] == "" ? "  ": generalPDF["input-tomados-retencion-no"], fontSize: 7,decoration: 'underline',decorationStyle: 'solid',decorationColor: 'black'},
				'  SI  ',
				{text: generalPDF["input-tomados-retencion-si"] == "" ? "  ": generalPDF["input-tomados-retencion-si"], fontSize: 7,decoration: 'underline',decorationStyle: 'solid',decorationColor: 'black'},
				'  pueden ser tomados para tal fin por el IDARTES.\n\n El (los) número(s) o referencias(s) de las(s) planilla(s) por el aporte de(l) (los) mes(es) de '+generalPDF["input-mes-planilla"]+' es(son):\n '+generalPDF["input-numero-planilla"]+' (Anexo copia(s) de la(s) planilla(s)).'],style: 'general',border: [true, true, true, false],colSpan:4},
				{text:'',style: 'general',border: [true, true, true, false]},
				{text:'',style: 'general',border: [true, true, true, false]},
				{text:'',style: 'general',border: [true, true, true, false]},
				],
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{text:'LOS PRODUCTOS QUE SE CERTIFICAN Y EL CUMPLIMIENTO DE OBLIGACIONES CONTRACTUALES HAN SIDO VERIFICADOS POR:',style: 'subtitlecenter',border: [true, true, true, false]}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',

			table: {
				heights: [0,1,10,0],
				widths: [10,200,'*',200,10],
				body: [
				[{text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{image: generalPDF['span-firma-supervisor'] != '' && generalPDF['span-firma-supervisor'] != 'data:,' ? 'firma_supervisor':'sin_firma',width: 180,height: 50, rowSpan: 3,alignment:'left', border: [false, false, false, false]},
				{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{image: generalPDF['span-firma-contratista'] != '' && generalPDF['span-firma-contratista'] != 'data:,' ? 'firma_contratista':'sin_firma',width: 180,height: 50,rowSpan: 3,alignment:'left', border: [false, false, false, false]},
				{text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{text:'',style: 'subtitle',border: [false, false, false, false]},
				{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{text:'',style: 'subtitle',border: [false, false, false, false]},
				{text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{text:generalPDF['span-nombre-supervisor'],style: 'subtitle',border: [false, true, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["input-nombres-apellidos"],style: 'subtitle',border: [false, true, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -3, 0, 0],text:generalPDF['span-cargo-supervisor'],style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, -3, 0, 0],text:'Contratista',fontSize: 7.2,border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -6, 0, 0],text:'Revisó Supervisor o Interventor',fontSize: 7.2,border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{image: generalPDF['span-firma-apoyo'] != '' && generalPDF['span-firma-apoyo'] != 'data:,' ? 'firma_apoyo':'sin_firma',width: 180,height: 50,rowSpan: 3,alignment:'left', border: [false, false, false, false]},
				{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{image: generalPDF['span-firma-apoyo_dos'] != '' && generalPDF['span-firma-apoyo_dos'] != 'data:,' ? 'firma_apoyo_dos':'sin_firma',width: 180,height: 50,rowSpan: 3,alignment:'left', border: [false, false, false, false]},
				{text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, 0, 0, 0],text:generalPDF['span-nombre-apoyo'],style: 'subtitle', border: generalPDF['span-nombre-apoyo'] != '' ? [false, true, false, false] : [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:generalPDF['span-nombre-apoyo_dos'],style: 'subtitle', border: generalPDF['span-nombre-apoyo_dos'] != '' ? [false, true, false, false] : [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}], 


				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -3, 0, 0],text:generalPDF['span-cargo-apoyo'],style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, -3, 0, 0],text:generalPDF['span-cargo-apoyo_dos'],style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -3, 0, 0],text:generalPDF["span-etiqueta-apoyo"],fontSize: 7.2,border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, -3, 0, 0],text:generalPDF["span-nombre-apoyo_dos"]!= '' ? 'Revisó Apoyo a la Supervisión':'',fontSize: 7.2,border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, 3, 0, 0],text:'Vo.Bo Apoyo Financiero',fontSize: 7,border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'\n',style: 'subtitlecenter',border: [true, false, true, true],colSpan:5,id:"lastrow"},{},{},{},{}]
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		],

		pageBreakBefore: function(currentNode, followingNodesOnPage, nodesOnNextPage, previousNodesOnPage) {
	    	/*count = count + 1;
	    	bandera = false;
	    	var total = (generalPDF["input-numero-obligaciones"] * 2) - 2;
			console.log(currentNode);
	    	console.log(count);
	    	console.log(total);
	    	console.log(followingNodesOnPage);
	    	console.log(nodesOnNextPage);
	    	console.log(previousNodesOnPage);*/
	    	//check if signature part is compl etely on the last page, add pagebreak if not
	    	/*if (count > 108 && (count - 108) == (total)){
	    		bandera = true;
	    	}   
	    	if (bandera && (nodesOnNextPage.length !== 0 && nodesOnNextPage[nodesOnNextPage.length-1].id == "lastrow") ) 
	    	{
	    		bandera = false;
	    		return true; 
	    	}*/
	    	/*if (currentNode.id == 'lastoblig') {
	    		console.log(nodesOnNextPage);
	    	}*/
	    	if (currentNode.id == 'lastoblig' && nodesOnNextPage.length != 0 && nodesOnNextPage[nodesOnNextPage.length-1].id == "lastrow")
	    	{
	    		return true; 
	    	}
	    	else{
	    		return false; 
	    	}

	    },
	    images: {
	    	idartes_logo: 'data:image/png;base64,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',
	    	firma_apoyo: generalPDF["span-firma-apoyo"],
	    	firma_apoyo_dos: generalPDF["span-firma-apoyo_dos"],
	    	firma_supervisor: generalPDF["span-firma-supervisor"],
	    	firma_contratista: generalPDF["span-firma-contratista"],
	    	sin_firma: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAACFCAYAAAAtmkC4AAAABHNCSVQICAgIfAhkiAAAAF96VFh0UmF3IHByb2ZpbGUgdHlwZSBBUFAxAAAImeNKT81LLcpMVigoyk/LzEnlUgADYxMuE0sTS6NEAwMDCwMIMDQwMDYEkkZAtjlUKNEABZgamFmaGZsZmgMxiM8FAEi2FMk61EMyAAABH0lEQVR4nO3BMQEAAADCoPVPbQlPoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4GKMEAAdM062UAAAAASUVORK5CYII='
	    },
	    defaultStyle: {
	    	font: 'arial'
	    },
	    styles: {
	    	titles: {
	    		fontSize: 7.2,
	    		bold: true,
	    		alignment: 'center',
	    		margin: [0, 8, 0, 0]
	    	},
	    	subtitle: {
	    		fontSize: 7.2,
	    		bold: true,
	    		alignment: 'left',
	    	},
	    	subtitlecenter: {
	    		fontSize: 7.2,
	    		bold: true,
	    		alignment: 'center',
	    	},
	    	subtitlesmallcenter: {
	    		fontSize: 7.2,
	    		bold: true,
	    		alignment: 'center',
	    	},
	    	general: {
	    		fontSize: 7.2,
	    		alignment: 'left',
	    	},
	    	generalsmall: {
	    		fontSize: 6,
	    		alignment: 'left',
	    	},
	    	subtitlesmall: {
	    		fontSize: 6,
	    		bold: true,
	    		alignment: 'left',
	    	},
	    	generalcenter: {
	    		fontSize: 7.2,
	    		alignment: 'center',
	    	},
	    	generalsmallcenter: {
	    		fontSize: 6,
	    		alignment: 'center',
	    	},
	    	footerStyle: {
	    		bold: false,
	    		margin: [0, 20, 40, 0],
	    		alignment: 'right',
	    		fontSize: 7.2
	    	}
	    }

	}
	pdfMake.createPdf(dd).download("informePago.pdf");
}

function descargarPDFCertificado(generalPDF,tamano,b64=false,radicado_orfeo=null) {
	var count = 0 ;
	var bandera = false;
	var fecha_producto = "";
	
	/*var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear();
	if(dd < 10){
		dd='0'+dd;
	}
	if(mm < 10){
		mm="0"+mm;
	} 
	generalPDF.fechaHoy = dd+'/'+mm+'/'+yyyy;*/
	var fechaHoy = new Date();
	var dia = fechaHoy.getDate();
	var mes = fechaHoy.getMonth() + 1; 
	var anio = fechaHoy.getFullYear();

	var dd = {
		pageSize: tamano,
		pageOrientation: 'portrait',
		pageMargins:[50,55,50,110],
		footer: {
			columns: [
			{ text: '2TR-GJU-F-19'+'\n'+ 
			'23/10/2019'+'\n'+ 
			'Versión 3'+'\n', style: 'footerStyle',id:"lastrow"}
			]
		},
		content: [
		{ 
			style: 'tableExample',
			table: {
				widths: [100, '*', 110],
				heights:[12,12,20],
				body: [
				[{image: 'idartes_logo',width: 70,rowSpan: 4,alignment:'center'},
				{text:'GESTIÓN JURÍDICA',style: 'titles',rowSpan: 2,margin: [0, 11, 0, 0]},
				{text:'Código:GF-F-01',style: 'general',margin: [0, 2, 0, 0]}],
				[{},{text:{}},{text:'Fecha: 09/03/2021',style: 'general',margin: [0, 2, 0, 0]}],
				[{},{text:'CERTIFICACIÓN DE CUMPLIMIENTO CONTRATO DE PRESTACIÓN DE SERVICIOS PROFESIONALES, APOYO A LA GESTIÓN Y TRABAJOS ARTÍSTICOS',rowSpan: 2,style: 'titles',margin: [0, 0, 0, 0]},{text:'Versión 4',style: 'general',margin: [0, 6, 0, 0]}],
				[{},{text:{}},{text:'Página: 1 de 1',style: 'general',margin: [0, 2, 0, 0]}],
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{border: [false, false, false, false],text: ''}],
				[{border: [false, false, false, false],text: ''}],
				[{border: [false, false, false, false],text: ''}],
				[{border: [false, false, false, false],text: ''}]
				]
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{text:[
					{text: generalPDF["span-nombre-supervisor"]+', '+generalPDF["span-cargo-supervisor"]+', ', bold:true},
					{text:'actuando en mi calidad de supervisor(a) del Contrato de Prestación de Servicios N° '},
					{text: generalPDF["input-numero-contrato"]+' ', bold:true},
					{text:'suscrito por el INSTITUTO DISTRITAL DE LAS ARTES con el (la) contratista '},
					{text: generalPDF["input-nombres-apellidos"]+', ', bold:true},
					{text:'cuyo objeto es "'+generalPDF["input-objeto"]+'", '},
					{text:'certifico que de acuerdo con las obligaciones pactadas, el citado ha hecho entrega de la totalidad de los productos del contrato del periodo comprendido entre el '},
					{text:generalPDF["input-periodo-inicio"]+' al '+generalPDF["input-periodo-fin"]+', ', bold:true},
					{text:'por lo tanto se solicita a la subdirección Administrativa y Financiera hacer el pago correspondiente al contratista.'}
					],style: 'subtitle',border: [false, false, false, false]}]
					]
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{border: [false, false, false, false],text: ''}],
					[{border: [false, false, false, false],text: ''}]
					]
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:[
						{text: 'Así mismo certifico que el contratista se encuentra al día con los aportes al Sistema de Seguridad Social Integral de conformidad con la normatividad que rige la materia, tal y como se acredita en los soportes de liquidación de planilla y pago que se anexan con el informe para realizar el '},
						{text: 'PAGO NÚMERO '+generalPDF["input-pago-numero"]+' de '+generalPDF["input-pago-de-total"], bold:true},
						{text:' del contrato, los cuales han sido verificados con el operador que liquida la planilla para pagos al Sistema.'},
						],style: 'subtitle',border: [false, false, false, false]}]
						]
					}
				},
				{
					style: 'tableExample',
					table: {
						widths: ['*'],
						body: [
						[{border: [false, false, false, false],text: ''}],
						[{border: [false, false, false, false],text: ''}]
						]
					}
				},
				{
					style: 'tableExample',
					table: {
						widths: ['*'],
						body: [
						[{text:[
							{text: 'Con la suscripción de esta certificación también se advierte al contratista que su obligación es efectuar los aportes exigidos por la disposición de ley y es de su respectivo resorte el pago de las cotizaciones al Sistema de Seguridad Social Integral, el cual se debe efectuar mes vencido, por periodos mensuales, a través de la planilla integrada de Liquidación de Aportes (PILA) y teniendo en cuenta los ingresos percibidos en el periodo de cotización, esto es, el mes inmediatamente anterior; hecho que se da por conocido por el contratista con el recibo de la presente.'}
							],style: 'subtitle',border: [false, false, false, false]}]
							]
						}
					},
					{
						style: 'tableExample',
						table: {
							widths: ['*'],
							body: [
							[{border: [false, false, false, false],text: ''}],
							[{border: [false, false, false, false],text: ''}]
							]
						}
					},
					{
						style: 'tableExample',
						table: {
							widths: ['*'],
							body: [
							[{text:[
								{text: 'Esta certificación se expide en la ciudad de Bogotá, a los '},
								{text: dia, bold:true},
								{text: ' día(s) del mes de '},
								{text: meses[parseInt(mes)], bold:true},
								{text: '  de '},
								{text: anio+'.', bold:true},
								],style: 'subtitle',border: [false, false, false, false]}]
								]
							}
						},
						{
							style: 'tableExample',
							table: {
								widths: ['*'],
								body: [
								[{border: [false, false, false, false],text: ''}],
								[{border: [false, false, false, false],text: ''}],
								[{border: [false, false, false, false],text: ''}]
								]
							}
						},
						{
							style: 'tableExample',

							table: {
								heights: [0,1,10,0],
								widths: [130,'*',130],
								body: [
								[
								{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
								{image: generalPDF['span-firma-supervisor'] != '' && generalPDF['span-firma-supervisor'] != 'data:,' ? 'firma_supervisor':'sin_firma',width: 180,height: 50, rowSpan: 3,alignment:'center', border: [false, false, false, false]},
								{text:'',style: 'subtitlecenter',border: [false, false, false, false]}
								],

								[
								{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
								{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
								{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
								],

								[
								{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
								{text:'',style: 'subtitle',border: [false, false, false, false]},
								{text:'',style: 'subtitlecenter',border: [false, false, false, false]}
								],

								[
								{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
								{margin: [0, 3, 0, 0],text:generalPDF['span-nombre-supervisor'],style: 'subtitlecenter',border: [false, true, false, false], bold:true},
								{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
								],

								[
								{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
								{margin: [0, -3, 0, 0],text:generalPDF['span-cargo-supervisor'],style: 'subtitlecenter',border: [false, false, false, false], bold:true},
								{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
								],

								[
								{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
								{margin: [0, -6, 0, 0],text:'Supervisor(a)',style: 'subtitlecenter',border: [false, false, false, false], bold:true},
								{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
								]
								]
							},layout: {
								vLineWidth: function (i, node) {
									return 0.9;
								},
								hLineWidth: function (i, node) {
									return 0.9;
								},
							}
						},
						],
						images: {
							idartes_logo: 'data:image/png;base64,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',
							firma_supervisor: generalPDF["span-firma-supervisor"],
							sin_firma: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAACFCAYAAAAtmkC4AAAABHNCSVQICAgIfAhkiAAAAF96VFh0UmF3IHByb2ZpbGUgdHlwZSBBUFAxAAAImeNKT81LLcpMVigoyk/LzEnlUgADYxMuE0sTS6NEAwMDCwMIMDQwMDYEkkZAtjlUKNEABZgamFmaGZsZmgMxiM8FAEi2FMk61EMyAAABH0lEQVR4nO3BMQEAAADCoPVPbQlPoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4GKMEAAdM062UAAAAASUVORK5CYII='
						},
						defaultStyle: {
							font: 'arial'
						},
						styles: {
							titles: {
								fontSize: 10,
								bold: true,
								alignment: 'center',
								margin: [0, 0, 0, 0]
							},
							subtitle: {
								fontSize: 11,
								bold: false,
								alignment: 'justify',
							},
							subtitlecenter: {
								fontSize: 11,
								bold: true,
								alignment: 'center',
							},
							general: {
								fontSize: 10,
								alignment: 'left',
							},
							footerStyle: {
								bold: false,
								margin: [0, 20, 40, 0],
								alignment: 'right',
								fontSize: 10
							}
						}

					}
					pdfMake.createPdf(dd).download("certificadoCumplimiento.pdf");
}

function descargarPDFCertificadoFinal(generalPDF,tamano) {
	var count = 0 ;
	var bandera = false;
	var fecha_producto = "";
	
	/*var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear();
	if(dd < 10){
		dd='0'+dd;
	}
	if(mm < 10){
		mm="0"+mm;
	} 
	generalPDF.fechaHoy = dd+'/'+mm+'/'+yyyy;*/
	var fechaHoy = generalPDF["fecha-informe"].split('/');
	var dia = fechaHoy[0];
	var mes = fechaHoy[1];
	var anio = fechaHoy[2];

	var dd = {
		pageSize: tamano,
		pageOrientation: 'portrait',
		pageMargins:[50,55,50,110],
		footer: {
			columns: [
			{ text: '2TR-GJU-F-19'+'\n'+ 
			'23/10/2019'+'\n'+ 
			'Versión 3'+'\n', style: 'footerStyle',id:"lastrow"}
			]
		},
		content: [
		{ 
			style: 'tableExample',
			table: {
				widths: [100, '*', 110],
				heights:[12,12,20],
				body: [
				[{image: 'idartes_logo',width: 70,rowSpan: 4,alignment:'center'},
				{text:'GESTIÓN JURÍDICA',style: 'titles',rowSpan: 2,margin: [0, 11, 0, 0]},
				{text:'Código:2TR-GJU-F-19',style: 'general',margin: [0, 2, 0, 0]}],
				[{},{text:{}},{text:'Fecha: 23/10/2019',style: 'general',margin: [0, 2, 0, 0]}],
				[{},{text:'CERTIFICACIÓN DE CUMPLIMIENTO CONTRATO DE PRESTACIÓN DE SERVICIOS PROFESIONALES, APOYO A LA GESTIÓN Y TRABAJOS ARTÍSTICOS',rowSpan: 2,style: 'titles',margin: [0, 0, 0, 0]},{text:'Versión 3',style: 'general',margin: [0, 6, 0, 0]}],
				[{},{text:{}},{text:'Página: 1 de 1',style: 'general',margin: [0, 2, 0, 0]}],
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{border: [false, false, false, false],text: ''}],
				[{border: [false, false, false, false],text: ''}],
				[{border: [false, false, false, false],text: ''}],
				[{border: [false, false, false, false],text: ''}]
				]
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{text:[
					{text: generalPDF["span-nombre-supervisor"]+', '+generalPDF["span-cargo-supervisor"]+', ', bold:true},
					{text:'actuando en mi calidad de supervisor(a) del Contrato de Prestación de Servicios N° '},
					{text: generalPDF["input-numero-contrato"]+' ', bold:true},
					{text:'suscrito por el INSTITUTO DISTRITAL DE LAS ARTES con el (la) contratista '},
					{text: generalPDF["input-nombres-apellidos"]+', ', bold:true},
					{text:'cuyo objeto es "'+generalPDF["input-objeto"]+' ",'},
					{text:'certifico que de acuerdo con las obligaciones pactadas en el contrato, el citado ha hecho entrega de la totalidad de los productos del contrato y ha cumplido el término contractual según la cláusula de plazo convenida entre las partes, por lo tanto se solicita a la Subdirección Administrativa y Financiera hacer el pago correspondiente al contratista y en consecuencia el contrato se da por terminado habiéndose cumplido todo lo pactado.'}
					],style: 'subtitle',border: [false, false, false, false]}]
					]
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{border: [false, false, false, false],text: ''}],
					[{border: [false, false, false, false],text: ''}]
					]
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{text:[
						{text: 'Así mismo certifico que el (la) contratista se encuentra al día con los aportes al Sistema de Seguridad Social Integral de conformidad con la normatividad que rige la materia, tal y como se acredita en los soportes de liquidación de planilla y pago que se anexan con el informe para realizar el pago final del contrato, los cuales han sido verificados con el operador que liquida la planilla para pagos al Sistema.'}
						],style: 'subtitle',border: [false, false, false, false]}]
						]
					}
				},
				{
					style: 'tableExample',
					table: {
						widths: ['*'],
						body: [
						[{border: [false, false, false, false],text: ''}],
						[{border: [false, false, false, false],text: ''}]
						]
					}
				},
				{
					style: 'tableExample',
					table: {
						widths: ['*'],
						body: [
						[{text:[
							{text: 'Con la suscripción de esta certificación también se advierte al contratista, que es su obligación efectuar los aportes exigidos por las disposiciones de ley y es de su exclusivo resorte el pago de las cotizaciones al Sistema de Seguridad Social Integral, el cual se debe efectuar mes vencido, por periodos mensuales, a través de la Planilla Integrada de Liquidación de Aportes (PILA) y teniendo en cuenta los ingresos percibidos en el periodo de cotización, esto es, el mes inmediatamente anterior; hecho que se da por conocido por el contratista con el recibo de la presente.'}
							],style: 'subtitle',border: [false, false, false, false]}]
							]
						}
					},
					{
						style: 'tableExample',
						table: {
							widths: ['*'],
							body: [
							[{border: [false, false, false, false],text: ''}],
							[{border: [false, false, false, false],text: ''}]
							]
						}
					},
					{
						style: 'tableExample',
						table: {
							widths: ['*'],
							body: [
							[{text:[
								{text: 'Así mismo, se advierte al contratista que la terminación del contrato, no lo exonera de cumplir con los aportes y cotizaciones al Sistema de Seguridad Social Integral, hasta por el monto de los honorarios '},
								{text: '(el cual se debe calcular sobre el 40% por ciento del valor por período pagado de cada contrato) ', style:'italicbold'},
								{text: 'sobre los cuales debe efectuar la liquidación para pago de aportes, acorde con lo percibido por la prestación de los servicios a la entidad.'}
								],style: 'subtitle',border: [false, false, false, false]}]
								]
							}
						},
						{
							style: 'tableExample',
							table: {
								widths: ['*'],
								body: [
								[{border: [false, false, false, false],text: ''}],
								[{border: [false, false, false, false],text: ''}]
								]
							}
						},
						{
							style: 'tableExample',
							table: {
								widths: ['*'],
								body: [
								[{text:[
									{text: 'Esta certificación se expide en la ciudad de Bogotá, a los '},
									{text: dia, bold:true},
									{text: ' día(s) del mes de '},
									{text: meses[parseInt(mes)], bold:true},
									{text: '  de '},
									{text: anio+'.', bold:true},
									],style: 'subtitle',border: [false, false, false, false]}]
									]
								}
							},
							{
								style: 'tableExample',
								table: {
									widths: ['*'],
									body: [
									[{border: [false, false, false, false],text: ''}],
									[{border: [false, false, false, false],text: ''}]
									]
								}
							},
							{
								style: 'tableExample',

								table: {
									heights: [0,1,10,0],
									widths: [130,'*',130],
									body: [
									[
									{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{image: generalPDF['span-firma-supervisor'] != '' && generalPDF['span-firma-supervisor'] != 'data:,' ? 'firma_supervisor':'sin_firma',width: 180,height: 50, rowSpan: 3,alignment:'center', border: [false, false, false, false]},
									{text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],

									[
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{margin: [0, -3, 0, 0],text:'',style: 'subtitle',border: [false, false, false, false]},
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],

									[
									{text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{text:'',style: 'subtitle',border: [false, false, false, false]},
									{text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],

									[
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{margin: [0, 3, 0, 0],text:generalPDF['span-nombre-supervisor'],style: 'subtitlecenter',border: [false, true, false, false], bold:true},
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],

									[
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{margin: [0, -3, 0, 0],text:generalPDF['span-cargo-supervisor'],style: 'subtitlecenter',border: [false, false, false, false], bold:true},
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									],

									[
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]},
									{margin: [0, -6, 0, 0],text:'Supervisor(a)',style: 'subtitlecenter',border: [false, false, false, false], bold:true},
									{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, false, false]}
									]
									]
								},layout: {
									vLineWidth: function (i, node) {
										return 0.9;
									},
									hLineWidth: function (i, node) {
										return 0.9;
									},
								}
							},
							],
							images: {
								idartes_logo: 'data:image/png;base64,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',
								firma_supervisor: generalPDF["span-firma-supervisor"],
								sin_firma: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAACFCAYAAAAtmkC4AAAABHNCSVQICAgIfAhkiAAAAF96VFh0UmF3IHByb2ZpbGUgdHlwZSBBUFAxAAAImeNKT81LLcpMVigoyk/LzEnlUgADYxMuE0sTS6NEAwMDCwMIMDQwMDYEkkZAtjlUKNEABZgamFmaGZsZmgMxiM8FAEi2FMk61EMyAAABH0lEQVR4nO3BMQEAAADCoPVPbQlPoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4GKMEAAdM062UAAAAASUVORK5CYII='
							},
							defaultStyle: {
								font: 'arial'
							},
							styles: {
								titles: {
									fontSize: 10,
									bold: true,
									alignment: 'center',
									margin: [0, 0, 0, 0]
								},
								subtitle: {
									fontSize: 11,
									bold: false,
									alignment: 'justify',
								},
								subtitlecenter: {
									fontSize: 11,
									bold: true,
									alignment: 'center',
								},
								general: {
									fontSize: 10,
									alignment: 'left',
								},
								italicbold:{
									fontSize: 10,
									bold: true,
									alignment: 'justify',
									italics: true
								},
								footerStyle: {
									bold: false,
									margin: [0, 20, 40, 0],
									alignment: 'right',
									fontSize: 10
								}
							}

						}
						pdfMake.createPdf(dd).download("certificadoFinalContrato.pdf");
	//pdfMake.createPdf(dd).open();
}

function descargarPDFInformeDetallado(generalPDF,tamano) {
	var count = 0 ;
	var bandera = false;
	var dd = {
		pageSize: tamano,
		pageOrientation: 'portrait',
		pageMargins:[19,55,20,70],
		watermark: {text: 'APROBADO', color: 'gray', opacity: 0.6, bold: true, italics: false,marginX:0,marginY:60,font: 'ArialOl'},
		content: [
		/*{ 
			style: 'tableExample',
			table: {
				widths: [109, '*'],
				heights:[12,12,20],
				body: [
				[{image: 'idartes_logo',width: 70,rowSpan: 2,alignment:'center'},
				{text:'GESTIÓN FINANCIERA',style: 'titles',margin: [0, 11, 0, 0]}],
				[{},{text:'INFORME PARA PAGO (PERSONA NATURAL Y/O JURÍDICA)',style: 'titles',margin: [0, 12, 0, 0]}]

				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},*/
		{ 
			style: 'tableExample',
			table: {
				widths: ['*', '*'],
				heights:[12,12,12],
				body: [
				[{text:'NOMBRE:',style: 'subtitle',alignment: 'right',margin: [0, 1, 0, 1],border: [true, true, false, true]},{text:generalPDF["input-nombres-apellidos"],style: 'titles',margin: [0, 1, 0, 1],alignment: 'left',border: [false, true, true, true]}],
				[{text:'N° DE CONTRATO:',style: 'subtitle',alignment: 'right',margin: [0, 1, 0, 1],border: [true, true, false, true]},{text:generalPDF["input-numero-contrato"],style: 'titles',margin: [0, 1, 0, 1],alignment: 'left',border: [false, true, true, true]}],
				[{text:'PERIODO:',style: 'subtitle',alignment: 'right',margin: [0, 1, 0, 1],border: [true, true, false, true]},{text:generalPDF["input-periodo-inicio"]+" AL "+generalPDF["input-periodo-fin"],style: 'titles',margin: [0, 1, 0, 1],alignment: 'left',border: [false, true, true, true]}],
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		{
			style: 'tableExample',
			table: {
				heights:generalPDF.heightsTablaObligaciones,
				widths: [300,254],
				body:generalPDF.obligacionesTabla
				
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},{
			style: 'tableExample',
			table: {
				heights: [0,1,10,0],
				widths: ["*",250,"*"],
				body: [
				[{text:'\n\n\n\n\n\n',style: 'subtitlecenter',border: [true, true, false, false]},
				{text:'\n\n\n\n\n\n',style: 'subtitlecenter',border: [false, true, false, true]},
				{text:'\n\n\n\n\n\n',style: 'subtitlecenter',border: [false, true, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, 0, 0, 0],text:generalPDF["input-nombres-apellidos"],style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -3, 0, 0],text:generalPDF["span-cargo-contratista"],style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [true, false, false, false]},
				{margin: [0, -3, 0, 0],text:'C.C.'+generalPDF["input-identificacion"],style: 'subtitlecenter',border: [false, false, false, false]},
				{margin: [0, 0, 0, 0],text:'',style: 'subtitlecenter',border: [false, false, true, false]}],

				[{margin: [0, 0, 0, 0],text:'\n',style: 'subtitlecenter',border: [true, false, true, generalPDF.supervisor.length != 0? false: true],colSpan:3,id:generalPDF.supervisor.length != 0? "prevrow": "lastrow"},{}]
				]
			},layout: {
				vLineWidth: function (i, node) {
					return 0.9;
				},
				hLineWidth: function (i, node) {
					return 0.9;
				},
			}
		},
		generalPDF.supervisor
		],
		pageBreakBefore: function(currentNode, followingNodesOnPage, nodesOnNextPage, previousNodesOnPage) {
			if (currentNode.id == 'lastoblig' && nodesOnNextPage.length != 0 && nodesOnNextPage[nodesOnNextPage.length-1].id == "lastrow")
			{
				return true; 
			}
			else{
				return false; 
			}

		},
		images: {
			idartes_logo: 'data:image/png;base64,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'
		},
		defaultStyle: {
			font: 'arial'
		},
		styles: {
			titles: { 
				fontSize: 10,
				bold: true,
				alignment: 'center',
				margin: [0, 8, 0, 0],

			},
			subtitle: {
				fontSize: 10,
				bold: true,
				alignment: 'left',
			},
			subtitlecenter: {
				fontSize: 10,
				bold: true,
				alignment: 'center',
			},
			subtitlesmallcenter: {
				fontSize: 10,
				bold: true,
				alignment: 'center',
			},
			general: {
				fontSize: 10,
				alignment: 'left',
			},
			generalsmall: {
				fontSize: 9,
				alignment: 'left',
			},
			subtitlesmall: {
				fontSize: 9,
				bold: true,
				alignment: 'left',
			},
			generalcenter: {
				fontSize: 10,
				alignment: 'center',
			},
			generalsmallcenter: {
				fontSize: 9,
				alignment: 'center',
			},
		}

	}
	//console.log("this");
	pdfMake.createPdf(dd).download("informeDetallado.pdf");
	//pdfMake.createPdf(dd).open();

}

function obtenerNumeroPagoAnexos(VC_Pago_Numero,VC_Numero_Pagos){
	var pagoActual = Number(VC_Pago_Numero)+1;
	var totalPagos = Number(VC_Numero_Pagos);

	if(pagoActual == 1){
		numeroPago = 'I';
	}else if(pagoActual == totalPagos){
		numeroPago = 'F';
	}else{
		numeroPago = 'O';
	}	
	return numeroPago;
}

function sumaBytesArchivos(param){
	upload_size = 0;
	$.each($(param), function(i){
		if($(this)[0].files[0] != undefined){
			upload_size += $(this)[0].files[0].size;
		}
	});	
	return upload_size;
}
		
function bytesToSize(bytes) {
	var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	if (bytes == 0) return '0 Byte';
	var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
 }
 
 function abrirModalCodigo(identificacion,informeSelected,identificador,checked,abreModal = true, esInformeRadicado = 0){
	var data = {
		'p1': identificacion
	};
	$.ajax({
		url: url_controller+"solicitarCodigoSeguridad",
		type: 'POST',
		dataType: 'json',
		data: data,
		success: function(result){
			if(result){					
				if(abreModal){
					$('#id-informe-cod').val(informeSelected);
					$('#id-finalizado-cod').val(checked);
					$('#identificador-cod').val(identificador); //No se esta usando
					$("#codigo_confirmacion").val("");
					$("#solicitar_codigo").data("cedula",identificacion);
					$('#aceptar_codigo').data('radicado',esInformeRadicado);
					var reglas = {
						'codigo_confirmacion': {
							required: true,
							maxlength: 6,
							minlength: 6,
							number: true,
						},
					};
				
					var mensajes = {
						'codigo_confirmacion': {
							maxlength:'El código de seguridad tiene 6 digitos',
							minlength:'El código de seguridad tiene 6 digitos',
						},					
					};
					validarForm("#form-codigo-seguridad",reglas,mensajes);
					$('#modal-codigo-confirmacion').modal("show");
				}else{
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: 'Bien hecho!',
						html: 'Codigo de seguridad enviado a su correo.',
						type: 'success',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					});
				}
			}else{
				parent.swal({
					confirmButtonColor: '#3f9a9d',
					title: 'Algo salio mal!',
					html: `No se encontro usuario de ORFEO para el documento ${identificacion}`,
					type: 'error',
					confirmButtonText: 'Aceptar',
					showCancelButton: false,
				});
			}			
			
		},error: function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Fallo de Conexión con ORFEO.',
				html: '<small>Intentelo mas tarde</small>',
				type: 'error',
				confirmButtonText: 'Aceptar',
				showCancelButton: false,
			});
		}
	});	 
 }
 function validarForm(id,reglas,mensajes,ignorar = ":hidden"){
	/* JQUERY VALIDATE*/
	if(id==undefined || $(id).length == 0 ){
		return false; 
	}else{  
		reglas = (reglas == undefined) ? [] : reglas;
		mensajes = (mensajes == undefined) ? [] : mensajes; 
		$(id).validate().destroy();	
		return $(id).validate({  
			debug: true,
			ignore: ignorar,    
			rules: reglas,
			messages: mensajes,
			errorPlacement : function(error, element) {
				//$(element).closest('.form-group').find('.help-block').html(error.html());
				//$(element).closest('.input-iconito').find('.help-block').html(error.html()); 
				$(element).tooltip("destroy");
				$(element).tooltip({title: error.html(), placement: "bottom"}); 
				if($(element).hasClass('filestyle')){
					$(element).closest('div').find('.bootstrap-filestyle input').tooltip({title: error.html(), placement: "bottom"}); 
				}			           
			},
			highlight : function(element) {
				$(element).addClass('has-error');
				if($(element).hasClass('filestyle')){
					$(element).closest('div').find('.bootstrap-filestyle input').addClass('has-error'); 
				}						
			}, 
			unhighlight: function(element, errorClass, validClass) {
				if($(element).hasClass('filestyle')){
					$(element).closest('div').find('.bootstrap-filestyle input').removeClass('has-error'); 
					$(element).closest('div').find('.bootstrap-filestyle input').tooltip("hide");
					$(element).closest('div').find('.bootstrap-filestyle input').tooltip("destroy");										
				}						
				$(element).removeClass('has-error');
				$(element).tooltip("hide");
				$(element).tooltip("destroy");
			}        
		});		
	}
}
function firmarRadicado(informeSelected,mensaje){
	var data = {
		'p1': informeSelected, 
	};
	$.ajax({
		url: url_controller+"firmaElectronicaDocumento",
		type: 'POST',
		dataType: 'json',
		data: data,
		success: function(data){

			parent.swal({
				type: mensaje.type,
				title: mensaje.title,
				html: `${mensaje.message}, ${data.validado} `,
				confirmButtonText: 'Aceptar',
				showCancelButton: false,
			}).then(()=>{
				parent.cerrarCargando();	
			});	
		},error: function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'ERROR',
				html: '<small>No se pudo firmar electronicamente, consulte al administrador del sistema.</small>',
				type: 'error',
				confirmButtonText: 'Aceptar',
				showCancelButton: false,
			});							
		}
	});		
}

