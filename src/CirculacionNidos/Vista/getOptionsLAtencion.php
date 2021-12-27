<?php foreach ($this->getVariables()['lugares'] as $l): ?> 
  <option value='<?= $l['Pk_Id_lugar_atencion'] ?>'><?= $l['VC_Nombre_Lugar'] ?></option>
<?php endforeach; ?>
<option value='999'>NUEVO LUGAR DE ATENCIÓN</option>