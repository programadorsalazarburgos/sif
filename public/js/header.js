var url_service = '../src/Administracion/Controlador/AparienciaController.php'; 
$(document).ready(function(e){
    var datos = {
        funcion : 'getMenu',
        p1: $("#id_usuario").val()
    };
    $.ajax({
        url: url_service,
        type: 'POST',
        data: datos,
        success: function(data){ 
            $("#side-menu").html(data); 
            $('#side-menu').metisMenu();     
            //console.log(data);
        }, 
        async: true
    });

    var datos = {
        'id_usuario': $("#id_usuario").val(),
        'rol_persona': $("#id_rol").val()
    };
    $.ajax({
        url: '../framework/sendIdToLaravel',
        type: 'POST',
        data: datos,
    }).done(function(data){

    }).fail(function(data){
        console.log("Fallo" + data);
    });

	//Header con Scroll 
    $('#navbarra').scrollToFixed();
    //$('.navbar').scrollToFixed();

  	/*$('.navbar').scrollToFixed({
        preFixed: function() { 
        	//$(this).addClass('navFixed');
        	//$('#menu-top').children('li').children('a').addClass('enlaceFixed');
        	
        }, 
        postFixed: function() { 
        	//$(this).removeClass('navFixed');
			//$('#menu-top').children('li').children('a').removeClass('enlaceFixed');

        }
    }); */
    // mostrarMensajePorPrograma("CREA","Informamos que la subsanación de sesiones de clase del mes de Agosto cierran el día siete (07) de Septiembre a las 10:00 AM.");
    
    // mostrarMensajePorPrograma("CREA","Debido a la migración.<br>El registro de asistencias está abierto para <b>todo el mes de Octubre.</b> ");
    //mostrarMensajePorPrograma("CREA","A partir del día 20 al 23 de Septiembre tendremos ventana de mantenimiento y el sistema no estará disponible.<br> Por esta razón el registro de asistencias está abierto para <b>todo el mes de Septiembre.</b> ");
    // mostrarMensajePorPrograma("CREA","Estamos en tiempos de finalización de contratos y queremos compartir el nuevo proceso de <a href='https://pandora.idartes.gov.co/modpazysalvo/public/crear-solicitud' target='_blank'>generación de paz y salvos virtual.</a><br><br>Ahora podrá radicar su paz y salvo desde el día de terminación de su contrato y hacerle seguimiento a su solicitud para todas las áreas que intervienen en la firma y vistos bueno.<br><br>Recuerde que este proceso es requerido para el último pago.<br><br>Lo invitamos a revisar el siguiente link video tutorial, en donde se explica cada uno de los pasos a seguir para obtener el paz y salvo en linea!<br><a href='https://www.youtube.com/watch?v=pt2kHWZ-DPk&feature=youtu.be'>https://www.youtube.com/watch?v=pt2kHWZ-DPk&feature=youtu.be</a><br><br>Para soporte de esta funcinalidad comuniquese con el área de tecnología a la extensión <b>4309</b> o al correo <a href='#'>soportesistemas@idartes.gov.co</a>");
    

     // mostrarMensajePorPrograma("NIDOS","El día 20 de Septiembre tendremos una ventana de mantenimiento y el sistema puede presentar intermitencias.");


     function mostrarMensajePorPrograma(programa,mensaje){
        var datos = {
            funcion : 'consultarProgramaUsuario',
            p1: $("#id_usuario").val()
        };
        $.ajax({
            url: url_service,
            type: 'POST',
            data: datos,
            async: true
        }).done(function(data){
            if(data == 'PERFIL CREA' || data == 'PERFIL TRANSVERSAL' || data == 'PERFIL NIDOS'){
                mostrarAlerta("warning","IMPORTANTE",mensaje,null,100000);
            }else{
                console.log("OTRO PERFIL " + data);
            }
        }).fail(function(result){
          console.log("Error: "+result);
      });
        
    }

});