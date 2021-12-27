<?php foreach ($this->getVariables()['Artistas'] as $ts): ?>
  <option value='<?= $ts['PK_Id_Persona'] ?>'><?= $ts['VC_Primer_Nombre'] ?> <?= $ts['VC_Segundo_Nombre'] ?> <?= $ts['VC_Primer_Apellido'] ?> <?= $ts['VC_Segundo_Apellido'] ?></option>
<?php endforeach; ?>
