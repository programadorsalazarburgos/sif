    <h3>Escoga la actividad con la cual presenta inconvenientes</h3>
    <ul class="nav" id="side-menu2">  

    <?php foreach ($this->getVariables()['menuActividades'] as $ma): ?>
	    <li>
			<a href='#' title='Módulo: <?= $ma['VC_Nom_Modulo'] ?>'>
				<span class='glyphicon glyphicon-<?= $ma['VC_Icono'] ?>' aria-hidden='true'></span> 
				<font color='#009933'><?= $ma['VC_Nom_Modulo'] ?></font>
				<span class='fa arrow'></span>
			</a>	    
			<ul class='nav nav-second-level'>
			<?php foreach ($ma['actividades'] as $a): ?>
				<li>
				<a href='#'  title='<?= $a['VC_Nom_Actividad'] ?>' id='<?= $a['PK_Id_Actividad'] ?>'><?= $a['VC_Nom_Actividad'] ?></a>
				</li>
			<?php endforeach; ?> 	
			</ul>	
	    </li>
    <?php endforeach; ?> 
    </ul>

    <script type="text/javascript">
		$(function() { 
			//$('#side-menu2').css("background","#f5f5f5"); 
			$('#side-menu2').metisMenu(); 
			$("#side-menu2").delegate("a","click",function(){
				var actividadInicio=$(this).prop("id");
				var nombreActividadInicio=$(this).prop("title");				
				if(actividadInicio!==''){ 
					$('#FK_Actividad_Apertura').val(actividadInicio);
					$('#TFK_Actividad_Apertura').html(nombreActividadInicio+' 									<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>');
					$("#modal_actividades").modal('hide');
				    $(".actividadInicio").show();
				}
				//alert("actividad: "+$(this).prop("id"));

			});

		});
	</script>
	<style>
		#side-menu2{
			background: "#f5f5f5";
		}
		ul#side-menu2 > li:first-child{
			border-top: 1px solid #e7e7e7;
		}
		ul#side-menu2 > li {
			border-bottom: 1px solid #e7e7e7;
		}
	</style>

    