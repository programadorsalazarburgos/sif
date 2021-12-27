    <?php 
    $return = "<table class='table table-hover'>";
    $return .= "<tr>
        <th>Fecha</th>
        <th>Observación</th>
        <th>Quien lo hizó</th>
    </tr>";
    foreach ($this->getVariables()['observacion'] as $o)
	{
    	$return .="<tr>";
    	$return .="	<td>". $o['DT_fecha']."</td>";
    	$return .="	<td>". $o['observacion']."</td>";       
    	$return .="	<td>". $o['VC_Primer_Nombre']." ".$o['VC_Segundo_Nombre']." ".$o['VC_Primer_Apellido']." ".$o['VC_Segundo_Apellido']."</td>";
    }
    $return .= "</table>";
    echo $return;
?>