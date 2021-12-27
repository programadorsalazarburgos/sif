    <option value='0'>Seleccione un Tipo de Soporte</option>
    <?php foreach ($this->getVariables()['tipoSoportes'] as $ts): ?>
	    <option value='<?= $ts['PK_tipo_soporte'] ?>'><?= $ts['VC_descripcion'] ?></option>
    <?php endforeach; ?> 