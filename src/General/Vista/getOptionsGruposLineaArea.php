<?php foreach ($this->getVariables()['grupos'] as $g): ?>
  <option value='<?= $g['FK_grupo'] ?>'><?= $g['Nombre'] ?></option>
<?php endforeach; ?>
