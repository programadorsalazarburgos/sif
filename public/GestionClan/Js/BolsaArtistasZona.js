let url_ok_obj = '../../src/GestionClan/GestionClanController/';
let array_artistas = [];
array_artistas['area_artistica'] = [];
array_artistas['zona'] = [];
let array_grupos = [];
array_grupos['area_artistica'] = [];
array_grupos['zona'] = [];

array_grupos['area_artistica']['ae'] = [];
array_grupos['area_artistica']['ic'] = [];
array_grupos['area_artistica']['cv'] = [];
array_grupos['area_artistica']['convenio_1'] = [];
array_grupos['area_artistica']['convenio_2'] = [];

array_grupos['zona']['ae'] = [];
array_grupos['zona']['ic'] = [];
array_grupos['zona']['cv'] = [];
array_grupos['zona']['convenio_1'] = [];
array_grupos['zona']['convenio_2'] = [];

var matriz_asignacion = {"7":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}],"8":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}],"9":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}],"10":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}],"11":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}]};
var alerta_artistas = 0;
var alerta_grupos_ae = 0;
var alerta_grupos_ec = 0;
var alerta_grupos_lc = 0;
var alerta_grupos_convenio_1 = 0;
var alerta_grupos_convenio_2 = 0;
$(function(){
    if(parent.idRol == 18 || parent.idRol == 17){
    }else{
        $("#BT_guardar").hide();
    }

    cargarTablaBolsaArtistas();
    // $.ajax({
    //     url: url_ok_obj+'getOptionAnioEstadistica',
    //     type: 'POST',
    //     async:false,
    //     beforeSend: function(){
    //         parent.mostrarCargando();
    //     }
    // }).done(function(data){
    //     parent.cerrarCargando();
    //     $("#SL_anio").html(data).selectpicker('refresh').change(cargarTablaBolsaArtistas);//.trigger('change');
    //     $('#SL_anio').selectpicker('val', '2020-II').trigger('change');
    // }).fail(function(data){
    //     parent.mostrarAlerta("error","Error","No se ha podido cargar el seleccionable de años." + data);
    //     console.log(data)
    // });

    // $("#div_table_bolsa_artistas").delegate(".numero_artistas","click",function(){
    //     if(parent.idRol == 18 || parent.idRol == 17){
    //         if($(this).attr("contentEditable") == true){
    //             $(this).attr("contentEditable","false");
    //         } else {
    //             $(this).attr("contentEditable","true");
    //         }
    //     }
    // }).delegate(".numero_artistas","focusout",function(){
    //     let val=$(this).text();
    //     if(isInt(val)){
    //         let id_area_artistica=$(this).data("id_area_artistica");
    //         let id_zona=$(this).data("id_zona");
    //         let total_artistas_area=0;
    //         let total_artistas_zona=0;
    //         if(array_artistas['area_artistica'][id_area_artistica] == null){
    //             array_artistas['area_artistica'][id_area_artistica]=[];
    //         }
    //         if(array_artistas['zona'][id_zona] == null){
    //             array_artistas['zona'][id_zona]=[];
    //         }
    //         if(matriz_asignacion[id_zona]==null){
    //             matriz_asignacion[id_zona]=[];
    //         }
    //         if(matriz_asignacion[id_zona][id_area_artistica]==null){
    //             matriz_asignacion[id_zona][id_area_artistica]={};
    //         }
    //         matriz_asignacion[id_zona][id_area_artistica].numero_artistas=val;
    //         array_artistas['area_artistica'][id_area_artistica][id_zona]=val;
    //         array_artistas['zona'][id_zona][id_area_artistica]=val;
    //         array_artistas['area_artistica'][id_area_artistica].forEach(a => {
    //             total_artistas_area+=parseInt(a);
    //         });
    //         array_artistas['zona'][id_zona].forEach(a => {
    //             total_artistas_zona+=parseInt(a);
    //         });
    //         $("#artistas_usados_zona_"+id_zona).html(total_artistas_zona);

    //         let total_artistas_area_temp=[]
    //         $.each(matriz_asignacion, function(i, val) {
    //             $.each(matriz_asignacion[i],function(j,val2) {
    //                 if(total_artistas_area_temp[j] == undefined){
    //                     total_artistas_area_temp[j]=0
    //                 }
    //                 if(matriz_asignacion[i][j]!=undefined) {
    //                     if(matriz_asignacion[i][j].numero_artistas != undefined){
    //                         total_artistas_area_temp[j]+= parseInt(matriz_asignacion[i][j].numero_artistas);
    //                         $("#artistas_usados_area_"+j).html(total_artistas_area_temp[j]);
    //                         if(total_artistas_area_temp[j] > parseInt($("#artistas_disponibles_area_"+j).text())){
    //                             $("#artistas_usados_area_"+j).removeClass('btn-warning');
    //                             $("#artistas_usados_area_"+j).removeClass('btn-success');
    //                             $("#artistas_usados_area_"+j).addClass('btn-danger');
    //                         }else{
    //                             $("#artistas_usados_area_"+j).removeClass('btn-success');
    //                             $("#artistas_usados_area_"+j).removeClass('btn-danger');
    //                             $("#artistas_usados_area_"+j).addClass('btn-warning');
    //                         }
    //                         if(total_artistas_area_temp[j] == parseInt($("#artistas_disponibles_area_"+j).text())){
    //                             $("#artistas_usados_area_"+j).removeClass('btn-warning');
    //                             $("#artistas_usados_area_"+j).removeClass('btn-danger');
    //                             $("#artistas_usados_area_"+j).addClass('btn-success');
    //                         }
    //                     }
    //                 }
    //             })
    //         });

    //         if(parseInt($("#artistas_usados_area_"+id_area_artistica).text()) > parseInt($("#artistas_disponibles_area_"+id_area_artistica).text())){
    //             parent.mostrarAlerta("error","Superó el límite.","El valor de AF asignados no puede ser mayor a los AF disponibles");
    //         }
    //     }else{
    //         parent.mostrarAlerta("warning","No valido","Digite un valor númerico");
    //     }
    // });

    // $("#div_table_bolsa_artistas").delegate(".numero_grupos_ae","click",function(){
    //     if(parent.idRol == 18 || parent.idRol == 17){
    //         if($(this).attr("contentEditable") == true){
    //             $(this).attr("contentEditable","false");
    //         } else {
    //             $(this).attr("contentEditable","true");
    //         }
    //     }
    // }).delegate(".numero_grupos_ae","focusout",function(){
    //     let val=$(this).text();
    //     if(isInt(val)){
    //         let id_area_artistica=$(this).data("id_area_artistica");
    //         let id_zona=$(this).data("id_zona");
    //         let total_grupos_area=0;
    //         let total_grupos_zona=0;
    //         if(array_grupos['area_artistica']['ae'][id_area_artistica] == null){
    //             array_grupos['area_artistica']['ae'][id_area_artistica]=[];
    //         }
    //         if(array_grupos['zona']['ae'][id_zona] == null){
    //             array_grupos['zona']['ae'][id_zona]=[];
    //         }
    //         if(matriz_asignacion[id_zona]==null){
    //             matriz_asignacion[id_zona]=[];
    //         }
    //         if(matriz_asignacion[id_zona][id_area_artistica]==null){
    //             matriz_asignacion[id_zona][id_area_artistica]={};
    //         }
    //         matriz_asignacion[id_zona][id_area_artistica].grupos_arte_escuela=val;
    //         array_grupos['area_artistica']['ae'][id_area_artistica][id_zona]=val;
    //         array_grupos['zona']['ae'][id_zona][id_area_artistica]=val;
    //         array_grupos['area_artistica']['ae'][id_area_artistica].forEach(a => {
    //             total_grupos_area+=parseInt(a);
    //         });
    //         array_grupos['zona']['ae'][id_zona].forEach(a => {
    //             total_grupos_zona+=parseInt(a);
    //         });

    //         $("#grupos_usados_arte_escuela_zona_"+id_zona).text(total_grupos_zona);

    //         let total_grupos_ae_temp=[]
    //         $.each(matriz_asignacion, function(i, val) {
    //             $.each(matriz_asignacion[i],function(j,val2) {
    //                 if(total_grupos_ae_temp[j] == undefined){
    //                     total_grupos_ae_temp[j]=0
    //                 }
    //                 if(matriz_asignacion[i][j]!=undefined) {
    //                     if(matriz_asignacion[i][j].grupos_arte_escuela != undefined){
    //                         total_grupos_ae_temp[j]+= parseInt(matriz_asignacion[i][j].grupos_arte_escuela);
    //                         $("#grupos_usados_arte_escuela_"+j).html(total_grupos_ae_temp[j]);
    //                         if(total_grupos_ae_temp[j] > parseInt($("#grupos_disponibles_arte_escuela_"+j).text())){
    //                             $("#grupos_usados_arte_escuela_"+j).removeClass('btn-warning');
    //                             $("#grupos_usados_arte_escuela_"+j).removeClass('btn-success');
    //                             $("#grupos_usados_arte_escuela_"+j).addClass('btn-danger');
    //                         }else{
    //                             $("#grupos_usados_arte_escuela_"+j).removeClass('btn-success');
    //                             $("#grupos_usados_arte_escuela_"+j).removeClass('btn-danger');
    //                             $("#grupos_usados_arte_escuela_"+j).addClass('btn-warning');
    //                         }
    //                         if(total_grupos_ae_temp[j] == parseInt($("#grupos_disponibles_arte_escuela_"+j).text())){
    //                             $("#grupos_usados_arte_escuela_"+j).removeClass('btn-warning');
    //                             $("#grupos_usados_arte_escuela_"+j).removeClass('btn-danger');
    //                             $("#grupos_usados_arte_escuela_"+j).addClass('btn-success');
    //                         }
    //                     }
    //                 }
    //             })
    //         });
    //         if(parseInt($("#grupos_usados_arte_escuela_"+id_area_artistica).text()) > parseInt($("#grupos_disponibles_arte_escuela_"+id_area_artistica).text())){
    //             parent.mostrarAlerta("error","Superó el límite.","La cantidad de Grupos AE asignados no puede ser mayor a los Grupos AE disponibles.");
    //         }
    //     }else{
    //         parent.mostrarAlerta("warning","No valido","Digite un valor númerico");
    //     }
    // }).delegate(".numero_grupos_ec","click",function(){
    //     if(parent.idRol == 18 || parent.idRol == 17){
    //         if($(this).attr("contentEditable") == true){
    //             $(this).attr("contentEditable","false");
    //         } else {
    //             $(this).attr("contentEditable","true");
    //         }
    //     }
    // }).delegate(".numero_grupos_ec","focusout",function(){
    //     let val=$(this).text();
    //     if(isInt(val)){
    //         let id_area_artistica=$(this).data("id_area_artistica");
    //         let id_zona=$(this).data("id_zona");
    //         let total_grupos_area=0;
    //         let total_grupos_zona=0;
    //         if(array_grupos['area_artistica']['ic'][id_area_artistica] == null){
    //             array_grupos['area_artistica']['ic'][id_area_artistica]=[];
    //         }
    //         if(array_grupos['zona']['ic'][id_zona] == null){
    //             array_grupos['zona']['ic'][id_zona]=[];
    //         }
    //         if(matriz_asignacion[id_zona]==null){
    //             matriz_asignacion[id_zona]=[];
    //         }
    //         if(matriz_asignacion[id_zona][id_area_artistica]==null){
    //             matriz_asignacion[id_zona][id_area_artistica]={};
    //         }
    //         matriz_asignacion[id_zona][id_area_artistica].grupos_impulso_colectivo=val;
    //         array_grupos['area_artistica']['ic'][id_area_artistica][id_zona]=val;
    //         array_grupos['zona']['ic'][id_zona][id_area_artistica]=val;
    //         array_grupos['area_artistica']['ic'][id_area_artistica].forEach(a => {
    //             total_grupos_area+=parseInt(a);
    //         });
    //         array_grupos['zona']['ic'][id_zona].forEach(a => {
    //             total_grupos_zona+=parseInt(a);
    //         });
    //         $("#grupos_usados_emprende_clan_zona_"+id_zona).text(total_grupos_zona);

    //         let total_grupos_ic_temp=[]
    //         $.each(matriz_asignacion, function(i, val) {
    //             $.each(matriz_asignacion[i],function(j,val2) {
    //                 if(total_grupos_ic_temp[j] == undefined){
    //                     total_grupos_ic_temp[j]=0
    //                 }
    //                 if(matriz_asignacion[i][j]!=undefined) {
    //                     if(matriz_asignacion[i][j].grupos_impulso_colectivo != undefined){
    //                         total_grupos_ic_temp[j]+= parseInt(matriz_asignacion[i][j].grupos_impulso_colectivo)
    //                         $("#grupos_usados_emprende_clan_"+j).html(total_grupos_ic_temp[j]);
    //                         if(total_grupos_ic_temp[j] > parseInt($("#grupos_disponibles_emprende_clan_"+j).text())){
    //                             $("#grupos_usados_emprende_clan_"+j).removeClass('btn-warning');
    //                             $("#grupos_usados_emprende_clan_"+j).removeClass('btn-success');
    //                             $("#grupos_usados_emprende_clan_"+j).addClass('btn-danger');
    //                         }else{
    //                             $("#grupos_usados_emprende_clan_"+j).removeClass('btn-success');
    //                             $("#grupos_usados_emprende_clan_"+j).removeClass('btn-danger');
    //                             $("#grupos_usados_emprende_clan_"+j).addClass('btn-warning');
    //                         }
    //                         if(total_grupos_ic_temp[j] == parseInt($("#grupos_disponibles_emprende_clan_"+j).text())){
    //                             $("#grupos_usados_emprende_clan_"+j).removeClass('btn-warning');
    //                             $("#grupos_usados_emprende_clan_"+j).removeClass('btn-danger');
    //                             $("#grupos_usados_emprende_clan_"+j).addClass('btn-success');
    //                         }
    //                     }
    //                 }
    //             });
    //         });
    //         if(parseInt($("#grupos_usados_emprende_clan_"+id_area_artistica).text()) > parseInt($("#grupos_disponibles_emprende_clan_"+id_area_artistica).text())){
    //             parent.mostrarAlerta("error","Superó el límite.","La cantidad de Grupos IC asignados no puede ser mayor a los Grupos IC disponibles.");
    //         }
    //     }else{  
    //         parent.mostrarAlerta("warning","No valido","Digite un valor númerico");
    //     }
    // }).delegate(".numero_grupos_lc","focusout",function(){
    //     let val=$(this).text();
    //     if(isInt(val)){
    //         let id_area_artistica=$(this).data("id_area_artistica");
    //         let id_zona=$(this).data("id_zona");
    //         let total_grupos_area=0;
    //         let total_grupos_zona=0;
    //         if(array_grupos['area_artistica']['cv'][id_area_artistica] == null){
    //             array_grupos['area_artistica']['cv'][id_area_artistica]=[];
    //         }
    //         if(array_grupos['zona']['cv'][id_zona] == null){
    //             array_grupos['zona']['cv'][id_zona]=[];
    //         }
    //         if(matriz_asignacion[id_zona]==null){
    //             matriz_asignacion[id_zona]=[];
    //         }
    //         if(matriz_asignacion[id_zona][id_area_artistica]==null){
    //             matriz_asignacion[id_zona][id_area_artistica]={};
    //         }
    //         matriz_asignacion[id_zona][id_area_artistica].grupos_converge=val;
    //         array_grupos['area_artistica']['cv'][id_area_artistica][id_zona]=val;
    //         array_grupos['zona']['cv'][id_zona][id_area_artistica]=val;
    //         array_grupos['area_artistica']['cv'][id_area_artistica].forEach(a => {
    //             total_grupos_area+=parseInt(a);
    //         });
    //         array_grupos['zona']['cv'][id_zona].forEach(a => {
    //             total_grupos_zona+=parseInt(a);
    //         });

    //         $("#grupos_usados_laboratorio_clan_zona_"+id_zona).text(total_grupos_zona);

    //         let total_grupos_cv_temp=[]
    //         $.each(matriz_asignacion, function(i, val) {
    //             $.each(matriz_asignacion[i],function(j,val2) {
    //                 if(total_grupos_cv_temp[j] == undefined){
    //                     total_grupos_cv_temp[j]=0
    //                 }
    //                 if(matriz_asignacion[i][j]!=undefined) {
    //                     if(matriz_asignacion[i][j].grupos_converge != undefined){
    //                         total_grupos_cv_temp[j]+= parseInt(matriz_asignacion[i][j].grupos_converge);
    //                         $("#grupos_usados_laboratorio_clan_"+j).html(total_grupos_cv_temp[j]);
    //                         if(total_grupos_cv_temp[j] > parseInt($("#grupos_disponibles_laboratorio_clan_"+j).text())){
    //                             $("#grupos_usados_laboratorio_clan_"+j).removeClass('btn-warning');
    //                             $("#grupos_usados_laboratorio_clan_"+j).removeClass('btn-success');
    //                             $("#grupos_usados_laboratorio_clan_"+j).addClass('btn-danger');
    //                         }else{
    //                             $("#grupos_usados_laboratorio_clan_"+j).removeClass('btn-success');
    //                             $("#grupos_usados_laboratorio_clan_"+j).removeClass('btn-danger');
    //                             $("#grupos_usados_laboratorio_clan_"+j).addClass('btn-warning');
    //                         }
    //                         if(total_grupos_cv_temp[j] == parseInt($("#grupos_disponibles_laboratorio_clan_"+j).text())){
    //                             $("#grupos_usados_laboratorio_clan_"+j).removeClass('btn-warning');
    //                             $("#grupos_usados_laboratorio_clan_"+j).removeClass('btn-danger');
    //                             $("#grupos_usados_laboratorio_clan_"+j).addClass('btn-success');
    //                         }
    //                     }
    //                 }
    //             });
    //         });
    //         if(parseInt($("#grupos_usados_laboratorio_clan_"+id_area_artistica).text()) > parseInt($("#grupos_disponibles_laboratorio_clan_"+id_area_artistica).text())){
    //             parent.mostrarAlerta("error","Superó el límite.","La cantidad de Grupos CV asignados no puede ser mayor a los Grupos CV disponibles.");
    //         }
    //     }else{
    //         parent.mostrarAlerta("warning","No valido","Digite un valor númerico");
    //     }
    // }).delegate(".numero_grupos_lc","click",function(){
    //     if(parent.idRol == 18 || parent.idRol == 17){
    //         if($(this).attr("contentEditable") == true){
    //             $(this).attr("contentEditable","false");
    //         } else {
    //             $(this).attr("contentEditable","true");
    //         }
    //     }
    // });

    $("#BT_guardar").click(function(){
        if(parseInt($("#artistas_usados_area_1").text()) > parseInt($("#artistas_disponibles_area_1").text()) || parseInt($("#artistas_usados_area_2").text()) > parseInt($("#artistas_disponibles_area_2").text()) || parseInt($("#artistas_usados_area_3").text()) > parseInt($("#artistas_disponibles_area_3").text()) || parseInt($("#artistas_usados_area_4").text()) > parseInt($("#artistas_disponibles_area_4").text()) || parseInt($("#artistas_usados_area_5").text()) > parseInt($("#artistas_disponibles_area_5").text()) || parseInt($("#artistas_usados_area_6").text()) > parseInt($("#artistas_disponibles_area_6").text()) || parseInt($("#artistas_usados_area_7").text()) > parseInt($("#artistas_disponibles_area_7").text()) || parseInt($("#artistas_usados_area_8").text()) > parseInt($("#artistas_disponibles_area_8").text())){
            alerta_artistas++;
        }
        else{
            alerta_artistas = 0;
        }

        if(parseInt($("#grupos_usados_arte_escuela_1").text()) > parseInt($("#grupos_disponibles_arte_escuela_1").text()) || parseInt($("#grupos_usados_arte_escuela_2").text()) > parseInt($("#grupos_disponibles_arte_escuela_2").text()) || parseInt($("#grupos_usados_arte_escuela_3").text()) > parseInt($("#grupos_disponibles_arte_escuela_3").text()) || parseInt($("#grupos_usados_arte_escuela_4").text()) > parseInt($("#grupos_disponibles_arte_escuela_4").text()) || parseInt($("#grupos_usados_arte_escuela_5").text()) > parseInt($("#grupos_disponibles_arte_escuela_5").text()) || parseInt($("#grupos_usados_arte_escuela_6").text()) > parseInt($("#grupos_disponibles_arte_escuela_6").text()) || parseInt($("#grupos_usados_arte_escuela_7").text()) > parseInt($("#grupos_disponibles_arte_escuela_7").text()) || parseInt($("#grupos_usados_arte_escuela_8").text()) > parseInt($("#grupos_disponibles_arte_escuela_8").text())){
            alerta_grupos_ae++;
        }
        else{
            alerta_grupos_ae = 0;
        }

        if(parseInt($("#grupos_usados_emprende_clan_1").text()) > parseInt($("#grupos_disponibles_emprende_clan_1").text()) || parseInt($("#grupos_usados_emprende_clan_2").text()) > parseInt($("#grupos_disponibles_emprende_clan_2").text()) || parseInt($("#grupos_usados_emprende_clan_3").text()) > parseInt($("#grupos_disponibles_emprende_clan_3").text()) || parseInt($("#grupos_usados_emprende_clan_4").text()) > parseInt($("#grupos_disponibles_emprende_clan_4").text()) || parseInt($("#grupos_usados_emprende_clan_5").text()) > parseInt($("#grupos_disponibles_emprende_clan_5").text()) || parseInt($("#grupos_usados_emprende_clan_6").text()) > parseInt($("#grupos_disponibles_emprende_clan_6").text()) || parseInt($("#grupos_usados_emprende_clan_7").text()) > parseInt($("#grupos_disponibles_emprende_clan_7").text()) || parseInt($("#grupos_usados_emprende_clan_8").text()) > parseInt($("#grupos_disponibles_emprende_clan_8").text())){
            alerta_grupos_ec++;
        }
        else{
            alerta_grupos_ec = 0;
        }

        if(parseInt($("#grupos_usados_laboratorio_clan_1").text()) > parseInt($("#grupos_disponibles_laboratorio_clan_1").text()) || parseInt($("#grupos_usados_laboratorio_clan_2").text()) > parseInt($("#grupos_disponibles_laboratorio_clan_2").text()) || parseInt($("#grupos_usados_laboratorio_clan_3").text()) > parseInt($("#grupos_disponibles_laboratorio_clan_3").text()) || parseInt($("#grupos_usados_laboratorio_clan_4").text()) > parseInt($("#grupos_disponibles_laboratorio_clan_4").text()) || parseInt($("#grupos_usados_laboratorio_clan_5").text()) > parseInt($("#grupos_disponibles_laboratorio_clan_5").text()) || parseInt($("#grupos_usados_laboratorio_clan_6").text()) > parseInt($("#grupos_disponibles_laboratorio_clan_6").text()) || parseInt($("#grupos_usados_laboratorio_clan_7").text()) > parseInt($("#grupos_disponibles_laboratorio_clan_7").text()) || parseInt($("#grupos_usados_laboratorio_clan_8").text()) > parseInt($("#grupos_disponibles_laboratorio_clan_8").text())){
            alerta_grupos_lc++;
        }
        else{
            alerta_grupos_lc = 0;
        }
        
        if(parseInt($("#grupos_usados_convenio_1_1").text()) > parseInt($("#grupos_disponibles_convenio_1_1").text()) || parseInt($("#grupos_usados_convenio_1_2").text()) > parseInt($("#grupos_disponibles_convenio_1_2").text()) || parseInt($("#grupos_usados_convenio_1_3").text()) > parseInt($("#grupos_disponibles_convenio_1_3").text()) || parseInt($("#grupos_usados_convenio_1_4").text()) > parseInt($("#grupos_disponibles_convenio_1_4").text()) || parseInt($("#grupos_usados_convenio_1_5").text()) > parseInt($("#grupos_disponibles_convenio_1_5").text()) || parseInt($("#grupos_usados_convenio_1_6").text()) > parseInt($("#grupos_disponibles_convenio_1_6").text()) || parseInt($("#grupos_usados_convenio_1_7").text()) > parseInt($("#grupos_disponibles_convenio_1_7").text()) || parseInt($("#grupos_usados_convenio_1_8").text()) > parseInt($("#grupos_disponibles_convenio_1_8").text())){
            alerta_grupos_convenio_1++;
        }
        else{
            alerta_grupos_convenio_1 = 0;
        }
        
        if(parseInt($("#grupos_usados_convenio_2_1").text()) > parseInt($("#grupos_disponibles_convenio_2_1").text()) || parseInt($("#grupos_usados_convenio_2_2").text()) > parseInt($("#grupos_disponibles_convenio_2_2").text()) || parseInt($("#grupos_usados_convenio_2_3").text()) > parseInt($("#grupos_disponibles_convenio_2_3").text()) || parseInt($("#grupos_usados_convenio_2_4").text()) > parseInt($("#grupos_disponibles_convenio_2_4").text()) || parseInt($("#grupos_usados_convenio_2_5").text()) > parseInt($("#grupos_disponibles_convenio_2_5").text()) || parseInt($("#grupos_usados_convenio_2_6").text()) > parseInt($("#grupos_disponibles_convenio_2_6").text()) || parseInt($("#grupos_usados_convenio_2_7").text()) > parseInt($("#grupos_disponibles_convenio_2_7").text()) || parseInt($("#grupos_usados_convenio_2_8").text()) > parseInt($("#grupos_disponibles_convenio_2_8").text())){
            alerta_grupos_convenio_2++;
        }
        else{
            alerta_grupos_convenio_2 = 0;
        }

        if(alerta_artistas == 0 && alerta_grupos_ae == 0 && alerta_grupos_ec == 0 && alerta_grupos_lc == 0 && alerta_grupos_convenio_1 == 0 && alerta_grupos_convenio_2 == 0){
            let datos={
                'p1':matriz_asignacion,
                'p2':parent.idUsuario,
                'p3':$("#SL_anio").val()
            }
            $.ajax({
                url: url_ok_obj+'actualizarMatrizAsignacion',
                type: 'POST',
                data:datos,
                async:false,
                beforeSend: function(){
                    parent.mostrarCargando();
                }
            }).done(function(data){
                parent.cerrarCargando();
                if(data==1){
                    parent.mostrarAlerta("success","Guardado","Se ha guardado los cambios realizados en la matriz correctamente")
                }else{
                    parent.mostrarAlerta("warning","NO Guardado","Por favor intente nuevamente")
                }
            }).fail(function(data){
    			parent.mostrarAlerta("error","Error","No se ha podido guardar los cambios de la matriz." + data);
			 console.log(data)
		  });
        }
        else{
            parent.mostrarAlerta("warning","Ajustar cifras","Las celdas en color ROJO indican que la cifra asignada es mayor que la planeada.<br>Ajuste las cifras antes de guardar.");
        }
    });

    function cargarTablaBolsaArtistas(){
        //let id_anio=$("#SL_anio").val();
        let id_anio = new Date().getFullYear();
        let datos={
            'p1':id_anio
        }
        $.ajax({
            url: url_ok_obj+'consultarTablaBolsaArtistasZona',
            type: 'POST',
            data:datos,
            async:false,
            beforeSend: function(){
                parent.mostrarCargando();
            }
        }).done(function(data){
            parent.cerrarCargando();
            $("#div_table_bolsa_artistas").html(data);
            $(".numero_grupos_ae").focusout();
            $(".numero_grupos_ec").focusout();
            $(".numero_grupos_lc").focusout();
            $(".numero_grupos_convenio_1").focusout();
            $(".numero_grupos_convenio_2").focusout();
            $(".numero_artistas").focusout();
            // matriz_asignacion = {"7":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}],"8":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}],"9":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}],"10":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}],"11":["",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"},"",{"numero_artistas":"0","grupos_arte_escuela":"0","grupos_impulso_colectivo":"0","grupos_converge":"0"}]};
            // let datos={
            //     'p1':id_anio
            // }
            // $.ajax({
            //     url: url_ok_obj+'consultarJsonMatrizAsignacion',
            //     type: 'POST',
            //     data:datos,
            //     async:false,
            //     beforeSend: function(){
            //         parent.mostrarCargando();
            //     }
            // }).done(function(data){
            //     if(data == ""){
            //     }else{
            //         let json_grupos_artistas = data
            //         try{
            //             json_grupos_artistas = $.parseJSON(json_grupos_artistas)
            //             let total_artistas_area_temp=[]
            //             let total_grupos_ae_temp=[]
            //             let total_grupos_ic_temp=[]
            //             let total_grupos_cv_temp=[]
            //             $.each(json_grupos_artistas, function(i, val) {
            //                 let id_zona_temp = i;
            //                 let id_area_artistica_temp = 0;
            //                 $(".numero_grupos_ae").trigger("click");
            //                 $(".numero_grupos_ec").trigger("click");
            //                 $(".numero_grupos_lc").trigger("click");
            //                 $(".numero_artistas").trigger("click");
            //                 $.each(json_grupos_artistas[i],function(j,val2) {
            //                     if(Object.keys(val2).length === 0){
            //                     }else{
            //                         id_area_artistica_temp = j
            //                         $("#grupos_arte_escuela_area_"+id_area_artistica_temp+"_zona_"+id_zona_temp).html(json_grupos_artistas[i][j].grupos_arte_escuela)
            //                         $("#grupos_emprende_crea_area_"+id_area_artistica_temp+"_zona_"+id_zona_temp).html(json_grupos_artistas[i][j].grupos_impulso_colectivo)
            //                         $("#grupos_laboratorio_crea_area_"+id_area_artistica_temp+"_zona_"+id_zona_temp).html(json_grupos_artistas[i][j].grupos_converge)
            //                         $("#artistas_area_"+id_area_artistica_temp+"_zona_"+id_zona_temp).html(json_grupos_artistas[i][j].numero_artistas)
                                    
            //                         if(total_artistas_area_temp[j] == undefined)
            //                             total_artistas_area_temp[j]=0
            //                         if(json_grupos_artistas[i][j].numero_artistas != undefined)
            //                             total_artistas_area_temp[j] += parseInt(json_grupos_artistas[i][j].numero_artistas)

            //                         if(total_grupos_ae_temp[j] == undefined)
            //                             total_grupos_ae_temp[j]=0
            //                         if(json_grupos_artistas[i][j].grupos_arte_escuela != undefined)
            //                             total_grupos_ae_temp[j] += parseInt(json_grupos_artistas[i][j].grupos_arte_escuela)

            //                         if(total_grupos_ic_temp[j] == undefined)
            //                             total_grupos_ic_temp[j]=0
            //                         if(json_grupos_artistas[i][j].grupos_impulso_colectivo != undefined)
            //                             total_grupos_ic_temp[j] += parseInt(json_grupos_artistas[i][j].grupos_impulso_colectivo)
                                    
            //                         if(total_grupos_cv_temp[j] == undefined)
            //                             total_grupos_cv_temp[j]=0
            //                         if(json_grupos_artistas[i][j].grupos_converge != undefined)
            //                             total_grupos_cv_temp[j] += parseInt(json_grupos_artistas[i][j].grupos_converge)

            //                         if(matriz_asignacion[id_zona_temp]==null){
            //                             matriz_asignacion[id_zona_temp]=[]
            //                         }
            //                         if(matriz_asignacion[id_zona_temp][id_area_artistica_temp]==null){
            //                             matriz_asignacion[id_zona_temp][id_area_artistica_temp]={}
            //                         }
            //                         matriz_asignacion[id_zona_temp][id_area_artistica_temp].numero_artistas=json_grupos_artistas[i][j].numero_artistas
            //                         matriz_asignacion[id_zona_temp][id_area_artistica_temp].grupos_arte_escuela=json_grupos_artistas[i][j].grupos_arte_escuela
            //                         matriz_asignacion[id_zona_temp][id_area_artistica_temp].grupos_impulso_colectivo=json_grupos_artistas[i][j].grupos_impulso_colectivo
            //                         matriz_asignacion[id_zona_temp][id_area_artistica_temp].grupos_converge=json_grupos_artistas[i][j].grupos_converge

            //                         let total_artistas_zona_temp = parseInt($("#artistas_usados_zona_"+id_zona_temp).html())
            //                         if(undefined != matriz_asignacion[id_zona_temp][id_area_artistica_temp].numero_artistas)
            //                             total_artistas_zona_temp += parseInt(matriz_asignacion[id_zona_temp][id_area_artistica_temp].numero_artistas)
            //                         $("#artistas_usados_zona_"+id_zona_temp).html(total_artistas_zona_temp)

            //                         let total_grupos_ae_zona_temp = parseInt($("#grupos_usados_arte_escuela_zona_"+id_zona_temp).html())
            //                         if(undefined != matriz_asignacion[id_zona_temp][id_area_artistica_temp].grupos_arte_escuela)
            //                             total_grupos_ae_zona_temp += parseInt(matriz_asignacion[id_zona_temp][id_area_artistica_temp].grupos_arte_escuela)
            //                         $("#grupos_usados_arte_escuela_zona_"+id_zona_temp).html(total_grupos_ae_zona_temp)

            //                         let total_grupos_ic_zona_temp = parseInt($("#grupos_usados_emprende_clan_zona_"+id_zona_temp).html())
            //                         if(undefined != matriz_asignacion[id_zona_temp][id_area_artistica_temp].grupos_impulso_colectivo)
            //                             total_grupos_ic_zona_temp += parseInt(matriz_asignacion[id_zona_temp][id_area_artistica_temp].grupos_impulso_colectivo)
            //                         $("#grupos_usados_emprende_clan_zona_"+id_zona_temp).html(total_grupos_ic_zona_temp)

            //                         let total_grupos_cv_zona_temp = parseInt($("#grupos_usados_laboratorio_clan_zona_"+id_zona_temp).html())
            //                         if(undefined != matriz_asignacion[id_zona_temp][id_area_artistica_temp].grupos_converge)
            //                         total_grupos_cv_zona_temp += parseInt(matriz_asignacion[id_zona_temp][id_area_artistica_temp].grupos_converge)
            //                         $("#grupos_usados_laboratorio_clan_zona_"+id_zona_temp).html(total_grupos_cv_zona_temp)
            //                     }
            //                 })
            //             })
            //             $.each(total_artistas_area_temp,function(j,val2) {
            //                 $("#artistas_usados_area_"+j).html(total_artistas_area_temp[j])
            //                 $("#grupos_usados_arte_escuela_"+j).html(total_grupos_ae_temp[j])
            //                 $("#grupos_usados_emprende_clan_"+j).html(total_grupos_ic_temp[j])
            //                 $("#grupos_usados_laboratorio_clan_"+j).html(total_grupos_cv_temp[j])
            //             })
            //         }catch(ex){
            //             parent.mostrarAlerta("error","Error cargando datos de grupos","No se han podido decodificar la matriz guardada anteriormente...    " + ex);
            //             console.log(ex);
            //             console.log(data);
            //         }
            //     }
            // }).fail(function(data){
            //     parent.mostrarAlerta("error","Error","No se ha podido cargar la tabla matriz de asignación." + data);
            //     console.log(data)
            // });
        }).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido cargar la tabla matriz de asignación." + data);
			console.log(data)
		});

        datos={
            //'p1':$("#SL_anio").val()
            'p1': new Date().getFullYear()
        }
        $.ajax({
            url: url_ok_obj+'getJsonColegioAnioEstadistica',
            type: 'POST',
            data:datos,
            async:false,
            beforeSend: function(){
                parent.mostrarCargando();
            }
        }).done(function(data){
            if(data==""){
                total_grupos_disponibles=[];
                total_grupos_disponibles['ae']=0;
                total_grupos_disponibles['ec']=0;
                total_grupos_disponibles['lc']=0;
                total_grupos_disponibles['convenio_1']=0;
                total_grupos_disponibles['convenio_2']=0;
                for(let i=1; i<=8;i++){
                    if(i != 7){
                        $("#grupos_disponibles_arte_escuela_"+i).html("0");
                        $("#grupos_disponibles_emprende_clan_"+i).html("0");
                        $("#grupos_disponibles_laboratorio_clan_"+i).html("0");
                        $("#grupos_disponibles_convenio_1_"+i).html("0");
                        $("#grupos_disponibles_convenio_2_"+i).html("0");
                        // if(isInt(json_grupo["ae"][i]))
                            total_grupos_disponibles['ae']+=parseInt("0");
                        // if(isInt(json_grupo["ic"][i]))
                            total_grupos_disponibles['ec']+=parseInt("0");
                        // if(isInt(json_grupo["lc"][i]))
                            total_grupos_disponibles['lc']+=parseInt("0");

                            total_grupos_disponibles['convenio_1']+=parseInt("0");
                            total_grupos_disponibles['convenio_2']+=parseInt("0");
                    }
                }
                $("#total_grupos_arte_escuela_disponibles").html("0");
                $("#total_grupos_emprende_clan_disponibles").html("0");
                $("#total_grupos_laboratorio_clan_disponibles").html("0");
                $("#total_grupos_convenio_1_disponibles").html("0");
                $("#total_grupos_convenio_2_disponibles").html("0");
                parent.mostrarAlerta("error","Faltan datos de artistas y/o grupos","No se han definido los artistas y/o grupos planeados para este periodo");
            }else{
                let json_grupo = [];
                parent.cerrarCargando();
                try{
                    json_grupo = $.parseJSON(data);
                }catch(ex){
                    parent.mostrarAlerta("error","Error cargando datos de grupos","No se han podido cargar los datos de los grupos planeados...    " + ex);
                    console.log(ex);
                    console.log(data);
                }
                total_grupos_disponibles=[];
                total_grupos_disponibles['ae']=0;
                total_grupos_disponibles['ec']=0;
                total_grupos_disponibles['lc']=0;
                total_grupos_disponibles['convenio_1']=0;
                total_grupos_disponibles['convenio_2']=0;
                for(let i=1; i<=8;i++){
                    if(i != 7){
                        $("#grupos_disponibles_arte_escuela_"+i).html(json_grupo["ae"][i]);
                        $("#grupos_disponibles_emprende_clan_"+i).html(json_grupo["ic"][i]);
                        $("#grupos_disponibles_laboratorio_clan_"+i).html(json_grupo["cv"][i]);
                        $("#grupos_disponibles_convenio_1_"+i).html(json_grupo["convenio_1"][i]);
                        $("#grupos_disponibles_convenio_2_"+i).html(json_grupo["convenio_2"][i]);
                        // if(isInt(json_grupo["ae"][i]))
                            total_grupos_disponibles['ae']+=parseInt(json_grupo["ae"][i]);
                        // if(isInt(json_grupo["ic"][i]))
                            total_grupos_disponibles['ec']+=parseInt(json_grupo["ic"][i]);
                        // if(isInt(json_grupo["lc"][i]))
                            total_grupos_disponibles['lc']+=parseInt(json_grupo["cv"][i]);
                            
                            total_grupos_disponibles['convenio_1']+=parseInt(json_grupo["convenio_1"][i]);
                            total_grupos_disponibles['convenio_2']+=parseInt(json_grupo["convenio_2"][i]);
                    }
                }
                $("#total_grupos_arte_escuela_disponibles").html(total_grupos_disponibles['ae']);
                $("#total_grupos_emprende_clan_disponibles").html(total_grupos_disponibles['ec']);
                $("#total_grupos_laboratorio_clan_disponibles").html(total_grupos_disponibles['lc']);
                $("#total_grupos_convenio_1_disponibles").html(total_grupos_disponibles['convenio_1']);
                $("#total_grupos_convenio_2_disponibles").html(total_grupos_disponibles['convenio_2']);
            }
        }).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido cargar los datos de los grupos planeados." + data);
			console.log(data)
		});;
    }

    function isInt(value) {
    return !isNaN(value) && 
            parseInt(Number(value)) == value && 
            !isNaN(parseInt(value, 10));
    }
});