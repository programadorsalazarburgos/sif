    <?php 
    $return ="";
    foreach ($this->getVariables()['soportes'] as $s)
	{
        $nombre=$s['primer_apellido_usuario']." ".$s['segundo_apellido_usuario']." ".$s['primer_nombre_usuario']." ".$s['segundo_nombre_usuario'];
    	$return .="<tr>";
    	$return .="	<td>". $s['codigo'] ."</td>";	     										
    	$return .="	<td>". $s['fecha_Creacion'] ."</td>";    
    	$return .="	<td>". $s['VC_descripcion'] ."</td>"; 
        $return .="<td>".$nombre."</td>";
    	$return .="	<td>". $s['titulo'] ."</td>";	    												 
    	$return .="	<td>". $s['estado'] ."</td>";    
    	$return .="	<td>". getPrioridad($s['prioridad']) ."</td>";    
		//$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_observaciones' id='linkObservaciones' class='btn observaciones btn-info'  data-incidente='".$s['codigo']."'>Ver / Añadir</td>";
        $return.="    <td>"; 
        $return.="      <a href='#' class='solucionar_soporte btn btn-info' data-id_persona='".$s['FK_Id_Usuario'] ."'  data-fecha_creacion='".$s['fecha_Creacion'] ."' data-texto_solicitud='".$s['descripcion_sintomas']."' data-nombre_usuario='".$nombre."' data-toggle='modal' data-target='#modal_solucion_soporte'  data-incidente='".$s['codigo']."'  data-fk_actividad_apertura='".$s['FK_Actividad_Apertura']."'
            data-actividad_apertura='".$s['actividad_apertura']."' 
            data-urgencia='".$s['urgencia']."' 
            data-impacto='".$s['impacto']."'
            data-prioridad='".$s['prioridad']."'  
            data-observadores='".$s['observadores']."'
            data-observadores_id='".$s['observadores_id']."'
            >Ver / Añadir</a>"; 
        $return.="    </td>";

    	$return .="	<td>". $s['primer_nombre_funcionario']." ".$s['segundo_nombre_funcionario'].' '.$s['primer_apellido_funcionario'].' '.$s['segundo_apellido_funcionario'] ."</td>";   
    	$return .="	<td>". strip_tags($s['descripcion_sintomas']) ."</td>";  			         
    	$return .="	<td>". strip_tags($s['descripcion_solucion']) ."</td>";    
    	$return .="	<td>". $s['fecha_cierre'] ."</td>"; 
    	$return .="	<td>". $s['actividad_apertura'] ."</td>";   	
        $return .=" <td>". $s['actividad_cierre'] ."</td>";   
    	$return .="</tr>";
    	    
	}
	echo $return;  

    function getPrioridad($prioridad)
    {
        switch ($prioridad) {
            case '':
                return 'Sin asignar';
                break;            
            case '1':
                return 'Planeada';
                break;
            case '2':
                return 'Baja';
                break;
            case '3':
                return 'Media';
                break;  
            case '4':
                return 'Alta';
                break; 
            case '5':
                return 'Crítica';
                break;                                              
            default:
                echo "Prioridad (".$prioridad.") no valida ";
                break;
        }
    }