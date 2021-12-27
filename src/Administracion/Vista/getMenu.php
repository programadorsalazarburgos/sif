
<?php $activo=true; foreach ($this->getVariables()['menu'] as $m): ?>
	<li <?php if($activo){echo $activo=false;}  ?>>
		<a href='#' title='Módulo: <?=$m['nombre']?>' class='eventoClic moduloMenu'> 			
			<img src='imagenes/<?=$m['imagen']?>' width='7%'></img>
			<?=$m['nombre']?>
			<i class='fas fa-angle-right flota-der'></i>
		</a>
		<?php if(isset($m['opciones'])): ?>
			<?php if(sizeof($m['opciones'])>0): ?>
			<ul class='nav nav-second-level'>
			<?php foreach ($m['opciones'] as $o): ?>
				<li>
					<?php if (strpos($o['nombre'],'Tutorial') == false){?>
					<a href='<?=($o['estado']==="1")?$o['url']:"../framework/errors/mantenimiento"?>' target='ventana_iframe' title='Actividad: <?= $o['nombre']?>' class='eventoClic actividadMenu'> 
						<?=$o['nombre']?>							
					</a>
					<?php } else {?>
						<a href='<?=($o['estado']==="1")?$o['url']:"../framework/errors/mantenimiento"?>' style='background-color: #66429a; color:white;' target='_blank' title='Actividad: <?= $o['nombre']?>' class='eventoClic actividadMenu'> 
						<?=$o['nombre']?>							
					</a>
					<?php } ?>
				</li>
			<?php endforeach; ?> 
			</ul>				
			<?php endif; ?>  
		<?php endif; ?>   
	</li> 
<?php endforeach; ?>  
