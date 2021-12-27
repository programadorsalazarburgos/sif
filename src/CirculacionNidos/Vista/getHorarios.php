<?php foreach ($this->getVariables()['horarios'] as $h): ?>
  <option value='<?= $h['Id'] ?>'><?= $h['Horario'] ?></option>
<?php endforeach; ?>