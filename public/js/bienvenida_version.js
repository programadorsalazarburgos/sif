var coberturaLineaCrea;
var coberturaPorCrea;
var coberturaLineasMensual;
var json_areas = "";
$(document).ready(function(){
  swal.close();
  //$.fn.snow();
  $(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
      scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
  });

  $("#SL_Linea").html(getOptionsLineasAtencion());

  var map;
  var map = AmCharts.makeChart("mapdiv", {
    "type": "map",
    //"theme": "light",
    "dataProvider": {
      "mapURL": "LibreriasExternas/mapas/LocalidadesBogota.svg",
      "getAreasFromMap": true,
      "zoomLevel": 0.95,
      "areas": [{
        title: "USAQUEN",
        id: "CO-BO1",
        color: "#00547b",
        customData: "<b>Nidos:</b> 1 <br><b>Crea:</b> <div id='USAQUEN' name='USAQUEN'>1005</div>",
      },{
        title: "CHAPINERO",
        id: "CO-BO2",
        color: "#29abe2",
        customData: "<b>Nidos:</b> 2 <br><b>Crea:</b> <div id='CHAPINERO' name='CHAPINERO'></div>",
      },{
        title: "BARRIOS UNIDOS",
        id: "CO-BO3",
        color: "#00547b",
        customData: "<b>Nidos:</b> 3 <br><b>Crea:</b> <div id='BARRIOSUNIDOS' name='BARRIOSUNIDOS'></div>",
      },{
        title: "TEUSAQUILLO",
        id: "CO-BO4",
        color: "#00a99d",
        customData: "<b>Nidos:</b> 4 <br><b>Crea:</b> <div id='TEUSAQUILLO' name='TEUSAQUILLO'></div>",
      },{
        title: "SUBA",
        id: "CO-BO5",
        color: "#00a99d",
        customData: "<b>Nidos:</b> 5 <br><b>Crea:</b> <div id='SUBA' name='SUBA'></div>", 
      },{
        title: "ENGATIVA",
        id: "CO-BO6",
        color: "#2e3192",
        customData: "<b>Nidos:</b> 6 <br><b>Crea:</b> <div id='ENGATIVA' name='ENGATIVA'></div>",
      },{
        title: "FONTIBON",
        id: "CO-BO7",
        color: "#00547b",
        customData: "<b>Nidos:</b> 7 <br><b>Crea:</b> <div id='FONTIBON' name='FONTIBON'></div",
      },{
        title: "CANDELARIA",
        id: "CO-BO8",
        color: "#5e6c68",
        customData: "<b>Nidos:</b> 8 <br><b>Crea:</b> <div id='CANDELARIA' name='CANDELARIA'></div>",
      },{
        title: "SANTA FE",
        id: "CO-BO9",
        color: "#2e3192",
        customData: "<b>Nidos:</b> 9 <br><b>Crea:</b> <div id='SANTAFE' name='SANTAFE'></div>",
      },{
        title: "MARTIRES",
        id: "CO-BO10",
        color: "#00547b",
        customData: "<b>Nidos:</b> 10 <br><b>Crea:</b> <div id='MARTIRES' name='MARTIRES'></div>",
      },{
        title: "ANTONIO NARIÑO",
        id: "CO-BO11",
        color: "#29abe2",
        customData: "<b>Nidos:</b> 11 <br><b>Crea:</b> <div id='ANTONIONARIÑO' name='ANTONIONARIÑO'></div>",
      },{
        title: "PUENTE ARANDA",
        id: "CO-BO12",
        color: "#5e6c68",
        customData: "<b>Nidos:</b> 12 <br><b>Crea:</b> <div id='PUENTEARANDA' name='PUENTEARANDA'></div>",
      },{
        title: "RAFAEL URIBE URIBE",
        id: "CO-BO13",
        color: "#00547b",
        customData: "<b>Nidos:</b> 13 <br><b>Crea:</b> <div id='RAFAELURIBEURIBE' name='RAFAELURIBEURIBE'></div>",
      },{
        title: "SAN CRISTOBAL",
        id: "CO-BO14",
        color: "#00a99d",
        customData: "<b>Nidos:</b> 14 <br><b>Crea:</b> <div id='SANCRISTOBAL' name='SANCRISTOBAL'></div>",
      },{
        title: "SUMAPAZ",
        id: "CO-BO15",
        color: "#01937c",
        customData: "<b>Nidos:</b> 15 <br><b>Crea:</b> <div id='SUMAPAZ' name='SUMAPAZ'></div>",
      },{
        title: "USME",
        id: "CO-BO16",
        color: "#89ddaf",
        customData: "<b>Nidos:</b> 16 <br><b>Crea:</b> <div id='USME' name='USME'>200</div>",
      },{
        title: "TUNJUELITO",
        id: "CO-BO17",
        color: "#00547b",
        customData: "<b>Nidos:</b> 17 <br><b>Crea:</b> <div id='TUNJUELITO' name='TUNJUELITO'></div>",
      },{
        title: "CIUDAD BOLIVAR",
        id: "CO-BO18",
        color: "#01937c",
        customData: "<b>Nidos:</b> 18 <br><b>Crea:</b> <div id='CIUDADBOLIVAR' name='CIUDADBOLIVAR'></div>",
      },{
        title: "KENNEDY",
        id: "CO-BO19",
        color: "#29abe2",
        customData: "<b>Nidos:</b> 19 <br><b>Crea:</b> <div id='KENNEDY' name='KENNEDY'></div>",
      },{
        title: "BOSA",
        id: "CO-BO20",
        color: "#00547b",
        customData: "<b>Nidos:</b> 20 <br><b>Crea:</b> <div id='BOSA' name='BOSA'></div>",
      },]
    },
    "areasSettings": {
      "autoRotateAngle": 90,
      "autoZoom": true,
      unlistedAreasColor: "#357566",
      rollOverOutlineColor: "#eeeeee",
      rollOverColor: "#357566",
      rollOutlineAlpha: 3,
      rollOutlineColor: "#eeeeee",
      rollOutlineThickness: 5,
      selectedColor: "#115f3e",
      "balloonText": "<b>[[title]]</b><br> [[customData]]"
    },
    "imagesSettings": {
      "labelPosition": "top",
      "labelFontSize": 9,
      "labelColor": "#000000",
      "labelRollOverColor": "#000000",
    },
    "zoomControl": {
      "minZoomLevel": 0.9
    },
    "titles": "Bogotá"
  } );

map.addListener( "init", function() {
  setTimeout( function() {

    map.dataProvider.images = [];
    for ( x in map.dataProvider.areas ) {
      var area = map.dataProvider.areas[ x ];
      var image = new AmCharts.MapImage();
      image.latitude = map.getAreaCenterLatitude( area );
      image.longitude = map.getAreaCenterLongitude( area );
      image.width = 30;
      image.height = 17;
      image.label = area.title;
      image.linkToObject = area;
      if (area.title == "USAQUEN"){
        image.latitude = image.latitude+0.2;
      }
      if (area.title == "CHAPINERO"){
        image.latitude = image.latitude-0.7;
      }
      if (area.title == "SUBA"){
        image.latitude = image.latitude+28;
        image.longitude = image.longitude+15;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "BARRIOS UNIDOS"){
        image.latitude = image.latitude+3;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "TEUSAQUILLO"){
        image.latitude = image.latitude+1;
        image.longitude = image.longitude+3;
      }
      if (area.title == "ENGATIVA"){
        image.latitude = image.latitude+55;
        image.longitude = image.longitude+15;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "FONTIBON"){
        image.latitude = image.latitude-15;
        image.longitude = image.longitude-5;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "KENNEDY"){
        image.latitude = image.latitude+15;
        image.longitude = image.longitude+10;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "BOSA"){
        image.latitude = image.latitude-3.1;
        image.longitude = image.longitude+5;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "TUNJUELITO"){
        image.latitude = image.latitude+8;
        image.longitude = image.longitude-15;
      }
      if (area.title == "CIUDAD BOLIVAR"){
        image.latitude = image.latitude+13;
        image.longitude = image.longitude+13;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "USME"){
        image.latitude = image.latitude-11;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "SANTA FE"){
        image.latitude = image.latitude+1.9;
        image.longitude = image.longitude-15;
      }
      if (area.title == "CANDELARIA"){
        image.latitude = image.latitude+2;
      }
      if (area.title == "RAFAEL URIBE URIBE"){
        image.latitude = image.latitude+2;
        image.label = "RAFAEL URIBE\nURIBE";
        image.longitude = image.longitude-7;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "ANTONIO NARIÑO"){
        image.latitude = image.latitude+25;
        image.label = "ANTONIO\nNARIÑO";
        image.longitude = image.longitude;
      }
      if (area.title == "MARTIRES"){
        image.latitude = image.latitude+1;
        image.longitude = image.longitude+3;
        image.imageURL = "https://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
      }
      if (area.title == "SUMAPAZ"){
        image.longitude = image.longitude+3;
      }
      map.dataProvider.images.push( image );
    }
    map.validateData();
      //console.log( map.dataProvider );
    }, 100 )
});
function handleMapObjectClick(event) {
  if (event.mapObject.title != undefined){
    $("#content").html(event.mapObject.title);
    console.log(event.mapObject.id);
    console.log(event.mapObject.title);
  }
  else{
    $("#content").html(event.mapObject.linkToObject.title);
    console.log(event.mapObject.linkToObject.id);
    console.log(event.mapObject.linkToObject.title);
  }
}

map.addListener("clickMapObject", handleMapObjectClick);
$("#BT_CARGAR_ESTADISTICAS_LOCALIDADES").on('click', function(){
  swal({
    text:'Cargando información',
    allowOutsideClick: false,
    allowEscapeKey: false,
    onOpen: () => {
      swal.showLoading();
    }
  });
  $("#mapdiv").attr("hidden", false);
  var datos = {
    funcion : 'getEstadisticasLocalidades',
    p1: (new Date()).getFullYear()
  };
  $.ajax({
    url: url_service,
    type: 'POST',
    data: datos,
    dataType: 'json',
    success: function(data){ 
      try{
        var USAQUEN_AE =0;
        var CHAPINERO_AE =0;
        var BARRIOSUNIDOS_AE =0;
        var TEUSAQUILLO_AE =0;
        var SUBA_AE =0;
        var ENGATIVA_AE =0;
        var FONTIBON_AE =0;
        var CANDELARIA_AE =0;
        var SANTAFE_AE =0;
        var MARTIRES_AE =0;
        var ANTONIONARIÑO_AE =0;
        var PUENTEARANDA_AE =0;
        var RUU_AE =0;
        var SANCRISTOBAL_AE =0;
        var SUMAPAZ_AE =0;
        var USME_AE =0;
        var TUNJUELITO_AE =0;
        var CIUDADBOLIVAR_AE =0;
        var KENNEDY_AE =0;
        var BOSA_AE =0;

        var USAQUEN_EC =0;
        var CHAPINERO_EC =0;
        var BARRIOSUNIDOS_EC =0;
        var TEUSAQUILLO_EC =0;
        var SUBA_EC =0;
        var ENGATIVA_EC =0;
        var FONTIBON_EC =0;
        var CANDELARIA_EC =0;
        var SANTAFE_EC =0;
        var MARTIRES_EC =0;
        var ANTONIONARIÑO_EC =0;
        var PUENTEARANDA_EC =0;
        var RUU_EC =0;
        var SANCRISTOBAL_EC =0;
        var SUMAPAZ_EC =0;
        var USME_EC =0;
        var TUNJUELITO_EC =0;
        var CIUDADBOLIVAR_EC =0;
        var KENNEDY_EC =0;
        var BOSA_EC =0;

        var USAQUEN_LC =0;
        var CHAPINERO_LC =0;
        var BARRIOSUNIDOS_LC =0;
        var TEUSAQUILLO_LC =0;
        var SUBA_LC =0;
        var ENGATIVA_LC =0;
        var FONTIBON_LC =0;
        var CANDELARIA_LC =0;
        var SANTAFE_LC =0;
        var MARTIRES_LC =0;
        var ANTONIONARIÑO_LC =0;
        var PUENTEARANDA_LC =0;
        var RUU_LC =0;
        var SANCRISTOBAL_LC =0;
        var SUMAPAZ_LC =0;
        var USME_LC =0;
        var TUNJUELITO_LC =0;
        var CIUDADBOLIVAR_LC =0;
        var KENNEDY_LC =0;
        var BOSA_LC =0;

        var USAQUEN_NIDOS =0;
        var CHAPINERO_NIDOS =0;
        var BARRIOSUNIDOS_NIDOS =0;
        var TEUSAQUILLO_NIDOS =0;
        var SUBA_NIDOS =0;
        var ENGATIVA_NIDOS =0;
        var FONTIBON_NIDOS =0;
        var CANDELARIA_NIDOS =0;
        var SANTAFE_NIDOS =0;
        var MARTIRES_NIDOS =0;
        var ANTONIONARIÑO_NIDOS =0;
        var PUENTEARANDA_NIDOS =0;
        var RUU_NIDOS =0;
        var SANCRISTOBAL_NIDOS =0;
        var SUMAPAZ_NIDOS =0;
        var USME_NIDOS =0;
        var TUNJUELITO_NIDOS =0;
        var CIUDADBOLIVAR_NIDOS =0;
        var KENNEDY_NIDOS =0;
        var BOSA_NIDOS =0;
        $.each(data, function(i) 
        {
          if(data[i].LINEA=='AE'){
            USAQUEN_AE += (data[i].LOCALIDAD=="USAQUÉN") ? parseInt(data[i].BENEFICIARIOS):0;
            CHAPINERO_AE += (data[i].LOCALIDAD=="CHAPINERO") ? parseInt(data[i].BENEFICIARIOS):0;
            BARRIOSUNIDOS_AE += (data[i].LOCALIDAD=="BARRIOS UNIDOS") ? parseInt(data[i].BENEFICIARIOS):0;
            TEUSAQUILLO_AE += (data[i].LOCALIDAD=="TEUSAQUILLO") ? parseInt(data[i].BENEFICIARIOS):0;
            SUBA_AE += (data[i].LOCALIDAD=="SUBA") ? parseInt(data[i].BENEFICIARIOS):0;
            ENGATIVA_AE += (data[i].LOCALIDAD=="ENGATIVÁ") ? parseInt(data[i].BENEFICIARIOS):0;
            FONTIBON_AE += (data[i].LOCALIDAD=="FONTIBÓN") ? parseInt(data[i].BENEFICIARIOS):0;
            CANDELARIA_AE += (data[i].LOCALIDAD=="CANDELARIA") ? parseInt(data[i].BENEFICIARIOS):0;
            SANTAFE_AE += (data[i].LOCALIDAD=="SANTA FE") ? parseInt(data[i].BENEFICIARIOS):0;
            MARTIRES_AE += (data[i].LOCALIDAD=="MÁRTIRES") ? parseInt(data[i].BENEFICIARIOS):0;
            ANTONIONARIÑO_AE += (data[i].LOCALIDAD=="ANTONIO NARIÑO") ? parseInt(data[i].BENEFICIARIOS):0;
            PUENTEARANDA_AE += (data[i].LOCALIDAD=="PUENTE ARANDA") ? parseInt(data[i].BENEFICIARIOS):0;
            RUU_AE += (data[i].LOCALIDAD=="RAFAEL URIBE") ? parseInt(data[i].BENEFICIARIOS):0;
            SANCRISTOBAL_AE += (data[i].LOCALIDAD=="SAN CRISTOBAL") ? parseInt(data[i].BENEFICIARIOS):0;
            SUMAPAZ_AE += (data[i].LOCALIDAD=="SUMAPAZ") ? parseInt(data[i].BENEFICIARIOS):0;
            USME_AE += (data[i].LOCALIDAD=="USME") ? parseInt(data[i].BENEFICIARIOS):0;
            TUNJUELITO_AE += (data[i].LOCALIDAD=="TUNJUELITO") ? parseInt(data[i].BENEFICIARIOS):0;
            CIUDADBOLIVAR_AE += (data[i].LOCALIDAD=="CIUDAD BOLIVAR") ? parseInt(data[i].BENEFICIARIOS):0;
            KENNEDY_AE += (data[i].LOCALIDAD=="KENNEDY") ? parseInt(data[i].BENEFICIARIOS):0;
            BOSA_AE += (data[i].LOCALIDAD=="BOSA") ? parseInt(data[i].BENEFICIARIOS):0;  
          }

          if(data[i].LINEA=='EC'){
            USAQUEN_EC += (data[i].LOCALIDAD=="USAQUÉN") ? parseInt(data[i].BENEFICIARIOS):0;
            CHAPINERO_EC += (data[i].LOCALIDAD=="CHAPINERO") ? parseInt(data[i].BENEFICIARIOS):0;
            BARRIOSUNIDOS_EC += (data[i].LOCALIDAD=="BARRIOS UNIDOS") ? parseInt(data[i].BENEFICIARIOS):0;
            TEUSAQUILLO_EC += (data[i].LOCALIDAD=="TEUSAQUILLO") ? parseInt(data[i].BENEFICIARIOS):0;
            SUBA_EC += (data[i].LOCALIDAD=="SUBA") ? parseInt(data[i].BENEFICIARIOS):0;
            ENGATIVA_EC += (data[i].LOCALIDAD=="ENGATIVÁ") ? parseInt(data[i].BENEFICIARIOS):0;
            FONTIBON_EC += (data[i].LOCALIDAD=="FONTIBÓN") ? parseInt(data[i].BENEFICIARIOS):0;
            CANDELARIA_EC += (data[i].LOCALIDAD=="CANDELARIA") ? parseInt(data[i].BENEFICIARIOS):0;
            SANTAFE_EC += (data[i].LOCALIDAD=="SANTA FE") ? parseInt(data[i].BENEFICIARIOS):0;
            MARTIRES_EC += (data[i].LOCALIDAD=="MÁRTIRES") ? parseInt(data[i].BENEFICIARIOS):0;
            ANTONIONARIÑO_EC += (data[i].LOCALIDAD=="ANTONIO NARIÑO") ? parseInt(data[i].BENEFICIARIOS):0;
            PUENTEARANDA_EC += (data[i].LOCALIDAD=="PUENTE ARANDA") ? parseInt(data[i].BENEFICIARIOS):0;
            RUU_EC += (data[i].LOCALIDAD=="RAFAEL URIBE") ? parseInt(data[i].BENEFICIARIOS):0;
            SANCRISTOBAL_EC += (data[i].LOCALIDAD=="SAN CRISTOBAL") ? parseInt(data[i].BENEFICIARIOS):0;
            SUMAPAZ_EC += (data[i].LOCALIDAD=="SUMAPAZ") ? parseInt(data[i].BENEFICIARIOS):0;
            USME_EC += (data[i].LOCALIDAD=="USME") ? parseInt(data[i].BENEFICIARIOS):0;
            TUNJUELITO_EC += (data[i].LOCALIDAD=="TUNJUELITO") ? parseInt(data[i].BENEFICIARIOS):0;
            CIUDADBOLIVAR_EC += (data[i].LOCALIDAD=="CIUDAD BOLIVAR") ? parseInt(data[i].BENEFICIARIOS):0;
            KENNEDY_EC += (data[i].LOCALIDAD=="KENNEDY") ? parseInt(data[i].BENEFICIARIOS):0;
            BOSA_EC += (data[i].LOCALIDAD=="BOSA") ? parseInt(data[i].BENEFICIARIOS):0;
          }

          if(data[i].LINEA=='LC'){
            USAQUEN_LC += (data[i].LOCALIDAD=="USAQUÉN") ? parseInt(data[i].BENEFICIARIOS):0;
            CHAPINERO_LC += (data[i].LOCALIDAD=="CHAPINERO") ? parseInt(data[i].BENEFICIARIOS):0;
            BARRIOSUNIDOS_LC += (data[i].LOCALIDAD=="BARRIOS UNIDOS") ? parseInt(data[i].BENEFICIARIOS):0;
            TEUSAQUILLO_LC += (data[i].LOCALIDAD=="TEUSAQUILLO") ? parseInt(data[i].BENEFICIARIOS):0;
            SUBA_LC += (data[i].LOCALIDAD=="SUBA") ? parseInt(data[i].BENEFICIARIOS):0;
            ENGATIVA_LC += (data[i].LOCALIDAD=="ENGATIVÁ") ? parseInt(data[i].BENEFICIARIOS):0;
            FONTIBON_LC += (data[i].LOCALIDAD=="FONTIBÓN") ? parseInt(data[i].BENEFICIARIOS):0;
            CANDELARIA_LC += (data[i].LOCALIDAD=="CANDELARIA") ? parseInt(data[i].BENEFICIARIOS):0;
            SANTAFE_LC += (data[i].LOCALIDAD=="SANTA FE") ? parseInt(data[i].BENEFICIARIOS):0;
            MARTIRES_LC += (data[i].LOCALIDAD=="MÁRTIRES") ? parseInt(data[i].BENEFICIARIOS):0;
            ANTONIONARIÑO_LC += (data[i].LOCALIDAD=="ANTONIO NARIÑO") ? parseInt(data[i].BENEFICIARIOS):0;
            PUENTEARANDA_LC += (data[i].LOCALIDAD=="PUENTE ARANDA") ? parseInt(data[i].BENEFICIARIOS):0;
            RUU_LC += (data[i].LOCALIDAD=="RAFAEL URIBE") ? parseInt(data[i].BENEFICIARIOS):0;
            SANCRISTOBAL_LC += (data[i].LOCALIDAD=="SAN CRISTOBAL") ? parseInt(data[i].BENEFICIARIOS):0;
            SUMAPAZ_LC += (data[i].LOCALIDAD=="SUMAPAZ") ? parseInt(data[i].BENEFICIARIOS):0;
            USME_LC += (data[i].LOCALIDAD=="USME") ? parseInt(data[i].BENEFICIARIOS):0;
            TUNJUELITO_LC += (data[i].LOCALIDAD=="TUNJUELITO") ? parseInt(data[i].BENEFICIARIOS):0;
            CIUDADBOLIVAR_LC += (data[i].LOCALIDAD=="CIUDAD BOLIVAR") ? parseInt(data[i].BENEFICIARIOS):0;
            KENNEDY_LC += (data[i].LOCALIDAD=="KENNEDY") ? parseInt(data[i].BENEFICIARIOS):0;
            BOSA_LC += (data[i].LOCALIDAD=="BOSA") ? parseInt(data[i].BENEFICIARIOS):0;
          }

          if(data[i].LINEA=='NIDOS'){
            USAQUEN_NIDOS += (data[i].LOCALIDAD=="USAQUÉN") ? parseInt(data[i].BENEFICIARIOS):0;
            CHAPINERO_NIDOS += (data[i].LOCALIDAD=="CHAPINERO") ? parseInt(data[i].BENEFICIARIOS):0;
            BARRIOSUNIDOS_NIDOS += (data[i].LOCALIDAD=="BARRIOS UNIDOS") ? parseInt(data[i].BENEFICIARIOS):0;
            TEUSAQUILLO_NIDOS += (data[i].LOCALIDAD=="TEUSAQUILLO") ? parseInt(data[i].BENEFICIARIOS):0;
            SUBA_NIDOS += (data[i].LOCALIDAD=="SUBA") ? parseInt(data[i].BENEFICIARIOS):0;
            ENGATIVA_NIDOS += (data[i].LOCALIDAD=="ENGATIVÁ") ? parseInt(data[i].BENEFICIARIOS):0;
            FONTIBON_NIDOS += (data[i].LOCALIDAD=="FONTIBÓN") ? parseInt(data[i].BENEFICIARIOS):0;
            CANDELARIA_NIDOS += (data[i].LOCALIDAD=="CANDELARIA") ? parseInt(data[i].BENEFICIARIOS):0;
            SANTAFE_NIDOS += (data[i].LOCALIDAD=="SANTA FE") ? parseInt(data[i].BENEFICIARIOS):0;
            MARTIRES_NIDOS += (data[i].LOCALIDAD=="MÁRTIRES") ? parseInt(data[i].BENEFICIARIOS):0;
            ANTONIONARIÑO_NIDOS += (data[i].LOCALIDAD=="ANTONIO NARIÑO") ? parseInt(data[i].BENEFICIARIOS):0;
            PUENTEARANDA_NIDOS += (data[i].LOCALIDAD=="PUENTE ARANDA") ? parseInt(data[i].BENEFICIARIOS):0;
            RUU_NIDOS += (data[i].LOCALIDAD=="RAFAEL URIBE") ? parseInt(data[i].BENEFICIARIOS):0;
            SANCRISTOBAL_NIDOS += (data[i].LOCALIDAD=="SAN CRISTOBAL") ? parseInt(data[i].BENEFICIARIOS):0;
            SUMAPAZ_NIDOS += (data[i].LOCALIDAD=="SUMAPAZ") ? parseInt(data[i].BENEFICIARIOS):0;
            USME_NIDOS += (data[i].LOCALIDAD=="USME") ? parseInt(data[i].BENEFICIARIOS):0;
            TUNJUELITO_NIDOS += (data[i].LOCALIDAD=="TUNJUELITO") ? parseInt(data[i].BENEFICIARIOS):0;
            CIUDADBOLIVAR_NIDOS += (data[i].LOCALIDAD=="CIUDAD BOLIVAR") ? parseInt(data[i].BENEFICIARIOS):0;
            KENNEDY_NIDOS += (data[i].LOCALIDAD=="KENNEDY") ? parseInt(data[i].BENEFICIARIOS):0;
            BOSA_NIDOS += (data[i].LOCALIDAD=="BOSA") ? parseInt(data[i].BENEFICIARIOS):0;
          }

          json_areas = [{
            title: "USAQUEN",
            id: "CO-BO1",
            color: "#00547b",
            customData: "<b>CREA AE: </b>"+USAQUEN_AE+"<br><b>CREA EC: </b>"+USAQUEN_EC+"<br><b>CREA LC: </b>"+USAQUEN_LC+"<br><b>NIDOS: </b>"+USAQUEN_NIDOS,
          },{
            title: "CHAPINERO",
            id: "CO-BO2",
            color: "#29abe2",
            customData: "<b>CREA AE: </b>"+CHAPINERO_AE+"<br><b>CREA EC: </b>"+CHAPINERO_EC+"<br><b>CREA LC: </b>"+CHAPINERO_LC+"<br><b>NIDOS: </b>"+CHAPINERO_NIDOS,
          },{
            title: "BARRIOS UNIDOS",
            id: "CO-BO3",
            color: "#00547b",
            customData: "<b>CREA AE: "+BARRIOSUNIDOS_AE+"<br><b>CREA EC: </b>"+BARRIOSUNIDOS_EC+"<br><b>CREA LC: </b>"+BARRIOSUNIDOS_LC+"<br><b>NIDOS: </b>"+BARRIOSUNIDOS_NIDOS+"<br><b>Crea 12 de Octubre</b><br>Cra 55 N° 75 - 40<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Doce-de-Octubre-150x150.jpg' width='100'><br><b>Crea Santa Sofía</b><br>Cra 28a Nº 77-70<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Santa-Sofia-150x150.jpg' width='100'>",
          },{
            title: "TEUSAQUILLO",
            id: "CO-BO4",
            color: "#00a99d",
            customData: "<b>CREA AE: </b>"+TEUSAQUILLO_AE+"<br><b>CREA EC: </b>"+TEUSAQUILLO_EC+"<br><b>CREA LC: </b>"+TEUSAQUILLO_LC+"<br><b>NIDOS: </b>"+TEUSAQUILLO_NIDOS,
          },{
            title: "SUBA",
            id: "CO-BO5",
            color: "#00a99d",
            customData: "<b>CREA AE: </b>"+SUBA_AE+"<br><b>CREA EC: </b>"+SUBA_EC+"<br><b>CREA LC: </b>"+SUBA_LC+"<br><b>NIDOS: </b>"+SUBA_NIDOS+"<br><b>Crea Suba Campiña</b><br>calle 146A # 94 A-05<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Campina-150x150.jpg' width='100'><br><b>Crea Suba Centro</b><br>Calle 146B Nº 91 - 44<br><img src='https://talento.crea.gov.co/archivos/2018/08/FACHADA-SUBA-CENTRO-150x150.jpg' width='100'>",
          },{
            title: "ENGATIVA",
            id: "CO-BO6",
            color: "#2e3192",
            customData: "<b>CREA AE: </b>"+ENGATIVA_AE+"<br><b>CREA EC: </b>"+ENGATIVA_EC+"<br><b>CREA LC: </b>"+ENGATIVA_LC+"<br><b>NIDOS: </b>"+ENGATIVA_NIDOS+"<br><b>Crea Villas del Dorado</b><br>Cra. 107 N° 70 - 58<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Villas-del-Dorado-150x150.jpg' width='100'><br><b>Crea La Granja</b><br>Calle 78 No.77B-86<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Granja-1-150x150.jpg' width='100'>",
          },{
            title: "FONTIBON",
            id: "CO-BO7",
            color: "#00547b",
            customData: "<b>CREA AE: </b>"+FONTIBON_AE+"<br><b>CREA EC: </b>"+FONTIBON_EC+"<br><b>CREA LC: </b>"+FONTIBON_LC+"<br><b>NIDOS: </b>"+FONTIBON_NIDOS+"<br><b>Crea Villemar</b><br>Calle 20C N° 96C - 51<br><img src='https://talento.crea.gov.co/archivos/2018/08/FACHADA-CREA-VILLEMAR-150x150.jpg' width='100'><br><b>Crea Las Flores</b><br>Calle 23G N° 111 - 16<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-crea-flores-150x150.jpg' width='100'>",
          },{
            title: "CANDELARIA",
            id: "CO-BO8",
            color: "#5e6c68",
            customData: "<b>CREA AE: </b>"+CANDELARIA_AE+"<br><b>CREA EC: </b>"+CANDELARIA_EC+"<br><b>CREA LC: </b>"+CANDELARIA_LC+"<br><b>NIDOS: </b>"+CANDELARIA_NIDOS,
          },{
            title: "SANTA FE",
            id: "CO-BO9",
            color: "#2e3192",
            customData: "<b>CREA AE: </b>"+SANTAFE_AE+"<br><b>CREA EC: </b>"+SANTAFE_EC+"<br><b>CREA LC: </b>"+SANTAFE_LC+"<br><b>NIDOS: </b>"+SANTAFE_NIDOS,
          },{
            title: "MARTIRES",
            id: "CO-BO10",
            color: "#00547b",
            customData: "<b>CREA AE: </b>"+MARTIRES_AE+"<br><b>CREA EC: </b>"+MARTIRES_EC+"<br><b>CREA LC: </b>"+MARTIRES_LC+"<br><b>NIDOS: </b>"+MARTIRES_NIDOS+"<br><b>Crea La Pepita</b><br>Cra 25 N° 10 - 78<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Pepita-150x150.jpg' width='100'>",
          },{
            title: "ANTONIO NARIÑO",
            id: "CO-BO11",
            color: "#29abe2",
            customData: "<b>CREA AE: </b>"+ANTONIONARIÑO_AE+"<br><b>CREA EC: </b>"+ANTONIONARIÑO_EC+"<br><b>CREA LC: </b>"+ANTONIONARIÑO_LC+"<br><b>NIDOS: </b>"+ANTONIONARIÑO_NIDOS,
          },{
            title: "PUENTE ARANDA",
            id: "CO-BO12",
            color: "#5e6c68",
            customData: "<b>CREA AE: </b>"+PUENTEARANDA_AE+"<br><b>CREA EC: </b>"+PUENTEARANDA_EC+"<br><b>CREA LC: </b>"+PUENTEARANDA_LC+"<br><b>NIDOS: </b>"+PUENTEARANDA_NIDOS,
          },{
            title: "RAFAEL URIBE URIBE",
            id: "CO-BO13",
            color: "#00547b",
            customData: "<b>CREA AE: </b>"+RUU_AE+"<br><b>CREA EC: </b>"+RUU_EC+"<br><b>CREA LC: </b>"+RUU_LC+"<br><b>NIDOS: </b>"+RUU_NIDOS+"<br><b>Crea Rafael Uribe Uribe</b><br>Calle 27a Sur N° 13 - 51<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-RUU-150x150.jpg' width='100'",
          },{
            title: "SAN CRISTOBAL",
            id: "CO-BO14",
            color: "#00a99d",
            customData: "<b>CREA AE: </b>"+SANCRISTOBAL_AE+"<br><b>CREA EC: </b>"+SANCRISTOBAL_EC+"<br><b>CREA LC: </b>"+SANCRISTOBAL_LC+"<br><b>NIDOS: </b>"+SANCRISTOBAL_NIDOS,
          },{
            title: "SUMAPAZ",
            id: "CO-BO15",
            color: "#01937c",
            customData: "<b>CREA AE: </b>"+SUMAPAZ_AE+"<br><b>CREA EC: </b>"+SUMAPAZ_EC+"<br><b>CREA LC: </b>"+SUMAPAZ_LC+"<br><b>NIDOS: </b>"+SUMAPAZ_NIDOS,
          },{
            title: "USME",
            id: "CO-BO16",
            color: "#89ddaf",
            customData: "<b>CREA AE: </b>"+USME_AE+"<br><b>CREA EC: </b>"+USME_EC+"<br><b>CREA LC: </b>"+USME_LC+"<br><b>NIDOS: </b>"+USME_NIDOS+"<br><b>Crea Cantarrana</b><br>Cra 1A Bis N° 100 - 45 Sur<br><img src='https://talento.crea.gov.co/archivos/2018/08/fachadacantarrana-150x150.jpg' width='100'",
          },{
            title: "TUNJUELITO",
            id: "CO-BO17",
            color: "#00547b",
            customData: "<b>CREA AE: </b>"+TUNJUELITO_AE+"<br><b>CREA EC: </b>"+TUNJUELITO_EC+"<br><b>CREA LC: </b>"+TUNJUELITO_LC+"<br><b>NIDOS: </b>"+TUNJUELITO_NIDOS,
          },{
            title: "CIUDAD BOLIVAR",
            id: "CO-BO18",
            color: "#01937c",
            customData: "<b>CREA AE: </b>"+CIUDADBOLIVAR_AE+"<br><b>CREA EC: </b>"+CIUDADBOLIVAR_EC+"<br><b>CREA LC: </b>"+CIUDADBOLIVAR_LC+"<br><b>NIDOS: </b>"+CIUDADBOLIVAR_NIDOS+"<br><b>Crea Meissen</b><br>AV Boyacá N° 62-30 Sur<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-crea-meissen-150x150.jpg' width='100'><br><b>Crea Lucero Bajo</b><br>Cra 17D Bis Nº 64A - 54 Sur<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Crea-Lucero-150x150.jpg' width='100'>",
          },{
            title: "KENNEDY",
            id: "CO-BO19",
            color: "#29abe2",
            customData: "<b>CREA AE: </b>"+KENNEDY_AE+"<br><b>CREA EC: </b>"+KENNEDY_EC+"<br><b>CREA LC: </b>"+KENNEDY_LC+"<br><b>NIDOS: </b>"+KENNEDY_NIDOS+"<br><b>Crea Castilla</b><br>Carrera 75 Nº 8B - 89<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Castilla-150x150.jpg' width='100'><br><b>Crea Roma</b><br>Ave. Calle 55 sur (Av primera de mayo) No. 79 G-09<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Roma-150x150.jpg' width='100'><br><b>Crea Las Delicias</b><br>AV Boyacá N° 43A - 62 Sur<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Delicias-150x150.jpg' width='100'>",
          },{
            title: "BOSA",
            id: "CO-BO20",
            color: "#00547b",
            customData: "<b>CREA AE: </b>"+BOSA_AE+"<br><b>CREA EC: </b>"+BOSA_EC+"<br><b>CREA LC: </b>"+BOSA_LC+"<br><b>NIDOS: </b>"+BOSA_NIDOS+"<br><b>Crea Naranjos</b><br>Calle 70A sur N° 80i - 15<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-Naranjos-1-150x150.jpg' width='100'><br><b>Crea San Pablo</b><br>Calle 68 Sur N° 78H - 37<br><img src='https://talento.crea.gov.co/archivos/2018/08/Fachada-San-Pablo-150x150.jpg' width='100'>",
          },];

          map.dataProvider.areas = json_areas;
          map.validateData();
          swal.close();
        // var elemento = "#"+data[i].LOCALIDAD;
        // var cantidad = "#"+data[i].BENEFICIARIOS;
        // $(elemento).html(cantidad);
        // for ( var x in map.dataProvider.areas ) {
        //   map.dataProvider.areas[ x ].customData = "AAA";
        // }
        // map.validateData();
      });
}catch(err){
  console.error("Error al leer estadísticas de Localidades: "+err.message);
}              
}
});
});

setInterval( function() {
}, 3000 );

var datosCrea=[];
$("#BT_CARGAR_GRAFICAS").on("click", function(){
  if($("#SL_Ano_Crea_Linea").val() == "" || $("#SL_Linea").val() == ""){
    swal("Debe seleccionar una línea y un año");
  }
  else{
    var anio = $("#SL_Ano_Crea_Linea").val();
    swal({
      text:'Cargando información',
      allowOutsideClick: false,
      allowEscapeKey: false,
      onOpen: () => {
        swal.showLoading();
      }
    });
    
    if(anio<(new Date()).getFullYear()){
      var datos = {
        funcion : 'getEstadisticas',
        p1: anio
      };
      $.ajax({
        url: url_service,
        type: 'POST',
        data: datos, 
        success: function(data){ 
          try{
            datos = JSON.parse(data)[0]; 
            datosCrea[datos.PK_Anio]=datos;
            swal.close();
            cargarDatosTabla($("#SL_Linea").val(),anio);
            $("#chartDivs").prop("hidden", false); 
          }catch(err){
            console.error("Error al leer datos años anteriores: "+err.message);
          }
        } 
      });
    }
    else {
      var datos = {
        funcion : 'getEstadisticasMesActual',
        p1: anio
      };
      $.ajax({
        url: url_service,
        type: 'POST',
        data: datos,
        success: function(data){ 
          try{
            datos = JSON.parse(data)[0];
            datosCrea[datos.PK_Anio]=datos;         
            swal.close();
            cargarDatosTabla($("#SL_Linea").val(),anio);
            $("#chartDivs").prop("hidden", false); 
          }catch(err){
            console.error("Error al leer datos año actual: "+err.message);
          }              
        } 
      });      
    }
  }
});

$("#SL_Linea_C").change(function(e){
  $("#SL_Ano_Crea_Linea_C").trigger("change"); 
});
$("#SL_Ano_Crea_Linea_C").change(function(e){
  var linea = $("#SL_Linea_C").val();
  var anio = $(this).val(); 
  var columna = "";
    //console.log(datosCrea);
    if( datosCrea[anio]!=undefined){
      mostrarGraficaCrea(datosCrea[anio],linea);
    }    
    var totales = JSON.parse(datosCrea[anio].TX_Cobertura_Linea); 
    $("#totalAE").html(totales[totales.length-1].ACUMULADO_AE+" (IDARTES: "+totales[totales.length-1].ACUMULADO_IDARTES+") (SED: "+totales[totales.length-1].ACUMULADO_SED+")");
    $("#totalEC").html(totales[totales.length-1].ACUMULADO_EC);
    $("#totalLC").html(totales[totales.length-1].ACUMULADO_LC); 
    $("#anioTotal").html(anio);    
  });  

$("#SL_Linea_Areas").change(function(e){
  $("#SL_Ano_Areas").trigger("change"); 
});
$("#SL_Ano_Areas").change(function(e){
  var linea = $("#SL_Linea_Areas").val();
  var anio = $(this).val(); 
  var columna = "";

  // [{"AREA":"DANZA","VALORAREA":1,"ATENCION_AE":5230,"ATENCION_EC":25,"ATENCION_LC":4,"ACUMULADO_LINEAS":5259,"CONSOLIDADO":5259,"color":"#8DE380"}]
  //console.log(datosCrea);
  if( datosCrea[anio]!=undefined){
    mostrarGraficaCrea(datosCrea[anio],linea);
  }
  var totales = JSON.parse(datosCrea[anio].TX_Cobertura_Linea); 
  $("#totalAE").html(totales[totales.length-1].ACUMULADO_AE+" (IDARTES: "+totales[totales.length-1].ACUMULADO_IDARTES+") (SED: "+totales[totales.length-1].ACUMULADO_SED+")");
  $("#totalEC").html(totales[totales.length-1].ACUMULADO_EC);
  $("#totalLC").html(totales[totales.length-1].ACUMULADO_LC); 
  $("#anioTotal").html(anio);    
});  

function cargarDatosTabla(linea, anio){
  var linea = linea;
  var anio = anio; 
  var columna1 = "";
  var columna2 = ""; 
  if( datosCrea[anio]!=undefined){
    mostrarGraficaLinea(datosCrea[anio],linea);
    mostrarGraficaCrea(datosCrea[anio],linea);
  }
  var totales = JSON.parse(datosCrea[anio].TX_Cobertura_Linea); 
  $("#totalAE").html(totales[totales.length-1].ACUMULADO_AE+" (IDARTES: "+totales[totales.length-1].ACUMULADO_IDARTES+") (SED: "+totales[totales.length-1].ACUMULADO_SED+")");
  $("#totalEC").html(totales[totales.length-1].ACUMULADO_EC);
  $("#totalLC").html(totales[totales.length-1].ACUMULADO_LC); 
  $("#anioTotal").html(anio);
};

function mostrarGraficaLinea(datosCrea,linea)
{
    //console.log(datosCrea,linea);
    var columna1,columna2;
    var coberturaLineasMensual = JSON.parse(datosCrea.TX_Cobertura_Linea);   
    jQuery.each(coberturaLineasMensual, function(clave,valor) {
      delete coberturaLineasMensual[clave].VALORMES;
      delete coberturaLineasMensual[clave].ACUMULADO_LINEAS_MES;
      delete coberturaLineasMensual[clave].CONSOLIDADO;
      delete coberturaLineasMensual[clave].VALORMES;
      delete coberturaLineasMensual[clave].color;
      //coberturaLineasMensual[clave].MES = coberturaLineasMensual[clave].MES.substring(0,3);
      if(linea=="arte_escuela"){
        delete coberturaLineasMensual[clave].ATENCION_MES_EC;
        delete coberturaLineasMensual[clave].ATENCION_MES_LC;
        delete coberturaLineasMensual[clave].ACUMULADO_EC;
        delete coberturaLineasMensual[clave].ACUMULADO_LC;                  
        columna1 = "ATENCION_MES_AE"
        columna2 = "ACUMULADO_AE"
        columna3 = "ATENCION_MES_AE_IDARTES"
        columna4 = "ATENCION_MES_AE_SED"
        columna5 = "ACUMULADO_IDARTES"
        columna6 = "ACUMULADO_SED"
      }else if(linea=="emprende_clan"){
        delete coberturaLineasMensual[clave].ATENCION_MES_AE;
        delete coberturaLineasMensual[clave].ATENCION_MES_LC;
        delete coberturaLineasMensual[clave].ACUMULADO_AE;
        delete coberturaLineasMensual[clave].ACUMULADO_LC;                    
        columna1 = "ATENCION_MES_EC"
        columna2 = "ACUMULADO_EC"
        columna3 = ""
        columna4 = ""
        columna5 = ""
        columna6 = ""
      }else if(linea=="laboratorio_clan"){
        delete coberturaLineasMensual[clave].ATENCION_MES_AE;
        delete coberturaLineasMensual[clave].ATENCION_MES_EC;
        delete coberturaLineasMensual[clave].ACUMULADO_AE;
        delete coberturaLineasMensual[clave].ACUMULADO_EC;                  
        columna1 = "ATENCION_MES_LC"
        columna2 = "ACUMULADO_LC"
        columna3 = ""
        columna4 = ""
        columna5 = ""
        columna6 = ""
      }
    });
    var chart = AmCharts.makeChart("chartdiv", {
      "theme": "chalk",
      "type": "serial",
      "dataProvider": coberturaLineasMensual,
      "valueAxes": [{
        //"unit": "%",
        "position": "left",
        "title": "Beneficiarios Atendidos",
      }],                  
      "startDuration": 1,
      "graphs": [{
        "balloonText": "Acumulado en [[category]] "+linea+" <b>[[value]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Acumulado",
        "type": "column",
        "columnWidth":0.8,
        "valueField": columna2
      },{
        "balloonText": "Atendidos en [[category]] "+linea+" <b>[[value]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Mensual",
        "type": "column",
        "clustered":false,
        "columnWidth":0.6,
        "valueField": columna1
      },{
        "balloonText": "Atendidos [[category]] IDARTES<b> [[value]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Mensual",
        "type": "column",
        "clustered":false,
        "columnWidth":0.6,
        "valueField": columna3
      },{
        "balloonText": "Atendidos [[category]] SED<b> [[value]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Mensual",
        "type": "column",
        "clustered":false,
        "columnWidth":0.6,
        "valueField": columna4
      },{
        "balloonText": "Acumulado IDARTES<b> [[value]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Mensual",
        "type": "column",
        "clustered":false,
        "columnWidth":0.6,
        "valueField": columna5
      },{
        "balloonText": "Acumulado SED<b> [[value]]</b>",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "title": "Mensual",
        "type": "column",
        "clustered":false,
        "columnWidth":0.6,
        "valueField": columna6
      }],
      "plotAreaFillAlphas": 0.1,
      "categoryField": "MES",
      "categoryAxis": {
        "gridPosition": "start",
        "labelRotation": 45
      },
      "chartCursor": {
        "enabled": true
      },
      "chartScrollbar": {
        "enabled": true
      },                  
      "export": {
        "enabled": true
      } 

    });            
  }

  function mostrarGraficaCrea(datosCrea,linea)
  {
      //console.log(datosCrea,linea);
      coberturaLineasCrea = JSON.parse(datosCrea.TX_Cobertura_Crea); 
      jQuery.each(coberturaLineasCrea, function(clave,valor) {
        delete coberturaLineasCrea[clave].color;
        coberturaLineasCrea[clave].CREA = coberturaLineasCrea[clave].CREA.substring(4);
        //coberturaLineasMensual[clave].MES = coberturaLineasMensual[clave].MES.substring(0,3);
        if(linea=="arte_escuela"){
          delete coberturaLineasCrea[clave].ATENCION_EC;
          delete coberturaLineasCrea[clave].ATENCION_LC;
          columna = "ATENCION_AE"
        }else if(linea=="emprende_clan"){
          delete coberturaLineasCrea[clave].ATENCION_AE;
          delete coberturaLineasCrea[clave].ATENCION_LC;
          columna = "ATENCION_EC"
        }else if(linea=="laboratorio_clan"){
          delete coberturaLineasCrea[clave].ATENCION_AE;
          delete coberturaLineasCrea[clave].ATENCION_EC;
          columna = "ATENCION_LC" 
        }
      }); 
      //console.log(coberturaLineasCrea);  
      var chart = AmCharts.makeChart("chartdivC", { 
        "theme": "chalk",
        "type": "serial",
        "dataProvider": coberturaLineasCrea,
        "valueAxes": [{
              //"unit": "%",
              "position": "left",
              "title": "Beneficiarios Atendidos",
            }],
            "startDuration": 1,
            "graphs": [{
              "balloonText": "Atendidos en [[category]] "+linea+" <b>[[value]]</b>",
              "fillAlphas": 0.9,
              "lineAlpha": 0.2,
              "title": "2004", 
              "type": "column", 
              "columnWidth":0.7,
              "valueField": columna
            }],
            "plotAreaFillAlphas": 0.1,
            "categoryField": "CREA",  
            "categoryAxis": {
              "gridPosition": "start",
              "labelRotation": 45, 
              "labelOffset": -10,
              "labelFrequency":0.1
              //"centerRotatedLabels": -50
            },
            "chartCursor": {
              "enabled": true
            },
            "chartScrollbar": {
              "enabled": true
            },                   
            "export": {
              "enabled": true
            }

          });                      
    }
  }); 
