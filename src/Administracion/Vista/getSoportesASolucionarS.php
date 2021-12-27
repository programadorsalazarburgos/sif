<?php     
    $retorno="";
    foreach ($this->getVariables()['soportes'] as $s){
	    $retorno.="<tr>
	        <td>".$s['DT_fecha_creacion']."</td>
			<td>".$s['VC_descripcion']."</td>
			<td>".$s['VC_Primer_Apellido']." ".$s['VC_Segundo_Apellido']." ".$s['VC_Primer_Nombre']." ".$s['VC_Segundo_Nombre']."</td>
			<td>
				<a href='#' class='solucionar_soporte btn btn-info' data-id_persona='".$s['FK_persona']."'  data-fecha_creacion='".$s['DT_fecha_creacion']."' data-texto_solicitud='".$s['TX_solicitud']."' data-toggle='modal' data-target='#modal_solucion_soporte'>_Solucionar Soporte</a>
			</td>		
	    </tr>";
    }
    echo $retorno;


    