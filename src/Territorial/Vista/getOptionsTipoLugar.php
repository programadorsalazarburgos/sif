<?php foreach ($this->getVariables()['tipoLugares'] as $ts): ?>
  <option value='<?= $ts['Pk_Id_Lugar'] ?>'><?= $ts['Vc_Descripcion'] ?></option>
<?php endforeach; ?>
