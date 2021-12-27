<?php foreach ($this->getVariables()['usuarios'] as $u): ?>
  <option value='<?= $u['PK_Id_Persona'] ?>'><?= $u['Nombre'] ?></option>
<?php endforeach; ?>
