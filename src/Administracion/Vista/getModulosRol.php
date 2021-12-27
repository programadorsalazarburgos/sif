<?php 

foreach ($this->getVariables()['modulos'] as $ma): ?>
	<?php if($ma['VC_Imagen']!=''): ?>
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 centrado modulo">
			<a href='#' title='Módulo: <?= $ma['VC_Nom_Modulo'] ?>' class="iconosInicio eventoClic" data-toggle="modal" data-modulo='<?= $ma['id_modulo'] ?>'  data-nombremodulo='<?= $ma['VC_Nom_Modulo'] ?>' data-target="#modal_actividades">
				<img src="imagenes/<?= $ma['VC_Imagen'] ?>" class="imagen-modulo" width="35%"></img>			
				<p class="nombre-modulo" id="nombre-modulo" name="nombre-modulo"><?= $ma['VC_Nom_Modulo'] ?></p>			
			</a>
		</div>
	<?php endif; ?>  
	<?php endforeach; ?>