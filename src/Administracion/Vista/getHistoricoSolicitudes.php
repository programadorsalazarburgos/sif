    <?php 
    $return ="";
    foreach ($this->getVariables()['soportesUsuario'] as $s)
	{
    	$return .="<tr>";
    	$return .="	<td>". $s['codigo'] ."</td>";	     										
    	$return .="	<td>". $s['fecha_Creacion'] ."</td>";    
        $return .=" <td>". $s['usuario'] ."</td>";     
        $return .=" <td>". $s['observadores'] ."</td>";  
        $return .=" <td>". $s['titulo'] ."</td>";                                                        
        $return .=" <td>". $s['estado'] ."</td>";    
        $return .=" <td>". getPrioridad($s['prioridad']) ."</td>";     
        $return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_observaciones' class='btn observaciones btn-info linkObservaciones'  data-incidente='".$s['codigo']."' data-observadores='".$s['observadores_id']."' data-atendido='".$s['atendido_por']."' data-estado='".$s['estado']."' data-usuario='".$s['FK_Id_Usuario']."' >Ver / Añadir</td>"; 
        $return .=" <td>". $s['primer_nombre_funcionario']." ".$s['segundo_nombre_funcionario'].' '.$s['primer_apellido_funcionario'].' '.$s['segundo_apellido_funcionario'] ."</td>";   
        $return .=" <td>". $s['descripcion_sintomas'] ."</td>";                      
        $return .=" <td>". $s['descripcion_solucion'] ."</td>";    
        $return .=" <td>". $s['fecha_cierre'] ."</td>"; 
        $return .=" <td>". $s['actividad_apertura'] ."</td>";       
        $return .=" <td>". $s['actividad_cierre'] ."</td>";   
    	$return .="	<td>". $s['VC_descripcion'] ."</td>";    
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