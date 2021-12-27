<?php 
$return = "";
foreach ($this->getVariables()['grupos'] as $d)
{
	  $return .="<tr>";
	  $return .="<td style='background-color:  #D1F2EB;'>". $d['LUGAR']."</td>";
	  $return .="<td style='background-color:  #FEF9E7;'><center>". $d['GRUPOS']."</center></td>";
	  $return .="<td style='background-color:  #D4E6F1;'><center>". $d['EXPERIENCAS']."</center></td>";
	  $return .="<td style='background-color:  #FCF3CF;'><center>". $d['BENEFICIARIOS']."</center></td>";
	  $return .="</tr>";
}
echo $return;
?>
