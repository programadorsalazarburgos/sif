<?php foreach ($this->getVariables()['tipoDuplas'] as $ts): ?>
  <option value='<?= $ts['Pk_Id_Tipo_dupla'] ?>'><?= $ts['Vc_Descripcion'] ?></option>
<?php endforeach; ?>
