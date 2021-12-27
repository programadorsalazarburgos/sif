<?php foreach ($this->getVariables()['Entidades'] as $ts): ?>
  <option value='<?= $ts['Pk_Id_Entidad'] ?>'><?= $ts['Vc_Nom_Entidad'] ?></option>
<?php endforeach; ?>
