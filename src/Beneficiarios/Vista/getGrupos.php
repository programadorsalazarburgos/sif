<?php foreach ($this->getVariables()['grupos'] as $g): ?>
  <option value='<?= $g['Pk_Id_Grupo'] ?>'><?= $g['VC_Nombre_Grupo'] ?></option>
<?php endforeach; ?>
