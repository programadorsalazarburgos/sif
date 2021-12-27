<?php foreach ($this->getVariables()['TipoEvento'] as $t): ?>
  <option value='<?= $t['FK_Value'] ?>'><?= $t['VC_Descripcion'] ?></option>
<?php endforeach; ?>