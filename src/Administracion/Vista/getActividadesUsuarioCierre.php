    <h3>Escoga la actividad  de cierre del incidente</h3>
    <ul class="nav" id="side-menu2">  

    <?php foreach ($this->getVariables()['menuActividades'] as $ma): ?>
	    <li>
			<a href='#' title='Módulo: <?= $ma['VC_Nom_Modulo'] ?>'>
				<span class='glyphicon glyphicon-<?= $ma['VC_Icono'] ?>' aria-hidden='true'></span> 
				<font color='#009933'><?= $ma['VC_Nom_Modulo'] ?></font>
				<span class='fa arrow'></span>
			</a>	    
			<ul class='nav nav-second-level'>
			<?php foreach ($ma['actividades'] as $a): ?>
				<li>
				<a href='#'  title='<?= $a['VC_Nom_Actividad'] ?>' id='<?= $a['PK_Id_Actividad'] ?>'><?= $a['VC_Nom_Actividad'] ?></a>
				</li>
			<?php endforeach; ?> 	
			</ul>	
	    </li>
    <?php endforeach; ?> 
    </ul>

	<style>
		#side-menu2{
			background: "#f5f5f5";
		}
		ul#side-menu2 > li:first-child{
			border-top: 1px solid #e7e7e7;
		}
		ul#side-menu2 > li {
			border-bottom: 1px solid #e7e7e7;
		}
	</style>

    