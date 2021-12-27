<?php foreach ($this->getVariables()['duplas'] as $d): ?>
  <option value='<?= $d['Id'] ?>'><?= $d['Dupla'] ?></option>
<?php endforeach; ?>