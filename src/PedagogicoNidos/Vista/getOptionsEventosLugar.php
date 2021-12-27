<?php foreach ($this->getVariables()['Eventos'] as $lp): ?>
  <option value='<?= $lp['Pk_Id_Fortalecimiento'] ?>'><?= $lp['Vc_Nom_Evento'] ?></option>
<?php endforeach; ?>
<option style="color: #0E6655; background-color: #A9DFBF;" value='1'><strong>NUEVO EVENTO</strong></option>
