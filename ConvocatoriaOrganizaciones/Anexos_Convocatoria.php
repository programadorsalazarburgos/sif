<?php
include_once("modelo/Conexion.php");
session_start();
if(!empty($_SESSION['id_usuario']) AND !empty($_SESSION['nombre_usuario']) ){

}else{
	header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<title>Convocatoria Organizaciones</title>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="utf-8"/> 
	<link rel="shortcut icon" href="../public/imagenes/favicon.png">
	<link href="../public/css/Siclan.css" rel="stylesheet"/>
	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet"/>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  	<script src="bootbox.js"></script>
	<script src="../public/bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script src="../public/bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
  	<script src="ConsultarConvocatoria.js?v=1.1"></script>
  	<style type="text/css">
		body{
			overflow-x:hidden
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
		p{
			font-family: 'Prompt';
			font-size: 17px; 
		}
		label{text-align: right;}
		#container {
			height: 400px; 
			min-width: 310px; 
			max-width: 800px;
			margin: 0 auto;
		}
	</style>       
</head>
<body>
<div id="div_body">
    <center>
		<header>
            <img src="imagenes/Logo.jpg" width="960" height="156" alt="">
        	<br>
        </header> 
	</center>
	<div class="panel panel-success">
     <div class="col-md-12 panel-heading">
     	<div class="col-md-4 col-md-offset-4">
			<center>
			<?php 
				$respuesta = mysqli_query(ConexionDatos::conexion(),'SELECT VC_Nombre_Entidad FROM tb_propuesta_organizacion_precontractual WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
				mysqli_close(ConexionDatos::conexion());
				while($fila = mysqli_fetch_array($respuesta)){
					?>
					<strong><p style="font-size:25px">ORGANIZACIÓN <?php echo $fila["VC_Nombre_Entidad"]?></p></strong>
					<?php
				}
	       	?>
       		</center>
       	</div>
       	<div class="col-md-2">
       		<input id="cerrar_sesion" class="btn btn-sm btn-danger" value="Cerrar Sesión">
       	</div>
     </div>
        <div class="panel-body" style="background-color:rgb(240,243,245)"> 
      			<center>
      				<p>
      				<strong>Aquí podrá acceder a los anexos de la propuesta entregados por la Organización</strong>
					</p>
				</center>
				<center>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3"><p style="background-color: #8cc63e; text-align:center; font-size:20px;">LISTADO DE ANEXOS</p></div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3" style="background-color: #eaeaea; border-style: groove;"><br>
						<table id="tabla-anexos" class="table table-hover">
							<thead>
								<th>Origen</th>
								<th>Nombre Archivo</th>
								<th>Link</th>
							</thead>
							<tbody>
							<?php
							$respuesta = mysqli_query(ConexionDatos::conexion(),'SELECT * FROM tb_propuesta_proyecto_archivos WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
							mysqli_close(ConexionDatos::conexion());
							while($fila = mysqli_fetch_array($respuesta)){
							?>
							<tr>
							 <td><?php echo $fila["VC_Fuente"]?></td>
							 <td><?php echo $fila["VC_Nombre_Archivo"]?></td>
							 <td><a href='<?php echo $fila["VC_Ubicacion"]?>' class="btn btn-primary">Ver</a></td>
							</tr>
							<?php
							}
	       					?>
	       					</tbody>
						</table>
				</div>
				
			</div>
</html>