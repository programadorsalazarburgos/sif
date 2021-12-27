var url_controller = "../../src/Administracion/Controlador/AdministracionController.php";
$(document).ready(function(){
    var session;
    var nombresregex = /(?=.*\d)(?=.*[aA-zZ]).{8,}/;

    $.validator.addMethod("validPassword", function( value, element ) {
        return this.optional( element ) || nombresregex.test( value );
    }); 

    $.validator.addMethod("validActualPass", function( value, element ) {
        return this.optional( element ) || value=='1';
    }); 

    var validator = $("#change-password-form").validate({
        rules:
        {
            TB_Old_Password: {
                required: true,
                equals: true
            },
            TB_Pass_Actual_Hidden: {
                required: true,
                validActualPass: true
            },
            TB_New_Password: {
                required: true,
                validPassword: true,
                maxlength: 20,
                minlength: 8
            },
            TB_Retype_Password: {
                required: true,
                validPassword: true,
                maxlength: 20,
                minlength: 8,
                equalTo: "#TB_New_Password"
            }
        },
        messages:
        { 
            TB_Old_Password: {
                required: "Por favor ingrese su contraseña actual.",
                equalTo: "#TB_Pass_Actual_Hidden"
            },
            TB_Pass_Actual_Hidden: {
                validActualPass: ""
            },
            TB_New_Password: {
                required: "Por favor ingrese su nueva contraseña.",
                validPassword: "La contraseña no cumple con las condiciones mínimas de seguridad.",
                maxlength: "Por favor no ingrese más de 20 dígitos.",
                minlength: "Su contraseña debe contener al menos 8 caracteres."
            },
            TB_Retype_Password: {
                required: "Por favor ingrese de nuevo su nueva contraseña.",
                validPassword: "La contraseña no cumple con las condiciones mínimas de seguridad.",
                maxlength: "Por favor no ingrese más de 20 dígitos.",
                minlength: "Su contraseña debe contener al menos 8 caracteres.",
                equalTo: "La nueva contraseña no coincide"
            }
        },
        errorPlacement : function(error, element) {
            $(element).closest('.form-group').find('.help-block').html(error.html());
        },
        highlight : function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            $(element).closest('.form-group').find('.help-block').html('');
        }
    });

    $("#TB_Old_Password").on("blur", function(){
        if($(this).val() != ""){
            $.get('../../Controlador/Consultas/getSession.php', {requested: 'session_username'}, function (data) {
                session = data;
                var datos = {
                    'funcion': 'verificaPasswordActual',
                    p1: session,
                    p2: $("#TB_Old_Password").val()
                };
                $.ajax({
                    url: url_controller,
                    type: 'POST',
                    data: datos,
                    cache: false,
                    async: false,
                    dataType: 'json',
                    success: function(datos)
                    {
                        $("#TB_Pass_Actual_Hidden").val(datos);
                        $("#change-password-form").validate().element("#TB_Old_Password");
                    }
                });
            }, 'json');
        }
    });
    
    $("#change-password-form").on('submit', function(e){
        e.preventDefault();
        if ($(this).valid()) {
            var new_password = $("#TB_New_Password").val();
            var datos = {
                'funcion': 'actualizarPassword',
                p1:{
                    'id_persona': session,
                    'password':new_password,
                    'id_session': session
                }
            };
            $.ajax({
                async : false,
                url: url_controller,
                type: 'POST',
                dataType: 'html',
                data: datos,
                success: function(retorno)
                {
                    if (retorno == 1) {
                        parent.mostrarAlerta("success", "Su contraseña ha sido actualizada.");
                    }
                    else{
                        if(retorno == '-1'){
                            parent.mostrarAlerta("warning", "La NUEVA contraseña no puede ser igual a la ACTUAL.");
                        }else{
                           parent.mostrarAlerta("error","Algo salió mal, por favor intente en un momento.");
                       }
                   }
               }
           });
        }
    });

    $(".mostrar-pass").on('mouseover', function(){
      var obj = document.getElementById($(this).data('input-id'));
      obj.type = "text";
  });

    $(".mostrar-pass").on('mouseout', function(){
      var obj = document.getElementById($(this).data('input-id'));
      obj.type = "password";
  });

    jQuery.validator.addMethod("equals", function(value, element){
        if ($("#TB_Pass_Actual_Hidden").val() == "1") {
            return true;
        } else {
            return false;
        };
    }, "Contraseña actual Incorrecta"); 
});