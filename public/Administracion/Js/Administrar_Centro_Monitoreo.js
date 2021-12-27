var url_service_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
$(document).ready(function(e){

	$('#TX_descripcion').summernote({
		  height: 100,                 // set editor height
		  minHeight: null,             // set minimum height of editor
		  maxHeight: null,             // set maximum height of editor
		  placeholder: 'Ingrese la descripción del tipo de indicador',
		  lang: 'es-ES'
	});	


	//Esperar que cargen los js  de editor_sublime.js
	//setTimeout(function(){  
	//	if (typeof cargado !== 'undefined') {         
			CodeMirror.commands.autocomplete = function(cm) {
			cm.showHint({hint: CodeMirror.hint.anyword});
			} 		 	
			var mime = 'text/x-mariadb';
			window.editor = CodeMirror.fromTextArea(document.getElementById('TX_sql'), {
			    mode: mime,
			    theme: "monokai",
			    autoCloseBrackets: true,
			    matchBrackets: true,
			    showCursorWhenSelecting: true,		    
			    indentWithTabs: true,
			    smartIndent: true,
			    lineNumbers: true,
			    scrollbarStyle: "simple",
			    keyMap: "sublime",  
			    autofocus: true,
			    autoRefresh: true,  
			    fullscreen:true ,		    
				extraKeys: {
				"Ctrl-Space": "autocomplete",
				"F11": function(cm) { 
				cm.setOption("fullScreen", !cm.getOption("fullScreen"));
				},
				"Esc": function(cm) {
					if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
					}
				}
			});		
			$(document).ready(function(e){
			    $("#myModal").modal({
			        show: false,
			        //backdrop: 'static',
					keyboard: false
			    });			
				$('#myModal').on('shown', function () {	
					editor.refresh();
					console.log("se abre");	
				});
			});		
		//}else{
		//	console.log("Entorno de editor sublime no esta definido, añadir ../js/editor_sublime.js");
	//	}
	//}, 1200); 	


	$("#SL_seccion").change(function(){		
		$("#SL_tipo_indicador").html(parent.getTiposIndicadores($(this).val())).selectpicker('refresh');
	});
	$("#IN_seccion").change(function(){ 
		$("#FK_tipo_indicador").html(parent.getAllTiposIndicadores()).selectpicker('refresh');
	});
	$("#VC_tipo_grafico").html(parent.getTipoDeGraficas()).selectpicker('refresh');

	$("#VC_filtros").html(parent.getTipoDeFiltrosGraficos()).selectpicker('refresh'); 

	$("#BT_Buscar").click(function(e){
		parent.mostrarCargando();
		var datos = { 
		    funcion: 'getTiposIndicadoresCentroMonitoreo', 
		    p1: {
		    	'in_seccion': $("#SL_seccion").val(),
		    	'fk_tipo_indicador': $("#SL_tipo_indicador").val()
		    }
		};
		$.ajax({
			url: url_service_obj, 
			type: 'POST',
			data: datos, 
			success: function(data){			
	
				$("#div_table_tipos_indicadores").html(data);
			    $("#table_tipos_indicadores").DataTable({
			        "pageLength": 10,
			        "language": {
			            "lengthMenu": "Ver _MENU_ registros por pagina",
			            "zeroRecords": "No hay información, lo sentimos.",
			            "info": "Mostrando pagina _PAGE_ de _PAGES_",
			            "infoEmpty": "No hay registros disponibles",
			            "infoFiltered": "(filtered from _MAX_ total records)",
			            "search": "Filtrar"
			        },
			        dom: 'Bfrtip'			        
			    }).draw();
			    parent.cerrarCargando();
			},
			error: function(result){ 
	      		console.error("Error: "+result);   
	    	}  
		});	
			 		
	});

	$("body").delegate(".BT_editar","click",function(){ 		
		var datos=$(this).data("indicador");
		$('#TX_descripcion').summernote('code', datos.TX_descripcion); 			 
		//window.editor.value=datos.TX_sql; 
		window.editor.getDoc().setValue(datos.TX_sql);

		//console.log(datos);
		$("#IN_seccion").val(datos.IN_seccion);
		$("#IN_seccion").trigger('change');
		$.each(datos,function(key,value){
			if(!$("#"+key).prop('multiple')){				
				$("#"+key).val(value);
			}
			else{
				if(value!=null){					
					$("#"+key).selectpicker('val', value.split(','));
				}
			}
		});
		if(datos.IN_estado=="1"){
			$("#IN_estado").bootstrapToggle('on');
		}else{
			$("#IN_estado").bootstrapToggle('off');
		} 
		$(".selectpicker").selectpicker('refresh');
		$("#BT_guardar").data('accion','update');

		limpiarformulario();
		$('#myModal').modal('show');  
		setTimeout(()=>{
			window.editor.refresh();
			$(".CodeMirror").outerHeight($("#labelSQL").outerHeight()); 
		},200);
	});

	$("#BT_Crear").click(function(e){ 
		e.preventDefault(); 
		window.editor.getDoc().setValue('');
		$('#TX_descripcion').summernote('code', '');
		$('#tipo_indicador')[0].reset();
		$(".selectpicker").selectpicker('refresh');
		$("#IN_estado").bootstrapToggle('on');
		$("#BT_guardar").data('accion','save');
 		limpiarformulario();
		setTimeout(()=>{
			window.editor.refresh();
			$(".CodeMirror").outerHeight($("#labelSQL").outerHeight()); 
		},200);

	});

	function limpiarformulario(){
		  $('.form-group').removeClass('has-error').removeClass('has-success'); 
		  $('.form-group').find('.help-block').html('');		
	}


	function guardarDatosIndicador(){
		var accion=$("#BT_guardar").data('accion'); 
		var formulario = parent.getFormData($("#tipo_indicador"));
		formulario.TX_descripcion=$('#TX_descripcion').summernote('code'); 
		formulario.TX_sql=window.editor.getDoc().getValue(); 
		formulario.VC_filtros=$("#VC_filtros").val().join(); 
		formulario.IN_estado= ($("#IN_estado").prop("checked") ? 1 : 0);  
		//console.log($("#VC_filtros").val().join()); 
		var datos = { 
		    funcion: accion+'TipoIndicador',   
		    p1: formulario
		};
		$.ajax({
			url: url_service_obj, 
			type: 'POST',
			data: datos, 
			success: function(data){			
				if(data==0){
					parent.mostrarAlerta("error","mensaje del sistema","El registro no ha sufrido modificaciones");					
				}else{
					parent.mostrarAlerta("success","mensaje del sistema","El tipo de indicador ha sido modificado","$('#BT_Buscar').trigger('click');");
					parent.swal({
						title: "mensaje del sistema",
						html: "El tipo de indicador ha sido modificado",
						type: 'success',
						showCancelButton: false,
						confirmButtonText: 'Ok',
						//reverseButtons: true,
					}).then(() => {
						$('#BT_Buscar').trigger('click');
						
					},function(dismiss) {
						if (dismiss == 'cancel') {
							
						}
					}).catch(parent.swal.noop);					
					
				}
				$('#myModal').modal('hide'); 
			},
			error: function(result){ 
	      		console.error("Error: "+result);   
	      		$('#myModal').modal('hide'); 
	    	}  
		});			
	}
	$('form .selectpicker').on('change', function () { 
	    $(this).valid();
	});
	$("#tipo_indicador").validate({
		rules: { 
		  VC_numeral: {
		    required: true,
		    minlength: 1
		  },
		  VC_titulo: {
		    required: true,
		    minlength: 10
		  },
		  IN_seccion: {
		    required: true
		  },
		  VC_icono: {
		    required: true,
		    minlength: 5
		  },
		  VC_tipo_grafico: {
		    required: true
		  },
		  TX_sql: {
		    required: true
		  }	  
		},
		messages: {
		  VC_numeral: {
		    required: "Por favor ingrese el numeral",
		    minlength: "El numeral debe contener al menos un caracter"
		  },
		  VC_titulo: {
		    required: "Por favor ingrese el titulo",
		    minlength: "El numeral debe contener al menos diez caracteres"

		  },
		  IN_seccion: {
		    required: "Por favor elija una sección"
		  },
		  VC_icono: {
		    required: "Por favor ingrese el icono del tipo de indicador",
		    minlength: "El nombre del icono debe contener al menos cinco caracteres"
		  },
		  VC_tipo_grafico: {
		    required: "Por favor ingrese el icono del tipo de grafico"
		  },
		  TX_sql: {
		    required: "Por favor ingrese el SQL"
		  }	  	   
		},
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
		   guardarDatosIndicador();
		}
	});

});