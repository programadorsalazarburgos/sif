<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:index.php");
	} else {
		include("../../Modelo/ConexionS.php");
	  	conectar_bd();
		$Id_Persona= $_SESSION["session_username"];
		$Datos= "SELECT * FROM tb_persona_2017 WHERE PK_Id_Persona='$Id_Persona'"; 
		$resultado = mysqli_query($conexio,$Datos);
		$Fila = mysqli_fetch_array($resultado);
		$PNombre=$Fila['VC_Primer_Nombre'];
		$SNombre=$Fila['VC_Segundo_Nombre'];
		$PApellido=$Fila['VC_Primer_Apellido'];
		$SApellido=$Fila['VC_Segundo_Apellido'];
		$NombreCompleto = $PNombre.' '.$SNombre.' '.$PApellido.' '.$SApellido;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="Js/Caracterizar_Grupo.js?v=2019.06.12.0"></script>   
    <link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
    <link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-slider/bootstrap-slider.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-select/bootstrap-select.css">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../Pedagogico/Js/bootstrap-slider/bootstrap-slider.js"></script>
	<script type="text/javascript" src="../bootstrap/bootstrap-select/bootstrap-select.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
    <link rel="stylesheet" type="text/css" href="../Pedagogico/Js/bootstrap-slider/css/bootstrap-slider.css">
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
</head>
<style type="text/css">
	div{
    font-family: 'Prompt';
    font-size: 14px;
    font-weight: normal; 
  }
  @media only screen and (max-width: 767px) {

   label {
      font-size: 10px;
   }
}
</style>
<body>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Caracterización de Grupos <small>Artista Formador</small></h1>
					<?php echo "<input type='hidden' id='id_usuario' value='".$Id_Persona."' >"; ?>
				</div>
			</div>
			<div class="panel-body">
				<div id="DIV_SELECCIONAR_GRUPO">
					<form id="FORM_Realizar_Caracterizacion">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_grupo">Seleccione el grupo:</label>
							</div>
							<div class="col-xs-6 col-md-9">
								<select id="SL_grupo" class="form-control selectpicker" required title="Seleccione un Grupo"></select>
							</div>
						</div>
						<div class="row" id="DIV_Observacion" hidden>
							<br>
							<div class="col-md-12">
								<label>Observación
								</label>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<h5 id="LB_Observacion">Observación
								</h5>
							</div>
							<br>
							<div class="col-md-12">
								<label>Estado
								</label>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<h5 id="LB_Estado">
								</h5>
							</div>
							<br>
						</div>
						<div class="row">
							<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
							<br>
								<button id="BTN_Realizar_Caracterizacion" class="btn btn-primary form-control" type="submit">Realizar Caracterización</button>
							</div>
						</div>
					</form>
				</div>
			<div class="panel-body panel-success">
			<div id="DIV_FORM_CARACTERIZACION" hidden>
				<form id="FORM_CARACTERIZACION">
					<div class="col-md-12">
						<div class="col-md-12" style="text-align: center; border-style: ridge; padding-top: 10px; background-color: rgb(210,210,210);">
							<p><b>FICHA DE CARACTERIZACIÓN – PROCESO DE FORMACIÓN ARTÍSTICA<b></p>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge;">
							<div class="col-md-8">
							<label>Formador: <?php echo $NombreCompleto;?></label>
							</div>
							<div class="col-md-4">
							<label id="LB_Area_Artistica"></label>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge;">
							<div class="col-md-8">
							<label id="LB_Colegio"></label>
							</div>
							<div class="col-md-4">
							<label id="LB_Clan"></label>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge;">
							<div class="col-md-8">
							<label id="LB_Fecha_Inicio"></label>
							</div>
							<div class="col-md-4">
							<label id="id_del_grupo"></label>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge;">
							<div class="col-md-8">
							<label id="LB_Lugar_Atencion"></label>
							</div>
							<div class="col-md-4">
							<select id="SL_CICLO" name="SL_CICLO" class="selectpicker form-control" required multiple="multiple" title="Seleccionar CICLO...">
									<option value="0" >NO APLICA</option>
									<option value="1" data-subtext=" (Grados 1,2)">CICLO I</option>
									<option value="2" data-subtext=" (Grados 3,4)">CICLO II</option>
									<option value="3" data-subtext=" (Grados 5,6,7)">CICLO III</option>
									<option value="4" data-subtext=" (Grados 8,9)">CICLO IV</option>
								</select>	
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge;">
							<div class="col-md-8">
								<label id="LB_Horario"></label>
							</div>
							<div class="col-md-4">
							<label id="LB_Promedio_Asistentes"></label>
							</div>
						</div>
						<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
							<p><label>1. DESCRIPCIÓN DEL GRUPO</label>
							<button id="EJ_1" type="button" class="btn btn-sm btn-danger" title="Ver Ejemplo"><span href="#" style="font-family: 'Prompt';">Ver Ejemplo</span></button></p>
							<p style="text-align: justify;">Diligenciar haciendo una breve reseña del grupo que contenga los siguientes datos: Edades de los participantes, Ciclo de formación al que pertenecen o si son multigrados, enuncie los grados, intereses y gustos específicos, expectativas frente al centro de interés y los talleres según el área artística, indagación del contexto, que incluya territorio, nivel socioeconómico, colegio, experiencias previas de formación, o si no han tenido ninguna experiencia previa. Así mismo hacer una descripción sobre la percepción del espacio en el que se brinda la formación.</p>
							<div class="col-md-12">
								<textarea id="TXTA_DESCRIPCION_GRUPO" name="TXTA_DESCRIPCION_GRUPO" class="form-control" rows="7" placeholder="Aquí la descripción general del grupo" required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
							<p><label>2. ASPECTOS DE CONVIVENCIA </label>
							</p>
							<p style="text-align: justify;">Identificar los aspectos de convivencia del grupo, dinámicas de relación, comunicación asertiva o no, seguimiento de instrucciones y acuerdos de aula. Esto se refiere al componente socio-afectivo que corresponde a las orientaciones de la Secretaría de Educación. (Dimensión afectiva, corporal y relacional, así es describir si es notoria o no la capacidad perceptiva, reflexiva, cooperativa, sentido de colectividad, integración...).</p>
							<div class="col-md-10">
								<label>Califique la Convivencia del Grupo en una escala de 1 a 5 (1 es Bajo y 5 es Alto)</label>
  									<input id="SLIDER_CONVIVENCIA" name="SLIDER_CONVIVENCIA" value="5" data-slider-min="1" data-slider-max="5" required>
  							</div>
							<div class="col-md-12">
							<br>
							<label>Describa la convivencia del Grupo </label> <button id="EJ_2" type="button" class="btn btn-sm btn-danger" title="Ver Ejemplo"><span href="#" style="font-family:'Prompt';">Ver Ejemplo</span></button>
								<textarea id="TXTA_CONVIVENCIA" name="TXTA_CONVIVENCIA" class="form-control" rows="3" placeholder="Aquí la descripción de convivencia del grupo." required></textarea>
								<br>
							</div>			
						</div>
						<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
							<p><label>3. IDENTIFICACIÓN DE INTERÉSES DEL GRUPO </label>
							</p>
							<p style="text-align: justify;">Tiene como objetivo dar cuenta de manera descriptiva los intereses de los niños, niñas y jóvenes, relacionándolos con el gesto de valoración: “Explorar, ir más allá, expandir posibilidades: se aprende a ser más exigente consigo mismo, a ser creativo, a intentar otras formas de trabajar y de pensar, de explorar y aprender de errores y accidentes.” (Idartes, 2016, 77).</p>
							<div class="col-md-1 col-md-offset-3">
								<label>Interesés:</label>
							</div>
							<div class="col-md-5">
								<select id="SL_Intereses" name="SL_Intereses" class="selectpicker form-control" multiple title="Seleccionar Interéses" data-header="Seleccionar Interéses" required>
								<optgroup label="Música">
  									  <option value="Folclor Urbano">Folclor Urbano</option>
  									  <option value="Salsa">Salsa</option>
  									  <option value="Andina-Llanera">Andina-Llanera</option>
  									  <option value="Rock">Rock</option>
  									  <option value="Percusión">Percusión</option>
  									  <option value="Banda de Vientos">Banda de Vientos</option>
  									  <option value="Ensamble Vocal-Instrumental">Ensamble Vocal-Instrumental</option>
  									  <option value="DJ">DJ</option>
  									  <option value="Música Latinoamericana">Música Latinoamericana</option>
  									  <option value="Ensamble Vocal">Ensamble Vocal</option>
  									  <option value="Chirimía">Chirimía</option>
  									  <option value="Folclor">Folclor</option>
  									  <option value="Música Tradicional Colombiana">Música Tradicional Colombiana</option>
  									</optgroup>
  									<optgroup label="Creación Literaria">
  									  <option value="Poesía">Poesía</option>
  									  <option value="libretos (teatrales- para audiovisuales)">libretos (teatrales- para audiovisuales)</option>
  									  <option value="Narrativa">Narrativa</option>
  									  <option value="Crónica">Crónica</option>
  									  <option value="Crítica">Crítica</option>
  									  <option value="Prensa Escrita">Prensa Escrita</option>
  									  <option value="Reportaje">Reportaje</option>
  									  <option value="hipertexto (textos con formato digital- perform">hipertexto (textos con formato digital- performancias)</option>
  									</optgroup>
  									<optgroup label="Danza">
  									  <option value="Folclore nacional">Folclore nacional</option>
  									  <option value="Folclore internacional">Folclore internacional</option>
  									  <option value="Tango">Tango</option>
  									  <option value="Salsa">Salsa</option>
  									  <option value="Ballet">Ballet</option>
  									  <option value="Danza contemporanéa">Danza contemporanéa</option>
  									  <option value="Danza tradicional">Danza tradicional</option>
  									  <option value="Danza teatro">Danza teatro</option>
  									  <option value="Teatro Músical">Teatro Músical</option>
  									  <option value="Danza urbana">Danza urbana</option>
  									  <option value="Danza popular">Danza popular</option>
  									  <option value="Ritmos latinos">Ritmos latinos</option>
  									  <option value="Capoeira">Capoeira</option>
  									  <option value="Danza Afro">Danza Afro</option>
  									  <option value="Flamenco">Flamenco</option>
  									  <option value="Danza Árabe">Danza Árabe</option>
  									</optgroup>
  									<optgroup label="Audiovisuales">
  									  <option value="Realización Audiovisual">Realización Audiovisual</option>
  									  <option value="Medios de Comunicación">Medios de Comunicación</option>
  									  <option value="Fotografía">Fotografía</option>
  									</optgroup>
  									<optgroup label="Arte Dramático">
  									  <option value="Teatro dramático y de sala">Teatro dramático y de sala.</option>
  									  <option value="Teatro gestual, corporal">Teatro gestual, corporal.</option>
  									  <option value="Clown.">Clown.</option>
  									  <option value="Teatro documental">Teatro documental.</option>
  									  <option value="Teatro de objetos y títeres">Teatro de objetos y títeres.</option>
  									  <option value="Teatro contemporáneo">Teatro contemporáneo.</option>
  									  <option value="Teatro de calle">Teatro de calle</option>
  									  <option value="Nuevas teatralidades" data-subtext="Performance, intervenciones espacios no convencionales">Nuevas teatralidades.</option>
  									  <option value="Interdisciplinar">Interdisciplinar</option>
  									</optgroup>
  									<optgroup label="Artes Plásticas">
  									  <option value="Ilustración">Ilustración.</option>
  									  <option value="Manga">Manga.</option>
  									  <option value="Origami">Origami.</option>
  									  <option value="Pop-up">Pop-up.</option>
  									  <option value="Graffiti">Graffiti.</option>
  									  <option value="Dibujo">Dibujo.</option>
  									  <option value="Pintura">Pintura</option>
  									  <option value="Gráfica (grabado en relieve, serigrafía, litografía, colografía, monotipo)">Gráfica (grabado en relieve, serigrafía, litografía, colografía, monotipo).</option>
  									  <option value="Pintura mural">Pintura mural</option>
  									  <option value="Modelado">Modelado</option>
  									  <option value="Talla en madera y otros">Talla en madera y otros.</option>
  									  <option value="Céramica">Céramica</option>
  									  <option value="Ensamblaje">Ensamblaje</option>
  									  <option value="Collage">Collage</option>
  									  <option value="Mosaico">Mosaico</option>
  									  <option value="Instalación">Instalación</option>
  									  <option value="Video Instalación">Video Instalación</option>
  									</optgroup>
								</select>
							</div>
							<div class="col-md-2 col-md-offset-2">
								<label>Otros(Opcional):</label>
							</div>
							<div class="col-md-5">
									<input id="TX_OTROS_INTERESES" name="TX_OTROS_INTERESES" class="form-control" type="text" placeholder="Ej: Canto lírico, Vitrales, etc..." maxlength="100">
							</div>
							<div class="col-md-12">
							<br>
								<p><label>3.1. INTERESES (MODALIDADES ÁREA ARTÍSTICA)</label> <button id="EJ_3" type="button" class="btn btn-sm btn-danger" title="Ver Ejemplo"><span href="#" style="font-family:'Prompt';">Ver Ejemplo</span></button></p>
								<textarea id="TXTA_INTERESES" name="TXTA_INTERESES" class="form-control" rows="4" placeholder="Aquí escriba sobre los intereses del Grupo..." required></textarea>
								<br>
							</div>							
						</div>
						<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
							<p><label>4. VALORACIÓN PARA LA FORMACIÓN ARTÍSTICA </label></p>
							<p style="text-align: justify;">Tiene como objeto identificar en los participantes, la dimensión de su ser, saber y saber hacer, esto se refiere a un reconocimiento descriptivo que hace el artista formador en los aspectos: </p><br>

							<div class="col-md-11" style="margin-left:5em; text-align: justify;">
							<strong>1.</strong> Actitudinales,  hacen parte de  la conducta y disposición que tienen los niños, niñas y jóvenes en la participación del centro de interés, también responde a las motivaciones y expectativas con las que llegan al taller. 
							<div class="col-md-11" style="margin-left: 5em;">
								<label>Califique la actitud del grupo en Escala de 1 a 5 (1 es Bajo y 5 es Alto)</label>
  									<input id="SLIDER_ACTITUDINALES" name="SLIDER_ACTITUDINALES" value="5" data-slider-min="1" data-slider-max="5" required>
  							</div>
							<div class="col-md-11">
							<br>
							<label>Describa el aspecto actitudinal del grupo</label> <button type="button" class="btn btn-sm btn-danger" id="EJ_4_1" title="Ver Ejemplo"><span href="#" style="font-family:'Prompt';">Ver Ejemplo</span></button>
								<textarea id="TXTA_ACTITUDINALES" name="TXTA_ACTITUDINALES" class="form-control" rows="3" placeholder="Aquí la descripción actitudinal del grupo..." required></textarea>
							</div>
										
  							</div>
  							<hr>
  							<div class="col-md-11" style="margin-left:5em; text-align: justify;">
							<strong>2.</strong> Cognitivos, hacen referencia a los conocimientos, conceptos y saberes que tienen los niños, niñas y jóvenes sobre las distintas áreas artísticas. 
							<div class="col-md-11" style="margin-left: 5em;">
								<label>Califique el aspecto Cognitivo en Escala de 1 a 5 (1 es Bajo y 5 es Alto)</label>
  									<input id="SLIDER_COGNITIVOS" name="SLIDER_COGNITIVOS" value="5" data-slider-min="1" data-slider-max="5" required>
  							</div>
							<div class="col-md-11">
							<br>
							<label>Describa el aspecto cognitivo del grupo</label> <button id="EJ_4_2" type="button" class="btn btn-sm btn-danger" title="Ver Ejemplo"><span href="#" style="font-family:'Prompt';">Ver Ejemplo</span></button>
								<textarea id="TXTA_COGNITIVOS" name="TXTA_COGNITIVOS" class="form-control" rows="3" placeholder="Aquí la descripción cognitiva del grupo..." required></textarea>
							</div>
										
  							</div>
  							<hr>
  							<div class="col-md-11" style="margin-left:5em; text-align: justify;">
							<strong>3.</strong> Procedimentales, reconoce el desempeño de habilidades, destrezas y aptitudes para el desarrollo del quehacer artístico y su práctica. 
							<div class="col-md-11" style="margin-left: 5em;">
								<label>Califique el aspecto procedimental en Escala de 1 a 5 (1 es Bajo y 5 es Alto)</label>
  									<input id="SLIDER_PROCEDIMENTALES" name="SLIDER_PROCEDIMENTALES" value="5" data-slider-min="1" data-slider-max="5" required>
  							</div>
							<div class="col-md-11">
							<br>
							<label>Describa el aspecto procedimental del grupo</label> <button id="EJ_4_3" type="button" class="btn btn-sm btn-danger" title="Ver Ejemplo"><span href="#" style="font-family:'Prompt';">Ver Ejemplo</span></button>
								<textarea id="TXTA_PROCEDIMENTALES" name="TXTA_PROCEDIMENTALES" placeholder="Aquí la descripción procedimental del grupo..." class="form-control" rows="3" required></textarea>
								<br>
							</div>
										
  							</div>
						</div>
						<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
							<p><label>5. PARTICULARIDADES DEL GRUPO </label>
							</p>
							<p style="text-align: justify;">Identificar casos que requieren atención especial o diferencial en aspectos artísticos, conductuales y de necesidades específicas de formación, de manera individual o grupal.</p>
							<div class="col-md-2"><label>Necesidades: </label></div>
							<div class="col-md-3">
								<select id="SL_Necesidades" name="SL_Necesidades" class="selectpicker form-control" title="Seleccionar Necesidades" multiple required>
									  <option value="0">Ninguna</option>
									  <option>Socio afectivas</option>
  									  <option>Fisico Creativas</option>
  									  <option>Cognitivas</option>
  								</select>
							</div>
							<div class="col-md-1"><label>Etnias: </label></div>
							<div class="col-md-3">
								<select id="SL_Etnias" name="SL_Etnias" class="selectpicker form-control" title="Seleccionar Etnias" multiple required>
									  <option value="0">Ninguna</option>
									  <option>Indígena</option>
  									  <option>Rural</option>
  									  <option>Afrocolombiano</option>
  									  <option>ROM (Gitanos)</option>
  									  <option>Inmigrantes</option>
  								</select>
							</div>
							<div class="col-md-12">
							<br>
							<label>Describa las particularidades del Grupo</label> <button id="EJ_5" type="button" class="btn btn-sm btn-danger" title="Ver Ejemplo"><span href="#" style="font-family:'Prompt';">Ver Ejemplo</span></button>
								<textarea id="TXTA_PARTICULARIDADES" name="TXTA_PARTICULARIDADES" class="form-control" rows="3" placeholder="Aquí la descripción de las particularidades del grupo..." required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
							<p><label>6. DESCRIPCIÓN DEL ESPACIO</label>
							<button id="EJ_6" type="button" class="btn btn-sm btn-danger" title="Ver Ejemplo"><span href="#" style="font-family:'Prompt';">Ver Ejemplo</span></button></p>
							<p style="text-align: justify;">Describir el lugar destinado para el trabajo del grupo.</p>
							<div class="col-md-12">
								<textarea id="TXTA_ESPACIO" name="TXTA_ESPACIO" class="form-control" rows="3" placeholder="Aquí la descripción del lugar de trabajo del grupo..." required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
							<p><label>7. OBSERVACIONES (OPCIONAL)</label></p>
							<p style="text-align: justify;">Aquí puede ingresar cualquier observación que considere pertinente en cuanto a la Caracterización del Grupo.</p>
							<div class="col-md-12">
								<textarea id="TXTA_OBSERVACIONES" name="TXTA_OBSERVACIONES" class="form-control" placeholder="Aquí las observaciones adicionales, este campo es opcional." rows="3"></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12">
						<br>
						<div class="col-md-6 col-md-offset-4">
							<input type="submit" id="GUARDAR_CARACTERIZACION" name="GUARDAR_CARACTERIZACION" class="eventoClic btn btn-success" value="GUARDAR CARACTERIZACIÓN">
						</div>	
						</div>
						
					</div>
					
				</form>
			</div>
			</div>
			</div>
		</div>
	</div>
</body>
<div class="modal fade" id="MODAL_EJEMPLO_UNO">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">DESCRIPCIÓN DEL GRUPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: justify;">
        <p>EJEMPLO:</p>
        <p>CICLO IV</p> 
			<p>• Ejes de Desarrollo: Vocación y Exploración Profesional.</p>
            <p>• Impronta del Ciclo: Proyecto de vida.</p>
		<p>Grado: 903</p>
		<p>El colegio se encuentra ubicado en la Localidad de San Cristóbal, la cual cuenta con estratos de 1 a 3; mantiene una amplia oferta de oferta cultural gracias al movimiento de organizaciones locales; tiene acceso a parques, bibliotecas barriales y locales y zonas de patrimonio cultural.
		La institución educativa lidera un festival de juegos tradicionales y otro de deportes, normalmente tiene una participación alta de la comunidad educativa (Docentes, administrativos, estudiantes y padres de familia).</p>
		<p>Desde una aproximación inicial a través del taller de Artes Plásticas, se han logrado identificar los siguientes intereses:</p>
		<p>* El uso de las redes sociales, el cual se puede aprovechar como posibles material reflexivo en relación a lo vivido.</p>
		<p>* La música es un factor importante a la hora de generar dinámicas de trabajo grupal en tanto se pone en juego gustos individuales y colectivos, como también niveles de comunicación entre ellos.</p>
		<p>* Generar otros espacios de socialización con sus amigos, alternos al institucional.</p>
		<p>Referente a las expectativas del taller manifiestan:</p>
		<p>- Aprender a dibujar</p>
		<p>- Pintar</p>
		<p>- Interés por la figura humana</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="MODAL_EJEMPLO_DOS">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ASPECTOS DE CONVIVENCIA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: justify;">
        <p>Ejemplo:</p>
		<p>El grupo atendido mantiene una dinámica de relación asertiva, sin embargo en ocasiones se presentan malos entendidos entre ellos debido a falta de comunicación, normalmente se solucionan al considerar la importancia del asunto y al escuchar las partes involucradas.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="MODAL_EJEMPLO_TRES">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">INTERESES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: justify;">
        <p>Ejemplo:</p>
		<p>El grupo hasta el momento está interesado en aproximarse a la exploración del dibujo y la creación de espacios; el nivel de exigencia en momentos afecta la confianza en su capacidad creativa, por lo que es necesario ampliar el valor de proceso y posibles vías de acción respecto a las necesidades que plantean. Se caracterizan por ir más allá de lo contemplado y conllevan a dar giros metodológicos según las inquietudes que emergen de momento.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="MODAL_EJEMPLO_CUATRO_UNO">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ASPECTO ACTITUDINAL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: justify;">
        <p>Ejemplo:</p>
		<p>Aunque varios de los participantes del grupo demuestran interés por el taller, algunos manifiestan el gusto por otras áreas artísticas y el deseo de estar en ellas, esto tiene que ver con la falta de participación a la hora de elegir un Centro de Interés.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="MODAL_EJEMPLO_CUATRO_DOS">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ASPECTO COGNITIVO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: justify;">
        <p>Ejemplo:</p>
		<p>Se identifica en el grupo una trayectoria inicial por el área, manejan algunos conceptos como: profundidad, perspectiva, colores complementarios, entre otros, esto ayuda a afianzar lo planeado en el taller.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="MODAL_EJEMPLO_CUATRO_TRES">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ASPECTO PROCEDIMENTAL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: justify;">
        <p>Ejemplo:</p>
		<p>Se reconoce en el grupo habilidades hacia el dibujo y el interés por otras técnicas. Su nivel creativo accede a la articulación de experiencias propias.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="MODAL_EJEMPLO_CINCO">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">PARTICULARIDADES DEL GRUPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: justify;">
        <p>Ejemplo:</p>
		<p>El grupo cuenta con un participante indígena, su comportamiento aunque es algo introspectivo alcanza procesos de reflexión íntimos desde las apuestas creativas.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="MODAL_EJEMPLO_SEIS">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">DESCRIPCION DEL ESPACIO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: justify;">
        <p>Ejemplo:</p>
		<p>El espacio en el que se da la formación cuenta con mesas para el desarrollo de las actividades, la luz es favorable, sin embargo en relación a la cantidad de participantes ameritaría pensar en otra ubicación. Tiene aislamiento acústico y ventilación adecuada.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</html>