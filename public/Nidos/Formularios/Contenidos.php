<html> 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Nidos en Casa</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Formularios.js?v=2020.06.29.1"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link rel="stylesheet" href="../../LibreriasExternas/sweetalert2/sweetalert2.min.css">
	<script src="../../LibreriasExternas/sweetalert2/sweetalert2.min.js"></script>	

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style type="text/css">
		.p-t{
			padding-top: 15px;
		}
	</style>

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
		<input type="hidden" name="TX_Formulario" id="TX_Formulario" value="1">
		<form class="form" id="form_comunidad">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<fieldset>
						<legend><center><h1>¡Regístrate y envíanos tus creaciones!</h1></center></legend>
						<p>¡Hola! Uno de los propósitos del programa Nidos - Arte en primera infancia, del Instituto Distrital de las Artes - Idartes, es llevar contenidos artísticos a las mujeres gestantes, los niños y niñas de 0 a 5 años y sus familias.</p>
						<p>En cada uno de los contenidos que hemos creado encontrarás invitaciones para que realices tus propias creaciones. ¡Es mucho más divertido cuando participas y compartes! Anímate a mostrarnos cómo vives estas experiencias en casa: usa tu imaginación, la creatividad de los niños o niñas con los que estés y un teléfono celular con el que puedes tomar fotos, grabar audio, registrar video y muchas cosas más.</p>
						<p>Envíanos tu valioso aporte a <a href="contacto.nidos@idartes.gov.co">contacto.nidos@idartes.gov.co</a>, pero primero ayúdanos respondiendo las siguientes preguntas:</p>
					</fieldset>
				</div>	
			</div>
			<div id="Informacion_Basica">
				<div class="panel panel-primary col-md-8 col-md-offset-2" style="min-height: 500px;">
					<div class="panel-heading"><i class="fa fa-2x fa-user"></i> INFORMACIÓN GENERAL</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<span>¿Cuál contenido o evento disfrutaste? (por ejemplo: Retazos de memoria, Universo estelar, Apicius molecularis, Facebook live, etc.)</span>
									<textarea class="form-control"></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<span>Nombre completo del adulto cuidador que autoriza</span>
									<input type="text" required="required" class="form-control mayuscula" id="TX_Nombre_Cuidador" name="TX_Nombre_Cuidador">
								</div>
								<div class="col-lg-6">
									<span>Correo electrónico del adulto cuidador que autoriza</span>
									<input type="email" required="required" class="form-control" id="TX_Correo_Cuidador" name="TX_Correo_Cuidador">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<span>Tipo de documento del adulto cuidador que autoriza</span>
									<select class="form-control selectpicker" title="Seleccione una opción"></select>
								</div>
								<div class="col-lg-6">
									<span>Número de identificación del adulto cuidador que autoriza</span>
									<input type="text" required="required" class="form-control" id="TX_Correo_Cuidador" name="TX_Correo_Cuidador">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<span>¿Cuántos menores de edad participan de la actividad?</span>
									<select class="form-control selectpicker" title="Seleccione una opción"></select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<label>Nombre(s) completo(s) del (los) menor(es) de edad que participan de la actividad y número(s) de identificación (por favor escribir tipo y número de identificación al frente de cada nombre)</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-lg-4">
									<span>Nombre completo</span>
									<input type="text" required="required" class="form-control">
								</div>
								<div class="col-lg-4">
									<span>Tipo de documento</span>
									<select class="form-control selectpicker" title="Seleccione una opción"></select>
								</div>
								<div class="col-lg-4">
									<span>Número de identificación</span>
									<input type="text" required="required" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="Informacion_atencion">
				<div class="panel panel-primary col-md-8 col-md-offset-2">
					<div class="panel-heading"><i class="fa fa-2x fa-book"></i> AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES Y AVISO DE PRIVACIDAD DEL PROYECTO NIDOS ARTE EN PRIMERA INFANCIA</div>
					<div class="panel-body">
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
						<div class="row p-t">
							<div class="col-md-2 col-md-offset-4">
								<label class="radio-inline">
									<input type="radio" name="RB_Autorizacion" required="required" id="RB_Aceptado"><strong>Acepto las políticas</strong>
								</label>
							</div>
							<div class="col-md-2">
								<label class="radio-inline">
									<input type="radio" name="RB_Autorizacion" required="required" id="RB_No_Aceptado"><strong>No acepto las políticas</strong>
								</label>
							</div>
						</div>
						<div class="row p-t">
							<div class="col-md-4 col-md-offset-4">
								<button class="form-control btn btn-primary" id="BT_guardar" type="submit">Enviar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</body> 
</html>
