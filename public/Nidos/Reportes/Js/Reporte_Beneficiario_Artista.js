var url_ok_obj = '../../../src/Reportes/Controlador/ReporteBeneficiarioArtistaController.php';
var bandera_existencia = 0;
var idDupla = 0;
$(function(){

$("#SL_Lugar_Atencion").html(getLugaresAtencion()).selectpicker("refresh");

$("#SL_Lugar_Atencion").change(cargarDatos);

function cargarDatos() {
  $("#div_asistencia_experiencia").show("refresh");
  ConsultarAsistenciaBeneficiarios();
}

//Cargue Elementos Consulta Mensual
$("#nav_Consolidado_Mensual").click(function() {
    $("#SL_Mes").html(getMes()).selectpicker("refresh");
    getIdDuplaArtista();
});

$("#SL_Mes").change(cargarReporteMensual);

function cargarReporteMensual() {
  $("#div_reporte_mensual_Dupla").show("refresh");
  getEncabezadoConsolidadoDupla();
  ConsultarConsolidadoMensual();
  TotalesEncabezadoConsolidadoDupla();
}

$("table").delegate(".Consultar-Experiencia", "click", function() {
    var idExperiencia = $(this).data("idexperiencia");
    procesarInfoPDFInforme(idExperiencia);
  });


    $("#Generar_Reporte").click(function() {
       var idMesReporte = $("#SL_Mes").val();
        procesarInfoPDFMensual(idMesReporte);
    });

  /*-----------------Función para obtener el lugar de atención dependiendo del usuario que ingrese-----------------------*/
  function getLugaresAtencion() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsLugaryGrupoArtista',
      'p1': parent.idUsuario
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

  function getIdDuplaArtista() {
    datos = {
      'funcion': 'consultarIdDuplaArtista',
      'p1': parent.idUsuario
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {
        datos = $.parseJSON(data);
        idDupla = datos[0]['Fk_Id_Dupla'];
        $("#SP_IdDupla").val(idDupla);
      },
      async: false,
    })
  }

  function getMes() {
    var mostrar = "";
    var datos = {
      funcion: 'getOptionsMes'
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

  /*-----------------CARGAR ENCABEZADO DEL REPORTE-----------------------*/
  function cargarEncabezadoReporte(idExperiencia) {
    var mostrar;
    var datos = {
      funcion: 'consultarEncabezadoExperiencia',
      'p1': idExperiencia
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      dataType: 'json',
      success: function(data) {
        mostrar = data[0];
      },
      async: false
    });
    return mostrar;
  }

  function cargarBeneficiariosReporte(idExperiencia) {
    var mostrar;
    var datos = {
      funcion: 'consultarBeneficiariosExperiencia',
      'p1': idExperiencia
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      dataType: 'json',
      success: function(data) {
        mostrar = data;
      },
      async: false
    });
    return mostrar;
  }

  function cargarTotalesReporte(idExperiencia) {
    var mostrar;
    var datos = {
      funcion: 'consultarTotalesExperiencia',
      'p1': idExperiencia
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      dataType: 'json',
      success: function(data) {
        mostrar = data[0];
      },
      async: false
    });
    return mostrar;
  }


  var table_asistencia_experiencia = $("#table_asistencia_experiencia").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 50,
    dom: 'Bfrtip',
    buttons: [
      'excel'
    ],
    "language": {
      "lengthMenu": "Ver _MENU_ registros por pagina",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando pagina _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Filtrar"
    }
  });

  function ConsultarAsistenciaBeneficiarios() {
    table_asistencia_experiencia.clear().draw();
    var datos = {
      funcion: 'getAsistenciaBeneficiario',
      'p1': $("#SL_Lugar_Atencion").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {},
      async: false
    }).done(function(data) {
      table_asistencia_experiencia.rows.add($(data)).draw();
      }).fail(function(data) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
  }

  ///////////////////////////////////////TABLA DE ENCABEZADO CONSOLIDADO MENSUAL DUPLA
  function getEncabezadoConsolidadoDupla() {
    var mostrar = "";
    datos = {
      'funcion': 'EncabezadoConsolidadoDupla',
      'p1': $("#SP_IdDupla").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
    }).done(function(data) {
      try {
        datos = $.parseJSON(data);
        $("#SP_TipoDupla").text(datos['TIPODUPLA']);
        $("#SP_CodigoDupla").text(datos['CODIGODUPLA']);
        $("#SP_Artistas").text(datos['ARTISTAS']);
        $("#SP_Territorio").text(datos['TERRITORIO']);
        $("#SP_Gestor").text(datos['GESTOR']);
        $("#SP_Eaat").text(datos['EAAT']);
      //  $("#SP_IdDupla").val(datos['Pk_Id_Dupla']);
      } catch (ex) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
  }

  /*-----------------CARGAR ENCABEZADO DEL REPORTE MENSUAL-----------------------*/
  function cargarEncabezadoReporteMensual() {
    var mostrar;
    var datos = {
      funcion: 'consultarEncabezadoReporteMensual',
      'p1': $("#SP_IdDupla").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      dataType: 'json',
      success: function(data) {
        mostrar = data[0];
      },
      async: false
    });
    return mostrar;
  }

  function cargarInfoGruposMes(idExperiencia) {
    var mostrar;
    var datos = {
      funcion: 'consultarInfoGruposMes',
      'p1': idExperiencia,
      'p2': $("#SP_IdDupla").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      dataType: 'json',
      success: function(data) {
        mostrar = data;
      },
      async: false
    });
    return mostrar;
  }

  function cargarTotalesReporteMensualPDF(idMesReporte) {
    var mostrar;
    var datos = {
      funcion: 'consultarTotalesGruposPdf',
      'p1': idMesReporte,
      'p2': $("#SP_IdDupla").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      dataType: 'json',
      success: function(data) {
        mostrar = data;
      },
      async: false
    });
    return mostrar;
  }

  ///////////////////////////////////////Tabla CONSOLIDADO POR MES
  var table_consolidado_Mensual = $("#table_consolidado_Mensual").DataTable({
    autoWidth: false,
    responsive: true,
    pageLength: 50,
    dom: 'Bfrtip',
    buttons: [
      'excel'
    ],
    "language": {
      "lengthMenu": "Ver _MENU_ registros por pagina",
      "zeroRecords": "No hay información, lo sentimos.",
      "info": "Mostrando pagina _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "search": "Filtrar"
    }
  });

  function ConsultarConsolidadoMensual() {
    table_consolidado_Mensual.clear().draw();
    var datos = {
      funcion: 'getConsolidadoMensualDupla',
      'p1': $("#SL_Mes").val(),
      'p2': $("#SP_IdDupla").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      success: function(data) {},
      async: false
    }).done(function(data) {
      table_consolidado_Mensual.rows.add($(data)).draw();
      }).fail(function(data) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
  }

  ///////////////////////////////////////TABLA DE ENCABEZADO CONSOLIDADO MENSUAL DUPLA
  function TotalesEncabezadoConsolidadoDupla() {
    var mostrar = "";
    datos = {
      'funcion': 'TotalesConsolidadoDupla',
      'p1': $("#SL_Mes").val(),
      'p2': $("#SP_IdDupla").val()
    };
    $.ajax({
      url: url_ok_obj,
      type: 'POST',
      data: datos,
      async: false,
    }).done(function(data) {
      try {
        datos = $.parseJSON(data);
        $("#SP_Experiencia").text(datos['EXPERIENCIA']);
        $("#SP_TotalesNuevos").text(datos['TOTAL_N']);
        $("#SP_Total0a3").text(datos['TOTAL_DE_0_3_ANIOS_R']);
        $("#SP_Total4a6").text(datos['TOTAL_DE_4_6_ANIOS_R']);
        $("#SP_TotalGestantes").text(datos['GESTANTES_R']);
        $("#SP_Totales").text(datos['TOTAL_R']);

      } catch (ex) {
        parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
      }
    }).fail(function(data) {
      parent.mostrarAlerta("error","Error","No se han podido cargar los datos de la tabla");
    });
  }

  function procesarInfoPDFInforme(idExperiencia) {
    var datosPDF = cargarEncabezadoReporte(idExperiencia);
    var beneficiaros = cargarBeneficiariosReporte(idExperiencia);
    var totalesPDF = cargarTotalesReporte(idExperiencia);
    console.log(beneficiaros);
    
    datosPDF.beneficiarosTabla = [];
    datosPDF.totalesTabla = [];

    datosPDF.beneficiarosTabla.push(
      [{text:'IDENTIFICACIÓN',style: 'titles'},
      {text:'TIPO DOCUMENTO',style: 'titles'},
      {text:'NOMBRE COMPLETO',style: 'titles'},
      {text:'FECHA NACIMIENTO',style: 'titles'},
      {text:'EDAD',style: 'titles'},
      {text:'GÉNERO',style: 'titles'},
      {text:'ENFOQUE',style: 'titles'},
      {text:'ASISTENCIA',style: 'titles'}],
    );
    beneficiaros.forEach(function(beneficiario) {

       datosPDF.beneficiarosTabla.push(
          [{text:beneficiario.IDENTIFICACION,style: 'campos'},{text:beneficiario.TIPO,style: 'campos'},{text:beneficiario.BENEFICIARIO,style: 'campos'},{text:beneficiario.FECHANACIMIENTO,style: 'campos'},{text:beneficiario.EDAD_EXP+' AÑOS', style: 'campos'},{text:beneficiario.GENERO,style: 'campos'},{text:beneficiario.ENFOQUE,style: 'campos'},{text:beneficiario.ASISTENCIA,style: 'campos'}],
        );
    });

    //console.log(datosPDF.beneficiarosTabla);
    datosPDF.totalesTabla.push(
      [{text:'Cantidad de Niños de 1er Mes - 3 años',style: 'titles'},
      {text:'Cantidad de Niñas de 1er Mes - 3 años',style: 'titles'},
      {text:'Cantidad de Niños de 4 a 6 años',style: 'titles'},
      {text:'Cantidad de Niñas de 4 a 6 años',style: 'titles'},
      {text:'Total de Niños y Niñas 1er mes a 3 años',style: 'titles'},
      {text:'Total de Niños y Niñas 4 a 6 años',style: 'titles'},
      {text:'Total de Madres Gestantes',style: 'titles'}],
    );
    datosPDF.totalesTabla.push(
      [{text:totalesPDF.NINOS_DE_0_A_3,style: 'campos'},
      {text:totalesPDF.NINAS_DE_0_A_3,style: 'campos'},
      {text:totalesPDF.NINOS_DE_4_A_6,style: 'campos'},
      {text:totalesPDF.NINAS_DE_4_A_6,style: 'campos'},
      {text:totalesPDF.TOTAL_DE_0_3_ANIOS,style: 'campos'},
      {text:totalesPDF.TOTAL_DE_4_6_ANIOS,style: 'campos'},
      {text:totalesPDF.GESTANTES,style: 'campos'}],
    );

    descargarPDFInforme(datosPDF);
  }

  function descargarPDFInforme(datosPDF) {
  	var count = 0 ;
  	var bandera = false;
    var dd = {
        pageMargins:[20,15,20,20],
        pageSize: 'letter',
        pageOrientation: 'landscape',
        header:
        {

    		},

    	content: [

    		{
    		    margin: [0, 10, 0, 0],
    			style: 'tableExample',
    			table: {
    			    widths: [100,"*",100],
    				body: [
    				[{image: 'idartes_logo',width: 50,rowSpan: 2,style: 'titles',margin: [0, 2, 0, 0]},{text:'GESTIÓN PARA LA APROPIACIÓN DE LAS ARTÍSTICAS ATENCIÓN A PRIMERA INFANCIA',style: 'titles',margin: [0, 5, 0, 5]},{image: 'nidos_logo',width: 80,rowSpan: 2,style: 'titles',margin: [0, 2, 0, 0]}],
    				[{},{text:'ASISTENCIA ÁMBITO FAMILIAR Y COMUNIDAD',style: 'titles',margin: [0, 8, 0, 0]},{}],

    				]
    			},layout: {
    				vLineWidth: function (i, node) {
    					return 0.5;
    				},
    				hLineWidth: function (i, node) {
    					return 0.5;
    				},
    			}
    		},
    		{
    		    margin: [0, 0, 0, 0],
    			style: 'tableExample',
    			table: {
    			    widths: [143,143,143,143,"*"],
    				body: [
    				[{text:'FECHA DEL ENCUENTRO',style: 'titles', border: [true, false, true, true]},
    				{text:'CÓDIGO DE DUPLA',style: 'titles', border: [true, false, true, true]},
    				{text:'ARTISTAS',style: 'titles', border: [true, false, true, true]},
    				{text:'TIPO DE LUGAR',style: 'titles', border: [true, false, true, true]},
    				{text:'TIPO DE ESTRATEGIA',style: 'titles', border: [true, false, true, true]}],
    				[{text:datosPDF.FECHA,style: 'campos'},{text:datosPDF["VC_Codigo_Dupla"],style: 'campos'},{text:datosPDF.ARTISTAS,style: 'campos'},{text:datosPDF.TIPO_LUGAR,style: 'campos'},{text:datosPDF.ESTRATEGIA,style: 'campos'}],

    				[{text:'HORA DEL ENCUENTRO',style: 'titles'},
    				{text:'NOMBRE DE LA EXPERIENCIA',style: 'titles'},
    				{text:'GESTOR TERRITORIAL',style: 'titles'},
    				{text:'EAAT',style: 'titles'},
    				{text:'PROFESIONAL RESPONSABLE',style: 'titles'}],
    				[{text:datosPDF.HORA,style: 'campos'},{text:datosPDF.EXPERIENCIA,style: 'campos'},{text:datosPDF.GESTOR,style: 'campos'},{text:datosPDF.EAAT,style: 'campos'},{text:datosPDF.RESPONSABLE,style: 'campos'}],

    				[{text:'LOCALIDAD',style: 'titles'},
    				{text:'UPZ',style: 'titles'},
    				{text:'BARRIO',style: 'titles'},
    				{text:'LUGAR',style: 'titles'},
    				{text:'NOMBRE DEL GRUPO',style: 'titles'}],
    				[{text:datosPDF.LOCALIDAD,style: 'campos'},{text:datosPDF.UPZ,style: 'campos'},{text:datosPDF.BARRIO,style: 'campos'},{text:datosPDF.LUGAR,style: 'campos'},{text:datosPDF.GRUPO,style: 'campos'}],
    				]
    			},layout: {
    				vLineWidth: function (i, node) {
    					return 0.5;
    				},
    				hLineWidth: function (i, node) {
    					return 0.5;
    				},
    			}
    		},
    		{
    		    margin: [0, 0, 0, 0],
    			style: 'tableExample',
    			table: {
    			    widths: ["*"],
    				body: [
    				[{text:'IDENTIFICACIÓN POBLACIONAL',style: 'titles', fillColor: '#dddddd', border: [true, true, true, true]}],
    	            ]
    			},layout: {
    				vLineWidth: function (i, node) {
    					return 1;
    				},
    				hLineWidth: function (i, node) {
    					return 1;
    				},
    			}
    		},
    		{
    		    margin: [0, 0, 0, 0],
    			style: 'tableExample',
    			table: {
    			    widths: [70,100,180,80,30,70,90,"*"],
    				body: datosPDF.beneficiarosTabla
    			},layout: {
    				vLineWidth: function (i, node) {
    					return 0.5;
    				},
    				hLineWidth: function (i, node) {
    					return 0.5;
    				},
    			}
    		},
        {
    		    margin: [0, 0, 0, 0],
    			style: 'tableExample',
    			table: {
    			    widths: [100,100,100,100,100,100,"*"],
    				body: datosPDF.totalesTabla
    			},layout: {
            fillColor: function (i, node) { return ( i === 0) ?  '#CCCCCC' : null; },
    				vLineWidth: function (i, node) {
    					return 0.5;
    				},
    				hLineWidth: function (i, node) {
    					return 0.5;
    				},
    			}
    		},
  	],


    	styles: {
    		header: {
    			fontSize: 18,
    			bold: true,
    			margin: [0, 0, 0, 10]
    		},
    		subheader: {
    			fontSize: 16,
    			bold: true,
    			margin: [0, 10, 0, 5]
    		},
    		tableExample: {
    			margin: [0, 5, 0, 15]
    		},
    		titles:{
    		    bold: true,
    		    alignment:'center',
    		    fontSize: 7,
    			color: 'black'
    		},
        campos:{
    		    alignment:'center',
    		    fontSize: 7,
    			color: 'black'
    		},
        titles:{
    		    bold: true,
    		    alignment:'center',
    		    fontSize: 7,
    			color: 'black'
    		},
    		tableHeader: {
    			bold: true,
    			fontSize: 13,
    			color: 'black'
    		}
    	},

      images: {
        idartes_logo: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIsAAACCCAIAAAD5dKxgAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAD/aSURBVHhe7V0HXBRH29+7o/eOii0WsMdeYhTpvQsqKIoNsXcxYsOGWJHeO4IKVowFUbFiV0CKgr1g7x32+8/Ocp6YvK8m+UxezPPb3zEzOzs78/yfOrt3MOy3Iv+0U97BB8puP+HrPFXzfz+h32z8nD52e/O+auuxqz2mZLmvzD11+T7fylFNpy8cU0y0/8erqqqrcs/ftJqfvb/gFt/0TejbITQnMZ/puUrOJcZu0a6UA5cqn7ziT/wJel9VnV92b3ZSvoF3OmMRxthEMpbhjF1kH9+twdsKKiqf8f3+HBXdeByw8WyniZsYi1Dc5UjxXf7EN6Fvh9Dc5BOMWQhjH0XWaRnWcGjqoBU5Eb8Wna24/+zlO77Tl9HVe893nLrum5DfbdpmkWM0YxrCWEcwzjGMC3c4RhGczEPVB8WbL8gO2HTm0MU7lY+/TiBuP3qRW3B70frT/X7ZruAWy5iFMlbhjEOkyCnmSPEdvtM3oW+J0EnCSspHpxjGNoIs2zxU2jnWYEyG3ZJd0+OOrdtRtDn/Khh6pvzBhauPLt54fLbiQX5Z5Z7zNxMPlPlnnB4edKDHjC3q7kmMZSQZzTKMcYjigcHI/BHNV+0jiTTgLjZRDYelGc3d4ROWtzzzXFre5Zzzt05euofBcSN8opxz4XZa3qVlm855h+YZ/rJdb1gyYxtJrsUIkCo6skO0FEGoDusQRajWARbbRPCshKWyigBHZJxj5V1jld3iRE7xAodo0sEqlDGMYYzDGZMYxjxR6BDPWKcy+HSJrj2g+MAphwTGOk1oH8+YJzAm0YxxBNMvhrEMZWzDhY6xIqc4GZcYWZcYkRN3C9zdHNPggAc80M5aAxKEor8/hCQP6BaYBTOFwwEakMjYxQqdI0m7XbyT78wuY5Z1Gh2we3u3iwdbBkfba7iiWzw5HOM+qhEBJo5xjGXsE+oNiohNsCrNa7Ytq6eB1+re4xeZT/sF7eC+CMPaxDNWieRGkBLcFwe5XGI+tQ4eoTpr5WohBCTAxziJFnrEcp8Q6qS+ExYf29/GYeZMxiJdbUD4taN60wK8753SZm8wbLEsW8nkbu/C2KRoDozSHBRGIKEjOMbpuIepuUbL2CecyWnL3mWq0fkWU3648S+BI0sOtpZzjmcs1g+bN/Xg3h87eQcwtsnkdvzdJQ5AhTEJ9jVn67gOJQGhYF5CnWIZq1SF/jHy/WMYGzCINuKT4wUK9gl6HmF3TtRj7zBGE+czfba3H7X8+jHdw1v6RMdb/+S9rI3XWrvps3dk9jGZ4L90nbvn3MmMNc9ogU3y+EXjfZePspo2b+vGvpZT5rTyWtvXZ0lystmR7T3L8lo28wxmft7u5juTfcCUHWyq4QrWx5NryQRqYMZhkyzvHKvqGs1YppAJE9Ws+wiFEIScYlXcIob4+m7P6BsXb9PTZ5nQCZpUozr2iYx1CtN3m9vsKexN5vSutjZT52VkGBbn6b8rkTuW/RPTbztjsoFwre9WoW26/3IftpzJ29a1pSdcehygbT987ak97diL8j7zfmGsNjCGmxmrFMZkI2OWWbKv3Zti2cI8/cRUM4dpc0v3/8BeZwwnz2EMtxGvBnclhscprpv3sshY+z1ZvYfOnsXraF33Q/mMaSi3+FjGNslyov/jc5r7dnboM3aZwDmOk18EeMkD/abs2t5tzirP7el92NvM47Malw43WxflaDxpQVGu/s4NZmOXeOsPDmnuGWI51W/LBkO76b8sDvKYs3KkyCaJwOwUK7JJDgjrPy3Qy9V31sb0flDB5kNCW3mum7x8eE6W4YndP/adsCgi3ubSkWbPz6nhFimphvNXD969rYf1DF9MTIxQrzHLdm/v9Picus2UBUL7JM7iRdX1SAFhEpCwSu3gHTDGf6z7jAUjF0xo5hnE2KSSdqdYacf44EinS8ebXM2vf2ZPm/WphhMCRjZBB5NNCv2jLx9u6r1wwv1TOtVlci/PqcAAVhxuIu8Yr+wa22BwCFwLY5tCDvP0Rp5rRM7RGgOi7sNp3WJenFNlL8tcPtRk8pLx5/a1Z2xTGbOM5l6rpwYO35DW93xO66sndMuONl0W7C5wqEHIOrXp4HUj5k9yn+4/xt+ns88yTsm+Bx2yTZkVOPRthVxsvLW0Seakpd6vShTGLhoLh090C3bGPl7GMUHBOVYIZlmtZyzXk9AL3sUhfsSCSR1Hrurhs+TY3tYPzint2d61+dAgxhTma4PIIdFsyvz09f02bfzZavocKVxrngFc2w5fdeDXHx+cVT2Q3bH9iMBeY5cOnjeFDsjYJTKW6YjFRQ7JCi4x0g4I6mhYGAsPNHz+hBfFytOXj5Iy3rIu0unDFZmFaz0Y6yShY93WoT7R3X2WsZeZt4UyRDMs0vUGB78plKsuk0IgoOQSo+seTlQBh1UqY5tQwzLuE5mNOdduuokxzZQiiU6GxoBox5m+QRGOBbn6bKmQvcawVxm2TFB0oHlIlIPzrJlQI5FNGuG+cRbBEh4OkNNhIQ10ZNtEMqxFOg4d93AVt6iWw4LeXZR/XSij6xHMWKZqDYx4ApW9yvQaO5+xSq670TYihZ9jTCYvAB9vHNOQ7R8Oo685IPT+SVVEBL0nzOvqvfz60UaxCZaecyd28VnccHCIulu4imsEPTQHhjf2XNdpzFKHmbMnLB0dFOmwf0enByc12TIOlcsMe5FhS+SrL0qzRVyVQMU8PKV+MLtjSIzNxIARwBLDNhsarD0oVNU1XJUbVmNgWGPP4G4+SzznTomMs7p2vKHp5IWdvZcjgqg8oarqFkZUzSmhKNcAHsty2gwAVqfzIZNQabuk9SnGbJmw3agVzE87ETHDTxzc0UnBLrn32MXsJYboQTlTXSTz4KR2xdF6JYfrl+I4VO/aMd1Hp7SqCmUJJFe4o5xgwBYK2BJpYMzeEgTO/uHMZjX2HuARvS+QJpiVct3QuYJ0xrBPTmvePK5bdqQBGfZw/atHdR+e1GYLZUg3gHqFsZ0+V9oy/dfNPZB1WUydw/Te0XLY2g+lUls39pKxSxA41O1dH+NQnUFhzrNmxyVbZ280nOE/flOq1dx1g7XcomDZDCf4s0UyhK2XRUQJwFwAAMzogTJaiqErArZIyBaJyHFR+K5Edt38JrHLVQv2aKgoK04brXl2j/psH72yHE1yFe1GDiG5EJfTYelBhy3hICyTIspXKnKc4QdzqtY/5pe1Q9Yn2U7zH79tQ7/EFEuXWbN1B4YI7WPrNEJGEXoeofu2dTuyr+3Ts+qAoexAix2b+3otGA9vjyCYhY0qE61f3fjGYUXoFgCQYPHvHBWCM9tUlRQ0GEaeISTNMEoTh2p/uCLFYflZf3oUCrlDxBYL2EphfqZmdkxTokalQvuZfozphkF+03Zs7lO83wAovjincjin/aGdXZt4BDF2cXV6b9ssGM5ZziWmmVtYTJJJXnZHi8lzh/n76A5eB/tuSBCSYW8LvPqrttFX35emwd6QhT8gTKzFX/4QVoPL5QL2mXB3kkZ/S01PJ+1BtpqTh2m/uqAA5agWq9pvHLCNDHtTwJbLJ67RVFdVjV6sTmSiROgAhCzXa7qHDFkwznKK394tPRKT+zUbEKroGsnYxkk51+1YznQd2VOwTGN6Z1tOm3MnX0/JJQ7aQ/a+bJL6wcpdlAWbUlZDIYQCgdxAB628TRpsuRx7S8heBk4CIvVAhecy4GFOZan5eKh5uTBeLoojXWUmeSqf3qLNXkNPcTeYL1rAtcQwEl25LfxQorQjRtPsZ9xLJCUlV7Zbldi6UpHDjLkk5EPob56ORLXiaFObmb6YMIkwHep8xmoaKnKJGbtk7MSAUZ1HrrqQa+AfNJCEvy7RSEEIQvBD5cydY8q6WkqcyWKAk0lvtfhAzcpjyuwNabJnCudBuV8seH9JoU83TXTTUFXMiGzUuqUayh1aqb4qUmBLqeahJ6wZhy58200he13u6kG1oPlaPTqiswx3E8air0Y15ABaRRDyIwghYbJMnbXK8+y+1u1HrBq3bPSkZd4ix2ihY11/PiSwScna0I99wjw/q3L7RIMze1tLOybSJJFYuSJZ4sxviBZN0YYaUfZxJGqgq+jprLEhVPNePqJzKQLAJeGdI7KKigo4q60uvyFSr9uPquiqrKR0aY8G/BPRGIBUICTRwQ3p24eVk9dqutpoaWoAfhEdl5BANjdZg5hTLlLgEXKKhQLl72535UjTh6fUMOHtmX0E1kkCglBdfvoQjAxR0y0qMcnsJcS8HPmKGkldkXNQhOCHgFAZ86pYsW93LZ6Dn5BMYz2VgFnaVZdloRNPT0qHLNCOCaxv3FtFjKicnPL5bRrsFU6HoD2XmVdFir4+2vV0lLk4ohZJzfbRZm8iixKQyEKMENlcX3cP+Va54E2x/PpUYw0EnN+BHwohBg3JvE1Kc4/QGUu93xQodhy5nGT1sHLjgRCnQzBiFczNY6o9OwEkAc/JT0hqtLsOZ5cE7HUh+1ywI0ZHrBZy8soXdmhyCBHteXlRwdaklkaKSXqSl051BWffcFNJhOySOo1a/rZQ3nf5aP3BIWQrjzz3q/t+iHv6QHaOYxiTTX6rhsBStR2+gkeIRgrIh+gewXXm8TmlEW5grhzPz09IZkOQFnuD8zHXBVlhuoCNnhAKpY6sl2avcvH0TVHADJz6DXj0dFWilumw16VJMosDMaGklbNL1Pdaheqida6MSSa/9f5dPGOtQYg4pI19X5xXVx8QCdPHWTl/tkTqzXnprZG6l/epVBUrIOJiHynlbmzgaq2jrIh05xN9crNDzCZDFOWmIGQR3L7YtQiyYxBWCKGOVcVKXdqR8EGSmjfRmDu53rWTquwjxHUyb84rndqi8mtc/eoS6JyQR8gxTt45rvJEA2RvIrtkEtoRhKgOfQ8I4XCM0xuyztF3tsCZe25mk0QQuihddUM4epCujLRS946qDqYKQ120p3tr+wxu0rQxlOkT6tJejb2iRDz8E+nJXop8KyGh/2Rd9rGIvcM8PKmhrQEXJSZgLGjVQtPNRs7ejDH/mTHsqdhWHwG3YvACHZIeiXUI83SMtZ7u13RoEHnrgT78retP8DiEKDzkiKaqw1epDiHavsLcPKLMefX/QgKB6Jex9csPqa0P0tLRoBsKPGlrKuyI0y7erzrUBZ5MImz7HerdVeMVVBYhH0FoDo8QZmWbzD+qoMd3htCnB4kUoEPcvtwNwaGNGtqafEr0H0mgII9om/dAn5KMnOwnsP0OCTq2Ua/I49JV6odmAqHU2tOjx3fhh2qtWXyQSKEmlkPge0N4LlvVrA/sjyzPyb+ehCrKCj5DtO6fIs9+uFgOCMEP/VeEvhMdckLYncDHSDhsko2olSMIcWHYFab6knx2nMbogSp9uim2aCIvJ8dvAfwZUldVNuuj6T1QOWyRWtkeVbJPgbgRt8NNgVCxtPEkf/LAl58keeuIK39ffgjYxMHWGwxfS/wQ0iPJXR+SDwmqEUNXCNk7QvaezJti9eyU+iMHNFJXI1sGf5KUlZSGuTTcnaDzqliVrZQi4SLsGxAi+9wMlNhwPBDivCNxkyltR6whr1HQSX4H+3IcQg7xbYav8l/rcflQ87BIpx4+y8jTaFvOylGELjJvChVCFzYf3l/dwlC9UX1FKam/QHs+JWkEI7amalOHq28OVyevPNKnR2KEHOK7jQkICXetONxkadCgtiNWE8Aco0TfhR9yitVwixo6d/Kds/UWrxkiAwm1S2RsEW3XIFQkrL4kyk3VatXi9/YU/iqS6dVF+2C6Jvf4juRPHxGyTZSyTVuwyuveea0xC8dqupL04LvZU7BJajAodEagl+dsv+lLJy4IGdDQI4Qx29hvwsIahLg96WvMq4tK6/y1OrRByol4QViD1h/DTNBAV76Bjry8vJKGmlybliqj3dX3Jmmyl+XJ/hDxQ5yVK5KFsWVMN+i5h85dN2ja0okevgt8V3g19ggmkXfdRsiPfjvFNqnzyOW3z+gU5uqLrFObeQY9Oq9+41S9VkODuo5Zzu+cEoS4ZzlIUG4JXxco5KWqBS/Q8J/B+E9T7N6x/h8CSdC7q87hTc2uHNO6cVjxbaE8/ywDt6Nb4DxCMj3GBLQYEnztZINnhSothq1mLDYczO5UeUGzp88SxiqpruuQCXlfbkdWL/Yh47fanbHIgLSuDHVGNTbRquvoldUfdYhToyJRVYE08eQPROxNpfwdWsMH6Cgr/nGf1FZfOT1U602JAntDii2Rqi7kjBt/Ox6hLiNXBkc7YEohkQ7kpTvL9OELJrD3mJytnZm6//TBOJSxSzq0sz17n/Fd6QHxZMw2+AYOYR8xEbF2XUetlLByOATQoQcn1BfP0LI11WpYr9azA5Giwn9PlQQCgbaW4qfbCkINNRV7M934FQ3fFsl/8ioEbn1RpuuoVUFA6DEzZ9VgDqH1Q+ZOYSuZk3vaMDYJTB1/14dYuWTzKfPuX9S4kNtcaJvKmGbu2tL9wuFm9dyiENRJWDnuHQSAVCIs3au8dLqGUS/VHxopaKox+s1UXG3UYwMbde+oy/P890kgYPrb6G2Orj/YUbXbjxrtDDR6dlYbZKeavErjXr4c9wYERYj75HSop88yXdfoUwf1D2V3JlpuvuHXzd2flKrazfiFsUziYrk6itA88iYJF8vZJ5iPWxSXYBsT45qcaLlnc+/pK0Yaj1/Ue+xSokMkbeSwAftQQGJ0SUCeXlfIPz8tf++Q8EOpDPtIdckMbYFA/ExB9Fk4Dm3jz0qJRHErtNmXCmy53JtzCmTL/LoU2W8t5QKEEqDC3QvKRBCS/clnWS/vZTNWjtq7uXdGqllwmHt0nL3lhIVCpK51P2MlX0BMVXON2JRhcnBvx/sntNlLTP5u/UM5bU0mz+sxGpEC2fWpOivFXmWqC4TVJ6TZi9QEcQl/GcNekSrO0XS1Jq+acPwXKCkohgVoRSyFPvHhg5SUbFpQ/cUz1aWlxQ+WpMd4aN48rEoeAgESYtkwoAhq+uEY93yoRFh9Dp6JWLnu3oG9xi45uLf90V2t2VKphye0MdWtm/rqDAhjzFKlnKLqdCxnHNZ7/BLoir5nUPeRy0fOm3w7v369wQhkExjzdKOJ/uTdz1vM2wTVZ971Xoyp/+GAPHuHe6BXyu0DIaksk94Yomfys0a3H7VNe2v4T1crP6J9bp+OUU94KR4hgUDk4aB+65Rmaa7WL2PVDbtrduugYWuitS+5HnuJgi0ibw5Bje4wr4PVnvnUez6+ftVJ7rXTIhkkzpgMFF1tQFR5XrOx/uN7jAhsNWztTz5LDScskHKMOVxXEZpD3tuOy97Ul70lSEvrJ2u5ISzOet+2buQLDtzbWL3GLakqla4+LvV0YMO7TOtnXnrv9si/iVR+m6JUfZaTdJijQu4t3wpZ9ro8W6lavE973FANOZnfeAirqaboP03zwTlN9r4SSXquyvD7b4DnCvNhn+zbGMW3CUrvtirdb9HinrrBqyVaxO4Vy/AZq2MsoriNGf0SUsykLTYlpxizNwX7NncTWKfkXazkl/RN6FtauXymT4zVVL+3JbII3k7v6XD7uJ79LF9+I9k2qePogHclctW7ZN9lKb1cov1qoe7zybr3tVrelTd41OOH99nkzRPykmKBAMns7WMqw/prykgr8ID8Ngm01BVXz1Un8MBCFgrJ5eWCVwEa9xq1uCtl8LBj01cBWi+mNHwTr/I2XZk9JWJLahDClGySe09YeONok+PZXdgHzLsyWaupM8l3Hy7W5VguGMs2HL8oIdHq4Tn10gPNpZ0SiAJxCHX2XvbugjyMT9UJ6aeDGlaflGLvMu82Kj1o3uwuY/DUvhExTeR9RMHJrapNG/73R3w1JHK313h5UZ6EA+XMhz0K9xu2vCul/8SuURVU8yHzJkztxYT67G3YUhIpfESIfFcw9div7Z8XqCUnmRlNXICMtS7HchxCoWRjG+vvtz0pyWT75u7ExIEXHEKdvAPeFcixN5nnPrr3dfSr8jm7dJd5Halaqaj/6KdmbBm3y1Ah2hqp1aalOs///05SzpY6d46pEDW6QSCvVDR42PkH4niQC99kXq9Sr5Rv9W6TIvnahSRCOCzT45NNszf+zBhvI48kHCO5WK7OWjnxzmkMY71++8afc7YhSwdC3EsaBKFl74vk4G+eWDWqlDJ4tVQTeWJ1GXkM8bBzsxfjdasLpdkzIgj7xRytDq3Iq6Ziknx0JCMtJSMtGXyLJo7QYa/JEQXKl646KfewQ7MXM7UxOHl9tVz4xLLxXaHBy2Xk+5SfIhSNdHVjRp+87C6MTRpRqe/l6QMgsUpLTTF6U6TQ2HMd+fI3RWj0sncF8hDz5+Pr3WVa3W/U4k2sCozeh3yZZ6Mavl6o9bRvU7ZA9sSvGvV1ycshUiK5xg1VAcfCKfVdLOtTNECKCnIr5vzgaK4qLa1o0AKqRrZch7loVT+Qq16n+sSy4ctfdF/M1oXGVF+UejZOt1JW/76awbuMz3TIPl7XPfTpObWtGX2IJEGwvqOn4JbrZ68a8uiCRqdRyxk77su9BKGAt0ConKk6Kf10gN59nZYPDJq9mKz72LDJu3Yt3nRuxUZon9qroasNDyTs0l49J1XzWKZudpxW+SEtddVPwjkHM9U3JarJKxrfOa61eJqmmjICCsHg/urvCtSqRzSt6qj/Qr/5E3e9p+4NyV1aNH+1SIvkxSQfqkHIJQYTaztixcPzGv5BA8jL5Zjkd6NDWGoctKfNiFXk2SVtEesQEnsw67Lw/U6F14u1nvRs+rxly7QWPzi00Rk0RKtBPSUlRbmAWbovipUQEJKc5oHsxKGfWDyOZI9tVGPvCYnheigs2KPmaqWFRqO+Ko7OmpMa6pV0af60cctnbo3ehKtXHZchKReSLSTFQAj5ENUhgGSfYOC1mryQRcOZ7+k9Be5VLLsE/vk/Ds4PEYTIC7oieKMPebLwEG+dG+5fXo9R4/2KtKLMqc1a5E3E68y7TMWqnfLvL8nSF+o/JcGKOfA9wnepilV5MgjY2Dty08d93McztdR6F6L7pHvTF9N0yUYD2WcScns/n0YKmJ4d9x1xOs/vyMo5xwhqCvxBEOJiObJRRr4kVF0sqAJUt5lze+FL6HtVojG9G7DXpKsLhU+H6FXKGryfWe9pBdNAlxEIZGSka97blpMGlNO8ddibUojZ7us1f71SnX3MXNmq1VJeg/Yx6q1efVeaLRVWI4EVb29zO6fkCd5HhLiDvjuH47tCqOZnYrgDTpggtPR9IX0bi/CLZJcQ7RK4B6nIJZpdOqiqKihntGrDblF8NVvrLtO6Ul2f3ap4r0A00VMralljLQ3+tVM3m/rrFuit8G3I3he8mKKNnvc09Ku2K76do+em3khVWcHdQfPUZmVEcTWbsxQh+hRcus8nOoSjRstx1HUrly9GSECsRxL3Kx81BsQ+ocmQoIenNTgd4mwOlWtSIF+Ze1qgULpF7UHL5k9sGj1o06xSyeDVEk1EX+8uSLM3lTaEiPdSmQ6tFNhyhTeFSkC3+oLoqRPZQ3pi3fiRQbObAxtdQmJ0VZZ7v4eOT2/BHSXM07MqzYauJpYNAkRe7kkg75/aJvJq9L34IacYgWO82ST//rNmDpwzg3gj7ufgRHbJ+7d1Jttu5CtzYvZRDopI7nKdeWrV+J5OyxdT673brMhehdvgzt5h5kxALMfvnDZuwFSe4L7LAAzIdytFb6JUnzg3uStn8GGFOvuACwo+wkO/dsm9jXWFyd3eWWTLvUePKdkluMz0c53lazp5oYj+8tD3EsvZJ7T2Crp65Ae2WK7DyJWyDgnK/WPJO2mmG0f4jyPSXUQfrHHA8Ae333NFiOirUs7g/W558qMJZCMVxlDE3hKELvr4fna7ViqvC+X5b0mC77CTT5mXM3WRY72JVCbhHxlQcnDuQCBXzrjOmUKeq1qnKfaPk7dP7DB8VfVFuRv5jX4cGYhpfyc6FCvlGDdotu+MwOHhka7TF08o2Nf65vEGiSlmjTzCZG1SD+3ozL2jC+6LcSKugrj068yz4UhmW78OUieM5vWAvJJ4IktNSop/KD5yoCb5EjlRFG4EXFgueGrX+K5sq7dpSlxa+in8GAedrzMpyaaMZYaue3hcgsX1Y3oXc1v6BYyJi3GeuWKo17xpMlCjuo2QX83vywlg3y3Xd/NeNifQu5FbdH/fWQ/OaCAgzs7sDfltPiTk8pGmBCSiSTUY4IAtKhV+OCD3LlHlQy737Tvx2WLBu0vyP3UjMTeCutwkdfJdcHqWoEguf5el9DZdufq0NBdY11xIP+H5rjM7N/dScUpgLNMz0kxgCZ+dV3H3m9Kof8zMZWMNxy9iLNYLnKOAkMgp+vDFOhrLzUuhvxVMfjxT1jGx9GCzqDgbxiSLMcvoPmbZyyLFB2eV5fpHotrCMzhnWzfyQAgWr5R7YYpkKmA6/908YsEKJJQAxw1hZigMnbSFoTr51iNMFgcMOQWQoEwYDdpDwxBylhsWvu0a87pIMTB0oIJjEmOVKnJKvHVU702ZvCFibrMNjMmmwDCX68caKiJSgGdyID+Re6LsHr+kb0LfDqHQX4vIL/HCD9klNh2+AqyvONJI3TWG/Pql6aZfM3vuyOqp6JSoMjCMsUkROSR5zp+0d3uP+6fUqy/KElbSAwghlAByOFDmAz+kMoLqUtmRA/QOpatzRpKDB7iWcd+ARGd84kLxOCXClxeUyw41Do2x7zw6kGzq2CcoDQhXckzclG6Yvakn+QUu6yTMp2h/c1zYxXspeaPRLlJtcMK1e8/5JX0T+nYIHSi4TX5j25GEsOpu4VcON2LvMzuyejQaFCZrlxIS7h4Q7H5id8duPuAF94OIVmlgSpMhwb3HLzKfMR2H1czpg+ZMGbto3MJ1A1JSTM/safnsjCphPQ6iZwxbhgABKsVhAFRKRNeP1N+9uVtQtB3c3rB5E518p5lNn2Y+Y6rJ1DkdRq1UIr9hmk5u50T2DtqOXH5sd8c1YW7Boe4ydkn1B4RlbvgZIcn9fO0GHqEkUrAK7zwl8/2Hr/0HBX+Kvh1CT1+9beKdTn7WGmpkm2w0YdHRPe3vn9XOSLPIzjB9ck7rxN520wJGSDnEk7gWfbi4nOx8I38EWkiecKCAA2y1Wi9ySDTwWjN64djsrJ9eFygSSKAxUKwK8rPAq8NdjCfP0xkQSX61kf6SIL2WDIWDy3LI1x/pjcjP0ArtE8cuHpO/u92z8xq5m3/akGZ574zOiZzWVlP9iAKhm2nIlNij/Hq+FX07hEAzEpC0BhNXxH0dBZnHoBlzd23tfe+07rMCxcQkS/KOo/l6okCUcfwhkdV/rMaSbkh74S0sMjqOXBEVb/PuokJpXlNv//EarrHkF/1oRkzx5nduag1FD+526GaZxphtCol2fFkgX3my3oHsnp6+v0jjFhARkr1Gi+wjT3z6bz++AX1ThCoqn6kPgk5EMi6xhCO2iYiX0tONO3kv6zRixfGc1qcOtoL7IVKPNBZMIeyT/Kw5YHCQVAIh61RVt2hlt2jiNizTf/QO0BoUQTSMKsdHVH4TmJqD3ztIG+A39fiBNif3G/TwXtZ6xKqU9WbD5k8gNpD0iWGMgwes2EcX8i3pmyIEWrejkDEJZhwpd2D9k4n9AReMN6k5x0XGurCXFLZu6qXZnzye+T14WnqtETrHiOyTVoY53zlZ/9YJvXlrB5P+sGZE3qM+g+T3EQLr7RKVneLXrzdiL8klJdtpI3gxziJToi7KJVqAPlbhWh4J5Xee8sv4hvStEYKT9VyTyxit43/CH4cjctj4eWs9rp6o/+y0GvEllcz+HV2UkJ04xJPkScxN5xgpp5hWw9ZsXW9R3z1sVYQLWy797Jx6dYk0/LmH36TxS0e5+U3jfAb38+bQMxwSl//G4RAnZ5+UndmLbFJcZp6fVr1+sv6iYHfyigu5lvsnHzbhUraRWcev8Gv4tvStEQK9evthQGAOAck+ipg7xxgZxzgw5erxBlePa6enGY2aP4ktlo6OtyIuXQwkDqdYWee4wOCBSImS4hxGzJvRdvgqPfeI9l5rVkfZpydb7d/WLSBsANNvC/EouNYuhbFPJvtJ5DeBUzj39pkyWaauCOvPXhKOXzw2LdXkynHtiuP1l4YMkqN+jnQIk3WISs27zM39m0ZxlP4GhEAIWP2ST0jbRZH/l+LI/e8YmxQ5p1hl1yjCUOMtaanG7F2GPKoh/ytAgqHWKa6zZkXH2gyfO9N6yiKm71YChkUa8/P2wHVebIn8uMVj+o3znxfknpZmdGBLt+O/dsrZ1nVFuLP9jJnqA8IFtUAir4AFsDeYXzN7kNzZJg0TkCV34X7/2y4SvqfV6PQ9577pP+2qRX8PQpRyC26bz9lOkiTTUPI/nWzBFKJSjF18c6+Vo5eM7eS9/JPnsDgc4poPW6PgmNBq+KrnZzWXhLr28F7e1CPUasq8/J1d3l6ULcnTL9jfOjO93+WDzdk7TFFu86Qkc/aS7IMTDdp5reFGwzg1A9rHtxu5wnuJT+sRgYxtPMnVbOMY62iSWZuG6HgkzE44/vD5G366fxP9XQh9NBcHCm9PjDrcZVKmsjvZPCYJk204YxnDGCYypvT/EoWQ7SJwzSqcsY8g3yN3iBfZJW/e2Id9TJzHh1LZ0ryW2zb1PbWnVcMBEap2ST29lz8tUIZyuM6ewfTd3m7EqpZeqwkGkAYMYh5CxsQnBjeJYPolMRbE2TB2ESKXGD2vVMv5O9dtL7x2/5vuHfwe/Z06JElvP1RdqXx+qOjO1vyrm49VbMm/uuFweXxOSfjOwvnpp0eHHbJduKvd+I2qgxAWR5LfSzWNVHKJDIm1Lz7cbHtmr94+ATlbf5q9eghjls6YZ2RuMIICBUc6CRHg2UYyRtFMv0iBfaTO0OSuUzNdA/ZOjDmyLPNc1K6LSbmlWcdxuytZx8p/PX3jTPmD+88klab6b/A8n9I/BaEvoTfvqyruPt1x4trctFOGs7dJOycwP8cxFlHkX6M4JrTwCmKQ1pAQLs5pzpS+E/zIv+syi6g3LNll6Z6g7QV5hbfvPH71vuoLec534/78nTD9LyFUiwqvPQrMutBlylbyj9nMw4gLgWtBcIwQsQ88Sqrjkt2pB0pvP3rJX/C/Sf/DCFF6X1W14+Q16wU7iY8hHj5UbWD8xMgjBdce8j14+tvN1R+k/3mExATr13Nq1pCVOSW1/ynv/zbVHYRAH/5+v/7XU51CqE7Svwj90+lfhP7pVHcQevfuXVVVFV+pQ1QXEDp58mSXLl18fX0BEt9Uh6guIOTl5aWvr3/x4kW+XrfoqxGCnBYUFIAd1RKh7d27d8vLy1+/fs3XJejx48f79+/fvHkzJJ1vqqG3b99iqOLiYsmh7t27d/ny5RcvXvB1jl6+fImeoMLCQnyWlZV9+PCBnnrw4EFWZiZaaJUSqhcuXPjN+YBu3Lhx/vx5dHj27BltQQFV0O3bt2kL6P3797hdUVERyrjk9OnTV6588hAPMz9x4sSrV69QLi0t3bFjx/bt23EJPQu6evUqxkQLCNNGf9r5q+irEUpKSpKXl1dQUNi9exffxLJOTk4qKipHjhzh6zWEzk2bNqUv64KMjIwwS/4cy4aHh2MoXHj48GG+iWWHDx+urKy8fv16vs4ROigqKkpJffzV5p49e+bm5uJURESEurr6vHnzaE8QWKmhoSEnJ7dixQq+6VMaNmwYzuLWixYtoi0ooAqaNm0abQFt2LABywTl5OQACZytX78+BQy0ceNGtHTo0AGiOXr0aKFQ/CNDjK2t7aVLl9DH2dkZffhWjtq3a79161Y6whfS1yJU3bdvX3oz3J5vY1lDQ0O0QFf4OkeZmZlolJGRmTNnTmxsbL9+/VBt2bIltApnIaHdunUjAzEMWEYvAWFYtMTFxfF1jvLy8tCop6eHoQCGnZ0dqmpqahDtmJgYlKdMmcJ3ZdlJkyaiBdSqVSsoH98qQYMGDaIdsBba0qdPH9oyfvx42gKysLCgjeA4qpMmTUIZjSg/f/68RYsWqG7atGno0KEotG7det26ddHRUZQVP/7446NHj+zt7VGG+C5YsGD+/PmOjo6oYhUPH9bakfpP9HUIHTt2DMLSvkP7Zs2aycrKFhfzpt/U1BT3PnjwIK2CYMHgvdGYkpJCW2BJwH34DJhEVKEBOIs+jRs3hhpdu3aNdnNzc0N7YmIirVI6dOgQGs3MzPg6y3p7e6MFK4eaojB9+nTafv/+fV1dHXCha9euaAcHabskeXh44BQ0T1VV9c6dO5WVlShoapIvw06YMIH2OXPmDFS2TZs2EClpaWlYdRgoQI4+0K0lS5agADiPHj2KQpMmTW7evEkvhBegshgVFTV48GAUMHl6CpaZ3gWmj7Z8CX0dQpQvGRkZAQEBKMyePZu2f44QfAkgxITgJ/imT4myaefOnXPnzkVh2bJltP0/IISV83WWhdFHC6QSjEBBjFB0dDSqs2bN2r17Nwrm5ua0XZIGDhyIUwMGDMBndnb2r7/+ioKrqys+x40bR/tMnjwZ1eTkZGgGCqiicd++fQKBAPKEpQEVaNLy5cslr6JE5zBq1ChPT08UoN8wJ8B17NixqBoYGDx58hU7h1+BELwo5E5HRwcGCsYXphyiSp3t5widO3cOLRBALINvkiC4XNh3LBJlCBSEFD2pRfpChPbs2YMWaFVkZCQK1H8gH4J/guyfPXsW1ebNm0Pj4Za4Kz4StXJr164Fo6dOnQq9wVooEtTKQaq0tbWxWEweGg8XiCq0E6fAbnQDTvBDqOJaVGHByLg1hLAIjYBcbE7F5ODg8HnE9J/pKxAKCQnBPTBdKysrsAazRBVGBqcoQvAWtCcIYQycJHw+tWmUINewHuAjFT3YFgxlYmKCMgiChj4UITqsmChCCDT4OsvC36IFZpMKLEUIoQrKIGNjY4wMFqM8ceJEeomYKOPAxx49etSrVw8y1717971796KRIhQfH48y5m9paQnHAwFCNSwsDKdKSkpQhtfhRmIXL16MKlwRrVJauXIlGmFvqA7BPMDqIMpAGXLAd/pi+lKEoDfUsiPzgGzCT+ITVThGnKVOFQEP7UyJ+szAwEBaRYCLqAEmAjaduijoe/PmzVq2bPHDDz+gSp0wZR+WRK+iRFkPOaBVYEy7rV69GoYIhRkzZqB95IiRKEM1oZHwlG3atEYVAEhKCYheizFnzpyJAgjmGpNHAeEAOvz8888oYxAsEgulQQHmjFOw3ii3b9+ehvtHDh9GFTGLOByFQ8K60JiWlkYtOQwp2mFgoLKo/qZr/A/0pQjBYWB0uErYUDhDEIyerm49NCKEo0FLr169XFxcoMiowhrAVUBL0A61gDHR1SU/Z4D2LVu2oNCxY0dYSDpURUUF7YlYdsiQISggFhIPhfg7PT0djdBIOB60d+7cGVXICsJCauV8Z/kikZKVk4UQYBA6LHw7ddq1wm4aLoKnSF9QAMEVHT9+HAX4M2g5CkgSYNboOBgZqKMRfuj69esoADy0YyhkcmPGjEELuA/HA3fVsGFDVC0sLZCNQQVRFkubv78/qjCYMDC05UvoSxGaOWNGo0aNaikp0ghMaOHChTDHWAPiAqgIJSQKWANCnb59+1B7qKWlhfWjEctA/IYomR+FI19fX3g1jA9xxlBYBj+QigpEGIts164dOqAKnGCaRgwfDl+IC+GxMBouhGNo0KAB2EQHpATLidGAK2UoJdg9XJKfnw/WY3CIPMCAu0IjNB5wYqWww3xvjlatWoVGzA3xPcCDusOo0FNQJtgxqCzWSAHAAmlGgSwCYwJ+2hNzQOSNySNnoC1fQl+KEG6JAJ+v1BCsDRqhVS9evEAHFCih/PTpU/FOAdI3mDjqaUG45POhsE5kCbgW8cLnQ2FttEw/JTNzhPW4EAILr46CmHFiQn+0S26q4haYAO2JwWmwgyoaMTJugYLkNgcIVTLpR48+fHiPDvQSScKY0F1EPejDN7Es2IKqpHBgGpiMmBVfQl8RKfxLfwv9ixBPkGvEab+5B/H30r8IESouLoYTRVQCk8g3/WPoX4QIpaamIpqorPymP4/5hfTHEYJnRrYYFBS0Zs0ahDoonzp1ip5C7I9GJO34pIQkTvL5DYxJbGwsrkVCg2vxiUgMHpg/zT2DwIAIEceNG4d4uhbv7ty5ExERgewSZ4ODg8V7epQQO/3yyy9IGBFkIoZGCzx2aGgoboQpoT+dM6ZEJ4yFoB0J6e8pEHx7eHg4vQpTxcQ+36dAiAGYESViVnFxcZ+HEn+Y/jhCCOppCiZJNI708fHh6xIESOiFIKSQCJr5EzXUrVs3uv+ITEXymQUIMStyEXotCjTnEBPi15x9OTgF4OluG0j8OGDu3LlIYhQUfuN3n5cuXYqrUlJSaBX5CneH2oQIjXYQE/IHyecdYAVyQf4cR8jY6AOIP09/HCEsW0lJSUtbOzc3F8KYlJRENzbAQboZis+CgoJz586dPXv29OlTkluoUBHYfWSpyOSxksLCQiSnuATqgriZ7lYgq4DrLisr8/PzQxW5DiJXQKujo4MquIlTpaWlUCNUkX4hXod8oAzuIIkG15DMA1q0QD8wk5MnT9JNGmtra0wYuRpGQxhtZGSERtDv7SIijAbeyKuOHD6MC6EidIsaCS/O4r4YENURI0ZgwjAVNH8fNGgQvfxP0p9CSFFREfMWpxrQEsxs5MiRlFMwLEgFwHGI9tu3n3wLBwhpaGgguYMBQRU5DZaHS3bv3k03relmkpgofunp6eAOCoMHD+ZPcIRLwEQMBRSlpaXFxhaUxT2j6t27N63SPU3ci1ZBEBEohLGxMX14U+vJISUMjlMQAr7OsjCVaPHw8EAZ2KMMqcIq6FkYYYja1+6Q/h79WYSQaYv9B+aEuWK106ZNQ0FGRgZKBvMCY9iiRXOgQruBUAY3wRotLS1onooK+e1fwIBTCxYsQBn6R3tSgvVH46JFi+BgUIiLJ8/3YPq3bt0KBwZcDxw4QPfuwCnJiLmiogLTwC1oIgkA0MfT05OeBdEnAtk7d4qhqpWrgihCbdu2FcsZdBQtsGwoZ2VloUyf8v1/0F+PEMSfbtHDr0DK4Bjc3NzGjBmD7J12AwEhOA/wDpI7cOBAmAXoEygzMxO+AddKWnkQRQiWbfbs2SjExJIdoxs3bmAEVEEwmMnJyajWQqi8vBxahXtRZa2FEDW2kKFDhw6dP3+eCs3nsi+BEK8lFCEsEGWICMr/XIRg6MXzzsjIoOunfIRRou2fE1hDHzXxde7pLS7p3r17QkICCpBl/gRHjo7EyiFYolbO3d2dtufk5OzYsR1hBdQU/u+HH34ASJKBFn1IAVbSPZ5aCNFd11oEraJnxUQRat+uHV9nWToN6mloHGFgYEB3u0FwRS4uLvHx8bT6J+nPRgoQT/j5iopyMAhShrnCf4ofm16/jkiYEGRZcsOKCq+amhqCCIyDYIH68J49e6Kqp6eH8ty5ftCSW7du0YdJQBT2nT5FRDUwMBBlhNHbtm3DOGi5fPmyr68vCoAZeoAAHfjRDU24DXpfSYTgPtET1dGjR0NlMWcYZwCMieFGtD8lIATdQhyBeWIhGFZfXx8XRkVF7d27F8pH392YPn06YlF0gD6hCvsBywm2fL5V+FX0xxFCsEQfbYlEIiwABRB9zk835EFSUlI4C0JZ8jUaBFFAF424UPwGj7y8fGZWFs7u2bOHPqoAv+TkyE+dI6ygz/dAkADYQzRCb+hZEEwl3BIAs7GxoS3Ut4EAgHjvMjExES2urq4oI9JDGbJPT1GiYVgtLyiOtulCKMFf0qBm6NChQKV1a/IsClOirICLgsTA9qL66NFXvDfyOf1xhOB+kPTBN0AAERBDY8RPwXft2oUFgLBUSvDw4k14EFiJ7A8ZJRVeEIaSdACAHy0eHu5gPUbGavkTHEHPkH5CSHF2/vz5ki9zAQwoCkSkf//+yB937tzJn+AI6o470veh9uXkIOaEEtBTlM6cOYPJwNLydY6g8dBjrHQut9KAgAB6R8T6kyZNysggxhy5BFJamF/MCir7lPPN/v4LwQTJnfg/QH8coX/p29C/CP3T6V+E/un0/SIEn/QnPcS3IR4hBLXiR7OfJ9WUEJ4+e/aM28J5izBBnAaBcAm96vXr14iqv3BnF50fcw+5aRUjIIJAFfTmDZ+9S04MCQfuKxm1oxvtL5mlShIwQNBBy+JJghAu0j0bkOQDcjFhdZLtuJH4WowpTtJBmBXWS6eBS9Dt+fPnKPOnOUJoQ1NmSuiAVdA1ggnojAAHjSBxCwgFVBn0mzp1KlIEJFkIQnAlwmK6y4m4Fi2IwehbH8gwJk+ejG5WVlYIYXF25syZDzj2ISIKCQk5cuQIolU0enl5IeahXEtLS3NwcBBnc2LKz893dHScMWPG8OHDcQmWjZgNARjCsBEjRhw4cACXYybDhg1zdnYODQ3F7Ae5Dxo71mf8+PEImSoqKhAxWlpa0v4I/DAm7oJ74Y70Fpg5BsRZgAGc0D8iIgLtWBSWgMZx48aBuQhB3dzcqMAtWbIE4RwKkAyPwR7gLMpJSUmIGClCWKadnR1uilkdP34cVyFvRcANhowaNQqZ36xZszDyyJEj6fvPwHK092isAiE+fQ9nxYoVAwYMwMLRghRiy5Yt6GlmZoZxEKAiEEXCQBdFQ0ryyhl4hPVjNlg8cnssm35Jgz6DiY2NRSaIKtYPkUdKgRkASPTp0b07VoJTyPYBHj7RH1WoArJX+t0EYN+xY0fklShLUkZGBu0MbH788cddu3dhWhs3bgQwEB9keQiL0YIqJubt7Q12GBkZUUnEhUi8wCx80v64I9oxSOcunTE9yDIgRCJ55sxpDLV27RqsFjMHo5FCAh5IG5gLbiLgBnLIYOijB2CPhBQFEJJocBZZap8+fZAS0UYwDtE27oiQ3cLCAhm3ubk57gUGovHN69eQUfp9G8CPwXFHKn9glImJCUR54oQJQAVD7d+/v127drAQICBEhRKrxlV0UbgK3RjohORmMGC3trbGJ8pxcXFQLypB9CwIGQbdF4F09DU0pOk3OIt5YNI//fQTxBCchVjhxtAqSBNYAKkRWwlKEHDa2cfHZ/DgwcAbV0GrMA6Sc6Di5OQkmSFhtE6dOkFW0AGKgvWA6d26dUMLkhKa94ChO7OzIc6HDh1Ci3h3h1JUVBRUDf3DI8Jpy5UrVxzs7ZOTk6dMmQKdADbQWjCOngVhwBYtWsBa8HVup1X8HhmkPiUlBXKDmYNRsAEQFIyDjCosLAxshIhj4VQRQbAE4CRSQ8gQckEkc8iWKFugT/R7O1Cj3r17ow8WRbevSEosziWxMIgqpAAAogoWQMqAEH3SRQnagAmhAIQgXE+455IbNmxAT4gG2ArlAOMiIyPRDhnv0qULMGjcuDF9l1pMSMixGFzYtWtX6DFaoOyQCeTnEFvoKwwUvAXtnJeXh+kaGhpCFHB3uk0JowEwIL/IHDEZWBh9fX0IRM+ePcFHXIIR6OXQmKNHj2JwIIS1LFm6hLZjSpgDEIKgFBQUmJqaYu3oSc+CgBmEhq9whLWI3ynHNGCm0AFMw5wpErCBYC5WBBMC7kNfz507R/sDHugfuA9gwB8DAwMsFu3QeEwDE0AZMMMAQnSwKN4PQcD79esH7cMCgB6ugUSD3Vgh9Bd8jI+Px12hH5s2bYLeoUBlE0yEEMG4IcHGPMA72FD6kjSm27lzZ6wcIxQVFcGrYU7gHcSkpKQEHUDoTLeIsDAoO9QFAgsd3717N2QW3XA7UxMTGCVMAHIK82tk1I/ucYH1WCp1CUARkzxx4gQ0D+qFe2EJ0E4oGUwWFozpge/oDM5CgXA7Y2NjGGToCqadnp4OkYJFwrCAHOZOUnFxd0gwX+EIzoZo6s6dgAq29+bNm927d8dokHJMA6YM+n371scv8kVHR1tbWwEtcAPsBWcgVVgjTsF9oAWyBSDBKAokdAtcpYuCwqCFxHJZWVmw7FBw+ioB1gCcxcKCqHR2DWH9gFfsVGDiYDQh1PQJ9/nz58W7LJC+RYsWiXveu3cPjAgMDIQW0xbcS9wZUoIJZWfvhGTgLhAiVNG+efNmTGz6tGlYGLCBDFHTDL7QR2SYJ/rjKtgTnL1x4wY3Hgtths49eHAfkGMhOIVGaAzd44HQ4BLIBxaOKoQXE0ABnIIhEg8CwmKpzxATRsC1uC/CDcg4xBQrAvCYBj4h+OgvGbaB0IJ74SrcF1XwRPydTsgELkEB8goWoQBRo6NB2qgd+qb50OXLl6mH+5e+nMi3BqBWQ4YMgXGTpM9bfo9q9YQb5EufETwNiK98Gf3mNP7DLT6n31vI5+1fNexX0Zcws9bdYaKh/QQhqC1cCIz+v/SPIoBC9+D/3Zf7p9NfgBBSGcm3FWsRPDwIsRmiYRTgWvkTHL1D3iixeyQmZMRw4whVECMhGMWFiGglr6VvEdEyskU4WHQT7xVRgs9DmMNXOMK9EM6gJ1+vocdPHlM3/p8JfrRWNwxFg5f/P/oLEEKsSb+6hvWLA4Fnz57R4AS5G/Iq8PfY8WPweciOsSpETfgExxE0JyUno9vjx48lXyxFwN2jR4+goCBE9jDHOIu7oB2xKVJXFPz9/cPDSeIJBiHSg0FAaoK0Bi3ACTEYCggFhw8fjgIlJHm4O0w8yoBcnEiCjh47iiAYBUxbHMvhXpJTAiFrwaxwLcpYAjojhsQSUMU06OuYILTXuvDP0F+AUFpaGrJoiDzSVaTQiBFPnz4FtiJtRBSLzBk+EOxLTEpq3bo1EpTly5cjHkVOgCAYCc2IESPgC+FL4RsRdNIxYYWRpdMyUkJUATMuwbDIXaBYFhbmyFTAIAsLC+ShSKsRlyO9QL6JtAFpGXJGIESTaxDa6S3c3NygzZAVmlfSB+QQINwO4TsuxCXIwKCUSHcAmzidR7COW9DntpCtIZ6eyPCQeNnY2AB4XI6QGvPHIGjHPD/f6Ppj9BcghGlBoiG/SEshgOACHB3mDTCQhSFVBIRr1qyJio7GMs6cOQPOQr2gE0gpoCUoIMDDwnCtpaUl3bTFCFQvQYSVq1YhnwBIGBYAw9QgP0eChdQB6QjSi/Hjx6WkpCDfwiBr167FsEjDo6KiaAYNQpoJgGGmwGXkcBT13j//fOH8eZzNz8/H3DAsNB4pFIJbJDHWNta4FzJlOgImMGSIJ6DFAjFJExMTKAoSGiwQ10I1ISVIgSGg1tbWUCyab/55+musHFa1dOlSmB34BrD7yJEjyNUnjJ+APB8woIxlIKuFlBUUXIAsi9cGKQZncQkSN7gTrJAaMbAPsgx7Ul5eTjccoTqHDx/GUChAIPz8/NAH94XuwhFOnDgBDFqxYgXEBYKPewFszEf8ahXEIi8vD4PjcigZrN/Bgweh+tTWUR2CSCFPxJSg90h4cS9cTrcboPTGxsZEzqKijIyMcIpqJ0QBC5w8eTLd0EOSjmEzNmRAMkaNGgVLSO795+gvQAj5P3gdHR2Vlpb68uVLaBKkFebL3t4eK8nJybF3sIcw5ubmLly4EIyIiYnp1auXmZkZ7ABE1cXFBXYD2AAJ9KdjHj1ypEuXLrBgVlaWMJVwIVg8boRuEH9cBceDC5F779u3D85v8eLFdJsZBXxCFMAgYEY9EwhnMRpuCqGpqCiHlEDSgQcNLhA+wFTCZoL7gASXY250CXRjBVbaz4//8inmD0Wke5UHDhzAtPfs2YMBcV+oL8DGJB0cHNDtn4LQv/T/Sv8i9E+nfxH6ZxPL/h9DpTul9ptE3gAAAABJRU5ErkJggg==',

     nidos_logo: 'data:image/png;base64,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'

      },

    	defaultStyle: {
    		// alignment: 'justify'
    	}

    }

	//pdfMake.createPdf(dd).open();
	pdfMake.createPdf(dd).download("ReporteAtencionGrupo.pdf");
  }



//************************* CONSOLIDADO MENSUAL ATENCIONES POR DUPLA


function procesarInfoPDFMensual(idMesReporte) { 
  var datosPDFMensual = cargarEncabezadoReporteMensual(idMesReporte);
  var GruposMes = cargarInfoGruposMes(idMesReporte);
  var totalesMensualPDF = cargarTotalesReporteMensualPDF(idMesReporte);

  datosPDFMensual.GruposMesTabla = [];
  datosPDFMensual.totalesMensualPDF = [];

  datosPDFMensual.GruposMesTabla.push(
    [{text:'LUGAR ATENCIÓN',style: 'titles'},
    {text:'NIVEL',style: 'titles'},
    {text:'ENTIDAD',style: 'titles'},
    {text:'TIPO LUGAR',style: 'titles'},
    {text:'# ATENCIONES',style: 'titles'},
    {text:'BENEFICIARIOS NUEVOS',style: 'titles'},
    {text:'DE 1ER MES A 3 AÑOS',style: 'titles'},
    {text:'DE 4 A 6 AÑOS',style: 'titles'},
    {text:'MADRES GESTANTES',style: 'titles'},
    {text:'TOTAL ASISTENTES',style: 'titles'}],
  );
 GruposMes.forEach(function(grupo) {

     datosPDFMensual.GruposMesTabla.push(
        [{text:grupo.LUGAR,style: 'campos', fillColor: '#FDF2E9'},{text:grupo.NOMGRUPO,style: 'campos', fillColor: '#FDF2E9'},{text:grupo.ENTIDAD,style: 'campos', fillColor: '#FDF2E9'},{text:grupo.TLUGAR,style: 'campos', fillColor: '#FDF2E9'},{text:grupo.EXPERIENCIA, style: 'campos', fillColor: '#FDF2E9'},{text:grupo.TOTAL_N,style: 'campos', fillColor: '#D4E6F1'},{text:grupo.TOTAL_DE_0_3_ANIOS_R,style: 'campos', fillColor: '#D1F2EB'},{text:grupo.TOTAL_DE_4_6_ANIOS_R,style: 'campos', fillColor: '#D1F2EB'},{text:grupo.GESTANTES_R,style: 'campos', fillColor: '#D1F2EB'},{text:grupo.TOTAL_R,style: 'campos', fillColor: '#76D7C4'}],

      );
  });


  totalesMensualPDF.forEach(function(totales) {

      datosPDFMensual.totalesMensualPDF.push(
         [{text:'TOTALES DEL MES:',style: 'campos', fillColor: '#FDF2E9'},{text:totales.EXPERIENCIA,style: 'campos', fillColor: '#FDF2E9'},{text:totales.TOTAL_N,style: 'campos', fillColor: '#D4E6F1'},{text:totales.TOTAL_DE_0_3_ANIOS_R,style: 'campos', fillColor: '#D1F2EB'},{text:totales.TOTAL_DE_4_6_ANIOS_R,style: 'campos', fillColor: '#D1F2EB'},{text:totales.GESTANTES_R, style: 'campos', fillColor: '#D1F2EB'},{text:totales.TOTAL_R,style: 'campos', fillColor: '#76D7C4'}],

       );
   });


  descargarPDFMensual(datosPDFMensual);
}


function descargarPDFMensual(datosPDFMensual) {
  var count = 0 ;
  var bandera = false;
  var dd = {
      pageMargins:[20,15,20,20],
      pageSize: 'letter',
      pageOrientation: 'landscape',
      header:
      {

      },

    content: [

      {
      	  margin: [0, 10, 0, 0],
      	  style: 'tableExample',
      	  table: {
      	  widths: [100,"*",100],
      	  body: [
      	  [{image: 'idartes_logo',width: 50,rowSpan: 2,style: 'titles',margin: [0, 2, 0, 0]},{text:'GESTIÓN PARA LA APROPIACIÓN DE LAS ARTÍSTICAS ATENCIÓN A PRIMERA INFANCIA',style: 'titles',margin: [0, 5, 0, 5]},{image: 'nidos_logo',width: 80,rowSpan: 2,style: 'titles',margin: [0, 2, 0, 0]}],
      	  [{},{text:'ASISTENCIA ÁMBITO FAMILIAR Y COMUNIDAD',style: 'titles',margin: [0, 8, 0, 0]},{}],
      		]
     		},layout: {
      	  vLineWidth: function (i, node) {
      	  return 0.5;
      	},
      	 hLineWidth: function (i, node) {
      	  return 0.5;
      	},
        }
      },
  	{
      		    margin: [0, 0, 0, 0],
      			style: 'tableExample',
      			table: {
      			    widths: [240,240,"*"],
      				body: [
      				[{text:'TIPO DE DUPLA',style: 'titles', border: [true, false, true, true]},
      				{text:'CÓDIGO DE DUPLA',style: 'titles', border: [true, false, true, true]},
      				{text:'ARTISTAS',style: 'titles', border: [true, false, true, true]}],
      				[{text:datosPDFMensual.TIPODUPLA,style: 'campos'},{text:datosPDFMensual.CODIGODUPLA,style: 'campos'},{text:datosPDFMensual.ARTISTAS,style: 'campos'}],

      				[{text:'TERRITORIO',style: 'titles', border: [true, false, true, true]},
      				{text:'GESTOR TERRITORIAL',style: 'titles', border: [true, false, true, true]},
      				{text:'EAAT',style: 'titles', border: [true, false, true, true]}],
      				[{text:datosPDFMensual.TERRITORIO,style: 'campos'},{text:datosPDFMensual.GESTOR,style: 'campos'},{text:datosPDFMensual.EAAT,style: 'campos'}],

      				]
      			},layout: {
      				vLineWidth: function (i, node) {
      					return 0.5;
      				},
      				hLineWidth: function (i, node) {
      					return 0.5;
      				},
      			}
      		},
  	        {
      		    margin: [0, 0, 0, 0],
      			style: 'tableExample',
      			table: {
      			    widths: ["*"],
      				body: [
      				[{text:'INFORMACIÓN MENSUAL POR GRUPO',style: 'titles', fillColor: '#dddddd', border: [true, true, true, true]}],
      	            ]
      		    	},layout: {
      				vLineWidth: function (i, node) {
      					return 1;
      				},
      				hLineWidth: function (i, node) {
      					return 1;
      				},
      			}
      		},

          {
      		    margin: [0, 0, 0, 0],
      			style: 'tableExample',
      			table: {
      			    widths: ["*",70,60,110,50,50,50,50,50,50],
      				body: datosPDFMensual.GruposMesTabla
      			},layout: {
      				vLineWidth: function (i, node) {
      					return 0.5;
      				},
      				hLineWidth: function (i, node) {
      					return 0.5;
      				},
      			}
      		},

        {
            margin: [0, 0, 0, 0],
          style: 'tableExample',
          table: {
              widths: ["*",50,50,50,50,50,50],
            body: datosPDFMensual.totalesMensualPDF
          },layout: {
            vLineWidth: function (i, node) {
              return 0.5;
            },
            hLineWidth: function (i, node) {
              return 0.5;
            },
          }
        },


  ],


    styles: {
      header: {
        fontSize: 18,
        bold: true,
        margin: [0, 0, 0, 10]
      },
      subheader: {
        fontSize: 16,
        bold: true,
        margin: [0, 10, 0, 5]
      },
      tableExample: {
        margin: [0, 5, 0, 15]
      },
      titles:{
          bold: true,
          alignment:'center',
          fontSize: 7,
        color: 'black'
      },
      campos:{
          alignment:'center',
          fontSize: 7,
        color: 'black'
      },
      titles:{
          bold: true,
          alignment:'center',
          fontSize: 7,
        color: 'black'
      },
      tableHeader: {
        bold: true,
        fontSize: 13,
        color: 'black'
      }
    },

    images: {
      idartes_logo: 'data:image/png;base64,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',

   nidos_logo: 'data:image/png;base64,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'

    },

    defaultStyle: {

    }

  }

//pdfMake.createPdf(dd).open();

pdfMake.createPdf(dd).download("ReporteMensualDupla.pdf");

}




});
