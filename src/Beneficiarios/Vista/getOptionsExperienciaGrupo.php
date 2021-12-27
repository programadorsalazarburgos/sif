<option value="1" style="background-color: green;"><label style="background-color: white;"> Crear Experiencia</label></option>
<?php foreach ($this->getVariables()['experiencia'] as $l): ?>  
  <option value='<?= $l['Pk_Id_Experiencia'] ?>'><?= $l['VC_Nombre_Experiencia'] ?> (<?= $l['DT_Fecha_Encuentro'] ?>)</option>
<?php endforeach; ?>
+