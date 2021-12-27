// var url_service = '../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
// var url_service_mapa = '../src/Administracion/Controlador/AparienciaController.php';
// var numeral = "";
// var filtros_aplicados = "";
// var valores_filtros = "";
// var dataProvider_column = '[{"X": "USA","Y": "4025","color": "#FF0F00"}, {"X": "China","Y": "1882","color": "#FF6600"}, {"X": "Japan","Y": "1809","color": "#FF9E01"}, {"X": "Germany","Y": "1322","color": "#FCD202"}, {"X": "UK","Y": "1122","color": "#F8FF01"}, {"X": "France","Y": "1114","color": "#B0DE09"}, {"X": "India","Y": "984","color": "#04D215"}, {"X": "Spain","Y": "711","color": "#0D8ECF"}, {"X": "Netherlands","Y": "665","color": "#0D52D1"}, {"X": "Russia","Y": "580","color": "#2A0CD0"}, {"X": "SouthKorea","Y": "443","color": "#8A0CCF"}, {"X": "Canada","Y": "441","color": "#CD0D74"}, {"X": "Brazil","Y": "395","color": "#754DEB"}, {"X": "Italy","Y": "386","color": "#DDDDDD"}, {"X": "Australia","Y": "384","color": "#999999"}, {"X": "Taiwan","Y": "338","color": "#333333"}, {"X": "Poland","Y": "328","color": "#000000"}]';
// dataProvider_column = JSON.parse(dataProvider_column);
// var dataProvider_lineal = '[{"X": "USA","Y": "4025"}, {"X": "China","Y": "1882"}, {"X": "Japan","Y": "1809"}, {"X": "Germany","Y": "1322"}, {"X": "UK","Y": "1122"}, {"X": "France","Y": "1114"}, {"X": "India","Y": "984"}, {"X": "Spain","Y": "711"}, {"X": "Netherlands","Y": "665"}, {"X": "Russia","Y": "580"}, {"X": "SouthKorea","Y": "443"}, {"X": "Canada","Y": "441"}, {"X": "Brazil","Y": "395"}, {"X": "Italy","Y": "386"}, {"X": "Australia","Y": "384"}, {"X": "Taiwan","Y": "338"}, {"X": "Poland","Y": "328"}]';
// dataProvider_lineal = JSON.parse(dataProvider_lineal);
// var dataProvider_pie = '[{"X": "USA","Y": "4025"}, {"X": "China","Y": "1882"}, {"X": "Japan","Y": "1809"}]';
// dataProvider_pie = JSON.parse(dataProvider_pie);
// var dataProvider_gauge = '[{"X": "1000","Y": "2000"}]';
// dataProvider_gauge = JSON.parse(dataProvider_gauge);
// var dataProvider_column_multiple = '[{"X": "2003","C": "2.5","N": "2.5"},{"X": "2004","C": "2.6","N": "2.7"}]';
// dataProvider_column_multiple = JSON.parse(dataProvider_column_multiple);
// var tipo_grafica = "";
// var anio_inicio = "";
// $(document).ready(function(){
//   $(document).on('click', 'a[href^="#"]', function (event) {
//     event.preventDefault();
//   });

//   $(".filtro").on('change', function(){
//     valores_filtros = "";
//     $( ".filtro" ).each(function(){
//       if($("#div_"+$(this).attr('id')).is(":visible")){
//         var valor = $(this).val().toString();
//         valor = valor.replace(/,/g, '-');//limpiar comas del select multiple.
//         valores_filtros += $(this).attr('id')+":"+"'"+valor+"'"+',';
//       }
//     });
//     construirDataProvider(numeral, valores_filtros, "chartdiv", "");
//   });

//   $(".anio_inicio").on('click', function(){
//     $(".anio_inicio").css("backgroundColor", "transparent");
//     $(".anio_inicio").css("color", "black");
//     $(this).css("backgroundColor", "teal");
//     $(this).css("color", "white");
//     anio_inicio = $(this).html();
//     if(anio_inicio!="2016"){
//       cargarSeccionInicio("1.1");
//       cargarSeccionInicio("1.3");
//     }
//     else{
//       $("#subdireccion_anual").html("<h3 style='background-color:lightsteelblue'>63720 BENEFICIARIOS ATENDIDOS</h3>");
//       $("#atencion_programa_linea").html("<h5>CREA</h5>");
//       $("#atencion_programa_linea").append("<h4>Arte en la Escuela : 55219</h4>");
//       $("#atencion_programa_linea").append("<h4>Emprende Clan : 6011</h4>");
//       $("#atencion_programa_linea").append("<h4>Laboratorio Clan : 2490</h4>");
//       $("#atencion_programa_linea").append("<h3 style='background-color:lightsteelblue'>Total: 63720</h3>");
//     }
//   });

//   $(".seccion").on('click', function(){
//     if($(this).attr('data-seccion')==3 || $(this).attr('data-seccion')==4){
//       llenarFiltros();
//       var datos = {
//         funcion : 'getPanelCentroMonitoreo',
//         p1: {
//           'in_seccion': $(this).attr('data-seccion')
//         }
//       };
//       $.ajax({
//         url: url_service,
//         type: 'POST',
//         data: datos,
//         success: function(data){
//           try{
//             $("#div_contenedor").html(data);
//             $(".miniatura").on('click', function(){
//               if($(this).data('estado')=='1'){
//                 mostrarFiltros($(this).attr('data-filtros'));
//                 $("#modal_title").html('<img src="'+$(this).attr('data-icono')+'" width="5%;"> '+$(this).attr('data-nombre-indicador')+' - '+$(this).attr('data-etiqueta'));
//                 $("#descripcion").html($(this).attr('data-descripcion'));
//                 $("#chartdiv").html('');
//                 tipo_grafica = $(this).attr('data-tipo-grafica');
//                 numeral = $(this).attr('data-numeral');
//                 if(numeral=='2.2.1'){
//                   $("#SL_LINEA_CREA option[value='0']").each(function() {
//                     $(this).remove();
//                   });
//                   $("#SL_LINEA_CREA").append('<option value="0">TODAS</option>').selectpicker("refresh");
//                   $("#SL_LINEA_CREA").removeAttr('multiple');
//                   $('#SL_LINEA_CREA').selectpicker("refresh");
//                 }
//                 else{
//                   if(numeral=='2.1.6'){
//                     $("#SL_LINEA_CREA option[value='0']").each(function() {
//                       $(this).remove();
//                     });
//                     $("#SL_LINEA_CREA").attr('multiple', 'multiple');
//                     $('#SL_LINEA_CREA').selectpicker('destroy');
//                     $('#SL_LINEA_CREA').selectpicker();
//                   }else{
//                     $("#SL_LINEA_CREA option[value='0']").each(function() {
//                       $(this).remove();
//                     });
//                     // $("#SL_LINEA_CREA").selectpicker({maxOptions: 1});
//                     $("#SL_LINEA_CREA").removeAttr('multiple');
//                     $('#SL_LINEA_CREA').selectpicker('destroy');
//                     $('#SL_LINEA_CREA').selectpicker();
//                   }
//                 }
//                 construirDataProvider(numeral, valores_filtros, "chartdiv", "");
//               }
//             });
//           }catch(err){
//             console.error("Error al leer datos años anteriores: "+err.message);
//           }
//         }
//       });
//     }
//     else{
//      if($(this).attr('data-seccion')==1){
//       $("#year2020").trigger("click");
//       anio_inicio = (new Date()).getFullYear();
//       cargarSeccionInicio("1.1");
//       cargarSeccionInicio("1.3");
//     }
//     if($(this).attr('data-seccion')==2){
//       construirDataProvider('1.4', 'SL_ANIO:2020,', "chartdivsub1","pie");
//       construirDataProvider('1.5', 'SL_ANIO:2020,', "chartdivsub2","pie");
//       setTimeout(function(){
//         construirDataProvider('1.6', 'SL_ANIO:2020,', "chartdivsub3", "column_multiple");
//       }, 2000);
//     }
//   }
// });
//   $(".seccion[data-seccion=1]").click();


//   function cargarGraficadeBarras(tema, chartname){
//     if(tema=='dark'){
//       $("#filter_div").css("backgroundColor", 'unset');
//     }
//     else{
//       $(".modal-body").css('backgroundColor', '#ffffff');
//       $(".modal-body").css('color', '#000');
//       $("#filter_div").css("backgroundColor", 'gainsboro');
//     }

//     var chart = AmCharts.makeChart(chartname, {
//       "theme": tema,
//       "type": "serial",
//       "startDuration": 2,
//       "dataProvider": dataProvider_column,
//       "graphs": [{
//         "labelText": "[[value]]",
//         "balloonText": "[[category]]: <b>[[value]]</b>",
//         "fillColorsField": "color",
//         "fillAlphas": 1,
//         "lineAlpha": 0.1,
//         "type": "column",
//         "valueField": "Y"
//       }],
//       "depth3D": 20,
//       "angle": 30,
//       "chartCursor": {
//         "categoryBalloonEnabled": false,
//         "cursorAlpha": 0,
//         "zoomable": false
//       },
//       "categoryField": "X",
//       "categoryAxis": {
//         "gridPosition": "start",
//         "labelRotation": 40
//       },
//       "export": {
//         "enabled": true
//       }
//     });
//   }

//   function cargarGraficadeLinea(tema){
//     if(tema=='dark'){
//       $("#filter_div").css("backgroundColor", 'unset');
//       $(".modal-body").css('backgroundColor', '#30303d');
//       $(".modal-body").css('color', '#fff');
//     }
//     else{
//       $(".modal-body").css('backgroundColor', '#ffffff');
//       $(".modal-body").css('color', '#000');
//       $("#filter_div").css("backgroundColor", 'gainsboro');
//     }

//     var chart = AmCharts.makeChart("chartdiv", {
//       "theme": tema,
//       "type": "serial",
//       "marginRight": 80,
//       "autoMarginOffset": 20,
//       "marginTop":20,
//       "dataProvider": dataProvider_lineal,
//       "valueAxes": [{
//         "id": "v1",
//         "axisAlpha": 1
//       }],
//       "graphs": [{
//         "labelText": "[[value]]",
//         "useNegativeColorIfDown": true,
//         "balloonText": "[[category]]<br><b>Cantidad: [[value]]</b>",
//         "bullet": "round",
//         "bulletBorderAlpha": 1,
//         "bulletBorderColor": "#FFFFFF",
//         "hideBulletsCount": 50,
//         "lineThickness": 2,
//         "lineColor": "#fdd400",
//         "negativeLineColor": "#67b7dc",
//         "valueField": "Y"
//       }],
//       "chartScrollbar": {
//         "scrollbarHeight": 5,
//         "backgroundAlpha": 0.1,
//         "backgroundColor": "#868686",
//         "selectedBackgroundColor": "#67b7dc",
//         "selectedBackgroundAlpha": 1
//       },
//       "chartCursor": {
//         "valueLineEnabled": true,
//         "valueLineBalloonEnabled": true
//       },
//       "categoryField": "X",
//       "categoryAxis": {
//         "labelRotation": 40,
//         "parseDates": false,
//         "axisAlpha": 0,
//         "minHorizontalGap": 60
//       },
//       "export": {
//         "enabled": true
//       }
//     });

//     chart.addListener("dataUpdated", zoomChart);

//     function zoomChart() {
//       if (chart.zoomToIndexes) {
//         chart.zoomToIndexes(130, dataProvider_lineal.length - 1);
//       }
//     }
//   }

//   function cargarGraficadePie(tema,chartname){
//     if(tema=='dark'){
//     }
//     else{
//       $(".modal-body").css('backgroundColor', '#ffffff');
//       $(".modal-body").css('color', '#000');
//     }
//     var chart = AmCharts.makeChart( chartname, {
//       "type": "pie",
//       "theme": tema,
//       "dataProvider": dataProvider_pie,
//       "valueField": "Y",
//       "titleField": "X",
//       "outlineAlpha": 0.4,
//       "depth3D": 15,
//       "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
//       "angle": 0,
//       "export": {
//         "enabled": true
//       }
//     } );
//   }

//   function cargarGraficadeCalibrador(tema){
//     if(tema=='dark'){
//     }
//     else{
//       $(".modal-body").css('backgroundColor', '#ffffff');
//       $(".modal-body").css('color', '#000');
//     }
//     var chart = AmCharts.makeChart("chartdiv", {
//       "theme": "light",
//       "type": "gauge",
//       "axes": [{
//         "topTextFontSize": 30,
//         "topTextYOffset": 150,
//         "axisColor": "#31d6ea",
//         "axisThickness": 1,
//         "endValue": dataProvider_gauge[0].Y,
//         "gridInside": true,
//         "inside": true,
//         "radius": "50%",
//         "valueInterval": (dataProvider_gauge[0].Y)/5,
//         "tickColor": "#67b7dc",
//         "startAngle": -90,
//         "endAngle": 90,
//         "bandOutlineAlpha": 0,
//         "bands": [{
//           "color": "#0080ff",
//           "endValue": dataProvider_gauge[0].Y,
//           "innerRadius": "105%",
//           "radius": "170%",
//           "gradientRatio": [0.5, 0, -0.5],
//           "startValue": 0
//         }, {
//           "color": "#3cd3a3",
//           "endValue": 0,
//           "innerRadius": "105%",
//           "radius": "170%",
//           "gradientRatio": [0.5, 0, -0.5],
//           "startValue": 0
//         }]
//       }],
//       "arrows": [{
//         "alpha": 1,
//         "innerRadius": "35%",
//         "nailRadius": 0,
//         "radius": "170%",
//         "value":dataProvider_gauge[0].X
//       }]
//     });
//     chart.axes[0].setTopText(Math.round((dataProvider_gauge[0].X*100)/dataProvider_gauge[0].Y)+"% CON UNA CANTIDAD DE: "+dataProvider_gauge[0].X);
//   }

//   function cargarGraficaMultiSerial(chartname, numeral){
//     $(".modal-body").css('backgroundColor', '#ffffff');
//     $(".modal-body").css('color', '#000');
//     if(numeral=='1.6'){
//       var graphs = [{
//         "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
//         "fillAlphas": 0.8,
//         "labelText": "[[value]]",
//         "lineAlpha": 0.3,
//         "title": "CREA",
//         "type": "column",
//         "color": "#000000",
//         "valueField": "C"
//       }, {
//         "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
//         "fillAlphas": 0.8,
//         "labelText": "[[value]]",
//         "lineAlpha": 0.3,
//         "title": "NIDOS",
//         "type": "column",
//         "color": "#000000",
//         "valueField": "N"
//       }];  
//     }
//     if(numeral=='2.2.9'){
//       var graphs = [{
//         "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
//         "fillAlphas": 0.8,
//         "labelText": "[[value]]",
//         "lineAlpha": 0.3,
//         "title": "COGNITIVO",
//         "type": "column",
//         "color": "#000000",
//         "valueField": "PROMEDIO_CG"
//       }, {
//         "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
//         "fillAlphas": 0.8,
//         "labelText": "[[value]]",
//         "lineAlpha": 0.3,
//         "title": "ACTITUDINAL",
//         "type": "column",
//         "color": "#000000",
//         "valueField": "PROMEDIO_AC"
//       }, {
//         "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
//         "fillAlphas": 0.8,
//         "labelText": "[[value]]",
//         "lineAlpha": 0.3,
//         "title": "CONVIVENCIAL",
//         "type": "column",
//         "color": "#000000",
//         "valueField": "PROMEDIO_CV"
//       }]; 
//     }
    
//     var chart = AmCharts.makeChart(chartname, {
//       "type": "serial",
//       "theme": "light",
//       "legend": {
//         "horizontalGap": 10,
//         "maxColumns": 1,
//         "position": "right",
//         "useGraphSettings": true,
//         "markerSize": 10
//       },
//       "dataProvider": dataProvider_column_multiple,
//       "valueAxes": [{
//         "stackType": "regular",
//         "axisAlpha": 0.3,
//         "gridAlpha": 0
//       }],
//       "graphs": graphs,
//       "categoryField": "X",
//       "categoryAxis": {
//         "gridPosition": "start",
//         "axisAlpha": 0,
//         "gridAlpha": 0,
//         "position": "left",
//         "labelRotation": 40
//       },
//       "export": {
//         "enabled": true
//       }

//     });
//   }

//   function cargarGraficaMultiLineal(chartname) {
//    $(".modal-body").css('color', '#fff');
//    var chart = AmCharts.makeChart(chartname, {
//     "type": "serial",
//     "theme": "none",
//     "legend": {
//       "useGraphSettings": true
//     },
//     "dataProvider": dataProvider_column_multiple,
//     "synchronizeGrid":true,
//     "valueAxes": [{
//       "id":"v1",
//       "axisColor": "#FF6600",
//       "axisThickness": 2,
//       "axisAlpha": 1,
//       "position": "left"
//     }, {
//       "id":"v2",
//       "axisColor": "#FCD202",
//       "axisThickness": 2,
//       "axisAlpha": 1,
//       "position": "right"
//     }, {
//       "id":"v3",
//       "axisColor": "#B0DE09",
//       "axisThickness": 2,
//       "gridAlpha": 0,
//       "offset": 50,
//       "axisAlpha": 1,
//       "position": "left"
//     }],
//     "graphs": [{
//       "valueAxis": "v1",
//       "lineColor": "#FF6600",
//       "bullet": "round",
//       "bulletBorderThickness": 1,
//       "hideBulletsCount": 30,
//       "title": "COGNITIVO",
//       "valueField": "PROMEDIO_CG",
//       "fillAlphas": 0
//     }, {
//       "valueAxis": "v2",
//       "lineColor": "#FCD202",
//       "bullet": "square",
//       "bulletBorderThickness": 1,
//       "hideBulletsCount": 30,
//       "title": "ACTITUDINAL",
//       "valueField": "PROMEDIO_AC",
//       "fillAlphas": 0
//     }, {
//       "valueAxis": "v3",
//       "lineColor": "#B0DE09",
//       "bullet": "triangleUp",
//       "bulletBorderThickness": 1,
//       "hideBulletsCount": 30,
//       "title": "CONVIVENCIAL",
//       "valueField": "PROMEDIO_CV",
//       "fillAlphas": 0
//     }],
//     "chartScrollbar": {},
//     "chartCursor": {
//       "cursorPosition": "middle",
//       "leaveCursor": true,
//       "categoryBalloonEnabled": true
//     },
//     "categoryField": "X",
//     "categoryAxis": {
//       "parseDates": false,
//       "axisColor": "#DADADA",
//       "minorGridEnabled": true
//     },
//     "export": {
//       "enabled": true,
//       "position": "bottom-right"
//     }
//   });

//    // chart.addListener("dataUpdated", zoomChart);
//    // zoomChart();


// // // generate some random data, quite different range
// // function generateChartData() {
// //   var chartData = [];
// //   var firstDate = new Date();
// //   firstDate.setDate(firstDate.getDate() - 100);

// //   var visits = 1600;
// //   var hits = 2900;
// //   var views = 8700;


// //   for (var i = 0; i < 100; i++) {
// //         // we create date objects here. In your data, you can have date strings
// //         // and then set format of your dates using chart.dataDateFormat property,
// //         // however when possible, use date objects, as this will speed up chart rendering.
// //         var newDate = new Date(firstDate);
// //         newDate.setDate(newDate.getDate() + i);

// //         visits += Math.round((Math.random()<0.5?1:-1)*Math.random()*10);
// //         hits += Math.round((Math.random()<0.5?1:-1)*Math.random()*10);
// //         views += Math.round((Math.random()<0.5?1:-1)*Math.random()*10);

// //         chartData.push({
// //           date: newDate,
// //           visits: visits,
// //           hits: hits,
// //           views: views
// //         });
// //       }
// //       return chartData;
// //     }

// // function zoomChart(){
// //   chart.zoomToIndexes(chart.dataProvider.length - 20, chart.dataProvider.length - 1);
// // }
// }

// function mapaLocalidades(){
//   var map;
//   var map = AmCharts.makeChart( "chartdiv", {
//     "type": "map",
//     //"theme": "light",
//     "dataProvider": {
//       "mapURL": "LibreriasExternas/mapas/LocalidadesBogota.svg",
//       "getAreasFromMap": true,
//       "zoomLevel": 0.95,
//       "areas": [{
//         title: "USAQUEN",
//         id: "CO-BO1",
//         color: "#00547b",
//         customData: "<b>Nidos:</b> 1 <br><b>Crea:</b> <div id='USAQUEN' name='USAQUEN'>1005</div>",
//       },{
//         title: "CHAPINERO",
//         id: "CO-BO2",
//         color: "#29abe2",
//         customData: "<b>Nidos:</b> 2 <br><b>Crea:</b> <div id='CHAPINERO' name='CHAPINERO'></div>",
//       },{
//         title: "BARRIOS UNIDOS",
//         id: "CO-BO3",
//         color: "#00547b",
//         customData: "<b>Nidos:</b> 3 <br><b>Crea:</b> <div id='BARRIOSUNIDOS' name='BARRIOSUNIDOS'></div>",
//       },{
//         title: "TEUSAQUILLO",
//         id: "CO-BO4",
//         color: "#00a99d",
//         customData: "<b>Nidos:</b> 4 <br><b>Crea:</b> <div id='TEUSAQUILLO' name='TEUSAQUILLO'></div>",
//       },{
//         title: "SUBA",
//         id: "CO-BO5",
//         color: "#00a99d",
//         customData: "<b>Nidos:</b> 5 <br><b>Crea:</b> <div id='SUBA' name='SUBA'></div>",
//       },{
//         title: "ENGATIVA",
//         id: "CO-BO6",
//         color: "#2e3192",
//         customData: "<b>Nidos:</b> 6 <br><b>Crea:</b> <div id='ENGATIVA' name='ENGATIVA'></div>",
//       },{
//         title: "FONTIBON",
//         id: "CO-BO7",
//         color: "#00547b",
//         customData: "<b>Nidos:</b> 7 <br><b>Crea:</b> <div id='FONTIBON' name='FONTIBON'></div>",
//       },{
//         title: "CANDELARIA",
//         id: "CO-BO8",
//         color: "#5e6c68",
//         customData: "<b>Nidos:</b> 8 <br><b>Crea:</b> <div id='CANDELARIA' name='CANDELARIA'></div>",
//       },{
//         title: "SANTA FE",
//         id: "CO-BO9",
//         color: "#2e3192",
//         customData: "<b>Nidos:</b> 9 <br><b>Crea:</b> <div id='SANTAFE' name='SANTAFE'></div>",
//       },{
//         title: "MARTIRES",
//         id: "CO-BO10",
//         color: "#00547b",
//         customData: "<b>Nidos:</b> 10 <br><b>Crea:</b> <div id='MARTIRES' name='MARTIRES'></div>",
//       },{
//         title: "ANTONIO NARIÑO",
//         id: "CO-BO11",
//         color: "#29abe2",
//         customData: "<b>Nidos:</b> 11 <br><b>Crea:</b> <div id='ANTONIONARIÑO' name='ANTONIONARIÑO'></div>",
//       },{
//         title: "PUENTE ARANDA",
//         id: "CO-BO12",
//         color: "#5e6c68",
//         customData: "<b>Nidos:</b> 12 <br><b>Crea:</b> <div id='PUENTEARANDA' name='PUENTEARANDA'></div>",
//       },{
//         title: "RAFAEL URIBE URIBE",
//         id: "CO-BO13",
//         color: "#00547b",
//         customData: "<b>Nidos:</b> 13 <br><b>Crea:</b> <div id='RAFAELURIBEURIBE' name='RAFAELURIBEURIBE'></div>",
//       },{
//         title: "SAN CRISTOBAL",
//         id: "CO-BO14",
//         color: "#00a99d",
//         customData: "<b>Nidos:</b> 14 <br><b>Crea:</b> <div id='SANCRISTOBAL' name='SANCRISTOBAL'></div>",
//       },{
//         title: "SUMAPAZ",
//         id: "CO-BO15",
//         color: "#01937c",
//         customData: "<b>Nidos:</b> 15 <br><b>Crea:</b> <div id='SUMAPAZ' name='SUMAPAZ'></div>",
//       },{
//         title: "USME",
//         id: "CO-BO16",
//         color: "#89ddaf",
//         customData: "<b>Nidos:</b> 16 <br><b>Crea:</b> <div id='USME' name='USME'>200</div>",
//       },{
//         title: "TUNJUELITO",
//         id: "CO-BO17",
//         color: "#00547b",
//         customData: "<b>Nidos:</b> 17 <br><b>Crea:</b> <div id='TUNJUELITO' name='TUNJUELITO'></div>",
//       },{
//         title: "CIUDAD BOLIVAR",
//         id: "CO-BO18",
//         color: "#01937c",
//         customData: "<b>Nidos:</b> 18 <br><b>Crea:</b> <div id='CIUDADBOLIVAR' name='CIUDADBOLIVAR'></div>",
//       },{
//         title: "KENNEDY",
//         id: "CO-BO19",
//         color: "#29abe2",
//         customData: "<b>Nidos:</b> 19 <br><b>Crea:</b> <div id='KENNEDY' name='KENNEDY'></div>",
//       },{
//         title: "BOSA",
//         id: "CO-BO20",
//         color: "#00547b",
//         customData: "<b>Nidos:</b> 20 <br><b>Crea:</b> <div id='BOSA' name='BOSA'></div>",
//       },]
//     },
//     "areasSettings": {
//       "autoRotateAngle": 90,
//       "autoZoom": true,
//       unlistedAreasColor: "#357566",
//       rollOverOutlineColor: "#eeeeee",
//       rollOverColor: "#357566",
//       rollOutlineAlpha: 3,
//       rollOutlineColor: "#eeeeee",
//       rollOutlineThickness: 5,
//       selectedColor: "#115f3e",
//       "balloonText": "<b>[[title]]</b><br> [[customData]]"
//     },
//     "imagesSettings": {
//       "labelPosition": "middle",
//       "labelFontSize": 10,
//       "labelColor": "#ffffff",
//       "labelRollOverColor": "#ffffff"
//     },
//     "zoomControl": {
//       "minZoomLevel": 0.9
//     },
//     "titles": "Bogotá"
//   } );

// map.addListener( "init", function() {
//   setTimeout( function() {

//     map.dataProvider.images = [];
//     for ( x in map.dataProvider.areas ) {
//       var area = map.dataProvider.areas[ x ];
//       var image = new AmCharts.MapImage();
//       image.latitude = map.getAreaCenterLatitude( area );
//       image.longitude = map.getAreaCenterLongitude( area );
//       image.label = area.title;
//       image.linkToObject = area;
//       if (area.title == "USAQUEN")
//         image.latitude = image.latitude+0.2;
//       if (area.title == "CHAPINERO"){
//         image.labelColor = "#000000";
//         image.labelRollOverColor = "#000000";
//         image.latitude = image.latitude-0.7;
//       }
//       if (area.title == "SUBA"){
//         image.latitude = image.latitude+28;
//         image.longitude = image.longitude+15;
//         image.labelColor = "#000000";
//         image.labelRollOverColor = "#000000";
//       }
//       if (area.title == "BARRIOS UNIDOS"){
//         image.latitude = image.latitude+3;
//       }
//       if (area.title == "TEUSAQUILLO"){
//         image.latitude = image.latitude+1;
//         image.longitude = image.longitude+3;
//       }
//       if (area.title == "ENGATIVA"){
//         image.latitude = image.latitude+55;
//         image.longitude = image.longitude+15;
//       }
//       if (area.title == "FONTIBON"){
//         image.latitude = image.latitude-15;
//         image.longitude = image.longitude-5;
//       }
//       if (area.title == "KENNEDY"){
//         image.latitude = image.latitude+15;
//         image.longitude = image.longitude+10;
//       }
//       if (area.title == "BOSA"){
//         image.latitude = image.latitude-3.1;
//         image.longitude = image.longitude+5;
//       }
//       if (area.title == "TUNJUELITO"){
//         image.latitude = image.latitude+8;
//         image.longitude = image.longitude-15;
//       }
//       if (area.title == "CIUDAD BOLIVAR"){
//         image.latitude = image.latitude+13;
//         image.longitude = image.longitude+13;
//       }
//       if (area.title == "USME"){
//         image.latitude = image.latitude-11;
//         image.labelColor = "#000000";
//         image.labelRollOverColor = "#000000";
//       }
//       if (area.title == "SANTA FE"){
//         image.latitude = image.latitude+1.9;
//         image.longitude = image.longitude-15;
//       }
//       if (area.title == "CANDELARIA"){
//         image.latitude = image.latitude+2;
//           //image.longitude = image.longitude-15;
//           image.labelColor = "#000000";
//           image.labelRollOverColor = "#000000";
//         }
//         if (area.title == "RAFAEL URIBE URIBE"){
//           image.latitude = image.latitude+2;
//           image.label = "RAFAEL URIBE\nURIBE";
//           image.longitude = image.longitude-7;
//         }
//         if (area.title == "ANTONIO NARIÑO"){
//           image.latitude = image.latitude+25;
//           image.label = "ANTONIO\nNARIÑO";
//           image.longitude = image.longitude;
//           image.labelColor = "#000000";
//           image.labelRollOverColor = "#000000";
//         }
//         if (area.title == "MARTIRES"){
//           image.latitude = image.latitude+1;
//           image.longitude = image.longitude+3;
//         }
//         if (area.title == "SUMAPAZ"){
//           image.labelColor = "#000000";
//           image.labelRollOverColor = "#000000";
//           image.longitude = image.longitude+3;
//         }
//         map.dataProvider.images.push( image );
//       }
//       map.validateData();
//     }, 100 );
// } );
// function handleMapObjectClick(event) {
//   if (event.mapObject.title != undefined){
//     $("#content").html(event.mapObject.title);
//     console.log(event.mapObject.id);
//     console.log(event.mapObject.title);
//   }
//   else{
//     $("#content").html(event.mapObject.linkToObject.title);
//     console.log(event.mapObject.linkToObject.id);
//     console.log(event.mapObject.linkToObject.title);
//   }
// }

// map.addListener("clickMapObject", handleMapObjectClick);

// var datos = {
//   funcion : 'getEstadisticasLocalidades',
//   p1: (new Date()).getFullYear()
// };
// $.ajax({
//   url: url_service_mapa,
//   type: 'POST',
//   data: datos,
//   dataType: 'json',
//   success: function(data){
//     try{
//       var USAQUEN_AE =0;
//       var CHAPINERO_AE =0;
//       var BARRIOSUNIDOS_AE =0;
//       var TEUSAQUILLO_AE =0;
//       var SUBA_AE =0;
//       var ENGATIVA_AE =0;
//       var FONTIBON_AE =0;
//       var CANDELARIA_AE =0;
//       var SANTAFE_AE =0;
//       var MARTIRES_AE =0;
//       var ANTONIONARIÑO_AE =0;
//       var PUENTEARANDA_AE =0;
//       var RUU_AE =0;
//       var SANCRISTOBAL_AE =0;
//       var SUMAPAZ_AE =0;
//       var USME_AE =0;
//       var TUNJUELITO_AE =0;
//       var CIUDADBOLIVAR_AE =0;
//       var KENNEDY_AE =0;
//       var BOSA_AE =0;

//       var USAQUEN_EC =0;
//       var CHAPINERO_EC =0;
//       var BARRIOSUNIDOS_EC =0;
//       var TEUSAQUILLO_EC =0;
//       var SUBA_EC =0;
//       var ENGATIVA_EC =0;
//       var FONTIBON_EC =0;
//       var CANDELARIA_EC =0;
//       var SANTAFE_EC =0;
//       var MARTIRES_EC =0;
//       var ANTONIONARIÑO_EC =0;
//       var PUENTEARANDA_EC =0;
//       var RUU_EC =0;
//       var SANCRISTOBAL_EC =0;
//       var SUMAPAZ_EC =0;
//       var USME_EC =0;
//       var TUNJUELITO_EC =0;
//       var CIUDADBOLIVAR_EC =0;
//       var KENNEDY_EC =0;
//       var BOSA_EC =0;

//       var USAQUEN_LC =0;
//       var CHAPINERO_LC =0;
//       var BARRIOSUNIDOS_LC =0;
//       var TEUSAQUILLO_LC =0;
//       var SUBA_LC =0;
//       var ENGATIVA_LC =0;
//       var FONTIBON_LC =0;
//       var CANDELARIA_LC =0;
//       var SANTAFE_LC =0;
//       var MARTIRES_LC =0;
//       var ANTONIONARIÑO_LC =0;
//       var PUENTEARANDA_LC =0;
//       var RUU_LC =0;
//       var SANCRISTOBAL_LC =0;
//       var SUMAPAZ_LC =0;
//       var USME_LC =0;
//       var TUNJUELITO_LC =0;
//       var CIUDADBOLIVAR_LC =0;
//       var KENNEDY_LC =0;
//       var BOSA_LC =0;

//       var USAQUEN_NIDOS =0;
//       var CHAPINERO_NIDOS =0;
//       var BARRIOSUNIDOS_NIDOS =0;
//       var TEUSAQUILLO_NIDOS =0;
//       var SUBA_NIDOS =0;
//       var ENGATIVA_NIDOS =0;
//       var FONTIBON_NIDOS =0;
//       var CANDELARIA_NIDOS =0;
//       var SANTAFE_NIDOS =0;
//       var MARTIRES_NIDOS =0;
//       var ANTONIONARIÑO_NIDOS =0;
//       var PUENTEARANDA_NIDOS =0;
//       var RUU_NIDOS =0;
//       var SANCRISTOBAL_NIDOS =0;
//       var SUMAPAZ_NIDOS =0;
//       var USME_NIDOS =0;
//       var TUNJUELITO_NIDOS =0;
//       var CIUDADBOLIVAR_NIDOS =0;
//       var KENNEDY_NIDOS =0;
//       var BOSA_NIDOS =0;
//       $.each(data, function(i)
//       {
//         if(data[i].LINEA=='AE'){
//           USAQUEN_AE += (data[i].LOCALIDAD=="USAQUÉN") ? parseInt(data[i].BENEFICIARIOS):0;
//           CHAPINERO_AE += (data[i].LOCALIDAD=="CHAPINERO") ? parseInt(data[i].BENEFICIARIOS):0;
//           BARRIOSUNIDOS_AE += (data[i].LOCALIDAD=="BARRIOS UNIDOS") ? parseInt(data[i].BENEFICIARIOS):0;
//           TEUSAQUILLO_AE += (data[i].LOCALIDAD=="TEUSAQUILLO") ? parseInt(data[i].BENEFICIARIOS):0;
//           SUBA_AE += (data[i].LOCALIDAD=="SUBA") ? parseInt(data[i].BENEFICIARIOS):0;
//           ENGATIVA_AE += (data[i].LOCALIDAD=="ENGATIVÁ") ? parseInt(data[i].BENEFICIARIOS):0;
//           FONTIBON_AE += (data[i].LOCALIDAD=="FONTIBÓN") ? parseInt(data[i].BENEFICIARIOS):0;
//           CANDELARIA_AE += (data[i].LOCALIDAD=="CANDELARIA") ? parseInt(data[i].BENEFICIARIOS):0;
//           SANTAFE_AE += (data[i].LOCALIDAD=="SANTA FE") ? parseInt(data[i].BENEFICIARIOS):0;
//           MARTIRES_AE += (data[i].LOCALIDAD=="MÁRTIRES") ? parseInt(data[i].BENEFICIARIOS):0;
//           ANTONIONARIÑO_AE += (data[i].LOCALIDAD=="ANTONIO NARIÑO") ? parseInt(data[i].BENEFICIARIOS):0;
//           PUENTEARANDA_AE += (data[i].LOCALIDAD=="PUENTE ARANDA") ? parseInt(data[i].BENEFICIARIOS):0;
//           RUU_AE += (data[i].LOCALIDAD=="RAFAEL URIBE") ? parseInt(data[i].BENEFICIARIOS):0;
//           SANCRISTOBAL_AE += (data[i].LOCALIDAD=="SAN CRISTOBAL") ? parseInt(data[i].BENEFICIARIOS):0;
//           SUMAPAZ_AE += (data[i].LOCALIDAD=="SUMAPAZ") ? parseInt(data[i].BENEFICIARIOS):0;
//           USME_AE += (data[i].LOCALIDAD=="USME") ? parseInt(data[i].BENEFICIARIOS):0;
//           TUNJUELITO_AE += (data[i].LOCALIDAD=="TUNJUELITO") ? parseInt(data[i].BENEFICIARIOS):0;
//           CIUDADBOLIVAR_AE += (data[i].LOCALIDAD=="CIUDAD BOLIVAR") ? parseInt(data[i].BENEFICIARIOS):0;
//           KENNEDY_AE += (data[i].LOCALIDAD=="KENNEDY") ? parseInt(data[i].BENEFICIARIOS):0;
//           BOSA_AE += (data[i].LOCALIDAD=="BOSA") ? parseInt(data[i].BENEFICIARIOS):0;
//         }

//         if(data[i].LINEA=='EC'){
//           USAQUEN_EC += (data[i].LOCALIDAD=="USAQUÉN") ? parseInt(data[i].BENEFICIARIOS):0;
//           CHAPINERO_EC += (data[i].LOCALIDAD=="CHAPINERO") ? parseInt(data[i].BENEFICIARIOS):0;
//           BARRIOSUNIDOS_EC += (data[i].LOCALIDAD=="BARRIOS UNIDOS") ? parseInt(data[i].BENEFICIARIOS):0;
//           TEUSAQUILLO_EC += (data[i].LOCALIDAD=="TEUSAQUILLO") ? parseInt(data[i].BENEFICIARIOS):0;
//           SUBA_EC += (data[i].LOCALIDAD=="SUBA") ? parseInt(data[i].BENEFICIARIOS):0;
//           ENGATIVA_EC += (data[i].LOCALIDAD=="ENGATIVÁ") ? parseInt(data[i].BENEFICIARIOS):0;
//           FONTIBON_EC += (data[i].LOCALIDAD=="FONTIBÓN") ? parseInt(data[i].BENEFICIARIOS):0;
//           CANDELARIA_EC += (data[i].LOCALIDAD=="CANDELARIA") ? parseInt(data[i].BENEFICIARIOS):0;
//           SANTAFE_EC += (data[i].LOCALIDAD=="SANTA FE") ? parseInt(data[i].BENEFICIARIOS):0;
//           MARTIRES_EC += (data[i].LOCALIDAD=="MÁRTIRES") ? parseInt(data[i].BENEFICIARIOS):0;
//           ANTONIONARIÑO_EC += (data[i].LOCALIDAD=="ANTONIO NARIÑO") ? parseInt(data[i].BENEFICIARIOS):0;
//           PUENTEARANDA_EC += (data[i].LOCALIDAD=="PUENTE ARANDA") ? parseInt(data[i].BENEFICIARIOS):0;
//           RUU_EC += (data[i].LOCALIDAD=="RAFAEL URIBE") ? parseInt(data[i].BENEFICIARIOS):0;
//           SANCRISTOBAL_EC += (data[i].LOCALIDAD=="SAN CRISTOBAL") ? parseInt(data[i].BENEFICIARIOS):0;
//           SUMAPAZ_EC += (data[i].LOCALIDAD=="SUMAPAZ") ? parseInt(data[i].BENEFICIARIOS):0;
//           USME_EC += (data[i].LOCALIDAD=="USME") ? parseInt(data[i].BENEFICIARIOS):0;
//           TUNJUELITO_EC += (data[i].LOCALIDAD=="TUNJUELITO") ? parseInt(data[i].BENEFICIARIOS):0;
//           CIUDADBOLIVAR_EC += (data[i].LOCALIDAD=="CIUDAD BOLIVAR") ? parseInt(data[i].BENEFICIARIOS):0;
//           KENNEDY_EC += (data[i].LOCALIDAD=="KENNEDY") ? parseInt(data[i].BENEFICIARIOS):0;
//           BOSA_EC += (data[i].LOCALIDAD=="BOSA") ? parseInt(data[i].BENEFICIARIOS):0;
//         }

//         if(data[i].LINEA=='LC'){
//           USAQUEN_LC += (data[i].LOCALIDAD=="USAQUÉN") ? parseInt(data[i].BENEFICIARIOS):0;
//           CHAPINERO_LC += (data[i].LOCALIDAD=="CHAPINERO") ? parseInt(data[i].BENEFICIARIOS):0;
//           BARRIOSUNIDOS_LC += (data[i].LOCALIDAD=="BARRIOS UNIDOS") ? parseInt(data[i].BENEFICIARIOS):0;
//           TEUSAQUILLO_LC += (data[i].LOCALIDAD=="TEUSAQUILLO") ? parseInt(data[i].BENEFICIARIOS):0;
//           SUBA_LC += (data[i].LOCALIDAD=="SUBA") ? parseInt(data[i].BENEFICIARIOS):0;
//           ENGATIVA_LC += (data[i].LOCALIDAD=="ENGATIVÁ") ? parseInt(data[i].BENEFICIARIOS):0;
//           FONTIBON_LC += (data[i].LOCALIDAD=="FONTIBÓN") ? parseInt(data[i].BENEFICIARIOS):0;
//           CANDELARIA_LC += (data[i].LOCALIDAD=="CANDELARIA") ? parseInt(data[i].BENEFICIARIOS):0;
//           SANTAFE_LC += (data[i].LOCALIDAD=="SANTA FE") ? parseInt(data[i].BENEFICIARIOS):0;
//           MARTIRES_LC += (data[i].LOCALIDAD=="MÁRTIRES") ? parseInt(data[i].BENEFICIARIOS):0;
//           ANTONIONARIÑO_LC += (data[i].LOCALIDAD=="ANTONIO NARIÑO") ? parseInt(data[i].BENEFICIARIOS):0;
//           PUENTEARANDA_LC += (data[i].LOCALIDAD=="PUENTE ARANDA") ? parseInt(data[i].BENEFICIARIOS):0;
//           RUU_LC += (data[i].LOCALIDAD=="RAFAEL URIBE") ? parseInt(data[i].BENEFICIARIOS):0;
//           SANCRISTOBAL_LC += (data[i].LOCALIDAD=="SAN CRISTOBAL") ? parseInt(data[i].BENEFICIARIOS):0;
//           SUMAPAZ_LC += (data[i].LOCALIDAD=="SUMAPAZ") ? parseInt(data[i].BENEFICIARIOS):0;
//           USME_LC += (data[i].LOCALIDAD=="USME") ? parseInt(data[i].BENEFICIARIOS):0;
//           TUNJUELITO_LC += (data[i].LOCALIDAD=="TUNJUELITO") ? parseInt(data[i].BENEFICIARIOS):0;
//           CIUDADBOLIVAR_LC += (data[i].LOCALIDAD=="CIUDAD BOLIVAR") ? parseInt(data[i].BENEFICIARIOS):0;
//           KENNEDY_LC += (data[i].LOCALIDAD=="KENNEDY") ? parseInt(data[i].BENEFICIARIOS):0;
//           BOSA_LC += (data[i].LOCALIDAD=="BOSA") ? parseInt(data[i].BENEFICIARIOS):0;
//         }

//         if(data[i].LINEA=='NIDOS'){
//           USAQUEN_NIDOS += (data[i].LOCALIDAD=="USAQUÉN") ? parseInt(data[i].BENEFICIARIOS):0;
//           CHAPINERO_NIDOS += (data[i].LOCALIDAD=="CHAPINERO") ? parseInt(data[i].BENEFICIARIOS):0;
//           BARRIOSUNIDOS_NIDOS += (data[i].LOCALIDAD=="BARRIOS UNIDOS") ? parseInt(data[i].BENEFICIARIOS):0;
//           TEUSAQUILLO_NIDOS += (data[i].LOCALIDAD=="TEUSAQUILLO") ? parseInt(data[i].BENEFICIARIOS):0;
//           SUBA_NIDOS += (data[i].LOCALIDAD=="SUBA") ? parseInt(data[i].BENEFICIARIOS):0;
//           ENGATIVA_NIDOS += (data[i].LOCALIDAD=="ENGATIVÁ") ? parseInt(data[i].BENEFICIARIOS):0;
//           FONTIBON_NIDOS += (data[i].LOCALIDAD=="FONTIBÓN") ? parseInt(data[i].BENEFICIARIOS):0;
//           CANDELARIA_NIDOS += (data[i].LOCALIDAD=="CANDELARIA") ? parseInt(data[i].BENEFICIARIOS):0;
//           SANTAFE_NIDOS += (data[i].LOCALIDAD=="SANTA FE") ? parseInt(data[i].BENEFICIARIOS):0;
//           MARTIRES_NIDOS += (data[i].LOCALIDAD=="MÁRTIRES") ? parseInt(data[i].BENEFICIARIOS):0;
//           ANTONIONARIÑO_NIDOS += (data[i].LOCALIDAD=="ANTONIO NARIÑO") ? parseInt(data[i].BENEFICIARIOS):0;
//           PUENTEARANDA_NIDOS += (data[i].LOCALIDAD=="PUENTE ARANDA") ? parseInt(data[i].BENEFICIARIOS):0;
//           RUU_NIDOS += (data[i].LOCALIDAD=="RAFAEL URIBE") ? parseInt(data[i].BENEFICIARIOS):0;
//           SANCRISTOBAL_NIDOS += (data[i].LOCALIDAD=="SAN CRISTOBAL") ? parseInt(data[i].BENEFICIARIOS):0;
//           SUMAPAZ_NIDOS += (data[i].LOCALIDAD=="SUMAPAZ") ? parseInt(data[i].BENEFICIARIOS):0;
//           USME_NIDOS += (data[i].LOCALIDAD=="USME") ? parseInt(data[i].BENEFICIARIOS):0;
//           TUNJUELITO_NIDOS += (data[i].LOCALIDAD=="TUNJUELITO") ? parseInt(data[i].BENEFICIARIOS):0;
//           CIUDADBOLIVAR_NIDOS += (data[i].LOCALIDAD=="CIUDAD BOLIVAR") ? parseInt(data[i].BENEFICIARIOS):0;
//           KENNEDY_NIDOS += (data[i].LOCALIDAD=="KENNEDY") ? parseInt(data[i].BENEFICIARIOS):0;
//           BOSA_NIDOS += (data[i].LOCALIDAD=="BOSA") ? parseInt(data[i].BENEFICIARIOS):0;
//         }

//         json_areas = [{
//           title: "USAQUEN",
//           id: "CO-BO1",
//           color: "#00547b",
//           customData: "<b>CREA AE: </b>"+USAQUEN_AE+"<br><b>CREA EC: </b>"+USAQUEN_EC+"<br><b>CREA LC: </b>"+USAQUEN_LC+"<br><b>NIDOS: </b>"+USAQUEN_NIDOS,
//         },{
//           title: "CHAPINERO",
//           id: "CO-BO2",
//           color: "#29abe2",
//           customData: "<b>CREA AE: </b>"+CHAPINERO_AE+"<br><b>CREA EC: </b>"+CHAPINERO_EC+"<br><b>CREA LC: </b>"+CHAPINERO_LC+"<br><b>NIDOS: </b>"+CHAPINERO_NIDOS,
//         },{
//           title: "BARRIOS UNIDOS",
//           id: "CO-BO3",
//           color: "#00547b",
//           customData: "<b>CREA AE: "+BARRIOSUNIDOS_AE+"<br><b>CREA EC: </b>"+BARRIOSUNIDOS_EC+"<br><b>CREA LC: </b>"+BARRIOSUNIDOS_LC+"<br><b>NIDOS: </b>"+BARRIOSUNIDOS_NIDOS,
//         },{
//           title: "TEUSAQUILLO",
//           id: "CO-BO4",
//           color: "#00a99d",
//           customData: "<b>CREA AE: </b>"+TEUSAQUILLO_AE+"<br><b>CREA EC: </b>"+TEUSAQUILLO_EC+"<br><b>CREA LC: </b>"+TEUSAQUILLO_LC+"<br><b>NIDOS: </b>"+TEUSAQUILLO_NIDOS,
//         },{
//           title: "SUBA",
//           id: "CO-BO5",
//           color: "#00a99d",
//           customData: "<b>CREA AE: </b>"+SUBA_AE+"<br><b>CREA EC: </b>"+SUBA_EC+"<br><b>CREA LC: </b>"+SUBA_LC+"<br><b>NIDOS: </b>"+SUBA_NIDOS,
//         },{
//           title: "ENGATIVA",
//           id: "CO-BO6",
//           color: "#2e3192",
//           customData: "<b>CREA AE: </b>"+ENGATIVA_AE+"<br><b>CREA EC: </b>"+ENGATIVA_EC+"<br><b>CREA LC: </b>"+ENGATIVA_LC+"<br><b>NIDOS: </b>"+ENGATIVA_NIDOS,
//         },{
//           title: "FONTIBON",
//           id: "CO-BO7",
//           color: "#00547b",
//           customData: "<b>CREA AE: </b>"+FONTIBON_AE+"<br><b>CREA EC: </b>"+FONTIBON_EC+"<br><b>CREA LC: </b>"+FONTIBON_LC+"<br><b>NIDOS: </b>"+FONTIBON_NIDOS,
//         },{
//           title: "CANDELARIA",
//           id: "CO-BO8",
//           color: "#5e6c68",
//           customData: "<b>CREA AE: </b>"+CANDELARIA_AE+"<br><b>CREA EC: </b>"+CANDELARIA_EC+"<br><b>CREA LC: </b>"+CANDELARIA_LC+"<br><b>NIDOS: </b>"+CANDELARIA_NIDOS,
//         },{
//           title: "SANTA FE",
//           id: "CO-BO9",
//           color: "#2e3192",
//           customData: "<b>CREA AE: </b>"+SANTAFE_AE+"<br><b>CREA EC: </b>"+SANTAFE_EC+"<br><b>CREA LC: </b>"+SANTAFE_LC+"<br><b>NIDOS: </b>"+SANTAFE_NIDOS,
//         },{
//           title: "MARTIRES",
//           id: "CO-BO10",
//           color: "#00547b",
//           customData: "<b>CREA AE: </b>"+MARTIRES_AE+"<br><b>CREA EC: </b>"+MARTIRES_EC+"<br><b>CREA LC: </b>"+MARTIRES_LC+"<br><b>NIDOS: </b>"+MARTIRES_NIDOS,
//         },{
//           title: "ANTONIO NARIÑO",
//           id: "CO-BO11",
//           color: "#29abe2",
//           customData: "<b>CREA AE: </b>"+ANTONIONARIÑO_AE+"<br><b>CREA EC: </b>"+ANTONIONARIÑO_EC+"<br><b>CREA LC: </b>"+ANTONIONARIÑO_LC+"<br><b>NIDOS: </b>"+ANTONIONARIÑO_NIDOS,
//         },{
//           title: "PUENTE ARANDA",
//           id: "CO-BO12",
//           color: "#5e6c68",
//           customData: "<b>CREA AE: </b>"+PUENTEARANDA_AE+"<br><b>CREA EC: </b>"+PUENTEARANDA_EC+"<br><b>CREA LC: </b>"+PUENTEARANDA_LC+"<br><b>NIDOS: </b>"+PUENTEARANDA_NIDOS,
//         },{
//           title: "RAFAEL URIBE URIBE",
//           id: "CO-BO13",
//           color: "#00547b",
//           customData: "<b>CREA AE: </b>"+RUU_AE+"<br><b>CREA EC: </b>"+RUU_EC+"<br><b>CREA LC: </b>"+RUU_LC+"<br><b>NIDOS: </b>"+RUU_NIDOS,
//         },{
//           title: "SAN CRISTOBAL",
//           id: "CO-BO14",
//           color: "#00a99d",
//           customData: "<b>CREA AE: </b>"+SANCRISTOBAL_AE+"<br><b>CREA EC: </b>"+SANCRISTOBAL_EC+"<br><b>CREA LC: </b>"+SANCRISTOBAL_LC+"<br><b>NIDOS: </b>"+SANCRISTOBAL_NIDOS,
//         },{
//           title: "SUMAPAZ",
//           id: "CO-BO15",
//           color: "#01937c",
//           customData: "<b>CREA AE: </b>"+SUMAPAZ_AE+"<br><b>CREA EC: </b>"+SUMAPAZ_EC+"<br><b>CREA LC: </b>"+SUMAPAZ_LC+"<br><b>NIDOS: </b>"+SUMAPAZ_NIDOS,
//         },{
//           title: "USME",
//           id: "CO-BO16",
//           color: "#89ddaf",
//           customData: "<b>CREA AE: </b>"+USME_AE+"<br><b>CREA EC: </b>"+USME_EC+"<br><b>CREA LC: </b>"+USME_LC+"<br><b>NIDOS: </b>"+USME_NIDOS,
//         },{
//           title: "TUNJUELITO",
//           id: "CO-BO17",
//           color: "#00547b",
//           customData: "<b>CREA AE: </b>"+TUNJUELITO_AE+"<br><b>CREA EC: </b>"+TUNJUELITO_EC+"<br><b>CREA LC: </b>"+TUNJUELITO_LC+"<br><b>NIDOS: </b>"+TUNJUELITO_NIDOS,
//         },{
//           title: "CIUDAD BOLIVAR",
//           id: "CO-BO18",
//           color: "#01937c",
//           customData: "<b>CREA AE: </b>"+CIUDADBOLIVAR_AE+"<br><b>CREA EC: </b>"+CIUDADBOLIVAR_EC+"<br><b>CREA LC: </b>"+CIUDADBOLIVAR_LC+"<br><b>NIDOS: </b>"+CIUDADBOLIVAR_NIDOS,
//         },{
//           title: "KENNEDY",
//           id: "CO-BO19",
//           color: "#29abe2",
//           customData: "<b>CREA AE: </b>"+KENNEDY_AE+"<br><b>CREA EC: </b>"+KENNEDY_EC+"<br><b>CREA LC: </b>"+KENNEDY_LC+"<br><b>NIDOS: </b>"+KENNEDY_NIDOS,
//         },{
//           title: "BOSA",
//           id: "CO-BO20",
//           color: "#00547b",
//           customData: "<b>CREA AE: </b>"+BOSA_AE+"<br><b>CREA EC: </b>"+BOSA_EC+"<br><b>CREA LC: </b>"+BOSA_LC+"<br><b>NIDOS: </b>"+BOSA_NIDOS,
//         },];

//         map.dataProvider.areas = json_areas;
//         map.validateData();
//       });
// }catch(err){
//   console.error("Error al leer estadísticas de Localidades: "+err.message);
// }
// }
// });
// }

// function mostrarFiltros(filtros){
//   $("#filter_div").attr("hidden", true);
//   $(".div_select").attr("hidden", true);
//   filtros_aplicados = filtros.split(",");
//   valores_filtros="";
//   $.each(filtros_aplicados, function(index){
//     var nombre_filtro = filtros_aplicados[index];
//     if(nombre_filtro != ""){
//       $("#filter_div").attr("hidden", false);
//       $("#div_"+nombre_filtro).removeAttr("hidden");
//       valores_filtros += $("#"+nombre_filtro).attr('id')+":"+$("#"+nombre_filtro).val()+',';
//     }
//   });
// }

// function construirDataProvider(numeral, valores_filtros, chartname, tipo_grafica_inicio){
//   if(tipo_grafica_inicio != ""){
//     tipo_grafica = tipo_grafica_inicio;
//   }
//   var datos = {
//     funcion : 'executeSql',
//     p1: {
//       'vc_numeral': numeral,
//       'valores_filtros':valores_filtros
//     }
//   };
//   mostrarCargando();
//   $.ajax({
//     url: url_service,
//     type: 'POST',
//     data: datos,
//     dataType: 'json',
//   }).done(function(data){
//     if(tipo_grafica == 'column'){
//       dataProvider_column = data;
//       cargarGraficadeBarras("light", chartname);
//     }
//     if(tipo_grafica == 'lineal'){
//       dataProvider_lineal = data;
//       cargarGraficadeLinea("dark");
//     }
//     if(tipo_grafica == 'pie'){
//       dataProvider_pie = data;
//       cargarGraficadePie("light",chartname);
//     }
//     if(tipo_grafica == 'gauge'){
//       dataProvider_gauge = data;
//       cargarGraficadeCalibrador("light");
//     }
//     if(tipo_grafica == 'map'){
//       mapaLocalidades();
//     }
//     if(tipo_grafica == 'column_multiple'){
//       dataProvider_column_multiple = data;
//       cargarGraficaMultiSerial(chartname, numeral);
//     }
//     if(tipo_grafica == 'multi_lineal'){
//       dataProvider_column_multiple = data;
//       cargarGraficaMultiLineal(chartname);
//     }
//     cerrarCargando();
//     if(chartname=="chartdiv"){
//       $("#modal_graph").modal('show');
//     }
//   }).fail(function (jqXHR, textStatus) {
//     if(tipo_grafica == 'column'){
//       dataProvider_column = '[{"X": "USA","Y": "4025","color": "#FF0F00"}, {"X": "China","Y": "1882","color": "#FF6600"}, {"X": "Japan","Y": "1809","color": "#FF9E01"}, {"X": "Germany","Y": "1322","color": "#FCD202"}, {"X": "UK","Y": "1122","color": "#F8FF01"}, {"X": "France","Y": "1114","color": "#B0DE09"}, {"X": "India","Y": "984","color": "#04D215"}, {"X": "Spain","Y": "711","color": "#0D8ECF"}, {"X": "Netherlands","Y": "665","color": "#0D52D1"}, {"X": "Russia","Y": "580","color": "#2A0CD0"}, {"X": "SouthKorea","Y": "443","color": "#8A0CCF"}, {"X": "Canada","Y": "441","color": "#CD0D74"}, {"X": "Brazil","Y": "395","color": "#754DEB"}, {"X": "Italy","Y": "386","color": "#DDDDDD"}, {"X": "Australia","Y": "384","color": "#999999"}, {"X": "Taiwan","Y": "338","color": "#333333"}, {"X": "Poland","Y": "328","color": "#000000"}]';
//       dataProvider_column = JSON.parse(dataProvider_column);
//       cargarGraficadeBarras("light", chartname);
//     }
//     if(tipo_grafica == 'pie'){
//       dataProvider_pie = '[{"X": "USA","Y": "4025"}, {"X": "China","Y": "1882"}, {"X": "Japan","Y": "1809"}]';
//       dataProvider_pie = JSON.parse(dataProvider_pie);
//       cargarGraficadePie("light",chartname);
//     }
//     if(tipo_grafica == 'lineal'){
//       dataProvider_lineal = '[{"X": "USA","Y": "4025"}, {"X": "China","Y": "1882"}, {"X": "Japan","Y": "1809"}, {"X": "Germany","Y": "1322"}, {"X": "UK","Y": "1122"}, {"X": "France","Y": "1114"}, {"X": "India","Y": "984"}, {"X": "Spain","Y": "711"}, {"X": "Netherlands","Y": "665"}, {"X": "Russia","Y": "580"}, {"X": "SouthKorea","Y": "443"}, {"X": "Canada","Y": "441"}, {"X": "Brazil","Y": "395"}, {"X": "Italy","Y": "386"}, {"X": "Australia","Y": "384"}, {"X": "Taiwan","Y": "338"}, {"X": "Poland","Y": "328"}]';
//       dataProvider_lineal = JSON.parse(dataProvider_lineal);
//       cargarGraficadeLinea("dark");
//     }
//     if(tipo_grafica == 'gauge'){
//       dataProvider_gauge = '[{"X": "1000","Y": "2000"}]';
//       dataProvider_gauge = JSON.parse(dataProvider_gauge);
//       cargarGraficadeCalibrador("light");
//     }
//     if(tipo_grafica == 'map'){
//       mapaLocalidades();
//     }
//     if(tipo_grafica == 'column_multiple'){
//       dataProvider_column_multiple = '[{"X": "2003","C": "2.5","N": "2.5"},{"X": "2004","C": "2.6","N": "2.7"}]';
//       dataProvider_column_multiple = JSON.parse(dataProvider_column_multiple);
//       cargarGraficaMultiSerial(chartname, numeral);
//     }
//     if(tipo_grafica == 'multi_lineal'){
//       // dataProvider_column_multiple = data;
//       cargarGraficaMultiLineal(chartname);
//     }
//     cerrarCargando();
//     $("#modal_graph").modal('show');
//   });
// }

// function llenarFiltros(){
//   $("#SL_ANIO").html(getOptionParametroDetalle(7)).selectpicker("refresh");
//   $("#SL_MES").html(getOptionParametroDetalle(8)).selectpicker("refresh");
//   $("#SL_LOCALIDAD").html(getOptionParametroDetalle(19)).selectpicker("refresh");
//   $("#SL_CREA").html(getOptionsClanes()).selectpicker("refresh");
//   $("#SL_TERRITORIO").html(getOptionParametroDetalle(43)).selectpicker("refresh");
//   $("#SL_LINEA_NIDOS").html(getLineasNidos()).selectpicker("refresh");
//   $("#SL_COLEGIO").html(getOptionsColegiosAtendidos()).selectpicker("refresh");
//   $("#SL_AREA_CREA").html(getOptionsAreasArtisticas()).selectpicker("refresh");

//   $("#SL_LOCALIDAD").on('change', function(){
//     $("#SL_UPZ").html(getOptionsUpz($(this).val())).selectpicker("refresh");
//   });

//   $("#SL_UPZ").on('change', function(){
//     $("#SL_LUGAR_NIDOS").html(getOptionsLugarNidos($(this).val())).selectpicker("refresh");
//   });

//   $("#SL_ANIO").on('change', function(){
//     $("#SL_GRUPO").html(getOptionsGruposLineaArea($(this).val(),$("#SL_LINEA_CREA").val(), $("#SL_AREA_CREA").val())).selectpicker("refresh");
//   });

//   $("#SL_LINEA_CREA").on('change', function(){
//     $("#SL_GRUPO").html(getOptionsGruposLineaArea($("#SL_ANIO").val(),$(this).val(), $("#SL_AREA_CREA").val())).selectpicker("refresh");
//   });

//   $("#SL_AREA_CREA").on('change', function(){
//     $("#SL_GRUPO").html(getOptionsGruposLineaArea($("#SL_ANIO").val(),$("#SL_LINEA_CREA").val(), $(this).val())).selectpicker("refresh");
//   });

// }

// function cargarSeccionInicio(id_indicador){
//   var datos = {
//     funcion : 'executeSql',
//     p1: {
//       'vc_numeral': id_indicador,
//       'valores_filtros': "SL_ANIO:"+anio_inicio+","
//     }
//   };
//   mostrarCargando();
//   $.ajax({
//     url: url_service,
//     type: 'POST',
//     data: datos,
//     dataType: 'json',
//   }).done(function(data){
//     cerrarCargando();
//     if (id_indicador=="1.1") $("#subdireccion_anual").html("<h3 style='background-color:lightsteelblue'>"+data[0].ATENDIDOS+" BENEFICIARIOS ATENDIDOS</h3>");
//     if (id_indicador=="1.3"){
//       var programa = data[0].PROGRAMA;
//       $("#atencion_programa_linea").html("<h5>"+data[0].PROGRAMA+"</h5>");
//       var total_linea = 0;
//       for(i=0;i<Object.keys(data).length;i++){
//         if(programa != data[i].PROGRAMA){
//           $("#atencion_programa_linea").append("<h3 style='background-color:lightsteelblue'>TOTAL : "+total_linea+"</h3>");
//           total_linea = 0;
//           $("#atencion_programa_linea").append("<h5>"+data[i].PROGRAMA+"</h5>");
//           programa = data[i].PROGRAMA;
//         }
//         $("#atencion_programa_linea").append("<h4>"+data[i].LINEA+": "+data[i].CANTIDAD+"</h4>");
//         total_linea = total_linea + parseInt(data[i].CANTIDAD);
//       };
//       $("#atencion_programa_linea").append("<h3 style='background-color:lightsteelblue'>TOTAL : "+total_linea+"</h3>");
//     }
//   }
//   ).fail(function (jqXHR, textStatus) {
//     alert("Algo resultó mal");
//     cerrarCargando();
//   });
// }
// });
location.href="https://sif.idartes.gov.co/sif/framework/centro-de-monitoreo"