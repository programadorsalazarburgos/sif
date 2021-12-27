<?php foreach ($this->getVariables()['duplas'] as $d): ?>
	    <option value='<?= $d['Pk_Id_Dupla'] ?>'><?= $d['Dupla'] ?></option>
<?php endforeach; ?>
