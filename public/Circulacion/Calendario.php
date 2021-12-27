<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:../index.php");
} else {
	$Id_Persona= $_SESSION["session_username"];
}

if(isset($_GET['mes'])){
	$fecha_calendario = array('anio' => $_GET['anio'],'mes' => $_GET['mes'],'dia' => '01');
}
else{
	$fecha_calendario = array('anio' => date('Y'),'mes' => date('m'),'dia' => '01');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Calendario Eventos Circulación</title>
	<link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>	
	
	<link href="../bower_components/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript" ></script>
	
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

    <link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

	<script src='../LibreriasExternas/pdfmake-0.1.36/build/pdfmake.js'></script>
	<script src='../LibreriasExternas/pdfmake-0.1.36/build/vfs_fonts.js'></script>

	<script type="text/javascript" src="Js/Calendario.js?v=2019.09.30"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel">
			<div class="row">
				<div class="col-xs-12 col-md-12 alert alert-warning">
					<p><b>Señor usuario: </b>Use los siguientes filtros para ver los eventos que existen en el SIF</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<label for="SL_crea">Filtro CREA:</label>
				</div>
				<div class="col-xs-12 col-md-9">
					<select class="form-control selectpicker" data-live-search="true" id="SL_crea" multiple="multiple" data-actions-box="true"></select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<label for="SL_area_artistica">Filtro Area Artistica:</label>
				</div>
				<div class="col-xs-12 col-md-9">
					<select class="form-control selectpicker" data-live-search="true" id="SL_area_artistica" multiple="multiple" data-actions-box="true"></select>
				</div>
			</div>
		</div>
		<div class="panel panel-success">
			<?php pintarCalendario($fecha_calendario);?>		
		</div>
		<script type="text/javascript">
			var mes = <?php echo $fecha_calendario["mes"]; ?>;
			var anio = <?php echo $fecha_calendario["anio"]; ?>;
			setTimeout(function() {
				cargarEventosMes(mes,anio);
			}, 500);
		</script>
		<div class='modal fade' role='dialog' id='modal-detalle-evento'>
			<div class='modal-dialog modal-lg'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal'>&times;</button>
						<h4 class='modal-title' id='fecha_detalle_evento'>Información detallada acerca del evento.</h4>
					</div>
					<div class='modal-body'>
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#tab_detalle_evento" id="nav_detalle_evento" role="tab">Detalle Evento</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_estudiantes_cupos" id="nav_estudiantes_cupos" role="tab">Estudiantes y cupos</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane" id="tab_detalle_evento" role="tabpanel">
								<div class="row">
									<div class="col-xs-12 col-md-12 table-responsive" id="div_detalle_evento">
										Detalles del evento
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_estudiantes_cupos" role="tabpanel">
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<div class="table-responsive text-center" id="div_table_estudiantes"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='modal-footer'>
						<a href="#" class="btn btn-info" id="BT_descargar_pdf">
							<span class="glyphicon glyphicon-cloud-download"></span> Ver PDF
						</a>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
/***************************************************************************
/* pintarCalendario() dibuja el calendario de un mes, identificando el día de inicio de la semana y el último día
***************************************************************************/
function pintarCalendario($fecha_calendario){
	$primer_dia_mes = (date("N",mktime(0,0,0,$fecha_calendario['mes'],1,$fecha_calendario['anio'])));

	$nombre_mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	/* comprobamos si el año es bisiesto y creamos array de días */
	if (($fecha_calendario['anio'] % 4 == 0) && (($fecha_calendario['anio'] % 100 != 0) || ($fecha_calendario['anio'] % 400 == 0))){
		$dias=array("","31","29","31","30","31","30","31","31","30","31","30","31");
	}
	else{ $dias=array("","31","28","31","30","31","30","31","31","30","31","30","31");
	}

	echo "<div class='panel-heading'><h3>Calendario de Eventos para " .$nombre_mes[intval($fecha_calendario['mes'])]." de ".$fecha_calendario['anio']."</h3></div>";
	echo "<div class='panel-body'>";
	echo "<table class='table-bordered' width='100%' cellspacing='0' cellpadding='0'>";
	echo "<tr><th>Lunes</th><th>Martes</th><th>Mi&eacute;rcoles</th><th>Jueves</th><th>Viernes</th><th>S&aacute;bado</th><th>Domingo</th></tr>";
	/* calculamos los días de la semana anterior al día 1 del mes en curso */
	$diasantes=$primer_dia_mes-1;
		
	/* los días totales de la tabla siempre serán máximo 42 (7 días x 6 filas máximo) */
	$diasdespues=42;
		
	/* calculamos las filas de la tabla */
	$tope=$dias[intval($fecha_calendario['mes'])]+$diasantes;
	if ($tope%7!=0){
		$totalfilas=intval(($tope/7)+1);
	}
	else{
		$diasdespues -=7;
		$totalfilas=intval(($tope/7));
	}
		
	/* empezamos a pintar la tabla */
	$dia = 1;
	echo "<tr>";
	for ($i=1; $i <= $diasdespues; $i++) {
		if($i >= $primer_dia_mes && $i <= $tope){
			echo "<td><div id='dia-".(($dia<10?'0':'').$dia)."' ";
				if(date('Y-m-d') > $fecha_calendario['anio'].'-'.$fecha_calendario['mes'].'-'.($dia<10?'0':'').$dia){
					echo "class='alert alert-warning'>".(($dia<10?'0':'').$dia)."</div>";
				}else if(date('Y-m-d') == $fecha_calendario['anio'].'-'.$fecha_calendario['mes'].'-'.($dia<10?'0':'').$dia){
					echo "class='alert alert-danger'>".(($dia<10?'0':'').$dia)."</div>";
				}else{
					echo "class='alert alert-info'>".(($dia<10?'0':'').$dia)."</div>";
				}
				echo "</td>";
			$dia++;
		}
		else{
			echo "<td><div></div></td>";
		}
		if ($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42){
			echo "</tr>";
		}
	}
	echo "</table><div>";
	$mesanterior=date("Y-m",mktime(0,0,0,$fecha_calendario['mes']-1,01,$fecha_calendario['anio']));
	$messiguiente=date("Y-m",mktime(0,0,0,$fecha_calendario['mes']+1,01,$fecha_calendario['anio']));
	echo "<div class='panel-footer'><center>";
		echo "<a href='#' class='cambia_mes' data-fecha='".$mesanterior."'>« Mes Anterior</a> - ";
		echo "<a href='#' class='cambia_mes' data-fecha='".$messiguiente."'>Mes Siguiente »</a>";
	echo "</center></div>";
}
?>