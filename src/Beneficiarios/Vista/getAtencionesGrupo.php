<?php foreach ($this->getVariables()['experiencias'] as $e): ?>
  <option value='<?= $e['Pk_Id_Experiencia'] ?>'><?= $e['VC_Nombre_Experiencia'] ?> (<?= $e['DT_Fecha_Encuentro'] ?> DE <?= $e['HR_Hora_Inicio'] ?> A <?= $e['HR_Hora_Finalizacion'] ?> )</option>
<?php endforeach; ?>
