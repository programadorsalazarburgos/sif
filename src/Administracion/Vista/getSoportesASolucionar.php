    <?php
    $return =""; 
    foreach ($this->getVariables()['soportes'] as $s){
    	$nombre=$s['primer_apellido_usuario']." ".$s['segundo_apellido_usuario']." ".$s['primer_nombre_usuario']." ".$s['segundo_nombre_usuario'];
	    $return.="<tr>";
	    $return.="    <td>".$s['codigo'] ."</td>";
	    $return.="    <td>".$s['fecha_Creacion'] ."</td>";
	    $return.="	  <td>". $s['titulo'] ."</td>";   
	    $return.="	  <td>". $s['FK_Id_Usuario'] ."</td>"; 
	    $return.="	  <td>". $s['estado'] ."</td>";    		
		$return.="	  <td>".$nombre."</td>";

		$return.="	  <td>"; 
		$return.="		<a href='#' class='solucionar_soporte btn btn-info' data-id_persona='".$s['FK_Id_Usuario'] ."'  data-fecha_creacion='".$s['fecha_Creacion'] ."' data-texto_solicitud='".$s['descripcion_sintomas']."' data-nombre_usuario='".$nombre."' data-toggle='modal' data-target='#modal_solucion_soporte'  data-incidente='".$s['codigo']."'  data-fk_actividad_apertura='".$s['FK_Actividad_Apertura']."'
			data-actividad_apertura='".$s['actividad_apertura']."' 
			data-urgencia='".$s['urgencia']."' 
			data-impacto='".$s['impacto']."'
			data-prioridad='".$s['prioridad']."'  
			data-observadores='".$s['observadores']."'
			data-titulo_incidente='".$s['titulo']."'
			>Solucionar Soporte</a>"; 
		$return.="	  </td>";
		$return.="	  <td>".$s['observadores']."</td>";
		//$return.="	  <td>".$s['descripcion_sintomas'] ."</td>";		
	    $return.="</tr>";
    }
    echo $return; 

    
    