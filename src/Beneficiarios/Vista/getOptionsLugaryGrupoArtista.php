<?php foreach ($this->getVariables()['LugaryGrupo'] as $lg): ?>
  <option value='<?= $lg['Pk_Id_Grupo'] ?>'><?= $lg['VC_Nombre_Lugar'] ?> -- (<?= $lg['VC_Nombre_Grupo'] ?>)</option>
<?php endforeach; ?>
