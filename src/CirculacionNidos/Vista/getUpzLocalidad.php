<?php foreach ($this->getVariables()['upz'] as $a): ?> 
  <option value='<?= $a['CODIGO'] ?>'><?= $a['CODIGO'] ?>- <?= $a['NOMBREUPZ'] ?></option>
<?php endforeach; ?>