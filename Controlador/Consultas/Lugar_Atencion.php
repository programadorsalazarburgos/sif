 <?php
session_start();
if(!isset($_SESSION["session_username"])) {
 header("location:../../index.php");
} else { 
  
$NClases = $_GET["id"];
?>

<div id="Atencion">
<?php

 if ($NClases == "Clan"){

?>
<table width="100%" border="0">
  <tr>
    <td width="44%"><div class="col-lg-10">Sal&oacute;n: </div></td>
    <td width="56%"><div class="col-lg-10">
	  <select class="form-control" id="TB_Salon" name="TB_Salon">
        <option value="1">Salon 1</option>
        <option value="2">Salon 2</option>
        <option value="3">Salon 3</option>
        <option value="4">Salon 4</option>
      </select>
    </div></td>
  </tr>
</table>
<?php } ?>
</div>
<?php }  ?>
