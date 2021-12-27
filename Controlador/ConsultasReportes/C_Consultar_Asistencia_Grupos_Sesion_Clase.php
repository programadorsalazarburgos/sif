<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/ConsultasReportes/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'get_clanes':
				echo getOptionsClan();
				break;
			case 'get_grupos_arte_escuela':
				echo getOptionsGruposArteEscuelaUsuario($_POST['id_usuario']);
			break;
			case 'get_grupos_emprende_clan':
				echo getOptionsGruposEmprendeClanUsuario($_POST['id_usuario']);
				break;
			case 'get_grupos_arte_escuela_by_clan':
				echo getOptionsGruposArteEscuelaByClan($_POST['id_clan']);
			break;
			case 'get_grupos_emprende_clan_by_clan':
				echo getOptionsGruposEmprendeClanByClan($_POST['id_clan']);
				break;
			case 'get_grupos_laboratorio_clan_by_clan':
				echo getOptionsGruposLaboratorioClanByClan($_POST['id_clan']);
				break;
			case 'get_mes_asistencia_clase_grupo':
				if($_POST['tipo_grupo'] == 'arte_escuela'){
					echo getMesSesionesClaseGrupoArteEscuela($_POST['id_grupo']);
				}else if($_POST['tipo_grupo'] == 'emprende_clan'){
					echo getMesSesionesClaseGrupoEmprendeClan($_POST['id_grupo']);
				}else if($_POST['tipo_grupo'] == 'laboratorio_clan'){
					echo getMesSesionesClaseGrupoLaboratorioClan($_POST['id_grupo']);
				}
				break;
			case 'get_asistencia_clase_grupo':
				if($_POST['tipo_grupo'] == 'arte_escuela'){
					echo getTableAsistenciasSesionesClaseArteEscuela($_POST['id_grupo'],$_POST['mes_anio'],null,null);
				}else if($_POST['tipo_grupo'] == 'emprende_clan'){
					echo getTableAsistenciasSesionesClaseEmprendeClan($_POST['id_grupo'],$_POST['mes_anio'],null,null);
				}else if($_POST['tipo_grupo'] == 'laboratorio_clan'){
					echo getTableAsistenciasSesionesClaseLaboratorioClan($_POST['id_grupo'],$_POST['mes_anio'],null,null); 
				}
				break;
			case 'get_asistencia_clase_grupo_usuario':
				if($_POST['tipo_grupo'] == 'arte_escuela'){
					echo getTableAsistenciasSesionesClaseArteEscuela($_POST['id_grupo'],$_POST['mes_anio'],$_POST['id_usuario'],$_POST['id_organizacion']);
				}else if($_POST['tipo_grupo'] == 'emprende_clan'){
					echo getTableAsistenciasSesionesClaseEmprendeClan($_POST['id_grupo'],$_POST['mes_anio'],$_POST['id_usuario']);
				}else if($_POST['tipo_grupo'] == 'laboratorio_clan'){
					echo getTableAsistenciasSesionesClaseLaboratorioClan($_POST['id_grupo'],$_POST['mes_anio'],$_POST['id_usuario']);
				} 
				break;				
			case 'get_encabezados_sesiones_asistencia_clase_grupo':
				if($_POST['tipo_grupo'] == 'arte_escuela'){ 
					echo getEncabezadosTableAsistenciasAllSesionesClaseArteEscuela($_POST['id_grupo'],$_POST['mes_anio'],null,$_POST['id_organizacion']);
				}else if($_POST['tipo_grupo'] == 'emprende_clan'){
					echo getEncabezadosTableAsistenciasAllSesionesClaseEmprendeClan($_POST['id_grupo'],$_POST['mes_anio'],null);
				}else if($_POST['tipo_grupo'] == 'laboratorio_clan'){
					echo getEncabezadosTableAsistenciasAllSesionesClaseLaboratorioClan($_POST['id_grupo'],$_POST['mes_anio'],null);
				}
				break;
			case 'get_encabezados_sesiones_asistencia_clase_grupo_usuario':
				if($_POST['tipo_grupo'] == 'arte_escuela'){
					echo getEncabezadosTableAsistenciasAllSesionesClaseArteEscuela($_POST['id_grupo'],$_POST['mes_anio'],$_POST['id_usuario'],$_POST['id_organizacion']);
				}else if($_POST['tipo_grupo'] == 'emprende_clan'){
					echo getEncabezadosTableAsistenciasAllSesionesClaseEmprendeClan($_POST['id_grupo'],$_POST['mes_anio'],$_POST['id_usuario']);
				}else if($_POST['tipo_grupo'] == 'laboratorio_clan'){
					echo getEncabezadosTableAsistenciasAllSesionesClaseLaboratorioClan($_POST['id_grupo'],$_POST['mes_anio'],$_POST['id_usuario']);
				}
				break;				
			default: 
				echo "opcion no valida en consultar asistencia grupos sesion clase: (".$_POST['opcion'].")";
				break;
		}
	}
	
	/***************************************************************************
	/* getOptionsClan() retorna en formato <option></option> los clanes registrados en el sistema.
	***************************************************************************/
	function getOptionsClan(){
		$clan = getClanes();
		$return = "";
		foreach ($clan as $c) {
			$return .= "<option value='".$c['PK_Id_Clan']."'>".$c['VC_Nom_Clan']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getOptionsGruposArteEscuelaUsuario() muestra en formato <option></option> los grupos de arte en la escuela activos, que tiene asignado un artista formador
	***************************************************************************/
	function getOptionsGruposArteEscuelaUsuario($id_usuario){
		$return = "<optgroup label='Arte En La Escuela'>";
		$grupo = getGruposActivosArteEscuelaByUsuario($id_usuario);
		foreach ($grupo as $g){
			$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='arte_escuela'>AE-".$g['PK_Grupo']."</option>";
		}
		$return .= "</optgroup>";
		return $return;
	}

	/***************************************************************************
	/* getOptionsGruposEmprendeClanUsuario() muestra en formato <option></option> los grupos de emprende clan activos, que tiene asignado un artista formador
	***************************************************************************/
	function getOptionsGruposEmprendeClanUsuario($id_usuario){
		$return = "<optgroup label='Emprende Clan'>";
		$grupo = getGruposActivosEmprendeClanByUsuario($id_usuario);
		foreach ($grupo as $g){
			$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='emprende_clan'>EC-".$g['PK_Grupo']."</option>";
		}
		$return .= "</optgroup>";
		return $return;
	}

	/***************************************************************************
	/* getMesSesionesClaseGrupoArteEscuela() muestra en formato <option></option> los meses de clase en que se han registrado sesiones de clase de asistencia para un grupo especifico de la línea de atención arte en la escuela
	***************************************************************************/
	function getMesSesionesClaseGrupoArteEscuela($id_grupo){
		$mostrar = "";
		$mes = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		$mes_sesion_clase = getMesAnioSesionClaseGrupoArteEscuela($id_grupo);
		foreach ($mes_sesion_clase as $m) {
			$mostrar .= "<option value='".$m['ANIO']."-".($m['MES'] < 10? '0' : '').$m['MES']."'>".$mes[$m['MES'] - 1]." de ".$m['ANIO']."</option>";
		}
		return $mostrar;
	}

	function getTableAsistenciasSesionesClaseArteEscuela($id_grupo,$mes_anio,$id_usuario,$id_organizacion){

		$mostrar = "<table class='table' id='table_asistencia'> 
					";

		$mostrar.= getEncabezadosTableAsistenciasAllSesionesClaseArteEscuela($id_grupo,$mes_anio,$id_usuario,$id_organizacion);					
		$mostrar.=" <tbody>";

		if($id_usuario!=null) //Trae los actuales + historico
			$estudiante = getEstudiantesGrupoArteEscuela($id_grupo,$mes_anio);
		else
			$estudiante = getEstudiantesGrupoArteEscuelaHistorico($id_grupo,$mes_anio);

		$sesion_clase = getAllSesionClaseGrupoArteEscuela($id_grupo,$mes_anio,$id_usuario,$id_organizacion);
		foreach ($estudiante as $e) {
			$mostrar .= "<tr>";
			$mostrar .= "<td>".$e['IN_Identificacion']."</td>";
			$mostrar .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']." ".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
			foreach ($sesion_clase as $sc) {
				$mostrar .= "<td class='text-center'>".consultarEstadoAsistenciaEstudianteGrupoArteEscuela($e['FK_estudiante'],$sc['PK_sesion_clase'])."</td>";
			}
			$mostrar .= "</tr>";
		}

		$mostrar .= "<tr>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";

		foreach ($sesion_clase as $sc) { 
			$mostrar .= "<td class='text-center'><button class=' btn btn-secondary pop_over ver_anexo' data-toggle='popover' data-vc_anexo='".$sc['VC_anexo']."' title='Ver Anexo' data-content='".$sc['TX_observaciones']."' data-placement='top'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button></td>";
		}
		$mostrar .= "</tr>";
		$mostrar.= "	</tbody>
					</table>"; 
		return $mostrar;
	}

	function consultarEstadoAsistenciaEstudianteGrupoArteEscuela($id_estudiante,$id_sesion_clase){
		$return = "";
		$estado_asistencia = getEstadoAsistenciaEstudianteGrupoArteEscuela($id_estudiante,$id_sesion_clase);

		if(!empty($estado_asistencia)){
			$estado_asistencia = $estado_asistencia[0];
			if($estado_asistencia == 1){
				$return = '<span title="SÍ Asistió" class="glyphicon glyphicon-ok" aria-hidden="true">SÍ</span>';
			}else if($estado_asistencia == 0){
				$return = '<span title="NO Asistió" class="glyphicon glyphicon-remove" aria-hidden="true">NO</span>';
			}
		}else{
			// $return = '<span title="No Registra" class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">N/R</span>';
			$return = '<span title="No Registra" class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">N0</span>';
		}
		return $return;
	}

	/***************************************************************************
	/* getMesSesionesClaseGrupoEmprendeClan() muestra en formato <option></option> los meses de clase en que se han registrado sesiones de clase de asistencia para un grupo especifico de la línea de atención emprende clan
	***************************************************************************/
	function getMesSesionesClaseGrupoEmprendeClan($id_grupo){
		$mostrar = "";
		$mes = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		$mes_sesion_clase = getMesAnioSesionClaseGrupoEmprendeClan($id_grupo);
		foreach ($mes_sesion_clase as $m) {
			$mostrar .= "<option value='".$m['ANIO']."-".($m['MES'] < 10? '0' : '').$m['MES']."'>".$mes[$m['MES'] - 1]." de ".$m['ANIO']."</option>";
		}
		return $mostrar;
	}

	/***************************************************************************
	/* getMesSesionesClaseGrupoLaboratorioClan() muestra en formato <option></option> los meses de clase en que se han registrado sesiones de clase de asistencia para un grupo especifico de la línea de atención laboratorio clan
	***************************************************************************/
	function getMesSesionesClaseGrupoLaboratorioClan($id_grupo){
		$mostrar = "";
		$mes = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		$mes_sesion_clase = getMesAnioSesionClaseGrupoLaboratorioClan($id_grupo);
		foreach ($mes_sesion_clase as $m) {
			$mostrar .= "<option value='".$m['ANIO']."-".($m['MES'] < 10? '0' : '').$m['MES']."'>".$mes[$m['MES'] - 1]." de ".$m['ANIO']."</option>";
		}
		return $mostrar;
	}

	function getTableAsistenciasSesionesClaseEmprendeClan($id_grupo,$mes_anio,$id_usuario){
		$mostrar = "<table class='table' id='table_asistencia'> 
					";

		$mostrar.= getEncabezadosTableAsistenciasAllSesionesClaseEmprendeClan($id_grupo,$mes_anio,$id_usuario);
		$mostrar.=" <tbody>";

		if($id_usuario!=null)
			$estudiante = getEstudiantesGrupoEmprendeClan($id_grupo,$mes_anio);
		else
			$estudiante = getEstudiantesGrupoEmprendeClanHistorico($id_grupo,$mes_anio);
		$sesion_clase = getAllSesionClaseGrupoEmprendeClan($id_grupo,$mes_anio,$id_usuario);
		
		foreach ($estudiante as $e) {
			$mostrar .= "<tr>";
			$mostrar .= "<td>".$e['IN_Identificacion']."</td>";
			$mostrar .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']." ".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
			foreach ($sesion_clase as $sc) {
				$mostrar .= "<td class='text-center'>".consultarEstadoAsistenciaEstudianteGrupoEmprendeClan($e['FK_estudiante'],$sc['PK_sesion_clase'])."</td>";
			}
			$mostrar .= "</tr>";

		}

		$mostrar .= "<tr>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";

		foreach ($sesion_clase as $sc) {
			$mostrar .= "<td class='text-center'><button class=' btn btn-secondary pop_over ver_anexo' data-toggle='popover' data-vc_anexo='".$sc['VC_anexo']."' title='Ver Anexo' data-content='".$sc['TX_observaciones']."' data-placement='top'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button></td>";
		}
		$mostrar .= "</tr>";
		$mostrar.= "	</tbody>
					</table>";
		return $mostrar;
	}

	function getTableAsistenciasSesionesClaseLaboratorioClan($id_grupo,$mes_anio,$id_usuario){
		
		$mostrar = "<table class='table' id='table_asistencia'> 
					";
		$mostrar.= getEncabezadosTableAsistenciasAllSesionesClaseLaboratorioClan($id_grupo,$mes_anio,$id_usuario);
		$mostrar.=" <tbody>";		
		if($id_usuario!=null)
			$estudiante = getEstudiantesGrupoLaboratorioClan($id_grupo,$mes_anio);
		else
			$estudiante = getEstudiantesGrupoLaboratorioClanHistorico($id_grupo,$mes_anio);
		$sesion_clase = getAllSesionClaseGrupoLaboratorioClan($id_grupo,$mes_anio,$id_usuario);
		
		foreach ($estudiante as $e) { 
			$mostrar .= "<tr>";
			$mostrar .= "<td>".$e['IN_Identificacion']."</td>";
			$mostrar .= "<td>".$e['Tipo_Identificacion']."</td>";
			$mostrar .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']." ".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
			$mostrar .= "<td>".$e['DD_F_Nacimiento']."</td>";
			$mostrar .= "<td>".$e['CH_Genero']."</td>";
			$mostrar .= "<td>".$e['FK_Grupo_Poblacional']."</td>";
			$mostrar .= "<td>".$e['TX_Tipo_Afiliacion']."</td>";
			$mostrar .= "<td>".$e['sisben']."</td>";
			$mostrar .= "<td>".$e['VC_Telefono']."</td>";
			$mostrar .= "<td>".$e['VC_Correo']."</td>";
			foreach ($sesion_clase as $sc) {
				$mostrar .= "<td class='text-center'>".consultarEstadoAsistenciaEstudianteGrupoLaboratorioClan($e['FK_estudiante'],$sc['PK_sesion_clase']);

				//$mostrar .="<table><thead><th>Lugar Atención</th><th>Tipo Grupo</th><th>AF</th><th>Asistencia</th></thead><tbody><tr><td>".$sc['lugar_atencion']."</td><td>".$sc['nombre_tipo_grupo']."</td><td>".$sc['af']."</td><td>".consultarEstadoAsistenciaEstudianteGrupoLaboratorioClan($e['FK_estudiante'],$sc['PK_sesion_clase'])."</td></tr></tbody></table>";

				$mostrar .="</td>";
			}
			$mostrar .= "</tr>";

		}

		$mostrar .= "<tr>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";
		$mostrar .= "<td></td>";

		foreach ($sesion_clase as $sc) {
			$mostrar .= "<td class='text-center'><button class=' btn btn-secondary pop_over ver_anexo' data-toggle='popover' data-vc_anexo='".$sc['VC_anexo']."' title='Ver Anexo' data-content='".$sc['TX_observaciones']."' data-placement='top'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button></td>";
		}
		$mostrar .= "</tr>";
		$mostrar.= "	</tbody> 
					</table><hr><h2>Detalle de la sesiónes de clase</h2><hr>";


		$mostrar.= "<table class='table table-hover' id='table_detalle_sesion'>
						<thead>
							<th>Fecha de sesión</th>
							<th>Lugar Atención</th>
							<th>Tipo Grupo</th>
							<th>AF</th>
							<th>Observacion</th>
						</thead>
						<tbody>";
		foreach ($sesion_clase as $sc) {
			$mostrar.= "<tr>
						<td>".$sc['DA_fecha_clase']."</td>
						<td>".$sc['lugar_atencion']."</td>
						<td>".$sc['nombre_tipo_grupo']."</td>
						<td>".$sc['af']."</td>
						<td>".$sc['TX_observaciones']."</td>
					</tr>";
		}						

		$mostrar.= "	</tbody>
					</table>";	 	
		return $mostrar;
	}

	function consultarEstadoAsistenciaEstudianteGrupoEmprendeClan($id_estudiante,$id_sesion_clase){
		$return = "";
		$estado_asistencia = getEstadoAsistenciaEstudianteGrupoEmprendeClan($id_estudiante,$id_sesion_clase);
		
		if(!empty($estado_asistencia)){
			$estado_asistencia = $estado_asistencia[0];
			if($estado_asistencia == 1){
				$return = '<span title="SÍ Asistió" class="glyphicon glyphicon-ok" aria-hidden="true">SÍ</span>';
			}else if($estado_asistencia == 0){
				$return = '<span title="NO Asistió" class="glyphicon glyphicon-remove" aria-hidden="true">NO</span>';
			}
		}else{
			// $return = '<span title="No Registra" class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">N/R</span>';
			$return = '<span title="No Registra" class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">N0</span>';
		}
		return $return;
	}

	function consultarEstadoAsistenciaEstudianteGrupoLaboratorioClan($id_estudiante,$id_sesion_clase){
		$return = "";
		$estado_asistencia = getEstadoAsistenciaEstudianteGrupoLaboratorioClan($id_estudiante,$id_sesion_clase);
		
		if(!empty($estado_asistencia)){
			$estado_asistencia = $estado_asistencia[0];
			if($estado_asistencia == 1){
				$return = '<span title="SÍ Asistió" class="glyphicon glyphicon-ok" aria-hidden="true">SÍ</span>';
			}else if($estado_asistencia == 0){
				$return = '<span title="NO Asistió" class="glyphicon glyphicon-remove" aria-hidden="true">NO</span>';
			}
		}else{
			$return = '<span title="No Registra" class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">N0</span>';
			// $return = '<span title="No Registra" class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">N/R</span>';
		}
		return $return;
	}

	function getEncabezadosTableAsistenciasAllSesionesClaseArteEscuela($id_grupo,$mes_anio,$id_usuario,$id_organizacion){
		$mostrar = "";
		$sesion_clase = getAllSesionClaseGrupoArteEscuela($id_grupo,$mes_anio,$id_usuario,$id_organizacion);


		$mostrar .= "<thead>
					 <th style='text-align: center;'> Identificación</th>";
		$mostrar .= "<th style='text-align: center;'> Nombre del Estudiante</th>";

		foreach ($sesion_clase as $sc) {
			$mostrar .= "<th style='text-align: center;'>".explode("-",$sc['DA_fecha_clase'])[2].'/'.explode("-",$sc['DA_fecha_clase'])[1].'/'.explode("-",$sc['DA_fecha_clase'])[0].' ('.$sc['FORMADOR'].")</th>";
		}
		$mostrar .= "</thead>";
		$mostrar .= "<colgroup><col style='width: 10%;'>";
		$mostrar .= "<col style='width: 30%;'>";
		$ancho_columna_asistencia = 60/sizeof($sesion_clase);
		foreach ($sesion_clase as $sc) {
			$mostrar .= "<col style='width: ".$ancho_columna_asistencia."%;'>";
		}
		$mostrar .= "</colgroup>";
		return $mostrar;
	}

	function getEncabezadosTableAsistenciasAllSesionesClaseEmprendeClan($id_grupo,$mes_anio,$id_usuario){
		$mostrar = "";
		$sesion_clase = getAllSesionClaseGrupoEmprendeClan($id_grupo,$mes_anio,$id_usuario);


		$mostrar .= "<thead>";
		$mostrar .= "<th style='text-align: center;'> Identificación</th>";
		$mostrar .= "<th style='text-align: center;'> Nombre del Estudiante</th>";

		foreach ($sesion_clase as $sc) {
			$mostrar .= "<th style='text-align: center;'>".explode("-",$sc['DA_fecha_clase'])[2].'/'.explode("-",$sc['DA_fecha_clase'])[1].'/'.explode("-",$sc['DA_fecha_clase'])[0].' ('.$sc['FORMADOR'].")</th>";
		}
		$mostrar .= "</thead>"; 
		$mostrar .= "<colgroup><col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 30%; border:1px solid black;'>";
		$ancho_columna_asistencia = 60/sizeof($sesion_clase);
		foreach ($sesion_clase as $sc) {
			$mostrar .= "<col style='width: ".$ancho_columna_asistencia."%; border:1px solid black;'>";
		}
		$mostrar .= "</colgroup>";
		return $mostrar;
	}

	function getEncabezadosTableAsistenciasAllSesionesClaseLaboratorioClan($id_grupo,$mes_anio,$id_usuario){
		$mostrar = "";
		$sesion_clase = getAllSesionClaseGrupoLaboratorioClan($id_grupo,$mes_anio,$id_usuario);

		$mostrar .= "<thead>";
		$mostrar .= "<th style='text-align: center;'> Identificación</th>";
		$mostrar .= "<th style='text-align: center;'> Tipo Identificación</th>";
		$mostrar .= "<th style='text-align: center;'> Nombre del Estudiante</th>";
		$mostrar .= "<th style='text-align: center;'> Fecha de Nacimiento</th>";
		$mostrar .= "<th style='text-align: center;'> Genero</th>";
		$mostrar .= "<th style='text-align: center;'> Grupo Poblacional</th>";
		$mostrar .= "<th style='text-align: center;'> Tipo de Afiliación</th>";
		$mostrar .= "<th style='text-align: center;'> Sisben</th>";
		$mostrar .= "<th style='text-align: center;'> Telefono</th>";
		$mostrar .= "<th style='text-align: center;'> Correo Electronico</th>";

		foreach ($sesion_clase as $sc) {
			$mostrar .= "<th style='text-align: center;'>".explode("-",$sc['DA_fecha_clase'])[2]."</th>";
		}
		$mostrar .= "</thead>";

		$mostrar .= "<colgroup><col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 10%; border:1px solid black;'>";

		$ancho_columna_asistencia = 60/sizeof($sesion_clase);
		foreach ($sesion_clase as $sc) {
			$mostrar .= "<col style='width: ".$ancho_columna_asistencia."%; border:1px solid black;'>";
		}
		$mostrar .= "</colgroup>";
		return $mostrar;
	}

	function getEncabezadosTableAsistenciasSesionesClaseEmprendeClan($id_grupo){
		$mostrar = "";
		$sesion_clase = getSesionClaseGrupoEmprendeClan($id_grupo);

		$mostrar .= "<tr>";
		$mostrar .= "<th class='text-center'> Identificación Estudiante</th>";
		$mostrar .= "<th class='text-center'> Nombre del Estudiante</th>";

		foreach ($sesion_clase as $sc) {
			$mostrar .= "<th class='text-center'>".$sc['DA_fecha_clase']."</th>";
		}
		$mostrar .= "</tr>";

		return $mostrar;
	}

	function getOptionsGruposArteEscuelaByClan($id_clan){
		$return = "<optgroup label='Arte En La Escuela'>";
		$grupo = getGruposArteEscuelaByClan($id_clan); 
		foreach ($grupo as $g){
			$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='arte_escuela'>AE-".$g['PK_Grupo']."</option>";
		}
		$return .= "</optgroup>";
		return $return;
	}

	function getOptionsGruposEmprendeClanByClan($id_clan){
		$return = "<optgroup label='Emprende clan'>";
		$grupo = getGruposEmprendeClanByClan($id_clan); 
		foreach ($grupo as $g){
			$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='emprende_clan'>EC-".$g['PK_Grupo']."</option>";
		}
		$return .= "</optgroup>";
		return $return;
	}

	function getOptionsGruposLaboratorioClanByClan($id_clan){
		$return = "<optgroup label='Laboratorio CREA'>";
		$grupo = getGruposLaboratorioClanByClan($id_clan); 
		foreach ($grupo as $g){
			$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='laboratorio_clan'>LC-".$g['PK_Grupo']."</option>";
		}
		$return .= "</optgroup>";
		return $return;
	}
?>