let url_ok_obj = '../../src/GestionClan/GestionClanController/';
$(function(){
    $("#SL_linea_atencion, #SL_linea_atencion_consulta, #SL_linea_atencion_editar").html(parent.getOptionParametroDetalleByOrder(60)).selectpicker('refresh');
    $("#SL_linea_atencion").change(function(ev){
        if($(this).val() == "1"){
            //$("#SL_lugar_atencion").html(parent.getOptionParametroDetalle(56)).selectpicker('refresh');	
            $("#SL_clan option[value='0']").remove();
            $("#SL_clan").selectpicker('refresh');
        }
        if ($(this).val() == "2") {
            //$("#SL_lugar_atencion").html(parent.getOptionParametroDetalle(57)).selectpicker('refresh');
            $("#SL_clan_editar option[value='0']").remove();
            $("#SL_clan").prepend("<option value='0' >No aplica</option>").selectpicker('refresh');
        }
        if ($(this).val() == "3") {
            //$("#SL_lugar_atencion").html(parent.getOptionParametroDetalle(39)).selectpicker('refresh');
            $("#SL_clan option[value='0']").remove();
            $("#SL_clan").selectpicker('refresh');
        }
    });
    /*$("#SL_linea_atencion_consulta").change(function(ev){
        if($(this).val() == "1"){
            $("#SL_lugar_atencion_consulta").html(parent.getOptionParametroDetalle(56)).selectpicker('refresh');	
        }
        if ($(this).val() == "2") {
            $("#SL_lugar_atencion_consulta").html(parent.getOptionParametroDetalle(57)).selectpicker('refresh');
        }
        if ($(this).val() == "3") {
            $("#SL_lugar_atencion_consulta").html(parent.getOptionParametroDetalle(39)).selectpicker('refresh');
        }
    });*/
    $("#SL_linea_atencion_editar").change(function(ev){
        if($(this).val() == "1"){
            //$("#SL_lugar_atencion_editar").html(parent.getOptionParametroDetalle(56)).selectpicker('refresh');	
            $("#SL_clan_editar option[value='0']").remove();
            $("#SL_clan_editar").selectpicker('refresh');
        }
        if ($(this).val() == "2") {
            //$("#SL_lugar_atencion_editar").html(parent.getOptionParametroDetalle(57)).selectpicker('refresh');
            $("#SL_clan_editar option[value='0']").remove();
            $("#SL_clan_editar").prepend("<option value='0' >No aplica</option>").selectpicker('refresh');
        }
        if ($(this).val() == "3") {
            //$("#SL_lugar_atencion_editar").html(parent.getOptionParametroDetalle(39)).selectpicker('refresh');
            $("#SL_clan_editar option[value='0']").remove();
            $("#SL_clan_editar").selectpicker('refresh');
        }
    });
    $("#SL_anio_consulta").html(parent.getOptionParametroDetalle(7)).selectpicker('refresh');
    $("#SL_zona, #SL_zona_consulta, #SL_zona_editar").html(parent.consultarZonas()).selectpicker('refresh');
    $("#SL_clan, #SL_clan_editar").html(parent.getOptionsClanes()).selectpicker('refresh');
    $("#SL_colegio, #SL_colegio_editar").html(parent.getOptionsColegios()).selectpicker('refresh');
    $("#SL_convenio, #SL_convenio_consulta, #SL_convenio_editar").html(parent.getOptionParametroDetalle(68)).selectpicker('refresh');
    $("#SL_area_artistica, #SL_area_artistica_consulta, #SL_area_artistica_editar").html(parent.getOptionsAreasArtisticas()).selectpicker('refresh');
    $("#SL_area_artistica").change(function(ev){
        //let detallado = pintarEntradasNumeroGruposYBeneficiariosProyectadosPorArea($(this).val(), $('#SL_lugar_atencion option:selected').toArray().map(item => item.text), $('#SL_lugar_atencion option:selected').toArray().map(item => item.value),"crear");
        let detallado = pintarEntradasNumeroGruposYBeneficiariosProyectadosPorArea($(this).val(), [" "], "1","crear");
        // document.getElementById("div_detalle_grupos_beneficiarios_area").innerHtml = detallado;
        $("#div_detalle_grupos_beneficiarios_area").html(detallado);
    });
    $("#SL_area_artistica_editar").change(function(ev){
        //let detallado = pintarEntradasNumeroGruposYBeneficiariosProyectadosPorArea($(this).val(), $('#SL_lugar_atencion_editar option:selected').toArray().map(item => item.text), $('#SL_lugar_atencion_editar option:selected').toArray().map(item => item.value),"editar");
        let detallado = pintarEntradasNumeroGruposYBeneficiariosProyectadosPorArea($(this).val(), [" "], "1","editar");
        // document.getElementById("div_detalle_grupos_beneficiarios_area").innerHtml = detallado;
        $("#div_detalle_grupos_beneficiarios_area_editar").html(detallado);
    });
    /*$("#SL_lugar_atencion").change(function(ev){
        if($("#SL_area_artistica").val()!=""){
            let detallado = pintarEntradasNumeroGruposYBeneficiariosProyectadosPorArea($("#SL_area_artistica").val(), $('#SL_lugar_atencion option:selected').toArray().map(item => item.text), $('#SL_lugar_atencion option:selected').toArray().map(item => item.value),"crear");
            // document.getElementById("div_detalle_grupos_beneficiarios_area").innerHtml = detallado;
           $("#div_detalle_grupos_beneficiarios_area").html(detallado);
        }
    });
    $("#SL_lugar_atencion_editar").change(function(ev){
        if($("#SL_area_artistica_editar").val()!=""){
            let detallado = pintarEntradasNumeroGruposYBeneficiariosProyectadosPorArea($("#SL_area_artistica_editar").val(), $('#SL_lugar_atencion_editar option:selected').toArray().map(item => item.text), $('#SL_lugar_atencion_editar option:selected').toArray().map(item => item.value),"editar");
            // document.getElementById("div_detalle_grupos_beneficiarios_area").innerHtml = detallado;
           $("#div_detalle_grupos_beneficiarios_area_editar").html(detallado);
        }
    });*/

    $("#form_nueva_cobertura").submit(function(event){
		event.stopPropagation();
        event.preventDefault();
        let o = {};
		let a = $(this).serializeArray();
		$.each(a, function () {
			 if (o[this.name]) {
					 if (!o[this.name].push) {
							 o[this.name] = [o[this.name]];
					 }
					 o[this.name].push(this.value || '');
			 } else {
					 o[this.name] = this.value || '';
			 }
        });
        o['id_usuario']=parent.idUsuario;
		datos_formulario = o
        datos = {
			'p1': datos_formulario
		}
        console.log(datos_formulario);
		$.ajax({
			url: url_ok_obj+'crearNuevaCobertura',
			type: 'POST',
			data: datos,
			async:false,
			beforeSend: function(){
				parent.mostrarCargando()
			}
		}).done(function(data){
            parent.cerrarCargando()
            if(parseInt(data) >= 1){
                parent.mostrarAlerta("success","Operación exitosa","Se ha guardado la cobertura.")
            }else{
                parent.mostrarAlerta("error","No Guardó","Hubo un problema y al parecer no fue guardada la cobertura. Por favor consultar para verificar.")
            }
            $('.selectpicker').selectpicker('val', '').selectpicker("refresh").change();
            $("#SL_area_artistica").selectpicker("deselectAll").change();
        }).fail(function(data){
            parent.mostrarAlerta("error","No Guardó","Hubo un problema.  " + data)
            console.log(data)
        })
    });

    $("#form_editar_cobertura").submit(function(event){
		event.stopPropagation();
        event.preventDefault();
        let o = {};
		let a = $(this).serializeArray();
		$.each(a, function () {
			 if (o[this.name]) {
					 if (!o[this.name].push) {
							 o[this.name] = [o[this.name]];
					 }
					 o[this.name].push(this.value || '');
			 } else {
					 o[this.name] = this.value || '';
			 }
        });
        o['id_usuario']=parent.idUsuario;
		datos_formulario = o
        datos = {
			'p1': datos_formulario
		}
        console.log(datos_formulario);
        
		$.ajax({
			url: url_ok_obj+'EditarCobertura',
			type: 'POST',
			data: datos,
			async:false,
			beforeSend: function(){
				parent.mostrarCargando()
			},
            complete: function(){
                $("#editar_cobertura").modal('hide');
                $("#BT_Consultar").click();
            }

		}).done(function(data){
            parent.cerrarCargando()           
            if(parseInt(data) >= 1){
                parent.mostrarAlerta("success","Operación exitosa","Se ha guardado la cobertura.");
            }else{
                parent.mostrarAlerta("error","No Guardó","Hubo un problema y al parecer no fue guardada la cobertura. Por favor consultar para verificar.")
            }
        })
        .fail(function(data){
            parent.mostrarAlerta("error","No Guardó","Hubo un problema.  " + data)
            console.log(data)
        });        
    });

    $("#form_filtros_consulta").submit(function(event){
		event.stopPropagation();
        event.preventDefault();
        let o = {};
		let a = $(this).serializeArray();
		$.each(a, function () {
			 if (o[this.name]) {
					 if (!o[this.name].push) {
							 o[this.name] = [o[this.name]];
					 }
					 o[this.name].push(this.value || '');
			 } else {
					 o[this.name] = this.value || '';
			 }
        });
        o['id_usuario']=parent.idUsuario;
		datos_formulario = o
        datos = {
			'p1': datos_formulario
		}
		$.ajax({
			url: url_ok_obj+'consultarCoberturasActivas',
			type: 'POST',
			async:false,
            data: datos,
			beforeSend: function(){
				parent.mostrarCargando()
			}
		}).done(function(data){
            area_artistica_text =$('#SL_area_artistica_consulta option:selected').toArray().map(item => item.text)
            //lugar_atencion_text = $('#SL_lugar_atencion_consulta option:selected').toArray().map(item => item.text);
            //cantidad = lugar_atencion_text.length + 2;
            parent.cerrarCargando()
            try{
                data = $.parseJSON(data);
                //console.log(data);
                let html = `
                <table id="tabla_consultar_pactos" class="table table-striped table-bordered table-hover display" style="width:100%"><thead><tr>
                <th rowspan="2">OPCIONES</th>
                <th rowspan="2">AÑO</th>
                <th rowspan="2">LÍNEA DE ATENCIÓN</th>
                <th rowspan="2">CONVENIO</th>
                <th rowspan="2">ZONA</th>
                <th rowspan="2">COLEGIO</th>
                <th rowspan="2">CREA(S)</th>`;

                area_artistica_text.forEach(area_artistica_text => {
                    html += `<th colspan=3><center>${area_artistica_text}</center></th>`;
                });

                html += `<th rowspan="2">CREACIÓN/EDICIÓN</th>
                         <th rowspan="2">USUARIO</th>
                    </tr>
                    <tr>`;
                
                area_artistica_text.forEach(() => {
                    html+='<th>GRUPOS</th>';
                    html+='<th>BENEFICIARIOS PROYECTADOS</th>';
                    html+='<th>OBSERVACIONES</th>';
                });
                html += `</tr></thead><tbody>`;
                lugares = ["1"];
                areas = datos_formulario['SL_area_artistica_consulta'];
                                
                data.forEach( c => {
                    crea_nombre = "No aplica";
                    if(c.VC_Nom_Clan != null){
                        crea_nombre = c.VC_Nom_Clan;
                    }
                    html += `<tr>
                        <td><a class='btn btn-info editar_pacto' data-id='${c.id}' data-toggle="tooltip" data-placement="bottom" title="Editar"><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a><a class='btn btn-danger confirmar_eliminar' data-id='${c.id}' title="Eliminar" data-toggle="modal" data-target="#eliminar_cobertura"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a></td>
                        <td>${c.anio}</td>
                        <td>${c.LINEA_ATENCION}</td>
                        <td>${c.CONVENIO}</td>
                        <td>${c.ZONA}</td>
                        <td>${c.VC_Nom_Colegio}</td>
                        <td>${crea_nombre}</td>`;

                    Array.from(areas).forEach(area => {
                        Array.from(lugares).forEach(lugar => {
                            //html += `<td>${c[area+'_'+lugar] != null ? c[area+'_'+lugar] : ''}</td>`;
                            html += `<td>${c['GRUPOS_'+area] != null ? c['GRUPOS_'+area] : ''}</td>`;
                        });                        
                        html += `<td>${c[area+'_BENEFICIARIOS'] != null ? c[area+'_BENEFICIARIOS'] : ''}</td>`;
                        html += `<td>${c[area+'_OBSERVACIONES'] != null ? c[area+'_OBSERVACIONES'] : ''}</td>`;
                    });
                                        
                    html += `<td>${c.FECHA}</td>
                        <td>${c.VC_Primer_Nombre} ${c.VC_Primer_Apellido}</td>
                    </tr>`
                });
                html += `</tbody></table>`;
                $("#div_tabla_consultar_pactos").html("")
                $("#div_tabla_consultar_pactos").html(html)
                
                let tabla_consultar_pactos = $("#tabla_consultar_pactos").DataTable({
                iDisplayLength: '50',
                "language": {
                    "lengthMenu": "Ver _MENU_ registros por pagina",
                    "zeroRecords": "No hay información, lo sentimos.",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Filtrar"
                },
                /*dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]*/
                }).on( 'draw', function () {
                    
                }).draw();
                tabla_consultar_pactos.search('').draw();
            }catch(error){
                parent.mostrarAlerta("error","Error decodificando JSON","Hubo un problema.  " + data)
                console.log(data)
            }
        }).fail(function(data){
            parent.mostrarAlerta("error","No Guardó","Hubo un problema.  " + data)
            console.log(data)
        })
    });

    $("#nav_consultar_pacto").click(function(){
		
    });

    $(document).on("click", ".editar_pacto",function(e){
        parent.window.scrollTo(0, 0);
        id = $(this).data('id');
        datos = {
			'p1': id
		}
		$.ajax({
			url: url_ok_obj+'consultarCoberturasActivasbyid',
			type: 'POST',
			async:false,
            data: datos,
			beforeSend: function(){
				parent.mostrarCargando()
			}
		}).done(function(data){
            data = $.parseJSON(data);          
            //console.log(data);  

            let areas = $.map($('#SL_area_artistica_consulta option'),function(option) { return option.value; });;
            let lugares = $.map($('#SL_linea_atencion_consulta option'),function(option) { return option.value; });;
            let lugares_registrado = [];
            let areas_registrado = [];
            let campos=[];

            Array.from(areas).forEach(area => {
                area_estado = false;
                Array.from(lugares).forEach(lugar => {                
                                  
                    if(data[0][area+'_BENEFICIARIOS'] != null){
                        lugares_registrado.push(lugar);  
                        //campos.push(["#IN_numero_grupos_"+area+"_"+lugar,data[0][area+'_'+lugar]]);
                        campos.push(["#IN_numero_grupos_"+area+"_"+lugar,data[0]["GRUPOS_"+area]]);
                        campos.push(["#IN_numero_beneficiarios_proyectados_area_artistica_"+area,data[0][area+'_BENEFICIARIOS']]);                     
                        campos.push(["#TX_observaciones_beneficiarios_proyectados_area_artistica_"+area,data[0][area+'_OBSERVACIONES']]);                     
                        
                        area_estado = true;
                    }
                }); 
                if(area_estado){
                    areas_registrado.push(area);
                }
                else{
                    if(data[0][area+'_BENEFICIARIOS'] != null){
                        areas_registrado.push(area);  
                        campos.push(["#IN_numero_beneficiarios_proyectados_area_artistica_"+area,data[0][area+'_BENEFICIARIOS']]);                 
                        campos.push(["#TX_observaciones_beneficiarios_proyectados_area_artistica_"+area,data[0][area+'_OBSERVACIONES']]);    
                    }
                }                
            });  

            $("#id").val(id);
            $("#SL_linea_atencion_editar").val(data[0].IN_linea_atencion).selectpicker('refresh').trigger('change');
            $("#SL_convenio_editar").val(data[0].id_convenio).selectpicker('refresh').trigger('change');
            $("#SL_lugar_atencion_editar").val(lugares_registrado).selectpicker('refresh').trigger('change');
            //$("#SL_lugar_atencion_editar").val($("#SL_lugar_atencion_consulta").val()).selectpicker('refresh').trigger('change'); 
            $("#SL_zona_editar").val(data[0].FK_zona).selectpicker('refresh').trigger('change');      
            $("#SL_colegio_editar").val(data[0].id_colegio).selectpicker('refresh').trigger('change');    
            $("#SL_clan_editar").val(data[0].id_clan).selectpicker('refresh').trigger('change');      
            //$("#SL_area_artistica_editar").val(areas_registrado).selectpicker('refresh').trigger('change');
            $("#SL_area_artistica_editar").val(areas_registrado).selectpicker('refresh').trigger('change');

            Array.from(campos).forEach(campo => {
                $(campo[0]).val(campo[1]);
            }); 

            parent.cerrarCargando()
            $("#editar_cobertura").modal('show');
        })
    });

    $(document).on("click", "#eliminar_pacto",function(e){
        id = $("#id").val();
        datos = {
			'p1': {"id": id, "id_usuario": parent.idUsuario}
		}
		$.ajax({
			url: url_ok_obj+'EliminarCobertura',
			type: 'POST',
			data: datos,
			async:false,
			beforeSend: function(){
				parent.mostrarCargando()
			},
            complete: function(){
                $("#eliminar_cobertura").modal('hide');
                $("#BT_Consultar").click();
            }
		}).done(function(data){
            parent.cerrarCargando()   
            if(parseInt(data) >= 1){
                parent.mostrarAlerta("success","Operación exitosa","Se ha eliminado el pacto de cobertura.");
            }else{
                parent.mostrarAlerta("error","No se eliminó","Hubo un problema y al parecer no se eliminó el pacto de cobertura. Por favor consultar para verificar.")
            }            
        }).fail(function(data){
            parent.mostrarAlerta("error","No Guardó","Hubo un problema.  " + data)
            console.log(data)
        })
    });

    $(document).on("click", ".confirmar_eliminar",function(e){
        parent.window.scrollTo(0, 0);
        id = $(this).data('id');
        datos = {
			'p1': id
		}
		$.ajax({
			url: url_ok_obj+'consultarCoberturasActivasbyid',
			type: 'POST',
			async:false,
            data: datos
		}).done(function(data){
            data = $.parseJSON(data);          
            console.log(data);  

            $("#id").val(id);
            html = `<p><b>Linea de Atencion: </b> ${data[0].Linea}</p>`;  
            html += `<p><b>Convenio: </b> ${data[0].Convenio}</p>`;          
            html += `<p><b>Zona: </b> ${data[0].VC_Nombre_Zona}</p>`;         
            html += `<p><b>Colegio: </b> ${data[0].VC_Nom_Colegio}</p>`;
            html += `<p><b>Crea: </b> ${data[0].VC_Nom_Clan}</p>`;

            $("#contenido_pacto").html(html);
        })
    });

    function pintarEntradasNumeroGruposYBeneficiariosProyectadosPorArea(area_artistica, lugar_atencion_text, lugar_atencion_values, accion) {
        let html='';
        area_artistica.forEach(area_artistica => {
            html+='<div class="'+ (accion == "crear" ? 'container ' : '') +'panel panel-info">';
                    html+='<div class="row panel-heading" '+ (accion == "editar" ? 'style="margin:0;"' : '') +'>';
                     html+='<div class="col-xs-12 col-md-12">';
                      html+='<h5 class="text-center">DETALLADO '+$("#SL_area_artistica option[value='"+area_artistica+"']").text()+'</h5>';
                     html+='</div>';
                    html+='</div>';
                    html+='<div class="panel-body">';
                     html+='<div class="row">';
                     var i=0;
                     lugar_atencion_text.forEach(lugar_atencion_text => {
                            html+='<div class="col-xs-6 col-md-3">';
                                html+='<label for="IN_numero_grupos_area_'+area_artistica+'_lugar_atencion_'+lugar_atencion_values[i]+'"># Grupos '+lugar_atencion_text+'</label>';
                                html+='<input type="number" required="required" name="IN_numero_grupos_'+area_artistica+'_'+lugar_atencion_values[i]+'" id="IN_numero_grupos_'+area_artistica+'_'+lugar_atencion_values[i]+'" class="form-control" placeholder="Número de grupos">';
                            html+='</div>';
                            i++;
                        });
                        html+='<div class="col-xs-6 col-md-3">';
                                html+='<label for="IN_numero_beneficiarios_proyectados_area_artistica_'+area_artistica+'"># Beneficiarios Proyectados</label>';
                                html+='<input type="number" required="required" name="IN_numero_beneficiarios_proyectados_area_artistica_'+area_artistica+'" id="IN_numero_beneficiarios_proyectados_area_artistica_'+area_artistica+'" class="form-control" placeholder="Beneficiarios Proyectados">'
                            html+='</div>';
                            html+='<div class="col-xs-6 col-md-3">';
                                html+='<label for="TX_observaciones_beneficiarios_proyectados_area_artistica_'+area_artistica+'">Observaciones</label>';
                                html+='<input type="text" required="required" name="TX_observaciones_beneficiarios_proyectados_area_artistica_'+area_artistica+'" id="TX_observaciones_beneficiarios_proyectados_area_artistica_'+area_artistica+'" class="form-control" placeholder="Observaciones del área">'
                            html+='</div>';
                        html+='</div>';
                    html+='</div>';
                html+='</div>';
        });
        return html;
    }
});