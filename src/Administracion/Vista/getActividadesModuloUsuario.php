
<ul class="nav">
<?php
	foreach ($this->getVariables()['actividades'] as $ma):
	if((strpos($ma['VC_Nom_Actividad'], 'Tutorial') === false) && (strpos($ma['VC_Nom_Actividad'], 'Manual') === false))
	{
?>
    <li>
		<a href='<?= ($ma['estado']==="1")?$ma['VC_Page']:"../framework/errors/mantenimiento" ?>' target="_self" title=" Actividad: <?= $ma['VC_Nom_Actividad'] ?>" class="eventoClic">
			<font><?= $ma['VC_Nom_Actividad'] ?></font>			
		</a>	    	 
    </li>
<?php }  else { ?>
	<li>
		<a style="background-color: #4f3483" href='<?= ($ma['estado']==="1")?$ma['VC_Page']:"../framework/errors/mantenimiento" ?>' target="_blank" title=" Actividad: <?= $ma['VC_Nom_Actividad'] ?>" class="eventoClic">
			<i style='color:#ffffff;'><span class='fa fa-play fa 2x'></span> <?= $ma['VC_Nom_Actividad'] ?></i>
		</a>	    	 
    </li>
	<?php }	?>
    <hr class="separadorMenu">
<?php endforeach; ?> 
</ul>