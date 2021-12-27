    <?php foreach ($this->getVariables()['asistencias'] as $s): ?>
	    <tr>
	        <td><?= $s['FK_sesion_clase'] ?></td>
			<td><?= $s['FK_estudiante'] ?></td>
			<td><?= $s['IN_estado_asistencia'] ?></td>	
	    </tr>
    <?php endforeach; ?> 
    