<?php foreach ($this->getVariables()['Territorio'] as $t): ?>
  <option value='<?= $t['Pk_Id_Territorio'] ?>'><?= $t['Vc_Nom_Territorio'] ?></option>
<?php endforeach; ?>
