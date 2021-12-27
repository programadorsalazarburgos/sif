<?php
include "../Modelo/ConexionS.php";

conectar_bd();
$Id_Persona = $_SESSION["session_username"];  
$Datos = "SELECT * FROM tb_usuario_actividad WHERE FK_Id_Persona='$Id_Persona'"; 
$resultado = mysql_query($Datos,$conexio);

while($row = mysql_fetch_array($resultado))
{
  $datos[] = $row[3]; 
}

?>
<div id="wrapper">
	<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="Inicio.php">IR A PÁGINA PRINCIPAL</a> 
            </div>
            <!-- /.navbar-header -->
		        <div align="right">
              <ul class="nav navbar-top-links navbar-right">
    			       <a href="FichaSoporte.php" target="ventana_iframe"><img src="imagenes/Soporte.gif" width="60%"/> </a>
	               <!-- /.dropdown -->
                 <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="ActualizarDatos_Usuarios.php" target="ventana_iframe"><i class="fa fa-user fa-fw"></i> Perfil de Usuario</a></li>
                        <li><a href="videotutoriales.html" target="ventana_iframe"><i class="fa fa-gear fa-fw"></i> Ayudas Audiovisuales</a></li>
            			      <li><a href="Cambiar_Contrasenia.php" target="ventana_iframe"><i class="fa fa-gear fa-fw"></i> Cambiar Contraseña</a></li>
						            <li class="divider"></li>
                        <li><a href="CerrarSesion.php"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a></li>
                    </ul>
                    <!-- /.dropdown-user -->             
			          </li>
                <!-- /.dropdown -->
			        </ul>
			      </div>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">        			
                      <?php if( $datos[0]==1 or $datos[1]==1 or $datos[2]==1 or $datos[3]==1 or $datos[4]==1 ){  ?>
                      <li><a href="index.html"><i class="fa fa-dashboard fa-fw"></i> <font color="#009933"><strong>Administraci&oacute;n Aplicativo</strong></font> <span class="fa arrow"></span></a>
					               <ul class="nav nav-second-level">
                            <?php if($datos[0]==1 ){ ?> <li><a href="Territorial/RegistroUsuarios.php" target="ventana_iframe">Registrar Usuario</a></li><?php } ?>
                            <?php if($datos[0]==1 ){ ?> <li><a href="Territorial/Consulta_Usuarios.php" target="ventana_iframe">Consultar Usuarios</a></li><?php } ?>
                            <?php if($datos[1]==1 ){ ?> <li><a href="Territorial/Acceso_Usuarios.php" target="ventana_iframe">Crear Acceso</a></li><?php } ?>
                            <?php if($datos[2]==1 ){ ?> <li><a href="Administracion/Actividades_Usuarios.php" target="ventana_iframe">Asignación Actividades</a></li> <?php } ?>
                            <?php if($datos[4]==1 ){ ?> <li><a href="Territorial/Consulta_Soportes_Pendientes.php" target="ventana_iframe">Solución de Soportes</a></li> <?php } ?>
                            <?php if($datos[4]==1 ){ ?> <li><a href="Territorial/Asignacion_Formadores_Grupos.php" target="ventana_iframe">Asignación de Artistas Formadores</a></li> <?php } ?>
                            <?php if($datos[4]==1 ){ ?> <li><a href="Territorial/Consulta_Estudiantes_Completa.php" target="ventana_iframe">Consulta Completa</a></li> <?php } ?>
                            <?php if($datos[4]==1 ){ ?> <li><a href="Territorial/Consulta_Total_Grupos.php" target="ventana_iframe">Total de Grupos</a></li> <?php } ?>
                            </ul>
	                    </li>   <?php } ?>
					 	
                      <?php if( $datos[5]==1 or $datos[6]==1 ){  ?>             
		                  <li><a href="#"><i class="fa fa-bar-chart-o fa-fw"></i><font color="#009933"><strong>Estudiantes</strong></font> <span class="fa arrow"></span></a>
                          <ul class="nav nav-second-level">
                            <?php if($datos[5]==1 ){ ?> <li><a href="Territorial/RegistroEstudiantes.php" target="ventana_iframe">Registro Estudiantes</a></li> <?php } ?>
                            <?php if($datos[6]==1 ){ ?> <li><a href="Territorial/Consulta_Individual_Estudiante.php" target="ventana_iframe">Consultar Estudiantes</a></li>	<?php } ?>						
                          </ul>
                      </li> <?php } ?>	         
			             						 
                      <?php if( $datos[7]==1 or $datos[8]==1 or $datos[9]==1 or $datos[10]==1 ){  ?> 					 
		                  <li><a href="#"><i class="fa fa-bar-chart-o fa-fw"></i><font color="#009933"><strong>Componente Territorial </strong></font> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                          <?php if($datos[7]==1 ){ ?> <li><a href="Territorial/Consulta_Cobertura_Total.php" target="ventana_iframe">Cobertura Total Clan</a></li> <?php } ?>
                          <?php if($datos[8]==1 ){ ?> 
                          <li><a href="Bienvenida.php" target="ventana_iframe">Consultas Especificas</a>
                            <ul class="nav nav-third-level">
                              <li><a href="Territorial/Consulta_Estadistica_AreaArtisitica.php" target="ventana_iframe">1. Gráfica Por Área Ártistica</a></li>
                              <li><a href="Territorial/Consulta_Estadistica_LineaAtencion.php" target="ventana_iframe">2. Gráfica Por Linea de Átención</a></li>
	                          <li><a href="Territorial/Consulta_Estadistica_Clan.php" target="ventana_iframe"> 3. Gráfica Por Clan</a> </li>
	                          <li><a href="Territorial/Consulta_Estadistica_Localidad.php" target="ventana_iframe">4. Gráfica Por Localidad</a></li>
	                          <li><a href="Territorial/Consulta_Estudiantes_Colegio.php" target="ventana_iframe">5. Gráfica Estudiantes Por Colegio</a></li>     
                            </ul>
                          <?php } ?>
                          </li>
                          <?php if($datos[9]==1 ){ ?> <li><a href="Territorial/Consultar_Colegios_Territoriales_Mensual.php" target="ventana_iframe"><font color="#FF0000">Consulta Asistencias por Colegios Jornada Extendida</font></a></li> <?php } ?>	   
                          <?php if($datos[10]==1 ){ ?> <li><a href="Territorial/Consultar_Grupos_Horarios.php" target="ventana_iframe">Consultar Grupos y Horarios</a></li> <?php } ?>	
                        </ul>
                      </li> <?php } ?>	

                      <?php if( $datos[11]==1 or $datos[12]==1 or $datos[13]==1 or $datos[14]==1 ){  ?> 	
                      <li><a href="tables.html"><i class="fa fa-table fa-fw"></i><font color="#009933"><strong>Componente Pedag&oacute;gico</strong></font><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                          <?php if($datos[11]==1 ){ ?> <li><a href="Bienvenida.php" target="ventana_iframe"><font color="#000000">Consultar Grupos</font></a></li> <?php } ?>
                          <?php if($datos[12]==1 ){ ?> <li><a href="Bienvenida.php" target="ventana_iframe"><font color="#000000">Plan Trabajo</font></a></li> <?php } ?>
                          <?php if($datos[13]==1 ){ ?> <li><a href="Bienvenida.php" target="ventana_iframe"><font color="#000000">Seguimiento Formadores Armonizadores</font></a></li> <?php } ?>
                          <?php if($datos[13]==1 ){ ?> <li><a href="Bienvenida.php" target="ventana_iframe"><font color="#000000">Evaluación</font></a></li> <?php } ?>
                          <?php if($datos[14]==1 ){ ?> <li><a href="Bienvenida.php" target="ventana_iframe"><font color="#000000">Base de Cónocimiento</font></a></li> <?php } ?>
                        </ul>
                      </li> <?php } ?>

                      <?php if( $datos[16]==1 or $datos[17]==1 or $datos[18]==1 or $datos[19]==1){  ?>
			                 <li><a href="tables.html"><i class="fa fa-table fa-fw"></i><font color="#009933"><strong>Información Clan</strong></font><span class="fa arrow"></span></a>
                          <ul class="nav nav-second-level">  
                            <?php if($datos[16]==1 ){ ?> <li><a href="Territorial/Consulta_Clan.php" target="ventana_iframe">Consultar Información Clan</a></li> <?php } ?>
                            <?php if($datos[17]==1 ){ ?> <li><a href="Territorial/Ficha_Grupo.php" target="ventana_iframe">Creación Grupos</a></li> <?php } ?>
                            <?php if($datos[18]==1 ){ ?> <li><a href="Territorial/Estudiantes_Grupo.php" target="ventana_iframe">Asignar Estudiantes Grupos</a></li> <?php } ?>
                            <?php if($datos[17]==1 ){ ?> <li><a href="Territorial/Consulta_Grupos_Clan.php" target="ventana_iframe">Consultar Estudiante en Grupo</a></li> <?php } ?>
                            <?php if($datos[19]==1 ){ ?> <li><a href="Territorial/Consultar_Formador_Clan.php" target="ventana_iframe">Consultar Formadores Clan</a></li> <?php } ?>
                            <?php if($datos[19]==1 ){ ?> <li><a href="Territorial/Grafica_Asistencia_por_Colegio_Clan.php" target="ventana_iframe"><strong>Consultar Asistencia por Colegio</strong></a></li> <?php } ?>
                          </ul>
                        </li> <?php } ?>

                      <?php if( $datos[22]==1 or $datos[23]==1 ){  ?>
			                <li><a href="tables.html"><i class="fa fa-table fa-fw"></i><font color="#009933"><strong>Artistas Formadores</strong></font><span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
                            <?php if($datos[22]==1 ){ ?> <li><a href="Territorial/Consultar_Grupos_Formador.php" target="ventana_iframe">Registrar Asistencia Estudiantes</a></li> <?php } ?>
                            <?php if($datos[23]==1 ){ ?> <li><a href="Territorial/Consultar_Asistencia_Formador.php" target="ventana_iframe">Consultar Asistencias Diarias</a></li> <?php } ?>
                            <?php if($datos[23]==1 ){ ?> <li><a href="Territorial/ReporteMensualArtista.php" target="ventana_iframe">Reporte Mensual por Grupo</a></li> <?php } ?> 
                         </ul>							 							
                      </li> <?php } ?>

                     <?php if( $datos[24]==1 or $datos[25]==1 or $datos[26]==1 or $datos[27]==1 or $datos[28]==1){  ?>
                      <li><a href="forms.html"><i class="fa fa-edit fa-fw"></i><font color="#009933"><strong> Componente Infraestructura </strong></font><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                          <?php if($datos[24]==1 ){ ?> <li><a href="Infraestructura/RegistrarInventario.php" target="ventana_iframe">Registro Inventarios</a></li><?php } ?>
                          <?php if($datos[25]==1 ){ ?> <li><a href="Infraestructura/ConsultarInventario.php" target="ventana_iframe">Consulta de Inventario</a></li><?php } ?>
                          <?php if($datos[26]==1 ){ ?> <li><a href="Bienvenida.php" target="ventana_iframe"> <font color="#000000">Ficha Clan </font></a></li> <?php } ?>
                          <?php if($datos[27]==1 ){ ?> <li><a href="Bienvenida.php" target="ventana_iframe"> <font color="#000000">Solicitud Translado</font></a></li><?php } ?> 
                          <?php if($datos[28]==1 ){ ?> <li><a href="Bienvenida.php" target="ventana_iframe"> <font color="#000000">Mantenimiento </font></a></li><?php } ?> 
                        </ul>
                      </li> <?php } ?>		  
							  
                      <?php if( $datos[31]==1 or $datos[32]==1 or $datos[33]==1){  ?>
                      <li><a href="#"><i class="fa fa-sitemap fa-fw"></i> <font color="#009933"><strong> Componente Circulación </strong> </font><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                          <?php if($datos[31]==1 ){ ?> <li><a href="Circulacion/Crear_Evento.php" target="ventana_iframe"><font color="#000000">Crear Evento</font></a></li><?php } ?> 
                          <?php if($datos[31]==1 ){ ?> <li><a href="Circulacion/Validar_Eventos.php" target="ventana_iframe"><font color="#000000">Validar Eventos</font></a></li><?php } ?>
                          <?php if($datos[31]==1 ){ ?> <li><a href="Circulacion/Consultar_Calendario_Eventos.php" target="ventana_iframe"><font color="#000000">Consultar Calendario</font></a></li><?php } ?>  
                          <?php if($datos[31]==1 ){ ?> <li><a href="Circulacion/Asistencia_Estudiante_Evento.php" target="ventana_iframe"><font color="#000000">Asistencia Estudiantes</font></a></li><?php } ?>
                        

                          <?php if($datos[32]==1 ){ ?> <li><a href="Circulacion/Asignar_Estudiante_Evento.php" target="ventana_iframe"><font color="#000000">Asignar Estudiantes a Evento</font></a></li><?php } ?>
                          <?php if($datos[33]==1 ){ ?> <li><a href="Circulacion/Confirmar_Permiso_Padres.php" target="ventana_iframe"><font color="#000000">Confirmar Permiso Padres</font></a></li><?php } ?>
                          
                        </ul> 
	                     </li>  <?php } ?>
	
	<!-- menu de organizaciones -->
	                     <?php if( $datos[29]==1 or $datos[30]==1 ){  ?>
                       <li><a href="#"><i class="fa fa-sitemap fa-fw"></i> <font color="#009933"><strong> Organizaciones </strong> </font><span class="fa arrow"></span></a>
                          <ul class="nav nav-second-level">
                            <?php if($datos[29]==1 ){ ?> <li><a href="Territorial/Consultar_Formadores_Organizacion.php" target="ventana_iframe">Artistas Formadores</a></li><?php } ?> 
                            <?php if($datos[29]==1 ){ ?> <li><a href="Territorial/Consultar_Reporte_Mensual_Organizacion.php" target="ventana_iframe">Reporte Mensual Organización</a></li><?php } ?>
                            <?php if($datos[30]==1 ){ ?> <li><a href="Territorial/Consultar_Informacion_Organizaciones.php" target="ventana_iframe">Supervisión Organización</a></li><?php } ?>
                          </ul> 
	                     </li>  <?php } ?>      
                </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
</div>