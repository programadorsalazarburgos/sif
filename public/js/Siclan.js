/*$(function() {

    $('#side-menu').metisMenu();

});*/

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
var url_service = '../src/Administracion/Controlador/AparienciaController.php'; 
$(function() {


    //Codigo para Menu Responsive
    var menuAbierto=false;
    $("#boton_menu_inicio").click(function(e){
        //alert("h");
        if(!menuAbierto){
            $("#contenedorMenu").animate({
                left: '0'
            });
            equisMenu();
            menuAbierto=true;
        }
        else{
            $("#contenedorMenu").animate({
                left: '-100%'
            }); 
            lineasMenu();
            menuAbierto=false;
        }
    });

    $("#menu-top li a").click(function(e){
        if($(window).outerWidth()<=768){            
            $("#contenedorMenu").animate({
                left: '-100%'
            });     
        }
        lineasMenu();
        menuAbierto=false;  
    }); 

    function equisMenu(){
        $("#boton_menu_inicio").animate({
            'border-radius': '50%'
        });
        $('#boton_menu_inicio .linea_inicio:nth-child(1)').animate({  textIndent: -45 }, {
            step: function(now,fx) {
              $(this).css({'-webkit-transform': 'translateY(9px) rotate('+now+'deg)'}); 
            },
            duration:'fast'
        },'linear');
        $('#boton_menu_inicio .linea_inicio:nth-child(2)').animate({  textIndent: 0 }, {
            step: function(now,fx) {
              $(this).css({'opacity': now}); 
            },
            duration:'fast'
        },'linear');        
        $('#boton_menu_inicio .linea_inicio:nth-child(3)').animate({  textIndent: 45 }, {
            step: function(now,fx) {
              $(this).css({'-webkit-transform': 'translateY(-9px) rotate('+now+'deg)'}); 
            },
            duration:'fast'
        },'linear');             
    }
    function lineasMenu(){
        $("#boton_menu_inicio").animate({
            'border-radius': '4px'
        });     
        $('#boton_menu_inicio .linea_inicio:nth-child(1)').animate({  textIndent: 0 }, {
            step: function(now,fx) {
              $(this).css({'-webkit-transform': 'translateY(0px) rotate('+now+'deg)'}); 
            },
            duration:'fast'
        },'linear');  
         
        $('#boton_menu_inicio .linea_inicio:nth-child(3)').animate({  textIndent: 0 }, {
            step: function(now,fx) {
              $(this).css({'-webkit-transform': 'translateY(0px) rotate('+now+'deg)'}); 
            },
            duration:'fast'
        },'linear');   
        $('#boton_menu_inicio .linea_inicio:nth-child(2)').animate({  textIndent: 1 }, {
            step: function(now,fx) {
              $(this).css({'opacity': now}); 
            },
            duration:'fast'
        },'linear');         
    }



    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }

    function validarEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    $("#olvide-password").click(function(e){
       
        var username=$("#username").val(); 
        if(username!=""){

            var datos = {
                funcion : 'getDatosPorNombre',
                p1: $("#username").val()
            };
            $.ajax({
                url: url_service,
                type: 'POST',
                data: datos,
                success: function(data){  
                    var datos=JSON.parse(data);
                    //console.log(datos.email); 

                    if(validarEmail(datos.email)){      
                        $('#modal-password').modal('show'); 
                        $("#email").val(datos.email);       
                        $("#id").val(datos.id); 
                    }
                    else{
                        alertify.alert("Mensaje del Sistema","Por favor escriba una solicitud al correo sif@idartes.gov.co, su usuario no tiene un correo válido para recuperación  de contraseña");
                        $('#modal-password').modal('hide');
                    }
                    
                }, 
                async: false 
            });          
        }
        else{
            alertify.alert("Mensaje del Sistema","Por favor escriba una solicitud al correo sif@idartes.gov.co, o indique el nombre de usuario en la ventana de login para cargar su correo");
            $('#modal-password').modal('hide');

        }
    
    });

    $("#enviar-token").click(function(e){
        var email = $("#email").val();  
        var id = $("#id").val();  
        var datos = {
            funcion : 'enviarCorreoToken',
            p1: email,
            p2: id
        };
        $.ajax({
            url: url_service,
            type: 'POST',
            data: datos,
            success: function(data){ 
                console.log(data);   
                if(data){ 
                    $("#contenedor-token").removeClass("hidden");
                    $("#contenedor-token").addClass("visible");     
                }
                else{
                    alertify.alert("Mensaje del Sistema","No se pudo enviar el correo, por favor intente más tarde o envie la solicitud al correo sif@idartes.gov.co");
                    $('#modal-password').modal('hide'); 
                } 
                
            }, 
            async: false 
        });   


    });

    $("#verificar-token").click(function(e){
        var tokenUsuario = $("#token").val();  
        if(tokenUsuario==''){
            alertify.alert("Mensaje del Sistema","Por favor digite el código de verificación enviado a su correo");
            return false;
        }
        else{
            var datos = {
                funcion : 'getDatosPorNombre',
                p1: $("#username").val()
            };
            $.ajax({
                url: url_service,
                type: 'POST',
                data: datos,
                success: function(data){  
                    var datos=JSON.parse(data);
                    console.log(datos.email); 

                    if(datos.token!=""){

                        if(tokenUsuario==datos.token){
                            $("#contenedor-password").removeClass("hidden");
                            $("#contenedor-password").addClass("visible");                               
                        }
                        else{
                            alertify.alert("Mensaje del Sistema","El código de verificación digitado no coincide, por favor verifique e ingrese de nuevo");                            

                        }
                    }
                    else{ 
                        alertify.alert("Mensaje del Sistema","No se ha generado un código de verificación para restablecer contraseña, por favor realice el proceso de nuevo");
                        $('#modal-password').modal('hide');
                    }
                    
                }, 
                async: false 
            });            
        }
    });
    $("#cambiar-password").click(function(e){
        var password=$("#password-cambiar").val(); 
        var passwordConfirmacion=$("#password-confirmacion").val();
        if (password == 0)
        {
            alertify.alert("Mensaje del Sistema","POR FAVOR INGRESE SU NUEVA CONTRASEÑA.");
            password="";
            $("#password-cambiar").focus();
            return false;
        }


        //*******************************************************
        if ( password.length < 6 ) {
            alertify.alert("Mensaje del Sistema","INGRESE EL MINIMO DE DIGITOS EN LA CONTRASEÑA (MIN. 6 CARACTERES)");
            $("#password-cambiar").focus();
            return false;
        }

        //*******************************************************
        if (passwordConfirmacion == 0)
        {
            alertify.alert("Mensaje del Sistema","DIGITE NUEVAMENTE LA NUEVA CONTRASEÑA.");
            passwordConfirmacion="";
            $("#password-confirmacion").focus();
            return false;
        }

        //*******************************************************
        if ( passwordConfirmacion.length < 6 ) {
            alertify.alert("Mensaje del Sistema","INGRESE EL MINIMO DE DIGITOS EN LA CONTRASEÑA (MIN. 6 CARACTERES)");
            $("#password-confirmacion").focus();
            return false;
        }


        //*******************************************************
        if (password != passwordConfirmacion)
        {
            alertify.alert("Mensaje del Sistema","LAS CONTRASEÑAS INGRESADAS NO COINCIDEN, POR FAVOR ASEGURESE QUE SEAN LA MISMA CONTRASEÑA.");
            $("#password-confirmacion").focus();
            return false;
        }  
 
        var id = $("#id").val();  
        var datos = {
            funcion : 'cambiarPassword',
            p1: password,
            p2: id
        };
        $.ajax({
            url: url_service,
            type: 'POST',
            data: datos,
            success: function(data){ 
                console.log(data);   
                if(data){ 
                    alertify.alert("Mensaje del Sistema","La Contraseña ha sido actualizada, por favor inicie sesión");
                    $('#modal-password').modal('hide');    
                }
                else{
                    alertify.alert("Mensaje del Sistema","No se Pudo Cambiar la Contraseña, por favor intente de nuevo");

                }  
                
            }, 
            async: false 
        });        

    });
});
