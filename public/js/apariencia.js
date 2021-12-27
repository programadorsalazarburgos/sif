 var url_service = '../src/Administracion/Controlador/AparienciaController.php'; 
$(document).ready(function(){
	//loadFuncion();
	var datos = {
		funcion : 'getApariencia',
		p1: $("#id_rol").val()
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("head").append(data);
			//console.log(data);
		}, 
		async: false,		
	});	 

//Codigo para Menu Responsive
	var menuAbierto=false;
	$("#boton_menu").click(function(e){
		//alert("h");
		if(!menuAbierto){ 
			$("#div_menu").css({
				left: '0'
			});
			$("#boton_menu").css({
				'border-radius': '50%'
			}); 
		    $('#boton_menu .linea:nth-child(1)').animate({  textIndent: -45 }, {
		        step: function(now,fx) {
		          $(this).css({'-webkit-transform': 'translateY(9px) rotate('+now+'deg)'}); 
		        },
		        duration:'fast'
		    },'linear');
		    $('#boton_menu .linea:nth-child(2)').animate({  textIndent: 0 }, {
		        step: function(now,fx) {
		          $(this).css({'opacity': now}); 
		        },
		        duration:'fast'
		    },'linear');        
		    $('#boton_menu .linea:nth-child(3)').animate({  textIndent: 45 }, {
		        step: function(now,fx) {
		          $(this).css({'-webkit-transform': 'translateY(-9px) rotate('+now+'deg)'}); 
		        },
		        duration:'fast'
		    },'linear'); 			
			menuAbierto=true;
		}
		else{
			$("#div_menu").css({
				left: '-100%'
			});	
			$("#boton_menu").css({
				'border-radius': '4px'
			});		
		    $('#boton_menu .linea:nth-child(1)').animate({  textIndent: 0 }, {
		        step: function(now,fx) {
		          $(this).css({'-webkit-transform': 'translateY(0px) rotate('+now+'deg)'}); 
		        },
		        duration:'fast'
		    },'linear');  
		     
		    $('#boton_menu .linea:nth-child(3)').animate({  textIndent: 0 }, {
		        step: function(now,fx) {
		          $(this).css({'-webkit-transform': 'translateY(0px) rotate('+now+'deg)'}); 
		        },
		        duration:'fast'
		    },'linear');   
		    $('#boton_menu .linea:nth-child(2)').animate({  textIndent: 1 }, {
		        step: function(now,fx) {
		          $(this).css({'opacity': now}); 
		        },
		        duration:'fast'
		    },'linear');  
			menuAbierto=false;
		}
	});	

	//$(".nav-second-level li a").on('click',function(e){ 
	$("body").delegate(".nav-second-level li a","click",function(){ 
		$("#div_menu").css({ 
			left: '-100%'
		});		  
		$("#boton_menu").css({
			'border-radius': '4px'
		});		
		$('#boton_menu .linea:nth-child(1)').animate({  textIndent: 0 }, {
		    step: function(now,fx) {
		      $(this).css({'-webkit-transform': 'translateY(0px) rotate('+now+'deg)'}); 
		    },
		    duration:'fast'
		},'linear');  
		 
		$('#boton_menu .linea:nth-child(3)').animate({  textIndent: 0 }, {
		    step: function(now,fx) {
		      $(this).css({'-webkit-transform': 'translateY(0px) rotate('+now+'deg)'}); 
		    },
		    duration:'fast'
		},'linear');   
		$('#boton_menu .linea:nth-child(2)').animate({  textIndent: 1 }, {
		    step: function(now,fx) {
		      $(this).css({'opacity': now}); 
		    },
		    duration:'fast'
		},'linear'); 		
		menuAbierto=false;	
	});
});