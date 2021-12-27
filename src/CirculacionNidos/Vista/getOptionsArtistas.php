<?php foreach ($this->getVariables()['artista'] as $a): ?> 
  <option value='<?= $a['IDPERSONA'] ?>'><?= $a['PNOMBRE'] ?> <?= $a['SNOMBRE'] ?> <?= $a['PAPELLIDO'] ?> <?= $a['SAPELLIDO'] ?> </option>
<?php endforeach; ?>
