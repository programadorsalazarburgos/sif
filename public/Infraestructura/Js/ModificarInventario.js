$(document).ready(function(){ 
	//ALIMENTA LAS LISTAS DESPLEGABLES
	// $.ajax({
	// 	async : false,
	// 	url: '../../Controlador/Infraestructura/Inventario/C_ListarClanes.php',
	// 	type: 'POST',
	// 	dataType: 'json',
	// 	data: {name: ''},
	// 	success: function(datos)
	// 	{
	// 		//console.log(datos);
	// 		$.each(datos, function(i) 
	// 		{
	// 			$('#modal-editar #MODAL_SL_CLAN').append("<option value="+datos[i].PK_Id_Clan+">"+datos[i].VC_Nom_Clan+"</option>");
	// 		});
			
	// 	}
	// });
	$.ajax({
		async : false,
		url: '../../Controlador/Infraestructura/Inventario/C_ListarTipoBien.php',
		type: 'POST',
		dataType: 'json',
		data: {name: ''},
		success: function(datos)
		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#modal-editar #MODAL_SL_TIPO_BIEN').append("<option value="+datos[i].PK_Id_Detalle+">"+datos[i].VC_Descripcion+"</option>");
			});
			
		}
	});/*
	$.ajax({
		async : false,
		url: '../../Controlador/Infraestructura/Inventario/C_ListarProcedencia.php',
		type: 'POST',
		dataType: 'json',
		data: {name: ''},
		success: function(datos)
		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#modal-editar #MODAL_SL_PROCEDENCIA').append("<option value="+datos[i].PK_Id_Detalle+">"+datos[i].VC_Descripcion+"</option>");
			});
		}
	});*/
	$.ajax({
		async : false,
		url: '../../Controlador/Infraestructura/Inventario/C_ListarElementos.php',
		type: 'POST',
		dataType: 'json',
		data: {name: ''},
		success: function(datos)
		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#modal-editar #MODAL_SL_ELEMENTO').append("<option value="+datos[i].PK_Id_Detalle+">"+datos[i].VC_Descripcion+"</option>");
			});
		}
	});
	$.ajax({
		async : false,
		url: '../../Controlador/Infraestructura/Inventario/C_ListarTipoElementos.php',
		type: 'POST',
		dataType: 'json',
		data: {name: ''},
		success: function(datos)
		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#modal-editar #MODAL_SL_TIPO_ELEMENTO').append("<option value="+datos[i].PK_Id_Detalle+">"+datos[i].VC_Descripcion+"</option>");
			});
		}
	});
	$.ajax({
		async : false,
		url: '../../Controlador/Infraestructura/Inventario/C_ListarEstadosBien.php',
		type: 'POST',
		dataType: 'json',
		data: {name: ''},
		success: function(datos)
		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#modal-editar #MODAL_SL_ESTADO_BIEN').append("<option value="+datos[i].PK_Id_Detalle+">"+datos[i].VC_Descripcion+"</option>");
			});
		}
	});
	//TERMINA CARGA DE LASLISTAS DESPLEGABLES
	var flag=0;
	$("#modal-editar #BT_SIN_PLACA").click(function(){
		if(flag==0)
       {
            $('#modal-editar #TXT_PLACA').val("S/P");
			$('#modal-editar #TXT_PLACA').prop('readonly', true);
			$(this).removeClass("btn-success");
			$(this).addClass("btn-danger	");
            flag=1;
            return;
        }
        if(flag==1)
        {
           	$('#modal-editar #TXT_PLACA').prop('readonly', false);
    		$('#modal-editar #TXT_PLACA').val("");
    		$(this).removeClass("btn-danger");
			$(this).addClass("btn-success");
            flag=0;
            return;
         }
	});

	$('#modal-editar #BT_LIMPIAR').on('click', function(){
		$('#modal-editar #TXT_PLACA').prop('readonly', false);
	});


});
