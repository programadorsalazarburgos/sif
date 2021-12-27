<?php foreach ($this->getVariables()['MesParametro'] as $m): ?>
  <option value='<?= $m['Fk_Value'] ?>'><?= $m['VC_Descripcion'] ?></option>
<?php endforeach; ?>
