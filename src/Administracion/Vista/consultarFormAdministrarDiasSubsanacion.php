<?php $dias_subsanacion = $this->getVariables()['dias_subsanacion'];?>
<div class="row">
	<div class="col-xs-12 col-md-12 alert alert-warning">
		<p>
			Al modificar los días de subsanación podra escoger si desea habilitarlos entre los últimos (0 a 5) días del mes que termina, y/o los primeros (0 a 5) días del mes que comienza.<br>
		</p>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-md-6">
		<label for="IN_ultimos_xx_dias">Últimos días del mes</label>
		<input type="number" class="form-control" id="IN_ultimos_xx_dias" value="<?php echo $dias_subsanacion[0]['FK_Value'] ?>" min="0" max="5" placeholder="Últimos días del mes">
	</div>
	<div class="col-xs-6 col-md-6">
		<label for="IN_primeros_xx_dias">Primeros días del mes</label>
		<input type="number" class="form-control" id="IN_primeros_xx_dias" value="<?php echo $dias_subsanacion[1]['FK_Value'] ?>" min="0" max="5" placeholder="Primeros días del mes">
	</div>
</div>
<div class="row">
	<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
		<button class="btn btn-success form-control" id="BT_actualizar_dias_subsanacion">Guardar</button>
	</div>
</div>