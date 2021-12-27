$(document).ready(function(){
//document.write("Server time is: " + date);
    obtenerFechaHora(true);  
    var myVar = setInterval(function() {obtenerFechaHora(true);}, 60000);
});

var xmlHttp;
function srvTime(){
    var xmlHttp;
    try {

        xmlHttp = new XMLHttpRequest();
    }
    catch (err1) {

        try {
            xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err2) {
            try {
                xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch (eerr3) {

                alert("AJAX not supported");
            }
        }
    }
    xmlHttp.open('HEAD',window.location.href.toString(),false);
    xmlHttp.setRequestHeader("Content-Type", "text/html");
    xmlHttp.send('');
    return xmlHttp.getResponseHeader("Date");
}

function obtenerFechaHora(principal){
    var st = srvTime();
    var date = new Date(st);
    var localTime = new Date();
    var monthNames = [
    "En", "Feb", "Mar",
    "Abr", "May", "Jun", "Jul",
    "Ago", "Sep", "Oct",
    "Nov", "Dic"
    ];

    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();
    var h = date.getHours();
    var m = date.getMinutes();
    var s = date.getSeconds();
    m = checkTime(m);
    s = checkTime(s); 
    if(principal)
        $("#time").html(''+h+':'+m+' '+day+'/'+monthNames[monthIndex]+'/'+year);
    else
       return date; 
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

parent.iframeFunctions = {
    test: obtenerFechaHora
}

