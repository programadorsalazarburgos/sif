<?

$firmas = $this->getVariables()['firmas'];
$return = '
<table class="table table-hover" cellspacing="0" width="100%"  >
	<thead>
		<tr>
			<th><strong>Id</strong></th>            
			<th><strong>Persona</strong></th> 
			<th><strong>Rol</strong></th>  
			<th><strong>Token</strong></th>  
			<th><strong>Fecha</strong></th>                     
		</tr>
	</thead>
	<tbody>';

foreach($firmas as $firma)
{
	$return .= '
	<tr>
		<td>'.$firma['id_informe'].'</td>            
		<td>'.$firma['persona'].'</td> 
		<td>'.$firma['rol'].'</td>  
		<td>'.$firma['token'].'</td>  
		<td>'.$firma['fecha'].'</td>                    
	</tr>		
	';		
}																																																	
$return .= '    
	</tbody>											
</table>
';


$html = $return;
