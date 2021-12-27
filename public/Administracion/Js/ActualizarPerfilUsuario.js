var url_controller = "../../src/Administracion/Controlador/AdministracionController.php"; 
var fotoGuardada, nuevaFoto;
var firmaEscaneada, firma, firma_base64;

document.addEventListener('DOMContentLoaded', () => {

    // Input File
    const inputImage = document.querySelector('#TX_Firma_Usuario');
    // Nodo donde estará el editor_foto_firma
    const toor = document.querySelector('#editor_foto_firma');
    // El canvas donde se mostrará la previa
    const miCanvas = document.querySelector('#preview_foto_firma');
    // Contexto del canvas
    const contexto = miCanvas.getContext('2d');
    // Ruta de la imagen seleccionada
    let urlImage = undefined;
    // Evento disparado cuando se adjunte una imagen
    inputImage.addEventListener('change', abrirEditor, false);

    /**
     * Método que abre el editor_foto_firma con la imagen seleccionada
     */
    function abrirEditor(e) {
        // Obtiene la imagen
        urlImage = URL.createObjectURL(e.target.files[0]);

        // Borra editor_foto_firma en caso que existiera una imagen previa
        editor_foto_firma.innerHTML = '';
        let cropprImg = document.createElement('img');
        cropprImg.setAttribute('id', 'croppr');
        editor_foto_firma.appendChild(cropprImg);

        // Limpia la previa en caso que existiera algún elemento previo
        contexto.clearRect(0, 0, miCanvas.width, miCanvas.height);

        // Envia la imagen al editor_foto_firma para su recorte
        document.querySelector('#croppr').setAttribute('src', urlImage);

        // Crea el editor_foto_firma
        new Croppr('#croppr', {
            aspectRatio: 0,
            startSize: [70, 70],
            onCropEnd: recortarImagen
        })
    }

    /**
     * Método que recorta la imagen con las coordenadas proporcionadas con croppr.js
     */
    function recortarImagen(data) {
        // Variables
        const inicioX = data.x;
        const inicioY = data.y;
        const nuevoAncho = data.width;
        const nuevaAltura = data.height;
        const zoom = 1;
        let imagenEn64 = '';
        // La imprimo
        miCanvas.width = nuevoAncho;
        miCanvas.height = nuevaAltura;
        // La declaro
        let miNuevaImagenTemp = new Image();
        // Cuando la imagen se carge se procederá al recorte
        miNuevaImagenTemp.onload = function() {
            // Se recorta
            contexto.drawImage(miNuevaImagenTemp, inicioX, inicioY, nuevoAncho * zoom, nuevaAltura * zoom, 0, 0, nuevoAncho, nuevaAltura);
            // Se transforma a base64
            imagenEn64 = miCanvas.toDataURL("image/jpeg");
            // Mostramos el código generado
            // document.querySelector('#foto_firma_base64').textContent = imagenEn64;
            foto_firma_base64 = imagenEn64;
            $("#firma").val(foto_firma_base64);
            
            $("#div_bt_guardar_firma").show();
        }
        // Proporciona la imagen cruda, sin editarla por ahora
        miNuevaImagenTemp.src = urlImage;
       
    }

  });


$(document).ready(function(){
    //get session data
    var session;

    $(".readonly").on('keydown paste', function(e){
        e.preventDefault();
    });
    $("#div_bt_guardar_firma").hide();
    $("#TB_FNacimiento").datepicker({
        format: 'yyyy/mm/dd'
    });

    $("#TX_Foto_Perfil").filestyle({
        htmlIcon: '<i class="fas fa-folder-open"></i>',
        btnClass: "btn-primary",
        text: "Seleccionar archivo",
    });

    $("#TX_Firma_Usuario").filestyle({
        htmlIcon: '<i class="fas fa-folder-open"></i>',
        btnClass: "btn-primary",
        text: "Seleccionar archivo",
    });


    $('#SL_TIPO_IDENTIFICACION').html(parent.getOptionsTiposDeIdentificacion());
    $('#SL_TIPO_IDENTIFICACION').selectpicker('refresh');
    $('#SL_SEXO').html(parent.getOptionsGenero());
    $('#SL_SEXO').selectpicker('refresh');

    $('.mayuscula').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });
    
    var nombresregex = /^[a-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i;

    $.validator.addMethod("validname", function( value, element ) {
        return this.optional( element ) || nombresregex.test( value );
    }); 

    // valid email pattern
    var eregex = /^([a-zA-Z0-9_\\.\\-\\+])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
    
    $.validator.addMethod("validemail", function( value, element ) {
        return this.optional( element ) || eregex.test( value );
    });

    $.validator.addMethod('filesize', function (value, element, arg) {
        var file = element.files[0];
        if(file != undefined){
            if(file.size<=arg){
       return true;
            }else{
       return false;
            }
        }else{
            return true;
        }
    });

    var numeroidentifiacionregex = /^(?=.*[0-9])([a-zA-Z0-9]+)$/;
    $.validator.addMethod("validIdentification", function( value, element ) {
        return this.optional( element ) || numeroidentifiacionregex.test( value );
    });

    var numeroregex = /^([0-9]+)$/;
    $.validator.addMethod("validNumber", function( value, element ) {
        return this.optional( element ) || numeroregex.test( value );
    });

    var ruleSet1 = {
        required: true,
        validname: true,
        minlength: 3,
        maxlength: 50
    };
    var ruleSet2 = {
        required: false,
        validname: true,
        minlength: 3,
        maxlength: 50
    };

    var validator = $("#update-form").validate({
        rules:
        {
            var_id:{
       required: true
            },
            SL_PERFIL: {
       required: true
            },
            SL_TIPO_IDENTIFICACION: {
       required: true
            },
            TB_NIdentificacion: {
       required: true,
       validIdentification: true,
       maxlength: 20
            },
            TB_PNombre: ruleSet1,
            TB_SNombre: ruleSet2,
            TB_PApellido: ruleSet1,
            TB_SApellido: ruleSet2,
            TB_FNacimiento: {
       required: true
            },
            SL_SEXO:{
       required: true
            },
            TB_Celular: {
       required: true,
       validNumber: true,
       minlength: 7,
       maxlength: 10
            },
            TB_Correo: {
       required: true,
       validemail: true,
       maxlength: 50
            },
            TX_Foto_Perfil: {
       filesize: 5000000
            },
            TX_Firma_Usuario: {
       filesize: 5000000
            },
        },
        messages:
        { 
            var_id: {
       required: "Por favor seleccione un Programa"
            },
            SL_PERFIL: {
       required: "Por favor seleccione un perfil de usuario"
            },
            SL_TIPO_IDENTIFICACION: {
       required: "Por favor seleccione un tipo de identificación"
            },
            TB_NIdentificacion: {
       required: "Por favor ingrese un número de identificación",
       validIdentification: "El número de identificación solo debe contener números y/o letras",
       maxlength: "Por favor no ingrese más de 20 dígitos"
            },
            TB_PNombre: {
       required: "Por favor ingrese el primer nombre",
       validname: "El primer nombre solo debe contener letras y/o espacios",
       minlength: "El primer nombre es muy corto",
       maxlength: "Por favor no ingrese más de 50 caracteres"
            },
            TB_SNombre: {
       validname: "El segundo nombre solo debe contener letras y/o espacios",
       minlength: "El segundo nombre es muy corto",
       maxlength: "Por favor no ingrese más de 50 caracteres"
            },
            TB_PApellido: {
       required: "Por favor ingrese el primer apellido",
       validname: "El primer apellido solo debe contener letras y/o espacios",
       minlength: "El primer apellido es muy corto",
       maxlength: "Por favor no ingrese más de 50 caracteres"
            },
            TB_SApellido: {
       validname: "El segundo apellido solo debe contener letras y/o espacios",
       minlength: "El segundo apellido es muy corto",
       maxlength: "Por favor no ingrese más de 50 caracteres"
            },
            TB_FNacimiento: {
       required: "Por favor indique una fecha de nacimiento"
            },
            SL_SEXO: {
       required: "Por favor seleccione un genero"
            },
            TB_Celular: {
       required: "Por favor ingrese un número de Celular",
       validNumber: "El celular solo debe contener números",
       minlength: "El número de celular es muy corto",
       maxlength: "Por favor no ingrese más de 10 dígitos"
            },
            TB_Correo: {
       required: "Por favor ingrese un Email",
       validemail: "Ingrese un Email válido",
       maxlength: "Por favor no ingrese más de 50 caracteres" 
            },
            TX_Foto_Perfil: {
       filesize: "El tamaño de la imagen no puede superar los 5MB"
            },
            TX_Firma_Usuario: {
       filesize: "El tamaño de la imagen no puede superar los 5MB"
            },
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

    //Consulta la variable de SESION session_username
    $.get('../../Controlador/Consultas/getSession.php', {requested: 'session_username'}, function (data) {
        parent.mostrarCargando();
        session = data;
        var datos = {
            'funcion': 'consultaInformacionUsuarioById',
            p1: session
        };

        $.ajax({
            url: url_controller,
            type: 'POST',
            data: datos,
            cache: false,
            async: true,
            dataType: 'json',
            success: function(datos)
            {
           if(datos != "" && datos != "NULL"){
               $.each(datos, function(i) 
               {
                  $("#TB_NIdentificacion").val(datos[i].VC_Identificacion);
                  $("#SL_TIPO_IDENTIFICACION option").filter(function() { return $(this).val() == datos[i].FK_Tipo_Identificacion; }).prop('selected', true);
                  $("#SL_TIPO_IDENTIFICACION").selectpicker("refresh");
                  $("#TB_PNombre").val(datos[i].VC_Primer_Nombre);
                  $("#TB_SNombre").val(datos[i].VC_Segundo_Nombre);
                  $("#TB_PApellido").val(datos[i].VC_Primer_Apellido);
                  $("#TB_SApellido").val(datos[i].VC_Segundo_Apellido);
                  $("#TB_FNacimiento").val(datos[i].DD_F_Nacimiento);
                  $("#SL_SEXO option").filter(function() { return $(this).val() == datos[i].FK_Id_Genero; }).prop('selected', true).selectpicker("refresh");
                  $("#SL_SEXO").selectpicker("refresh");
                  $("#SL_Localidad option").filter(function() { return $(this).val() == datos[i].FK_Id_Localidad; }).prop('selected', true);
                  $("#TB_Barrio").val(datos[i].VC_Barrio);
                  $("#TB_Direccion").val(datos[i].VC_Direccion);
                  $("#TB_Correo").val(datos[i].VC_Correo);
                  $("#TB_Telefono").val(datos[i].VC_Telefono);
                  $("#TB_Celular").val(datos[i].VC_Celular);
                  if(datos[i].TX_Firma_Escaneada != null){
                      $("#mensaje_firma_actual").html('<br><li>Ésta es su firma actual, si no se visualiza debe cargarla nuevamente siguiendo los 3 pasos.</li>');  
                      $("#img_firma_actual").attr("src",datos[i].TX_Firma_Escaneada);
                  }
                  else{
                      $("#mensaje_firma_actual").html('<br><li>Aún no ha cargado su firma, por favor adjuntela a continuación</li>');  
                  }
                  fotoGuardada =  datos[i].TX_Foto_Perfil;
                  firmaEscaneada =  datos[i].TX_Firma_Escaneada;
                  parent.cerrarCargando();
              });
           }
           else{
              //$("#div_alerta").show();
           }           
       }   
            });
    }, 'json');
    
    $("#update-form").on('submit', function(e){
        e.preventDefault();
        if ($(this).valid()) {
            var file = $("#TX_Foto_Perfil")[0].files[0];
            var reader = new FileReader();
            if(file){
       reader.readAsDataURL(file);
       nuevaFoto = reader.result;
       reader.onload = function (res) {
           guardar(session, res.srcElement.result);
       };
       reader.onerror = function (error) {
           console.log('Error: ', error);
       };
            }else{
       nuevaFoto = fotoGuardada;
       guardar(session, nuevaFoto)
            }
            
        }
    });
   
    function guardar(session,nuevaFoto) {
        //console.log(foto_firma_base64);
        var formulario = $("#update-form").serializeArray();
        formulario.push({
            name:'id_persona',
            value:session
        });
        formulario.push({
            name:'file',
            value:nuevaFoto
        });
        var datos = {
            'funcion': 'actualizarDatosPerfilUsuario',
            p1: formulario
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
           //parent.alertify.alert("Su PERFIL DE USUARIO ha sido actualizado.");
           parent.refreshNombreImagen(session);
           parent.mostrarAlerta('success','Mensaje del sistema','Su PERFIL DE USUARIO ha sido actualizado.');
       }
       else{
           //parent.alertify.alert("Algo salió mal, por favor intente en un momento.");   
           parent.mostrarAlerta('error','Mensaje del sistema','Algo salió mal, por favor intente en un momento.');
       }
            }
        });
    }


$("#form_subir_firma").submit(function(event) {
    event.stopPropagation();
    event.preventDefault();
    var mostrar = "";
    datos = {
      funcion: 'SubirFirmaUsuario',
      p1: {
        'tx_id_persona': session,
        'tx_firma': $("#firma").val()        
        
      }
    };
    $.ajax({
      url: url_controller,
      type: 'POST',
      data: datos,
      success: function(data) {
        mostrar += data;
        parent.mostrarAlerta("success","Mensaje del sistema","Se ha almacenado su firma escaneada.");
        $("#mensaje_firma_actual").html('');
        setTimeout(function() {
              window.scrollTo(0, -100);
              location.reload(true);
        }, 3000);
      },
      async: false
    });
    return mostrar;
  });



});




