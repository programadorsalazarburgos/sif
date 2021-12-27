<?php foreach ($this->getVariables()['Localidades'] as $d): ?>
  <option value='<?= $d['FK_Value'] ?>'><?= $d['VC_Descripcion'] ?></option>
<?php endforeach; ?>