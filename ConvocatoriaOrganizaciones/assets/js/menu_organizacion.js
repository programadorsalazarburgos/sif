$(document).ready(function(){
    var Nombre_Usuario = "";
    var Password_Anterior = "";
    var NIT = "";
    var Bandera_Password = "";
    var Bandera_Habilitantes = "";
    var Bandera_Propuesta = "";
    var Tipo = "";
    $.ajax({
        url: 'controlador/C_Obtener_Banderas.php',
        type: 'POST',
        cache: false,
        async: false,
        dataType: 'json',
        success: function(data, textStatus, jqXHR)
        {
            $.each(data, function(i) 
            {
                Id_Usuario = data[i].PK_Id_Usuario;
                Nombre_Usuario = data[i].VC_Nombre_Usuario;
                Password_Anterior = data[i].VC_Password;
                NIT = data[i].VC_NIT;
                Bandera_Password = data[i].IN_Bandera_Pass;
                Bandera_Habilitantes = data[i].IN_Bandera_Habilitantes;
                Bandera_Propuesta = data[i].IN_Bandera_Propuesta;
                Tipo = data[i].IN_Tipo;
            });
        }   
    });
    if (Tipo == "1") {
        $("#consultar_propuestas").css('background-color','#38a099');
        $("#consultar_propuestas").css('color','white');
        $("#title_convocatoria").html("<h1>Convocatoria 2018</h1>");
        $(".progress").hide();
        $("#timeline").hide();
        $("#div_invitacion").hide();
        $("#div_password").hide();
        $("#div_subir_habilitantes").hide();
        $("#div_propuesta").hide();
        $("#div_consulta").show();
        $("#subsanaciones").hide();
        $("#subsanaciones2").hide();
    }
    else{
        $("#invitacion").css('background-color','#38a099');
        $("#invitacion").css('color','white');
        $("#title_convocatoria").html("<h1>Paso a Paso Convocatoria 2018</h1><center><p>Debe cambiar la contraseña que le fue asignada para poder acceder a las opciones dispuestas para la presentación de la propuesta.</p></center>");
        $(".progress").show();
        $("#timeline").show();
        $("#div_password").show();
        $("#div_invitacion").show();
        $("#div_subir_habilitantes").show();
        $("#div_propuesta").show();
        $("#div_consulta").hide();
        $("#subsanaciones").hide();
        $("#subsanaciones2").hide();
    }

    if (Bandera_Password == "0") {
        $(".progress-bar").css('width', '0%');
        $(".progress-bar").html("0 % Completado");
        $("#invitación").attr('disabled', true);
        $("#subir_habilitantes").attr('disabled', true);
        $("#propuesta").attr('disabled', true);
        $("#reporte").attr('disabled', true);
    }
    else{
        $("#password").css('background-color','#1f9eba');
        $("#password").css('color','white');
        $(".progress-bar").css('width', '34%');
        $(".progress-bar").html("Contraseña cambiada");
        $("#invitación").attr('disabled', false);
        $("#subir_habilitantes").attr('disabled', false);
        $("#propuesta").attr('disabled', false);
        $("#reporte").attr('disabled', false);
    }

    if (Bandera_Habilitantes == "0") {
        $("#reporte_habilitantes").attr('disabled', true);
        $("#propuesta").attr('disabled', true);
    }
    else{
        $("#subir_habilitantes").css('background-color','#1f9eba');
        $("#subir_habilitantes").css('color','white');
        $(".progress-bar").css('width', '71.5%');
        $(".progress-bar").html("Documentos de Idoneidad Subidos");
        $("#reporte_habilitantes").attr('disabled', false);
        $("#propuesta").attr('disabled', false);
    }

    if (Bandera_Propuesta == "0") {
        $("#reporte_propuesta").attr('disabled', true);
    }
    else{
        $("#propuesta").css('background-color','#1f9eba');
        $("#propuesta").css('color','white');
        $(".progress-bar").css('width', '100%');
        $(".progress-bar").html("Propuesta Diligenciada");
        $("#reporte_propuesta").attr('disabled', false);
    }

        //HABILITAR SUBIDA DE DOCUMENTOS PARA ESTOS USUARIOS -BATUTA
        if (Id_Usuario =="16" || Id_Usuario =="2"){
            $("#habilitantes").show();
            $("#div_de_propuesta").show();
        }
        else{
            $("#habilitantes").hide();
        }

        $("#cambiar_password, #password").on('click', function(){
            $("#modal_cambiar_password").modal('show');     
        });

        $("#subir_habilitantes").on('click', function(){
            bootbox.alert("<strong>PARA TENER EN CUENTA:</strong><br><br>Si ya ha subido los Documentos de Idoneidad previamente, estos serán <strong>REEMPLAZADOS</strong> por los que decida adjuntar al pulsar el boton <strong>ENVIAR DOCUMENTOS</strong><br><br>Recuerde que los archivos enviados serán objeto de analisis y serán utilizados única y exclusivamente para evaluar la idoneidad de su organización.", function(){
                $("#modal_subir_habilitantes").modal('show');
                $("#archivos_adjuntos_habilitantes").html('<strong>No se han seleccionado archivos</strong>');      
            });
        });

        $("#subir_subsanaciones").on('click', function(){
            bootbox.alert("<strong>PARA TENER EN CUENTA:</strong><br><br>Si ya ha subido el(los) Documento(s) de Subsanacion previamente, estos serán <strong>REEMPLAZADOS</strong> por los que decida adjuntar al pulsar el boton <strong>ENVIAR SUBSANACIONES</strong><br><br>Recuerde que los archivos enviados serán objeto de analisis y serán utilizados única y exclusivamente para evaluación de su Organización.", function(){
                $("#modal_subir_subsanaciones").modal('show');
                $("#archivos_adjuntos_subsanaciones").html('<strong>No se han seleccionado archivos</strong>');      
            });
        });

        $("#subir_subsanaciones2").on('click', function(){
            bootbox.alert("<strong>PARA TENER EN CUENTA:</strong><br><br>Si ya ha subido el(los) Documento(s) de SEGUNDA Subsanacion previamente, estos serán <strong>REEMPLAZADOS</strong> por los que decida adjuntar al pulsar el boton <strong>ENVIAR SEGUNDAS SUBSANACIONES</strong><br><br>Recuerde que los archivos enviados serán objeto de analisis y serán utilizados única y exclusivamente para evaluación de su Organización.", function(){
                $("#modal_subir_subsanaciones2").modal('show');
                $("#archivos_adjuntos_subsanaciones2").html('<strong>No se han seleccionado archivos</strong>');      
            });
        });

        $("#propuesta").on('click', function(){
            bootbox.alert("<strong>PARA TENER EN CUENTA:</strong><br><br>Si ya ha enviado la propuesta anteriormente esta se reemplazará por los nuevos datos que envíe ahora.<br><br>La propuesta que debe diligenciar le solicitará bastante información y tal vez no la tenga toda inmediatamente, por ello se aconseja que revise y conozca los campos o datos que se solicitan en la invitación, así como los formatos que aparecen en el <strong>NUMERAL 11 y 12</strong>, identifique la información que le hace falta y una vez tenga toda la información inicie a diligenciarla de principio a fin...", function(){
                var location = window.location.href;
                if(location.includes("localhost") == true){
                    window.location.href = "http://localhost/sif/ConvocatoriaOrganizaciones/propuesta.php";
                }
                else{
                    window.location.href = "https://sif.idartes.gov.co/sif/ConvocatoriaOrganizaciones/propuesta.php";   
                }
            });     
        });
        //Aquí se debe MODIFICAR la funcion ¨prepareUploadSubsanaciones¨ por ¨prepareUpload¨ cuando se este trabajando la subida de habilitantes o la de subsanaciones o subsanaciones2.
        $('input[type=file]').on('change', prepareUpload);

        $("#cerrar_sesion").on('click', function(){
            $.ajax({
                url: 'controlador/C_Cerrar_Sesion.php',
                type: 'POST',
                cache: false,
                async: false,
                dataType: 'html',
                success: function(data, textStatus, jqXHR)
                {
                    var location = window.location.href;
                    if(location.includes("localhost") == true){
                        window.location.href = "http://localhost/sif/ConvocatoriaOrganizaciones";
                    }
                    else{
                        window.location.href = "https://sif.idartes.gov.co/sif/ConvocatoriaOrganizaciones";
                    }   
                }
            });
        });

        $("#consultar_propuestas").on('click', function(){
            var location = window.location.href;
            if(location.includes("localhost") == true){
                window.location.href = "http://localhost/sif/ConvocatoriaOrganizaciones/ConsultarConvocatoria.php";
            }
            else{
                window.location.href = "https://sif.idartes.gov.co/sif/ConvocatoriaOrganizaciones/ConsultarConvocatoria.php";
            }
        });

        $("#invitacion").on('click', function(){
            window.open("INVITACION ORGANIZACIONES.pdf");
            //$("#modal_invitacion").modal("show");
        });

        $("#reporte_propuesta").on('click', function(){
            window.open("controlador/C_PDF_Propuesta.php");
        });
        $("#reporte_habilitantes").on('click', function(){
            window.open("controlador/C_PDF_Habilitantes.php");
        });
        $("#reporte_subsanaciones").on('click', function(){
            window.open("controlador/C_PDF_Subsanaciones.php");
        });
        $("#reporte_subsanaciones2").on('click', function(){
            window.open("controlador/C_PDF_Subsanaciones2.php");
        });

        $("#password_anterior, #password_nueva").on('keyup', function(){
            $("#div_modal_alerta").hide();
        });

        $("#FORM_CAMBIAR_PASSWORD").on('submit', function(event){
            event.preventDefault();
            var password_uno = CryptoJS.MD5($("#password_anterior").val())
            var password_nueva = $("#password_nueva").val();

            if (password_uno != Password_Anterior) {
                $("#div_modal_alerta").show();
            }else{
                $.ajax({
                    url: 'controlador/C_Cambiar_Password.php',
                    type: 'POST',
                    cache: false,
                    async: false,
                    data: {'id_usuario':Id_Usuario, 'password':password_nueva},
                    dataType: 'html',
                    success: function(data, textStatus, jqXHR)
                    {
                        alert("La contraseña se cambió exitosamente!");
                        location.reload(true);
                        
                    }   
                });//Fin Ajax Cambiar_Password
            }
            /**/
        });

        $("#FORM_HABILITANTES").on('submit', function(event){
            event.preventDefault();
            bootbox.confirm({
                title: "Se van a enviar los siguientes documentos, está seguro?",
                message: $('#archivos_adjuntos_habilitantes').html(),
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancelar'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirmar'
                    }
                },
                callback: function (result) {
                    if(result == true){
                        uploadFiles(event);         
                    }else{
                    }   
                }
            });
            //uploadFiles(event);
        });//FIN SUBMIT FORM HABILITANTES

        $("#FORM_SUBSANACIONES").on('submit', function(event){
            event.preventDefault();
            bootbox.confirm({
                title: "Se van a enviar los siguientes documentos, está seguro?",
                message: $('#archivos_adjuntos_subsanaciones').html(),
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancelar'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirmar'
                    }
                },
                callback: function (result) {
                    if(result == true){
                        uploadFilesSubsanaciones(event);         
                    }else{
                    }   
                }
            });
            //uploadFiles(event);
        });//FIN SUBMIT FORM SUBSANACIONES

        $("#FORM_SUBSANACIONES2").on('submit', function(event){
            event.preventDefault();
            bootbox.confirm({
                title: "Se van a enviar los siguientes documentos, está seguro?",
                message: $('#archivos_adjuntos_subsanaciones2').html(),
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancelar'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirmar'
                    }
                },
                callback: function (result) {
                    if(result == true){
                        uploadFilesSubsanacionesDos(event);         
                    }else{
                    }   
                }
            });
            //uploadFiles(event);
        });//FIN SUBMIT FORM SEGUNDA SUBSANACION

    });

// PREPARE UPLOAD DE HABILITANTES
// Grab the files and set them to our variable
function prepareUpload(event)
{
    files = event.target.files;
    document.getElementById('archivos_adjuntos_habilitantes').innerHTML = "";
    newp = document.createElement('p');
    newp.style.cssText = 'font-size:14px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
    newp.innerHTML= "<strong>Estos son TODOS los archivos que se van a enviar:</strong>";
    document.getElementById('archivos_adjuntos_habilitantes').appendChild(newp);
    $.each(files, function(index, value) {
        newp = document.createElement('p');
        newp.style.cssText = 'font-size:12px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
        newp.innerHTML= files[index]["name"];
        document.getElementById('archivos_adjuntos_habilitantes').appendChild(newp);
            //console.log(files[index]["name"]);
        });
}

//PREPARE UPLOAD DE SUBSANACIONES
// Grab the files and set them to our variable
function prepareUploadSubsanaciones(event)
{
    files = event.target.files;
    document.getElementById('archivos_adjuntos_subsanaciones').innerHTML = "";
    newp = document.createElement('p');
    newp.style.cssText = 'font-size:14px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
    newp.innerHTML= "<strong>Estos son TODOS los archivos que se van a enviar:</strong>";
    document.getElementById('archivos_adjuntos_subsanaciones').appendChild(newp);
    $.each(files, function(index, value) {
        newp = document.createElement('p');
        newp.style.cssText = 'font-size:12px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
        newp.innerHTML= files[index]["name"];
        document.getElementById('archivos_adjuntos_subsanaciones').appendChild(newp);
            //console.log(files[index]["name"]);
        });
}

//PREPARE UPLOAD DE SUBSANACIONES 2
// Grab the files and set them to our variable
function prepareUploadSubsanacionesDos(event)
{
    files = event.target.files;
    document.getElementById('archivos_adjuntos_subsanaciones2').innerHTML = "";
    newp = document.createElement('p');
    newp.style.cssText = 'font-size:14px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
    newp.innerHTML= "<strong>Estos son TODOS los archivos que se van a enviar:</strong>";
    document.getElementById('archivos_adjuntos_subsanaciones2').appendChild(newp);
    $.each(files, function(index, value) {
        newp = document.createElement('p');
        newp.style.cssText = 'font-size:12px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
        newp.innerHTML= files[index]["name"];
        document.getElementById('archivos_adjuntos_subsanaciones2').appendChild(newp);
            //console.log(files[index]["name"]);
        });
}


//UPLOAD FILES HABILITANTES
function uploadFiles(event)
{
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        $.each(files, function(key, value)
        {
            data.append(key, value);
        });
        
        //authWindow = window.open('about:blank');
        $.ajax({
            url: 'subirHabilitantes.php?files',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'html',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend: function(){
                parent.mostrarCargando();
            },
            success: function(data)
            {
                    // Success so call function to process the form
                    //submitForm(event, data);
                    parent.cerrarCargando();
                    $("#modal_subir_habilitantes").modal('hide');
                    bootbox.alert("<strong>DOCUMENTOS ENVIADOS</strong><br><br>Por favor imprima o guarde el siguiente reporte, deberá <strong>radicarlo FIRMADO cuando se le indique.</strong>", function(){
                        location.reload(true);
                        $("#reporte_habilitantes").click();        
                    });
                    //window.location.replace("controlador/C_PDF_Habilitantes.php");
                }
            });
    }//FIN FUNCION UPLOADFILES HABILITANTES


//UPLOAD FILES SUBSANACIONES
function uploadFilesSubsanaciones(event)
{
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        $.each(files, function(key, value)
        {
            data.append(key, value);
        });
        
        //authWindow = window.open('about:blank');
        $.ajax({
            url: 'subirSubsanaciones.php?files',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'html',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend: function(){
                parent.mostrarCargando();
            },
            success: function(data)
            {
                    // Success so call function to process the form
                    //submitForm(event, data);
                    parent.cerrarCargando();
                    $("#modal_subir_subsanaciones").modal('hide');
                    bootbox.alert("<strong>SUBSANACIONES ENVIADAS</strong><br><br>Por favor imprima o guarde el siguiente reporte, <strong>En el aparecen relacionados los documentos que fueron enviados y será el soporte para su organización.</strong>", function(){
                        location.reload(true);
                        $("#reporte_subsanaciones").click();        
                    });
                    //window.location.replace("controlador/C_PDF_Habilitantes.php");
                }
            });
    }//FIN FUNCION UPLOADFILES SUBSANACIONES

    //UPLOAD FILES SEGUNDAS SUBSANACIONES
    function uploadFilesSubsanacionesDos(event)
    {
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        $.each(files, function(key, value)
        {
            data.append(key, value);
        });
        
        //authWindow = window.open('about:blank');
        $.ajax({
            url: 'subirSegundaSubsanacion.php?files',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'html',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend: function(){
                parent.mostrarCargando();
            },
            success: function(data)
            {
                    // Success so call function to process the form
                    //submitForm(event, data);
                    parent.cerrarCargando();
                    $("#modal_subir_subsanaciones2").modal('hide');
                    bootbox.alert("<strong>SUBSANACIONES ENVIADAS</strong><br><br>Por favor imprima o guarde el siguiente reporte, <strong>En el aparecen relacionados los documentos que fueron enviados y será el soporte para su organización.</strong>", function(){
                        location.reload(true);
                        $("#reporte_subsanaciones2").click();        
                    });
                    //window.location.replace("controlador/C_PDF_Habilitantes.php");
                }
            });
    }//FIN FUNCION UPLOADFILES SEGUNDAS SUBSANACIONES