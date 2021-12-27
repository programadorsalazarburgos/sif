<?php
	header ('Content-type: text/html; charset=utf-8');
	session_start();
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	require_once ("../../Controlador/ReportePDF/C_ArtistaFormador_Mensual_Asistencia_Grupo.php");

	date_default_timezone_set('America/Bogota');
	$artista_formador = getDatosArtistaFormador($_GET['id_artista_formador']);
	$administrador_clan = getCoordinadorClanGrupo($_GET['tipo_grupo'],$_GET['id_grupo']);
	$datos_grupo = getAreaArtisticaGrupo($_GET['tipo_grupo'],$_GET['id_grupo'])[0];
	$codigo_verificacion = date('YmdHis').$_GET['id_artista_formador'];

	function dibujarCabeceraReporte($codigo,$version,$fecha){
		$mostrar = "<page_header>";
		$mostrar .= '<table cellspacing="0" style="width: 100%; border: solid 1px black;">
            	<col style="text-align:left;width: 20%;border:1px solid black;"></col>
            	<col style="text-align:left;width: 60%;border:1px solid black;"></col>
            	<col style="text-align:left;width: 20%;border:1px solid black;"></col>
            <tr>
                <td rowspan="3" align="center">
                	<img src="../imagenes/logo_alcaldia_bogota.jpg" alt="Escudo de bogotá" width="110" />
                </td>
                <td align="center">
                	<span style="font-size: 17px; font-weight: bold">
                		GESTIÓN PARA LA APROPIACIÓN DE LAS PRÁCTICAS ARTÍSTICAS
                	</span>
                </td>
                <td>
                	<span style="font-size: 12px; font-weight: bold">
                		Código: '.$codigo.'
                	</span>
                </td>
            </tr>
            <tr>
            	<td rowspan="2" align="center">
            		<span style="font-size: 17px; font-weight: bold">
            			REPORTE DE ASISTENCIA MENSUAL CREA'.(isset($_GET['suplencia'])? ' - SUPLENCIA' : '').'
            		</span>
            	</td>
                <td>
                	<span style="font-size: 12px; font-weight: bold">
            			Versión: '.$version.'
            		</span>
                </td>
            </tr>
            <tr>
            	<td>
            		<span style="font-size: 12px; font-weight: bold">
            			Fecha: '.$fecha.'
            		</span>
            	</td>
            </tr>
        </table>';
		$mostrar .= "</page_header>";
		return $mostrar;
	}

	function dibujarPiePaginaReporte(){
		global $artista_formador;
		$a = $artista_formador[0];
		$mostrar = '<page_footer>
	        <table style="width: 100%;">
	            <tr>
	                <td style="text-align:left;width: 85%">Reporte mensual de asistencias '.(isset($_GET['suplencia'])? ' POR SUPLENCIA' : '').' del artista formador: '.$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido'].'</td>
	                <td style="text-align:right;width: 15%">Página [[page_cu]] de [[page_nb]]</td>
	            </tr>
	        </table>
	    </page_footer>';
	    return $mostrar;
	}

	function dibujarDatosArtistaFormador(){
		global $artista_formador;
		global $datos_grupo;
		global $codigo_verificacion;
		$mostrar = "";
		$mostrar .= "<table cellspacing='0' style='width: 100%; border: solid 1px black;'>";
		$mostrar .= "<col style='width: 20%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 46%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 15%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 19%; border:1px solid black;'>";
		$mostrar .= "<tr>
			<td><strong>Código de Verificación</strong></td>
			<td colspan='3' align='center'>".$codigo_verificacion."</td>
		</tr>";
		switch ($_GET['tipo_grupo']) {
			case 'arte_escuela':
				$tipo_grupo_mostrar = "Arte en la escuela";
				$tipo_grupo_mostrar_corto = "AE";
				break;
			case 'emprende_clan':
				$tipo_grupo_mostrar = "Impulso Colectivo";
				$tipo_grupo_mostrar_corto = "EC";
				break;
			case 'laboratorio_clan':
				$tipo_grupo_mostrar = "Converge";
				$tipo_grupo_mostrar_corto = "LC";
				break;
			default:
				$tipo_grupo_mostrar = "Tipo grupo no valido";
				$tipo_grupo_mostrar_corto = "NV";
				break;
		}
		foreach ($artista_formador as $a) {
			$mostrar .= "<tr>
				<td><strong>Artista Formador:</strong></td>
				<td>".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']." "."</td>
				<td><strong>Identificación:</strong></td>
				<td>".$a['VC_Identificacion']."</td>
			</tr>
			<tr>
			<td><strong>Correo:</strong></td>
			<td>".$a['VC_Correo']."</td>
			<td><strong>Línea de atención:</strong></td>
			<td>".$tipo_grupo_mostrar."</td>
			</tr>
			<tr>
				<td><strong>Organización:</strong></td>
				<td>".getNombreOrganizacion($_GET['id_organizacion'])."</td>
				<td><strong>Área Artística:</strong></td>
				<td>".$datos_grupo['VC_Nom_Area']."</td>
			</tr>";
		}
		$mostrar .= "</table>";

		$mostrar .= "<br><table cellspacing='0' style='width: 100%; border: solid 1px black;'>
			<tr>
				<td style='width:16%; border: solid 1px solid black;'><strong>Grupo:</strong></td>
				<td style='width:17%; border: solid 1px solid black;'>".$tipo_grupo_mostrar_corto."-".$_GET['id_grupo']."</td>
				<td style='width:16%; border: solid 1px solid black;'><strong>Mes de reporte:</strong></td>
				<td style='width:17%; border: solid 1px solid black;'>".$_GET['mes_anio']."</td>
				<td style='width:16%; border: solid 1px solid black;'><strong>Fecha de reporte:</strong></td>
				<td style='width:18%; border: solid 1px solid black;'>".date('Y-m-d H:i:s')."</td>
			</tr>
			<tr>
				<td style='width:16%; border: solid 1px solid black;'><strong>Institución Educativa:</strong></td>
				<td colspan='5' style='width:17%; border: solid 1px solid black;'>".getColegioGrupo($_GET['id_grupo'],$_GET['tipo_grupo'])."</td>
			</tr>
		</table>";
		return $mostrar;
	}

	function dibujarSesionesClaseGrupo(){
		$sesion_clase = getSesionClaseGrupo($_GET['tipo_grupo'],$_GET['id_grupo'],$_GET['mes_anio'],$_GET['id_artista_formador'],$_GET['id_organizacion']);
		$mostrar = "<table cellspacing='0' style='width: 100%; border: solid 1px black;'>
		<col style='width: 12%; border:1px solid black;'>
		<col style='width: 12%; border:1px solid black;'>
		<col style='width: 12%; border:1px solid black;'>
		<col style='width: 40%; border:1px solid black;'>
		<col style='width: 12%; border:1px solid black;'>
		<col style='width: 12%; border:1px solid black;'>
		<tr>
			<td align='center'>N° Sesión</td>
			<td align='center'>Fecha Sesión</td>
			<td align='center'>Horas de Taller / Evento</td>
			<td align='center'>Observaciones</td>
			<td align='center'>Estudiantes matriculados</td>
			<td align='center'>Estudiantes con asistencia</td>
		</tr>";
		$total_horas = 0;
		for ($i=0; $i < sizeof($sesion_clase); $i++) {
			$hora_clase = getHorasClaseSesion($_GET['tipo_grupo'],$_GET['id_grupo'],$sesion_clase[$i]['PK_sesion_clase'])[0];

			$horas_sesion = RestarHoras($hora_clase['TI_hora_inicio_clase'],$hora_clase['TI_hora_fin_clase']);

			$mostrar .= "<tr>
				<td>".($i+1)."</td>
				<td>".$sesion_clase[$i]['DA_fecha_clase']."</td>
				<td>".$sesion_clase[$i]['IN_horas_clase']." horas.</td>
				<td>".$sesion_clase[$i]['TX_observaciones']."</td>
				<td align='center'>".getTotalEstudiantesSesionClase($_GET['tipo_grupo'],$sesion_clase[$i]['PK_sesion_clase'])."</td>
				<td align='center'>".getTotalEstudiantesAsistieronSesionClase($_GET['tipo_grupo'],$sesion_clase[$i]['PK_sesion_clase'])."</td>
			</tr>";
			$total_horas += $sesion_clase[$i]['IN_horas_clase'];
		}
		$datos_sesion_clase_evento = dibujarSesionesClaseEventoGrupo();
		$mostrar .= $datos_sesion_clase_evento[0];
		$mostrar .= "</table>";

		$mostrar .= "<p><b> Total horas sesiones clase: ".$total_horas."</b><br>";
		$mostrar .= "<b> Total horas sesiones clase evento: ".$datos_sesion_clase_evento[1]."</b></p>";
		return $mostrar;
	}

	function dibujarSesionesClaseEventoGrupo(){
		global $artista_formador;
		global $datos_grupo;
		global $codigo_verificacion;
		$total_horas_sesiones_clase_evento = 0;
		$sesion_clase = consultarSesionesClaseEventoMes($_GET['tipo_grupo'],$_GET['id_grupo'],$_GET['id_artista_formador'],$_GET['mes_anio']);
		$mostrar = "";
		foreach ($sesion_clase as $s) {
			$mostrar .= "<tr>
				<td>EV-".$s['FK_evento']."</td>
				<td>".$s['DA_fecha_sesion_clase']."</td>
				<td>".$s['IN_horas_clase']." horas.</td>
				<td>Evento <b>".$s['VC_Nombre']."</b> - ".$s['TX_Observaciones']."</td>
				<td align='center'>".consultarTotalEstudiantesSesionClaseEvento($s['PK_sesion_clase'])."</td>
				<td align='center'>".consultarTotalEstudiantesSesionClaseEventoSIAsistencia($s['PK_sesion_clase'])."</td>
			</tr>";
			$total_horas_sesiones_clase_evento += $s['IN_horas_clase'];
		}
		return [$mostrar,$total_horas_sesiones_clase_evento];

	}

	function RestarHoras($horaini,$horafin){
		$horai=substr($horaini,0,2);
		$mini=substr($horaini,3,2);
		$segi=substr($horaini,6,2);

		$horaf=substr($horafin,0,2);
		$minf=substr($horafin,3,2);
		$segf=substr($horafin,6,2);

		$ini=((($horai*60)*60)+($mini*60)+$segi);
		$fin=((($horaf*60)*60)+($minf*60)+$segf);

		$dif=$fin-$ini;

		$difh=floor($dif/3600);
		$difm=floor(($dif-($difh*3600))/60);
		$difs=$dif-($difm*60)-($difh*3600);
		return date("H:i",mktime($difh,$difm,$difs));
	}

	function dibujarNovedadesSesionesClaseGrupo(){
		$novedad = getNovedadesFormador($_GET['tipo_grupo'],$_GET['id_grupo'],$_GET['mes_anio'],$_GET['id_artista_formador']);
		$mostrar = "<table cellspacing='0' style='width: 100%; border: solid 1px black;'>
		<col style='width: 20%; border:1px solid black;'>
		<col style='width: 20%; border:1px solid black;'>
		<col style='width: 20%; border:1px solid black;'>
		<col style='width: 40%; border:1px solid black;'>
		<tr>
			<td align='center'>Fecha Sesión</td>
			<td align='center'>Asistencia</td>
			<td align='center'>Novedad</td>
			<td align='center'>Observación</td>
		</tr>";
		$mostrar .= $novedad;
		$mostrar .= "</table>";
		return $mostrar;
	}

	function dibujarAceptacionVeracidadInformacion(){
		global $artista_formador;
		global $administrador_clan;
		$a = $artista_formador[0];
		$mostrar = "<p>Yo ".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido'].", certifico que la información reportada en el presente formato es verdadera, correcta y corresponde exactamente a la asistencia reportada en los talleres artisticos programados.</p>";
		$mostrar .= "<p>Yo ".$administrador_clan[0]['VC_Primer_Nombre']." ".$administrador_clan[0]['VC_Segundo_Nombre']." ".$administrador_clan[0]['VC_Primer_Apellido']." ".$administrador_clan[0]['VC_Segundo_Apellido'].", certifico que he revisado la información reportada por el formador(a) ".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']." y valido la veracidad de la misma.</p><br>";
		return $mostrar;
	}

	function dibujarFirmas(){
		global $artista_formador;
		global $administrador_clan;
		$a = $artista_formador[0];
		$mostrar = "<p></p>";
		$mostrar .= "<p><table style='width: 100%;'>
			<tr>
				<td style='width:50%;'>
					------------------------------------------------------<br>
					".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']."
					<br>Firma Artista Formador(a)
				</td>
				<td style='width:50%;'>
					------------------------------------------------------<br>
					".$administrador_clan[0]['VC_Primer_Nombre']." ".$administrador_clan[0]['VC_Segundo_Nombre']." ".$administrador_clan[0]['VC_Primer_Apellido']." ".$administrador_clan[0]['VC_Segundo_Apellido']."
					<br>"."Firma Coordinador(a) ".($administrador_clan[0]['VC_Nom_Clan'])."
				</td>
			</tr>
		</table></p>";
		return $mostrar;
	};

	function dibujarDatosDetalleAsistenciaEstudiantes(){
		$detalle = "<table cellspacing='0' style='width: 100%; border: solid 1px black;'>";
		$detalle .= getEncabezadosTableAsistenciasSesionesClase($_GET['tipo_grupo'],$_GET['id_grupo'],$_GET['mes_anio'],$_GET['id_artista_formador'],$_GET['id_organizacion']);
		$detalle .= getTableAsistenciasSesionesClase($_GET['tipo_grupo'],$_GET['id_grupo'],$_GET['mes_anio'],$_GET['id_artista_formador'],$_GET['id_organizacion']);
		$detalle .= "</table>";
		$detalle .= "<br>";
		return $detalle;
	}

	function pintarPaginaVertical(){
		$mostrar = "<page backtop='28mm'>";
		$mostrar .= dibujarCabeceraReporte('2MI-GFOR-F-03','2','31/05/2018');
		$mostrar .= dibujarDatosArtistaFormador();
		$mostrar .= "<p>Listado detallado de las sesiones de clase dictadas ".(isset($_GET['suplencia'])? ' POR SUPLENCIA' : '')." en el mes ".$_GET['mes_anio']." :</p>";
		$mostrar .= dibujarSesionesClaseGrupo();
		$mostrar .= "<p>Listado detallado de novedades del artista formador sobre las sesiones de clase dictadas ".(isset($_GET['suplencia'])? ' POR SUPLENCIA' : '')." en el mes ".$_GET['mes_anio']." :</p>";
		$mostrar .= dibujarNovedadesSesionesClaseGrupo();
		$mostrar .= dibujarAceptacionVeracidadInformacion();
		$mostrar .= dibujarFirmas();
		$mostrar .=dibujarPiePaginaReporte();
		$mostrar .= "</page>";
		return $mostrar;
	}

	function pintarPaginaHorizontal(){
		$mostrar = "<page orientation='paysage' backtop='28mm'>";
		$mostrar .= dibujarCabeceraReporte('2MI-GFOM-F-07','1','2/22/2018');
		$mostrar .= dibujarDatosArtistaFormador();
		$mostrar .= "<p>Listado detallado de las asistencias de los estudiantes a las sesiones de clase dictadas ".(isset($_GET['suplencia'])? ' por SUPLENCIA' : '')." en el mes ".$_GET['mes_anio']." :</p>";
		$mostrar .= dibujarDatosDetalleAsistenciaEstudiantes();
		$mostrar .= dibujarPiePaginaReporte();
		$mostrar .= "</page>";
		return $mostrar;
	}

	function pintarHTMLCompleto(){
		$mostrar = pintarPaginaVertical();
		$mostrar .= pintarPaginaHorizontal();
		return $mostrar;
	}

	require_once dirname(__FILE__).'/../LibreriasExternas/html2pdf/vendor/autoload.php';

	use Spipu\Html2Pdf\Html2Pdf;
	use Spipu\Html2Pdf\Exception\Html2PdfException;
	use Spipu\Html2Pdf\Exception\ExceptionFormatter;
	try {
		guardarHTMLInDB($codigo_verificacion,pintarHTMLCompleto());
	    ob_start();
	    $content = pintarHTMLCompleto();
	    $html2pdf = new HTML2PDF('P','A4','fr', array(mL, mT, mR, mB));
	    $html2pdf->pdf->SetDisplayMode('fullpage');
	    $html2pdf->writeHTML($content);
	    ob_clean();
	    $html2pdf->Output('Reporte_Artista_Formador_Mensual_Asistencia_Grupo.pdf');
	} catch (Html2PdfException $e) {
	    $formatter = new ExceptionFormatter($e);
	    echo $formatter->getHtmlMessage();
	}
?>
