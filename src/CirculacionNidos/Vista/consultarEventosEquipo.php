<?php foreach ($this->getVariables()['EventosEquipo'] as $e): ?>
  <option value='<?= $e['Pk_Id_Evento'] ?>'><?= $e['Evento'] ?></option>
<?php endforeach; ?>