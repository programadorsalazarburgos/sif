<?php foreach ($this->getVariables()['Territorios'] as $d): ?>
  <option value='<?= $d['Pk_Id_Territorio'] ?>'><?= $d['Vc_Nom_Territorio'] ?></option>
<?php endforeach; ?>
