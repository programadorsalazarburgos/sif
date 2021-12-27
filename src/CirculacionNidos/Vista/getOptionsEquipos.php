<?php foreach ($this->getVariables()['equipos'] as $e): ?> 
  <option value='<?= $e['Pk_Id_Dupla'] ?>'><?= $e['VC_Codigo_Dupla'] ?> -- (<?= $e['ARTISTAS'] ?>)</option>
<?php endforeach; ?>
