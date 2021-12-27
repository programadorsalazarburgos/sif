<?php foreach ($this->getVariables()['Territorio'] as $ts): ?>
	    <option value='<?= $ts['Pk_Id_Territorio'] ?>'><?= $ts['Vc_Nom_Territorio'] ?></option>
<?php endforeach; ?>
