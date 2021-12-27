<?php
$retorno="<table class='table table-hover' id='table_log_login'>
			<thead>
				<tr>
					<th class='text-center'>Fecha y hora</th>
					<th class='text-center'>Dispositivo</th>
					<th class='text-center'>IP</th>
				</tr>
			</thead>
			<tbody>";
    foreach ($this->getVariables()['log_login'] as $l){
	    $retorno.="<tr>
	    <td>".$l['DT_fecha_ingreso']."</td>
			<td>".$l['TX_dispositivo']."</td>
      <td>".$l['TX_IP']."</td>
	    </tr>";
    }
    echo $retorno."</tbody>
		</table>";
