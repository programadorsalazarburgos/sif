<html> 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Nidos en Casa</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Formularios.js?v=2021.06.24.1"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link rel="stylesheet" href="../../LibreriasExternas/sweetalert2/sweetalert2.min.css">
	<script src="../../LibreriasExternas/sweetalert2/sweetalert2.min.js"></script>	

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body style="background-color: #ffefdb">
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<img src="logo.jpg" style="width: 100%">
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2" id="div_info_formulario_cerrado">
			</div>
		</div>
		<input type="hidden" id="TX_Formulario" value="1">
		<form class="form" id="form_comunidad">
			<div class="form-group">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<fieldset>
							<legend><center><h1>En-cuentados y en-cantados con Nidos en Casa.</h1></center></legend>
							<p>¡Hola! El programa Nidos - Arte para la primera infancia, del Instituto Distrital de las Artes - Idartes, se transformó para seguir llevando contenidos artísticos enriquecedores a las mujeres gestantes, los niños y niñas desde los 0 hasta los 6 años y sus familias durante este tiempo de autocuidado en el hogar. Así nació Nidos en Casa, una estrategia digital que ofrece diversos recursos en diferentes formatos y que puedes encontrar en este enlace: <a href="https://www.nidos.gov.co/divirtiendonos" target="_blank">www.nidos.gov.co/divirtiendonos</a>.</p>
							<p>Bajo esta gran estrategia, para continuar con el juego y experimentando el mundo de fantasía de la primera infancia creamos En-cuentados y en-cantados, una apuesta narrativa en la que te contamos y cantamos -a ti y a los niños y niñas de la casa- poemas, historias y canciones vía telefónica.</p>
							<p>¡Llena este formulario y espera nuestra llamada!</p>
						</fieldset>
					</div>	
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<p>¿Te has inscrito en una ocasión anterior para recibir nuestra llamada?</p>
						<label class="radio-inline">
							<input type="radio" name="RB_Atendido" id="RB_Atendido_Si"><strong>Si</strong>
						</label>
						<label class="radio-inline">
							<input type="radio" name="RB_Atendido" id="RB_Atendido_No"><strong>No</strong>
						</label>
					</div>
				</div>
			</div>
			<div id="div-busqueda" style="display: none;">
				<div class="panel panel-primary col-md-8 col-md-offset-2">
					<div class="panel-heading"><i class="fa fa-2x fa-search"></i> BÚSQUEDA DE BENEFICIARIO</div>
					<div class="panel-body">
						<label>Ingrese el número de documento del niño/niña o cuidador:</label>
						<div class="form-inline">
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" type="number" id="TX_Busqueda">
								</div>
							</div>
							<button type="button" class="btn btn-primary" id="BTN_Buscar">Buscar</button>
						</div>
						<div class="col-md-10">
						</div>
						<div class="col-md-2">
						</div>
					</div>
				</div>
			</div>
			<div id="Informacion_Basica" style="display: none;">
				<div class="panel panel-primary col-md-8 col-md-offset-2" style="min-height: 500px;">
					<div class="panel-heading"><i class="fa fa-2x fa-user"></i> INFORMACIÓN DEL CUIDADOR</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Nombre completo</label>	
									<input type="text" required class="form-control mayuscula" id="TX_Nombre_Cuidador" required>
								</div>
								<div class="col-md-6">
									<label>Correo electrónico</label>
									<input type="email" required class="form-control" id="TX_Correo_Cuidador" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Tipo de documento</label>
									<select class="form-control selectpicker" title="Seleccione una opción" data-live-search="true" id="SL_Tipo_Doc_Cuidador" required></select>
								</div>												
								<div class="col-md-6">
									<label>Número de documento</label>
									<input type="number" required class="form-control" id="TX_Identificacion_Cuidador" required>
								</div>	
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Localidad</label>
									<select class="form-control selectpicker" title="Seleccione la localidad" data-live-search="true" id="SL_Localidad_Cuidador" required>
										<option value="1">1. USAQUÉN</option>
										<option value="2">2. CHAPINERO</option>
										<option value="3">3. SANTA FE</option>
										<option value="4">4. SAN CRISTOBAL</option>
										<option value="5">5. USME</option>
										<option value="6">6. TUNJUELITO</option>
										<option value="7">7. BOSA</option>
										<option value="8">8. KENNEDY</option>
										<option value="9">9. FONTIBÓN</option>
										<option value="10">10. ENGATIVÁ</option>
										<option value="11">11. SUBA</option>
										<option value="12">12. BARRIOS UNIDOS</option>
										<option value="13">13. TEUSAQUILLO</option>
										<option value="14">14. MÁRTIRES</option>
										<option value="15">15. ANTONIO NARIÑO</option>
										<option value="16">16. PUENTE ARANDA</option>
										<option value="17">17. CANDELARIA</option>
										<option value="18">18. RAFAEL URIBE</option>
										<option value="19">19. CIUDAD BOLIVAR</option>
										<option value="20">20. SUMAPAZ</option>
										<option value="21">21. OTRA CIUDAD O PAIS</option>
									</select>	
								</div>	
								<div class="col-md-2">
									<label>Otro ¿Cuál?</label>	
									<input type="text" class="form-control mayuscula" id="TX_Otro" required disabled>
								</div>
								<div class="col-md-6">
									<label>Barrio</label>	
									<input type="text" required class="form-control mayuscula" id="TX_Barrio_Cuidador" required>										
								</div>	
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Dirección</label>	
									<input type="text" required class="form-control mayuscula" id="TX_Direccion_Cuidador" required>
								</div>									
								<div class="col-md-6">
									<label>Estrato</label>
									<select class="form-control selectpicker" title="Seleccione el estrato" id="SL_Estrato_Cuidador" required>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
									</select>										
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Edad</label>	
									<input type="number" min="1" class="form-control mayuscula" id="TX_Edad_Cuidador" required>
								</div>									
								<div class="col-md-6">
									<label>¿A quien va dirigida la lectura?</label>
									<select class="form-control selectpicker" title="Seleccione a quien va dirigida" id="SL_Dirigida" required>
										<option value="1">Mujer Gestante</option>
										<option value="2">Niño</option>
										<option value="3">Niña</option>
									</select>										
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="Informacion_ninos" style="display: none;">
				<div class="panel panel-primary col-md-8 col-md-offset-2">
					<div class="panel-heading"><i class="fa fa-2x fa-child"></i> INFORMACIÓN DEL NIÑO/NIÑA A QUIEN VA DIRIGIDA LA ATENCIÓN</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Parentesco</label>
									<select class="form-control selectpicker" title="Seleccione parentesco" id="SL_Parentesco">
										<option value="1">Madre o padre</option>
										<option value="2">Tía o tío</option>
										<option value="3">Abuela o abuelo</option>
										<option value="4">Hermano o hermana</option>
										<option value="5">Acudiente</option>
										<option value="6">Otro</option>
									</select>										
								</div>																								
								<div class="col-md-6">
									<label>¿Posee la patria potestad?</label>
									<select class="form-control selectpicker" title="Seleccione si tiene la potestad" id="SL_Potestad">
										<option value="1">Si</option>
										<option value="0">No</option>
									</select>								
								</div>									
							</div>
						</div>
						<div id="Informacion_potestaNo" style="display: none;">		
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Nombres</label>	
										<input type="text" class="form-control mayuscula" id="TX_Nombres_Beneficiario" name="TX_Nombres_Beneficiario">
									</div>
									<div class="col-md-6">
										<label>Apellidos</label>	
										<input type="text" class="form-control mayuscula" id="TX_Apellidos_Beneficiario" name="TX_Apellidos_Beneficiario">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6" style="display: none;" id="div-check-si">
										<label>Fecha de nacimiento</label><input type="date" class="form-control" id="TX_Fec_Nac_Beneneficiario" name="TX_Fec_Nac_Beneneficiario">
									</div>
									<div class="col-md-6" style="display: none;" id="div-check-no">
										<label>Edad</label>
										<select class="form-control selectpicker" title="Seleccione una opción" data-live-search="true" id="SL_Edad_Beneficiario" name="SL_Edad_Beneficiario">
											<option value="1">De 1 mes a 1 año</option>
											<option value="2">2 años</option>
											<option value="3">3 años</option>
											<option value="4">4 años</option>
											<option value="5">5 años</option>
										</select>
									</div>
									<div class="col-md-6">
										<label>Se reconoce al niño/niña dentro de alguna de las siguientes poblaciones</label>	
										<select class="form-control selectpicker" title="Seleccione una opción" id="SL_Enf_Beneficiario" name="TX_Fec_Nac_Beneneficiario"></select>
									</div>
								</div>
							</div>
						</div>
						<div id="Informacion_potestaSi" style="display: none;">
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Tipo de documento</label>
										<select class="form-control selectpicker" title="Seleccione una opción" data-live-search="true" id="SL_Tipo_Doc_Beneficiario" name="SL_Edad_Beneficiario"></select>
									</div>
									<div class="col-md-6">
										<label>Número de documento</label>	
										<input type="number" class="form-control" id="TX_Identificacion_Beneficiario" name="TX_Identificacion_Beneficiario">
									</div>
								</div>
							</div>
						</div>		
					</div>
				</div>
			</div>
			<div id="Informacion_atencion" style="display: none;">
				<div class="panel panel-primary col-md-8 col-md-offset-2">
					<div class="panel-heading"><i class="fa fa-2x fa-phone"></i> INFORMACIÓN DE LA  ATENCIÓN</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<input type="hidden" id="TX_Institucion" value="">
									<input type="hidden" id="SL_Entidad" value="">
									<label>Número telefónico al cual llamaremos</label>
									<input type="number" required class="form-control" id="TX_Celular">
								</div>	
								<div class="col-md-6">
									<label>¿Qué te gustaría escuchar?</label>	
									<select class="form-control selectpicker" required title="Seleccione tipo de lectura" id="SL_Tipo_Atencion">
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Elige la fecha y el horario de la llamada</label>
									<select class="form-control selectpicker" required title="Seleccione una opción" id="SL_Horario_Atencion"></select>
								</div>
								<div class="col-md-6">
									<label>¿Quieres contarnos algo más?</label>	
									<input type="text" class="form-control mayuscula" id="TX_Comentario">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-primary col-md-8 col-md-offset-2">
					<div class="panel-heading"><i class="fa fa-2x fa-book"></i> AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES Y AVISO DE PRIVACIDAD DEL PROYECTO NIDOS ARTE EN PRIMERA INFANCIA</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<p>La presente autorización para el tratamiento de datos personales establece los términos y condiciones en virtud de los cuales el INSTITUTO DISTRITAL DE LAS ARTES (en adelante IDARTES), que actuará como responsable del tratamiento, identificado con el NIT No. 900.413.030-9 y con domicilio en la Carrera 8 No. 15 – 46, de la ciudad de Bogotá, realizará el tratamiento de sus datos personales y en tal virtud podrá, recolectar, almacenar y usar, para desarrollar el programa “NIDOS - Arte en Primera Infancia” en ejercicio del objetivo y deberes encargados al IDARTES en virtud del acuerdo 440 del 24 de junio de 2010, del Consejo de Bogotá y en desarrollo de los derechos constitucionales de los niños y niñas, establecidos en el artículo 44 de la Constitución nacional.</p>
									<p><strong>1. Tratamiento y Finalidad:</strong></p>
									<p>El tratamiento al que serán sujetos los datos personales suministrados, obedece a las finalidades de:</p>
									<ol type="A">
										<li>Efectuar gestiones pertinentes para el desarrollo del objeto social del IDARTES, a través del programa “NIDOS - Arte en Primera Infancia”, gestiones que consisten en contactar al titular vía telefónica, para leer cuentos y recitar poesías con el objetivo de aportar al desarrollo y a la formación integral del ser, en niños y niñas menores de 5 años, junto con sus familiares y/o adultos cuidadores, maestros, artistas y demás agentes que se encuentren en contacto con esta población.</li>
										<li>Almacenar los datos que sean necesarios, para cumplir con deberes legales a los cuales este sujeto el IDARTES, en desarrollo de los objetivos y deberes asignados por el acuerdo 440 del Consejo Superior de Bogotá y las demás normas que correspondan al cumplimiento de su misión.</li>
										<li>Gestionar trámites relacionados a peticiones, quejas o reclamos de los titulares de los datos, o de sus representantes legales.</li>
										<li>Contactar al titular o su representante legal para el envió de información referente al cambio de la finalidad o en la política de protección de datos personales de la entidad.</li> 
										<li>Contactar al titular de los datos o a su representante legal para informar, de nuevas iniciativas en cabeza de la entidad, cuyo objeto guarde relación con el proyecto NIDOS arte en primera instancia</li>
										<li>Prestar los demás servicios ofrecidos por el programa “Nidos - Arte en Primera Infancia” los cuales fueron informados al titular y su representante legal en su totalidad.</li>
										<li>El IDARTES también podrá intercambiar información personal con autoridades gubernamentales o públicas de otro tipo (incluidas, entre otras autoridades judiciales o administrativas, autoridades fiscales y organismos de investigación penal, civil, administrativa, disciplinaria y fiscal) y terceros participantes de las actividades, para las que fueron recolectados, para cumplir con leyes vigentes; procesos jurídicos; para responder a las solicitudes de autoridades públicas.</li>
									</ol>
									<p><strong>2. Derechos del titular:</strong></p>
									<p>Sus derechos como titular del dato son los previstos en la Constitución y en la Ley 1581 de 2012 en su artículo 8, especialmente los siguientes:</p>
									<ol type="A">
										<li>Acceder en forma gratuita a los datos proporcionados que hayan sido objeto de tratamiento.</li>
										<li>Solicitar la actualización y rectificación de su información frente a datos parciales, inexactos, incompletos, fraccionados, que induzcan a error, o a aquellos cuyo tratamiento esté prohibido o no haya sido autorizado.</li>
										<li>Solicitar prueba de la autorización otorgada.</li>
										<li>Presentar ante la Superintendencia de Industria y Comercio (SIC) quejas por infracciones a lo dispuesto en la normatividad vigente.</li>
										<li>Revocar la autorización y/o solicitar la supresión del dato, a menos que exista un deber legal o contractual que haga imperativo conservar la información.</li>
										<li>Abstenerse de responder las preguntas sobre datos sensibles sobre datos de las niñas y niños y adolescentes. Estos derechos los podré ejercer a través de los canales o medios dispuestos por el IDARTES, para la atención al público: Domicilio de la entidad ubicado en Carrera 8 No. 15 – 46, disponible de lunes a viernes en la franja horaria de 7:00 am a 4;30 pm; el PBX (+571) 379 5750 o al correo electrónico <a href="mailto:#">contactenos@idartes.gov.co</a>, cuya información puedo consultar en <a href="www.idartes.gov.co" target="_blank">www.idartes.gov.co</a>.</li>
									</ol>
									<p><strong>3. Tratamiento de datos personales de niños, niñas y adolescentes:</strong></p>
									<p>El instituto Distrital de las Artes garantizará en todo momento el respeto prevalente a los derechos de los niños, niñas y adolescentes en el tratamiento de datos personales que realice. </p>
									<p>Está prohibido el Tratamiento de los datos personales de los niños, niñas y adolescentes, salvo que se trate de datos de naturaleza pública y cuando su tratamiento, respete el interés superior de los menores y asegure el respeto de sus derechos fundamentales. En esos casos, la autorización se obtendrá de su representante legal o tutor, previo ejercicio del derecho del menor a ser escuchado. Su opinión en todo caso, será valorada a partir de la madurez, autonomía y capacidad para entender el asunto.</p>
									<p>Por lo anterior he otorgado mi consentimiento, de manera inequívoca al INSTITUTO DISTRITAL DE LAS ARTES, para que trate mi información personal y la del menor de edad, en mi calidad de representante legal, de acuerdo con la Política de Tratamiento de Datos Personales dispuesta por la entidad en medio electrónico en <a href="https://idartes.gov.co/sites/default/files/inline-files/Manual%20de%20Politica%20de%20seguridad%20de%20la%20informaci%c3%b3n%20Web%20-2017.pdf" target="_blank">Manual de política y seguridad de la información web</a> y que dio a conocer antes de recolectar mis datos personales y los del menor de edad que representó legalmente de acuerdo a lo establecido por el artículo 62 del Código Civil colombiano.</p>
									<p>Manifiesto que la presente autorización me fue solicitada y puesta de presente antes de entregar mis datos y que la suscribo de forma libre y voluntaria una vez leída en su totalidad.</strong></p>					
								</div>	
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2 col-md-offset-4">
									<label class="radio-inline">
										<input type="radio" name="RB_Autorizacion" required id="RB_Aceptado"><strong>Acepto las políticas</strong>
									</label>
								</div>
								<div class="col-md-2">
									<label class="radio-inline">
										<input type="radio" name="RB_Autorizacion" required id="RB_No_Aceptado"><strong>No acepto las políticas</strong>
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							
							<div class="row">
								<div class="col-md-4 col-md-offset-4">
									<button class="form-control btn btn-primary" id="BT_guardar" type="submit">Enviar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</body> 
</html>