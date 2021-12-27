<?php
session_start();
if(!empty($_SESSION['id_usuario'])){
	
}else{
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<title>Propuesta Organizaciones</title>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="utf-8"/> 
	<link rel="shortcut icon" href="../public/imagenes/favicon.png">
	<link href="../public/css/Siclan.css" rel="stylesheet"/>
	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
	<link href="datepicker/css/datepicker.css" rel="stylesheet"/>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  	<script src="datepicker/js/bootstrap-datepicker.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>                    
	<script src="bootbox.js"></script>
  	<script src="principal.js?v=2018.07.18.0"></script>
  	<script type="text/javascript" src="bootstrap-filestyle.js"> </script>
	<style type="text/css">
		body{
			overflow-x:hidden
		}
		.video-container {
		    position: relative;
		    padding-bottom: 56.25%;
		    padding-top: 30px; height: 0; overflow: hidden;
		}
		.video-container iframe,
		.video-container object,
		.video-container embed {
		    position: absolute;
		    top: 0;
		    left: 0;
		    width: 100%;
		    height: 100%;
		}
		img {max-width:100%;}
		/* centered columns styles */
		.row-centered {text-align:center;}
		.col-centered {
		    display:inline-block;
		    float:none;
		    /* reset the text-align */
		    text-align:right;
		    /* inline-block space fix */
		    margin-right:-4px;
		}
		hr { 
		    display: block;
		    margin-top: 0.5em;
		    margin-bottom: 0.5em;
		    margin-left: auto;
		    margin-right: auto;
		    border-style: inset;
		    border-width: 2px;
		}
		th { font-size: 12px; }
		td { font-size: 11px; }
		p{
			font-family: 'Prompt';
			font-size: 14px; 
		}
		label{text-align: right;}
		textarea {
		        text-align: justify;
		        white-space: normal;
		         resize: none;
		}
		#container {
			height: 400px; 
			min-width: 310px; 
			max-width: 800px;
			margin: 0 auto;
		}
		.hidden{display: none!important;}
		@media screen and (min-width: 768px) {
		.modal-lg{width:100%;}
		.modal-sm{width:300px;}
		}
	</style>       
</head>
<body>

<div id="precarga" style="padding-top:100px">
	<center><img src="imagenes/cargando-formulario.gif"></center>
</div>
</center>
<div id="div_body" hidden>
    <center>
		<header>
            <img src="imagenes/Logo.jpg" width="960" height="156" alt="">
        	<br>
        </header> 
	</center>
	<div class="panel panel-success">
     <div class="panel-heading"> <center>
       <strong><p style="font-size:25px">PROPUESTA DEL USUARIO <?php echo $_SESSION['nombre_usuario'] ?></p></strong> </center></div>
         <div class="panel-body" style="background-color:rgb(240,243,245)"> 
         <form id="FORM_PROPUESTA" name="FORM_PROPUESTA" enctype="multipart/form-data">
				<p>El presente formato está diseñado para orientar la formulación del proyecto. En cada uno de los numerales encontrará las instrucciones que debe seguir para diligenciar la información.
					<br><strong>La información es confidencial y será usada con fines estadísticos.</strong>
				</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="background-color: #8cc63e; text-align:center; font-size:20px;">1. INFORMACIÓN GENERAL</p></div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="background-color: #eaeaea; padding:5px; border-style: groove;">
						<p>INFORMACIÓN DEL PROYECTO</p>
						<hr>
						<p>Fecha de radicación: <label id="fecha" name="fecha"></label></p>	
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Nombre Proyecto*: </label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
							<input id="nombre_proyecto" name="nombre_proyecto" type="text" class="form-control" placeholder="Mi proyecto" maxlength="100" required>
						</div>	
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Tipo Proyecto*: </label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<label>Apoyo Concertado</label><input type="radio" name="tipo_proyecto" value="Apoyo concertado" required>
  								<label>Convenio de Asociación</label><input type="radio" name="tipo_proyecto" value="Convenio de Asociación" required>
						</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: #eaeaea; padding:5px;">
				<p>INFORMACIÓN DE LA ENTIDAD SIN ÁNIMO DE LUCRO</p>
						<hr>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Nombre Entidad*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
							<input id="nombre_entidad" name="nombre_entidad" type="text" class="form-control" placeholder="Nombre de la entidad" maxlength="50" required>
						</div>	
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Número de NIT*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="nit" name="nit" type="text" class="form-control" placeholder="Numero nit" maxlength="50" value="<?php echo $_SESSION['nit']; ?>" readonly>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Dirección*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="direccion_entidad" name="direccion_entidad" type="text" class="form-control" maxlength="50" required>
						</div>	
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Localidad*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<select id="SL_LOCALIDAD_ENTIDAD" name="SL_LOCALIDAD_ENTIDAD" type="text" class="form-control" required>
  									<option value="">Seleccione Localidad..</option>
  									<option value="1">Usaquén</option>
  									<option value="2">Chapinero</option>
  									<option value="3">Santa Fe</option>
  									<option value="4">San Cristóbal</option>
  									<option value="5">Usme</option>
  									<option value="6">Tunjuelito</option>
  									<option value="7">Bosa</option>
  									<option value="8">Kennedy</option>
  									<option value="9">Fontibón</option>
  									<option value="10">Engativá</option>
  									<option value="11">Suba</option>
  									<option value="12">Barrios Unidos</option>
  									<option value="13">Teusaquillo</option>
  									<option value="14">Mártires</option>
  									<option value="15">Antonio Nariño</option>
  									<option value="16">Puente Aranda</option>
  									<option value="17">Candelaria</option>
  									<option value="18">Rafael Uribe</option>
  									<option value="19">Ciudad Bolivar</option>
  									<option value="20">Sumapaz</option>
  									<option value="21">Localidad - Colegio</option>
  								</select>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Objeto Social*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="objeto_social" name="objeto_social" type="text" class="form-control" maxlength="500" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Teléfono*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="telefono_entidad" name="telefono_entidad" type="text" class="form-control" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Correo*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="correo_entidad" name="correo_entidad" type="email" class="form-control" placeholder="correo@gmail.com" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Estrato Sede*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<select id="SL_ESTRATO_SEDE" name="SL_ESTRATO_SEDE" type="text" class="form-control" required>
  									<option value="">Seleccione Estrato..</option>
  									<option value="1">Estrato 1</option>
  									<option value="2">Estrato 2</option>
  									<option value="3">Estrato 3</option>
  									<option value="4">Estrato 4</option>
  									<option value="5">Estrato 5</option>
  									<option value="6">Estrato 6</option>
  								</select>
						</div>
				</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="background-color: #eaeaea; padding:5px; border-style: groove;">
							
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: #eaeaea; padding:5px;">
						<p>INFORMACIÓN DEL REPRESENTATE LEGAL</p>
						<hr>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Nombre*: </label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
							<input id="nombre_representante" name="nombre_representante" type="text" class="form-control" placeholder="Nombre del Representante" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Identificación*: </label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
							<input id="identificacion_representante" name="identificacion_representante" type="text" class="form-control" placeholder="Aquí la cédula" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Dirección*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="direccion_representante" name="direccion_representante" type="text" class="form-control" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Teléfono*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="telefono_representante" name="telefono_representante" type="text" class="form-control" placeholder="Teléfono" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Correo*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="correo_representante" name="correo_representante" type="email" class="form-control" placeholder="Correo Electrónico" maxlength="50" required>
						<br>
						</div>
						<p>INFORMACIÓN DEL DIRECTOR DEL PROYECTO</p>
						<hr>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Nombre*: </label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
							<input id="nombre_director" name="nombre_director" type="text" class="form-control" placeholder="Nombre del Director" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Identificación*: </label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
							<input id="identificacion_director" name="identificacion_director" type="text" class="form-control" placeholder="Aquí la cédula" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Dirección*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="direccion_director" name="direccion_director" type="text" class="form-control" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Teléfono*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="telefono_director" name="telefono_director" type="text" class="form-control" placeholder="Teléfono" maxlength="50" required>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<label>Correo*:</label>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">	
  								<input id="correo_director" name="correo_director" type="email" class="form-control" placeholder="Correo Electrónico" maxlength="50" required>
						</div>
				</div>			
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">2. DIMENSIÓN DEL PROYECTO: <strong>FORMACIÓN</strong></p>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">3. ANTECEDENTES DE LA ENTIDAD PROPONENTE</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p>En este espacio describa la trayectoria de la organización, contemplando:</p>
					<p><span class="glyphicon glyphicon-record"></span>	El historial que permita establecer la relación misional de la entidad proponente con el proyecto propuesto.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Describa las principales actividades que realiza la entidad.</p>
				</div>
				<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
					<textarea id="textarea_antecedentes_entidad" name="textarea_antecedentes_entidad" class="form-control" rows="31" maxlength="5000" required></textarea>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br><br>
					<p><span class="glyphicon glyphicon-record"></span> Enumere las entidades o instituciones con las que en la actualidad sostiene o ha tenido vínculos para el desarrollo de sus principales actividades y proyectos así:</p>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-sm-offset-9">
					<button id="crear_fila" class="btn btn-success" type="button" style="color: white;">Agregar</button>
					<button id="eliminar_fila" class="btn btn-danger" type="button" style="color: white;">Eliminar</button>	
				</div>
				<table class="table" id="contenedor" style="background-color:#0b4373; color:#ffffff; text-align:center;">
						<input type="text" id="id_celda_sumatoria_historial" hidden>
						<tr>
							<td>
								<label style="font-size:14px;">Entidad con la que se desarrollo el proyecto</label>
							</td>
							<td>
								<label style="font-size:14px;">Nombre del Proyecto <br>(Si aplica)</label>
							</td>
							<td>
								<label style="font-size:14px;">Fecha<br>Inicio</label>
							</td>
							<td>
								<label style="font-size:14px;">Fecha<br>Terminación</label>
							</td>
							<td>
								<label style="font-size:14px;">Actividad desarrollada</label>
							</td>
							<td>
								<label style="font-size:14px;">Población<br>beneficiada</label>
							</td>
						</tr>
						<tr id="tr1">
							<td style='padding:3px'>
								<input type="text" id="entidad_1" name="entidad_1" class="form-control" maxlength="50" required>
							</td>
							<td style='padding:3px'>
								<input type="text" id="proyecto_1" name="proyecto_1" maxlength="100" class="form-control">
							</td>
							<td style='padding:3px; color:#000;' class="col-md-1">
								<input type="text" id="antecedente_inicio_1" name="antecedente_inicio_1" class="form-control datetime_class" required readonly>
							</td>
							<td style='padding:3px; color:#000;' class="col-md-1">
								<input type="text" id="antecedente_fin_1" name="antecedente_fin_1" class="form-control datetime_class" required readonly>
   							</td>
							<td style='padding:3px'>
								<input type="text" id="actividad_1" name="actividad_1" class="form-control" maxlength="500" required>
							</td>
							<td style='padding:3px' class="col-md-1">
								<input type="text" id="sumatoria_1" name="sumatoria_1" class="form-control beneficiarios" maxlength="200" onclick="abrirmodal(this.id)" value="0" readonly required>
								<input type="text" id="beneficiarios_1" name="beneficiarios_1" class="form-control hidden">
							</td>

						</tr>
				</table>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">4. DESCRIPCIÓN DE LA SITUACIÓN O PROBLEMA A RESOLVER</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p>En este espacio explique el problema o necesidad del campo artístico, cultural, patrimonial o deportivo que justifique el desarrollo del proyecto. Especifique:</p>
					<p><span class="glyphicon glyphicon-record"></span>	Origen o causas.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Estado actual.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Los efectos si no se emprende alguna acción.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Indique cómo el proyecto ayuda o interviene en el cumplimiento de las metas del Plan de Desarrollo Distrital y/o Local vigente.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Indique cómo el proyecto ayuda o interviene en el cumplimiento de las Políticas Culturales Distritales y/o Planes de Cultura Distritales vigentes.</p>
					<p>Tome aquellas variables, condiciones o elementos probables que influyen en el campo artístico, cultural, patrimonial o deportivo, y que el proyecto podría modificar favorablemente.</p>
				</div>
				<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
					<textarea id="textarea_problema" name="textarea_problema" class="form-control" rows="31" maxlength="5000" required></textarea>
					<br>
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">5. OBJETIVOS DEL PROYECTO</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p><strong>4.1. Objetivo general</strong></p>
					<p>En este espacio, plantee el propósito central que le da sentido al proyecto, indicando el estado ideal que se desea lograr mediante su ejecución. Alcanzarlo se traducirá en un aporte a la solución del problema o necesidad enunciada en el numeral <i><strong>3. Descripción de la situación o problema a resolver.</strong></i></p>
				</div>
				<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
					<textarea id="textarea_objetivo_general" name="textarea_objetivo_general" class="form-control" rows="3" required maxlength="1000"></textarea>
					<br>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p><strong>4.2. Objetivos Especificos</strong></p>
					<p>En este espacio, especifique los propósitos concretos que permiten determinar los alcances del proyecto, y que significarán la obtención del objetivo general, planteados en términos medibles, razonables y obtenibles en términos de tiempo y recursos.</p>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-sm-offset-8">
					<button id="crear_fila_objetivo" class="btn btn-success" type="button" style="color: white;">Agregar</button>
					<button id="eliminar_fila_objetivo" class="btn btn-danger" type="button" style="color: white;">Eliminar</button>	
				</div>
				<table class="table" id="contenedor_objetivos" style="background-color:#0b4373; color:#ffffff; text-align:center;">
						<tr>
							<td>
								<label style="font-size:14px;">Objetivo Específico</label>
							</td>
							<td>
								<label style="font-size:14px;">Actividades para cumplirlo</label>
							</td>
						</tr>
						<tr id="tr_objetivo1">
							<td style='padding:3px'>
								<input type="text" id="objetivo_1" name="objetivo_1" class="form-control" placeholder="Mi objetivo numero 1" maxlength="200" required>
							</td>
							<td style='padding:3px'>
								<input type="text" id="actividad_obj_1" name="actividad_obj_1" class="form-control" placeholder="Ejemplo: ferias, ciclos de cine, talleres..." maxlength="1000" required>
							</td>
						</tr>
				</table>	
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">6. DESCRIPCION DEL PROYECTO</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p><strong>Tomando en cuenta los antecedentes, en este espacio exponga el proyecto a realizar en contexto con la situación identificada dentro del campo artístico, cultural, patrimonial y/o deportivo. Defina y describa claramente la secuencia de actividades, agrupándolas en etapas que coincidan con avances significativos en el logro de los objetivos específicos. En conjunto, las fases deben interrelacionarse y precisar procedimientos para alcanzar el objetivo que se quiere lograr en forma propositiva y dinámica, guardando coherencia con el tiempo de duración y los costos requeridos. La descripción del proyecto también debe plantear:</strong></p>
					<p><span class="glyphicon glyphicon-record"></span>	Metodología para la ejecución del proyecto.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Plan de convocatoria.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Actividades a adelantar para el cumplimiento de los objetivos. Ejemplo: ferias, ciclos de  cine, talleres.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Productos a obtener dentro de los márgenes de libertad y creatividad inherentes a la naturaleza del proyecto.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Estrategia de divulgación.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Estrategia de socialización de resultados.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Metodología de seguimiento y evaluación.</p>
				</div>
				<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
					<textarea id="textarea_descripcion_proyecto" name="textarea_descripcion_proyecto" class="form-control" rows="31" maxlength="40000" required></textarea>
					<br>
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">7. POBLACIÓN OBJETIVO</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p><strong>Indique el número total de beneficiarios que se pretende atender con la ejecución del proyecto:</strong></p>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-5 col-sm-offset-5 col-md-offset-5 col-lg-offset-5">
					<input id="definir_poblacion_objetivo" name="definir_poblacion_objetivo" type="button" class="btn btn-lg btn-success" value="Definir Población Objetivo">
					<input id="poblacion_objetivo" name="poblacion_objetivo" type="text" class="btn btn-lg btn-success" value=0 readonly>
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<br>
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">8. METAS DEL PROYECTO</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p>Las metas son los resultados concretos, medibles, realizables y verificables que se esperan obtener con la ejecución del proyecto, presentadas como bienes y/o servicios a ofrecer.</p>
					<p><strong>Proceso:</strong> Verbo en infinitivo que indica la acción. Ejemplo: capacitar.</p>
					<p><strong>Magnitud:</strong> Cantidad o número de la acción identificada: ejemplo 50.</p>
					<p><strong>Unidad de medida:</strong> Cantidad estandarizada de una magnitud. Ejemplo: niños, artistas, talleres, eventos.</p>
					<p><strong>Descripción:</strong> Decir en que consiste el proceso.</p>
					<p><strong>Periodo:</strong> Tiempo en el que se espera cumplir la meta, en relación con el proyecto.</p>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-sm-offset-8">
					<button id="ver_ejemplo_metas" class="btn btn-primary btn-md" type="button" style="color: white;">Ver Ejemplo</button>
					<button id="crear_fila_meta" class="btn btn-success" type="button" style="color: white;">Agregar</button>
					<button id="eliminar_fila_meta" class="btn btn-danger" type="button" style="color: white;">Eliminar</button>	
				</div>
				<table class="table" id="contenedor_metas" style="background-color:#0b4373; color:#ffffff; text-align:center;">
						<tr>
							<td>
								<label style="font-size:14px;">Proceso</label>
							</td>
							<td>
								<label style="font-size:14px;">Magnitud</label>
							</td>
							<td>
								<label style="font-size:14px;">Unidad de Medida</label>
							</td>
							<td>
								<label style="font-size:14px;">Descripción</label>
							</td>
							<td>
								<label style="font-size:14px;">Periodo</label>
							</td>
						</tr>
						<tr id="tr_meta1">
							<td style='padding:3px'>
								<input type="text" id="proceso_1" name="proceso_1" class="form-control" maxlength="50" required>
							</td>
							<td style='padding:3px' class="col-md-1">
								<input type="number" id="magnitud_1" name="magnitud_1" class="form-control" maxlength="10" min="0" required>
							</td>
							<td style='padding:3px'>
								<input type="text" id="unidad_1" name="unidad_1" class="form-control" maxlength="50" required>
							</td>
							<td style='padding:3px'>
								<input type="text" id="descripcion_1" name="descripcion_1" class="form-control" maxlength="100" required>
							</td>
							<td style='padding:3px'>
								<input type="text" id="periodo_1" name="periodo_1" class="form-control" placeholder='Ej: A diciembre de 2015' maxlength="50" required>
							</td>
						</tr>
				</table>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">9. INDICADORES DE EVALUACIÓN DEL PROYECTO</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p>A partir de la definición de los objetivos y las metas del proyecto construir los indicadores, que ayudan a medir los cambios presentados en ella después de un periodo o tiempo determinado. Debe existir al menos un indicador asociado a cada una de las metas planteados.</p>
					<p><strong>Conforme a la particularidad del proyecto, se podrán construir indicadores de:</strong></p>
					<p><strong>Calidad:</strong> Referentes a la contribución del proyecto al desarrollo de los campos artístico, cultural, patrimonial y deportivo.</p>
					<p><strong>Pertinencia:</strong> Para valorar la articulación y contribución del proyecto a las políticas culturales.</p>
					<p><strong>Resultados:</strong> Grado de cumplimiento de las metas y objetivos conforme a la formulación de los mismos.</p>
					<p><strong>Cobertura:</strong> Para medir el alcance de los beneficios directos e indirectos del proyecto.</p>
					<p><strong>Eficiencia:</strong> Para evaluar el manejo de los recursos, el cumplimiento de los cronogramas y los procesos de gestión e interacción al interior del proyecto.</p>
					<br>
					<p><strong>En la construcción de indicadores se debe tener en cuenta:</strong></p>
					<p><strong>Nombre del indicador:</strong> Expresión verbal con la cual se personifica el indicador. A partir del nombre del indicador se puede identificar la unidad en la que está formulado. Un indicador puede estar dado en cifras absolutas, en porcentajes, en tasas, en medias estadísticas (promedio, moda, mediana)</p>
					<p><strong>Fórmula del indicador:</strong> Relación matemática que permite calcular en forma de porcentaje, tasa o valores absolutos el cambio en la(s) variable(s) del indicador. Las variables son las características, cualidades, elementos o componentes de una unidad de análisis que pueden modificarse o variar en el tiempo. La construcción del indicador debe estar en relación con los objetivos y metas del proyecto.</p>
					<p><strong>Estado inicial:</strong> Especifica estado inicial o valor actual del indicador.</p>
					<p><strong>Valor esperado:</strong> Expresión cuantitativa o cualitativa de lo que se pretende lograr o alcanzar.</p>
					<p><strong>Periodo:</strong> Tiempo dentro del cual se espera alcanzar el valor esperado del indicador</p>
					
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-sm-offset-8">
					<button id="ver_ejemplo_indicador" class="btn btn-primary btn-md" type="button" style="color: white;">Ver Ejemplo</button>
					<button id="crear_fila_indicador" class="btn btn-success btn-md" type="button" style="color: white;">Agregar</button>
					<button id="eliminar_fila_indicador" class="btn btn-danger btn-md" type="button" style="color: white;">Eliminar</button>	
				</div>
				<table class="table" id="contenedor_indicadores" style="background-color:#0b4373; color:#ffffff; text-align:center;">
						<tr>
							<td>
								<label style="font-size:14px;">Nombre del indicador</label>
							</td>
							<td>
								<label style="font-size:14px;">Fórmula</label>
							</td>
							<td>
								<label style="font-size:14px;">Estado inicial</label>
							</td>
							<td>
								<label style="font-size:14px;">Valor esperado</label>
							</td>
							<td>
								<label style="font-size:14px;">Periodo</label>
							</td>
						</tr>
						<tr id="tr_indicador1">
							<td style='padding:3px'>
								<input type="text" id="nombreindicador_1" name="nombreindicador_1" class="form-control" maxlength="100" required>
							</td>
							<td style='padding:3px'>
								<input type="text" id="formula_1" name="formula_1" class="form-control" maxlength="100" required>
							</td>
							<td style='padding:3px'>
								<input type="text" id="estadoinicial_1" name="estadoinicial_1" class="form-control" maxlength="10" required>
							</td>
							<td style='padding:3px'>
								<input type="text" id="valoresperado_1" name="valoresperado_1" class="form-control" maxlength="10" required>
							</td>
							<td style='padding:3px'>
								<input type="text" id="periodoindicador_1" name="periodoindicador_1" class="form-control" placeholder='Ej: A mayo de 2015 (3 meses)' maxlength="50" required>
							</td>
						</tr>
				</table>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">10. EQUIPO DE TRABAJO DEL PROYECTO</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p>En el siguiente cuadro relacione las personas que conforman el equipo de trabajo, describir brevemente el perfil profesional y experiencia laboral, así como el rol y funciones que tendrá para el desarrollo del proyecto.</p>
					<br>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-sm-offset-8">
					<input id="ver_ejemplo_equipo" type="button" class="btn btn-md btn-primary" value="Ver Ejemplo">
					<button id="crear_fila_persona" class="btn btn-success btn-md" type="button" style="color: white;">Agregar</button>
					<button id="eliminar_fila_persona" class="btn btn-danger btn-md" type="button" style="color: white;">Eliminar</button>	
				</div>
				<table class="table" id="contenedor_equipo" style="background-color:#0b4373; color:#ffffff; text-align:center;">
						<tr>
							<td>
								<label style="font-size:14px;">Nombre de la Persona</label>
							</td>
							<td>
								<label style="font-size:14px;">Perfil profesional y experiencia laboral<br>relacionada con el rol o funciones en el marco del proyecto</label>
							</td>
							<td>
								<label style="font-size:14px;">Rol</label>
							</td>
							<td>
								<label style="font-size:14px;">Actividades a desempeñar en la ejecución del proyecto</label>
							</td>
						</tr>
						<tr id="tr_persona1">
							<td style='padding:3px'>
								<input type="text" id="nombrepersona_1" name="nombrepersona_1" class="form-control" maxlength="50" required>
							</td>
							<td style='padding:3px'>
								<textarea id="perfilpersona_1" name="perfilpersona_1" class="form-control" rows="4" required maxlength="1000"></textarea>
							</td>
							<td style='padding:3px'>
								<input type="text" id="rolpersona_1" name="rolpersona_1" class="form-control" maxlength="50" required>
							</td>
							<td style='padding:3px'>
								<textarea id="actividadespersona_1" name="actividadespersona_1" class="form-control" rows="4" maxlength="1000" required maxlength="5000"></textarea>
							</td>
						</tr>
				</table>
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">11. CRONOGRAMA DEL PROYECTO</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p>En un archivo en <strong>EXCEL</strong> el cual debe adjuntar como <strong>ANEXO</strong>, indique la totalidad de actividades contempladas para desarrollar los objetivos del proyecto. Una vez estén relacionadas, marque con una X el tiempo en el cual se llevará a cabo dicha actividad.
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xs-offset-5 col-sm-offset-5 col-md-offset-5 col-lg-offset-5">
							<a id="ver_ejemplo_cronograma" href="ANEXO 5. CRONOGRAMA DE LAPROPUESTA PRESENTADA.ods" class="btn btn-md btn-primary" download>Descargar Plantilla Cronograma</a>
						</div>
						<!--<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
							<input name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" runat="server" required>
						</div>-->						
						<br><br><br>
					</p>
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">12. PRESUPUESTO DEL PROYECTO</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p>En un archivo en <strong>EXCEL</strong> el cual debe adjuntar como <strong>ANEXO</strong>, indique la totalidad de actividades contempladas para desarrollar los objetivos del proyecto. Totalice el costo de cada actividad e indique la forma con se va a financiar cada una, especificando el monto asumido por cada una de las fuentes de financiación presentadas.
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xs-offset-5 col-sm-offset-5 col-md-offset-5 col-lg-offset-5">
							<a id="ver_ejemplo_presupuesto" href="ANEXO 3. FORMATO PARA LA PRESENTACION DEL PRESUPUESTO - MATERIALES.xlsx" class="btn btn-md btn-primary" download>Plantilla Presupuesto - Materiales</a>
						</div>
						<!--<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
							<input name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" runat="server" required>
						</div>-->
						<br><br>
					</p>
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="background-color: #8cc63e; text-align:center; font-size:20px;">ANEXOS</p>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p><strong>Agregué los archivos anexos descritos a continuación:</strong>
					<p><span class="glyphicon glyphicon-record"></span> Cronograma en <strong>EXCEL</strong>, Especificado en el numeral 11.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Presupuesto y Materiales en <strong>EXCEL</strong>, Especificado en el numeral 12.</p>
					<p><span class="glyphicon glyphicon-record"></span>	Documentos (Certificaciones de costos) de la determinación de Presupuesto y Materiales</p>
					<p style="font-size:18px"><strong>Organicé TODOS los ANEXOS en una misma carpeta antes de adjuntar, y haciendo uso del MOUSE o de la tecla CTRL seleccionelos todos.</strong>
					<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" id="contenedor_anexos">
						<!--<button id="agregar_input_archivo" class="btn btn-success" type="button" style="color: white;">Agregar mas Archivos</button>
						<button id="eliminar_input_archivo" class="btn btn-danger" type="button" style="color: white;">Eliminar Último</button>	-->
						<div id="div_archivo1"><input id="archivo_1" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" multiple required></div>
						<!--<div id="div_archivo2"><input id="archivo_2" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" required></div>
						<div id="div_archivo3"><input id="archivo_3" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" required></div>
						<div id="div_archivo4"><input id="archivo_4" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" required></div>
						<div id="div_archivo5"><input id="archivo_5" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" required></div>
						<div id="div_archivo6"><input id="archivo_6" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" required></div>
						<div id="div_archivo7"><input id="archivo_7" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" required></div>-->
					</div>
					
						<br><br>
					</p>
					<div class="alert alert-danger">
  						<strong>Estos son todos los archivos que se van a enviar:</strong>
  						<div id="archivos_adjuntos">
  							
  						</div>
					</div>
				</div>
				</div>
				<hr>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-5 col-sm-offset-5 col-md-offset-5 col-lg-offset-5">
					<input type="submit" value="Enviar Propuesta" class="btn btn-lg btn-primary" style="color:#ffffff">
				</div>
				</div>
				</form>
			</div>  
      </div>
</div>     
<div class="modal fade" id="modal_beneficiarios_historial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Poblacion Beneficiada con el Proyecto</h4>
      </div>
      <div class="modal-body">

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       	<p style="text-align:center"><strong>Beneficiarios segun sexo:</strong></p>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Mujeres:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Mujeres" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Hombres:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Hombres" type="number" class="form-control" min="0" value="0"></div>
      </div>

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       	<p style="text-align:center"><strong>Beneficiarios según grupo poblacional por ciclo vital:</strong></p>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Primera infancia (0 – 5 años):</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_P_Infancia" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Infancia (6 – 11 años):</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Infancia" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Adolescencia (12 – 13 años):</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Adolescencia" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Juventud (14 – 26 años):</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Juventud" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Adulto (27 – 59 años):</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Adulto" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Adulto Mayor (60 años y más):</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Adulto_Mayor" type="number" class="form-control" min="0" value="0"></div>
      </div>

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       	<p style="text-align:center"><strong>Beneficiarios según sector social:</strong></p>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Campesinos:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Campesinos" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Artesanos:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Artesanos" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Personas con discapacidad:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Discapacidad" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">LGBTI:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_LGBTI" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Reinsertados - reincorporados:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Reinsertados" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Víctimas:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Victimas" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Personas en condición de desplazamiento:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Dezplazamiento" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Habitantes de calle:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Habitantes_Calle" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Medios comunitarios:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Medios_Comunitarios" type="number" class="form-control" min="0" value="0"></div>
      </div>
        
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       	<p style="text-align:center"><strong>Beneficiarios según la pertenencia étnica:</strong></p>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Pueblo Raizal:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Pueblo_Raizal" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Afrodescendientes, negritudes y palenque:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Afrodescendientes" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Pueblo Rrom - gitano:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Pueblo_Gitano" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Pueblos indígenas:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Indigenas" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Otras etnias:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Otras_Etnias" type="number" class="form-control" min="0" value="0"></div>
      </div>

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       	<p style="text-align:center"><strong>Beneficiarios según estrato:</strong></p>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 1:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Uno" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 2:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Dos" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 3:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Tres" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 4:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Cuatro" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 5:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Cinco" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 6:</p></div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Seis" type="number" class="form-control" min="0" value="0"></div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="capturar_beneficiarios">Guardar Beneficiarios</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_beneficiarios_proyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Poblacion Beneficiada con el Proyecto</h4>
      </div>
      <div class="modal-body">

      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
       	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align:center"><strong>Beneficiarios segun sexo:</strong></p></div>
       	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Mujeres:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Mujeres" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Hombres:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Hombres" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align:center"><strong>Beneficiarios según sector social:</strong></p></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Campesinos:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Campesinos" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Artesanos:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Artesanos" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Personas con discapacidad:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Discapacidad" type="number" class="form-control" min="0" value="0"></div>
      	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">LGBTI:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_LGBTI" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Reinsertados - reincorporados:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Reinsertados" type="number" class="form-control" min="0" value="0"></div> 
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Víctimas:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Victimas" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Personas en condición de desplazamiento:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Dezplazamiento" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Habitantes de calle:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Habitantes_Calle" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Medios comunitarios:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Medios_Comunitarios" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align:center"><strong>Beneficiarios según la pertenencia étnica:</strong></p></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Pueblo Raizal:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Pueblo_Raizal" type="number" class="form-control" min="0" value="0"></div>
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Afrodescendientes, negritudes y palenque:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Afrodescendientes" type="number" class="form-control" min="0" value="0"></div>
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Pueblo Rrom - gitano:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Pueblo_Gitano" type="number" class="form-control" min="0" value="0"></div>
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Pueblos indígenas:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Indigenas" type="number" class="form-control" min="0" value="0"></div>
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Otras etnias:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Otras_Etnias" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align:center"><strong>Beneficiarios según estrato:</strong></p></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Estrato 1:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Estrato_Uno" type="number" class="form-control" min="0" value="0"></div>
 		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Estrato 2:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Estrato_Dos" type="number" class="form-control" min="0" value="0"></div>    
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Estrato 3:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Estrato_Tres" type="number" class="form-control" min="0" value="0"></div>     
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Estrato 4:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Estrato_Cuatro" type="number" class="form-control" min="0" value="0"></div>      
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Estrato 5:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Estrato_Cinco" type="number" class="form-control" min="0" value="0"></div>
      	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Estrato 6:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Estrato_Seis" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align:center"><strong>Beneficiarios según Alcance Territorial:</strong></p></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Local (Impacto en 1 Localidad):</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Local" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Inter-Local (Más de 1 y máximo 3 localidades):</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_InterLocal" type="number" class="form-control" min="0" value="0"></div>      
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Metropolitano (4 o más localidades o en escenarios de carácter metropolitano):</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Metropolitano" type="number" class="form-control" min="0" value="0"></div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align:center"><strong>Beneficiarios según grupo poblacional por ciclo vital:</strong></p></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Primera infancia (0 – 5 años):</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_P_Infancia" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Infancia (6 – 11 años):</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Infancia" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Adolescencia (12 – 13 años):</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Adolescencia" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Juventud (14 – 26 años):</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Juventud" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Adulto (27 – 59 años):</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Adulto" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Adulto Mayor (60 años y más):</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Adulto_Mayor" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align:center"><strong>Beneficiarios según Localidad:</strong></p></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Usaquén:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Usaquen" type="number" class="form-control" min="0" value="0"></div>     
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Chapinero:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Chapinero" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Santa Fe:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Santafe" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">San Cristobal:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_SanCristobal" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Usme:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Usme" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Tunjuelito:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Tunjuelito" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Bosa:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Bosa" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Kennedy:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Kenndy" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Fontibón:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Fontibon" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Engativá:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Engativa" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Suba:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Suba" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Barrios Unidos:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_BarriosUnidos" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Teusaquillo:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Teusaquillo" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Mártires:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Martires" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Antonio Nariño:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_AntonioNariño" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Puente Aranda:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_PuenteAranda" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Candelaria:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Candelaria" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Rafael Uribe:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_RafaelUribe" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Ciudad Bolivar:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_CiudadBolivar" type="number" class="form-control" min="0" value="0"></div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><p style="text-align:right">Sumapaz:</p></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><input id="B_Localidad_Sumapaz" type="number" class="form-control" min="0" value="0"><br><br></div>
      
      </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="capturar_beneficiarios_proyecto">Guardar Beneficiarios</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_ejemplo_equipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Ejemplo Tabla Equipo de Trabajo</h4>
      </div>
      <div class="modal-body">
		<img src="imagenes/ejemplo_equipo.PNG" width="1000" height="400">      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_ejemplo_indicadores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Ejemplo Tabla de Indicadores</h4>
      </div>
      <div class="modal-body">
		<img src="imagenes/ejemplo_indicadores.PNG" width="600" height="120">      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_ejemplo_metas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Ejemplo Tabla de Metas</h4>
      </div>
      <div class="modal-body">
		<img src="imagenes/ejemplo_metas.PNG" width="600" height="120">      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_ejemplo_cronograma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Ejemplo Cronograma - Excel</h4>
      </div>
      <div class="modal-body">
		<img src="imagenes/ejemplo_cronograma.PNG" width="600" height="120">      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_ejemplo_presupuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Ejemplo Presupuesto - Excel</h4>
      </div>
      <div class="modal-body">
		<img src="imagenes/ejemplo_presupuesto.PNG" width="600" height="150">      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body">
		<img src="imagenes/enviando.gif" width="600" height="250">      
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>

</html>