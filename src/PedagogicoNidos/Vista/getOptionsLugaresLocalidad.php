<?php foreach ($this->getVariables()['LPedagogico'] as $lp): ?>
  <option value='<?= $lp['Pk_Id_lugar_pedagogico'] ?>'><?= $lp['VC_Nombre_Lugar'] ?></option>
<?php endforeach; ?>
