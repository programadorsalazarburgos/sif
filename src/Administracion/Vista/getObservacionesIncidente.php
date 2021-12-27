    <?php 
    $return ="";
    foreach ($this->getVariables()['observaciones'] as $s)
	{
    	$return .="<tr>";
    	$return .="	<td>". $s['fecha'] ."</td>";		
    	$return .="	<td>". $s['nombre'] ."</td>";    
    	$return .="	<td>". $s['observaciones'] ."</td>";    
        $return .="</tr>";            	    
	}
    $return.= "<input type='hidden' id='tipoPersona' value='".$this->getVariables()['TipoPersona']."' />";
	echo $return; 