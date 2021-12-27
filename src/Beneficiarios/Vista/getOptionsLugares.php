<?php foreach ($this->getVariables()['lugares'] as $l): ?> 
  <option value='<?= $l['Pk_Id_lugar_atencion'] ?>'><?= $l['VC_Nom_Localidad'] ?> --> <?= $l['VC_Nombre_Lugar'] ?></option>
<?php endforeach; ?>