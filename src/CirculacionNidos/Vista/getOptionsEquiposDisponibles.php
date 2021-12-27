<?php 
$disponible = $this->getVariables()['disponible'];
for ($i = 1; $i <= $disponible; $i++) { ?> 
  <option value='<?= $i?>'><?= $i?> </option>
<?php } ?> 