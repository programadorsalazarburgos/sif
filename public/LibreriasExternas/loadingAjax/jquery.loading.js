/*!
 * Loading v1.0
 * Copyright Grafikdev
 * Distributed under the MIT license
 */
 function loadFuncion() {
    var loading = $("<div>").attr("id","full-loading");
    var wrapper = $("<div>").addClass("wrapper").appendTo(loading);
    var inner = $("<div>").addClass("inner").appendTo(wrapper);
    /*$("<span>").text("C").appendTo(inner);
    $("<span>").text("a").appendTo(inner);
    $("<span>").text("r").appendTo(inner);
    $("<span>").text("g").appendTo(inner);
    $("<span>").text("a").appendTo(inner);
    $("<span>").text("n").appendTo(inner);
    $("<span>").text("d").appendTo(inner);
    $("<span>").text("o a").appendTo(inner);
    $("<span>").text("n").appendTo(inner);
    $("<span>").text("d").appendTo(inner);
    $("<span>").text("o").appendTo(inner);*/
    $(loading).appendTo("body");
    $("#full-loading").hide();
    $(document).on({
        ajaxStart: function() {
            $("#full-loading").show();
            setTimeout(function(){  $("#full-loading").show(); }, 500);
            
        },
        ajaxStop: function() {           
           setTimeout(function(){  $("#full-loading").hide(); }, 500);
        }
    });

}