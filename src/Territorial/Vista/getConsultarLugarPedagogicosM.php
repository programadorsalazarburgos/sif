    <?php foreach ($this->getVariables()['ConsultaLugarM'] as $ts): ?>
	    <option value='<?= $ts['Pk_Id_lugar_pedagogico'] ?>'><?= $ts['VC_Nombre_Lugar'] ?></option>
    <?php endforeach; ?>
