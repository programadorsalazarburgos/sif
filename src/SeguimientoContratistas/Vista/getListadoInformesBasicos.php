<?php
$return = "";
foreach ($this->getVariables()['arrayInformes'] as $informe)
{
	$return .="<tr>";
	foreach ($informe as $columna => $valor)
		$return .="<td>".$valor."</td>";
	$return .="<td><a href='#' data-informe_id='".$informe['PK_Id_Tabla']."' data-fk_persona='".$informe['FK_Persona']."' data-tipo='informe'  class='editar_informe form-control btn btn-primary' data-placement='top' data-toggle='tooltip' title='Editar'><i class='fa fa-edit'></i></a></td>";
	$return .="</tr>";
}
echo $return;