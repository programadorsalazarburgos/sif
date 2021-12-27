$(window).load(function(){ 
	$("#precarga").hide();
	$("#div_body").show();
});

function abrirmodal(boton){
	$("#modal_beneficiarios_historial").modal('show');
	$('body').css('height', '100');
	var id = boton;
	$("#id_celda_sumatoria_historial").val(id);
	var input_sumatoria = id.split("_");
	var id_input_beneficiarios = "beneficiarios_"+input_sumatoria[1];
	var beneficiarios = $("#"+id_input_beneficiarios).val();
	
	if(beneficiarios != "")
	{
		var vector_beneficiarios = beneficiarios.split(",");
		$("#BH_Mujeres").val(vector_beneficiarios[0]);
		$("#BH_Hombres").val(vector_beneficiarios[1]);
		$("#BH_P_Infancia").val(vector_beneficiarios[2]);
		$("#BH_Infancia").val(vector_beneficiarios[3]);
		$("#BH_Adolescencia").val(vector_beneficiarios[4]);
		$("#BH_Juventud").val(vector_beneficiarios[5]);
		$("#BH_Adulto").val(vector_beneficiarios[6]);
		$("#BH_Adulto_Mayor").val(vector_beneficiarios[7]);
		$("#BH_Campesinos").val(vector_beneficiarios[8]);
		$("#BH_Artesanos").val(vector_beneficiarios[9]);
		$("#BH_Discapacidad").val(vector_beneficiarios[10]);
		$("#BH_LGBTI").val(vector_beneficiarios[11]);
		$("#BH_Reinsertados").val(vector_beneficiarios[12]);
		$("#BH_Victimas").val(vector_beneficiarios[13]);
		$("#BH_Dezplazamiento").val(vector_beneficiarios[14]);
		$("#BH_Habitantes_Calle").val(vector_beneficiarios[15]);
		$("#BH_Medios_Comunitarios").val(vector_beneficiarios[16]);
		$("#BH_Pueblo_Raizal").val(vector_beneficiarios[17]);
		$("#BH_Afrodescendientes").val(vector_beneficiarios[18]);
		$("#BH_Pueblo_Gitano").val(vector_beneficiarios[19]);
		$("#BH_Indigenas").val(vector_beneficiarios[20]);
		$("#BH_Otras_Etnias").val(vector_beneficiarios[21]);
		$("#BH_Estrato_Uno").val(vector_beneficiarios[22]);
		$("#BH_Estrato_Dos").val(vector_beneficiarios[23]);
		$("#BH_Estrato_Tres").val(vector_beneficiarios[24]);
		$("#BH_Estrato_Cuatro").val(vector_beneficiarios[25]);
		$("#BH_Estrato_Cinco").val(vector_beneficiarios[26]);
		$("#BH_Estrato_Seis").val(vector_beneficiarios[27]);
	}
}
function escribir_beneficiarios(beneficiarios, sumatoria){
	var id = $("#id_celda_sumatoria_historial").val();
	$("#"+id).val(sumatoria);
	$("#"+id).prop('readonly', true);

	var input_sumatoria = id.split("_");
	var id_input_beneficiarios = "beneficiarios_"+input_sumatoria[1];
	$('input[name="'+id_input_beneficiarios+'"]').val(beneficiarios);
}
function escribir_beneficiarios_proyecto(beneficiarios_proyecto){
	var vector_beneficiarios_proyecto = beneficiarios_proyecto.split(",");
	var sumatoria_beneficiarios_proyecto = 0;
	for(i=0;i<vector_beneficiarios_proyecto.length;i++){
		sumatoria_beneficiarios_proyecto = parseInt(vector_beneficiarios_proyecto[i])+sumatoria_beneficiarios_proyecto;
	}
	$("#poblacion_objetivo").val(sumatoria_beneficiarios_proyecto);
	$("#poblacion_objetivo").show();
	//alert($("#poblacion_objetivo").val());
}

$(document).ready(function(){ 
	var Id_Usuario = "";
	var Nombre_Usuario = "";
	$('#modal_beneficiarios_historial').on('hidden.bs.modal', function (e) {
  		$(this).find("input").val('0').end();
	});
 	$('.datetime_class').datepicker();

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
                });
            	}	
        });


var beneficiarios_proyecto = "";
var cantidad_beneficiados = "";
$("#modal_beneficiarios_historial").find("#capturar_beneficiarios").on('click', function(){
		var B_Mujeres = $("#modal_beneficiarios_historial #BH_Mujeres").val(); if (B_Mujeres == "") { B_Mujeres="0"};
		var B_Hombres = $("#modal_beneficiarios_historial #BH_Hombres").val(); if (B_Hombres == "") { B_Hombres="0"};
		var B_P_Infancia = $("#modal_beneficiarios_historial #BH_P_Infancia").val(); if (B_P_Infancia == "") { B_P_Infancia="0"};
		var B_Infancia = $("#modal_beneficiarios_historial #BH_Infancia").val(); if (B_Infancia == "") { B_Infancia="0"};
		var B_Adolescencia = $("#modal_beneficiarios_historial #BH_Adolescencia").val(); if (B_Adolescencia == "") { B_Adolescencia="0"};
		var B_Juventud = $("#modal_beneficiarios_historial #BH_Juventud").val(); if (B_Juventud == "") { B_Juventud="0"};
		var B_Adulto = $("#modal_beneficiarios_historial #BH_Adulto").val(); if (B_Adulto == "") { B_Adulto="0"};
		var B_Adulto_Mayor = $("#modal_beneficiarios_historial #BH_Adulto_Mayor").val(); if (B_Adulto_Mayor == "") { B_Adulto_Mayor="0"};
		var B_Campesinos = $("#modal_beneficiarios_historial #BH_Campesinos").val(); if (B_Campesinos == "") { B_Campesinos="0"};
		var B_Artesanos = $("#modal_beneficiarios_historial #BH_Artesanos").val(); if (B_Artesanos == "") { B_Artesanos="0"};
		var B_Discapacidad = $("#modal_beneficiarios_historial #BH_Discapacidad").val(); if (B_Discapacidad == "") { B_Discapacidad="0"};
		var B_LGBTI = $("#modal_beneficiarios_historial #BH_LGBTI").val(); if (B_LGBTI == "") { B_LGBTI="0"};
		var B_Reinsertados = $("#modal_beneficiarios_historial #BH_Reinsertados").val(); if (B_Reinsertados == "") { B_Reinsertados="0"};
		var B_Victimas = $("#modal_beneficiarios_historial #BH_Victimas").val(); if (B_Victimas == "") { B_Victimas="0"};
		var B_Dezplazamiento = $("#modal_beneficiarios_historial #BH_Dezplazamiento").val(); if (B_Dezplazamiento == "") { B_Dezplazamiento="0"};
		var B_Habitantes_Calle = $("#modal_beneficiarios_historial #BH_Habitantes_Calle").val(); if (B_Habitantes_Calle == "") { B_Habitantes_Calle="0"};
		var B_Medios_Comunitarios = $("#modal_beneficiarios_historial #BH_Medios_Comunitarios").val(); if (B_Medios_Comunitarios == "") { B_Medios_Comunitarios="0"};
		var B_Pueblo_Raizal = $("#modal_beneficiarios_historial #BH_Pueblo_Raizal").val(); if (B_Pueblo_Raizal == "") { B_Pueblo_Raizal="0"};
		var B_Afrodescendientes = $("#modal_beneficiarios_historial #BH_Afrodescendientes").val(); if (B_Afrodescendientes == "") { B_Afrodescendientes="0"};
		var B_Pueblo_Gitano = $("#modal_beneficiarios_historial #BH_Pueblo_Gitano").val(); if (B_Pueblo_Gitano == "") { B_Pueblo_Gitano="0"};
		var B_Indigenas = $("#modal_beneficiarios_historial #BH_Indigenas").val(); if (B_Indigenas == "") { B_Indigenas="0"};
		var B_Otras_Etnias = $("#modal_beneficiarios_historial #BH_Otras_Etnias").val(); if (B_Otras_Etnias == "") { B_Otras_Etnias="0"};
		var B_Estrato_Uno = $("#modal_beneficiarios_historial #BH_Estrato_Uno").val(); if (B_Estrato_Uno == "") { B_Estrato_Uno="0"};
		var B_Estrato_Dos = $("#modal_beneficiarios_historial #BH_Estrato_Dos").val(); if (B_Estrato_Dos == "") { B_Estrato_Dos="0"};
		var B_Estrato_Tres = $("#modal_beneficiarios_historial #BH_Estrato_Tres").val(); if (B_Estrato_Tres == "") { B_Estrato_Tres="0"};
		var B_Estrato_Cuatro = $("#modal_beneficiarios_historial #BH_Estrato_Cuatro").val(); if (B_Estrato_Cuatro == "") { B_Estrato_Cuatro="0"};
		var B_Estrato_Cinco = $("#modal_beneficiarios_historial #BH_Estrato_Cinco").val(); if (B_Estrato_Cinco == "") { B_Estrato_Cinco="0"};
		var B_Estrato_Seis = $("#modal_beneficiarios_historial #BH_Estrato_Seis").val(); if (B_Estrato_Seis == "") { B_Estrato_Seis="0"};
		var beneficiarios = B_Mujeres+","+B_Hombres+","+B_P_Infancia+","+B_Infancia+","+B_Adolescencia+","+B_Juventud+","+B_Adulto+","+B_Adulto_Mayor+","+B_Campesinos+","+B_Artesanos+","+B_Discapacidad+","+B_LGBTI+","+B_Reinsertados+","+B_Victimas+","+B_Dezplazamiento+","+B_Habitantes_Calle+","+B_Medios_Comunitarios+","+B_Pueblo_Raizal+","+B_Afrodescendientes+","+B_Pueblo_Gitano+","+B_Indigenas+","+B_Otras_Etnias+","+B_Estrato_Uno+","+B_Estrato_Dos+","+B_Estrato_Tres+","+B_Estrato_Cuatro+","+B_Estrato_Cinco+","+B_Estrato_Seis;
        var sumatoria_beneficiarios = parseInt(B_Mujeres)+parseInt(B_Hombres)+parseInt(B_P_Infancia)+parseInt(B_Infancia)+parseInt(B_Adolescencia)+parseInt(B_Juventud)+parseInt(B_Adulto)+parseInt(B_Adulto_Mayor)+parseInt(B_Campesinos)+parseInt(B_Artesanos)+parseInt(B_Discapacidad)+parseInt(B_LGBTI)+parseInt(B_Reinsertados)+parseInt(B_Victimas)+parseInt(B_Dezplazamiento)+parseInt(B_Habitantes_Calle)+parseInt(B_Medios_Comunitarios)+parseInt(B_Pueblo_Raizal)+parseInt(B_Afrodescendientes)+parseInt(B_Pueblo_Gitano)+parseInt(B_Indigenas)+parseInt(B_Otras_Etnias)+parseInt(B_Estrato_Uno)+parseInt(B_Estrato_Dos)+parseInt(B_Estrato_Tres)+parseInt(B_Estrato_Cuatro)+parseInt(B_Estrato_Cinco)+parseInt(B_Estrato_Seis);
		escribir_beneficiarios(beneficiarios, sumatoria_beneficiarios);
		$("#modal_beneficiarios_historial").modal('hide');
});

$("#modal_beneficiarios_proyecto").find("#capturar_beneficiarios_proyecto").on('click', function(){
		var Proyecto_B_Mujeres = $("#modal_beneficiarios_proyecto #B_Mujeres").val(); if (Proyecto_B_Mujeres == "") { Proyecto_B_Mujeres="0"};
		var Proyecto_B_Hombres = $("#modal_beneficiarios_proyecto #B_Hombres").val(); if (Proyecto_B_Hombres == "") { Proyecto_B_Hombres="0"};
		var Proyecto_B_P_Infancia = $("#modal_beneficiarios_proyecto #B_P_Infancia").val(); if (Proyecto_B_P_Infancia == "") { Proyecto_B_P_Infancia="0"};
		var Proyecto_B_Infancia = $("#modal_beneficiarios_proyecto #B_Infancia").val(); if (Proyecto_B_Infancia == "") { Proyecto_B_Infancia="0"};
		var Proyecto_B_Adolescencia = $("#modal_beneficiarios_proyecto #B_Adolescencia").val(); if (Proyecto_B_Adolescencia == "") { Proyecto_B_Adolescencia="0"};
		var Proyecto_B_Juventud = $("#modal_beneficiarios_proyecto #B_Juventud").val(); if (Proyecto_B_Juventud == "") { Proyecto_B_Juventud="0"};
		var Proyecto_B_Adulto = $("#modal_beneficiarios_proyecto #B_Adulto").val(); if (Proyecto_B_Adulto == "") { Proyecto_B_Adulto="0"};
		var Proyecto_B_Adulto_Mayor = $("#modal_beneficiarios_proyecto #B_Adulto_Mayor").val(); if (Proyecto_B_Adulto_Mayor == "") { Proyecto_B_Adulto_Mayor="0"};
		var Proyecto_B_Campesinos = $("#modal_beneficiarios_proyecto #B_Campesinos").val(); if (Proyecto_B_Campesinos == "") { Proyecto_B_Campesinos="0"};
		var Proyecto_B_Artesanos = $("#modal_beneficiarios_proyecto #B_Artesanos").val(); if (Proyecto_B_Artesanos == "") { Proyecto_B_Artesanos="0"};
		var Proyecto_B_Discapacidad = $("#modal_beneficiarios_proyecto #B_Discapacidad").val(); if (Proyecto_B_Discapacidad == "") { Proyecto_B_Discapacidad="0"};
		var Proyecto_B_LGBTI = $("#modal_beneficiarios_proyecto #B_LGBTI").val(); if (Proyecto_B_LGBTI == "") { Proyecto_B_LGBTI="0"};
		var Proyecto_B_Reinsertados = $("#modal_beneficiarios_proyecto #B_Reinsertados").val(); if (Proyecto_B_Reinsertados == "") { Proyecto_B_Reinsertados="0"};
		var Proyecto_B_Victimas = $("#modal_beneficiarios_proyecto #B_Victimas").val(); if (Proyecto_B_Victimas == "") { Proyecto_B_Victimas="0"};
		var Proyecto_B_Dezplazamiento = $("#modal_beneficiarios_proyecto #B_Dezplazamiento").val(); if (Proyecto_B_Dezplazamiento == "") { Proyecto_B_Dezplazamiento="0"};
		var Proyecto_B_Habitantes_Calle = $("#modal_beneficiarios_proyecto #B_Habitantes_Calle").val(); if (Proyecto_B_Habitantes_Calle == "") { Proyecto_B_Habitantes_Calle="0"};
		var Proyecto_B_Medios_Comunitarios = $("#modal_beneficiarios_proyecto #B_Medios_Comunitarios").val(); if (Proyecto_B_Medios_Comunitarios == "") { Proyecto_B_Medios_Comunitarios="0"};
		var Proyecto_B_Pueblo_Raizal = $("#modal_beneficiarios_proyecto #B_Pueblo_Raizal").val(); if (Proyecto_B_Pueblo_Raizal == "") { Proyecto_B_Pueblo_Raizal="0"};
		var Proyecto_B_Afrodescendientes = $("#modal_beneficiarios_proyecto #B_Afrodescendientes").val(); if (Proyecto_B_Afrodescendientes == "") { Proyecto_B_Afrodescendientes="0"};
		var Proyecto_B_Pueblo_Gitano = $("#modal_beneficiarios_proyecto #B_Pueblo_Gitano").val(); if (Proyecto_B_Pueblo_Gitano == "") { Proyecto_B_Pueblo_Gitano="0"};
		var Proyecto_B_Indigenas = $("#modal_beneficiarios_proyecto #B_Indigenas").val(); if (Proyecto_B_Indigenas == "") { Proyecto_B_Indigenas="0"};
		var Proyecto_B_Otras_Etnias = $("#modal_beneficiarios_proyecto #B_Otras_Etnias").val(); if (Proyecto_B_Otras_Etnias == "") { Proyecto_B_Otras_Etnias="0"};
		var Proyecto_B_Estrato_Uno = $("#modal_beneficiarios_proyecto #B_Estrato_Uno").val(); if (Proyecto_B_Estrato_Uno == "") { Proyecto_B_Estrato_Uno="0"};
		var Proyecto_B_Estrato_Dos = $("#modal_beneficiarios_proyecto #B_Estrato_Dos").val(); if (Proyecto_B_Estrato_Dos == "") { Proyecto_B_Estrato_Dos="0"};
		var Proyecto_B_Estrato_Tres = $("#modal_beneficiarios_proyecto #B_Estrato_Tres").val(); if (Proyecto_B_Estrato_Tres == "") { Proyecto_B_Estrato_Tres="0"};
		var Proyecto_B_Estrato_Cuatro = $("#modal_beneficiarios_proyecto #B_Estrato_Cuatro").val(); if (Proyecto_B_Estrato_Cuatro == "") { Proyecto_B_Estrato_Cuatro="0"};
		var Proyecto_B_Estrato_Cinco = $("#modal_beneficiarios_proyecto #B_Estrato_Cinco").val(); if (Proyecto_B_Estrato_Cinco == "") { Proyecto_B_Estrato_Cinco="0"};
		var Proyecto_B_Estrato_Seis = $("#modal_beneficiarios_proyecto #B_Estrato_Seis").val(); if (Proyecto_B_Estrato_Seis == "") { Proyecto_B_Estrato_Seis="0"};

		var Proyecto_B_Local = $("#modal_beneficiarios_proyecto #B_Local").val(); if (Proyecto_B_Local == "") { Proyecto_B_Local="0"};
		var Proyecto_B_InterLocal = $("#modal_beneficiarios_proyecto #B_InterLocal").val(); if (Proyecto_B_InterLocal == "") { Proyecto_B_InterLocal="0"};
		var Proyecto_B_Metropolitano = $("#modal_beneficiarios_proyecto #B_Metropolitano").val(); if (Proyecto_B_Metropolitano == "") { Proyecto_B_Metropolitano="0"};

		var Proyecto_B_Localidad_Usaquen = $("#modal_beneficiarios_proyecto #B_Localidad_Usaquen").val(); if (Proyecto_B_Localidad_Usaquen == "") { Proyecto_B_Localidad_Usaquen="0"};
		var Proyecto_B_Localidad_Chapinero = $("#modal_beneficiarios_proyecto #B_Localidad_Chapinero").val(); if (Proyecto_B_Localidad_Chapinero == "") { Proyecto_B_Localidad_Chapinero="0"};
		var Proyecto_B_Localidad_Santafe = $("#modal_beneficiarios_proyecto #B_Localidad_Santafe").val(); if (Proyecto_B_Localidad_Santafe == "") { Proyecto_B_Localidad_Santafe="0"};
		var Proyecto_B_Localidad_SanCristobal = $("#modal_beneficiarios_proyecto #B_Localidad_SanCristobal").val(); if (Proyecto_B_Localidad_SanCristobal == "") { Proyecto_B_Localidad_SanCristobal="0"};
		var Proyecto_B_Localidad_Usme = $("#modal_beneficiarios_proyecto #B_Localidad_Usme").val(); if (Proyecto_B_Localidad_Usme == "") { Proyecto_B_Localidad_Usme="0"};
		var Proyecto_B_Localidad_Tunjuelito = $("#modal_beneficiarios_proyecto #B_Localidad_Tunjuelito").val(); if (Proyecto_B_Localidad_Tunjuelito == "") { Proyecto_B_Localidad_Tunjuelito="0"};
		var Proyecto_B_Localidad_Bosa = $("#modal_beneficiarios_proyecto #B_Localidad_Bosa").val(); if (Proyecto_B_Localidad_Bosa == "") { Proyecto_B_Localidad_Bosa="0"};
		var Proyecto_B_Localidad_Kenndy = $("#modal_beneficiarios_proyecto #B_Localidad_Kenndy").val(); if (Proyecto_B_Localidad_Kenndy == "") { Proyecto_B_Localidad_Kenndy="0"};
		var Proyecto_B_Localidad_Fontibon = $("#modal_beneficiarios_proyecto #B_Localidad_Fontibon").val(); if (Proyecto_B_Localidad_Fontibon == "") { Proyecto_B_Localidad_Fontibon="0"};
		var Proyecto_B_Localidad_Engativa = $("#modal_beneficiarios_proyecto #B_Localidad_Engativa").val(); if (Proyecto_B_Localidad_Engativa == "") { Proyecto_B_Localidad_Engativa="0"};
		var Proyecto_B_Localidad_Suba = $("#modal_beneficiarios_proyecto #B_Localidad_Suba").val(); if (Proyecto_B_Localidad_Suba == "") { Proyecto_B_Localidad_Suba="0"};
		var Proyecto_B_Localidad_BarriosUnidos = $("#modal_beneficiarios_proyecto #B_Localidad_BarriosUnidos").val(); if (Proyecto_B_Localidad_BarriosUnidos == "") { Proyecto_B_Localidad_BarriosUnidos="0"};
		var Proyecto_B_Localidad_Teusaquillo = $("#modal_beneficiarios_proyecto #B_Localidad_Teusaquillo").val(); if (Proyecto_B_Localidad_Teusaquillo == "") { Proyecto_B_Localidad_Teusaquillo="0"};
		var Proyecto_B_Localidad_Martires = $("#modal_beneficiarios_proyecto #B_Localidad_Martires").val(); if (Proyecto_B_Localidad_Martires == "") { Proyecto_B_Localidad_Martires="0"};
		var Proyecto_B_Localidad_AntonioNariño = $("#modal_beneficiarios_proyecto #B_Localidad_AntonioNariño").val(); if (Proyecto_B_Localidad_AntonioNariño == "") { Proyecto_B_Localidad_AntonioNariño="0"};
		var Proyecto_B_Localidad_PuenteAranda = $("#modal_beneficiarios_proyecto #B_Localidad_PuenteAranda").val(); if (Proyecto_B_Localidad_PuenteAranda == "") { Proyecto_B_Localidad_PuenteAranda="0"};
		var Proyecto_B_Localidad_Candelaria = $("#modal_beneficiarios_proyecto #B_Localidad_Candelaria").val(); if (Proyecto_B_Localidad_Candelaria == "") { Proyecto_B_Localidad_Candelaria="0"};
		var Proyecto_B_Localidad_RafaelUribe = $("#modal_beneficiarios_proyecto #B_Localidad_RafaelUribe").val(); if (Proyecto_B_Localidad_RafaelUribe == "") { Proyecto_B_Localidad_RafaelUribe="0"};
		var Proyecto_B_Localidad_CiudadBolivar = $("#modal_beneficiarios_proyecto #B_Localidad_CiudadBolivar").val(); if (Proyecto_B_Localidad_CiudadBolivar == "") { Proyecto_B_Localidad_CiudadBolivar="0"};
		var Proyecto_B_Localidad_Sumapaz = $("#modal_beneficiarios_proyecto #B_Localidad_Sumapaz").val(); if (Proyecto_B_Localidad_Sumapaz == "") { Proyecto_B_Localidad_Sumapaz="0"};
		cantidad_beneficiados = parseInt(Proyecto_B_Mujeres)+parseInt(Proyecto_B_Hombres)+parseInt(Proyecto_B_P_Infancia)+parseInt(Proyecto_B_Infancia)+parseInt(Proyecto_B_Adolescencia)+parseInt(Proyecto_B_Juventud)+parseInt(Proyecto_B_Adulto)+parseInt(Proyecto_B_Adulto_Mayor)+parseInt(Proyecto_B_Campesinos)+parseInt(Proyecto_B_Artesanos)+parseInt(Proyecto_B_Discapacidad)+parseInt(Proyecto_B_LGBTI)+parseInt(Proyecto_B_Reinsertados)+parseInt(Proyecto_B_Victimas)+parseInt(Proyecto_B_Dezplazamiento)+parseInt(Proyecto_B_Habitantes_Calle)+parseInt(Proyecto_B_Medios_Comunitarios)+parseInt(Proyecto_B_Pueblo_Raizal)+parseInt(Proyecto_B_Afrodescendientes)+parseInt(Proyecto_B_Pueblo_Gitano)+parseInt(Proyecto_B_Indigenas)+parseInt(Proyecto_B_Otras_Etnias)+parseInt(Proyecto_B_Estrato_Uno)+parseInt(Proyecto_B_Estrato_Dos)+parseInt(Proyecto_B_Estrato_Tres)+parseInt(Proyecto_B_Estrato_Cuatro)+parseInt(Proyecto_B_Estrato_Cinco)+parseInt(Proyecto_B_Estrato_Seis)+parseInt(Proyecto_B_Local)+parseInt(Proyecto_B_InterLocal)+parseInt(Proyecto_B_Metropolitano)+parseInt(Proyecto_B_Localidad_Usaquen)+parseInt(Proyecto_B_Localidad_Chapinero)+parseInt(Proyecto_B_Localidad_Santafe)+parseInt(Proyecto_B_Localidad_SanCristobal)+parseInt(Proyecto_B_Localidad_Usme)+parseInt(Proyecto_B_Localidad_Tunjuelito)+parseInt(Proyecto_B_Localidad_Bosa)+parseInt(Proyecto_B_Localidad_Kenndy)+parseInt(Proyecto_B_Localidad_Fontibon)+parseInt(Proyecto_B_Localidad_Engativa)+parseInt(Proyecto_B_Localidad_Suba)+parseInt(Proyecto_B_Localidad_BarriosUnidos)+parseInt(Proyecto_B_Localidad_Teusaquillo)+parseInt(Proyecto_B_Localidad_Martires)+parseInt(Proyecto_B_Localidad_AntonioNariño)+parseInt(Proyecto_B_Localidad_PuenteAranda)+parseInt(Proyecto_B_Localidad_Candelaria)+parseInt(Proyecto_B_Localidad_RafaelUribe)+parseInt(Proyecto_B_Localidad_CiudadBolivar)+parseInt(Proyecto_B_Localidad_Sumapaz);
		beneficiarios_proyecto = Proyecto_B_Mujeres+","+Proyecto_B_Hombres+","+Proyecto_B_P_Infancia+","+Proyecto_B_Infancia+","+Proyecto_B_Adolescencia+","+Proyecto_B_Juventud+","+Proyecto_B_Adulto+","+Proyecto_B_Adulto_Mayor+","+Proyecto_B_Campesinos+","+Proyecto_B_Artesanos+","+Proyecto_B_Discapacidad+","+Proyecto_B_LGBTI+","+Proyecto_B_Reinsertados+","+Proyecto_B_Victimas+","+Proyecto_B_Dezplazamiento+","+Proyecto_B_Habitantes_Calle+","+Proyecto_B_Medios_Comunitarios+","+Proyecto_B_Pueblo_Raizal+","+Proyecto_B_Afrodescendientes+","+Proyecto_B_Pueblo_Gitano+","+Proyecto_B_Indigenas+","+Proyecto_B_Otras_Etnias+","+Proyecto_B_Estrato_Uno+","+Proyecto_B_Estrato_Dos+","+Proyecto_B_Estrato_Tres+","+Proyecto_B_Estrato_Cuatro+","+Proyecto_B_Estrato_Cinco+","+Proyecto_B_Estrato_Seis+","+Proyecto_B_Local+","+Proyecto_B_InterLocal+","+Proyecto_B_Metropolitano+","+Proyecto_B_Localidad_Usaquen+","+Proyecto_B_Localidad_Chapinero+","+Proyecto_B_Localidad_Santafe+","+Proyecto_B_Localidad_SanCristobal+","+Proyecto_B_Localidad_Usme+","+Proyecto_B_Localidad_Tunjuelito+","+Proyecto_B_Localidad_Bosa+","+Proyecto_B_Localidad_Kenndy+","+Proyecto_B_Localidad_Fontibon+","+Proyecto_B_Localidad_Engativa+","+Proyecto_B_Localidad_Suba+","+Proyecto_B_Localidad_BarriosUnidos+","+Proyecto_B_Localidad_Teusaquillo+","+Proyecto_B_Localidad_Martires+","+Proyecto_B_Localidad_AntonioNariño+","+Proyecto_B_Localidad_PuenteAranda+","+Proyecto_B_Localidad_Candelaria+","+Proyecto_B_Localidad_RafaelUribe+","+Proyecto_B_Localidad_CiudadBolivar+","+Proyecto_B_Localidad_Sumapaz;
		escribir_beneficiarios_proyecto(beneficiarios_proyecto);
		$("#modal_beneficiarios_proyecto").modal('hide');
});

	var mes=new Array();
	mes[0]="01";
	mes[1]="02";
	mes[2]="03";
	mes[3]="04";
	mes[4]="05";
	mes[5]="06";
	mes[6]="07";
	mes[7]="08";
	mes[8]="09";
	mes[9]="10";
	mes[10]="11";
	mes[11]="12";
	
	var d = new Date();
	
	document.getElementById("fecha").innerHTML = d.getDate()+"/"+mes[d.getMonth()]+"/"+d.getFullYear();
	var fecha = d.getFullYear()+"/"+mes[d.getMonth()]+"/"+d.getDate();
	
	$(":file").filestyle({buttonName: "btn-primary"});

	$("#ver_ejemplo_equipo").on('click', function(){
		$("#modal_ejemplo_equipo").modal('show');
	});
	$("#ver_ejemplo_indicador").on('click', function(){
		$("#modal_ejemplo_indicadores").modal('show');
	});
	$("#ver_ejemplo_metas").on('click', function(){
		$("#modal_ejemplo_metas").modal('show');
	});
	$("#ver_ejemplo_cronograma").on('click', function(){
		//$("#modal_ejemplo_cronograma").modal('show');
	});
	$("#ver_ejemplo_presupuesto").on('click', function(){
		//$("#modal_ejemplo_presupuesto").modal('show');
	});
	$("#definir_poblacion_objetivo").on('click', function(){
		$("#modal_beneficiarios_proyecto").modal('show');
	});

	var contador = 2;
	$("#crear_fila").on('click', function(){
		var newtr = document.createElement('tr');
	    newtr.id = "tr"+contador;
	    newtr.innerHTML = "<td style='padding:3px'><input id='entidad_"+contador+"' name='entidad_"+contador+"' type='text' class='form-control' maxlength='50' required></td>"+"<td style='padding:3px'><input id='proyecto_"+contador+"' name='proyecto_"+contador+"' type='text' class='form-control' maxlength='100'></td>"+"<td style='padding:3px; color:#000;'><input id='antecedente_inicio_"+contador+"' name='antecedente_inicio_"+contador+"' type='text' class='form-control datetime_class' maxlength='10' required readonly></td>"+"<td style='padding:3px; color:#000;'><input id='antecedente_fin_"+contador+"' name='antecedente_fin_"+contador+"' type='text' class='form-control datetime_class' maxlength='10' required readonly></td>"+"<td style='padding:3px'><input id='actividad_"+contador+"' name='actividad_"+contador+"' type='text' class='form-control' maxlength='500' required></td>"+"<td style='padding:3px'><input id='sumatoria_"+contador+"' name='sumatoria_"+contador+"' type='text' value='0' class='form-control' onclick='abrirmodal(this.id)' maxlength='200' readonly required></td><input type='text' id='beneficiarios_"+contador+"' name='beneficiarios_"+contador+"' class='form-control hidden'>";
	    document.getElementById('contenedor').appendChild(newtr);
		$('.datetime_class').datepicker();
	    contador++;
	});
	$("#eliminar_fila").on('click', function(){
		if (contador>2) {
			contador--;
			$('#tr'+contador).remove();
		};
	});

	var contador_objetivos = 2;
	$("#crear_fila_objetivo").on('click', function(){
		var newtr = document.createElement('tr');
	    newtr.id = "tr_objetivo"+contador_objetivos;
	    newtr.innerHTML = "<td style='padding:3px'><input id='objetivo_"+contador_objetivos+"' name='objetivo_"+contador_objetivos+"' type='text' class='form-control' maxlength='200' required></td>"+"<td style='padding:3px'><input id='actividad_obj_"+contador_objetivos+"' name='actividad_obj_"+contador_objetivos+"' type='text' class='form-control' maxlength='1000' required></td>";
	    document.getElementById('contenedor_objetivos').appendChild(newtr);
	    contador_objetivos++;
	});
	$("#eliminar_fila_objetivo").on('click', function(){
		if (contador_objetivos>2) {
			contador_objetivos--;
			$('#tr_objetivo'+contador_objetivos).remove();
		};
	});

	var contador_metas = 2;
	$("#crear_fila_meta").on('click', function(){
		var newtr = document.createElement('tr');
	    newtr.id = "tr_meta"+contador_metas;
	    newtr.innerHTML = "<td style='padding:3px'><input id='proceso_"+contador_metas+"' name='proceso_"+contador_metas+"' type='text' class='form-control' maxlength='50' required></td>"+"<td style='padding:3px'><input id='magnitud_"+contador_metas+"' name='magnitud_"+contador_metas+"' type='number' min='0' class='form-control' maxlength='10' required></td>"+"<td style='padding:3px'><input id='unidad_"+contador_metas+"' name='unidad_"+contador_metas+"' type='text' class='form-control' maxlength='50' required></td>"+"<td style='padding:3px'><input id='descripcion_"+contador_metas+"' name='descripcion_"+contador_metas+"' type='text' class='form-control' maxlength='100' required></td>"+"<td style='padding:3px'><input id='periodo_"+contador_metas+"' name='periodo_"+contador_metas+"' type='text' class='form-control' placeholder='Ej: A diciembre de 2015' maxlength='50' required></td>";
	    document.getElementById('contenedor_metas').appendChild(newtr);
	    contador_metas++;
	});
	$("#eliminar_fila_meta").on('click', function(){
		if (contador_metas>2) {
			contador_metas--;
			$('#tr_meta'+contador_metas).remove();
		};
	});

	var contador_indicadores = 2;
	$("#crear_fila_indicador").on('click', function(){
		var newtr = document.createElement('tr');
	    newtr.id = "tr_indicador"+contador_indicadores;
	    newtr.innerHTML = "<td style='padding:3px'><input id='nombreindicador_"+contador_indicadores+"' name='nombreindicador_"+contador_indicadores+"' type='text' class='form-control' maxlength='100' required></td>"+"<td style='padding:3px'><input id='formula_"+contador_indicadores+"' name='formula_"+contador_indicadores+"' type='text' class='form-control' maxlength='100' required></td>"+"<td style='padding:3px'><input id='estadoinicial_"+contador_indicadores+"' name='estadoinicial_"+contador_indicadores+"' type='text' class='form-control' maxlength='10' required></td>"+"<td style='padding:3px'><input id='valoresperado_"+contador_indicadores+"' name='valoresperado_"+contador_indicadores+"' type='text' class='form-control' maxlength='10' required></td>"+"<td style='padding:3px'><input id='periodoindicador_"+contador_indicadores+"' name='periodoindicador_"+contador_indicadores+"' type='text' class='form-control' placeholder='Ej: A mayo de 2015 (3 meses)' maxlength='50' required></td>";
	    document.getElementById('contenedor_indicadores').appendChild(newtr);
	    contador_indicadores++;
	});
	$("#eliminar_fila_indicador").on('click', function(){
		if (contador_indicadores>2) {
			contador_indicadores--;
			$('#tr_indicador'+contador_indicadores).remove();
		};
	});

	var contador_equipo = 2;
	$("#crear_fila_persona").on('click', function(){
		var newtr = document.createElement('tr');
	    newtr.id = "tr_persona"+contador_equipo;
	    newtr.innerHTML = "<td style='padding:3px'><input id='nombrepersona_"+contador_equipo+"' name='nombrepersona_"+contador_equipo+"' type='text' class='form-control' maxlength='50' required></td>"+"<td style='padding:3px'><textarea id='perfilpersona_"+contador_equipo+"' name='perfilpersona_"+contador_equipo+"' type='text' class='form-control' rows='4' maxlength='1000' required></textarea></td>"+"<td style='padding:3px'><input id='rolpersona_"+contador_equipo+"' name='rolpersona_"+contador_equipo+"' type='text' class='form-control' maxlength='50' required></td>"+"<td style='padding:3px'><textarea id='actividadespersona_"+contador_equipo+"' name='actividadespersona_"+contador_equipo+"' type='text' class='form-control' rows='4' maxlength='1000' required></textarea></td>";
	    document.getElementById('contenedor_equipo').appendChild(newtr);
	    contador_equipo++;
	});
	$("#eliminar_fila_persona").on('click', function(){
		if (contador_equipo>2) {
			contador_equipo--;
			$('#tr_persona'+contador_equipo).remove();
		};
	});

	var contador_anexos = 8;
	$("#agregar_input_archivo").on('click', function(){
		var newtr = document.createElement('div');
	    newtr.id = "div_archivo"+contador_anexos;

	    newtr.innerHTML = "<input id='archivo_"+contador_anexos+"' name='file[]' type='file' class='filestyle' data-buttonname='btn-primary' runat='server' required='' tabindex='-1' style='position: absolute; clip: rect(0px 0px 0px 0px);'><div class='bootstrap-filestyle input-group'><input type='text' class='form-control' placeholder='' disabled=''> <span class='group-span-filestyle input-group-btn' tabindex='0'><label for='archivo_"+contador_anexos+"' class='btn btn-primary'><span class='icon-span-filestyle glyphicon glyphicon-folder-open'></span> <span class='buttonText'>Seleccionar Archivo</span></label></span></div>";
	    document.getElementById('contenedor_anexos').appendChild(newtr);
	    contador_anexos++;
	});
	$("#eliminar_input_archivo").on('click', function(){
		if (contador_anexos>2) {
			contador_anexos--;
			$('#div_archivo'+contador_anexos).remove();
		};
	});
	
	$("#modal_beneficiarios_historial").on("show.bs.modal", function () {
	  var top = $("body").scrollTop(); $("body").css('position','fixed').css('overflow','hidden').css('top',-top).css('width','100%').css('height',top+5000);
	}).on("hide.bs.modal", function () {
	  var top = $("body").position().top; $("body").css('position','relative').css('overflow','auto').css('top',0).scrollTop(-top);
	});
	
	var files;
	// Add events
	$('input[type=file]').on('change', prepareUpload);
	
	var nombre_empresa ="";

	$('#FORM_PROPUESTA').on('submit', function(e){
		e.preventDefault();
		if(beneficiarios_proyecto != ""){
			bootbox.confirm({
    			title: "Se van a enviar la propuesta con los siguientes documentos, está seguro?",
    			message: $('#archivos_adjuntos').html(),
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
    					nombre_empresa = $("#nombre_entidad").val();
						var cont_historial = contador--;
						var cont_indicadores = contador_indicadores--;
						var cont_metas = contador_metas--;
						var cont_equipo = contador_equipo--;
						var cont_objetivos = contador_objetivos--;
						var formulario = $("#FORM_PROPUESTA").serializeArray();
						formulario.push(
						{
    						"name": "beneficiarios_proyecto",
    						"value": beneficiarios_proyecto
						},
						{
    						"name": "cantidad_beneficiados",
    						"value": cantidad_beneficiados
						},
						{
							"name": "fecha",
    						"value": fecha			
						},
						{
							"name": "contador_historial",
    						"value": cont_historial
						},
						{
							"name": "contador_objetivos",
    						"value": cont_objetivos
						},
						{
							"name": "contador_indicadores",
    						"value": cont_indicadores
						},
						{
							"name": "contador_metas",
    						"value": cont_metas
						},
						{
							"name": "contador_equipo",
    						"value": cont_equipo	
						},
						{
							"name": "id_usuario",
    						"value": Id_Usuario	
						}
						);
			
						$.ajax({
        				   	url: 'controlador/C_Insertar_Propuesta.php',
        				   	type: 'POST',
        				   	data: formulario,
        				   	cache: false,
        				   	async: false,
        				   	dataType: 'json',
        				   	beforeSend: function(){
        						
     						},
        				   	success: function(data, textStatus, jqXHR)
        				   	{
        				   		console.log(data);
        				   	}	
        				});
						console.log(formulario);
			
						uploadFiles(e);
						    	
    			    }else{
    			    		
    			    }	
    			}
		    });				
		}
		else{
			alert("Falta definir la POBLACION OBJETIVO, Numeral 7");
		}
		
	
	}); // FIN SUBMIT FORMULARIO PROPUESTA

	// Grab the files and set them to our variable
	function prepareUpload(event)
	{
		files = event.target.files;
		document.getElementById('archivos_adjuntos').innerHTML = "";
		$.each(files, function(index, value) {
			newp = document.createElement('p');
			newp.innerHTML= files[index]["name"];
			document.getElementById('archivos_adjuntos').appendChild(newp);
    		//console.log(files[index]["name"]);
		});	
	}

	// Catch the form submit and upload the files
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
		data.append("id_usuario", Id_Usuario);
		data.append("nombre_usuario", Nombre_Usuario);
  
        $.ajax({
            url: 'submit.php?files',
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
               		bootbox.alert("Por favor imprima o guarde el siguiente reporte, deberá <strong>radicarlo FIRMADO cuando se le indique.</strong>", function(){
                    window.location.href = "https://si.crea.gov.co/ConvocatoriaOrganizaciones/menuorganizacion.php";
                    window.open("controlador/C_PDF_Propuesta.php");
                    });
            		//window.location.href = "agradecimiento.html";
            	
            }
        });
    }
});	