<?php foreach ($this->getVariables()['estrategias'] as $e): ?>
  <option value='<?= $e['Pk_Id_Estrategia'] ?>'><?= $e['Vc_Estrategia'] ?></option>
<?php endforeach; ?>
