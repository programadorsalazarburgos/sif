<?php foreach ($this->getVariables()['Duplas'] as $ds): ?>
	    <option value='<?= $ds['Pk_Id_Dupla'] ?>'><?= $ds['VC_Codigo_Dupla'] ?></option>
<?php endforeach; ?>
